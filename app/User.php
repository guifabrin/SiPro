<?php

namespace App;

use App\SocialAccount as SocialAccount;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable as Notifiable;

class User extends Authenticatable
{
  use Notifiable;
    /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = [
         'name', 'email', 'password', 'avatar'
     ];
       /**
      * The attributes that should be hidden for arrays.
      *
      * @var array
      */
     protected $hidden = [
         'remember_token',
     ];
}
