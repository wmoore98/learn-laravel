@extends('layouts.app')
@section('title', 'Register')

@section('content')
  <h1>Register</h1>

  <form action="{{ route('register') }}" method="post">

    @csrf

    <div class="form-group">
      <label for="name">Name</label>
      <input
        type="text"
        name="name"
        id="name"
        value="{{ old('name') }}"
        required
        class="form-control @error('name') is-invalid @enderror"
      >

      @error('name')
        <div class="invalid-feedback">
          <b>{{ $errors->first('name') }}</b>
        </div>
      @enderror

    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input
        type="email"
        name="email"
        id="email"
        value="{{ old('email') }}"
        required
        class="form-control @error('email') is-invalid @enderror"
      >

      @error('email')
        <div class="invalid-feedback">
          <b>{{ $errors->first('email') }}</b>
        </div>
      @enderror

    </div>
    
    <div class="form-group">
      <label for="password">Password</label>
      <input
        type="password"
        name="password"
        id="password"
        required
        class="form-control @error('password') is-invalid @enderror"
      >

      @error('password')
        <div class="invalid-feedback">
          <b>{{ $errors->first('password') }}</b>
        </div>
      @enderror

    </div>
    
    <div class="form-group">
      <label for="password_confirm">Confirm Password</label>
      <input
        type="password"
        name="password_confirmation"
        id="password_confirmation"
        required
        class="form-control"
      >
    </div>

    <button class="btn btn-primary btn-block">Register</button>
    
  </form>
    
@endsection