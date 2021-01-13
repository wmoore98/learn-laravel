@extends('layouts.app')

@section('title', $post->title)

@section('content')
  <h1>{{ $post->title }}
     @if (now()->diffInMinutes($post->created_at) < 15)
      <span class="badge badge-secondary">New</span>
    @endif
  </h1>
  <p>{{ $post->content }}</p>
  <p>Added {{ $post->created_at->diffForHumans() }}</p>

  @if (now()->diffInMinutes($post->created_at) < 15)
    <div class="alert alert-info">New!</div>
  @endif

  <h4>Comments</h4>
  @if ($post->comments->count() )
    <ul class='list-group'>
      @foreach ($post->comments as $comment)
          <li class="list-group-item">
            {{ $comment->content }} <br>
            <small class="text-muted">added {{ $comment->created_at->diffForHumans() }}</small>
          </li>
      @endforeach
    </ul>
  @else
    <div>No comments yet!</div>
  @endif
@endsection
