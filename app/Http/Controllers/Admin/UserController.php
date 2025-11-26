<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::whereIn('id', function ($query) {
            $query->select('user_id')
                ->from('user_courses');
        })->get();
        return view('admin.users.index', compact('users'));
    }
}
