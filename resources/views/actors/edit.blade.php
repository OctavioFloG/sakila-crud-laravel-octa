@extends('layouts.app')
@section('content')
<h1 class="h3 mb-3">Editar actor #{{ $actor->actor_id }}</h1>
<form method="POST" action="{{ route('actors.update', $actor) }}">
  @csrf @method('PUT')
  @include('actors._form')
</form>
@endsection
