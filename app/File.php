<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $with = ['fileable'];

    protected $fillable = [
        'file',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function detail()
    {
        return $this->morphOne('App\Detail', 'profile');
    }
}
