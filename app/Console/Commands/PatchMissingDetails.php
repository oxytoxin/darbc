<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MemberInformation;

class PatchMissingDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patch:missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replaces empty strings to null in member information table.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->output->writeln("Patching missing details...");
        MemberInformation::where('spouse', '')->update(['spouse' => null]);
        MemberInformation::where('address_line', '')->update(['address_line' => null]);
        MemberInformation::where('mother_maiden_name', '')->update(['mother_maiden_name' => null]);
        MemberInformation::where('sss_number', '')->update(['sss_number' => null]);
        MemberInformation::where('philhealth_number', '')->update(['philhealth_number' => null]);
        MemberInformation::where('tin_number', '')->update(['tin_number' => null]);
        MemberInformation::where('contact_number', '')->update(['contact_number' => null]);
        MemberInformation::where('blood_type', '')->orWhereNull('blood_type')->update(['blood_type' => 'Unknown']);
        MemberInformation::where('religion', '')->update(['religion' => null]);
        $this->output->writeln("Done!");
        return Command::SUCCESS;
    }
}
