<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_requirements', 'major_id', 'event_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
