<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffEmailVerification extends Model
{
    protected $fillable = ['user_id', 'token', 'ís_verified'];

    // protected $guarded = [];

    protected $table = 'staff_email_verifications';
}
