<?php

use App\Models\MemberInformation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $members = MemberInformation::whereNotNull('province_code')->get();
        $members->each(function ($member) {
            $member->address_line = strtoupper($member->address);
            $member->save();
        });
        Schema::table('member_information', function (Blueprint $table) {
            $table->dropColumn('province_code');
            $table->dropColumn('region_code');
            $table->dropColumn('city_code');
            $table->dropColumn('barangay_code');
        });
        Schema::dropIfExists('regions');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('barangays');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_information', function (Blueprint $table) {
            //
        });
    }
};
