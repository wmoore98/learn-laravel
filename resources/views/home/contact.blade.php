@extends('layouts.app')

@section('title', 'Contact page')

@section('content')
<h1>Contact page</h1>
@can('home.secret')
  <a href="{{ route('home.secret') }}">Go to Secret Page - shh 🤫</a>
@endcan
@endsection