<?php

namespace App\Actions;

use Illuminate\Support\Collection;

class ExtractAmountFromDenominationRecord
{
    public static function run(Collection|array $denominations)
    {
        $denominations = Collection::wrap($denominations);
        return $denominations->map(fn ($d) => $d['count'] * $d['denomination'])->sum();
    }
}
