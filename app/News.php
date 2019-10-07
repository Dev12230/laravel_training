<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'main_title','secondary_title','type','author','content'
    ];

    public function staff()
    {
        return $this->belongsTo('App\Staff', 'author');
    }
}
