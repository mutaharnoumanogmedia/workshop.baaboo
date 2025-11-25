<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }


    public function createUserAndAttachCourse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'course_id' => 'required|integer|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        //creating user with the given email address
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'first_name' => explode('@', $request->email)[0],
                'last_name' =>  '',
                'password' => bcrypt('baaboo123')
            ]
        );
        //attach the course to the user
        $course = Course::find($request->course_id);
        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found'
            ], 404);
        }

        $userCourse = $user->courses()->where('course_id', $course->id)->first();

        if ($userCourse) {
            return response()->json([
                'success' => true,
                'message' => 'User already enrolled in this course',
                'user' => $user,
                'course' => $course
            ], 200);
        }

        $userCourse = $user->courses()->firstOrCreate(['course_id' => $course->id]);

        return response()->json([
            'success' => true,
            'message' => 'User created and course attached successfully',
            'user' => $user,
            'course' => $course
        ]);
    }
}
