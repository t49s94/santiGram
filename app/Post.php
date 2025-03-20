<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class represents a Post made by User.

*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;

class Post extends Model
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Attributes

  // $guarded is a built in array of Lavarel that has all the fields that are gonna be in the form. It prevents anyone from passing fields to the form that doesn't exist. Since
  // we validated all the fields previously and also we used request() and not requestAll(), we only get the data from the chosen fields so the user can't create new fields.
  // We turn off the security method "$guarded" by overwritting it setting an empty string
  protected $guarded = [];

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function comments()
  {
    return $this->hasMany("App\Comment")->orderBy('created_at', 'DESC');
  }

  public function likers()
  {
    return $this->belongsToMany("App\User");
  }

  // Returns Notifications that are related to this Post.
  // @return Notifications.
  public function notifications()
  {
    return $this->hasMany("App\Notification")->orderBy('created_at', 'DESC');
  }
  
}
