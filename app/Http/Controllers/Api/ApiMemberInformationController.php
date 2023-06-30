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
            ->select(['member_information.id', 'users.full_name'])
            ->when(request()->integer('status'), fn ($query) => $query->whereStatus(request()->integer('status')))
            ->when(request()->boolean('holographic'), fn ($query) => $query->whereHolographic(request()->boolean('holographic')))
            ->get();
    }
}
