<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', 0)->latest()->paginate(25);

        return view('admin.user.index', compact('users'));

    }
}
