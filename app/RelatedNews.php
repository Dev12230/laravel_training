<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelatedNews extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'news_id','related_id',
    ];

    public function news(){
        return $this->belongsTo('App\News', 'related_id');
    }
}
