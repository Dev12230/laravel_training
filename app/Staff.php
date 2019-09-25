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
      /** @inheritdoc */
    protected $with = ['user', 'job'];


    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function job()
    {
    	return $this->belongsTo('App\Job');
    }

    public function image() 
    { 
      return $this->morphOne('App\Image', 'profile');
    }

}
