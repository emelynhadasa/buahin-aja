<?php

namespace App\Models\Quiz;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'user_id',
        'event_id',
        'score',
    ];
    protected $uniqueKey = ['user_id', 'event_id'];

    protected $table = 'quiz_attempts';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
