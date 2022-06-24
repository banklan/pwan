<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'title', 'detail'
    ];

    protected $casts = ['is_approved' => 'boolean', 'is_featured' => 'boolean'];

    protected $appends = ['slug', 'published', 'evnt_date', 'evnt_time'];

    protected $with = ['user', 'admin', 'event_files'];


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

    public function setVenueAttribute($value)
    {
        $this->attributes['venue'] = ucfirst($value);
    }

    public function getSlugAttribute($value)
    {
        $slug = Str::slug($this->title);
        return $slug;
    }

    public function getEvntDateAttribute($value)
    {
        $date = date('d/m/Y', strtotime($this->event_date));;
        return $date;
    }

    public function getEvntTimeAttribute($value)
    {
        $time = date('h:ia', strtotime($this->event_time));;
        return $time;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function admin(){
        return $this->belongsTo('App\Admin');
    }

    public function event_files(){
        return $this->hasMany('App\EventFile');
    }
}
