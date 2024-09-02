<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingOptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'image_url',
        'voting_id',
    ];

    protected $table = 'voting_options';

    public $timestamps = true;

    public function voting()
    {
        return $this->belongsTo(Voting::class);
    }

    public function votes()
    {
        return $this->hasMany(VotingVotes::class, "voting_option_id", "id");
    }
}
