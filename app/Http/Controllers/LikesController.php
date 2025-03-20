<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class is the controller for Likes to posts, comments and replies.

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Comment;
use Illuminate\Support\Str;

class LikesController extends Controller
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

  // Stores a Like to a post in DB.
  // @param Post. Post that a user liked.
  // @return array. Array that shows if the Like to Post was attached or detached.
  public function storePost(Post $post)
  {
    $result = auth()->user()->likingPost()->toggle($post);

    // If attached is empty means a user stopped liking a Post.
    if(!empty($result['attached']))
    {
      auth()->user()->profile->notificationSenders()->create([
        'receiver_id' => $post->user->profile->id,
        'sender_id' => auth()->user()->profile->id,
        'post_id' => $post->id,
        'notification_type' => "New like to post",
        'body' => auth()->user()->username . ' likes your post "' . Str::limit($post->caption , 50, $end='...') . '".' ,
        'seen' => 0,
      ]);
    }

    return $result;
  }

  // Stores a Like to a Comment in DB.
  // @param Comment. Comment that a user liked.
  // @return array. Array that shows if the Like to Comment was attached or detached.
  public function storeComment(Comment $comment)
  {
    $result = auth()->user()->likingComment()->toggle($comment);

    // If attached is empty means a user stopped liking a Comment.
    if(!empty($result['attached']))
    {
      auth()->user()->profile->notificationSenders()->create([
        'receiver_id' => $comment->profile->id,
        'sender_id' => auth()->user()->profile->id,
        'post_id' => $comment->post->id,
        'notification_type' => "New like to comment",
        'body' => auth()->user()->username . ' likes your comment "' . Str::limit($comment->body , 50, $end='...') . '".' ,
        'seen' => 0,
      ]);
    }

    return $result;
  }
  
}
