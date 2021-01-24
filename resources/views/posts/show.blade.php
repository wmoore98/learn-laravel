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
        @if ($post->created_at->diffForHumans() !== $post->updated_at->diffForHumans())
          @slot('lastUpdated', $post->updated_at)
        @endif
      @endupdated
    
      <x-tags>@slot('tags', $post->tags)</x-tags>
    
      <p>Currently read by {{ $counter }} people</p>
    
      <h4>Comments</h4>
      @if ($post->comments->count() )
        <ul class='list-group'>
          @foreach ($post->comments as $comment)
              <li class="list-group-item">
                {{ $comment->content }} <br>
                @updated(['date' => $comment->created_at, 'name' => $comment->user->name])
                  @if ($comment->created_at->diffForHumans() !== $comment->updated_at->diffForHumans())
                    @slot('lastUpdated', $comment->updated_at)
                  @endif
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
