<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class is the controller for Profile user has.

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

use App\Profile;
use DB;

class ProfilesController extends Controller
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  // Shows Profile page.
  // @param $user. User that owns Profile.
  // @return View. View that contains Profile.
  public function index(User $user)
  {
    //$isConversationCreated = isset($_POST['isConversationCreated'])?$_POST['isConversationCreated']:-1;

    // If the user is authenticated then asks if the following contains the user
    $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

    // Store post count in cache using remember. (key, duration, function)
    $postCount = Cache::remember('count.posts.' . $user->id, now()->addSeconds(30),
    function () use ($user) {
        return $user->posts->count();
    });

    $followerCount = Cache::remember('count.followers.' . $user->id, now()->addSeconds(30),
    function () use ($user) {
        return $user->profile->followers->count();
    });

    $followingCount = Cache::remember('count.following.' . $user->id, now()->addSeconds(30),
    function () use ($user) {
        return $user->following->count();
    });

    return view('profiles.index', compact('user', 'follows', 'postCount', 'followerCount', 'followingCount'));
  }

  // Shows Followers page.
  // @param $user. User who owns followers.
  // @return View. View that contains the profiles that follow User.
  public function followers(User $user)
  {
    $followers = $user->profile->followers;
    return view('profiles.followers', compact('user', 'followers'));
  }

  // Shows Following page.
  // @param $user. User who follows profiles.
  // @return View. View that contains the profiles that fUser follows.
  public function following(User $user)
  {
    $followingUsers = $user->following;
    return view('profiles.following', compact('user', 'followingUsers'));
  }

  // Ajax request for #profileSearch input. Get the profiles that match the input from the user.
  // @param $request. Request that contains the Profile's name that User wants to find.
  // @return json array. Contains profiles that match the criteria. (profile's id, profile's name).
  public function getProfiles(Request $request)
  {
    $search = $request->search;

    if($search == '')
    {
       $profiles = DB::table('users')
        ->join('profiles', 'users.id', '=', 'profiles.user_id')
        ->select('profiles.id', 'users.name')
        ->limit(5)
        ->get();
    }
    else
    {
      $profiles = DB::table('users')
       ->join('profiles', 'users.id', '=', 'profiles.user_id')
       ->select('profiles.id', 'users.name')
       ->where('users.name', 'like', '%' .$search . '%')
       ->limit(5)
       ->get();
    }

    $response = array();
    foreach($profiles as $profile){
       $response[] = array("value"=>$profile->id,"label"=>$profile->name);
    }

    return response()->json($response);
 }


  // Shows Profile Edit page.
  // We pass "User $user" so we won't have to call User::findOrFail($user) like in index function.
  // @param $user. User that owns Profile.
  // @return View. View that contains a form to update Profile.
  public function edit(\App\User $user)
  {
    // We protect the view by using authorize. Prevents a person to get to the view if it hasn't logged in
    $this->authorize('update', $user->profile);
    // We use compact so we won't have to pass array
    return view('profiles.edit', compact('user'));
  }

  // Update Profile.
  // @param $user. User that owns Profile.
  // @return Page. Redirects to User's Profile.
  public function update(User $user)
  {
    // If person isn't logged, this will prevent him to updatwe a profile.
    $this->authorize('update', $user->profile);

    $data = request()->validate([
      'title' => 'required',
      'description' => 'required',
      'url' => 'url',
      'image' => '',
    ]);

    if(request('image'))
    {
      $imagePath = request('image')->store('profile', 'public');

      $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000,1000);
      $image->save();

      $ImageArray = ['image' => $imagePath];
    }

    // auth() forces the user to be authorized so no person can edit a profile who wasn't logged in.
    auth()->user()->profile->update(array_merge(
        $data,
        // If $ImageArray isn't set, pass empty array
        $ImageArray ?? []
    ));

    return redirect("/profile/{$user->id}");
  }

}
