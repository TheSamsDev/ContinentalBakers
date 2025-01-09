<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create Permissions
        $permissions = [
            'view permission',
            'create permission',
            'update permission',
            'delete permission',
            'view role',
            'create role',
            'update role',
            'delete role',
            'view store',
            'create store',
            'update store',
            'delete store',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $adminRole = Role::firstOrCreate(['name' => 'SuperAdmin']);
        $adminRole->syncPermissions(Permission::all());

         Role::firstOrCreate(['name' => 'Retailer']);
        // $userRole->syncPermissions(['view dashboard']); // Limited permissions for 'user'



        $this->command->info('Roles, Permissions, and Admin User seeded successfully.');
    }
}
