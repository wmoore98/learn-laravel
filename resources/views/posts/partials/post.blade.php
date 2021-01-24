<h3 class='mb-0'>
  @if ($post->trashed())
    <del>
  @endif
  <a class="{{ $post->trashed() ? 'text-muted' : '' }}"
    href="{{ route('posts.show', ['post' => $post->id]) }}"
  >
    {{ $post->title }}
  </a>
  @if ($post->trashed())
    </del>
  @endif
</h3>

{{--  @updated(['date' => $post->created_at, 'name' => $post->user->name])
@endupdated  --}}

<x-updated date="{{ $post->created_at }}" name="{{ $post->user->name }}">
  @if ($post->created_at->diffForHumans() !== $post->updated_at->diffForHumans())
    @slot('lastUpdated', $post->updated_at)
  @endif
</x-updated>

<x-tags>@slot('tags', $post->tags)</x-tags>

@if ($post->comments_count)
  <small class="d-block text-muted mb-3">{{ $post->comments_count }} comments</small>
@else
  <p>No comments yet!</p>
@endif

<div class="mb-5">
  @can('update', $post)
    <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
  @endcan
  @if (!$post->trashed())
    @can('delete', $post)
      <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    @endcan
  @endif

</div>
