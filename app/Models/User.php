<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Crypt ;

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
        'email',
        'password',
        'email_verified_at' ,
        'provider',
        'provider_id',
        'provider_token',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider_token',

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

  
    public function histories(){
        return $this->hasMany(History::class) ;
    }


    public function socials()
    {
        return $this->hasMany(Social::class) ;
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class,'reviews') ;
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class) ;
    }


    public function jobs(){
        return $this->belongsToMany(Job::class,'bookmarks') ;
    }


    // public function Apply()
    // {
    //     return $this->belongsToMany(Job::class,
    //     'job_user' ,
    //     'user_id' ,
    //     'job_id' ,
    //     'id' ,
    //     'id'
    //     )->withPivot([]) ;

    // }

    public function Apply()
{
    return $this->belongsToMany(Job::class, 'job_user');
}



    




    public function setProviderTokenAttribute($value)
    {
        $this->attributes['provider_token'] = Crypt::encryptString($value);
    }

    public function getProviderTokenAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}
