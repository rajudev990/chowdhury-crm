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
        $sources = Source::latest()->paginate(10);
        return view('setup.sources.index', compact('sources'));
    }

    /**
     * Show create source form
     */
    public function create()
    {
        return view('setup.sources.create');
    }

    /**
     * Store new source
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sources,name|max:255',
        ]);

        Source::create([
            'name' => $request->name,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()
            ->route('sources.index')
            ->with('success', 'Source created successfully');
    }

    /**
     * Show edit source form
     */
    public function edit(Source $source)
    {
        return view('setup.sources.create', compact('source'));
    }

    /**
     * Update source
     */
    public function update(Request $request, Source $source)
    {
        $request->validate([
            'name' => 'required|unique:sources,name,' . $source->id . '|max:255',
        ]);

        $source->update([
            'name' => $request->name,
           'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()
            ->route('sources.index')
            ->with('success', 'Source updated successfully');
    }

    /**
     * Delete source
     */
    public function destroy(Source $source)
    {
        $source->delete();

        return back()->with('success', 'Source deleted successfully');
    }
}