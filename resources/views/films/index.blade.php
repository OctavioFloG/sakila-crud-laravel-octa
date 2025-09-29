@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3">Películas</h1>
  <a href="{{ route('films.create') }}" class="btn btn-primary">Nueva película</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Actores</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($films as $f)
          <tr>
            <td>{{ $f->film_id }}</td>
            <td>{{ $f->title }}</td>
            <td>{{ $f->actors_count ?? $f->actors->count() }}</td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('films.show', $f) }}">Ver</a>
              <a class="btn btn-sm btn-outline-primary" href="{{ route('films.edit', $f) }}">Editar</a>
              <form action="{{ route('films.destroy', $f) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('¿Eliminar película?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center py-4">Sin registros</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
