@extends('layouts.app')

@section('title', 'Edit a post')

@section('content')

  <form
    action="{{ route('posts.update', ['post' => $post->id]) }}"
    method="POST"
    enctype="multipart/form-data"
  >
    @csrf
    @method('PUT')
    @include('posts.partials.form')
    <div><button class="btn btn-primary btn-block" type='submit'>Update</button></div>
  </form>
    
@endsection