<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = [
        'class_id',
        'teacher_id',
        'subject_id',
        'classroom_id',
        'day_of_week',
        'start_time',
        'end_time',
        // Autres colonnes...
    ];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(SchoolSubject::class, 'subject_id');
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

}

