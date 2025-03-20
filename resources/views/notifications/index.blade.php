@extends('layouts.app')

<link rel="stylesheet" type="text/css" href="{{ url('/css/NotificationIndexStyle.css') }}" />

@section('content')
<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view shows Notifications User has.

  -->

  @foreach($notifications as $notification)

    @if ($notification->seen == 0)
      <div id="notification_{{ $notification->id }}" class="card flex-row text-white bg-primary flex-wrap">
        <?php
          $notification->seen = 1;
          $notification->save();
        ?>

        @else
          <div id="notification_{{ $notification->id }}" class="card flex-row text-white bg-secondary flex-wrap">

        @endif
          <div class="card-header border-0">
            <a href="/profile/{{ $notification->sender->id }}">
              <img class="rounded-circle" src="{{ $notification->sender->profileImage() }}" alt="" style="max-width:30px">
            </a>
          </div>
          <div class="card-block px-2">
            <a href="/p/{{ $notification->post->id ?? $notification->sender->id }}" class="a_toPost">
              <span class="card-title font-weight-bold">{{ $notification->created_at }}</span>
              <p class="card-text">{{ $notification->body }}</p>
            </a>
          </div>
        </div>

    @endforeach

    <!-- Pagination button -->
    <div class="row pt-4">
      <div class="col-12 d-flex justify-content-center">
        {{ $notifications->links() }}
      </div>
    </div>

  </div>

</div>
@endsection
