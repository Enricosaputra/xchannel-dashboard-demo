<?php

namespace App\Http\Controllers;

use App\Enums\Day;
use App\Http\Requests\SlotRequest;
use App\Models\ScheduleSlot;
use App\Models\Show;
use App\Models\Station;
use App\Services\ScheduleService;
use App\Support\Clock;
use DomainException;

class ScheduleSlotController extends Controller
{
    public function __construct(private ScheduleService $schedule) {}

    public function index()
    {
        $slots = ScheduleSlot::with(['station', 'show.hosts'])
            ->when(request('station'), fn ($q, $id) => $q->where('station_id', $id))
            ->when(request('day'), fn ($q, $day) => $q->where('day_of_week', $day))
            ->orderBy('station_id')->orderBy('day_of_week')->orderBy('starts_at')
            ->paginate(25)->withQueryString();

        return view('slots.index', ['slots' => $slots, 'stations' => Station::orderBy('id')->get(), 'days' => Day::cases()]);
    }

    public function create()
    {
        return view('slots.form', ['slot' => new ScheduleSlot(['station_id' => request('station')]), ...$this->choices()]);
    }

    public function store(SlotRequest $request)
    {
        $data = $request->validated();
        try {
            $this->schedule->schedule(
                Station::findOrFail($data['station_id']),
                Show::findOrFail($data['show_id']),
                array_map(fn ($d) => Day::from((int) $d), $data['days']),
                Clock::toMinutes($data['starts_at']),
                Clock::toMinutes($data['ends_at']),
            );
        } catch (DomainException $e) {
            return back()->withInput()->withErrors(['starts_at' => $e->getMessage()]);
        }

        return to_route('stations.show', $data['station_id'])->with('status', __('Added to the schedule.'));
    }

    public function edit(ScheduleSlot $slot)
    {
        return view('slots.form', ['slot' => $slot, ...$this->choices()]);
    }

    public function update(SlotRequest $request, ScheduleSlot $slot)
    {
        $data = $request->validated();
        try {
            $this->schedule->move(
                $slot,
                Station::findOrFail($data['station_id']),
                Show::findOrFail($data['show_id']),
                Day::from((int) $data['day_of_week']),
                Clock::toMinutes($data['starts_at']),
                Clock::toMinutes($data['ends_at']),
            );
        } catch (DomainException $e) {
            return back()->withInput()->withErrors(['starts_at' => $e->getMessage()]);
        }

        return to_route('stations.show', $slot->station_id)->with('status', __('Saved.'));
    }

    public function destroy(ScheduleSlot $slot)
    {
        $slot->delete();

        return back()->with('status', __('Removed from the schedule.'));
    }

    private function choices(): array
    {
        return [
            'stations' => Station::where('is_active', true)->orderBy('id')->get(),
            'shows' => Show::with('hosts')->where('is_active', true)->orderBy('title')->get(),
            'days' => Day::cases(),
        ];
    }
}
