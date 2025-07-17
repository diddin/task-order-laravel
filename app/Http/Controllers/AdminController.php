<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;

class AdminController extends Controller
{
    private $role;

    public function __construct(Auth $auth)
    {
        $this->role = $auth::user()->role->name;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::where('role_id', Role::ROLE_ADMIN)->latest()->paginate(10);
        return view($this->role.'.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->role.'.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $profileImage = null;
        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            // Simpan file di storage/app/public/images dengan nama unik
            $path = $request->file('profile_image')->store('profile_images', 'public');
            // Masukkan path file ke data array (sesuai kolom di DB)
            $profileImage = $path;
        }
    
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'profile_image' => $profileImage,
            'role_id' => Role::where('name', 'admin')->first()->id,
        ]);

        return to_route($this->role.'.admins.index')->with('status', 'Admin '.$user->name.' berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view($this->role.'.admins.show', ['admin' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view($this->role.'.admins.profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            // Simpan file di storage/app/public/images dengan nama unik
            $path = $request->file('profile_image')->store('profile_images', 'public');
            // Masukkan path file ke data array (sesuai kolom di DB)
            $validated['profile_image'] = $path;
        }

        // Set email_verified_at ke null jika email berubah
        if ($user->email !== $validated['email']) {
            $user->email_verified_at = null;
        }

        // Update user
        $user->update($validated);

        // $user->fill($request->all());
        // if ($user->isDirty('email')) {
        //     $user->email_verified_at = null;
        // }
        // $user->save();

        return to_route($this->role.'.admins.index')->with('status', 'Admin '.$user->name.' berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return to_route($this->role.'.admins.index')->with('status', 'Admin '.$user->name.' berhasil dihapus.');
    }
}
