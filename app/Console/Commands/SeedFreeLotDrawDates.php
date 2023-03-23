<?php

namespace App\Console\Commands;

use App\Models\FreeLot;
use Illuminate\Console\Command;
use Spatie\SimpleExcel\SimpleExcelReader;

class SeedFreeLotDrawDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:freelot-draw-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates free lot records with appropriate draw dates from csv.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->output->writeln("Updating free lot draw dates...");
        // $this->output->progressStart(8615);
        // $rows = SimpleExcelReader::create(
        //     storage_path('csv/free-lot-draws.csv')
        // )->getRows();
        // $current_date = '';
        // $rows->each(function ($data) use (&$current_date) {
        //     if ($data['DRAWDATE'] && !$data['MEMBER']) {
        //         try {
        //             $date_string = preg_replace('/(Day|DAY) [0-9]+/', '', $data['DRAWDATE']);
        //             $current_date = date_format(
        //                 date_create(trim($date_string)),
        //                 'Y-m-d'
        //             );
        //         } catch (\Throwable $e) {
        //             echo $e->getMessage();
        //             abort(500);
        //         }
        //     }
        //     if ($data['DARBCID']) {
        //         $fl = FreeLot::whereHas('user', function ($query) use ($data) {
        //             $query->whereRelation('member_information', 'darbc_id', $data['DARBCID']);
        //         })->first();
        //         $fl->update([
        //             'draw_date' => $current_date,
        //         ]);
        //         $this->output->progressAdvance();
        //     }
        // });
        // $this->output->writeln("Draw dates for free lots updated!");
        return Command::SUCCESS;
    }
}
