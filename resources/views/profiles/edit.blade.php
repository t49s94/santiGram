@extends('layouts.app')

@section('content')

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view has form to edit User's Profile.

  -->

  <form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">

    <!-- @csrf allows laravel who can post into our form. If we don't do this we can curl into an end point such as
    /p and create any post that an user wants without actually having to go through the website. So we need to limit
    who is authorized to actually hit that empty point and the way that laravel does it is by adding an extremely large key
    to each form and then it can validate that key and say: "Did this come from this server?". If it did then it allows the
    user to post. If it didn't, it will throw a 419 error.
    -->
    @csrf

    <!-- We say we will use method "PATCH" to edit profile  -->
    @method('PATCH')

    <div class="row">

      <div class="col-8 offset-2">

        <div class="row">
          <h1>Edit Profile</h1>
        </div>

        <div class="form-group row">

          <label for="title" class="col-md-4 col-form-label">Title</label>

          <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
          name="title" value="{{ old('title') ?? $user->profile->title }}"
          autocomplete="title" autofocus>

          @if ($errors->has('title'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('title') }}</strong>
            </span>
          @endif

        </div>

        <div class="form-group row">

          <label for="description" class="col-md-4 col-form-label">Description</label>

          <input id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
          name="description" value="{{ old('description') ?? $user->profile->description }}"
          autocomplete="description" autofocus>

          @if ($errors->has('description'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('description') }}</strong>
            </span>
          @endif

        </div>

        <div class="form-group row">

          <label for="url" class="col-md-4 col-form-label">URL</label>

          <input id="url" type="text" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}"
          name="url" value="{{ old('url') ?? $user->profile->url }}"
          autocomplete="url" autofocus>

          @if ($errors->has('url'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('url') }}</strong>
            </span>
          @endif

        </div>

        <div class="row">

          <label for="caption" class="col-md-4 col-form-label">Profile Image</label>
          <input type="file" class="form-control-file" id="image" name="image">

          @if ($errors->has('image'))
            <strong>{{ $errors->first('image') }}</strong>
          @endif

        </div>

        <div class="row pt-4">
          <button class="btn btn-primary">Save Profile</button>
        </div>

      </div>

    </div>

  </form>

</div>

@endsection
