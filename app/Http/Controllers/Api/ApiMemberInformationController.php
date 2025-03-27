<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\MemberInformation;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberInformationResource;

class ApiMemberInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = MemberInformation::query()
            ->with('user')
            ->when(request()->integer('status'), fn ($query) => $query->whereStatus(request()->integer('status')))
            ->when(request()->boolean('holographic'), fn ($query) => $query->whereHolographic(request()->boolean('holographic')))
            ->paginate(50);
        return MemberInformationResource::collection($members);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MemberInformation $memberInformation)
    {
        return MemberInformationResource::make($memberInformation->load(['user', 'user.active_restriction']));
    }

    public function darbc_ids()
    {
        return MemberInformation::query()
            ->select(['id', 'darbc_id'])
            ->when(request()->integer('status'), fn ($query) => $query->whereStatus(request()->integer('status')))
            ->when(request()->boolean('holographic'), fn ($query) => $query->whereHolographic(request()->boolean('holographic')))
            ->get();
    }

    public function darbc_names()
    {
        return MemberInformation::query()
            ->join('users', 'users.id', '=', 'member_information.user_id')
            ->leftJoin('rsbsa_records', 'member_information.id', '=', 'rsbsa_records.member_information_id')
            ->select([
                'member_information.id',
                'member_information.darbc_id',
                'member_information.tin_verification_status',
                'users.full_name',
                'users.surname',
                'users.first_name',
                'users.middle_name',
                'member_information.succession_number',
                'rsbsa_records.id as rsbsa_record_id',
                'rsbsa_records.missingDetails'])
            ->when(request()->integer('status'), fn ($query) => $query->whereStatus(request()->integer('status')))
            ->when(request()->boolean('holographic'), fn ($query) => $query->whereHolographic(request()->boolean('holographic')))
            ->get();


        return MemberInformation::query()
            ->join('users', 'users.id', '=', 'member_information.user_id')
            ->select(['member_information.id', 'member_information.darbc_id', 'users.full_name'])
            ->when(request()->integer('status'), fn ($query) => $query->whereStatus(request()->integer('status')))
            ->when(request()->boolean('holographic'), fn ($query) => $query->whereHolographic(request()->boolean('holographic')))
            ->get();
    }

    public function darbc_members()
    {
        return MemberInformation::query()
            ->join('users', 'users.id', '=', 'member_information.user_id')
            ->join('free_lots', 'free_lots.user_id', '=', 'users.id') // Corrected this join
            ->select([
                'member_information.darbc_id',
                'users.surname',
                'users.first_name',
                'member_information.succession_number',
                'member_information.spa',
                'free_lots.area',
            ])
            ->get();
    }


    public function darbc_members_complete()
    {
        return MemberInformation::query()
        ->join('users', 'users.id', '=', 'member_information.user_id')
        ->join('free_lots', 'free_lots.user_id', '=', 'users.id')
        ->leftJoin('occupations', 'occupations.id', '=', 'member_information.occupation_id')
        ->leftJoin('clusters', 'clusters.id', '=', 'member_information.cluster_id')
        ->leftJoin('genders', 'genders.id', '=', 'member_information.gender_id')
        ->leftJoin('membership_statuses', 'membership_statuses.id', '=', 'member_information.membership_status_id')
        ->select([
            'member_information.darbc_id',
            'users.surname',
            'users.first_name',
            'users.middle_name',
            'member_information.succession_number',
            'member_information.spa',
            'free_lots.area',
            'member_information.place_of_birth',
            'occupations.name as occupation',
            'member_information.mother_maiden_name',
            'member_information.sss_number',
            'clusters.name as cluster',
            'genders.name as gender',
            'member_information.occupation_details',
            'member_information.spouse',
            'member_information.tin_number',
            'member_information.tin_verification_status',
            'member_information.status',
            'member_information.blood_type',
            'member_information.children',
            'member_information.philhealth_number',
            'member_information.percentage',
            'member_information.date_of_birth',
            'member_information.religion',
            'member_information.address_line',
            'member_information.dependents_count',
            'member_information.contact_number',
            'member_information.deceased_at',
            'membership_statuses.name as membership_status',
            'member_information.civil_status',
            'member_information.application_date',
        ])
        ->get();
    }

}
