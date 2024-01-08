<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Session;

class StudentController extends Controller
{
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function create()
    {
        $r = request();
        User::create([
            'name' => $r->name,
            'email' => $r->email,
            'role' => $r->role,
            'student_id' => $r->student_id,
            'password' => Hash::make($r->password),
        ]);

        Session::flash('success',"User create successfully!");
        return back();
    }
}
