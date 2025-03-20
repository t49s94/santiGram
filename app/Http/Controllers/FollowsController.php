<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class is the controller for users that follow somebody else.

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class FollowsController extends Controller
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Constructor
  public function __construct()
  {
      // Without this if user isn't authenticated, the store() will fail because user is null
      $this->middleware('auth');
  }

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  // Stores a record that represents a Follow in DB.
  // @param User. User that is going to be followed.
  // @return array. Array that shows if the user was attached or detached.
  public function store(User $user)
  {
    $result = auth()->user()->following()->toggle($user->profile);

    if(!empty($result['attached']))
    {
      auth()->user()->profile->notificationSenders()->create([
        'receiver_id' => $user->profile->id,
        'sender_id' => auth()->user()->profile->id,
        'notification_type' => "New follower",
        'body' => auth()->user()->username . " is following you.",
        'seen' => 0,
      ]);
    }

    return $result;
  }

}
