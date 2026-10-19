<?php

namespace App\Http\Controllers;

use App\Http\Requests\HostRequest;
use App\Models\Host;
use App\Services\ScheduleService;

class HostController extends Controller
{
    public function index(ScheduleService $schedule)
    {
        $hosts = Host::with('shows')
            ->when(request('q'), fn ($q, $term) => $q->whereRaw('lower(name) like ?', ['%'.mb_strtolower($term).'%']))
            ->orderBy('name')->paginate(20)->withQueryString();

        return view('hosts.index', ['hosts' => $hosts, 'minutes' => $schedule->weeklyMinutesByHost()]);
    }

    public function create()
    {
        return view('hosts.form', ['host' => new Host()]);
    }

    public function store(HostRequest $request)
    {
        Host::create($request->validated());

        return to_route('hosts.index')->with('status', __('Saved.'));
    }

    public function edit(Host $host)
    {
        return view('hosts.form', compact('host'));
    }

    public function update(HostRequest $request, Host $host)
    {
        $host->update($request->validated());

        return to_route('hosts.index')->with('status', __('Saved.'));
    }

    public function destroy(Host $host)
    {
        if ($reason = $host->deletionBlocker()) {
            return back()->with('error', $reason);
        }
        $host->delete();

        return back()->with('status', __('Deleted.'));
    }
}
