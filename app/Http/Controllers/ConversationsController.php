<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class is the controller for Conversations between Profiles.

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Conversation;

class ConversationsController extends Controller
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Attributes

  protected $conversationsPerPage = 5;

  //----------------------------------------------------------------------------------------------------------------------------
  // Constructor

  public function __construct()
  {
    // Without this if user isn't authenticated, the store() will fail because user is null
    $this->middleware('auth');
  }

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  // Shows Conversation's page.
  // @return view. View that contains Conversations that a User has.
  public function index(Request $request)
  {
    $conversations = Conversation::where('receiver_id', auth()->user()->profile->id)
                                  ->orWhere('sender_id', auth()->user()->profile->id)
                                  ->latest()
                                  ->paginate($this->conversationsPerPage);

    if($request->ajax())
    {
      return [
        'conversations' => view('conversations.ajax.index')->with(compact('conversations'))->render(),
        'next_page' => $conversations->nextPageUrl()
      ];
    }

    return view('conversations.index')->with(compact('conversations'));

  }

  public function fetchNextConversationsSet($page)
  {

  }

  // Stores a new Conversation in DB.
  // @param $receiverId. Integer with the Id of Profile who received a Message.
  // @param $senderId. Integer with the Id of Profile who sent a Message.
  public static function store($receiverId, $senderId)
  {
    auth()->user()->profile->conversationSenders()->create([
      'receiver_id' => $receiverId,
      'sender_id' => $senderId,
      'seen' => 0,
    ]);
  }

}
