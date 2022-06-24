<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PropertyListingPlan extends Model
{
    protected $table = 'property_listing_plans';

    protected $guarded = [];

    protected $appends = ['published', 'plan'];


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

    public function property_listing(){
        return $this->belongsTo('App\PropertyListing');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function getPlanAttribute(){
        $price = number_format($this->price / 100);
        $plan = $this->name.' - '.$price;
        return $plan;
    }

    public function subscription(){
        return $this->belongsTo('App\Subscription');
    }
}
