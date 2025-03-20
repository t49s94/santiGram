<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class represents a Notification to User.

*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Attributes

  protected $fillable = ['receiver_id', 'sender_id', 'post_id', 'notification_type', 'body', 'seen'];

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  // Returns User that got Notification.
  // @return Profile.
  public function receiver()
  {
    return $this->belongsTo("App\Profile", 'receiver_id');
  }

  // Returns User that triggered Notification.
  // @return Profile.
  public function sender()
  {
    return $this->belongsTo("App\Profile", 'sender_id');
  }

  public function post()
  {
    return $this->belongsTo("App\Post", 'post_id');
  }

}
