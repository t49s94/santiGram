<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class is the controller for Messages sent by Profiles.

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PusherFactory;
use App\Conversation;
use App\Message;

class MessagesController extends Controller
{
  protected $messagesPerPage = 5;

  //----------------------------------------------------------------------------------------------------------------------------
  // Constructor

  public function __construct()
  {
    // Without this if user isn't authenticated, the store() will fail because user is null
    $this->middleware('auth');
  }

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  // Shows messages in next page.
  // @param Request.
  // @return Array. [Messages, Next page's URL]
  public function index(Request $request)
  {
    $conversationId = isset($_GET['conversationId'])?$_GET['conversationId']:"";

    $messages = Message::where('conversation_id', $conversationId)
                              ->latest()
                              ->paginate($this->messagesPerPage);

    // If conversation the messages belong to hasn't been seen.
    if($messages[0]->conversation->seen == 0)
    {
      $messages[0]->conversation->seen = 1;
      $messages[0]->conversation->save();
    }

    if($request->ajax())
    {
      return [
        'messages' => view('messages.index')->with(compact('messages'))->render(),
        'next_page' => $messages->nextPageUrl(),
      ];
    }
  }

  // Stores message in DB.
  // @return. Redirects.
  public static function store()
  {
    // We validate the request and then get the validated data.
    $data = request()->validate([
      'message' => 'required',
    ]);

    // Get conversation between the 2 profiles.
    $conversationAux = Conversation::where('receiver_id', auth()->user()->profile->id)
                                  ->where('sender_id', request()->input('receiverId'))
                                  ->orwhere(function($q) {
                                      $q->where('receiver_id', request()->input('receiverId'))
                                        ->where('sender_id', auth()->user()->profile->id);
                                    })
                                  ->get();

    // If there's no conversation, creates it.
    if(count($conversationAux) == 0)
    {
      $conversation = Conversation::create([
        'sender_id' => auth()->user()->profile->id,
        'receiver_id' => request()->input('receiverId'),
        'seen' => 0,
      ]);

      $isConversationCreated = 1;
    }
    else
    {
      // When you're using get() you get a collection. In this case you need to iterate over it to get properties or
      // Or you could just get one of objects by it's index
      $conversation = $conversationAux[0];
      $isConversationCreated = 0;

      $conversation->seen = 0;
      $conversation->save();
    }

    $receiverUser = $conversation->receiver->id = auth()->user()->id ?
      $conversation->sender->user : $conversation->receiver->user;

    $message = new Message;
    $message->conversation_id = $conversation->id;
    $message->profile_id = auth()->user()->profile->id;
    $message->body = $data['message'];
    $message->save();

    return redirect('/profile/' . request()->input('receiverId'))->with('isConversationCreated', $isConversationCreated);
  }

  // Stores new Message in DB. Function for "img id='sendMessage'".
  // @return. View with new Message appended.
  public function sendMessage()
  {
    $conversationId = isset($_GET['conversationId'])?$_GET['conversationId']:"";
    $messageBody = isset($_GET['message'])?$_GET['message']:"";

    $message = new Message;
    $message->conversation_id = $conversationId;
    $message->profile_id = auth()->user()->profile->id;
    $message->body = $messageBody;
    $message->save();

    $message->conversation->seen = 0;
    $message->conversation->save();

    // fires a new event with data and it takes three parameters [channel name, event name, array of data]
    PusherFactory::make()->trigger('chat', 'sendMessage_click', ['data' => $message]);

    return [
      'message' => view('messages.index')->with(compact('message'))->render()
    ];

  }

  // Gets a message.
  // @returns. View with the message.
  public function getMessage()
  {
    $id = isset($_GET['messageId'])?$_GET['messageId']:"";
    $message = Message::find($id);

    return [
      'message' => view('messages.index')->with(compact('message'))->render()
    ];
  }

}
