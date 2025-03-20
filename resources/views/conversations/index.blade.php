
@extends('layouts.app')

@section('content')

<link href="{{ asset('css/ConversationIndexBladeStyle.css') }}" rel="stylesheet">

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view shows Conversations Profile has.
  https://www.youtube.com/watch?v=3cmbkEQG8is
  -->

  <input type="hidden" id="profileId" value="{{ auth()->user()->profile->id }}">

  <div class="conversation-message  d-flex">

    <div class="conversations endless-pagination col-4"
    data-next-page="{{ $conversations->nextPageUrl() }}">

      <div class="conversationList">

        @foreach($conversations as $conversation)

          <?php
            $profile = auth()->user()->profile->id == $conversation->receiver->id ?
              $conversation->sender : $conversation->receiver;

            $yourMessage = auth()->user()->profile->id == $conversation->messages[0]->profile->id ?
              true : false;
          ?>

          <div class="conversation d-flex" id="conversation_{{ $conversation->id }}">

            <img src="{{ $profile->profileImage() }}" class="w-100 border-top py-2">

            <div class="align-self-stretch pl-3 border-top py-2">

              <div class="d-flex">
                <h5 id="profileUsername">{{ $profile->user->username }}</h5>
                <div class="pl-3">{{ $conversation->messages[0]->created_at }}</div>
              </div>

              <div id="seenConversation">{{ $conversation->seen == 0 && !$yourMessage ? 'NEW Message!' : '' }}</div>

              <div>
                <strong id="yourMessageSign">{{ $yourMessage ? 'You: ' : '' }}</strong>
                <span id="lastMessage">{{ $conversation->messages[0]->body }}</span>
              </div>

            </div>

          </div>

        @endforeach

      </div>

    <div id="overflowing"></div>

  </div>

  <div class="viewMessages col-8 d-flex flex-column">

    <h3 id="usernameHeader" class="border-bottom py-3 ">Username</h3>

    <div class="messages endless-pagination-message pb-2" data-next-page="">
      <div id="overflowing"></div>
      <div class="messageList">
      </div>
    </div>

    <div id="messageBoxContainer" class="rounded">

      <div class="form-group row pt-3 px-5">
        <input id="messageBox" type="text" class="form-control " name="messageBox" placeholder="Type a message..." disabled>
      </div>

      <div class="form-group row d-flex justify-content-end pb-3 pr-4">
        <img id="sendMessage" src="/storage/images/Send-message-arrow-disabled.png" alt="">
      </div>

    </div>

  </div>

</div>

  <input type="hidden" id="current_user" value="{{ auth()->user()->profile->id }}" />
  <input type="hidden" id="pusher_app_key" value="{{ env('PUSHER_APP_KEY') }}" />
  <input type="hidden" id="pusher_cluster" value="{{ env('PUSHER_APP_CLUSTER') }}" />

  <!--
  Play sound if you user receives a message.
  -->
  <audio id="chat-alert-sound" style="display: none">
    <source src="{{ asset('sound/Message-notification.mp3') }}" />
  </audio>

</div>

@endsection

@push('head')

<!--
Helps to get/send messages live between users.
-->



<script>
  (function($){
  $(document).ready(function() {

    window.conversations = {};

    // Add Event handler when user clicks on a conversation.
    @for ($i = 0; $i < $conversations->count(); $i++)
      window.conversations[{{ $i }}] = {{ $conversations[$i]->id }};
      $(`#conversation_{{ $conversations[$i]->id }}`).click({idx: {{ $i }} }, conversation_click);
    @endfor

  });
})(jQuery);
</script>



@endpush
