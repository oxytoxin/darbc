<?php

namespace Database\Seeders;

use App\Models\Cluster;
use DB;
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
        $path = storage_path('csv/clusters-csv.csv');
        ini_set('auto_detect_line_endings', TRUE);
        $handle = fopen($path, 'r');
        DB::beginTransaction();
        while (($data = fgetcsv($handle)) !== FALSE) {
            Cluster::create([
                'id' => intval($data[0]),
                'name' => $data[0],
                'address' => $data[2],
            ]);
        }
        Cluster::create([
            'id' => 56,
            'name' => 56,
            'address' => '',
        ]);
        Cluster::create([
            'id' => 59,
            'name' => 59,
            'address' => '',
        ]);
        DB::commit();
    }
}
