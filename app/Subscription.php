<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Subscription extends Model
{
    protected $guarded = [];

    protected $appends = ['created', 'date_of_bt'];


    protected static function boot(){
        parent::boot();
        static::addGlobalScope('order', function(Builder $builder){
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function getCreatedAttribute($value)
    {
        $date = $this->created_at->format('F jS, Y');
        return $date;
    }

    public function setSurnameAttribute($value)
    {
        $this->attributes['surname'] = ucfirst($value);
    }

    public function setOtherNamesAttribute($value)
    {
        $this->attributes['other_names'] = ucfirst($value);
    }

    public function setSpouseSurnameAttribute($value)
    {
        $this->attributes['spouse_surname'] = ucfirst($value);
    }

    public function setSpouseNamesAttribute($value)
    {
        $this->attributes['spouse_names'] = ucfirst($value);
    }

    public function setKinNameAttribute($value)
    {
        $this->attributes['kin_name'] = ucfirst($value);
    }

    public function getGenderAttribute($value)
    {
        if($this->gender = 'M'){
            return 'Male';
        }else{
            return 'Female';
        }
    }

    public function getDateOfBtAttribute($value){
        // $bd = date_format($this->dob, 'd/m/y');
        $bd = date('d/m/Y', strtotime($this->dob));
        return $bd;
    }
}
