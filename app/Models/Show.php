<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// A radio programme (program acara), e.g. a morning show. When it airs is in schedule_slots.
class Show extends Model
{
    use HasFactory;

    protected $attributes = ['is_active' => true];

    protected $fillable = ['title', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function hosts(): BelongsToMany
    {
        return $this->belongsToMany(Host::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(ScheduleSlot::class);
    }

    public function hostNames(): string
    {
        return $this->hosts->pluck('name')->join(', ', ' & ');
    }

    public function deletionBlocker(): ?string
    {
        return $this->slots()->exists() ? __('":name" is on the schedule. Remove its slots first, or mark it inactive.', ['name' => $this->title]) : null;
    }
}
