<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function settings()
    {
        return view('admin.auth.settings');
    }

    public function updateSettings(Request $request)
        {
            $user = auth()->user(); // 🔥 auth guard

            $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            // image upload
            if ($request->hasFile('image')) {

                // old image delete
                if ($user->image && Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                }

                $image = ImageHelper::uploadImage($request->file('image'));
            } else {
                $image = $user->image;
            }

            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $image,
            ]);

            return back()->with('success', 'Profile updated successfully.');
        }

}
