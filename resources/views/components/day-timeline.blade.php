@props(['slots', 'gaps' => [], 'now' => null])

{{-- One day as a 24-hour bar: shows in dark blocks, empty hours as stripes. --}}
<div class="relative h-9 overflow-hidden rounded-lg bg-slate-100">
    @foreach ($gaps as [$from, $to])
        <div class="absolute inset-y-0 bg-[repeating-linear-gradient(45deg,#e2e8f0_0,#e2e8f0_4px,#f1f5f9_4px,#f1f5f9_8px)]"
             style="left: {{ $from / 14.4 }}%; width: {{ ($to - $from) / 14.4 }}%"></div>
    @endforeach
    @foreach ($slots as $slot)
        <a href="{{ route('slots.edit', $slot) }}" title="{{ $slot->show->title }} · {{ $slot->timeRange() }}"
           class="absolute inset-y-1 flex items-center overflow-hidden rounded-md bg-slate-900 px-2 text-xs font-medium text-white hover:bg-rose-600"
           style="left: calc({{ $slot->starts_at / 14.4 }}% + 1px); width: calc({{ $slot->minutes() / 14.4 }}% - 2px)">
            <span class="truncate">{{ $slot->show->title }}</span>
        </a>
    @endforeach
    @if ($now !== null)
        <div class="absolute inset-y-0 w-0.5 bg-rose-500" style="left: {{ $now / 14.4 }}%"></div>
    @endif
</div>
