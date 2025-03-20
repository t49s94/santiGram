<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class represents a Conversation between Profiles.

*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Attributes

  protected $fillable = ['receiver_id', 'sender_id', 'seen'];

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

  // Returns Messages that belongs to Conversation.
  // @return Message.
  public function messages()
  {
    return $this->hasMany(Message::class)->orderBy('created_at', 'DESC');
  }

}
