<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskOrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/customers', CustomerController::class)
        ->name('customers.index', 'customers.store', 'customers.create', 
        'customers.show', 'customers.edit', 'customers.update', 'customers.destroy');
    Route::resource('/networks', NetworkController::class)
        ->name('networks.index', 'networks.store', 'networks.create', 
        'networks.show', 'networks.edit', 'networks.update', 'networks.destroy');
    Route::resource('/taskorders', TaskOrderController::class)
        ->name('taskorders.index', 'taskorders.store', 'taskorders.create', 
        'taskorders.show', 'taskorders.edit', 'taskorders.update', 'taskorders.destroy');
    Route::resource('/tasks', TaskController::class)
        ->name('tasks.index', 'tasks.store', 'tasks.create', 
        'tasks.show', 'tasks.edit', 'tasks.update', 'tasks.destroy');
});

require __DIR__.'/auth.php';
// require __DIR__.'/role_master.php';
// require __DIR__.'/role_admin.php';
// require __DIR__.'/role_user.php';
