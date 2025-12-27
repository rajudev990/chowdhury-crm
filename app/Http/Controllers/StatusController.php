<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view status')->only('index');
        $this->middleware('permission:create status')->only(['create', 'store']);
        $this->middleware('permission:edit status')->only(['edit', 'update']);
        $this->middleware('permission:delete status')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Status::latest()->get();
        return view('statuses.index', compact('data'));
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
        $request->validate([
            'name' => 'required|unique:statuses,name',
            'status' => 'nullable|boolean',
        ]);

        Status::create([
            'name' => $request->name,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Status created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:statuses,name,' . $status->id,
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;

        $status->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('statuses.index')->with('success', 'Status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        $status->delete();
        return redirect()->back()->with('success', 'Status deleted successfully!');
    }
}
