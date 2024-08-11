<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'profile' => Profile::where('user_id', Auth::id())->first(),
        ]);
    }

    public function show($id) {
        $profile = Profile::where('user_id', $id)->first();
        if (!$profile) {
            abort(404, 'Profile not found');
        }
        return view('profile.show', compact('profile'));
    }

    public function update(Request $request) {
        $profile = Profile::where('user_id', Auth::id())->first();

        if ($profile) {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'bio' => 'nullable|string',
                'interests' => 'nullable|string',
                'photo' => 'nullable|image|max:2048', // Validate the photo upload
            ]);
    
            // Handle file upload
            if ($request->hasFile('photo')) {
                // Store the photo and get its path
                $path = $request->file('photo')->store('photos', 'public');
                $validatedData['photo'] = $path; // Update the photo path in the validated data
            }
    
            // Process interests field
            $validatedData['interests'] = array_map('trim', explode(',', $request->input('interests', '')));
    
            // Update the profile with the validated data
            $profile->update($validatedData);
        }

        $user = User::where('id', Auth::id())->first();
        if ($user) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);
            $user->update($validatedData);
        }
    
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    
    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
