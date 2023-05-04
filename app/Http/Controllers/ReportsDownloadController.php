<?php

namespace App\Http\Controllers;

use App\Models\Dividend;
use App\Models\MemberInformation;
use App\Models\MembershipStatus;
use App\Models\Release;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ReportsDownloadController extends Controller
{
    public function active_members()
    {
        $writer = SimpleExcelWriter::streamDownload(storage_path('app/livewire-tmp/ActiveMembers.xlsx'));
        $writer->addHeader([
            'DARBC ID',
            'NAME',
        ]);
        $members = MemberInformation::query()->with('user')->whereStatus(MemberInformation::STATUS_ACTIVE)->orderBy('darbc_id');
        $members->each(function ($member) use ($writer) {
            $writer->addRow([
                $member->darbc_id,
                $member->user->alt_full_name,
            ]);
        });
        $writer->toBrowser();
    }

    public function members()
    {
        $writer = SimpleExcelWriter::streamDownload(storage_path('app/livewire-tmp/Profiling.xlsx'))->addHeader([
            'DARBC ID',
            'Member Name',
            'Succession',
            'Status',
            'Percentage',
            'Cluster',
            'Date of Birth',
            'Place of Birth',
            'Gender',
            'Blood Type',
            'Religion',
            'Civil Status',
            'Occupation',
            'Contact Number',
            'SSS Number',
            'TIN Number',
            'PhilHealth Number',
            'SPA'
        ]);
        $members = MemberInformation::query()
            ->with(['user', 'cluster', 'gender', 'occupation'])
            ->orderBy('darbc_id');
        if (in_array(request('status'), ['active', 'original', 'replacement'])) {
            $members
                ->when(request('status') == 'active', fn ($query) => $query->whereStatus(MemberInformation::STATUS_ACTIVE))
                ->when(request('status') == 'original', fn ($query) => $query->whereMembershipStatusId(MembershipStatus::ORIGINAL))
                ->when(request('status') == 'replacement', fn ($query) => $query->whereMembershipStatusId(MembershipStatus::REPLACEMENT));
        }
        $members->each(function ($member) use ($writer) {
            $writer->addRow([
                $member->darbc_id,
                $member->user->alt_full_name,
                $member->succession_number == 0 ? 'Original' : ordinal($member->succession_number) . ' Successor',
                match ($member->status) {
                    MemberInformation::STATUS_ACTIVE => 'Active',
                    MemberInformation::STATUS_DECEASED => 'Deceased',
                    MemberInformation::STATUS_INACTIVE => 'Inactive',
                },
                $member->percentage,
                $member->cluster?->name,
                $member->date_of_birth?->format('m/d/Y'),
                $member->place_of_birth,
                $member->gender->name,
                $member->blood_type,
                $member->religion,
                match ($member->civil_status) {
                    1 => 'SINGLE',
                    2 => 'MARRIED',
                    3 => 'WIDOW',
                    4 => 'LEGALLY_SEPARATED',
                    5 => 'UNKNOWN',
                },
                $member->occupation_details ? $member->occupation?->name . ' - ' . $member->occupation_details : $member->occupation?->name,
                $member->contact_number,
                $member->sss_number,
                $member->tin_number,
                $member->philhealth_number,
                implode(', ', $member->spa),
            ]);
        });
        $writer->toBrowser();
    }

    public function releasesByCashier(User $cashier)
    {
        $release = Release::findOrFail(request('release_id'));
        $writer = SimpleExcelWriter::streamDownload($release->name . ' Releases from ' . $cashier->full_name . '.xlsx');
        $writer->addHeader([
            'DARBC ID',
            'Member Name',
            'Amount',
            'Released At',
        ]);
        Dividend::with(['user.member_information'])->whereReleasedBy($cashier->id)
            ->whereReleaseId(request('release_id'))
            ->whereStatus(Dividend::RELEASED)
            ->each(function ($dividend) use ($writer) {
                $writer->addRow([
                    $dividend->user->member_information->darbc_id,
                    $dividend->user->alt_full_name,
                    $dividend->net_amount,
                    $dividend->released_at->format('h:i a m/d/Y'),
                ]);
            });
        $writer->toBrowser();
    }

    public function voidedReleasesByCashier(User $cashier)
    {
        $release = Release::findOrFail(request('release_id'));
        $writer = SimpleExcelWriter::streamDownload($release->name . ' Voided Releases from ' . $cashier->full_name . '.xlsx');
        $writer->addHeader([
            'DARBC ID',
            'Member Name',
            'Amount',
            'Remarks',
            'Released At',
        ]);
        Dividend::with(['user.member_information'])->whereReleasedBy($cashier->id)
            ->whereReleaseId(request('release_id'))
            ->whereStatus(Dividend::RELEASED)
            ->whereVoided(true)
            ->each(function ($dividend) use ($writer) {
                $writer->addRow([
                    $dividend->user->member_information->darbc_id,
                    $dividend->user->alt_full_name,
                    $dividend->net_amount,
                    $dividend->remarks,
                    $dividend->released_at->format('h:i a m/d/Y'),
                ]);
            });
        $writer->toBrowser();
    }

    public function releasesByStatus(Release $release, int $status)
    {
        $filename = match ($status) {
            Dividend::FOR_RELEASE => $release->name . ' Overall Releases Unclaimed.xlsx',
            Dividend::ON_HOLD => $release->name . ' Overall Releases On-Hold.xlsx',
            Dividend::RELEASED => $release->name . ' Overall Releases.xlsx',
        };
        $writer = SimpleExcelWriter::streamDownload($filename);
        if ($status == Dividend::RELEASED) {
            $writer->addHeader([
                'DARBC ID',
                'Member Name',
                'Amount',
                'Cashier',
                'Released At',
            ]);
        }
        if ($status == Dividend::FOR_RELEASE) {
            $writer->addHeader([
                'DARBC ID',
                'Member Name',
                'Amount',
            ]);
        }
        if ($status == Dividend::ON_HOLD) {
            $writer->addHeader([
                'DARBC ID',
                'Member Name',
                'Amount',
                'Restrictions',
            ]);
        }

        Dividend::with(['user.member_information', 'cashier'])
            ->whereReleaseId($release->id)
            ->whereStatus($status)
            ->each(function ($dividend) use ($writer, $status) {
                if ($status == Dividend::RELEASED) {
                    $writer->addRow([
                        $dividend->user->member_information->darbc_id,
                        $dividend->user->alt_full_name,
                        $dividend->net_amount,
                        $dividend->cashier?->full_name,
                        $dividend->released_at->format('h:i a m/d/Y'),
                    ]);
                }
                if ($status == Dividend::FOR_RELEASE) {
                    $writer->addRow([
                        $dividend->user->member_information->darbc_id,
                        $dividend->user->alt_full_name,
                        $dividend->net_amount,
                    ]);
                }
                if ($status == Dividend::ON_HOLD) {
                    $writer->addRow([
                        $dividend->user->member_information->darbc_id,
                        $dividend->user->alt_full_name,
                        $dividend->net_amount,
                        implode(', ', $dividend->restriction_entries),
                    ]);
                }
            });
        $writer->toBrowser();
    }

    public function voidedReleases(Release $release)
    {
        $writer = SimpleExcelWriter::streamDownload($release->name . ' Overall Voided Releases.xlsx');
        $writer->addHeader([
            'DARBC ID',
            'Member Name',
            'Amount',
            'Cashier',
            'Released At',
            'Remarks',
        ]);
        Dividend::with(['user.member_information', 'cashier'])
            ->whereReleaseId($release->id)
            ->whereVoided(true)
            ->whereStatus(Dividend::RELEASED)
            ->each(function ($dividend) use ($writer) {
                $writer->addRow([
                    $dividend->user->member_information->darbc_id,
                    $dividend->user->alt_full_name,
                    $dividend->net_amount,
                    $dividend->cashier->full_name,
                    $dividend->released_at->format('h:i a m/d/Y'),
                    $dividend->remarks,
                ]);
            });
        $writer->toBrowser();
    }

    public function claimedReleasesByType(Release $release)
    {
        $claim_type = request('claim_type');
        $claim_type_name = match (intval($claim_type)) {
            1 => 'Member',
            2 => 'SPA',
            3 => 'Authorized Representative',
            default => 'Member',
        };
        $writer = SimpleExcelWriter::streamDownload($release->name . ' ' . $claim_type_name . ' Claimed Releases.xlsx');
        $writer->addHeader([
            'DARBC ID',
            'Member Name',
            'Amount',
            'Cashier',
            'Released At',
            'Claimed By ' . $claim_type_name,
        ]);
        Dividend::with(['user.member_information', 'cashier'])
            ->whereReleaseId($release->id)
            ->whereClaimType($claim_type)
            ->whereStatus(Dividend::RELEASED)
            ->each(function ($dividend) use ($writer) {
                $writer->addRow([
                    $dividend->user->member_information->darbc_id,
                    $dividend->user->alt_full_name,
                    $dividend->net_amount,
                    $dividend->cashier->full_name,
                    $dividend->released_at->format('h:i a m/d/Y'),
                    $dividend->claimed_by,
                ]);
            });
        $writer->toBrowser();
    }

    public function unclaimed()
    {
    }
}
