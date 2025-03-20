<!--

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

Returns messages for conversations/index.blade.php.
-->

<!--
Returns next page of messages
-->
@isset($messages)

  @for ($i = ($messages->count() - 1); $i >= 0 ; $i--)

    <?php
    $yourMessage = auth()->user()->profile->id == $messages[$i]->profile->id ? true : false;
     ?>

    <div class="message d-flex align-items-center pt-3 {{ $yourMessage ? 'flex-row-reverse' : '' }}">

      <div class="px-3">
        <img src="{{ $messages[$i]->profile->profileImage() }}" class=" rounded-circle" style="max-width: 50px">
      </div>

      <div class="rounded p-2" style="background-color:{{ $yourMessage ? 'DarkSeaGreen' : 'Wheat' }};">
        <div>
          {{ $messages[$i]->body }}
        </div>
        <div class="pt-2 font-weight-bold">
            {{ $messages[$i]->created_at->format('Y-m-d h:i a') }}
        </div>
      </div>

    </div>

  @endfor

<!--
In case user Sends a message, It is appended not prepended.
-->
@else

<?php
$yourMessage = auth()->user()->profile->id == $message->profile->id ? true : false;
 ?>

<div class="message d-flex align-items-center pt-3 {{ $yourMessage ? 'flex-row-reverse' : '' }}">

  <div class="px-3">
    <img src="{{ $message->profile->profileImage() }}" class=" rounded-circle" style="max-width: 50px">
  </div>

  <div class="rounded p-2" style="background-color:{{ $yourMessage ? 'DarkSeaGreen' : 'Wheat' }};">
    <div>
      {{ $message->body }}
    </div>
    <div class="pt-2 font-weight-bold">
        {{ $message->created_at->format('Y-m-d h:i a') }}
    </div>
  </div>

</div>

@endisset
