<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    public static function boot() {
        parent::boot();

        static::deleting(function($news) {
             $news->image()->delete();
             $news->file()->delete();
             $news->related()->delete();
        });
    }
    
    protected $fillable = [
        'main_title','secondary_title','type','staff_id','content',
    ];
    protected $with = ['staff','related'];

    public function staff()
    {
        return $this->belongsTo('App\Staff', 'staff_id');
    }

    public function image()
    {
        return $this->morphMany('App\Image', 'profile');
    }

    public function file()
    {
        return $this->morphMany('App\File', 'file');
    }

    public function related()
    {
        return $this->hasMany('App\RelatedNews', 'news_id');
    }



}
