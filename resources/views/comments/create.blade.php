@extends('layouts.app')

@section('content')

<!--

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

-->

<div class="container">

  <form action="/c" enctype="multipart/form-data" method="post">
    @csrf

    <div class="form-group row pr-3">
      <textarea id="commentBody" class="form-control" rows="4" cols="50" placeholder="Comment here...">{{ $commentBody }}</textarea>
    </div>

    <div class="form-group row mb-0">
      <div class="col-md-6 offset-md-4">
        <button class="btn btn-primary">Post comment</button>
      </div>
    </div>

    <input type="hidden" id="postId" value="{{ $post }}">

  </form>

  <div class="card">
    <div class="card-body">Basic card</div>
  </div>
  <div class="card">
    <div class="card-body">Basic card</div>
  </div>

</div>
@endsection
