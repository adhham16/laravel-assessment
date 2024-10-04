<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];


    protected $casts = [
        'date_of_birth' => 'date',
        'gender' => Gender::class,
    ];

    public function getDateOfBirthAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}
