<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRestriction
 */
class Restriction extends Model
{
    use HasFactory;

    protected $casts = [
        'entries' => 'array'
    ];
}
