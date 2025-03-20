<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class represents a User.

*/

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserWelcomeMail;

class User extends Authenticatable
{
  use Notifiable;

  //----------------------------------------------------------------------------------------------------------------------------
  // Attributes

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'email', 'username', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
      'email_verified_at' => 'datetime',
  ];

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  protected static function boot()
  {
    parent::boot();

    // Gets fired whenever a user is created. Creates a default profile
    static::created(function ($user)
    {
      $user->profile()->create([
          'title' => $user->username,
      ]);

      Mail::to($user->email)->send(new NewUserWelcomeMail());
    });
  }

  // Returns Replies that User likes.
  // @return Replies.
  public function likingReply()
  {
    return $this->belongsToMany(Reply::class);
  }

  // Returns Comments that User likes.
  // @return Comments.
  public function likingComment()
  {
    return $this->belongsToMany(Comment::class);
  }

  // Returns Posts that User likes.
  // @return Posts.
  public function likingPost()
  {
    return $this->belongsToMany(Post::class);
  }

  // Makes 1-m relationship
  // Function name plural because is 1:m relationship
  public function posts()
  {
      return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
  }

  public function following()
  {
    return $this->belongsToMany(Profile::class);
  }

  // Makes 1-1 relationship
  // Function name in singular because is 1:1 relationship
  public function profile()
  {
    return $this->hasOne(Profile::class);
  }
  
}
