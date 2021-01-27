@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
  <form
    action="{{ route('users.update', $user) }}"
    method="POST"
    enctype="multipart/form-data"
    class="form-horizontal"
  >
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-md-4">
        <img
          src="{{ $user->image ? $user->image->url() : '' }}"
          alt=""
          class="img-thumbnail avatar @error('avatar')is-invalid @enderror">
        <div class="card mt-4">
          <div class="card-body">
            <h6>Upload a different photo</h6>
            <input type="file" class="form-control-file" name="avatar">
          </div>
        </div>
        @error('avatar')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
  
      <div class="col-md-8">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" name="name" id="name" value="">
        </div>

        <div class="form-group">
          <button class="btn btn-primary" type="submit">Save changes</button>
        </div>
  
      </div>
    </div>

  </form>
@endsection