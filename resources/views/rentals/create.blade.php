@extends('layouts.app')

@section('content')
<h1 class="h3 mb-3">Registrar renta</h1>

<form method="POST" action="{{ route('rentals.store') }}">
  @csrf

  <div class="card">
    <div class="card-body">
      <div class="row g-3">
        <div class="col-lg-6">
          <label class="form-label">Película</label>
          @php
            $prefilm = old('film_id', $selectedFilmId ?? request('film_id'));
          @endphp

          <select name="film_id" class="form-select" required>
            <option value="" disabled {{ $prefilm ? '' : 'selected' }}>Selecciona película…</option>
            @foreach($films as $f)
              <option value="{{ $f->film_id }}" {{ (int)$prefilm == (int)$f->film_id ? 'selected' : '' }}>
                #{{ $f->film_id }} — {{ $f->title }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-lg-2">
          <label class="form-label">Store ID</label>
          <input type="number" name="store_id" class="form-control" min="1"
                 value="{{ old('store_id', 1) }}" required>
        </div>

        <div class="col-lg-4">
          <label class="form-label">Cliente</label>
          <select name="customer_id" class="form-select" required>
            @foreach($customers as $c)
              <option value="{{ $c->customer_id }}"
                {{ (int)old('customer_id') === $c->customer_id ? 'selected' : '' }}>
                #{{ $c->customer_id }} — {{ $c->full_name ?? ($c->first_name.' '.$c->last_name) }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-lg-4">
          <label class="form-label">Staff</label>
          <select name="staff_id" class="form-select" required>
            @foreach($staff as $s)
              <option value="{{ $s->staff_id }}"
                {{ (int)old('staff_id') === $s->staff_id ? 'selected' : '' }}>
                #{{ $s->staff_id }} — {{ $s->full_name ?? ($s->first_name.' '.$s->last_name) }}
              </option>
            @endforeach
          </select>
        </div>

      </div>
    </div>
    <div class="card-footer text-end">
      <a href="{{ route('films.index') }}" class="btn btn-light">Cancelar</a>
      <button class="btn btn-success">Registrar renta</button>
    </div>
  </div>
</form>
@endsection
