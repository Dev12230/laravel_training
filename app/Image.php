<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $with = ['profile'];

    protected $fillable = [
        'image',
    ];

    public function profile()
    {
        return $this->morphTo();
    }

    public static function defaultImage()
    {
        return 'default.png';
    }
}
