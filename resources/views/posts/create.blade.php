@extends('layouts.app')

@section('content')

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view has Post creation form.

  -->

  <form action="/p" enctype="multipart/form-data" method="post">

      <!-- @csrf allows laravel who can post into our form. If we don't do this we can curl into an end point such as
      /p and create any post that an user wants without actually having to go through the website. So we need to limit
      who is authorized to actually hit that empty point and the way that laravel does it is by adding an extremely large key
      to each form and then it can validate that key and say: "Did this come from this server?". If it did then it allows the
      user to post. If it didn't, it will throw a 419 error.
      -->
      @csrf

      <div class="row">
        <div class="col-8 offset-2">

          <div class="row">
            <h1>Add New Post</h1>
          </div>

          <div class="form-group row">

            <input id="caption" type="text" class="form-control{{ $errors->has('caption') ? ' is-invalid' : '' }}"
            name="caption" value="{{ old('caption') }}"
            autocomplete="caption" autofocus>

            @if ($errors->has('caption'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('caption') }}</strong>
              </span>
            @endif

          </div>

          <div class="row">

            <label for="caption" class="col-md-4 col-form-label">Post Image</label>
            <input type="file" class="form-control-file" id="image" name="image">

            @if ($errors->has('image'))
              <strong>{{ $errors->first('image') }}</strong>
            @endif

          </div>

          <div class="row pt-4">
            <button class="btn btn-primary">Add New Post</button>
          </div>

        </div>
      </div>
  </form>

</div>

@endsection
