@extends('layouts.app')
@section('content')
<h1 class="h3 mb-3">Nueva película</h1>
<form method="POST" action="{{ route('films.store') }}">
  @csrf
  @include('films._form')
</form>
@endsection
