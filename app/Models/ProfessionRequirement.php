<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'score',
        'category_id',
        'profession_id',
      ];
    
    protected $table = 'profession_requirements';

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
