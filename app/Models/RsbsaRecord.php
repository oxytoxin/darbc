<?php

namespace App\Models;

use App\Models\MemberInformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RsbsaRecord extends Model
{
    use HasFactory;


    const HIGHEST_FORMAL_EDUCATION=[
        'Pre-school'=> 'Pre-school', 
        'Elementary'=> 'Elementary', 
        'High School (non K-12)'=> 'High School (non K-12)', 
        'Junior High School (K-12)'=> 'Junior High School (K-12)', 
        'Senior High School (K-12)'=> 'Senior High School (K-12)', 
        'College'=> 'College', 
        'Vocational'=> 'Vocational', 
        'Post-graduate'=> 'Post-graduate', 
        'None'=> 'None', 
    ];
    const LIVELIHOOD_OPTION = ['Farmer' => 'Farmer', 'Farmworker/Laborer' => 'Farmworker/Laborer', 'Fisherfolk' => 'Fisherfolk', 'Agri Youth' => 'Agri Youth'];

    public function memberInformation(){
        return $this->belongsTo(MemberInformation::class,'member_information_id');
    }
}
