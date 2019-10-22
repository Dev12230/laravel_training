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
    
    protected $table = 'news';

    public function news()
    {
        return $this->belongsToMany('App\News', 'related_news', 'related_id', 'news_id');
    }
}
