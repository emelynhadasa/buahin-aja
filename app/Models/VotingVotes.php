<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingVotes extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'voting_option_id',
        'voting_id',
    ];

    protected $table = 'voting_votes';

    protected $uniqueKey = ['voting_id', 'student_id'];

    public function option()
    {
        return $this->belongsTo(VotingOptions::class, 'voting_option_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, "student_id", "id");
    }
}
