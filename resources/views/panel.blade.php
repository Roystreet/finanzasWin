@extends('layout-backend')
@section('title', 'Inicio')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bienvenido {{ auth()->user()->lastname }} {{ auth()->user()->name }}</div>
            </div>
          </div>
    </div>
</div>
@endsection
