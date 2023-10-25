<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobUser extends Model
{
    use HasFactory;
    protected $table = 'job_user';
    
    protected  $fillable = [
        'job_id',
        'user_id',
        
    ];
}
