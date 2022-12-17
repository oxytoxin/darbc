<?php

namespace App\Console\Commands;

use App\Models\Release;
use Illuminate\Console\Command;
use Spatie\SimpleExcel\SimpleExcelReader;

class SeedUnclaimedReleases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:unclaimed_releases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed unclaimed releases';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->output->writeln("Seeding Unclaimed Releases...");
        // $rows = SimpleExcelReader::create(storage_path('csv/unclaimed_releases.csv'))->getRows();
        // $rows->each(function ($data) {
        //     Release::create([
        //         'name' => $data["NAME"],
        //         'total_amount' => $data["AMOUNT"],
        //         'created_at' => date_create('01/01/' . $data["DATE"]),
        //         'updated_at' => date_create('01/01/' . $data["DATE"]),
        //         'disbursed' => true,
        //     ]);
        // });
        return Command::SUCCESS;
    }
}
