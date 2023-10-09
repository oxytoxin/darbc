<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Spatie\SimpleExcel\SimpleExcelReader;

class UpdateAddressesAndOriginalMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:addresses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates member addresses and original members';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        MemberInformation::whereIsDarbcMember(true)->update(['membership_status_id' => MembershipStatus::ORIGINAL]);
        $rows = SimpleExcelReader::create(storage_path('csv/addresses.xlsx'))->getRows();
        $rows->each(function ($row) {
            MemberInformation::whereDarbcId($row['darbc_id'])->update([
                'address_line' => $row['address']
            ]);
        });
        DB::commit();
        return Command::SUCCESS;
    }
}
