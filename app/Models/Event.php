<?php

namespace App\Models;

use App\Models\Batch;
use App\Models\Category;
use App\Models\Major;
use App\Models\Quiz\QuizAttempt;
use App\Models\Quiz\QuizOption;
use App\Models\Quiz\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'point',
        'progress_num',
        'max_participants',
        'start',
        'end',
        'type',
        'requirements',
        'description',
    ];

    public function eventRequirements()
    {
        return $this->hasMany(EventRequirement::class);
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'event_requirements', 'event_id', 'batch_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'event_requirements', 'event_id', 'major_id');
    }
    
    public function submissionAnswers()
    {
        return $this->hasMany(SubmissionAnswer::class);
    }


    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
    

}
