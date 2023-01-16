<?php

namespace Database\Seeders;

use App\Models\BlockAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlockAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 29; $i++) {
            DB::table('block_addresses')->insert([
                'block' => $i,
            ]);
        }
    }
}
