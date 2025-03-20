<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class represents a Comment made by a User.

*/

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Post;

class Comment extends Model
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Attributes

  protected $fillable = ['profile_id', 'body'];

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  public function post()
  {
    return $this->belongsTo("App\Post", "post_id");
  }

  public function profile()
  {
    return $this->belongsTo("App\Profile", "profile_id");
  }

  public function replies()
  {
    return $this->hasMany("App\Reply")->orderBy('created_at', 'DESC');
  }

  public function likers()
  {
    return $this->belongsToMany("App\User");
  }

  // Shows if Comment is liked by User.
  // @return Boolean. True if User likes it.
  public function isLikedByUser()
  {
    return (auth()->user()) ? auth()->user()->likingComment->contains($this->id) : false;
  }
  
}
