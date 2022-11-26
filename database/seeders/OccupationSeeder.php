<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Occupation::create([
            'name' => 'Active DoleFil Employee',
        ]);

        Occupation::create([
            'name' => 'Special Voluntary Retirement',
        ]);

        Occupation::create([
            'name' => 'Retired',
        ]);

        Occupation::create([
            'name' => 'Others',
        ]);
    }
}
