<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyFile extends Model
{
    protected $fillable = [
        'property_listing_id', 'image'
    ];

    public function property_listing(){
        return $this->belongsTo('App\PropertyListing');
    }

}
