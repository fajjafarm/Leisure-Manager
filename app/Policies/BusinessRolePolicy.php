<?php

namespace App\Policies;

use App\Models\BusinessRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Stancl\Tenancy\Database\Models\Tenant;

class BusinessRolePolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return $user && $user->isSuperAdmin();  // Super admins see all; business admins see tenant-scoped
    }

    public function view(?User $user, BusinessRole $businessRole): bool
    {
        return $user && ($user->isSuperAdmin() || $user->tenant_id === $businessRole->tenant_id);
    }

    public function create(?User $user): bool
    {
        return $user && ($user->isSuperAdmin() || $user->isBusinessAdmin());
    }

    public function update(?User $user, BusinessRole $businessRole): bool
    {
        return $user && ($user->isSuperAdmin() || ($user->isBusinessAdmin() && $user->tenant_id === $businessRole->tenant_id));
    }

    public function delete(?User $user, BusinessRole $businessRole): bool
    {
        return $user && ($user->isSuperAdmin() || ($user->isBusinessAdmin() && $user->tenant_id === $businessRole->tenant_id));
    }
}