<?php

use App\Models\FreeLot;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
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
        Schema::table('free_lots', function (Blueprint $table) {
            $table->json('relocation_history')->after('status')->nullable();
            $table->json('swapping_history')->after('status')->nullable();
        });
        FreeLot::query()->where('status', 3)->update([
            'relocation_history' => [
                [
                    'date' => null,
                    'origin' => [
                        'cluster_id' => null,
                        'block' => null,
                        'lot' => null,
                        'area' => null,
                    ]
                ],
            ]
        ]);
        FreeLot::query()->where('status', 4)->with('user')->each(function ($record) {
            $record->update([
                'swapping_history' => [
                    [
                        'date' => null,
                        'origin' => [
                            'owner_id' => $record->user_id,
                            'owner' => $record->user->full_name,
                            'cluster_id' => null,
                            'block' => null,
                            'lot' => null,
                            'area' => null,
                        ],
                        'target' => [
                            'owner_id' => null,
                            'owner' => null,
                            'cluster_id' => $record->cluster_id,
                            'block' => $record->block,
                            'lot' => $record->lot,
                            'area' => $record->area,
                        ],
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
            $table->dropColumn('relocation_history');
            $table->dropColumn('swapping_history');
        });
    }
};
