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
        $statuses = Status::latest()->paginate(10);
        return view('setup.statuses.index', compact('statuses'));
    }

    /**
     * Show create status form
     */
    public function create()
    {
        return view('setup.statuses.create');
    }

    /**
     * Store new status
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:statuses,name|max:255',
        ]);

        Status::create([
            'name' => $request->name,
            'status' => $request->has('status') ? 1 : 0, // checkbox checked hole 1, na hole 0
        ]);

        return redirect()
            ->route('statuses.index')
            ->with('success', 'Status created successfully');
    }

    /**
     * Show edit status form
     */
    public function edit(Status $status)
    {
        return view('setup.statuses.create', compact('status'));
    }

    /**
     * Update status
     */
    public function update(Request $request, Status $status)
    {
        $request->validate([
            'name' => 'required|unique:statuses,name,' . $status->id . '|max:255',
        ]);

        $status->update([
            'name' => $request->name,
            'status' => $request->has('status') ? 1 : 0, // checkbox checked hole 1, na hole 0
        ]);

        return redirect()
            ->route('statuses.index')
            ->with('success', 'Status updated successfully');
    }

    /**
     * Delete status
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return back()->with('success', 'Status deleted successfully');
    }
}