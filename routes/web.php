<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskOrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('role:master')->prefix('master')->group(function () {

    Route::get('dashboard', function () {
        return redirect()->route('master.admins.index');
    })->name('master.dashboard');

    Route::get('/register', [RegisteredUserController::class, 'createAccount'])
        ->name('registerAccount');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Tambahkan dulu route khusus sebelum resource
    Route::put('admins/password/{user}', [PasswordController::class, 'updateAdminPassword'])
        ->name('master.admins.password.update');
    // Baru definisikan resource setelahnya
    Route::resource('admins', AdminController::class)
        ->parameters(['admins' => 'user']) // ganti {admin} jadi {user}
        ->names('master.admins');
    // Tambahkan dulu route khusus sebelum resource
    Route::put('technicians/password/{user}', [PasswordController::class, 'updateTechnicianPassword'])
        ->name('master.technicians.password.update');
    // Baru definisikan resource setelahnya
    Route::resource('technicians', TeknisiController::class)
        ->parameters(['technicians' => 'user'])
        ->names('master.technicians');
    Route::resource('customers', CustomerController::class)->names('master.customers');
    Route::resource('networks', NetworkController::class)->names('master.networks');
    Route::resource('tasks', TaskController::class)->names('master.tasks');
    Route::resource('announcements', AnnouncementController::class)->names('master.announcements');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'editMaster')->name('master.profile.edit');
        Route::patch('profile', 'updateMaster')->name('master.profile.update');
        Route::delete('profile', 'destroy')->name('master.profile.destroy');
    });

    // Route::get('admins', [AdminController::class, 'index'])->name('master.admins.index');
    // Route::get('admins/create', [AdminController::class, 'create'])->name('master.admins.create');
    // Route::post('admins', [AdminController::class, 'store'])->name('master.admins.store');
    // Route::get('admins/{user}', [AdminController::class, 'show'])->name('master.admins.show');
    // Route::get('admins/{user}/edit', [AdminController::class, 'edit'])->name('master.admins.edit');
    // Route::match(['put', 'patch'], 'admins/{user}', [AdminController::class, 'update'])->name('master.admins.update');
    // Route::delete('admins/{user}', [AdminController::class, 'destroy'])->name('master.admins.destroy');
    // Route::put('admins/password/{user}', [PasswordController::class, 'updateAdminPassword'])->name('master.admins.password.update');

    // Route::get('technicians', [TeknisiController::class, 'index'])->name('master.technicians.index');
    // Route::get('technicians/create', [TeknisiController::class, 'create'])->name('master.technicians.create');
    // Route::post('technicians', [TeknisiController::class, 'store'])->name('master.technicians.store');
    // Route::get('technicians/{user}', [TeknisiController::class, 'show'])->name('master.technicians.show');
    // Route::get('technicians/{user}/edit', [TeknisiController::class, 'edit'])->name('master.technicians.edit');
    // Route::put('technicians/{user}', [TeknisiController::class, 'update'])->name('master.technicians.update');
    // Route::patch('technicians/{user}', [TeknisiController::class, 'update'])->name('master.technicians.update');
    // Route::delete('technicians/{user}', [TeknisiController::class, 'destroy'])->name('master.technicians.destroy');
    // Route::put('technicians/password/{user}', [PasswordController::class, 'updateTechnicianPassword'])->name('master.technicians.password.update');

    // Route::get('customers', [CustomerController::class, 'index'])->name('master.customers.index');
    // Route::get('customers/create', [CustomerController::class, 'create'])->name('master.customers.create');
    // Route::post('customers', [CustomerController::class, 'store'])->name('master.customers.store');
    // Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('master.customers.show');
    // Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('master.customers.edit');
    // Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('master.customers.update');
    // Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('master.customers.destroy');

    // Route::get('networks', [NetworkController::class, 'index'])->name('master.networks.index');
    // Route::get('networks/create', [NetworkController::class, 'create'])->name('master.networks.create');
    // Route::post('networks', [NetworkController::class, 'store'])->name('master.networks.store');
    // Route::get('networks/{network}', [NetworkController::class, 'show'])->name('master.networks.show');
    // Route::get('networks/{network}/edit', [NetworkController::class, 'edit'])->name('master.networks.edit');
    // Route::put('networks/{network}', [NetworkController::class, 'update'])->name('master.networks.update');
    // Route::delete('networks/{network}', [NetworkController::class, 'destroy'])->name('master.networks.destroy');

    // Route::get('tasks', [TaskController::class, 'index'])->name('master.tasks.index');
    // Route::get('tasks/create', [TaskController::class, 'create'])->name('master.tasks.create');
    // Route::post('tasks', [TaskController::class, 'store'])->name('master.tasks.store');
    // Route::get('tasks/{task}', [TaskController::class, 'show'])->name('master.tasks.show');
    // Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('master.tasks.edit');
    // Route::put('tasks/{task}', [TaskController::class, 'update'])->name('master.tasks.update');
    // Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('master.tasks.destroy');

    // Route::get('profile', [ProfileController::class, 'editMaster'])->name('master.profile.edit');
    // Route::patch('profile', [ProfileController::class, 'updateMaster'])->name('master.profile.update');
    // Route::delete('profile', [ProfileController::class, 'destroy'])->name('master.profile.destroy');
});


Route::middleware('role:admin')->prefix('admin')->group(function () {

    Route::get('dashboard', fn () => redirect()->route('admin.customers.index'))->name('admin.dashboard');

    Route::resource('customers', CustomerController::class)->names('admin.customers');
    Route::resource('networks', NetworkController::class)->names('admin.networks');
    Route::resource('tasks', TaskController::class)->names('admin.tasks');
    Route::resource('announcements', AnnouncementController::class)->names('admin.announcements');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'editAdmin')->name('admin.profile.edit');
        Route::patch('profile', 'updateAdmin')->name('admin.profile.update');
        Route::delete('profile', 'destroy')->name('admin.profile.destroy');
    });

    // Route::get('dashboard', function () {
    //     return redirect()->route('admin.customers.index');
    // })->name('admin.dashboard');

    // Route::get('customers', [CustomerController::class, 'index'])->name('admin.customers.index');
    // Route::get('customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
    // Route::post('customers', [CustomerController::class, 'store'])->name('admin.customers.store');
    // Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('admin.customers.show');
    // Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit');
    // Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');
    // Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');

    // Route::get('networks', [NetworkController::class, 'index'])->name('admin.networks.index');
    // Route::get('networks/create', [NetworkController::class, 'create'])->name('admin.networks.create');
    // Route::post('networks', [NetworkController::class, 'store'])->name('admin.networks.store');
    // Route::get('networks/{network}', [NetworkController::class, 'show'])->name('admin.networks.show');
    // Route::get('networks/{network}/edit', [NetworkController::class, 'edit'])->name('admin.networks.edit');
    // Route::put('networks/{network}', [NetworkController::class, 'update'])->name('admin.networks.update');
    // Route::delete('networks/{network}', [NetworkController::class, 'destroy'])->name('admin.networks.destroy');

    // Route::get('tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
    // Route::get('tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create');
    // Route::post('tasks', [TaskController::class, 'store'])->name('admin.tasks.store');
    // Route::get('tasks/{task}', [TaskController::class, 'show'])->name('admin.tasks.show');
    // Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('admin.tasks.edit');
    // Route::put('tasks/{task}', [TaskController::class, 'update'])->name('admin.tasks.update');
    // Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');

    // Route::resource('announcements', AnnouncementController::class)->names('admin.announcements');

    // Route::get('profile', [ProfileController::class, 'editAdmin'])->name('admin.profile.edit');
    // Route::patch('profile', [ProfileController::class, 'updateAdmin'])->name('admin.profile.update');
    // Route::delete('profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
});

Route::middleware('role:technician')->group(function () {
    
    Route::get('dashboard', [TeknisiController::class, 'dashboard'])->name('technician.dashboard');

    Route::get('tasks', [TaskController::class, 'index'])->name('technician.tasks.index');
    Route::post('/tasks/{task}/complete', [TaskController::class, 'completeProgress'])->name('technician.task.complete');

    Route::get('taskorders/{task}', [TaskOrderController::class, 'addProgress'])->name('technician.taskorders.progress');
    Route::post('taskorders/{task}', [TaskOrderController::class, 'storeProgress'])->name('technician.taskorders.store-progress');

    Route::get('profile', [ProfileController::class, 'editTeknisi'])->name('technician.profile.edit');
    Route::patch('profile', [ProfileController::class, 'updateTeknisi'])->name('technician.profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('technician.profile.destroy');

});

Route::middleware('auth')->group(function () {

    Route::resource('announcements', AnnouncementController::class);
    
    Route::delete('/profile/image', [ProfileController::class, 'destroyImage'])->name('profile.image.delete');

    Route::get('assets', [AssetController::class, 'index'])->name('assets.index');
    Route::get('assets/create', [AssetController::class, 'create'])->name('assets.create');
    Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
    Route::get('assets/{asset}/task/{task}', [AssetController::class, 'show'])->name('assets.show');
    Route::get('assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
    Route::put('assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
    Route::delete('assets', [AssetController::class, 'destroy'])->name('assets.destroy');

    //Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('chat', [ChatController::class, 'technicianMessages'])->name('chat.technician-index');
    Route::post('chat', [ChatController::class, 'send'])->name('chat.send');
    
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/{id}', [NotificationController::class, 'detail'])->name('notifications.detail');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllTasksAsRead'])
            ->name('notifications.markAllTasksAsRead');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';
    
// Route::resource('/taskorders', TaskOrderController::class)
//     ->name('taskorders.index', 'taskorders.store', 'taskorders.create', 
//     'taskorders.show', 'taskorders.edit', 'taskorders.update', 'taskorders.destroy');
