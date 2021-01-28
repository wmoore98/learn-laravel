@if (count($comments) )
  <ul class='list-group'>
    @foreach ($comments as $comment)
        <li class="list-group-item">
          {{ $comment->content }} <br>
          @updated([
            'date' => $comment->created_at,
            'name' => $comment->user->name,
            'userId' => $comment->user->id,
          ])
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
