<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // User permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        // Role permissions
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);

        // Permissions permissions
        Permission::create(['name' => 'view permissions']);

        // Category permissions
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);

        // Tag permissions
        Permission::create(['name' => 'view tags']);
        Permission::create(['name' => 'create tags']);
        Permission::create(['name' => 'edit tags']);
        Permission::create(['name' => 'delete tags']);

        // Item permissions
        Permission::create(['name' => 'view items']);
        Permission::create(['name' => 'create items']);
        Permission::create(['name' => 'edit items']);
        Permission::create(['name' => 'delete items']);

        // Domain permissions
        Permission::create(['name' => 'view domains']);
        Permission::create(['name' => 'create domains']);
        Permission::create(['name' => 'edit domains']);
        Permission::create(['name' => 'delete domains']);

        // Domain Type permissions
        Permission::create(['name' => 'view domain-types']);
        Permission::create(['name' => 'create domain-types']);
        Permission::create(['name' => 'edit domain-types']);
        Permission::create(['name' => 'delete domain-types']);

        // Ticket Permissions
        Permission::create(['name' => 'view tickets']);
        Permission::create(['name' => 'create tickets']);
        Permission::create(['name' => 'edit tickets']);
        Permission::create(['name' => 'delete tickets']);

        // Orders Permissions
        Permission::create(['name' => 'manage orders']);
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'edit orders']);
        Permission::create(['name' => 'delete orders']);

        // Warranty Permissions
        Permission::create(['name' => 'manage warranty']);
        Permission::create(['name' => 'view warranty']);
        Permission::create(['name' => 'create warranty']);
        Permission::create(['name' => 'edit warranty']);
        Permission::create(['name' => 'delete warranty']);

        // Media Permissions
        Permission::create(['name' => 'manage media']);
        Permission::create(['name' => 'view media']);
        Permission::create(['name' => 'create media']);
        Permission::create(['name' => 'edit media']);
        Permission::create(['name' => 'delete media']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'creator']);
        $role->givePermissionTo([
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            'view tags',
            'create tags',
            'edit tags',
            'delete tags',

            'view items',
            'create items',
            'edit items',
            'delete items',

            'view domains',
            'create domains',
            'edit domains',
            'delete domains',

            'view domain-types',
            'create domain-types',
            'edit domain-types',
            'delete domain-types',

            'view tickets',
            'create tickets',
            'edit tickets',
            'delete tickets',
        ]);

        $role = Role::create(['name' => 'developer']);

        $role = Role::create(['name' => 'member']);
        $role->givePermissionTo([
            'view categories',
            'view tags',
            'view items',
            'view domains',
            'view tickets',
        ]);

        // Dealer Role
        $role = Role::create(['name' => 'dealer']);
        $role->givePermissionTo([
            'view domains',
            'manage warranty',
            'view warranty',
            'create warranty',
            'edit warranty',
            'delete warranty',
        ]);

        // Manufacturer Role
        $role = Role::create(['name' => 'manufacturer']);
        $role->givePermissionTo([
            'view domains',
            'view warranty',
        ]);
    }
}
