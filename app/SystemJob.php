<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemJob extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name','description'
    ];

    public function staff()
    {
     return $this->hasMany('App\Staff');
    }
}
