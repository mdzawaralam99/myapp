<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for Products (using firstOrCreate)
        Permission::firstOrCreate(['name' => 'add product', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'edit product', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'delete product', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'view product', 'guard_name' => 'api']);

        // Create permissions for Product Categories
        Permission::firstOrCreate(['name' => 'add product category', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'edit product category', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'delete product category', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'view product category', 'guard_name' => 'api']);

        // Create roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'SUPER_ADMIN', 'guard_name' => 'api']);
        $superAdmin->givePermissionTo(Permission::all());

        $propertyManager = Role::firstOrCreate(['name' => 'PROPERTY_MANAGER', 'guard_name' => 'api']);
        $propertyManager->givePermissionTo([
            'add product', 'edit product', 'view product',
            'add product category', 'edit product category', 'view product category'
        ]);

        $officeManager = Role::firstOrCreate(['name' => 'OFFICE_MANAGER', 'guard_name' => 'api']);
        $officeManager->givePermissionTo([
            'add product', 'edit product', 'view product',
            'add product category', 'edit product category', 'view product category'
        ]);

        $securityPersonnel = Role::firstOrCreate(['name' => 'SECURITY_PERSONNEL', 'guard_name' => 'api']);
        $securityPersonnel->givePermissionTo([
            'add product', 'edit product', 'delete product', 'view product',
            'add product category', 'edit product category', 'delete product category', 'view product category'
        ]);

        $maintenanceStaff = Role::firstOrCreate(['name' => 'MAINTENANCE_STAFF', 'guard_name' => 'api']);
        $maintenanceStaff->givePermissionTo(['view product', 'view product category']);

        $constructionSupervisor = Role::firstOrCreate(['name' => 'CONSTRUCTION_SUPERVISOR', 'guard_name' => 'api']);
        $constructionSupervisor->givePermissionTo(['view product', 'view product category']);
    }
}