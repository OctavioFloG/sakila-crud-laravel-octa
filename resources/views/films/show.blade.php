@extends('layouts.app')

@section('content')
<h1 class="h3 mb-3">{{ $film->title }} <small class="text-muted">#{{ $film->film_id }}</small></h1>

<div class="row g-3">
  <div class="col-lg-8">
    <div class="card mb-3">
      <div class="card-body">
        <p class="mb-2"><strong>Año:</strong> {{ $film->release_year ?? '—' }}</p>
        <p class="mb-2"><strong>Language ID:</strong> {{ $film->language_id }}</p>
        <p class="mb-2"><strong>Tarifa:</strong> ${{ number_format($film->rental_rate,2) }}</p>
        <p class="mb-2"><strong>Duración renta:</strong> {{ $film->rental_duration }} días</p>
        <p class="mb-0"><strong>Descripción:</strong><br>{{ $film->description ?? '—' }}</p>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">Actores</div>
      <div class="card-body">
        @if($film->actors->isEmpty())
        <em>Sin actores vinculados.</em>
        @else
        <ul class="mb-0">
          @foreach($film->actors as $a)
          <li>{{ $a->first_name }} {{ $a->last_name }}</li>
          @endforeach
        </ul>
        @endif
      </div>
    </div>

    <a href="{{ route('films.edit', $film) }}" class="btn btn-primary">Editar</a>
    <a href="{{ route('films.index') }}" class="btn btn-light">Volver</a>
    <a href="{{ route('rentals.create', ['film_id' => $film->film_id]) }}"
      class="btn btn-success">
      Rentar esta película
    </a>

  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">Inventario por tienda</div>
      <div class="card-body">
        @if($film->inventories->isEmpty())
        <em>No hay copias registradas.</em>
        @else
        <ul class="list-group list-group-flush">
          @foreach($film->inventories as $inv)
          @php
          $rented = $inv->rentals()->whereNull('return_date')->exists();
          @endphp
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Inv #{{ $inv->inventory_id }} | Store {{ $inv->store_id }}
            <span class="badge {{ $rented ? 'bg-danger' : 'bg-success' }}">
              {{ $rented ? 'Rentado' : 'Disponible' }}
            </span>
          </li>
          @endforeach
        </ul>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection