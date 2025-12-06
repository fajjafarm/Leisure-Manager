<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Run only on the central database
        if (config('database.default') !== 'central') {
            return;
        }

        // Create super_admin role
        Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web',
        ]);

        // Create or update super admin user
        $super = User::updateOrCreate(
            ['email' => 'super@lrm2.glensloss.co.uk'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'), // Change this!
            ]
        );

        // Assign role using Spatie's trait method
        $super->syncRoles('super_admin');

        $this->command->info('Super admin created/updated and assigned "super_admin" role.');
    }
}