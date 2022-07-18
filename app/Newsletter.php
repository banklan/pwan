<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Newsletter extends Model
{
    protected $guarded = [];

    protected $with = ['admin'];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope('order', function(Builder $builder){
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function setSubjectAttribute($value)
    {
        $this->attributes['subject'] = ucfirst($value);
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = ucfirst($value);
    }

    public function setClosingAttribute($value)
    {
        $this->attributes['closing'] = ucfirst($value);
    }

    public function admin(){
        return $this->belongsTo('App\Admin');
    }
}
