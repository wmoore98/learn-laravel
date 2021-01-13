<div class="form-group">
  <label for="title">Title</label>
  <input
    class="form-control"
    type="text"
    name="title"
    id="title"
    value="{{ old('title', optional($post ?? null)->title) }}"
  >
</div>

@error('title')
  <div class="alert alert-danger">{{ $message }}</div>
@enderror

<div class="form-group">
  <label for="content">Content</label>
  <textarea
    class="form-control"
    name="content"
    id="content"
  >{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>

@if ($errors->any())
  <div class="mb-3">
    <ul class="list-group">
      @foreach ($errors->all() as $error)
        <li class="list-group-item list-group-item-danger">
          {{ $error }}
        </li>
      @endforeach
    </ul>
  </div>
@endif
