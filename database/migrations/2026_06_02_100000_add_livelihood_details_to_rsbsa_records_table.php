<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Part II livelihood sub-details from the 01-2024 form. Purely additive —
     * no existing column or data is touched.
     */
    public function up(): void
    {
        Schema::table('rsbsa_records', function (Blueprint $table) {
            // Farmer: type of farming activity
            $table->json('farmer_activities')->nullable()->after('main_livelihood');
            $table->string('farmer_activities_other')->nullable()->after('farmer_activities');

            // Farmworker/Laborer: kind of work
            $table->json('farmworker_activities')->nullable()->after('farmer_activities_other');
            $table->string('farmworker_activities_other')->nullable()->after('farmworker_activities');

            // Fisherfolk: kind of activity
            $table->json('fisherfolk_activities')->nullable()->after('farmworker_activities_other');
            $table->string('fisherfolk_activities_other')->nullable()->after('fisherfolk_activities');

            // Agri-youth: type of involvement
            $table->json('agri_youth_involvement')->nullable()->after('fisherfolk_activities_other');
            $table->string('agri_youth_involvement_other')->nullable()->after('agri_youth_involvement');
        });
    }

    public function down(): void
    {
        Schema::table('rsbsa_records', function (Blueprint $table) {
            $table->dropColumn([
                'farmer_activities',
                'farmer_activities_other',
                'farmworker_activities',
                'farmworker_activities_other',
                'fisherfolk_activities',
                'fisherfolk_activities_other',
                'agri_youth_involvement',
                'agri_youth_involvement_other',
            ]);
        });
    }
};
