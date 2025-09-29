@php
  $isEdit = isset($film);
  $selected = collect(old('actor_ids', isset($film) ? $film->actors->pluck('actor_id')->all() : []));
@endphp

<div class="card">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-8">
        <label class="form-label">Título</label>
        <input type="text" name="title" class="form-control" required
               value="{{ old('title', $film->title ?? '') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Año</label>
        <input type="number" name="release_year" class="form-control"
               value="{{ old('release_year', $film->release_year ?? '') }}">
      </div>

      <div class="col-12">
        <label class="form-label">Descripción</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $film->description ?? '') }}</textarea>
      </div>

      <div class="col-md-4">
        <label class="form-label">Language ID</label>
        <input type="number" name="language_id" class="form-control" required
               value="{{ old('language_id', $film->language_id ?? 1) }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Duración de renta (días)</label>
        <input type="number" name="rental_duration" class="form-control" required
               value="{{ old('rental_duration', $film->rental_duration ?? 3) }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Tarifa de renta</label>
        <input type="number" step="0.01" name="rental_rate" class="form-control" required
               value="{{ old('rental_rate', $film->rental_rate ?? 2.99) }}">
      </div>

      <div class="col-md-4">
        <label class="form-label">Duración (min)</label>
        <input type="number" name="length" class="form-control"
               value="{{ old('length', $film->length ?? '') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Costo de reposición</label>
        <input type="number" step="0.01" name="replacement_cost" class="form-control" required
               value="{{ old('replacement_cost', $film->replacement_cost ?? 19.99) }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Clasificación</label>
        <input type="text" name="rating" class="form-control"
               value="{{ old('rating', $film->rating ?? '') }}">
      </div>

      <div class="col-12">
        <label class="form-label">Actores</label>
        <select name="actor_ids[]" class="form-select" multiple size="8">
          @foreach($actors as $a)
            <option value="{{ $a->actor_id }}"
              {{ $selected->contains($a->actor_id) ? 'selected' : '' }}>
              {{ $a->first_name }} {{ $a->last_name }}
            </option>
          @endforeach
        </select>
        <div class="form-text">Mantén CTRL/⌘ para seleccionar varios.</div>
      </div>
    </div>
  </div>

  <div class="card-footer text-end">
    <a href="{{ route('films.index') }}" class="btn btn-light">Cancelar</a>
    <button class="btn btn-primary">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
  </div>
</div>
