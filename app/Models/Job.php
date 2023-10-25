<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'min_salary',
        'max_salary',
        'location',
        'type',
        'category_id',
        'company_id',
        'about',

    ];

    public function company()
    {
        return $this->belongsTo(Company::class) ;
    }

    public function category()
    {
        return $this->belongsTo(Category::class) ;
    }

    // public function Apply()
    // {
    //     return $this->belongsToMany(User::class,
    //     'job_user' ,
    //     'job_id' ,
    //     'user_id' ,
    //     'id' ,
    //     'id'
    //     ) ;

    // }

    public function Apply()
{
    return $this->belongsToMany(User::class, 'job_user');
}



    public function users(){
        return $this->belongsToMany(User::class,'bookmarks') ;
    }

    public function isBookmarked()
    {
        // Check if the authenticated user has bookmarked this job
        return $this->users()->where('user_id', auth()->id())->exists();
    }
}
