<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class represents a Message in a Conversation.

*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Attributes

  protected $fillable = ['conversation_id', 'profile_id', 'body'];

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  // Returns Conversation where Message belongs.
  // @return Conversation.
  public function conversation()
  {
    return $this->belongsTo("App\Conversation", 'conversation_id');
  }

  // Returns Profile that sent Message.
  // @return Profile.
  public function profile()
  {
    return $this->belongsTo("App\Profile", 'profile_id');
  }

}
