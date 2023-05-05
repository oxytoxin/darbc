<?php

namespace App\Console\Commands;

use App\Models\MemberInformation;
use Illuminate\Console\Command;
use Spatie\SimpleExcel\SimpleExcelReader;

class UpdateInformationNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates informational numbers such as SSS, TIN, PhilHealth.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->output->writeln("Processing SSS...");
        $this->processSSS();
        $this->output->writeln("Processing TIN...");
        $this->processTIN();
        $this->output->writeln("Processing PhilHealth...");
        $this->processPH();
        $this->output->writeln("Processing Contact numbers...");
        $this->processContact();
        return Command::SUCCESS;
    }

    private function processSSS()
    {
        $rows = SimpleExcelReader::create(storage_path('csv/infonumbers.csv'))->getRows();
        $members = MemberInformation::query()->orderBy('darbc_id')->where('sss_number', 'like', '%E+%')->cursor();
        $members->each(function ($m) use ($rows) {
            $sss = $rows->firstWhere('DARBCID', $m->darbc_id)["SSS"];
            $m->update([
                'sss_number' => $sss,
            ]);
        });
    }

    private function processTIN()
    {
        $rows = SimpleExcelReader::create(storage_path('csv/infonumbers.csv'))->getRows();
        $members = MemberInformation::query()->orderBy('darbc_id')->where('tin_number', 'like', '%E+%')->cursor();
        $members->each(function ($m) use ($rows) {
            $tin = $rows->firstWhere('DARBCID', $m->darbc_id)["TIN"];
            $m->update([
                'tin_number' => $tin,
            ]);
        });
    }

    private function processPH()
    {
        $rows = SimpleExcelReader::create(storage_path('csv/infonumbers.csv'))->getRows();
        $members = MemberInformation::query()->orderBy('darbc_id')->where('philhealth_number', 'like', '%E+%')->cursor();
        $members->each(function ($m) use ($rows) {
            $ph = $rows->firstWhere('DARBCID', $m->darbc_id)["PHILHEALTH"];
            $m->update([
                'philhealth_number' => $ph,
            ]);
        });
    }

    private function processContact()
    {
        $rows = SimpleExcelReader::create(storage_path('csv/infonumbers.csv'))->getRows();
        $members = MemberInformation::query()->orderBy('darbc_id')->where('contact_number', 'like', '%E+%')->cursor();
        $members->each(function ($m) use ($rows) {
            $contact = $rows->firstWhere('DARBCID', $m->darbc_id)["CONTACT"];
            $m->update([
                'contact_number' => $contact,
            ]);
        });
    }
}
