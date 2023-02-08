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
        Schema::table('member_information', function (Blueprint $table) {
            $table->integer('missing_details_count')->virtualAs(MemberInformation::getMissingFieldsDBQuery(null));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_information', function (Blueprint $table) {
            $table->dropColumn('missing_details_count');
        });
    }
};
