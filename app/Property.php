<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Property extends Model
{
    protected $fillable = [
        'name', 'address', 'landmark', 'detail', 'cost'
    ];

    protected $casts = ['is_approved' => 'boolean', 'is_featured' => 'boolean', 'is_sold' => 'boolean'];

    protected $appends = ['slug', 'published'];

    protected $with = ['user'];


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

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setDetailAttribute($value)
    {
        $this->attributes['detail'] = ucfirst($value);
    }

    public function getSlugAttribute($value)
    {
        $slug = Str::slug($this->name);
        return $slug;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
