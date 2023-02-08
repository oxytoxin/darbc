<?php

namespace App\Console\Commands;

use App\Models\FreeLot;
use App\Models\MemberInformation;
use DB;
use Illuminate\Console\Command;
use Schema;
use Spatie\SimpleExcel\SimpleExcelReader;

class SeedLotDistribution extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:lot_distribution';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Seeds lot distribution';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->revertLotDistributionInitialChanges();
        $this->correctDARBCID();
        $this->output->writeln("Seeding Free Lot Distribution...");
        $this->output->progressStart(7565);
        $rows = SimpleExcelReader::create(storage_path('csv/free-lot-masterlist.csv'))->getRows();
        DB::beginTransaction();
        $rows->each(function ($data) {
            try {
                FreeLot::create([
                    'user_id' => MemberInformation::firstWhere('darbc_id', trim($data['DARBCID']))->user_id,
                    'cluster_id' => filled(trim($data['CLUSTER'])) ? trim($data['CLUSTER']) : null,
                    'reference_name' => filled(trim($data['NAME'])) ? trim($data['NAME']) : null,
                    'block' => filled(trim($data['BLOCK'])) ? trim($data['BLOCK']) : null,
                    'lot' => filled(trim($data['LOT'])) ? trim($data['LOT']) : null,
                    'area' => filled(trim($data['AREA'])) ? strtoupper(trim($data['AREA'])) : null,
                    'status' => match (strtoupper(trim($data['STATUS']))) {
                        'SOLD' => 2,
                        'RELOCATE' => 3,
                        'SWAP' => 4,
                        default => 1,
                    },
                    'buyer' => filled(trim($data['BUYER'])) ? trim($data['BUYER']) : null,
                    'sold_at' => filled(trim($data['DATE'])) ? trim($data['DATE']) : null,
                    'draw_date' => filled(trim($data['DRAW DATE'])) ? trim($data['DRAW DATE']) : null,
                ]);
            } catch (\Throwable $th) {
                dd($data, $th->getMessage());
            }
            $this->output->progressAdvance();
        });

        DB::commit();
        return Command::SUCCESS;
    }

    private function correctDARBCID()
    {
        MemberInformation::find(6020)->update([
            'darbc_id' => 4262,
        ]);
        MemberInformation::find(6021)->update([
            'darbc_id' => 4262,
        ]);
        MemberInformation::find(9949)->update([
            'darbc_id' => 7068,
        ]);
    }

    private function revertLotDistributionInitialChanges()
    {
        Schema::dropIfExists('map_images');
        Schema::dropIfExists('lot_information');
        Schema::dropIfExists('block_addresses');
        Schema::dropIfExists('area_addresses');
        Schema::dropIfExists('lot_addresses');
        $model_files = [
            app_path('Models/AreaAddress.php'),
            app_path('Models/BlockAddress.php'),
            app_path('Models/LotAdress.php'),
            app_path('Models/LotInformation.php'),
            app_path('Models/MapImage.php'),
        ];
        $migration_files = [
            database_path('migrations/2022_01_12_124342_create_block_addresses_table.php'),
            database_path('migrations/2023_01_12_124344_create_lot_addresses_table.php'),
            database_path('migrations/2023_01_12_124345_create_area_addresses_table.php'),
            database_path('migrations/2023_01_12_154342_create_lot_information_table.php'),
            database_path('migrations/2023_01_16_103631_create_map_images_table.php'),
        ];
        foreach ($model_files as $key => $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
        foreach ($migration_files as $key => $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
