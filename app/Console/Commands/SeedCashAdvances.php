<?php

namespace App\Console\Commands;

use App\Models\CashAdvance;
use Illuminate\Console\Command;
use App\Models\MemberInformation;
use DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class SeedCashAdvances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:cash-advances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds cash advances';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rows = SimpleExcelReader::create(storage_path('csv/cash-advances.csv'))->getRows();
        $count = SimpleExcelReader::create(storage_path('csv/cash-advances.csv'))->getRows()->count();
        $this->output->info("Seeding Cash Advances.");
        $this->output->info("Processing {$count} rows...");
        $this->output->progressStart($count);
        DB::beginTransaction();
        $rows->each(function ($data) {
            if ($data["DARBC ID"]) {
                $user_id = MemberInformation::whereDarbcId($data["DARBC ID"])->first()->user_id;
                CashAdvance::create([
                    'user_id' => $user_id,
                    'purpose' => $data['PURPOSE'] ?? null,
                    'illness' => $data['ILLNESS'] ?? null,
                    'contact_number' => $data['CONTACT NUMBER'] ?? null,
                    'account_amount' => filled($data['ACCOUNT']) ? $data['ACCOUNT'] : null,
                    'requested_amount' => filled($data['REQUESTED AMOUNT']) ? $data['REQUESTED AMOUNT'] : null,
                    'approved_amount' => filled($data['APPROVED AMOUNT']) ? $data['APPROVED AMOUNT'] : null,
                    'date_received' => filled($data['DATE RECEIVED']) ? $data['DATE RECEIVED'] : null,
                    'date_approved' => filled($data['DATE APPROVED']) ? $data['DATE APPROVED'] : null,
                    'remarks' => $data['REMARKS'] ?? null,
                    'other_details' => [
                        'pera_padala' => [
                            'principal' => $data['PERA PADALA PRINCIPAL AMOUNT'] ?? null,
                            'rate' => $data['PERA PADALA RATE'] ?? null,
                            'net_amount' => $data['PERA PADALA NET AMOUNT'] ?? null,
                        ]
                    ]
                ]);
            }
            $this->output->progressAdvance();
        });
        DB::commit();
        $this->output->info("Done seeding.");
        $this->output->writeln("");
        return Command::SUCCESS;
    }
}
