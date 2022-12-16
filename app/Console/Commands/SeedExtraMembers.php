<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Gender;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Spatie\SimpleExcel\SimpleExcelReader;

class SeedExtraMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:extra';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds additional members';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->output->writeln("Seeding extra members...");
        $rows = SimpleExcelReader::create(storage_path('csv/extra-members.csv'))->getRows();
        $this->output->progressStart(60);
        $rows->each(function (array $data) {

            $names = array_map('trim', explode('/', $data["NAME"]));
            $darbc_segments = explode('.', $data["DARBC ID"]);
            $darbc_id = $darbc_segments[0];
            $original_user = User::with('member_information')->whereRelation('member_information', 'darbc_id', $darbc_id)->whereRelation('member_information', 'is_darbc_member', true)->first();
            $succession = $darbc_segments[1] - 1;
            $lineage_identifier = $original_user->member_information->lineage_identifier;

            foreach ($names as $key => $name) {
                $status = 1;

                if (count($names) > 1) {
                    if (preg_match('/Dec./', $name))
                        $status = 2;
                    else
                        $status = 3;
                    if ($key == count($names) - 1) {
                        $status = 1;
                    }
                }

                $name = trim(preg_replace('/([\s]*(on)?[Hh]old.+)|([\s]*[0-9]+[\s]*%)|([\s]*[^\/a-zA-ZÑñ,\-\s.].+)|([\s]*[Cc]\?[Oo].+)|(Dec.)/', '', $name));
                $name = trim(preg_replace('/ \-/', '', $name));
                $segments = array_map('trim', explode(',', $name));

                if (count($segments) > 2) {
                    $lastname = $segments[0];
                    unset($segments[0]);
                    $segments = [$lastname, implode(' ', $segments)];
                }

                if (count($segments) > 1) {
                    try {
                        $surname = $segments[0];
                        $firstname = $segments[1];
                    } catch (\Throwable $th) {
                        dd($name);
                    }
                } else {
                    $matches = [];
                    preg_match('/[A-Z]\./', $name, $matches);
                    if (!count($matches)) {
                        $segments = explode(' ', $name);
                        $surname = $segments[count($segments) - 1];
                        unset($segments[count($segments) - 1]);
                        $firstname = implode(' ', $segments);
                    } else {
                        $segments = preg_split('/[A-Z]\./', $name);
                        $firstname = implode(' ', [$segments[0], $matches[0]]);
                        $surname = $segments[1];
                    }
                }

                $percentages = [];
                $percentage = 100;
                if (preg_match('/[\s]*[0-9]+(\.[0-9]+)?[\s]*%/', $data["PERCENTAGE"], $percentages))
                    $percentage = preg_replace('/[^0-9.]/', '', $percentages[0]);
                $firstname = mb_strtoupper(trim(preg_replace('/-$/', '', $firstname)), 'UTF-8');
                $surname = mb_strtoupper(trim($surname), 'UTF-8');

                $user = User::make([
                    'reference_name' => $data["NAME"],
                    'first_name' => $firstname,
                    'surname' => $surname,
                    'username' => str($firstname . ' ' . $surname . ' ' . Str::random(5))->slug('-'),
                    'password' => '$2y$10$X6oT7o3qGEaegt.BvKqJCubW/KKl2/zk2I/B8Nb/2uYWpnjHtKBVq',
                ]);
                $user->save();

                $member = MemberInformation::make();
                $member->user_id = $user->id;
                $member->is_darbc_member = false;
                $member->reference_number = $data["DARBC ID"];
                $member->split_claim = true;
                $member->percentage = $percentage;
                $member->gender_id = Gender::UNKNOWN;
                $member->occupation_id = 5;
                $member->spa = $data['SPA'] ? [$data['SPA']] : [];

                $member->lineage_identifier = $lineage_identifier;
                $member->succession_number = $succession;
                $member->original_member_id = $original_user->id;
                $member->membership_status_id = MembershipStatus::REPLACEMENT;
                $member->darbc_id = $darbc_id;
                $member->status = $status;
                $member->children = [];

                $member->save();
                $succession += 1;
            }
            $this->output->progressAdvance();
        });
        $this->output->writeln("Extra members seeded successfully!");
        return Command::SUCCESS;
    }
}
