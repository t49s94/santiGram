@extends('layouts.app')

@section('content')

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This views shows information about a Post.

  -->

  <div class="row">

    <div class="col-8">
      <img src="/storage/{{ $post->image }}" class="w-100">
    </div>

    <div class="col-4">

      <div>

        <div class="d-flex align-items-center">

          <div class="pr-3">
            <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100" style="max-width: 40px;">
          </div>

          <div>

            <div class="font-weight-bold d-flex align-items-center">

              <a href="/profile/{{ $post->user->id }}" class="pr-3">
                <span class="text-dark">{{ $post->user->username }}</span>
              </a>

              @auth
                <!-- If User isn't looking at his own post, follow-button will show up -->
                @if (Auth::user()->id != $post->user->id)
                  <follow-button  user-id="{{ $post->user->id }}" follows="{{ $follows }}"></follow-button>
                @endif
              @endauth

            </div>

          </div>

        </div>

        <hr>

        <p>
          <span class="font-weight-bold">
            <a href="/profile/{{ $post->user->id }}">
              <span class="text-dark">{{ $post->user->username }}</span>
            </a>
          </span>
        </p>

        <p>{{ $post->caption }}</p>

        <div class="d-flex justify-content-around">

          <like-button class="container d-flex align-items-center justify-content-center"
          component-type="post" component-id="{{ $post->id }}" likes="{{ $likes }}" likes-count="{{ $likesCount }}"></like-button>

          <div id="commentButton" class="container d-flex align-items-center justify-content-center">
            <img class="w-100 pr-2" style="max-width:30px;" src='/storage/images/Comment-button.png'  >
            <span class="font-weight-bold">{{ $post->comments->count() }}</span>
          </div>

        </div>

        <!-- Form to post a comment -->
        <form action="/c" enctype="multipart/form-data" method="post" class="px-3 py-3">

          @csrf

          <div class="form-group row">
            <textarea id="commentBody" name="commentBody" class="form-control" rows="4" cols="50" placeholder="Comment here..."></textarea>
          </div>

          <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
              <button class="btn btn-primary">Post comment</button>
            </div>
          </div>

          <input type="hidden" id="postId" name="postId" value="{{ $post->id }}">

        </form>

        <div id="displayComments">

          @for ($i = 0; $i < $commentCount; $i++)

            <div id="comment_{{ $comments[$i]->id }}" class="card flex-row flex-wrap">

              <div class="card-header border-0">
                <img class="rounded-circle" src="{{ $comments[$i]->profile->profileImage() }}" alt="" style="max-width:30px">
              </div>

              <div class="card-block px-2">

                <span class="card-title font-weight-bold">{{ $comments[$i]->profile->user->username }}</span>
                <p class="card-text">{{ $comments[$i]->body }}</p>

                <div class="d-flex flex-row pb-2">

                  <div id="likeButton" class="container d-flex align-items-center">
                    <img class="w-100 pr-2" style="max-width:30px;" src="{{ $likesComment[$i] }}"  >
                    <span class="font-weight-bold">{{ $comments[$i]->likers->count() }}</span>
                  </div>

                  <span id="replyButton" class='font-weight-bold align-items-center'>REPLY</span>

                </div>

                <?php
                  $replyText = ($comments[$i]->replies->count() == 1) ? 'reply' : 'replies' ;
                ?>

                <!-- If comment has any replies, show seeRepliesButton -->
                @if ($comments[$i]->replies->count() > 0)
                  <div id='seeRepliesButton' class='container d-flex align-items-center pb-2'>
                    <img class='w-100 pr-2' style='max-width:30px;' src='/storage/images/Comment-button.png'>
                    <span class='font-weight-bold'>See {{$comments[$i]->replies->count()}} {{ $replyText }}</span>
                  </div>
                @endif

              </div>

            </div>

            <!-- Where replies are gonna be shown -->
            <div id='displayReplies_{{ $comments[$i]->id }}' class='ml-3'></div>

          @endfor

          <!-- If there are still comments that haven't been shown, show loadComments button  -->
          @if ($comments->count() > $numberNewComments)
            <p id="loadComments" class="py-2">Load more comments...</p>
          @endif

        </div>

      </div>

    </div>

  </div>

</div>

@endsection

@push('head')

  <link rel="stylesheet" href="{{ asset('css/PostShowBladeStyle.css') }}">

  <!-- Scripts -->

  <script>

    window.postId = {{ $post->id }};
    window.comments = {};
    window.numberNewComments = {{ $numberNewComments }};

    @for ($i = 0; $i < $commentCount; $i++)
      window.comments[{{ $i }}] = { id: {{ $comments[$i]->id }}, likesCount: {{ $comments[$i]->likers->count() }} };
    @endfor

  </script>
  
  <script src="{{ asset('js/PostShowBladeJS.js')}}" defer></script>


@endpush
