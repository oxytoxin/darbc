<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayslipEntry extends Model
{
    use HasFactory;
    protected $casts = [
        'content' => 'array'
    ];

    public function getFullGcNumberAttribute()
    {
        return implode('-', [
            $this->payslip->release->gift_certificate_prefix,
            $this->gc_number
        ]);
    }

    public function payslip()
    {
        return $this->belongsTo(Payslip::class);
    }
}
