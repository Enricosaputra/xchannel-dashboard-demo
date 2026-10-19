<x-layouts.app title="Hosts">
    <x-page-header :title="__($host->exists ? 'Edit host' : 'New host')" />

    <x-card>
        <form method="POST" action="{{ $host->exists ? route('hosts.update', $host) : route('hosts.store') }}" class="space-y-4">
            @csrf
            @if ($host->exists) @method('PUT') @endif

            <div class="grid gap-4 sm:grid-cols-2">
                <x-input name="name" :label="__('Name')" :value="$host->name" />
                <x-checkbox name="is_active" :label="__('Active')" :checked="$host->is_active" />
                <x-textarea name="bio" :label="__('Short bio')" :value="$host->bio" class="sm:col-span-2" />
            </div>

            <x-form-actions :cancel="route('hosts.index')" />
        </form>
    </x-card>
</x-layouts.app>
