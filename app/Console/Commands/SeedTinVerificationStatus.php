<?php

namespace App\Console\Commands;

use App\Models\MemberInformation;
use Illuminate\Console\Command;
use Spatie\SimpleExcel\SimpleExcelReader;

class SeedTinVerificationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-tin-verification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed TIN Verification';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->output->writeln("Seeding SPA...");
        $rows = SimpleExcelReader::create(storage_path('csv/tin.xlsx'))->getRows();
        $this->output->progressStart(7565);
        $rows->each(function ($data) {
            MemberInformation::where('status', 1)->where('darbc_id', $data['DARBC ID'])->update(['tin_verification_status' => $data['Remarks/TIN Verification']]);
            $this->output->progressAdvance();
        });
        return Command::SUCCESS;
    }
}
