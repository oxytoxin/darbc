<?php

namespace App\Http\Controllers\Rsbase;

use App\Http\Controllers\Controller;
use App\Models\RsbsaRecord;
use App\Services\RsbsaPdfService;
use Illuminate\Http\Request;

class RsbsaPdfController extends Controller
{
    /** Stream the filled PDF inline (preview in browser). ?grid=1 adds the grid. */
    public function inline(RsbsaRecord $rsbsa, Request $request, RsbsaPdfService $service)
    {
        if ($request->boolean('grid')) {
            $service->withGrid();
        }

        $pdf = $service->fill($rsbsa);

        return response($pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="rsbsa-' . $rsbsa->darbc_id . '.pdf"');
    }

    /** Download the filled PDF. */
    public function download(RsbsaRecord $rsbsa, RsbsaPdfService $service)
    {
        $pdf = $service->fill($rsbsa);

        return response($pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="rsbsa-' . $rsbsa->darbc_id . '.pdf"');
    }

}
