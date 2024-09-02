<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SubmissionAnswer extends Model
{
    use HasFactory;

    // Specify the table if it doesn't follow the convention of the plural form of the model name
    protected $table = 'submission_answers';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'event_id',
        'student_id',
        'file_link',
        'notes',
        'score',
        'last_updated'
    ];

    // Specify the attributes that should be cast to native types
    protected $casts = [
        'last_updated' => 'datetime',
    ];

    // Define the relationships with other models

    /**
     * Get the event that owns the submission answer.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the student that owns the submission answer.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function setCreatedAt($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value)->setTimezone('UTC');
    }

    public function setUpdatedAt($value)
    {
        $this->attributes['updated_at'] = Carbon::parse($value)->setTimezone('UTC');
    }
}
