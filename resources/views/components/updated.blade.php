<small class="text-muted mb-2 d-block">
  {{ empty(trim($slot)) ? 'Added' : $slot }} {{ \Carbon\Carbon::parse($date)->diffForHumans() }}
  @if (isset($name))
    @if (isset($userId))
      by <a href="{{ route('users.show', ["user" => $userId]) }}">{{ $name }}</a>        
    @else
      by {{ $name }}
    @endif
  @endif
  @if (isset($lastUpdated))
    <br>Last updated {{ \Carbon\Carbon::parse($lastUpdated)->diffForHumans() }}
  @endif
</small>
