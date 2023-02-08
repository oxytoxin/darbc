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
        Schema::dropIfExists('land_documents');
        Schema::dropIfExists('map_images');
        Schema::dropIfExists('lot_information');
        Schema::dropIfExists('block_addresses');
        Schema::dropIfExists('area_addresses');
        Schema::dropIfExists('lot_addresses');
        return Command::SUCCESS;
    }
}
