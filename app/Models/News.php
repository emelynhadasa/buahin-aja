<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'description',
        'publisher',
        'publish_date',
        'image',
        'order_number',
        'status',
    ];
}
