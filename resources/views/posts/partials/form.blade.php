<div class="form-group">
  <label for="title">Title</label>
  <input
    class="form-control @error('title')is-invalid @enderror"
    type="text"
    name="title"
    id="title"
    value="{{ old('title', optional($post ?? null)->title) }}"
  >
  @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
  @enderror
</div>

<div class="form-group">
  <label for="content">Content</label>
  <textarea
    class="form-control @error('content')is-invalid @enderror"
    name="content"
    id="content"
  >{{ old('content', optional($post ?? null)->content) }}</textarea>
  @error('content')
    <div class="alert alert-danger">{{ $message }}</div>
  @enderror
</div>

<x-errors></x-errors>