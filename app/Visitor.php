<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($visitor) {
             $visitor->image()->delete();
             $visitor->user()->delete();
        });
    }

    protected $fillable = [
        'user_id','country_id','city_id'
    ];
      /** @inheritdoc */
 
    protected $with = ['user','city'];


    public function user()
    {
        return $this->belongsTo('App\User');
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

    public function toggleStatus()
    {
        $this->user->active = !$this->user->active;
        $this->user->save();
    }
}
