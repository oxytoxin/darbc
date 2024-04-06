<?php

namespace App\Console\Commands;

use App\Models\Payslip;
use DB;
use Illuminate\Console\Command;
use Spatie\SimpleExcel\SimpleExcelReader;

class SeedPayslipPS2023 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:ps2023';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed payslips for PS2023';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        $payslip = Payslip::create([
            'release_id' => 31
        ]);
        $rows = SimpleExcelReader::create(storage_path('csv/imports/ps2023forga.xlsx'), 'xlsx')->getRows();
        $rows->each(function ($data) use ($payslip) {
            try {
                $items = [];
                $entries = [
                    ['title' => 'Interest on Share Capital', 'amount' => filled($data['Interest on Share Capital']) ? $data['Interest on Share Capital'] : 0],
                    ['title' => 'Patronage Refund', 'amount' => filled($data['Patronage Refund']) ? $data['Patronage Refund'] : 0],
                ];
                $items[] = [
                    'title' => 'Profit Share 2023',
                    'entries' => $entries,
                    'total' =>  [
                        'title' => 'Total Profit Share', 'amount' => collect($entries)->sum('amount')
                    ]
                ];
                $entries = [
                    ['title' => "Calamity Assistance", 'amount' => filled($data["Calamity Assistance"]) ? $data["Calamity Assistance"] : 0],
                    ['title' => 'Meal Allowance', 'amount' => filled($data['Meal Allowance']) ? $data['Meal Allowance'] : 0],
                ];
                $items[] = [
                    'title' => 'Add:',
                    'entries' => $entries,
                    'total' =>  [
                        'title' => "Total Member's Benefit", 'amount' => collect($entries)->sum('amount')
                    ]
                ];
                $entry = $payslip->payslip_entries()->create([
                    'member_name' => $data["MEMBERS' NAME"],
                    'content' => [
                        'items' => $items,
                        'extra' => [
                            ['title' => 'Gift Certificate', 'amount' => '(worth P1,000)'],
                            ['title' => 'Giveaways (Bedsheet with Pillow Case)', 'amount' => '1 set'],
                            ['title' => 'Souvenir Program (Annual Report)', 'amount' => '1 pc'],
                        ]
                    ]
                ]);
            } catch (\Throwable $th) {
                dd($data);
            }
        });
        DB::commit();
        return Command::SUCCESS;
    }
}
