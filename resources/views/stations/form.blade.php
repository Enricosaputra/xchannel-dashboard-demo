<x-layouts.app title="Stations">
    <x-page-header :title="__($station->exists ? 'Edit station' : 'New station')" />

    <x-card>
        <form method="POST" action="{{ $station->exists ? route('stations.update', $station) : route('stations.store') }}" class="space-y-4">
            @csrf
            @if ($station->exists) @method('PUT') @endif

            <div class="grid gap-4 sm:grid-cols-2">
                <x-input name="name" :label="__('Name')" :value="$station->name" :placeholder="__('e.g. XChannel Bandung')" />
                <x-input name="city" :label="__('City')" :value="$station->city" />
                <x-input name="frequency" :label="__('Frequency')" :value="$station->frequency" placeholder="92.3 FM" />
                <x-input name="stream_url" :label="__('Stream URL')" :value="$station->stream_url" placeholder="https://" />
                <x-select name="stream_status" :label="__('Stream')" :options="collect($statuses)->mapWithKeys(fn ($s) => [$s->value => $s->label()])" :value="$station->stream_status?->value" />
                <x-checkbox name="is_active" :label="__('Active')" :checked="$station->is_active" />
            </div>

            <x-form-actions :cancel="$station->exists ? route('stations.show', $station) : route('stations.index')" />
        </form>
    </x-card>
</x-layouts.app>
