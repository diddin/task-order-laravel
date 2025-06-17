<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskOrderController;

Route::middleware('auth', 'role:user')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('user.profile.destroy');

    Route::resource('/customers', CustomerController::class)
        ->name('user.customers.index', 'user.customers.store', 'user.customers.create', 
        'user.customers.show', 'user.customers.edit', 'user.customers.update', 'user.customers.destroy');
    Route::resource('/networks', NetworkController::class)
        ->name('user.networks.index', 'user.networks.store', 'user.networks.create', 
        'user.networks.show', 'user.networks.edit', 'user.networks.update', 'user.networks.destroy');
    Route::resource('/taskorders', TaskOrderController::class)
        ->name('user.taskorders.index', 'user.taskorders.store', 'user.taskorders.create', 
        'user.taskorders.show', 'user.taskorders.edit', 'user.taskorders.update', 'user.taskorders.destroy');
    Route::resource('/tasks', TaskController::class)
        ->name('user.tasks.index', 'user.tasks.store', 'user.tasks.create', 
        'user.tasks.show', 'user.tasks.edit', 'user.tasks.update', 'user.tasks.destroy');
});
