<?php

namespace App\Console\Commands;

use App\Models\FreeLot;
use Illuminate\Console\Command;
use App\Models\MemberInformation;

class ReplaceFreeLotDeceasedWithActiveMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'free_lot:update_member_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace member information of free lots for deceased members to their active replacements.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $free_lots = FreeLot::whereRelation('user.member_information', 'status', 2)->with('user.member_information')->get();
        foreach ($free_lots as $free_lot) {
            $active_member = MemberInformation::whereLineageIdentifier($free_lot->user->member_information->lineage_identifier)
                ->whereStatus(MemberInformation::STATUS_ACTIVE)
                ->first();
            if ($active_member) {
                $free_lot->update([
                    'user_id' => $active_member->user_id
                ]);
            }
        }
        return Command::SUCCESS;
    }
}
