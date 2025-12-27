<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view permission')->only('index');
        $this->middleware('permission:create permission')->only(['create', 'store']);
        $this->middleware('permission:edit permission')->only(['edit', 'update']);
        $this->middleware('permission:delete permission')->only('destroy');
    }

    /**
     * Display permissions
     */
    public function index()
    {
        $permissions = Permission::latest()->paginate(15);
        return view('staff.permissions.index', compact('permissions'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('staff.permissions.create');
    }

    /**
     * Store permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission created successfully');
    }

    /**
     * Edit permission
     */
    public function edit(Permission $permission)
    {
        return view('staff.permissions.create', compact('permission'));
    }

    /**
     * Update permission
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    /**
     * Delete permission
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'Permission deleted successfully');
    }
}
