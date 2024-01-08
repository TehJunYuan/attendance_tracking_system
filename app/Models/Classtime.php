<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classtime extends Model
{
    use HasFactory;


    protected $fillable = [
        'start',
        'course_id',
        'classroom_id',
        'end',
        'day',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }

    public function timetable()
    {
        return $this->hasOne(Timetable::class);
    }
}
