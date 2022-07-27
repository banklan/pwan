<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FAQ extends Model
{
    protected $guarded = [];

    protected $with = ['user'];

    protected $table = 'faqs';


    public function setQstnAttribute($value)
    {
        $this->attributes['qstn'] = ucfirst($value);
    }

    public function setAnsAttribute($value)
    {
        $this->attributes['ans'] = ucfirst($value);
    }

    public function setExtraAttribute($value)
    {
        $this->attributes['extra'] = ucfirst($value);
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
