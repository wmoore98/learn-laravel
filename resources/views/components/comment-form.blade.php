<div class="mb-2">
  @auth
    <form action="{{ $route }}" method="POST">
      @csrf
      <legend style="font-size: medium">Add a comment</legend>
      <div class="form-group">
        <textarea
          name="content"
          class="form-control @error('content')is-invalid @enderror"></textarea>
        @error('content')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <button class="btn btn-primary btn-block" type='submit'>Add comment</button>
    </form>
  @else
    <a href="{{ route('login') }}">Sign in</a> to post comments
  @endauth
  <x-errors></x-errors>
</div>
<hr>
