<?php

namespace App\Models\Quiz;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'question',
        'order',
    ];

    public function event()
    {
        return $this->belongsToMany(Event::class);
    }

    public function options()
    {
        return $this->hasMany(QuizOption::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
