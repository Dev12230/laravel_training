<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

    protected $with = ['videoable'];

    protected $fillable = [
        'video',
    ];

    public function videoable()
    {
        return $this->morphTo();
    }

    public function detail()
    {
        return $this->morphOne('App\Detail', 'profile');
    }
}
