@extends('layouts.app')

@section('content')

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view shows all the posts from the following Users.

  -->

  @foreach($posts as $post)

    <div class="row">

      <div class="col-6 offset-3">
        <a href="/p/{{ $post->id }}">
          <img src="/storage/{{ $post->image }}"class="w-100">
        </a>
      </div>

    </div>

    <div class="row pt-2 pb-4">

      <div class="col-6 offset-3">

        <div>

          <p class="d-flex align-items-center">

            <span class="pr-3">
              <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100" style="max-width: 40px;">
            </span>

            <span class="font-weight-bold pr-3">
              <a href="/profile/{{ $post->user->id }}">
                <span class="text-dark">{{ $post->user->username }}</span>
              </a>
            </span>{{ $post->caption }}

          </p>

        </div>

        <div class="d-flex justify-content-around">

          <div id="likeButton" class="container d-flex align-items-center justify-content-center">
            <img class="w-100 pr-2" style="max-width:30px;" src='/storage/images/Like-button.png'  >
            <span class="font-weight-bold">{{ $post->likers->count() }}</span>
          </div>

          <div id="commentButton" class="container d-flex align-items-center justify-content-center">
            <img class="w-100 pr-2" style="max-width:30px;" src='/storage/images/Comment-button.png'  >
            <span class="font-weight-bold">{{ $post->comments->count() }}</span>
          </div>

        </div>

      </div>

    </div>

  @endforeach

  <!-- Pagination button -->
  <div class="row">
    <div class="col-12 d-flex justify-content-center">
      {{ $posts->links() }}
    </div>
  </div>

</div>
@endsection
