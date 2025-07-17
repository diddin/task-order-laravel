<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Task;

class TeknisiController extends Controller
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
        $technicians = User::where('role_id', Role::ROLE_TECHNICIAN)->latest()->paginate(10);
        return view($this->role.'.technicians.index', compact('technicians'));
    }

    public function dashboard()
    {
        $technician = Auth::user(); //dd($technician->id);

        $newTasks = Task::with(['network', 'assignedUser', 'creator'])
            ->forUser($technician->id)
            ->withoutAction()
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($task) {
                $deadline = $task->created_at->copy()->addHours(6);

                if (now()->lessThanOrEqualTo($deadline)) {
                    $task->remaining = now()->locale('id')->diffForHumans($deadline, [
                        'parts' => 2,
                        'join' => true,
                    ]) . ' tersisa';

                    $task->remaining = str_replace('dan', '', $task->remaining);
                    $task->remaining = str_replace('sebelumnya', '', $task->remaining);
                } else {
                    $task->remaining = 'Tidak Tercapai';
                }

            return $task;
        });

        $myActivities = Task::with(['network', 'assignedUser', 'creator'])
            ->forUser($technician->id)
            ->withAction()
            ->latest()
            ->take(3)
            ->get();

        $tasks = [
            'newTasks' => $newTasks,
            'myActivities' => $myActivities,
        ];

        // echo "<pre>";
        // print_r($newTasks->toArray());
        // echo "</pre>";die();

        return view($this->role.'.dashboard', compact('technician', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->role.'.technicians.create');
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
            'password' => Hash::make($request->password),
            'profile_image' => $profileImage,
            'role_id' => Role::where('name', 'admin')->first()->id,
        ]);
        
        return Redirect::route($this->role.'.technicians.index')->with('success', 'Teknisi '.$user->name.' berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view($this->role.'.technicians.show', ['technician' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view($this->role.'.technicians.profile.edit', [
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

        return Redirect::route($this->role.'.technicians.index', $user)->with('status', 'Teknisi '.$user->name.' berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return Redirect::route($this->role.'.technicians.index')->with('status', 'Teknisi '.$user->name.' berhasil dihapus.');
    }
}
