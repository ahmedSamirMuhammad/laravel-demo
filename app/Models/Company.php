<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Paddle\Billable;



class Company   extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,   Billable ;
    protected $fillable = [
        'first_name',
        'last_name',
        'company_name',
        'email',
        'password',
        'email_verified_at'

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];



    public function jobs(){
        return $this->hasMany(Job::class) ;
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'reviews')->withPivot(['rating', 'title', 'comment', 'user_id', 'created_at']);
    }
}
