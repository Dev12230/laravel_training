<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','code'
    ];

    public function city()
    {
        return $this->hasMany(City::class);
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
