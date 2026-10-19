<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// An announcer (penyiar).
class Host extends Model
{
    use HasFactory;

    protected $attributes = ['is_active' => true];

    protected $fillable = ['name', 'bio', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function shows(): BelongsToMany
    {
        return $this->belongsToMany(Show::class);
    }

    public function deletionBlocker(): ?string
    {
        return $this->shows()->exists() ? __('":name" still hosts shows. Mark them inactive instead.', ['name' => $this->name]) : null;
    }
}
