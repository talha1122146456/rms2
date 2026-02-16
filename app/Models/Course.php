<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title','description','instructor','duration','image'];


    public function files()
    {
        return $this->hasMany(CourseFile::class);
    }



    public function users()
{
    return $this->belongsToMany(User::class)->withTimestamps();
}

}
