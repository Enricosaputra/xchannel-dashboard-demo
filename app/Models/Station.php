<?php

namespace App\Models;

use App\Enums\StreamStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{
    use HasFactory;

    // Same defaults as the database, so a model is right before it is reloaded.
    protected $attributes = ['is_active' => true, 'stream_status' => 'offline'];

    protected $fillable = ['name', 'city', 'frequency', 'stream_url', 'stream_status', 'is_active'];

    protected $casts = ['stream_status' => StreamStatus::class, 'is_active' => 'boolean'];

    public function slots(): HasMany
    {
        return $this->hasMany(ScheduleSlot::class)->orderBy('day_of_week')->orderBy('starts_at');
    }

    public function deletionBlocker(): ?string
    {
        return $this->slots()->exists() ? __('":name" still has a schedule. Mark it inactive instead.', ['name' => $this->name]) : null;
    }
}
