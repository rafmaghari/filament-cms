<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CompanyTypeSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('company_types')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('company_types')->insert([
            'id' => 1,
            'label' => 'Dealer',
            'name' => 'dealer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('company_types')->insert([
            'id' => 2,
            'label' => 'Manufacturer',
            'name' => 'manufacturer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
