<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class is the controller for Reply made by User to a Comment.

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\Reply;

class RepliesController extends Controller
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  // Ajax request. Returns replies that Comment has.
  // @return json array. Contains replies that Comment has (String with replies, Integer with new reply's start index,
  // Integer with new reply's end index, Boolean that si true if we reached the end of reply's list).
  public function index()
  {
    // Id of comment that we want to see replies of.
    $commentId = isset($_POST['commentId'])?$_POST['commentId']:"";
    // Start index in reply's list.
    $startIdxAux = isset($_POST['startIdx'])?$_POST['startIdx']:"";
    // End index in reply's list.
    $endIdx = isset($_POST['endIdx'])?$_POST['endIdx']:"";
    // Number of replies that we desire to get.
    $numberNewComments = isset($_POST['numberNewComments'])?$_POST['numberNewComments']:"";

    // Try to get all the replies desired. We get 2 more to determine if we reached the end of the list.
    $replies = Reply::orderby('created_at','desc')->select('*')->where('comment_id', $commentId)->limit($endIdx + 2)->get();

    // If the end index is greater than the replies that we got, means we reached the end of the list.
    if ($endIdx >= $replies->count())
    {
      // the new end index will be the end of the list.
      $endIdx = $replies->count() - 1;
      $reachedEndList = true;
    }
    else
    {
        $reachedEndList = false;
    }

    // We move the start index to after the start index.
    $startIdx = $endIdx + 1;

    // String with list of replies.
    $repliesString = "";

    for ($i = $startIdxAux; $i <= $endIdx; $i++)
    {
      $likeButtonImgPath =  $replies[$i]->isLikedByUser() ? '/storage/images/Blue-Like-button.png' : '/storage/images/Like-button.png';

      $repliesString = $repliesString . "
          <div id='reply_{$replies[$i]->id}' class='card flex-row flex-wrap'>
            <div class='card-header border-0'>
                <img class='rounded-circle' src='{$replies[$i]->profile->profileImage()}' alt='' style='max-width:30px'>
            </div>
            <div class='card-block px-2'>
                <span class='card-title font-weight-bold'>{$replies[$i]->profile->user->username}</span>
                <p class='card-text'>{$replies[$i]->body}</p>
                <div id='likeButton' class='container d-flex align-items-center'>
                    <img class='w-100 pr-2' style='max-width:30px;' src='{$likeButtonImgPath}'>
                    <span class='font-weight-bold'>{$replies[$i]->likers->count()}</span>
                </div>
            </div>
          </div>
      ";
    }

    // Move the end index to the new end index when the user wants to see more replies.
    $endIdx += $numberNewComments;

    $response = array("replies"=> $repliesString, "startIdx"=>$startIdx, "endIdx"=>$endIdx, "reachedEndList"=>$reachedEndList);
    return response()->json($response);
 }

 // Ajax request. Stores Reply in DB.
 // @return String.
 public function store()
  {
    // Comment's Id that User wants to reply.
    $commentId = isset($_POST['commentId'])?$_POST['commentId']:"";
    // Text of reply.
    $body = isset($_POST['body'])?$_POST['body']:"";

    Comment::find($commentId)->replies()->create([
        'profile_id' => auth()->user()->profile->id,
        'body' => $body,
    ]);

    return "success";
  }

}
