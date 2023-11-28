<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Get and show all listings
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::latest()
                ->filter(request(['tag', 'search']))
                ->paginate(5),
        ]);
    }

    // Show a single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing,
        ]);
    }

    // Show create form
    public function create(Listing $listing)
    {
        return view('listings.create');
    }

    // Show create form
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request
                ->file('logo')
                ->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing Created Successfully');
    }

    // Show Edit Form
    public function edit(Listing $listing)
    {
        return view('listings.edit', [
            'listing' => $listing,
        ]);
    }

    // Update Listing Data
    public function update(Request $request, Listing $listing)
    {
        if($listing->user_id !== auth()->id()) {
            abort(403, "Unauthorized Action");
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request
                ->file('logo')
                ->store('logos', 'public');
        }

        // Add user_id to form fields (Adding relationship between user and listing)
        $formFields['user_id'] = auth()->id();

        // Update the listing
        $listing->update($formFields);

        return redirect('/')->with('message', 'Listing Updated Successfully');
    }

    // Delete Listing
    public function destroy(Listing $listing)
    {
        if($listing->user_id !== auth()->id()) {
            abort(403, "Unauthorized Action");
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing Deleted Successfully');
    }

    // Show Manage Listings
    public function manage()
    {
        return view('listings.manage', [
            'listings' => auth()->user()->listings,
        ]);
    }
}
