<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $with = ['file'];

    protected $fillable = [
        'file',
    ];

    public function file()
    {
        return $this->morphTo();
    }
}
