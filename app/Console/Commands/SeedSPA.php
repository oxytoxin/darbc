<?php

namespace App\Console\Commands;

use App\Models\MemberInformation;
use Illuminate\Console\Command;
use Spatie\SimpleExcel\SimpleExcelReader;

class SeedSPA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:spa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds SPA';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->output->writeln("Seeding SPA...");
        $rows = SimpleExcelReader::create(storage_path('csv/spa.csv'))->getRows();
        $this->output->progressStart(730);
        $rows->each(function ($data) {
            $matches = [];
            preg_match('/SPA.+/', $data['NAME'], $matches);
            if (count($matches)) {
                $spa_name = $matches[0];
                $spa_name = preg_replace("/(\/)|(SPA)/", '', $spa_name);
                MemberInformation::where('darbc_id', $data['DARBC ID'])->update(['spa' => [strtoupper(trim($spa_name))]]);
            }
            $this->output->progressAdvance();
        });
        return Command::SUCCESS;
    }
}
