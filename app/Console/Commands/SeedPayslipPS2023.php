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
                $items = [
                    ['title' => 'Interest on Share Capital', 'amount' => filled($data['Interest on Share Capital']) ? $data['Interest on Share Capital'] : 0],
                    ['title' => 'Patronage Refund', 'amount' => filled($data['Patronage Refund']) ? $data['Patronage Refund'] : 0],
                    ['title' => "Member's Benefit", 'amount' => filled($data["Member's Benefit"]) ? $data["Member's Benefit"] : 0],
                    ['title' => 'Meal Allowance', 'amount' => filled($data['Meal Allowance']) ? $data['Meal Allowance'] : 0],
                ];
                $entry = $payslip->payslip_entries()->create([
                    'member_name' => $data["MEMBERS' NAME"],
                    'content' => [
                        'items' => $items,
                        'total' => [
                            'title' => 'Total Profit Share', 'amount' => collect($items)->sum('amount')
                        ],
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
