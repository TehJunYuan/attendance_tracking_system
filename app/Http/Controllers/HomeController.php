<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Classroom;
use App\Models\Classtime;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }


    public function adminHome()
    {
        $getCourse = Course::count();
        $getClassroom = Classroom::count();
        $getStudent = User::where('role', 0)->count();
        $getAdmin = User::where('role', 1)->count();
        $getLecture = User::where('role', 2)->count();
        $data = [
            'countCourse' => $getCourse,
            'countClassroom' =>$getClassroom,
            'countStudent' => $getStudent,
            'countAdmin' => $getAdmin,
            'countLecture' => $getLecture,
        ];
        return view('admin.home',compact('data'));
    }

    public function lecturehome(){

        $getTimetable = Timetable::where('lecture_id',Auth::user()->id)->count();
        $getClasstime = Classtime::where('lecture_id',Auth::user()->id)->count();

        $data = [
            'countTimetable' => $getTimetable,
            'countClasstime' =>$getClasstime,
        ];
        return view('lecture.home',compact('data'));
    }

    public function studentHome(){

        $getTimetable = Timetable::where('user_id',Auth::user()->id)->get();
        return view('student.home',compact('getTimetable'));
    }
}
