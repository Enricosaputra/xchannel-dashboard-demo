<x-layouts.app title="Schedule">
    <x-page-header :title="__('Schedule')" :description="__('Every show on every station. Slots on the same station and day cannot overlap.')">
        <x-button :href="route('slots.create')">{{ __('Add to schedule') }}</x-button>
    </x-page-header>

    <form method="GET" class="mb-4 flex flex-wrap gap-3">
        <select name="station" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm" onchange="this.form.submit()">
            <option value="">{{ __('All stations') }}</option>
            @foreach ($stations as $station)
                <option value="{{ $station->id }}" @selected((string) request('station') === (string) $station->id)>{{ $station->name }}</option>
            @endforeach
        </select>
        <select name="day" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm" onchange="this.form.submit()">
            <option value="">{{ __('Every day') }}</option>
            @foreach ($days as $day)
                <option value="{{ $day->value }}" @selected((string) request('day') === (string) $day->value)>{{ $day->label() }}</option>
            @endforeach
        </select>
    </form>

    <x-table :headings="['Station', 'Day', 'Time', 'Show', 'Hosts']">
        @forelse ($slots as $slot)
            <tr>
                <td class="px-4 py-3 text-slate-600">{{ $slot->station->name }}</td>
                <td class="px-4 py-3">{{ $slot->day_of_week->label() }}</td>
                <td class="whitespace-nowrap px-4 py-3 tabular-nums">{{ $slot->timeRange() }}</td>
                <td class="px-4 py-3 font-medium">{{ $slot->show->title }}</td>
                <td class="px-4 py-3 text-slate-600">{{ $slot->show->hostNames() ?: '-' }}</td>
                <td class="px-4 py-3">
                    <x-row-actions :edit="route('slots.edit', $slot)" :destroy="route('slots.destroy', $slot)" :confirm="__('Remove :show on :day from the schedule?', ['show' => $slot->show->title, 'day' => $slot->day_of_week->label()])" />
                </td>
            </tr>
        @empty
            <x-empty-row span="6" />
        @endforelse
    </x-table>

    <div class="mt-4">{{ $slots->links() }}</div>
</x-layouts.app>
