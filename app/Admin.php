<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'status', 'role', 'password'
    ];

    protected $appends = ['fullname', 'admin_status', 'created'];

    protected $with = ['creator', 'authorizer'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at'
    ];



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $date = [
        'updated_at'
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
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

    public function getAdminStatusAttribute($value)
    {
        if($this->status == 0){
            return 'Disabled';
        }
        return 'Enabled';
    }

    public function getCreatedAttribute($value)
    {
        $date = $this->created_at->format('F jS, Y');
        return $date;
    }

    public function creator(){
        return $this->belongsTo('App\Admin');
    }

    public function authorizer(){
        return $this->belongsTo('App\Admin');
    }

    public function user(){
        return $this->hasmany('App\User');
    }

    public function property(){
        return $this->hasmany('App\PropertyListing');
    }

    public function event(){
        return $this->hasmany('App\Event');
    }

    public function news_posts(){
        return $this->hasmany('App\NewsPost');
    }

    public function offer(){
        return $this->hasmany('App\NewOffer');
    }
}
