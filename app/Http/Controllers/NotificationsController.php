<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class is the controller for Notifications to users.

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
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

  // Shows Notification page.
  // @return view. View that contains Notifications that a User has.
  public function index()
  {
    // Order the notifications in descending order and paginate the results.
    $notifications = \App\Notification::where('receiver_id', auth()->user()->profile->id)->latest()->paginate(5);
    return view('notifications.index', compact('notifications'));
  }

  // Stores a new Notification in DB.
  // @param $receiverId. Integer with the Id of User that owns Notification.
  // @param $senderId. Integer with the Id of User that triggered Notification.
  // @param $postId. Integer with the Id of Post related to Notification.
  // @param $notificationType. String with the type of Notification.
  // @param $body. String with Notification's text.
  public static function store($receiverId, $senderId, $postId, $notificationType, $body)
  {
    auth()->user()->profile->notificationSenders()->create([
      'receiver_id' => $receiverId,
      'sender_id' => $senderId,
      'post_id' => $postId,
      'notification_type' => $notificationType,
      'body' => $body,
      'seen' => 0,
    ]);
  }

  // Returns number of new notifications.
  // @return Int.
  public function getNumberNotifications()
  {
    $numberNotifications = \App\Notification::orderby('created_at','desc')->select('id')
                          ->where('receiver_id', auth()->user()->profile->id)
                          ->where('seen', 0)
                          ->get()->count();

    return $numberNotifications;
  }

}
