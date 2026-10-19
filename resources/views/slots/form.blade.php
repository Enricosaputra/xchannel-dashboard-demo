<x-layouts.app title="Schedule">
    <x-page-header :title="__($slot->exists ? 'Change slot' : 'Add to schedule')"
                   :description="__('Times are WIB in HH:MM, from 00:00 to 24:00. A show past midnight needs two slots: until 24:00, and from 00:00 the next day.')" />

    <x-card>
        <form method="POST" action="{{ $slot->exists ? route('slots.update', $slot) : route('slots.store') }}" class="space-y-4">
            @csrf
            @if ($slot->exists) @method('PUT') @endif

            <div class="grid gap-4 sm:grid-cols-2">
                <x-select name="station_id" :label="__('Station')" :options="$stations->pluck('name', 'id')" :value="$slot->station_id" />
                <x-select name="show_id" :label="__('Show')" :options="$shows->mapWithKeys(fn ($s) => [$s->id => $s->title.($s->hosts->isNotEmpty() ? ' ('.$s->hostNames().')' : '')])" :value="$slot->show_id" />
                @if ($slot->exists)
                    <x-select name="day_of_week" :label="__('Day')" :options="collect($days)->mapWithKeys(fn ($d) => [$d->value => $d->label()])" :value="$slot->day_of_week->value" />
                @else
                    <x-checkbox-list name="days" :label="__('Days')" :options="collect($days)->mapWithKeys(fn ($d) => [$d->value => $d->label()])" :selected="[]" class="sm:col-span-2" />
                @endif
                <x-input name="starts_at" :label="__('From')" :value="$slot->exists ? \App\Support\Clock::format($slot->starts_at) : ''" placeholder="06:00" inputmode="numeric" />
                <x-input name="ends_at" :label="__('Until')" :value="$slot->exists ? \App\Support\Clock::format($slot->ends_at) : ''" placeholder="10:00" inputmode="numeric" />
            </div>

            <x-form-actions :cancel="$slot->station_id ? route('stations.show', $slot->station_id) : route('slots.index')" />
        </form>
    </x-card>
</x-layouts.app>
