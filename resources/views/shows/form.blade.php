<x-layouts.app title="Shows">
    <x-page-header :title="__($show->exists ? 'Edit show' : 'New show')" />

    <x-card>
        <form method="POST" action="{{ $show->exists ? route('shows.update', $show) : route('shows.store') }}" class="space-y-4">
            @csrf
            @if ($show->exists) @method('PUT') @endif

            <div class="grid gap-4 sm:grid-cols-2">
                <x-input name="title" :label="__('Title')" :value="$show->title" />
                <x-checkbox name="is_active" :label="__('Active')" :checked="$show->is_active" />
                <x-checkbox-list name="hosts" :label="__('Hosts')" :options="$hosts->pluck('name', 'id')" :selected="$show->hosts->pluck('id')" class="sm:col-span-2" />
                <x-textarea name="description" :label="__('Description')" :value="$show->description" class="sm:col-span-2" />
            </div>

            <x-form-actions :cancel="route('shows.index')" />
        </form>
    </x-card>
</x-layouts.app>
