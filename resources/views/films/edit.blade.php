@extends('layouts.app')
@section('content')
<h1 class="h3 mb-3">Editar película #{{ $film->film_id }}</h1>
<form method="POST" action="{{ route('films.update', $film) }}">
  @csrf @method('PUT')
  @include('films._form')
</form>
@endsection
