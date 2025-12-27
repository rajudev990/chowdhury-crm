<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view country')->only('index');
        $this->middleware('permission:create country')->only(['create', 'store']);
        $this->middleware('permission:edit country')->only(['edit', 'update']);
        $this->middleware('permission:delete country')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::latest()->paginate(10);
        return view('setup.countries.index', compact('countries'));
    }

    /**
     * Show create country form
     */
    public function create()
    {
        return view('setup.countries.create');
    }

    /**
     * Store new country
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:countries,name|max:255',
        ]);

        Country::create([
            'name' => $request->name,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country created successfully');
    }

    /**
     * Show edit country form
     */
    public function edit(Country $country)
    {
        return view('setup.countries.create', compact('country'));
    }

    /**
     * Update country
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|unique:countries,name,' . $country->id . '|max:255',
        ]);

        $country->update([
            'name' => $request->name,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country updated successfully');
    }

    /**
     * Delete country
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return back()->with('success', 'Country deleted successfully');
    }
}