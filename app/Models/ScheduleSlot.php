<?php

namespace App\Models;

use App\Enums\Day;
use App\Support\Clock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// One show on one station, on one day, from starts_at to ends_at (minutes since midnight).
class ScheduleSlot extends Model
{
    protected $fillable = ['station_id', 'show_id', 'day_of_week', 'starts_at', 'ends_at'];

    protected $casts = ['day_of_week' => Day::class, 'starts_at' => 'integer', 'ends_at' => 'integer'];

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    public function minutes(): int
    {
        return $this->ends_at - $this->starts_at;
    }

    /** "06:00 - 10:00" */
    public function timeRange(): string
    {
        return Clock::format($this->starts_at).' - '.Clock::format($this->ends_at);
    }
}
