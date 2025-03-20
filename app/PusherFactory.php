<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class creates a Pusher that will help to send and receive messages in the chat room.

*/

namespace App;
use Pusher\Pusher;

class PusherFactory
{

  // Creates a new Pusher object.
  // @return Pusher
  public static function make()
  {
    return new Pusher(
        env("PUSHER_APP_KEY"), // public key
        env("PUSHER_APP_SECRET"), // Secret
        env("PUSHER_APP_ID"), // App_id
        array(
          'cluster' => env("PUSHER_APP_CLUSTER"), // Cluster
          'encrypted' => true,
        )
    );
  }

}
