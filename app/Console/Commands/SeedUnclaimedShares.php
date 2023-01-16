<?php

namespace App\Console\Commands;

use App\Models\Dividend;
use App\Models\MemberInformation;
use App\Models\Release;
use Illuminate\Console\Command;
use Spatie\SimpleExcel\SimpleExcelReader;

class SeedUnclaimedShares extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:unclaimed_shares';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed unclaimed shares';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->output->writeln("Seeding Unclaimed Shares...");
        // $rows = SimpleExcelReader::create(storage_path('csv/unclaimed_shares.csv'))->getRows();
        // $this->output->progressStart(7630);
        // $rows->each(function ($data) {
        //     $member = MemberInformation::whereReferenceNumber($data["DARBC ID"])->whereStatus(MemberInformation::STATUS_ACTIVE)->first();
        //     if (!$member)
        //         dump($data["DARBC ID"] . ", " . $data["NAME"]);
        //     foreach ($data as $key => $value) {
        //         if (is_int($key) && is_numeric($value)) {
        //             Dividend::create([
        //                 'status' => Dividend::FOR_RELEASE,
        //                 'release_id' => $key,
        //                 'user_id' => $member->user_id,
        //                 'gross_amount' => $value,
        //                 'particulars' => [],
        //                 'restriction_entries' => [],
        //             ]);
        //         }
        //     }
        //     $this->output->progressAdvance();
        // });
        return Command::SUCCESS;
    }
}
