<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\DealerLocation;
use Illuminate\Database\Seeder;

class DealerLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'company' => 'On The Move Caravans',
                'locations' => [
                    'Yatala',
                    'Townsville',
                    '4K RV Sydney',
                    'Carrum Downs',
                    'Adelaide Car Connection S.A',
                ],
            ],
            [
                'company' => 'MyDream RV',
                'locations' => [
                    'Gippsland RV & Marine',
                    'Rose RV',
                    'BMG Caravans',
                    'Everything RV',
                    'Coast to Country Caravans',
                    'Destiny RV SA',
                ],
            ],
        ];

        foreach ($data as $row) {
            $companyName = data_get($row, 'company');
            $locations = data_get($row, 'locations');

            if ($company = Company::where('name', $companyName)->first()) {
                foreach ($locations as $location) {
                    DealerLocation::firstOrCreate([
                        'location' => $location,
                        'company_id' => $company->id,
                    ]);
                }
            }
        }

    }
}
