<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar_schedule extends Model
{
    use HasFactory;
    protected $table = 'calendar_schedule';
    protected $fillable = [

        'class',
        'teacher',
        'subject',
        'classroom',
        'start',
        'end',
        'color'
    ];

}
