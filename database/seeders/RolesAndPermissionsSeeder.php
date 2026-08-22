<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create standard roles
        foreach (RoleName::cases() as $role) {
            Role::firstOrCreate(['name' => $role->value, 'guard_name' => 'web']);
        }

        // Create base permissions
        $permissions = [
            'view admin dashboard',
            'manage settings',
            'manage users',
            'manage vendors',
            'manage categories',
            'manage brands',
            'manage products',
            'manage orders',
            'manage inventory',
            'manage promotions',
            'manage reviews',
            'manage settlements',
            'manage cms',
            'manage support tickets',
            'view vendor dashboard',
            'manage vendor products',
            'manage vendor orders',
            'manage vendor inventory',
            'manage vendor settlements',
            'view customer profile',
            'place orders',
            'write reviews',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign all permissions to Admin
        $adminRole = Role::findByName(RoleName::Admin->value, 'web');
        $adminRole->givePermissionTo(Permission::all());

        // Assign Vendor permissions
        $vendorRole = Role::findByName(RoleName::Vendor->value, 'web');
        $vendorRole->syncPermissions([
            'view vendor dashboard',
            'manage vendor products',
            'manage vendor orders',
            'manage vendor inventory',
            'manage vendor settlements',
        ]);

        // Assign Customer permissions
        $customerRole = Role::findByName(RoleName::Customer->value, 'web');
        $customerRole->syncPermissions([
            'view customer profile',
            'place orders',
            'write reviews',
        ]);
    }
}
