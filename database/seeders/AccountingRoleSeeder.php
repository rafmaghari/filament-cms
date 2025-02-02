<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AccountingRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounting = Role::firstOrCreate(['name' => 'accounting']);
        $permissions = [
            'manage orders',
            'view orders',
        ];

        $accounting->revokePermissionTo($permissions);
        $accounting->givePermissionTo($permissions);
    }
}
