<?php

namespace App\Enums;

// Production's `status` table: live, idle, offline.
enum StreamStatus: string
{
    case Live = 'live';
    case Idle = 'idle';
    case Offline = 'offline';

    public function label(): string
    {
        return __(ucfirst($this->value));
    }
}
