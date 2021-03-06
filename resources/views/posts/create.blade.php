@extends('layouts.app')

@section('title', 'Create a post')

@section('content')

  <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('posts.partials.form')
    <button class="btn btn-primary btn-block" type='submit'>Create</button>
  </form>
    
@endsection