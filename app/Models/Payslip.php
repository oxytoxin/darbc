<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;

    public function release()
    {
        return $this->belongsTo(Release::class);
    }

    public function payslip_entries()
    {
        return $this->hasMany(PayslipEntry::class);
    }
}
