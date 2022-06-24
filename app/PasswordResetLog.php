<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PasswordResetLog extends Model
{
    protected $fillable = ['user_id', 'email'];

    protected $appends = ['request_date_time', 'reset_date_time'];

    protected $date = ['created_at', 'request_date', 'reset_date'];

    protected $with = ['user'];


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function getRequestDateTimeAttribute(){
        $date = Carbon::parse($this->request_date)->format('d/m/Y, h:ma');
        return $date;
    }

    public function getResetDateTimeAttribute(){
        $date = Carbon::parse($this->reset_date)->format('d/m/Y, h:ma');
        return $date;
    }
}
