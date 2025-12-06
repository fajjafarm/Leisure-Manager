<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Qualification extends Model
{
    use HasFactory, BelongsToTenant;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];  // ? FINAL FIX

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'cpr_score' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::ulid();
            }
        });
    }

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date < now();
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        return $this->expiry_date >= now() && $this->expiry_date <= now()->addDays(60);
    }
}