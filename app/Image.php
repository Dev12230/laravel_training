<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $with = ['profile'];

    protected $fillable = [
        'image',
    ];

    public function profile()
    {
      return $this->morphTo();
    }

    public function getHasUserAttribute()
    {
      return $this->profile_type == 'App\User';
    }
  
    public function getHasStaffAttribute()
    {
      return $this->profile_type == 'App\Staff';
    }
}
