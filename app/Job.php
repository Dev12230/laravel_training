<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name','description'
    ];
 

    public function staffs()
    {
        return $this->hasMany('App\Staff');
    }
}
