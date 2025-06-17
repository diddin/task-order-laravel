<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskOrderController;

Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

    Route::resource('/customers', CustomerController::class)
        ->name('admin.customers.index', 'admin.customers.store', 'admin.customers.create', 
        'admin.customers.show', 'admin.customers.edit', 'admin.customers.update', 'admin.customers.destroy');
    Route::resource('/networks', NetworkController::class)
        ->name('admin.networks.index', 'admin.networks.store', 'admin.networks.create', 
        'admin.networks.show', 'admin.networks.edit', 'admin.networks.update', 'admin.networks.destroy');
    Route::resource('/taskorders', TaskOrderController::class)
        ->name('admin.taskorders.index', 'admin.taskorders.store', 'admin.taskorders.create', 
        'admin.taskorders.show', 'admin.taskorders.edit', 'admin.taskorders.update', 'admin.taskorders.destroy');
    Route::resource('/tasks', TaskController::class)
        ->name('admin.tasks.index', 'admin.tasks.store', 'admin.tasks.create', 
        'admin.tasks.show', 'admin.tasks.edit', 'admin.tasks.update', 'admin.tasks.destroy');
});