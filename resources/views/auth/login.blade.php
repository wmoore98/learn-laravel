@extends('layouts.app')
@section('title', 'Login')

@section('content')
  <h1>Login</h1>

  <form action="{{ route('login') }}" method="POST">

    @csrf

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
      <div class="form-check">
        <input
          type="checkbox"
          class="form-check-input"
          name="remember"
          id="remember"
          value="{{ old('remember') ? 'checked' : '' }}"
        >
        <label class="form-check-label" for="remember">
          Remember Me
        </label>
      </div>
    </div>

    <button class="btn btn-primary btn-block">Login</button>
    
  </form>
    
@endsection