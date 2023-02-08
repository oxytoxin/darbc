<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $file = Storage::get('path/to/file.csv'); // or .xlsx
        // $simpleExcel = new SimpleExcel();
        // $data = $simpleExcel->load($file, 'csv')->getData();

        // foreach ($data as $row) {
        //     $user = User::where('name', $row['name'])->first();
        //     if (!$user) {
        //         continue;
        //     }

        //     $lotAddress = new LotAddress();
        //     $lotAddress->user_id = $user->id;
        //     $lotAddress->address = $row['address'];
        //     $lotAddress->save();
        // }
    }
}
