<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowRequest;
use App\Models\Host;
use App\Models\Show;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    public function index()
    {
        $shows = Show::with(['hosts', 'slots.station'])
            ->when(request('q'), fn ($q, $term) => $q->whereRaw('lower(title) like ?', ['%'.mb_strtolower($term).'%']))
            ->orderBy('title')->paginate(15)->withQueryString();

        return view('shows.index', compact('shows'));
    }

    public function create()
    {
        return view('shows.form', ['show' => new Show(), 'hosts' => Host::where('is_active', true)->orderBy('name')->get()]);
    }

    public function store(ShowRequest $request)
    {
        DB::transaction(function () use ($request) {
            $show = Show::create($request->safe()->except('hosts'));
            $show->hosts()->sync($request->input('hosts', []));
        });

        return to_route('shows.index')->with('status', __('Saved.'));
    }

    public function edit(Show $show)
    {
        return view('shows.form', ['show' => $show->load('hosts'), 'hosts' => Host::where('is_active', true)->orderBy('name')->get()]);
    }

    public function update(ShowRequest $request, Show $show)
    {
        DB::transaction(function () use ($request, $show) {
            $show->update($request->safe()->except('hosts'));
            $show->hosts()->sync($request->input('hosts', []));
        });

        return to_route('shows.index')->with('status', __('Saved.'));
    }

    public function destroy(Show $show)
    {
        if ($reason = $show->deletionBlocker()) {
            return back()->with('error', $reason);
        }
        $show->delete();

        return back()->with('status', __('Deleted.'));
    }
}
