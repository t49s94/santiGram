@extends('layouts.app')

@section('content')

<link href="{{ asset('css/ProfileIndexBladeStyle.css') }}" rel="stylesheet">

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view shows the information about a Profile

  -->

  <?php
    $isConversationCreated = session('isConversationCreated');
    session()->forget('isConversationCreated');
  ?>

  <div class="row d-flex justify-content-center">
    @if (!is_null($isConversationCreated))
      <h2 style="color:DarkGreen;">Message sent!</h2>
    @endif
  </div>

  <div class="row">

    <div class="col-3 p-5">
      <img src="{{ $user->profile->profileImage() }}" alt="" class="rounded-circle w-100">
    </div>

    <div class="col-9 pt-5">

      <div class="d-flex justify-content-between align-items-baseline">

        <div class="d-flex align-items-center pb-3">

          <div class="h4">{{ $user->username }}</div>

          <!-- We use Vue to create a follow-button. In Vue we can create any number of additional fields to pass data.
           These fields are called props (properties) in Vue-->
           @auth
             @if (Auth::user()->id != $user->id)
              <follow-button  user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
            @endif
          @endauth

        </div>

        @can ('update', $user->profile)
          <a href="/p/create">Add new post</a>
        @endcan

      </div>

      <!-- If the user is allowed to update, "Edit profile" link will be shown -->
      @can ('update', $user->profile)
        <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
      @endcan

      <div class="d-flex">
        <div class="pr-5"><strong>{{ $postCount }}</strong> posts</div>
        <div class="pr-5"><strong>{{ $followerCount }}</strong> followers</div>
        <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
      </div>

      <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
      <div>{{ $user->profile->description }}</div>
      <div><a href="https://www.linkedin.com/in/sergio-eduardo-santillana-l%C3%B3pez-752ba219a/">{{ $user->profile->url }}</a></div>

      <hr>
      <form action="/m" enctype="multipart/form-data" method="post" class="px-3">
        @csrf
        <div class="form-group row">
          <label class="col-form-label">Write a message to {{ $user->username }}:</label>
        </div>

          <div class="form-group row">
            <input id="message" type="text" class="form-control " name="message">

          </div>

          <div class="form-group row d-flex justify-content-end">
            <button id="sendMessage" class="btn">
              <img src="/storage/images/Send-message-arrow.png" alt="" style="max-width:40px;">
            </button>

          </div>

          <input type="hidden" id="receiverId" name="receiverId" value="{{ $user->profile->id }}">
          <input type="hidden" id="receiverUserId" name="receiverUserId" value="{{ $user->id }}">

      </form>

    </div>

    <!-- Shows Profile's posts -->
    <div class="row pt-5">
      @foreach($user->posts as $post)
        <div class="col-4 pb-4">
          <a href="/p/{{ $post->id }}">
            <img src="/storage/{{ $post->image }}" class="w-100">
          </a>
        </div>
      @endforeach
    </div>

  </div>

</div>
@endsection
