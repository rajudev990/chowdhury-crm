<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view source')->only('index');
        $this->middleware('permission:create source')->only(['create', 'store']);
        $this->middleware('permission:edit source')->only(['edit', 'update']);
        $this->middleware('permission:delete source')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Source::latest()->get();
        return view('sources.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sources',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        Source::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('sources.index')->with('success', 'Source created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Source $source)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sources,name,' . $source->id,
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        $source->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('sources.index')->with('success', 'Source updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Source $source)
    {
        $source->delete();
        return redirect()->back()->with('success', 'Source deleted successfully!');
    }
}
