<x-layouts.app title="Shows">
    <x-page-header :title="__('Shows')" :description="__('Radio programmes. When and where they air is set in the schedule.')">
        <x-button :href="route('shows.create')">{{ __('New show') }}</x-button>
    </x-page-header>

    <x-search />

    <x-table :headings="['Show', 'Hosts', 'On air', 'Status']">
        @forelse ($shows as $show)
            <tr>
                <td class="px-4 py-3">
                    <span class="block font-medium">{{ $show->title }}</span>
                    @if ($show->description) <span class="block text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($show->description, 90) }}</span> @endif
                </td>
                <td class="px-4 py-3 text-slate-600">{{ $show->hostNames() ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-600">
                    @if ($show->slots->isEmpty())
                        <span class="text-slate-400">{{ __('not scheduled') }}</span>
                    @else
                        {{ trans_choice(':count slot|:count slots', $show->slots->count()) }}
                        <span class="block text-xs text-slate-500">{{ $show->slots->pluck('station.city')->unique()->sort()->implode(', ') }}</span>
                    @endif
                </td>
                <td class="px-4 py-3"><x-active-badge :active="$show->is_active" /></td>
                <td class="px-4 py-3">
                    <x-row-actions :edit="route('shows.edit', $show)" :destroy="route('shows.destroy', $show)" :confirm="__('Delete :name?', ['name' => $show->title])" />
                </td>
            </tr>
        @empty
            <x-empty-row span="5" />
        @endforelse
    </x-table>

    <div class="mt-4">{{ $shows->links() }}</div>
</x-layouts.app>
