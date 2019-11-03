<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','description'
    ];

    public function image()
    {
        return $this->morphOne('App\Image', 'profile');
    }

    public function file()
    {
        return $this->morphOne('App\File', 'fileable');
    }

    public function video()
    {
        return $this->morphOne('App\Video', 'Videoable');
    }

    public function permitted()
    {
        return $this->belongsToMany('App\Staff');
    }
}
