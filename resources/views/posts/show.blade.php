@extends('layouts.app')

@section('title', $post->title)

@section('content')
  <div class="row">
    <div class="col-8">
      @if ($post->image)
        <div style="background-image: url('{{ $post->image->url() }}'); min-height: 30rem; color: white; text-align: center; background-attachment: fixed;">
          <h1 style="padding-top: 6.25rem; text-shadow: 1px 2px #000">
      @else
        <h1>
      @endif
        {{ $post->title }}
        @badge([
          'type' => 'success',
          'show' => now()->diffInMinutes($post->created_at) < 30,
          ])
          New          
        @endbadge
      @if ($post->image)
          </h1>
        </div>
      @else
        </h1>
      @endif

      <p>{{ $post->content }}</p>
    
      @updated(['date' => $post->created_at, 'name' => $post->user->name, 'userId' => $post->user->id])
        @if ($post->created_at->diffForHumans() !== $post->updated_at->diffForHumans())
          @slot('lastUpdated', $post->updated_at)
        @endif
      @endupdated
    
      <x-tags>@slot('tags', $post->tags)</x-tags>
    
      <p>Currently read by {{ $counter }} people</p>
    
      <h4>Comments</h4>

      <x-comment-form route="{{ route('posts.comments.store', $post) }}"></x-comment-form>
      <x-comment-list>@slot('comments', $post->comments)</x-comment-list>
    </div>

    <div class="col-4">
      @include('posts.partials.activity')
    </div>  
  </div>
@endsection
