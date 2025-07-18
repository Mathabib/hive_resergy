<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $authUser = Auth::user(); // gunakan nama variabel yang tidak bentrok
        return view('profile.edit', compact('authUser')); // kirim dengan nama authUser
    }

    public function update(Request $request)
    {
        $authUser = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $authUser->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update nama & email
        $authUser->name = $request->name;
        $authUser->email = $request->email;

        // Update password jika diisi
        if ($request->filled('password')) {
            $authUser->password = Hash::make($request->password);
        }

        // Upload foto jika ada
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($authUser->profile_photo) {
                Storage::delete('public/profile_photos/' . $authUser->profile_photo);
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profile_photos', $filename);

            $authUser->profile_photo = $filename;
        }

        $authUser->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
