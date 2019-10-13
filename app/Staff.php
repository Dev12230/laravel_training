<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;


    public static function boot() {
        parent::boot();

        static::deleting(function($staff) {
             $staff->image()->delete();
             $staff->user()->delete();
        });
    }

    protected $fillable = [
        'user_id','job_id','country_id','city_id'
    ];
      /** @inheritdoc */
 
    protected $with = ['user'];


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
    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function news()
    {
        return $this->hasMany('App\News');
    }


}
