@extends('layouts.app')

@section('content')

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view shows the profiles the User is following.

  -->

  <div class="d-flex justify-content-center pb-5"><h2>Following</h2></div>

  <div class="d-flex flex-wrap justify-content-center">

    @foreach($followingUsers as $followingUser)

      <div class="pr-4 pb-3">

        <div class="card" style="max-width: 200px">

          <img class="card-img-top" src="{{ $followingUser->user->profile->profileImage() }}">

          <div class="card-body">

            <h4 class="card-title">{{ \Illuminate\Support\Str::limit($followingUser->user->username , 12, $end='...') }}</h4>

            <p class="card-text" style="height: 50px;">
              {{ \Illuminate\Support\Str::limit($followingUser->user->profile->title , 50, $end='...') }}
            </p>

            <p class="card-text" style="height: 110px;">
              {{ \Illuminate\Support\Str::limit($followingUser->user->profile->description , 90, $end='...') ?? "No description" }}
            </p>

            <a href="/profile/{{ $followingUser->user->profile->id }}" class="btn btn-primary stretched-link">Visit Profile</a>

          </div>

        </div>

      </div>

    @endforeach

  </div>

  @if (count($followingUsers) == 0)
    <div class="d-flex flex-column pt-5">
      <div class="d-flex justify-content-center"><h3 style="color:gray;">You don't follow anybody yet!</h3></div>
      <div class="d-flex justify-content-center pt-5"><img src='/storage/images/Shocked-face.png'></div>
    </div>
  @endif

</div>

@endsection
