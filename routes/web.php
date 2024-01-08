<?php

use App\Http\Livewire\Admin\UserList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Admin\CreateCourse;
use App\Http\Controllers\StudentController;
use App\Http\Livewire\Admin\CreateClassroom;
use App\Http\Controllers\AttendanceController;
use App\Http\Livewire\Lecture\CreateClassTime;
use App\Http\Livewire\Lecture\CreateStudentsTimeTable;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//teacher
Route::group(['prefix' => 'lecture', 'middleware' => ['lecture']], function () {
    //exams
    Route::group(['prefix' => 'attendance'], function () {
        Route::get('attendanceList/{id}', [AttendanceController::class, 'attendance'])->name('attendance');
    });

    //studentExam
    Route::group(['prefix' => 'timetable'], function () {
        Route::post('updateAtt', [AttendanceController::class, 'updateAtt'])->name('studentExam.updateAtt');
    });
    
    Route::get('classtime',CreateClassTime::class)->name('lecture.classtime');
    Route::get('timetable',CreateStudentsTimeTable::class)->name('lecture.timetable');
    Route::get('home',[HomeController::class, 'lecturehome'])->name('lecture.home');
});

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    //exams
    Route::post('createStudent',[StudentController::class, 'create'])->name('create_student');
    Route::get('home',[HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('classroom',CreateClassroom::class)->name('admin.classroom');
    Route::get('course',CreateCourse::class)->name('admin.course');
    Route::get('userList',UserList::class)->name('admin.userList');
});

Route::group(['prefix' => 'student', 'middleware' => ['auth']], function () {
    //exams
    Route::get('home',[HomeController::class, 'studentHome'])->name('student.home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');