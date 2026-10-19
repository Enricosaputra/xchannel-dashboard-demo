<x-layouts.app title="Stations">
    <x-page-header :title="$station->name" :description="$station->frequency.' · '.$station->city">
        <x-button :href="route('slots.create', ['station' => $station->id])">{{ __('Add to schedule') }}</x-button>
        <x-button :href="route('stations.edit', $station)" variant="outline">{{ __('Edit') }}</x-button>
    </x-page-header>

    <x-card :title="__('Week schedule')" :description="__('Click a show to change it. Striped parts have no show: the station plays automated music.')">
        <div class="grid grid-cols-[4.5rem_1fr] gap-3">
            <span></span>
            <x-hour-ruler />
        </div>
        <div class="space-y-2">
            @foreach ($days as $row)
                <div class="grid grid-cols-[4.5rem_1fr] items-center gap-3">
                    <span class="text-sm font-medium text-slate-600">{{ $row['day']->label() }}</span>
                    <x-day-timeline :slots="$row['slots']" :gaps="$row['gaps']" />
                </div>
            @endforeach
        </div>
    </x-card>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        @foreach ($days as $row)
            <x-card :title="$row['day']->label()">
                <ul class="-my-2 divide-y divide-slate-100 text-sm">
                    @forelse ($row['slots'] as $slot)
                        <li class="flex items-center justify-between gap-3 py-2">
                            <span class="min-w-0">
                                <a href="{{ route('slots.edit', $slot) }}" class="block truncate font-medium hover:underline">{{ $slot->show->title }}</a>
                                <span class="block truncate text-xs text-slate-500">{{ $slot->show->hostNames() ?: __('No host') }}</span>
                            </span>
                            <span class="whitespace-nowrap tabular-nums text-slate-600">{{ $slot->timeRange() }}</span>
                        </li>
                    @empty
                        <li class="py-2 text-slate-500">{{ __('Nothing scheduled: automated music') }}</li>
                    @endforelse
                </ul>
            </x-card>
        @endforeach
    </div>
</x-layouts.app>
