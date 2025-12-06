<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TenantRole extends Model
{
    protected $guarded = [];

    protected $casts = [
        'permissions' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id ??= (string) Str::ulid());
    }

    public function tenant()
    {
        return $this->belongsTo(\Stancl\Tenancy\Database\Models\Tenant::class);
    }

    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'tenant_role_id');
    }

    // THESE TWO LINES ARE THE FINAL FIX
    public function getRouteKeyName()
    {
        return 'id';
    }

public function getRouteKeyName()
{
    return 'id'; // This forces ULID in URLs
}
}