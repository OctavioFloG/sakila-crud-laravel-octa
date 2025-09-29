<form method="POST" action="{{ route('rentals.store') }}">
  @csrf
  <label>Película</label>
  <select name="film_id">@foreach($films as $f)<option value="{{ $f->film_id }}">{{ $f->title }}</option>@endforeach</select>

  <label>Tienda (store_id)</label>
  <input type="number" name="store_id" min="1" required>

  <label>Cliente</label>
  <select name="customer_id">@foreach($customers as $c)<option value="{{ $c->customer_id }}">{{ $c->customer_id }}</option>@endforeach</select>

  <label>Staff</label>
  <select name="staff_id">@foreach($staff as $s)<option value="{{ $s->staff_id }}">{{ $s->staff_id }}</option>@endforeach</select>

  <button type="submit">Rentar</button>
</form>
