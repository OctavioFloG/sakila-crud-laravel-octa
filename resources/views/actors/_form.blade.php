@php $isEdit = isset($actor); @endphp
<div class="card">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="first_name" class="form-control"
               value="{{ old('first_name', $actor->first_name ?? '') }}" maxlength="45" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Apellido</label>
        <input type="text" name="last_name" class="form-control"
               value="{{ old('last_name', $actor->last_name ?? '') }}" maxlength="45" required>
      </div>
    </div>
  </div>
  <div class="card-footer text-end">
    <a href="{{ route('actors.index') }}" class="btn btn-light">Cancelar</a>
    <button class="btn btn-primary">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
  </div>
</div>
