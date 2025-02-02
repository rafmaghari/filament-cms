<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SalesRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = Role::firstOrCreate(['name' => 'sales']);
        $permissions = [
            'manage orders',
            'view orders',
        ];

        $sales->revokePermissionTo($permissions);
        $sales->givePermissionTo($permissions);
    }
}
