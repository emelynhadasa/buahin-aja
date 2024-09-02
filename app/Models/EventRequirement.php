<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRequirement extends Model
{
  use HasFactory;

  protected $fillable = [
    'event_id',
    'batch_id',
    'major_id',
    'category_id',
    'category_score',
  ];

  protected $table = 'event_requirements';
}
