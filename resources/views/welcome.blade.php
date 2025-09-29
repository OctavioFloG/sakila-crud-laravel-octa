<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sakila · Laravel</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .hero {
      background: radial-gradient(1200px 400px at 20% 0%, #0d6efd22, transparent), #0b0d12 center/cover no-repeat;
      color: #fff;
    }
    .glass {
      backdrop-filter: blur(6px);
      background-color: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.18);
      border-radius: 1rem;
    }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="{{ url('/') }}">🎬 Sakila</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('actors.index') }}">Actores</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('films.index') }}">Películas</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('rentals.create') }}">Rentar</a></li>
      </ul>
    </div>
  </div>
</nav>

<header class="hero py-5">
  <div class="container">
    <div class="row align-items-center gy-4">
      <div class="col">
        <div class="p-4 p-lg-5 glass">
          <h1 class="display-5 fw-bold">Videoclub Sakila</h1>
          <p class="lead mb-4">
            Administra <strong>actores</strong>, <strong>películas</strong> y el <strong>proceso de renta</strong> con Laravel.
            Conecta a tu base <code>sakila</code> y empieza a operar.
          </p>
          <div class="d-flex gap-2">
            <a href="{{ route('films.index') }}" class="btn btn-primary btn-lg">Ver Películas</a>
            <a href="{{ route('actors.index') }}" class="btn btn-outline-light btn-lg">Ver Actores</a>
            <a href="{{ route('rentals.create') }}" class="btn btn-success btn-lg">Rentar ahora</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<main class="container my-5">
  {{-- Alertas globales si las usas en otras vistas --}}
  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <strong>Corregir los siguientes errores:</strong>
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  {{-- Sección “Acciones rápidas” --}}
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Agregar película</h5>
          <p class="card-text text-muted">Crea un nuevo registro y asocia actores.</p>
          <a href="{{ route('films.create') }}" class="btn btn-primary">Nueva película</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Agregar actor</h5>
          <p class="card-text text-muted">Da de alta actores para tus películas.</p>
          <a href="{{ route('actors.create') }}" class="btn btn-outline-primary">Nuevo actor</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Registrar renta</h5>
          <p class="card-text text-muted">Busca inventario disponible por tienda.</p>
          <a href="{{ route('rentals.create') }}" class="btn btn-success">Rentar</a>
        </div>
      </div>
    </div>
  </div>

  {{-- (Opcional) Últimas rentas: pasa $recentRentals desde el controlador --}}
  @isset($recentRentals)
    <div class="mt-5">
      <h2 class="h5 mb-3">Últimas rentas</h2>
      <div class="card">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Película</th>
                <th>Cliente</th>
                <th>Fecha renta</th>
                <th>Fecha devolución</th>
                <th>Devuelta</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentRentals as $r)
                <tr>
                  <td>{{ $r->rental_id }}</td>
                  <td>{{ $r->inventory->film->title ?? '—' }}</td>
                  <td>{{ $r->customer->full_name ?? ($r->customer->first_name.' '.$r->customer->last_name) }}</td>
                  <td>{{ \Illuminate\Support\Carbon::parse($r->rental_date)->format('Y-m-d H:i') }}</td>
                  <td>{{ \Illuminate\Support\Carbon::parse($r->return_date)->format('Y-m-d H:i') }}</td>
                  <td>
                    @if($r->return_date)
                      <span class="badge bg-success">Sí</span>
                    @else
                      <span class="badge bg-danger">No</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr><td colspan="5" class="text-center py-4">Sin movimientos recientes</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endisset
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
