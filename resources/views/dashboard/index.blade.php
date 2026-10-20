<x-layouts.app title="Dashboard">
    <x-page-header :title="__('Dashboard')" :description="__('What every station is playing, and how the week is filled.')" />

    <form method="GET" class="mb-6 flex flex-wrap items-end gap-3 rounded-xl border border-ink-200 bg-white p-4 shadow-sm">
        <div>
            <label for="day" class="mb-1.5 block text-sm font-medium text-ink-700">{{ __('Day') }}</label>
            <select id="day" name="day" class="rounded-lg border border-ink-300 bg-white px-3 py-2 text-sm shadow-sm">
                @foreach (\App\Enums\Day::cases() as $day)
                    <option value="{{ $day->value }}" @selected($day === $today)>{{ $day->label() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="time" class="mb-1.5 block text-sm font-medium text-ink-700">{{ __('Time (WIB)') }}</label>
            <input id="time" name="time" type="time" value="{{ $at->format('H:i') }}" class="rounded-lg border border-ink-300 bg-white px-3 py-2 text-sm shadow-sm">
        </div>
        <x-button variant="outline">{{ __('View') }}</x-button>
        @if (request()->filled('day'))
            <a href="{{ route('dashboard') }}" class="pb-2 text-sm text-ink-500 hover:text-ink-900">{{ __('Back to now') }}</a>
        @endif
    </form>

    @php
        $cards = [
            [__('Active stations'), $stations->count(), __('on air')],
            [__('Shows'), $showCount, __('active programmes')],
            [__('Hosts'), $hostCount, __('active announcers')],
            [__('Airtime per week'), \App\Support\Clock::hours($weeklyMinutes).' '.__('hours'), __('scheduled, all stations')],
        ];
    @endphp
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ($cards as [$label, $value, $note])
            <div class="rounded-xl border border-ink-200 bg-white p-5 shadow-sm">
                <p class="whitespace-nowrap text-xl font-bold">{{ $value }}</p>
                <p class="text-sm text-ink-500">{{ $label }}</p>
                <p class="mt-1 text-xs text-ink-400">{{ $note }}</p>
            </div>
        @endforeach
    </div>

    <section class="mt-6 rounded-xl border border-ink-200 bg-white shadow-sm">
        <header class="border-b border-ink-100 px-6 py-4">
            <h2 class="font-semibold">{{ __('On air at :day :time', ['day' => $today->label(), 'time' => $at->format('H:i')]) }}</h2>
        </header>
        <ul class="divide-y divide-ink-100">
            @foreach ($stations as $row)
                @php [$station, $now, $next] = [$row['station'], $row['now'], $row['next']]; @endphp
                <li class="px-6 py-4">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0">
                            <a href="{{ route('stations.show', $station) }}" class="font-medium hover:underline">{{ $station->name }}</a>
                            <span class="ml-1 text-xs text-ink-500">{{ $station->frequency }}</span>
                            <x-stream-badge :status="$station->stream_status" />
                        </div>
                        <div class="text-right text-sm">
                            @if ($now)
                                <span class="block font-medium">{{ $now->show->title }} <span class="font-normal text-ink-500">· {{ $now->timeRange() }}</span></span>
                                <span class="block text-xs text-ink-500">{{ $now->show->hostNames() ?: __('No host') }}</span>
                            @else
                                <span class="block text-ink-500">{{ __('Nothing scheduled: automated music') }}</span>
                            @endif
                            @if ($next)
                                <span class="block text-xs text-ink-400">{{ __('Up next: :show, :day :time', ['show' => $next->show->title, 'day' => $next->day_of_week->label(), 'time' => \App\Support\Clock::format($next->starts_at)]) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3">
                        <x-day-timeline :slots="$station->slots->where('day_of_week', $today)" :gaps="$row['gaps']" :now="$at->hour * 60 + $at->minute" />
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <x-card :title="__('Airtime per host')" :description="__('Hours on air per week, across all stations')">
            @php $most = max(1, $byHost->max()); @endphp
            <ul class="space-y-3">
                @foreach ($byHost as $name => $minutes)
                    <li>
                        <div class="mb-1 flex justify-between text-sm"><span>{{ $name }}</span><span class="text-ink-500">{{ \App\Support\Clock::hours($minutes) }} {{ __('hours') }}</span></div>
                        <div class="h-2 overflow-hidden rounded-full bg-ink-100"><div class="h-full rounded-full bg-accent-600" style="width: {{ $minutes / $most * 100 }}%"></div></div>
                    </li>
                @endforeach
            </ul>
        </x-card>

        <x-card :title="__('Airtime per station')" :description="__('Scheduled hours per week; the rest is automated music')">
            <ul class="space-y-3">
                @foreach ($byStation as $name => $minutes)
                    <li>
                        <div class="mb-1 flex justify-between text-sm"><span>{{ $name }}</span><span class="text-ink-500">{{ __(':hours of 168 hours', ['hours' => \App\Support\Clock::hours($minutes)]) }}</span></div>
                        <div class="h-2 overflow-hidden rounded-full bg-ink-100"><div class="h-full rounded-full bg-ink-900" style="width: {{ $minutes / (168 * 60) * 100 }}%"></div></div>
                    </li>
                @endforeach
            </ul>
        </x-card>
    </div>
</x-layouts.app>
