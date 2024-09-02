<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'prize', 'score', 'category_id'];

    public function requirements() {
        return $this->hasMany(ProfessionRequirement::class);
    }

    public function requirement_categories()
    {
        return $this->hasManyThrough(Category::class, ProfessionRequirement::class, 'profession_id', 'id', 'id', 'category_id');
    }
}
