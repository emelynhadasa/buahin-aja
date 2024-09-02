<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'quiz_name',
        'duration'
    ];

}
