<?php

namespace App\Jobs;

use App\Models\Listing;
use App\Services\ListingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishListingsJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, Dispatchable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ListingService $listingService): void
    {
        Listing::query()
            ->shouldPublish()
            ->get()
            ->each(fn (Listing $listing) => $listingService->publish($listing));
    }
}
