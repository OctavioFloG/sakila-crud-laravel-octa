@if(session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

@if($errors->any())
  <div class="alert alert-danger">
    <strong>Corrige los siguientes errores:</strong>
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif
