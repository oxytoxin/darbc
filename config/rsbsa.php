<?php

/*
|--------------------------------------------------------------------------
| RSBSA Enrollment Form — PDF overlay configuration
|--------------------------------------------------------------------------
|
| Coordinates are in points (pt). Page is US Letter (612 x 792).
| Origin is top-left; y increases downward; for text/boxed, y is the baseline.
|
| Field types:
|   text  => single line of text at (x, y)
|   boxed => one glyph per fixed-width cell, starting at (x, y), spaced by 'gap'
|   check => stamps an "X" at (x, y)
|
| Coordinates are tuned with the measurement grid (see RsbsaPdfService grid()).
|
*/

return [

    'template' => 'templates/rsbsa-template.pdf',

    'page' => ['w' => 612, 'h' => 792],

    'font' => ['family' => 'Helvetica', 'size' => 8],

    'fields' => [

        // --- 2x2 photo (x,y = top-left corner; w,h in points) ---
        'photo' => ['type' => 'image', 'page' => 1, 'x' => 450, 'y' => 45, 'w' => 120, 'h' => 120],

        // --- Transaction code: PhilSys PCN (16 digits, 4 groups of 4 with separators) ---
        'pcn_1' => ['type' => 'boxed', 'page' => 1, 'x' => 153, 'y' => 103, 'gap' => 14],
        'pcn_2' => ['type' => 'boxed', 'page' => 1, 'x' => 225, 'y' => 103, 'gap' => 14],
        'pcn_3' => ['type' => 'boxed', 'page' => 1, 'x' => 297, 'y' => 103, 'gap' => 14],
        'pcn_4' => ['type' => 'boxed', 'page' => 1, 'x' => 369, 'y' => 103, 'gap' => 14],
        // No-PhilID TRN
        'trn' => ['type' => 'boxed', 'page' => 1, 'x' => 153, 'y' => 123, 'gap' => 14],

        // --- Names ---
        'surname'        => ['type' => 'text', 'page' => 1, 'x' => 108, 'y' => 186],
        'first_name'     => ['type' => 'text', 'page' => 1, 'x' => 400, 'y' => 186],
        'middle_name'    => ['type' => 'text', 'page' => 1, 'x' => 108, 'y' => 208],
        'extension_name' => ['type' => 'text', 'page' => 1, 'x' => 348, 'y' => 208],

        // --- Sex ---
        'sex_male'   => ['type' => 'check', 'page' => 1, 'x' => 459, 'y' => 207],
        'sex_female' => ['type' => 'check', 'page' => 1, 'x' => 505, 'y' => 207],

        // --- Permanent address ---
        'perm_house'    => ['type' => 'text', 'page' => 1, 'x' => 150, 'y' => 262],
        'perm_street'   => ['type' => 'text', 'page' => 1, 'x' => 320, 'y' => 262],
        'perm_barangay' => ['type' => 'text', 'page' => 1, 'x' => 485, 'y' => 262],
        'perm_city'     => ['type' => 'text', 'page' => 1, 'x' => 95,  'y' => 290],
        'perm_province' => ['type' => 'text', 'page' => 1, 'x' => 290, 'y' => 290],
        'perm_region'   => ['type' => 'text', 'page' => 1, 'x' => 485, 'y' => 290],

        // --- Date of birth (MM / DD / YYYY split for the separator gaps) & place of birth ---
        'dob_mm'              => ['type' => 'boxed', 'page' => 1, 'x' => 100, 'y' => 384, 'gap' => 17],
        'dob_dd'              => ['type' => 'boxed', 'page' => 1, 'x' => 150, 'y' => 384, 'gap' => 18],
        'dob_yyyy'            => ['type' => 'boxed', 'page' => 1, 'x' => 196, 'y' => 384, 'gap' => 17],
        'place_birth_city'    => ['type' => 'text',  'page' => 1, 'x' => 180, 'y' => 398],
        'place_birth_province'=> ['type' => 'text',  'page' => 1, 'x' => 180, 'y' => 421],

        // --- Mobile ---
        'mobile' => ['type' => 'boxed', 'page' => 1, 'x' => 360, 'y' => 393, 'gap' => 13],

        // --- Mother's maiden name & spouse ---
        'mother_maiden_name' => ['type' => 'text', 'page' => 1, 'x' => 60, 'y' => 445],
        'spouse'             => ['type' => 'text', 'page' => 1, 'x' => 60, 'y' => 540],

        // --- Civil status ---
        'civil_single'   => ['type' => 'check', 'page' => 1, 'x' => 64,  'y' => 471],
        'civil_married'  => ['type' => 'check', 'page' => 1, 'x' => 64,  'y' => 491],
        'civil_widow'    => ['type' => 'check', 'page' => 1, 'x' => 165, 'y' => 471],
        'civil_legally'  => ['type' => 'check', 'page' => 1, 'x' => 165, 'y' => 491],

        // --- Religion ---
        'religion_christianity' => ['type' => 'check', 'page' => 1, 'x' => 82,  'y' => 586],
        'religion_islam'        => ['type' => 'check', 'page' => 1, 'x' => 200, 'y' => 586],
        'religion_others'       => ['type' => 'check', 'page' => 1, 'x' => 282, 'y' => 586],
        'religion_none'         => ['type' => 'check', 'page' => 1, 'x' => 362, 'y' => 586],

        // --- Highest formal education ---
        'edu_preschool'         => ['type' => 'check', 'page' => 1, 'x' => 354, 'y' => 478],
        'edu_elementary'        => ['type' => 'check', 'page' => 1, 'x' => 354, 'y' => 498],
        'edu_highschool_nonk12' => ['type' => 'check', 'page' => 1, 'x' => 354, 'y' => 518],
        'edu_juniorhigh'        => ['type' => 'check', 'page' => 1, 'x' => 354, 'y' => 538],
        'edu_seniorhigh'        => ['type' => 'check', 'page' => 1, 'x' => 478, 'y' => 478],
        'edu_college'           => ['type' => 'check', 'page' => 1, 'x' => 478, 'y' => 498],
        'edu_postgrad'          => ['type' => 'check', 'page' => 1, 'x' => 478, 'y' => 518],
        'edu_vocational'        => ['type' => 'check', 'page' => 1, 'x' => 478, 'y' => 538],
        'edu_none'              => ['type' => 'check', 'page' => 1, 'x' => 540, 'y' => 538],

        // --- Valid proof of identity ---
        'id_type'   => ['type' => 'text', 'page' => 1, 'x' => 420, 'y' => 585],
        'id_number' => ['type' => 'text', 'page' => 1, 'x' => 420, 'y' => 607],

        // --- Provincial address (NCR only) ---
        'prov_house'    => ['type' => 'text', 'page' => 1, 'x' => 150, 'y' => 340],
        'prov_street'   => ['type' => 'text', 'page' => 1, 'x' => 320, 'y' => 340],
        'prov_barangay' => ['type' => 'text', 'page' => 1, 'x' => 485, 'y' => 340],
        'prov_city'     => ['type' => 'text', 'page' => 1, 'x' => 95,  'y' => 366],
        'prov_province' => ['type' => 'text', 'page' => 1, 'x' => 290, 'y' => 366],
        'prov_region'   => ['type' => 'text', 'page' => 1, 'x' => 485, 'y' => 366],

        // --- Mobile ownership ---
        'owns_mobile_yes'           => ['type' => 'check', 'page' => 1, 'x' => 548, 'y' => 405],
        'owns_mobile_no'            => ['type' => 'check', 'page' => 1, 'x' => 575, 'y' => 405],
        'mobile_owner_name'         => ['type' => 'text',  'page' => 1, 'x' => 430, 'y' => 423],
        'mobile_owner_relationship' => ['type' => 'text',  'page' => 1, 'x' => 545, 'y' => 423],

        // --- RSBSA number (system-generated) ---
        'rsbsa_number' => ['type' => 'boxed', 'page' => 1, 'x' => 95, 'y' => 560, 'gap' => 16],

        // --- ICC/IP ---
        'icc_yes'  => ['type' => 'check', 'page' => 1, 'x' => 52,  'y' => 650],
        'icc_no'   => ['type' => 'check', 'page' => 1, 'x' => 78,  'y' => 650],
        'icc_name' => ['type' => 'text',  'page' => 1, 'x' => 200, 'y' => 650],

        // --- PWD / 4Ps ---
        'pwd_yes'    => ['type' => 'check', 'page' => 1, 'x' => 395, 'y' => 650],
        'pwd_no'     => ['type' => 'check', 'page' => 1, 'x' => 420, 'y' => 650],
        'fourps_yes' => ['type' => 'check', 'page' => 1, 'x' => 520, 'y' => 650],
        'fourps_no'  => ['type' => 'check', 'page' => 1, 'x' => 548, 'y' => 650],

        // --- Farmers/Irrigators association names ---
        'fca_1' => ['type' => 'text', 'page' => 1, 'x' => 60,  'y' => 672],
        'fca_2' => ['type' => 'text', 'page' => 1, 'x' => 230, 'y' => 672],
        'fca_3' => ['type' => 'text', 'page' => 1, 'x' => 400, 'y' => 672],

        // --- Part 2: livelihood profile ---
        'liv_farmer' => ['type' => 'check', 'page' => 1, 'x' => 60,  'y' => 712],
        'liv_worker' => ['type' => 'check', 'page' => 1, 'x' => 200, 'y' => 712],
        'liv_fisher' => ['type' => 'check', 'page' => 1, 'x' => 360, 'y' => 712],
        'liv_youth'  => ['type' => 'check', 'page' => 1, 'x' => 500, 'y' => 712],

        /*
        |--- Page 2: Farm Parcel 1 (parcels 2 & 3 are this block offset downward) ---
        */
        'p1_barangay'    => ['type' => 'text',  'page' => 2, 'x' => 95,  'y' => 110],
        'p1_city'        => ['type' => 'text',  'page' => 2, 'x' => 95,  'y' => 125],
        'p1_area'        => ['type' => 'text',  'page' => 2, 'x' => 95,  'y' => 145],
        'p1_ad_yes'      => ['type' => 'check',  'page' => 2, 'x' => 150, 'y' => 145],
        'p1_ad_no'       => ['type' => 'check',  'page' => 2, 'x' => 175, 'y' => 145],
        'p1_arb_yes'     => ['type' => 'check',  'page' => 2, 'x' => 150, 'y' => 158],
        'p1_arb_no'      => ['type' => 'check',  'page' => 2, 'x' => 175, 'y' => 158],
        'p1_own_registered' => ['type' => 'check', 'page' => 2, 'x' => 35, 'y' => 185],
        'p1_own_tenant'     => ['type' => 'check', 'page' => 2, 'x' => 35, 'y' => 195],
        'p1_own_lessee'     => ['type' => 'check', 'page' => 2, 'x' => 110, 'y' => 185],
        'p1_own_others'     => ['type' => 'check', 'page' => 2, 'x' => 110, 'y' => 195],
        'p1_land_owner'  => ['type' => 'text',  'page' => 2, 'x' => 80,  'y' => 215],
        'p1_tiller_name' => ['type' => 'text',  'page' => 2, 'x' => 120, 'y' => 233],
        'p1_remarks'     => ['type' => 'text',  'page' => 2, 'x' => 460, 'y' => 233],
        // parcel 1, commodity row 1
        'p1_c1_schedule' => ['type' => 'text',  'page' => 2, 'x' => 250, 'y' => 110],
        'p1_c1_commodity'=> ['type' => 'text',  'page' => 2, 'x' => 330, 'y' => 110],
        'p1_c1_size'     => ['type' => 'text',  'page' => 2, 'x' => 415, 'y' => 110],
        'p1_c1_heads'    => ['type' => 'text',  'page' => 2, 'x' => 460, 'y' => 110],
        // parcel 1, commodity row 2
        'p1_c2_schedule' => ['type' => 'text',  'page' => 2, 'x' => 250, 'y' => 125],
        'p1_c2_commodity'=> ['type' => 'text',  'page' => 2, 'x' => 330, 'y' => 125],
        'p1_c2_size'     => ['type' => 'text',  'page' => 2, 'x' => 415, 'y' => 125],
        'p1_c2_heads'    => ['type' => 'text',  'page' => 2, 'x' => 460, 'y' => 125],
    ],
];
