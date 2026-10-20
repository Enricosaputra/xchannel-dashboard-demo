<div class="relative mb-1 h-4 text-[10px] text-ink-400">
    @foreach ([0 => 'translate-x-0', 6 => '-translate-x-1/2', 12 => '-translate-x-1/2', 18 => '-translate-x-1/2', 24 => '-translate-x-full'] as $hour => $align)
        <span class="absolute {{ $align }}" style="left: {{ $hour / 24 * 100 }}%">{{ sprintf('%02d:00', $hour) }}</span>
    @endforeach
</div>
