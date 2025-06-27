<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Show all users
     */
    public function users()
    {
        $users = \App\Models\User::all();
        return view('admin.users', compact('users'));
    }
}
