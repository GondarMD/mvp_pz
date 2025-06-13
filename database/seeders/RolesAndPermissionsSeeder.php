<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions

        // Products
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);
        // Categories
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);
        // Orders
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'edit orders']);
        Permission::create(['name' => 'delete orders']);
        // Users / Roles / Permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']); 
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'edit permissions']);     
        Permission::create(['name' => 'delete permissions']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::create(['name' => 'guest']);
        $role->givePermissionTo('view products');
        $role->givePermissionTo('view categories');
        $role->givePermissionTo('view orders');


        // or may be done by chaining
        $role = Role::create(['name' => 'authenticated']);
        $role->givePermissionTo(['view products', 'view categories', 'view orders', 'create orders', 'edit orders', 'delete orders']);

        $role = Role::create(['name' => 'product_manager']);
        $role->givePermissionTo(['view products', 'create products', 'edit products', 'delete products']);
        $role->givePermissionTo(['view categories', 'create categories', 'edit categories', 'delete categories']);

        $role = Role::create(['name' => 'order_manager']);
        $role->givePermissionTo(['view orders', 'create orders', 'edit orders', 'delete orders']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions'
        ]);
        
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

    }
}
