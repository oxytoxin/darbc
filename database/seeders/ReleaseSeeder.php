<?php

namespace Database\Seeders;

use App\Models\Release;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReleaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Release::create([
            'name' => 'Pamaskong Handog 2022',
            'gift_certificate_prefix' => 'PS2023',
            'gift_certificate_amount' => 1000,
            'total_amount' => 15130000,
            'particulars' => [
                'Calendar' => '1 set',
                'Pineapple Products' => '2 cans',
            ],
        ]);
    }
}
