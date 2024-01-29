<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignTeacher extends Model {
    protected $table = 'assign_teacher';
    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function teacher_class() {
        return $this->belongsTo(StudentClass::class, 'class_id', 'id');
    }



    public function teacher_year() {
        return $this->belongsTo(StudentYear::class, 'year_id', 'id');
    }
    public function teacher_subject() {
        return $this->belongsTo(SchoolSubject::class, 'subject_id', 'id');
    }

}
