<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TeamMember extends Model
{
    use HasFactory, BelongsToTenant;

    protected $keyType = 'string';
    public $incrementing = false;

    // ? THIS IS THE FINAL FIX
    protected $guarded = [];

    protected $casts = [
        'employment_start_date' => 'date',
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

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function businessRole(): BelongsTo
    {
        return $this->belongsTo(BusinessRole::class);
    }

    public function qualifications(): HasMany
    {
        return $this->hasMany(Qualification::class);
    }

    public function trainingLogs(): HasMany
    {
        return $this->hasMany(TrainingLog::class);
    }

    public function hasExpiringQualifications(): bool
    {
        return $this->qualifications()
            ->where('expiry_date', '>=', now())
            ->where('expiry_date', '<=', now()->addDays(60))
            ->exists();
    }

    public function getAnnualTrainingHoursAttribute(): int
    {
        return $this->trainingLogs()
            ->whereYear('date', now()->year)
            ->sum('hours');
    }
}