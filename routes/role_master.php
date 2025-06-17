<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskOrderController;

Route::middleware('auth', 'role:master')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('master.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('master.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('master.profile.destroy');

    Route::resource('/customers', CustomerController::class)
        ->name('master.customers.index', 'master.customers.store', 'master.customers.create', 
        'master.customers.show', 'master.customers.edit', 'master.customers.update', 'master.customers.destroy');
    Route::resource('/networks', NetworkController::class)
        ->name('master.networks.index', 'master.networks.store', 'master.networks.create', 
        'master.networks.show', 'master.networks.edit', 'master.networks.update', 'master.networks.destroy');
    Route::resource('/taskorders', TaskOrderController::class)
        ->name('master.taskorders.index', 'master.taskorders.store', 'master.taskorders.create', 
        'master.taskorders.show', 'master.taskorders.edit', 'master.taskorders.update', 'master.taskorders.destroy');
    Route::resource('/tasks', TaskController::class)
        ->name('master.tasks.index', 'master.tasks.store', 'master.tasks.create', 
        'master.tasks.show', 'master.tasks.edit', 'master.tasks.update', 'master.tasks.destroy');
});
