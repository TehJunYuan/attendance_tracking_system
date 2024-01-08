<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Classtime;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Session;

class AttendanceController extends Controller
{
    //

    public function attendance($id){
        $classtime = Classtime::all()->find($id);
        $getCourseId = $classtime->course_id;
        $course = Course::where('id',$getCourseId)->first();
        $courseName = $course->name;
        $getClasstimeId = $classtime->id;
        $getTimetables = Timetable::
        where('classtime_id',$getClasstimeId)
        ->get();
        return view('lecture.qr_attendance', compact(['getTimetables','id','course']));
    }
    
    public function updateAtt(Request $request)
    {

        $user_id = User::all()->where('student_id', '=', $request->StudentID)->first()->id;

        $timetable = TimeTable::all()
            ->where('user_id', '=', $user_id)
            ->where('classtime_id', '=', $request->id)
            ->first();

        $timetable->isPresent = true;
        $timetable->save();
        Session::flash('done',"User create successfully!");
        return response()->json([
            // 'success' => $student_exam,
            'success' => 'Student attendance  successfully.',
        ]);
    }
}
