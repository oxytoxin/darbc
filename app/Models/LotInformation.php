<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotInformation extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function block()
    {
        return $this->belongsTo(BlockAddress::class);
    }

    public function lot()
    {
        return $this->belongsTo(LotAddress::class);
    }

    public function area()
    {
        return $this->belongsTo(AreaAddress::class);
    }
}
