<p class="text-muted mb-0">
  {{ empty(trim($slot)) ? 'Added' : $slot }} {{ \Carbon\Carbon::parse($date)->diffForHumans() }}
  @if (isset($name))
    by {{ $name }}
  @endif
</p>
