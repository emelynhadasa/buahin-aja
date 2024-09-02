<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Quiz\QuizAttempt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'role_id',
        'email',
        'password',
        'role_id',
        'student_id',
        'batch',
        'major',
        'date_of_birth',
        'GPA'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function submissions()
    {
        return $this->hasMany(SubmissionAnswer::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function batches()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function majors()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class, 'id');
    }

}
