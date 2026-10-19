<?php

namespace App\Http\Controllers;

use App\Enums\Day;
use App\Models\Host;
use App\Models\ScheduleSlot;
use App\Models\Show;
use App\Models\Station;
use App\Services\ScheduleService;

class DashboardController extends Controller
{
    public function __invoke(ScheduleService $schedule)
    {
        // "What is on at ...?" defaults to now, but can be any day and time, which helps in a demo.
        $at = now();
        if (request()->filled('day') && preg_match('/^([01]\d|2[0-3]):[0-5]\d$/D', (string) request('time'))) {
            $day = Day::tryFrom((int) request('day')) ?? Day::from(now()->dayOfWeekIso);
            $at = now()->startOfWeek()->setTimeFromTimeString(request('time'))->addDays($day->value - 1);
        }
        $today = Day::from($at->dayOfWeekIso);

        $stations = Station::with('slots.show.hosts')->where('is_active', true)->orderBy('id')->get()->map(fn (Station $station) => [
            'station' => $station,
            'now' => $schedule->onAir($station, $at),
            'next' => $schedule->upNext($station, $at),
            'gaps' => $schedule->gaps($station, $today),
        ]);

        return view('dashboard.index', [
            'at' => $at,
            'today' => $today,
            'stations' => $stations,
            'showCount' => Show::where('is_active', true)->count(),
            'hostCount' => Host::where('is_active', true)->count(),
            'weeklyMinutes' => (int) ScheduleSlot::get()->sum(fn (ScheduleSlot $s) => $s->minutes()),
            'byHost' => $schedule->weeklyMinutesByHost()->take(8),
            'byStation' => $schedule->weeklyMinutesByStation(),
        ]);
    }
}
