<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Logic to retrieve notifications and display them
        return view('notifications.index');
    }

    public function detail($id)
    {
        // Logic to retrieve a specific notification by ID
        return view('notifications.detail', ['id' => $id]);
    }
}
