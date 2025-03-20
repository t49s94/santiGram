<!--

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

Returns next page of conversations.
https://www.youtube.com/watch?v=3cmbkEQG8is
-->

@foreach($conversations as $conversation)

  <?php
    $profile = auth()->user()->profile->id == $conversation->receiver->id ?
      $conversation->sender : $conversation->receiver;

    $yourMessage = auth()->user()->profile->id == $conversation->messages[0]->profile->id ?
      true : false;

    $i = 0;
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

    <input type="hidden" id="newConversation_{{ $i++ }}" value="{{ $conversation->id }}">
    
  </div>

@endforeach

<input type="hidden" id="newConversationsCount" value="{{ $conversations->count() }}">
<div id="overflowing"></div>
