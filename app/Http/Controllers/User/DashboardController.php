<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //


    public function index()
    {
        $myCourses = Course::myCourses()->get();
        return view('user.dashboard', compact('myCourses'));
    }
}
