<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Testimonial extends Model
{
    protected $guarded = [];

    protected $with = ['user'];

    protected $appends = ['published'];

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

    public function setFullnameAttribute($value)
    {
        $this->attributes['fullname'] = ucfirst($value);
    }

    public function setOccupationAttribute($value)
    {
        $this->attributes['occupation'] = ucfirst($value);
    }

    public function setOrganizationAttribute($value)
    {
        $this->attributes['organization'] = ucfirst($value);
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
