<?php

namespace App\Jobs;

use App\Book;
use App\BookTotal;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Min3TotalCulculatingJob implements ShouldQueue
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
        $sum = Book::where('created_at', '>=', Carbon::now()->subMinutes(3))->sum('item_amount');
        $bookTotal = new BookTotal();
        $bookTotal->period = 3;
        $bookTotal->amount = $sum;
        $bookTotal->save();
        \Log::info('総額(3分単位)が計算されたよ');
    }
}
