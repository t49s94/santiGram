<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class is the controller for Post made by User.

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Post;

use App\User;

class PostsController extends Controller
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Constructor

  // Requires a user to be logged in if he wants to create a post. If he isn't logged in, he'll be sent to login page
  public function __construct()
  {
    $this->middleware('auth');
  }

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  // Shows Posts page.
  // @return view. View that contains Posts from Users followed by User.
  public function index()
  {
    // Get the ids of all of the users that the user is following
    $users = auth()->user()->following()->pluck('profiles.user_id');

    // Get the posts that the users the user is following has made. with() method tackle down n +1 problem. n+1 problems mean
    // that when we're loading the user we do it like this: select * from "users" where "users".id = ? limit 1 which means we're
    // loading users one at the time. Method with(nameOfMethodThatCreatesRelationship) grabs users all at once:
    // select * from "users" where "users"."id" in (3). 'user' param from with() comes from Posts.user()
    //$posts = Post::whereIn('user_id', $users)->with('user')->orderBy('created_at', 'DESC')->get();
    // Option 2, latest()
    //$posts = Post::whereIn('user_id', $users)->with('user')->latest()->get();
    //Option 3, paginate()
    $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

    return view('posts.index', compact('posts'));
  }

  // Shows Post creation page.
  // @return view. View that contains a form for User to make a Post.
  public function create()
  {
    return view('posts.create');
  }

  // Stores Post in DB.
  // @return. Redirects to User's Profile.
  public function store()
  {
    // We validate the request and then get the validated data.
    $data = request()->validate([
        'caption' => 'required',
        'image' => 'required|image',
    ]);

    //(dir, driver used to store the file)
    $imagePath = request('image')->store('uploads', 'public');

    //fit(witdth, height) doesn't resize image, just cut it
    $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
    $image->save();

    // We get the authenticated user, get his posts and use function create to create a post
    auth()->user()->posts()->create([
        'caption' => $data['caption'],
        'image' => $imagePath,
    ]);

    return redirect('/profile/' . auth()->user()->id);
  }

  // Shows Post page.
  // @return Post. Post that wants to be seen.
  // @return View. View that contains information about Post.
  public function show(\App\Post $post)
  {
    // If the user is authenticated then asks if the following contains the user
    $follows = (auth()->user()) ? auth()->user()->following->contains($post->user->id) : false;
    // Determine if User likes Post.
    $likes = (auth()->user()) ? auth()->user()->likingPost->contains($post->user->id) : false;
    // Get number of likes that Post has.
    $likesCount = $post->likers->count();
    $comments = $post->comments;

    $likesComment = array();
    foreach($comments as $comment)
    {
      array_push($likesComment, $comment->isLikedByUser() ?
      '/storage/images/Blue-Like-button.png' : '/storage/images/Like-button.png');
    }

    // Number of comments that are gonna be shown in the beginning.
    $numberNewComments = 10;
    // If the number of comments got from DB are less than the number of comments that we want to show,
    // just show the comments we actually have.
    $commentCount = $comments->count() >= $numberNewComments ? $numberNewComments : $comments->count();

    // compact will match post equal to a variable named $post. It's an alternative for passing an array
    return view('posts.show',compact('post', 'follows', 'comments', 'likesComment', 'likes',
    'likesCount', 'numberNewComments', 'commentCount'));
  }

}
