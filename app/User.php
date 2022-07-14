<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $with = ['authorizer'];

    protected $appends = ['created', 'fullname'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function properties()
    {
        return $this->hasMany('App\Property');
    }

    public function property_listings()
    {
        return $this->hasMany('App\PropertyListing');
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function setFirstNameAttribute($value){
        $this->attributes['first_name'] = ucwords($value);
    }

    public function setLastNameAttribute($value){
        $this->attributes['last_name'] = ucwords($value);
    }

    public function getFullnameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function getCreatedAttribute($value)
    {
        $date = $this->created_at->format('F jS, Y');
        return $date;
    }

    public function authorizer(){
        return $this->belongsTo('App\Admin');
    }

    public function testimonials(){
        return $this->hasMany('App\Testimonial');
    }

    public function news_posts(){
        return $this->hasMany('App\NewsPost');
    }

    public function password_request_log(){
        return $this->hasMany('App\PasswordRequestLog');
    }

    public function new_offers(){
        return $this->hasMany('App\NewOffer');
    }

    public function video_rolls(){
        return $this->hasMany('App\VideoRoll');
    }
}
