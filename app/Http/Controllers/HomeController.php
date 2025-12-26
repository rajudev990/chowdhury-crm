<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function settings()
    {
        return view('auth.settings');
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



    public function changePassword()
    {
        return view('auth.change-password');
    }

   public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed', // Ensure that the passwords match
            'new_password_confirmation' => 'required|string|min:8', // Ensure confirmation
        ]);

        $user = auth()->user();

        // Check if the current password matches the stored password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the password
        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }



}
