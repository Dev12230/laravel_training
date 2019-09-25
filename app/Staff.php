<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Staff extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id','job_id'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function systemjob()
    {
    	return $this->belongsTo('App\SystemJob');
    }

    public function image() 
    { 
      return $this->morphOne('App\Image', 'profile');
    }

}
