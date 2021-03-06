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
    <div class="invalid-feedback">{{ $message }}</div>
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
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="form-group">
  <label for="thumbnail">Thumbnail</label>
  <input
    class="form-control-file @error('thumbnail')is-invalid @enderror"
    type="file"
    name="thumbnail"
    id="thumbnail"
  >
  @error('thumbnail')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<x-errors></x-errors>