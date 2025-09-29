@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3">Actores</h1>
  <a href="{{ route('actors.create') }}" class="btn btn-primary">Nuevo actor</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($actors as $a)
          <tr>
            <td>{{ $a->actor_id }}</td>
            <td>{{ $a->first_name }} {{ $a->last_name }}</td>
            <td class="text-end">
              <a href="{{ route('actors.show', $a) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
              <a href="{{ route('actors.edit', $a) }}" class="btn btn-sm btn-outline-primary">Editar</a>
              <form action="{{ route('actors.destroy', $a) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('¿Eliminar actor?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="text-center py-4">Sin registros</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
