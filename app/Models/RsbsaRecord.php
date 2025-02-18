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

public function getFormattedUpdatedAt()
{
    return $this->updated_at ? str_split($this->updated_at->format('mdY')) : [];
}

public function getFormattedLocationCodes()
{
    return [
        'region' => str_split(str_pad($this->region_code, 2, '0', STR_PAD_LEFT)),
        'province' => str_split(str_pad($this->province_code, 2, '0', STR_PAD_LEFT)),
        'city_municipality' => str_split(str_pad($this->city_municipality_code, 2, '0', STR_PAD_LEFT)),
        'barangay' => str_split(str_pad($this->barangay_code, 3, '0', STR_PAD_LEFT)),
        'last_six' => str_split(str_pad($this->reference_last_six ?? '', 6, '0', STR_PAD_RIGHT)), // Ensuring 6 digits always exist
    ];
}


public function getFormattedContactNumber()
{
    if (!$this->contact_number) {
        return null;
    }

    // Split the numbers if they are separated by `/`
    $numbers = explode('/', $this->contact_number);

    foreach ($numbers as $number) {
        $cleaned = preg_replace('/\D/', '', $number); // Remove non-numeric characters
        if (strlen($cleaned) === 11) {
            return $cleaned; // Return first valid 11-digit number
        }
    }

    return null; // Return null if no valid number found
}


public function getFormattedLandlineNumber()
{
    if (!$this->landline_number) {
        return null;
    }

    // Remove non-numeric characters
    $cleaned = preg_replace('/\D/', '', $this->landline_number);

    // Ensure it has 10 digits (standard landline format)
    if (strlen($cleaned) >= 7 && strlen($cleaned) <= 10) {
        return str_pad($cleaned, 10, ' ', STR_PAD_LEFT); // Pad left if necessary
    }

    return null; // Return null if invalid format
}
public function getFormattedDateOfBirth()
{
    if (!$this->memberInformation?->date_of_birth) {
        return array_fill(0, 8, ''); // Return empty values if no date
    }

    $date = \Carbon\Carbon::parse($this->memberInformation->date_of_birth);
    return str_split($date->format('mdY')); // Convert to MMDDYYYY and split into an array
}


public function isEducationLevel($level)
{
    return $this->highest_formal_education === $level;
}

public function getFormattedEmergencyContact()
{
    if (!$this->emergency_contact_number) {
        return array_fill(0, 11, ''); // Ensure layout remains intact
    }

    $cleaned = preg_replace('/\D/', '', $this->emergency_contact_number); // Remove non-numeric characters
    return str_split(substr($cleaned, 0, 11)); // Ensure it's exactly 11 digits
}


}
