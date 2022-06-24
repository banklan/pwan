<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class NewsPost extends Model
{
    protected $guarded = [];

    protected $appends = ['slug', 'published'];

    protected $with = ['user', 'admin'];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope('order', function(Builder $builder){
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function getPublishedAttribute($value)
    {
        $date = $this->created_at->format('F jS, Y');
        return $date;
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst($value);
    }

    public function setDetailAttribute($value)
    {
        $this->attributes['detail'] = ucfirst($value);
    }

    public function getSlugAttribute($value)
    {
        $slug = Str::slug($this->title);
        return $slug;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function admin(){
        return $this->belongsTo('App\Admin');
    }
}
