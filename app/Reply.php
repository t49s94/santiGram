<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class represents a Reply made by User.

*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Attributes

  protected $fillable = ['profile_id', 'body'];

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  public function comment()
  {
    return $this->belongsTo("App\Comment", "comment_id");
  }

  public function profile()
  {
    return $this->belongsTo("App\Profile", "profile_id");
  }

  public function likers()
  {
    return $this->belongsToMany("App\User");
  }

  // Shows if Reply is liked by User.
  // @return Boolean. True if User likes it.
  public function isLikedByUser()
  {
    return (auth()->user()) ? auth()->user()->likingReply->contains($this->id) : false;
  }
  
}
