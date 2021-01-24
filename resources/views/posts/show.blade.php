@extends('layouts.app')

@section('title', $post->title)

@section('content')
  <div class="row">
    <div class="col-8">
      <h1>{{ $post->title }}
        @badge([
          'type' => 'success',
          'show' => now()->diffInMinutes($post->created_at) < 30,
          ])
          New          
        @endbadge
        {{--  <x-badge type="info">
          New Syntax
        </x-badge>  --}}
      </h1>
      <p>{{ $post->content }}</p>
    
      @updated(['date' => $post->created_at, 'name' => $post->user->name])
      @endupdated
    
      <x-tags>@slot('tags', $post->tags)</x-tags>
    
      <p>Currently read by {{ $counter }} people</p>
    
      <h4>Comments</h4>
      @if ($post->comments->count() )
        <ul class='list-group'>
          @foreach ($post->comments as $comment)
              <li class="list-group-item">
                {{ $comment->content }} <br>
                <small class="text-muted">added {{ $comment->created_at->diffForHumans() }}</small>
                @updated(['date' => $comment->created_at])
                @endupdated
              </li>
          @endforeach
        </ul>
      @else
        <div>No comments yet!</div>
      @endif
    
    </div>

    <div class="col-4">
      @include('posts.partials.activity')
    </div>  
  </div>
@endsection
