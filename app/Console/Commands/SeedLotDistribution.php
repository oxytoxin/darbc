<?php

namespace App\Console\Commands;

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
        // $this->revertLotDistributionInitialChanges();
        return Command::SUCCESS;
    }

    private function revertLotDistributionInitialChanges()
    {
        Schema::dropIfExists('land_documents');
        Schema::dropIfExists('map_images');
        Schema::dropIfExists('lot_information');
        Schema::dropIfExists('block_addresses');
        Schema::dropIfExists('area_addresses');
        Schema::dropIfExists('lot_addresses');
        $model_files = [
            app_path('Models/AreaAddress.php'),
            app_path('Models/BlockAddress.php'),
            app_path('Models/LandDocuments.php'),
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
            database_path('migrations/2023_01_16_145736_create_land_documents_table.php'),
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
