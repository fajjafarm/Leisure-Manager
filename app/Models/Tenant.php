<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    // These are REAL columns in your tenants table
    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'subscription_plan',
    ];

    protected $guarded = [];

public function teamRoles()
{
    return $this->hasMany(\App\Models\TenantRole::class);
}
}