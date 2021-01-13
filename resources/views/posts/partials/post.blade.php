<h3 class='mb-0'>
  <a
    href="{{ route('posts.show', ['post' => $post->id]) }}"
  >{{ $post->title }}</a>
</h3>

<p class="mb-0">Last updated {{ $post->updated_at->diffForHumans() }}</p>

@if ($post->comments_count)
  <p>{{ $post->comments_count }} comments</p>
@else
  <p>No comments yet!</p>
@endif

<div class="mb-5">
  <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
  <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger" type="submit">Delete</button>
  </form>
</div>
