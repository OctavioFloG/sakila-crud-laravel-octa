@extends('layouts.app')
@section('content')
<h1 class="h3">Actor #{{ $actor->actor_id }}</h1>

<div class="card mb-3">
  <div class="card-body">
    <p class="mb-1"><strong>Nombre:</strong> {{ $actor->first_name }} {{ $actor->last_name }}</p>
  </div>
</div>

<a href="{{ route('actors.edit', $actor) }}" class="btn btn-primary">Editar</a>
<a href="{{ route('actors.index') }}" class="btn btn-light">Volver</a>
@endsection
