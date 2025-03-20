<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class is the controller for the comments made by the users.

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\User;
use App\Comment;

class CommentsController extends Controller
{
  
  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  // Creates the view that displays the comments.
  public function create()
  {

    return view('comments.create');

  }

  // Stores a new comment in the DB.
  public function store()
  {

    // We validate the request and then get the validated data.
    $data = request()->validate([
        'commentBody' => 'required',
    ]);

    Post::find(request()->input('postId'))->comments()->create([
        'profile_id' => auth()->user()->profile->id,
        'body' => $data['commentBody'],
    ]);

    return redirect('/p/' . request()->input('postId'));

  }

  // Function used for AJAX method to get a number of comments. Gets all the comments from DB and returns a portion of them
  // starting from a index provided to a final index.
  // @returns json array. Contains : string with comments, array with Ids of comments, array with number of likes for
  // each comment, integer for start index, integer for end index, bool (true if we reached the end of the list).
  public function getComments()
  {

    // Id of the post where the comment was made.
    $postId = isset($_POST['postId'])?$_POST['postId']:"";
    $startIdxAux = isset($_POST['startIdx'])?$_POST['startIdx']:"";
    $endIdx = isset($_POST['endIdx'])?$_POST['endIdx']:"";
    // Number of comments want to be returned
    $numberNewComments = isset($_POST['numberNewComments'])?$_POST['numberNewComments']:"";

    // Try to get all the comments desired. We get 2 more to determine if we reached the end of the list.
    $comments = Comment::orderby('created_at','desc')->select('*')->where('post_id', $postId)->limit($endIdx + 2)->get();

    // If the end index is greater than the comments that we got, means we reached the end of the list.
    if ($endIdx >= $comments->count())
    {
      // the new end index will be the end of the list.
      $endIdx = $comments->count() - 1;
      $reachedEndList = true;
    }
    else
    {
      $reachedEndList = false;
    }

    // We move the start index to after the start index.
    $startIdx = $endIdx + 1;

    // String with lsit of comments.
    $commentString = "";

    // Array of Ids of comments.
    $commentsId = array();
    // Array of number of likes for each comment.
    $likesCounts = array();

    // Gets comments from start index to end index
    for ($i = $startIdxAux; $i <= $endIdx; $i++)
    {
      array_push($commentsId, $comments[$i]->id);
      array_push($likesCounts,  $comments[$i]->likers->count());

      $likeButtonImgPath =  $comments[$i]->isLikedByUser() ? '/storage/images/Blue-Like-button.png' : '/storage/images/Like-button.png';

      $commentString = $commentString . "
        <div id='comment_{$comments[$i]->id}' class='card flex-row flex-wrap'>
          <div class='card-header border-0'>
            <img class='rounded-circle' src='{$comments[$i]->profile->profileImage()}' alt='' style='max-width:30px'>
          </div>
          <div class='card-block px-2'>
            <span class='card-title font-weight-bold'>{$comments[$i]->profile->user->username}</span>
            <p class='card-text'>{$comments[$i]->body}</p>
            <div class='d-flex flex-row pb-2'>
              <div id='likeButton' class='container d-flex align-items-center'>
                <img class='w-100 pr-2' style='max-width:30px;' src='{$likeButtonImgPath}'>
                <span class='font-weight-bold'>{$comments[$i]->likers->count()}</span>
              </div>
              <span id='replyButton' class='font-weight-bold align-items-center'>REPLY</span>
            </div>
      ";

      $replyText = ($comments[$i]->replies->count() == 1) ? 'reply' : 'replies';

      if ($comments[$i]->replies->count() > 0)
      {
        $commentString = $commentString . "
          <div id='seeRepliesButton' class='container d-flex align-items-center pb-2'>
            <img class='w-100 pr-2' style='max-width:30px;' src='/storage/images/Comment-button.png'>
            <span class='font-weight-bold'>See {$comments[$i]->replies->count()} {$replyText}</span>
          </div>
        ";
      }

      $commentString = $commentString . "
          </div>
        </div>
        <div id='displayReplies_{$comments[$i]->id}' class='ml-3'></div>
      ";

    }

    // Move the end index to the new end index when the user wants to see more comments.
    $endIdx += $numberNewComments;

    $response = array("comments"=> $commentString, "commentsId"=> $commentsId, "likesCounts"=> $likesCounts, "startIdx"=>$startIdx, "endIdx"=>$endIdx, "reachedEndList"=>$reachedEndList);
    return response()->json($response);

  }

}
