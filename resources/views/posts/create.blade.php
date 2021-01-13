@extends('layouts.app')

@section('title', 'Create a post')

@section('content')

  <form action="{{ route('posts.store') }}" method="POST">
    @csrf
    @include('posts.partials.form')
    <div><button class="btn btn-primary btn-block" type='submit'>Create</button></div>
  </form>
    
@endsection