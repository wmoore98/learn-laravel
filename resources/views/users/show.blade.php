@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
  <div class="row">
    <div class="col-md-4">
      <img src="{{ $user->image ? $user->image->url() :'' }}" alt="" class="img-thumbnail avatar">
    </div>

    <div class="col-md-8">
      <h3>{{ $user->name }}</h3>
    </div>
  </div>
@endsection