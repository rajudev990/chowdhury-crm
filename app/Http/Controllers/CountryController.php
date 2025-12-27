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
        $data = Country::latest()->get();
        return view('countries.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:countries',
    ]);

    // checkbox status handle
    $validated['status'] = $request->has('status') ? 1 : 0;

    Country::create($validated);

    // AJAX response
    if ($request->ajax()) {
        return response()->json(['success' => true]);
    }

    return redirect()->route('countries.index')
        ->with('success', 'Country created successfully!');
}


/**
 * Update the specified resource
 */
public function update(Request $request, Country $country)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:countries,name,' . $country->id,
    ]);

    // checkbox status handle
    $validated['status'] = $request->has('status') ? 1 : 0;

    $country->update($validated);

    // AJAX response
    if ($request->ajax()) {
        return response()->json(['success' => true]);
    }

    return redirect()->route('countries.index')->with('success', 'Country updated successfully!');
}


/**
 * Remove the specified resource
 */
public function destroy(Country $country)
{
    $country->delete();

    return redirect()->back()->with('success', 'Country deleted successfully!');
}

}
