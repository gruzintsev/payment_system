<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';

    protected $fillable = ['user_id', 'status', 'job_class', 'progress', 'payload'];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = ['payload' => 'array'];
    
}
