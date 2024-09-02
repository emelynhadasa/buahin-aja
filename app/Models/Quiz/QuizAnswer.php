<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'option_id',
    ];

    public function options()
    {
        return $this->belongsTo(QuizOption::class, 'option_id');
    }

    public function questions()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}
