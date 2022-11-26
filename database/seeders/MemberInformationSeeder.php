<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\MemberInformation;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $barangay = Barangay::inRandomOrder()->first();
        DB::beginTransaction();
        MemberInformation::factory()->count(100)->create([
            'region_code' => $barangay->region_code,
            'province_code' => $barangay->province_code,
            'city_code' => $barangay->city_code,
            'barangay_code' => $barangay->code,
        ]);
        DB::commit();
    }
}
