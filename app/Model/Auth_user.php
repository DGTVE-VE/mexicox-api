<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Auth_user extends Model
{
    protected $table = 'auth_user';
    public $timestamps = false;
    
    public function profile()
    {
        return $this->hasOne('App\Model\Auth_userprofile', 'user_id');
    }
}
