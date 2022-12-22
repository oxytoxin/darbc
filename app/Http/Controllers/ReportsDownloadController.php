<?php

namespace App\Http\Controllers;

use App\Models\Dividend;
use App\Models\Release;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ReportsDownloadController extends Controller
{
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
                        implode($dividend->restriction_entries, ', '),
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
