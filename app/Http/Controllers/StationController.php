<?php

namespace App\Http\Controllers;

use App\Enums\Day;
use App\Enums\StreamStatus;
use App\Http\Requests\StationRequest;
use App\Models\Station;
use App\Services\ScheduleService;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::withCount('slots')->orderBy('id')->get();

        return view('stations.index', compact('stations'));
    }

    // The station's week at a glance.
    public function show(Station $station, ScheduleService $schedule)
    {
        $station->load('slots.show.hosts');

        return view('stations.show', [
            'station' => $station,
            'days' => collect(Day::cases())->map(fn (Day $day) => [
                'day' => $day,
                'slots' => $station->slots->where('day_of_week', $day)->values(),
                'gaps' => $schedule->gaps($station, $day),
            ]),
        ]);
    }

    public function create()
    {
        return view('stations.form', ['station' => new Station(), 'statuses' => StreamStatus::cases()]);
    }

    public function store(StationRequest $request)
    {
        $station = Station::create($request->validated());

        return to_route('stations.show', $station)->with('status', __('Saved.'));
    }

    public function edit(Station $station)
    {
        return view('stations.form', ['station' => $station, 'statuses' => StreamStatus::cases()]);
    }

    public function update(StationRequest $request, Station $station)
    {
        $station->update($request->validated());

        return to_route('stations.show', $station)->with('status', __('Saved.'));
    }

    public function destroy(Station $station)
    {
        if ($reason = $station->deletionBlocker()) {
            return back()->with('error', $reason);
        }
        $station->delete();

        return to_route('stations.index')->with('status', __('Deleted.'));
    }
}
