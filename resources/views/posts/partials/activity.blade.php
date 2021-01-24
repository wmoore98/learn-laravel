<div class="container">
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
