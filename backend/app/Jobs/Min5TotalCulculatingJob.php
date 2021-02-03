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

class Min5TotalCulculatingJob implements ShouldQueue
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
        $sum = Book::where('created_at', '>=', Carbon::now()->subMinutes(5))->sum('item_amount');
        $bookTotal = new BookTotal();
        $bookTotal->period = 5;
        $bookTotal->amount = $sum;
        $bookTotal->save();
        \Log::info('総額(5分単位)が計算されたよ');
    }
}
