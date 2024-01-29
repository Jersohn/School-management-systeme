<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function class ()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }



}
