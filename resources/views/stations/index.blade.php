<x-layouts.app title="Stations">
    <x-page-header :title="__('Stations')" :description="__('Each city has its own station and its own week of shows.')">
        <x-button :href="route('stations.create')">{{ __('New station') }}</x-button>
    </x-page-header>

    <x-table :headings="['Station', 'City', 'Stream', '>Slots per week', 'Status']">
        @forelse ($stations as $station)
            <tr>
                <td class="px-4 py-3">
                    <a href="{{ route('stations.show', $station) }}" class="block font-medium hover:underline">{{ $station->name }}</a>
                    <span class="block text-xs text-ink-500">{{ $station->frequency }}</span>
                </td>
                <td class="px-4 py-3 text-ink-600">{{ $station->city }}</td>
                <td class="px-4 py-3"><x-stream-badge :status="$station->stream_status" /></td>
                <td class="px-4 py-3 text-right tabular-nums">{{ $station->slots_count }}</td>
                <td class="px-4 py-3"><x-active-badge :active="$station->is_active" /></td>
                <td class="px-4 py-3">
                    <x-row-actions :edit="route('stations.edit', $station)" :destroy="route('stations.destroy', $station)" :confirm="__('Delete :name?', ['name' => $station->name])" />
                </td>
            </tr>
        @empty
            <x-empty-row span="6" />
        @endforelse
    </x-table>
</x-layouts.app>
