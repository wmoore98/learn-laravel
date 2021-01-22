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

    <div class="container">
      <div class="row mb-4">

        <div class="row mb-4">
          @card([
            'title' => 'Most Commented',
            'subtitle' => 'What people are talking about',
            'items' => collect($mostActiveLastMonth)->pluck('name'),
          ])
          @slot('items')
            @foreach ($mostCommented as $post)
              <li class="list-group-item">
                <a class="card-link" href="{{ route('posts.show', ['post' => $post->id]) }}">
                  {{ $post->title }}
                </a>
              </li>
            @endforeach
          @endslot
          @endcard
        </div>
  
        <div class="card" style="width: 100%;">
          <div class="card-body">
            <h5 class="card-title">Most Commented</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              What people are squawking about
            </h6>
            <ul class="list-group list-group-flush">
              @foreach ($mostCommented as $post)
                <li class="list-group-item">
                  <a class="card-link" href="{{ route('posts.show', ['post' => $post->id]) }}">
                    {{ $post->title }}
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        @card([
          'title' => 'Most Active',
          'subtitle' => 'Writers with the most posts',
          'items' => collect($mostActive)->pluck('name'),
        ])
        @endcard
      </div>

      <div class="row mb-4">
        @card([
          'title' => 'Most Active Last Month',
          'subtitle' => 'Writers with the most posts written in the last 30 days',
          'items' => collect($mostActiveLastMonth)->pluck('name'),
        ])
        @endcard
      </div>

    </div>
  </div>
</div>

@endsection