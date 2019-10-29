<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $with = ['profile'];

    protected $fillable = [
        'name','description'
    ];

    public function profile()
    {
        return $this->morphTo();
    }
}
