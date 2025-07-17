<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private $role;

    public function __construct(Auth $auth)
    {
        $this->role = $auth::user()->role->name;
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function editMaster(Request $request): View
    {
        return view('master.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function editAdmin(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function editTeknisi(Request $request): View
    {
        return view('technician.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile information.
     */
    public function updateMaster(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            // Masukkan path file ke data array (sesuai kolom di DB)
            $validated['profile_image'] = $path;
        }

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('master.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile information. ProfileUpdateRequest
     */
    public function updateAdmin(ProfileUpdateRequest $request): RedirectResponse
    { //dd($request->all());
        $validated = $request->validated();

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            // Masukkan path file ke data array (sesuai kolom di DB)
            $validated['profile_image'] = $path;
        }

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile information.
     */
    public function updateTeknisi(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            // Masukkan path file ke data array (sesuai kolom di DB)
            $validated['profile_image'] = $path;
        }

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('technician.profile.edit')->with('status', 'profile-updated');
    }

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

        // Mengambil yang sudah dihapus:
        // User::onlyTrashed()->get();

        // Mengambil semua (termasuk yang terhapus):
        // User::withTrashed()->get();

        // Mengembalikan user:
        // $user->restore();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/login');
    }
}
