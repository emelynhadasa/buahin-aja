<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Category extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'name',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_requirements', 'category_id', 'event_id');
    }

    // Define a relationship to requirements
    public function professions()
    {
        return $this->hasMany(Profession::class);
    }

}
