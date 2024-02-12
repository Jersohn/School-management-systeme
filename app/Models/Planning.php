<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;
    protected $table = 'planning';
    protected $fillable = ['subject_id', 'class_id', 'hours'];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(SchoolSubject::class, 'subject_id');
    }

    public function hoursForSubject($subjectId)
    {
        $planning = $this->where('subject_id', $subjectId)->first();

        return $planning ? $planning->hours : '';
    }
}
