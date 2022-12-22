<?php

namespace App\Console\Commands;

use App\Models\Dividend;
use Illuminate\Console\Command;

class UpdateDividendClaimType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dividends:claim_type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates dividend claim types for SPA/Representatives';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dividends = Dividend::with(['user.member_information'])->whereNotNull('claimed_by')->get();
        $claimedBySPA = $dividends->filter(function ($dividend) {
            return collect($dividend->user->member_information->spa)->contains($dividend->claimed_by);
        });
        $claimedBySPA->each(function ($dividend) {
            $dividend->update([
                'claim_type' => 2
            ]);
        });
        $claimedByRepresentative = $dividends->filter(function ($dividend) {
            return !collect($dividend->user->member_information->spa)->contains($dividend->claimed_by);
        });
        $claimedByRepresentative->each(function ($dividend) {
            $dividend->update([
                'claim_type' => 3
            ]);
        });
        return Command::SUCCESS;
    }
}
