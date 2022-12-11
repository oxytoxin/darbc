<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Gender;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use App\Models\Occupation;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class SeedMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds members';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->output->writeln("Seeding members...");
        $rows = SimpleExcelReader::create(storage_path('csv/members.csv'))->getRows();
        $this->output->progressStart(7565);
        $rows->each(function (array $data) {
            $names = array_map('trim', explode('/', $data["MEMBERS' NAME"]));
            $lineage_identifier = Str::random(10);
            $percentages = [];
            $percentage = 100;
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

                if (preg_match('/[\s]*[0-9]+(\.[0-9]+)?[\s]*%/', $name, $percentages))
                    $percentage = preg_replace('/[^0-9.]/', '', $percentages[0]);

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

                $firstname = mb_strtoupper(trim(preg_replace('/-$/', '', $firstname)), 'UTF-8');
                $surname = mb_strtoupper(trim($surname), 'UTF-8');


                $user = User::make([
                    'reference_name' => $data["MEMBERS' NAME"],
                    'first_name' => $firstname,
                    'surname' => $surname,
                    'username' => str($firstname . ' ' . $surname . ' ' . Str::random(5))->slug('-'),
                    'password' => '$2y$10$X6oT7o3qGEaegt.BvKqJCubW/KKl2/zk2I/B8Nb/2uYWpnjHtKBVq',
                ]);
                $user->save();

                $member = MemberInformation::make();
                $member->user_id = $user->id;
                $member->percentage = $percentage;
                $member->membership_status_id = ($key == 0 && $data["MEMBER STATUS"] != "REPLACEMENT") ? MembershipStatus::ORIGINAL : MembershipStatus::REPLACEMENT;

                if ($key == count($names) - 1) {
                    $member->date_of_birth = (filled($data["DATE OF BIRTH"]) && date_create($data["DATE OF BIRTH"])) ? date_create($data["DATE OF BIRTH"]) : null;
                    $member->place_of_birth = strtoupper(trim($data["PLACE OF BIRTH"])) ?? null;
                    $member->mother_maiden_name = strtoupper(trim($data["MOTHER'S MAIDEN NAME"])) ?? null;
                    $member->blood_type = strtoupper(trim($data["BLOOD TYPE"]));
                    $member->religion = strtoupper(trim($data["RELIGION"]));
                    $member->sss_number = $data["SSS"];
                    $member->philhealth_number = $data["PHILHEALTH #"];
                    $member->tin_number = $data["TIN"];
                    $member->contact_number = $data["CONTACT #"];

                    if (intval($data["CLUSTER #"]))
                        $member->cluster_id = $data["CLUSTER #"];
                    else
                        $member->cluster_id = null;
                    if ($data["DATE"])
                        $member->application_date = date_create($data["DATE"]) ? date_create($data["DATE"]) : today();
                    else
                        $member->application_date = now();

                    $member->spouse = strtoupper(trim($data["NAME OF SPOUSE"]));

                    if ($data["OCCUPATION"]) {
                        switch (trim(strtoupper($data["OCCUPATION"]))) {
                            case 'ACTIVE DOLEFIL EMPLOYEE':
                                $member->occupation_id = 1;
                                break;
                            case 'SPECIAL VOLUNTARY RETIREMENT':
                                $member->occupation_id = 2;
                                break;
                            case 'RETIRED':
                                $member->occupation_id = 3;
                                break;
                            default:
                                $member->occupation_id = 4;
                                $member->occupation_details = $data["OCCUPATION"];
                                break;
                        }
                    } else {
                        $member->occupation_id = 5;
                    }

                    switch (trim(strtoupper($data["GENDER"]))) {
                        case 'MALE':
                            $member->gender_id = Gender::MALE;
                            break;
                        case 'FEMALE':
                            $member->gender_id = Gender::FEMALE;
                            break;
                        default:
                            $member->gender_id = Gender::UNKNOWN;
                            break;
                    }

                    switch (trim(strtoupper($data["CIVIL STATUS"]))) {
                        case 'SINGLE':
                            $member->civil_status = MemberInformation::CS_SINGLE;
                            break;
                        case 'MARRIED':
                            $member->civil_status = MemberInformation::CS_MARRIED;
                            break;
                        case 'WIDOW':
                            $member->civil_status = MemberInformation::CS_WIDOW;
                            break;
                        case 'LEGALLY SEPARATED':
                            $member->civil_status = MemberInformation::CS_LEGALLY_SEPARATED;
                            break;
                        default:
                            $member->civil_status = MemberInformation::CS_UNKNOWN;
                            break;
                    }
                } else {
                    $member->gender_id = Gender::UNKNOWN;
                    $member->occupation_id = 5;
                }
                $member->lineage_identifier = $lineage_identifier;
                $member->succession_number = ($key == 0 && $data["MEMBER STATUS"] == "REPLACEMENT") ? 1 : $key;
                if ($key > 0) {
                    $member->original_member_id = $original_member_id ?? null;
                }
                $member->darbc_id = $data["DARBC ID #"];
                $member->status = $status;
                $member->children = [];

                $member->save();
                $original_member_id = $user->id;
            }
            $this->output->progressAdvance();
        });

        $this->output->writeln("Members seeded!");
        return Command::SUCCESS;
    }
}
