<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'classtime_id',
        'isPresent',
    ];

    public function classtime(){
        return $this->belongsTo(Classtime::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lecture(){
        return $this->belongsTo(User::class, 'lecture_id');
    }
}
