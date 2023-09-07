<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create([
            'name' => 'Guatemala Prueba',
            'code' => 'T_GT_AGROCENTRO_2016_U',
        ]);

        Country::create([
            'name' => 'Honduras Prueba',
            'code' => 'T_HN_AGROCENTRO_2016',
        ]);

        Country::create([
            'name' => 'El Salvador Prueba',
            'code' => 'T_SV_AGROCENTRO_2016',
        ]);
    }
}
