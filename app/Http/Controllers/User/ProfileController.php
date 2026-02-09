<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
 public function uploadProfilePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = Auth::user();

    // Store image
    $path = $request->file('profile_picture')->store(
        'profile-photos',
        'public'
    );

    // OPTIONAL: delete old photo if exists
    if ($user->profile_photo_path) {
        Storage::disk('public')->delete($user->profile_photo_path);
    }

    // Save new photo path
    $user->profile_photo_path = $path;
    $user->save();

    return back()->with('success', 'Profile picture updated successfully.');
}
    // Update profile information
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $user->update($request->only(['name', 'dob', 'phone', 'address', 'country']));

        return redirect()->back()->with('success', 'Profile information updated successfully!');
    }

    // Update account and contact information
    public function updateAccount(Request $request)
    {
        $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'swift_code' => 'nullable|string|max:100',
            'btc_address' => 'nullable|string|max:255',
            'eth_address' => 'nullable|string|max:255',
            'ltc_address' => 'nullable|string|max:255',
            'usdt_address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->update($request->all());

        return response()->json(['status' => 200, 'success' => 'Withdrawal information updated successfully!']);
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('message', 'Current password does not match!');
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }

    // Update email preferences
    public function updateEmailPreferences(Request $request)
    {
        $request->validate([
            'otpsend' => 'nullable|boolean',
            'roiemail' => 'nullable|boolean',
            'invplanemail' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $user->update([
            'sendotpemail' => $request->otpsend,
            'sendroiemail' => $request->roiemail,
            'sendinvplanemail' => $request->invplanemail,
        ]);

        return response()->json(['status' => 200, 'success' => 'Email preferences updated successfully!']);
    }
}