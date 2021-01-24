@if ($errors->any())
  <div class="mt-3 mb-3">
      @foreach ($errors->all() as $error)
        <div class="alert alert-danger mb-1" role="alert">
          {{ $error }}
        </div>
      @endforeach
  </div>
@endif