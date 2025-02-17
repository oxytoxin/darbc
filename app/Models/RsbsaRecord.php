<?php

namespace App\Models;

use App\Models\MemberInformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class RsbsaRecord extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('two_by_two')
            ->singleFile()
            ->useDisk('rsbsa_two_by_two');

    }

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


    protected $casts = [
        'main_livelihood' => 'array',
    ];


    public function memberInformation(){
        return $this->belongsTo(MemberInformation::class,'member_information_id');
    }

    public function getImage(){
        return self::getFirstMediaUrl('two_by_two') ?: asset('assets/placeholder.jpg');
    }
    
    public function isNew(): bool
{
    return $this->enrollment_type === 'New';
}

public function isUpdating(): bool
{
    return $this->enrollment_type === 'Updating';
}


}
