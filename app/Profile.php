<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class represents a User's Profile.

*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Attributes

  // $guarded is a built in array of Lavarel that has all the fields that are gonna be in the form. It prevents anyone from passing fields to the form that doesn't exist. Since
  // we validated all the fields previously and also we used request() and not requestAll(), we only get the data from the chosen fields so the user can't create new fields.
  // We turn off the security method "$guarded" by overwritting it setting an empty string
  protected $guarded = [];

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  // Returns path to Profile's image.
  // @return String.
  public function profileImage()
  {
    // If profile image hasn't been set, return default image
    $imagePath = ($this->image) ? $this->image : 'profile/6v1nP94kYFuqN2CxlmboZ8j7waxnn7wZRZon8Pmm.png';
    return '/storage/' . $imagePath;
  }

  public function followers()
  {
    return $this->belongsToMany(User::class);
  }

  // Makes a relationship to the User
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
  }

  // Returns Replies to Comments made by Profile.
  // @return Replies.
  public function replies()
  {
    return $this->hasMany(Reply::class)->orderBy('created_at', 'DESC');
  }

  public function notifications()
  {
    return $this->hasMany("App\Notification")->orderBy('created_at', 'DESC');
  }

  public function notificationReceivers()
  {
    return $this->hasMany("App\Notification", 'receiver_id')->orderBy('created_at', 'DESC');
  }

  public function notificationSenders()
  {
    return $this->hasMany("App\Notification", 'sender_id')->orderBy('created_at', 'DESC');
  }

  public function conversationReceivers()
  {
    return $this->hasMany("App\Conversation", 'receiver_id')->orderBy('created_at', 'DESC');
  }

  public function conversationSenders()
  {
    return $this->hasMany("App\Conversation", 'sender_id')->orderBy('created_at', 'DESC');
  }

  public function messages()
  {
    return $this->hasMany("App\Message", 'profile_id')->orderBy('created_at', 'DESC');
  }

}
