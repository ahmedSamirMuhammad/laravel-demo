<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'name',
        'title',
        'comment',
    ];

    public function users()
    {
        return $this->hasMany(User::class)->withDefault([
            'first_name' => $this->first_name
        ]);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
