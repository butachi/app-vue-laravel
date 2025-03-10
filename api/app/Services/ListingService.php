<?php
namespace App\Services;

use App\Exceptions\Listing\CannotPublishListingException;
use App\Models\Listing;

class ListingService
{
    public function getAll()
    {
        return Listing::query()
            ->published()
            ->accepted()
            ->get();
    }

    public function upsert(array $data, Listing $listing = null) : Listing 
    {
        return Listing::updateOrCreate(
            ['id' => $listing?->id],
            $data,
        );    
    }

    public function delete(Listing $listing): void
    {
        $listing->delete();
    }

    public function accept(Listing $listing): void
    {
        $listing->accepted = true;
        $listing->accepted_at = now();

        if (!$listing->publish_at || $listing->publish_at->isPass()) {
            $$this->publish($listing);
        }

        $listing->save();
    }
    
    public function publish(Listing $listing): void
    {
        if (!$listing->accepted) {
            throw CannotPublishListingException::because(
                'Listing is not accepted yet'
            );
        }

        $listing->publish_at = now();
        $listing->published = true;
        $listing->save();
    }

}