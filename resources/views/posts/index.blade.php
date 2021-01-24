@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="row">
  <div class="col-8">
    {{-- @each('posts.partials.post', $posts, 'post') --}}
    @forelse ($posts as $key => $post)
      @include('posts.partials.post', [])
    @empty
    No posts found!
    @endforelse
  </div>
  <div class="col-4">
    @include('posts.partials.activity')
  </div>
</div>

@endsection