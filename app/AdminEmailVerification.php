<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminEmailVerification extends Model
{
    protected $fillables = ['admin_id', 'token'];

    protected $table = 'admins_email_verifications';
}
