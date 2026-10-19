<?php

namespace App\Services;

use App\Enums\Day;
use App\Models\Host;
use App\Models\ScheduleSlot;
use App\Models\Show;
use App\Models\Station;
use App\Support\Clock;
use Carbon\CarbonInterface;
use DomainException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ScheduleService
{
    /** The slot this time range would collide with on that station and day, if any. */
    public function clash(int $stationId, Day $day, int $start, int $end, ?int $ignoreId = null): ?ScheduleSlot
    {
        // Two ranges overlap when each one starts before the other ends. Touching (10:00 - 10:00) is fine.
        return ScheduleSlot::with('show')
            ->where('station_id', $stationId)
            ->where('day_of_week', $day->value)
            ->where('starts_at', '<', $end)
            ->where('ends_at', '>', $start)
            ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
            ->orderBy('starts_at')
            ->first();
    }

    /**
     * Put a show on the air on several days at the same time. All days are saved, or none.
     *
     * @param  list<Day>  $days
     * @return Collection<int, ScheduleSlot>
     *
     * @throws DomainException when a day would overlap an existing slot
     */
    public function schedule(Station $station, Show $show, array $days, int $start, int $end): Collection
    {
        $this->assertValidRange($start, $end);

        return DB::transaction(function () use ($station, $show, $days, $start, $end) {
            return collect($days)->map(function (Day $day) use ($station, $show, $start, $end) {
                $this->assertFree($station->id, $day, $start, $end);

                return $station->slots()->create(['show_id' => $show->id, 'day_of_week' => $day, 'starts_at' => $start, 'ends_at' => $end]);
            });
        });
    }

    /** @throws DomainException */
    public function move(ScheduleSlot $slot, Station $station, Show $show, Day $day, int $start, int $end): ScheduleSlot
    {
        $this->assertValidRange($start, $end);
        $this->assertFree($station->id, $day, $start, $end, $slot->id);
        $slot->update(['station_id' => $station->id, 'show_id' => $show->id, 'day_of_week' => $day, 'starts_at' => $start, 'ends_at' => $end]);

        return $slot;
    }

    public function onAir(Station $station, CarbonInterface $at): ?ScheduleSlot
    {
        $minute = $at->hour * 60 + $at->minute;

        return $station->slots()->with('show.hosts')
            ->where('day_of_week', $at->dayOfWeekIso)
            ->where('starts_at', '<=', $minute)
            ->where('ends_at', '>', $minute)
            ->first();
    }

    /** The next slot that starts after $at, looking up to a week ahead. */
    public function upNext(Station $station, CarbonInterface $at): ?ScheduleSlot
    {
        $slots = $station->slots()->with('show')->get();
        $minute = $at->hour * 60 + $at->minute;
        $day = Day::from($at->dayOfWeekIso);

        for ($ahead = 0; $ahead < 8; $ahead++) {
            $next = $slots->where('day_of_week', $day)
                ->filter(fn (ScheduleSlot $s) => $ahead > 0 || $s->starts_at > $minute)
                ->sortBy('starts_at')->first();
            if ($next) {
                return $next;
            }
            $day = $day->next();
        }

        return null;
    }

    /**
     * Hours of a day with nothing scheduled (production plays automated music then).
     *
     * @return list<array{0: int, 1: int}> [start, end] pairs in minutes
     */
    public function gaps(Station $station, Day $day): array
    {
        $gaps = [];
        $cursor = 0;
        foreach ($station->slots->where('day_of_week', $day)->sortBy('starts_at') as $slot) {
            if ($slot->starts_at > $cursor) {
                $gaps[] = [$cursor, $slot->starts_at];
            }
            $cursor = max($cursor, $slot->ends_at);
        }
        if ($cursor < 1440) {
            $gaps[] = [$cursor, 1440];
        }

        return $gaps;
    }

    /** @return Collection<string, int> host name => minutes on air per week, across all stations */
    public function weeklyMinutesByHost(): Collection
    {
        $minutesPerShow = ScheduleSlot::get()->groupBy('show_id')->map->sum(fn (ScheduleSlot $s) => $s->minutes());

        return Host::with('shows')->where('is_active', true)->get()
            ->mapWithKeys(fn (Host $h) => [$h->name => $h->shows->sum(fn (Show $show) => $minutesPerShow[$show->id] ?? 0)])
            ->filter()->sortDesc();
    }

    /** @return Collection<string, int> station name => scheduled minutes per week */
    public function weeklyMinutesByStation(): Collection
    {
        return Station::with('slots')->get()
            ->mapWithKeys(fn (Station $s) => [$s->name => $s->slots->sum(fn (ScheduleSlot $slot) => $slot->minutes())])
            ->sortDesc();
    }

    private function assertValidRange(int $start, int $end): void
    {
        if ($start < 0 || $end > 1440 || $end <= $start) {
            throw new DomainException(__('A slot must end after it starts, within one day. Split late-night shows at midnight.'));
        }
    }

    private function assertFree(int $stationId, Day $day, int $start, int $end, ?int $ignoreId = null): void
    {
        if ($clash = $this->clash($stationId, $day, $start, $end, $ignoreId)) {
            throw new DomainException(__(':day :time clashes with ":show" (:existing).', [
                'day' => $day->label(), 'time' => Clock::format($start).' - '.Clock::format($end),
                'show' => $clash->show->title, 'existing' => $clash->timeRange(),
            ]));
        }
    }
}
