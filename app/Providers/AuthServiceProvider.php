<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\BusinessRole;
use App\Policies\BusinessRolePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        BusinessRole::class => BusinessRolePolicy::class,
        // Add more models here later (TeamMember, Equipment, etc.)
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}