<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender',
        'title',
        'content',
        'to_batch',
        'to_major',
        'to_student'
    ];
}
