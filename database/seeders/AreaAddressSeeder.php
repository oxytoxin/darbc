<?php

namespace Database\Seeders;

use App\Models\AreaAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $villages = [
            ['area' => 'Village 1'],
            ['area' => 'Village 2'],
            ['area' => 'Village 3'],
            ['area' => 'Village 4A'],
            ['area' => 'Village 4B'],
            ['area' => 'Village 4C'],
            ['area' => 'Village 5'],
            ['area' => 'Village 6'],
            ['area' => 'Village 7'],
            ['area' => 'Village 8'],
            ['area' => 'Village 9'],
            ['area' => 'Village 10'],
            ['area' => 'Village 11'],
            ['area' => 'Village 12'],
            ['area' => 'Village 13'],
            ['area' => 'Village 14'],
            ['area' => 'Village 15'],
        ];

        foreach ($villages as $key => $value) {
            AreaAddress::create($value);
        }
    }
}
