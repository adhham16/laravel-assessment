<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $table = 'timesheets';
    protected $fillable = [
        'user_id',
        'project_id',
        'task_name',
        'date',
        'hours'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function getDateAttribute($value){
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


}
