@props(['status'])

<x-badge :tone="match ($status->value) { 'live' => 'green', 'idle' => 'amber', default => 'slate' }">{{ $status->label() }}</x-badge>
