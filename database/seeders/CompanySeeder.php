<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('companies')->truncate();
        Schema::enableForeignKeyConstraints();

        Company::create([
            'id' => 1,
            'name' => 'On The Move Caravans',
            'domain' => 'onthemovecaravans.com.au',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sit amet nulla nulla. Donec luctus lorem justo, ut ullamcorper eros pellentesque ut',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Company::create([
            'id' => 2,
            'name' => 'MyDream RV',
            'domain' => 'mydreamrv.com.au',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sit amet nulla nulla. Donec luctus lorem justo, ut ullamcorper eros pellentesque ut',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
