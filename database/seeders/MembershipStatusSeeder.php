<?php

namespace Database\Seeders;

use App\Models\MembershipStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MembershipStatus::create([
            'name' => 'Original',
        ]);

        MembershipStatus::create([
            'name' => 'Replacement',
        ]);
    }
}
