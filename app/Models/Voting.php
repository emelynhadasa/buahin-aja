<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;


    protected $fillable = [
        'event_id',
        'title',
        'description',
        'image_url',
    ];

    protected $table = 'voting';

    public $timestamps = true;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function votes()
    {
        return $this->hasMany(VotingVotes::class);
    }

    public function options()
    {
        return $this->hasMany(VotingOptions::class);
    }
}
