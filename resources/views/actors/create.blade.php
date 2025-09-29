@extends('layouts.app')
@section('content')
<h1 class="h3 mb-3">Nuevo actor</h1>
<form method="POST" action="{{ route('actors.store') }}">
  @csrf
  @include('actors._form')
</form>
@endsection
