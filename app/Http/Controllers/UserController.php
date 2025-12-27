<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view user')->only('index');
        $this->middleware('permission:create user')->only(['create', 'store']);
        $this->middleware('permission:edit user')->only(['edit', 'update']);
        $this->middleware('permission:delete user')->only('destroy');
    }

    /**
     * Admin users list
     */
    public function index()
    {
        $users = User::where('type', 'admin')
            ->with('roles')
            ->latest()
            ->paginate(10);

        return view('staff.users.index', compact('users'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $roles = Role::all();
        return view('staff.users.create', compact('roles'));
    }

    /**
     * Store admin user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            // 'password' => 'required|min:6|confirmed',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'admin',
        ]);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'Admin user created successfully');
    }

    /**
     * Edit admin user
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();

        return view('staff.users.create', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update admin user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:3',
            // 'password' => 'nullable|min:6|confirmed',
            'roles' => 'required|array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'Admin user updated successfully');
    }

    /**
     * Delete admin user
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return back()->with('error', 'Super Admin cannot be deleted');
        }

        $user->delete();

        return back()->with('success', 'Admin user deleted successfully');
    }
}
