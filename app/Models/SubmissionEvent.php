<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'submission_name',
        'file_type',
        'desc',
        'file_size',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
