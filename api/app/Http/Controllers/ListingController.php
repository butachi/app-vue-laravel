<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index()
    {
        return Listing::query()
            ->published()
            ->accepted()
            ->get();
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
        return Listing::create($request->all());
    }

    public function update(Request $request, Listing $listing)
    {
        return $listing->fill($request->all());
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();

        return response()->noContent();
    }

    public function publish(Listing $listing)
    {
        $listing->publish();

        return response()->noContent();
    }

    public function accept(Listing $listing)
    {
        $listing->accept();

        return response()->noContent();
    }
}
