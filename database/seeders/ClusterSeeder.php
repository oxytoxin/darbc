<?php

namespace Database\Seeders;

use App\Models\Cluster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cluster::create([
            'name' => 'Cluster 1',
            'leader_id' => 1,
        ]);
        Cluster::create([
            'name' => 'Cluster 2',
            'leader_id' => 1,
        ]);
    }
}
