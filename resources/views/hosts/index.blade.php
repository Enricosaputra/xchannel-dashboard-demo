<x-layouts.app title="Hosts">
    <x-page-header :title="__('Hosts')" :description="__('Announcers. A show can have several hosts, and a host can be on several shows.')">
        <x-button :href="route('hosts.create')">{{ __('New host') }}</x-button>
    </x-page-header>

    <x-search />

    <x-table :headings="['Name', 'Shows', '>Hours per week', 'Status']">
        @forelse ($hosts as $host)
            <tr>
                <td class="px-4 py-3 font-medium">{{ $host->name }}</td>
                <td class="px-4 py-3 text-ink-600">{{ $host->shows->pluck('title')->implode(', ') ?: '-' }}</td>
                <td class="px-4 py-3 text-right tabular-nums">{{ \App\Support\Clock::hours($minutes[$host->name] ?? 0) }}</td>
                <td class="px-4 py-3"><x-active-badge :active="$host->is_active" /></td>
                <td class="px-4 py-3">
                    <x-row-actions :edit="route('hosts.edit', $host)" :destroy="route('hosts.destroy', $host)" :confirm="__('Delete :name?', ['name' => $host->name])" />
                </td>
            </tr>
        @empty
            <x-empty-row span="5" />
        @endforelse
    </x-table>

    <div class="mt-4">{{ $hosts->links() }}</div>
</x-layouts.app>
