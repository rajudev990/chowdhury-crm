<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Setting;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view setting')->only('index');
        $this->middleware('permission:create setting')->only(['create', 'store']);
        $this->middleware('permission:edit setting')->only(['edit', 'update']);
        $this->middleware('permission:delete setting')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $setting = Setting::first();
        return view('setup.settings.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'copyright' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
        ]);

        $setting = Setting::findOrFail($id);
        
        // Data prepare koro
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'copyright' => $request->copyright,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'youtube' => $request->youtube,
        ];

        $logo = $request->hasFile('logo') ? ImageHelper::uploadImage($request->file('logo')) : null;

        // Logo upload handle
        if ($request->hasFile('logo')) {
        
            if ($setting && $setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
        
            $data['logo'] = $logo;
        }

      
        $setting->update($data);


        return redirect()->route('settings.index')->with('success', 'Settings Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
