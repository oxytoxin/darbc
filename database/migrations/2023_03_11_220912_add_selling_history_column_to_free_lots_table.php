<?php

use App\Models\FreeLot;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('free_lots', function (Blueprint $table) {
            $table->string('address')->virtualAs("CONCAT('Block ', COALESCE(block, 'UNKNOWN'), ', Lot ', COALESCE(lot, 'UNKNOWN'), ', ', COALESCE(area, 'UNKNOWN'))")->after('user_id');
            $table->json('selling_history')->nullable()->after('status');
        });
        FreeLot::query()->where('status', 2)->with('user')->each(function ($record) {
            $record->update([
                'selling_history' => [
                    [
                        'date' => $record->sold_at?->format('Y-m-d') ?? null,
                        'buyer' => $record->buyer ?? null,
                    ],
                ]
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('free_lots', function (Blueprint $table) {
            //
        });
    }
};
