<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'option',
        'score',
        'question_id',
    ];

    public function questions()
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
