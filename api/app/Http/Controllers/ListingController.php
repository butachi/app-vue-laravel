<?php

namespace App\Http\Controllers;

use App\Exceptions\Listing\CannotPublishListingException;
use App\Models\Listing;
use App\Services\ListingService;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function __construct(
        private readonly ListingService $listingService
    ) 
    {
        
    }
    public function index()
    {
        return $this->listingService->getAll();
    }

    public function show(Listing $listing)
    {
        if (!$listing->accepted || !$listing->published) {
            abort(404, 'Listing is not found');
        }

        return $listing;
    }

    public function store(Request $request)
    {
        return $this->listingService->upsert($request->all());
    }

    public function update(Request $request, Listing $listing)
    {
        return $this->listingService->upsert($request->all(), $listing);
    }

    public function destroy(Listing $listing)
    {
        $this->listingService->delete($listing);

        return response()->noContent();
    }

    public function publish(Listing $listing)
    {
        try {
            $this->listingService->publish($listing);
        } catch (CannotPublishListingException $ex) {
            abort('422', $ex->getMessage());
        }
        
        return response()->noContent();
    }

    public function accept(Listing $listing)
    {
        $this->listingService->accept($listing);

        return response()->noContent();
    }
}
