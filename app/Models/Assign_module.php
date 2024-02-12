<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assign_module extends Model
{
    use HasFactory;

    protected $table = 'assign_module';

    protected $fillable = [
        'subject_id',
        'teacher_id',
        'class_id',
        'classroom_id',
        'color',
        'hour_per_year',
    ];

    public function subject()
    {
        return $this->belongsTo(SchoolSubject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
    public function planning()
    {
        return $this->hasMany(Planning::class, 'class_id', 'class_id')
            ->where('subject_id', $this->subject_id);
    }

    public function getHoursPerYearAttribute()
    {
        // Récupérez les plannings liés à cette classe et cette matière spécifiques
        $plannings = $this->planning;

        // Calculez la somme des heures pour ce module sur une année
        return $plannings->sum('hours');
    }

}
