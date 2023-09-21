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
        DB::beginTransaction();
        MemberInformation::factory()->count(20)->create();
        DB::commit();
    }
}
