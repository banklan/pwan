<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PropertyListing extends Model
{
    protected $fillable = [
        'name', 'location', 'title', 'detail', 'price'
    ];

    protected $casts = ['is_approved' => 'boolean', 'is_featured' => 'boolean', 'status' => 'boolean'];

    protected $appends = ['slug', 'published', 'updated'];

    protected $with = ['user', 'admin', 'files', 'property_listing_plans'];


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

    public function getUpdatedAttribute($value)
    {
        $date = $this->updated_at->format('F jS, Y, h:ia');
        return $date;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setLandmarkAttribute($value)
    {
        $this->attributes['landmark'] = ucfirst($value);
    }

    public function setDetailAttribute($value)
    {
        $this->attributes['detail'] = ucfirst($value);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst($value);
    }

    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = ucfirst($value);
    }

    public function getSlugAttribute($value)
    {
        $slug = Str::slug($this->name);
        return $slug;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function admin(){
        return $this->belongsTo('App\Admin');
    }

    public function files(){
        return $this->hasMany('App\PropertyFile');
    }

    public function property_listing_plans(){
        return $this->hasMany('App\PropertyListingPlan');
    }

    public function subscriptions(){
        return $this->hasMany('App\Subscription');
    }
}
