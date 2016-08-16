<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Auth_userprofile extends Model
{
    protected $table = 'auth_userprofile';
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('App\Auth_user');
    }
}
