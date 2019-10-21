<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'main_title','secondary_title','content','start_date','end_date','address_address','address_latitude','address_longitude'
    ];

    public function visitors()
    {
        return $this->belongsToMany('App\Visitor');
    }

    public function image()
    {
        return $this->morphMany('App\Image', 'profile');
    }

    public function getStartDateAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d h:i A');
    }

    public function getEndDateAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d h:i A');
    }
}
