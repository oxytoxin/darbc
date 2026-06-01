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

    /** Visual coordinate tuner page. */
    public function tuner(RsbsaRecord $rsbsa, RsbsaPdfService $service)
    {
        $fields = RsbsaPdfService::fields();
        $values = $service->mappedData($rsbsa);

        // Build a flat list for the view: key, type, page, x, y, gap, display value.
        $items = [];
        foreach ($fields as $key => $f) {
            $items[] = [
                'key'   => $key,
                'type'  => $f['type'],
                'page'  => $f['page'] ?? 1,
                'x'     => $f['x'],
                'y'     => $f['y'],
                'gap'   => $f['gap'] ?? null,
                'w'     => $f['w'] ?? null,
                'h'     => $f['h'] ?? null,
                'value' => $this->displayValue($f['type'], $values[$key] ?? null, $key),
            ];
        }

        return view('rsbsa.pdf-tuner', [
            'rsbsa'    => $rsbsa,
            'items'    => $items,
            'page'     => config('rsbsa.page'),
            'fontSize' => config('rsbsa.font.size'),
        ]);
    }

    /** Persist dragged coordinates to the overrides file. */
    public function save(Request $request)
    {
        $data = $request->validate([
            'coords'             => ['required', 'array'],
            'coords.*.x'         => ['required', 'numeric'],
            'coords.*.y'         => ['required', 'numeric'],
            'coords.*.gap'       => ['nullable', 'numeric'],
        ]);

        $clean = [];
        foreach ($data['coords'] as $key => $pos) {
            $clean[$key] = [
                'x' => round($pos['x'], 1),
                'y' => round($pos['y'], 1),
            ];
            if (isset($pos['gap']) && is_numeric($pos['gap'])) {
                $clean[$key]['gap'] = round($pos['gap'], 1);
            }
        }

        file_put_contents(
            RsbsaPdfService::overridesPath(),
            json_encode($clean, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        return response()->json(['saved' => count($clean)]);
    }

    private function displayValue(string $type, $value, string $key): string
    {
        if ($type === 'check') {
            return 'X';
        }
        if ($type === 'image') {
            return '2x2 PHOTO';
        }
        if ($value === null || $value === '') {
            return '〈' . $key . '〉'; // placeholder so empty fields are still positionable
        }
        return (string) $value;
    }
}
