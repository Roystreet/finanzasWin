@extends('layouts.app')
@section('title', 'Detalles del Conductor')

@section('css')

@endsection

@section('content')


<section class="content-header">
  <button type="button" class="btn btn-info pull-right" >
     <i class="fa fa-edit" aria-hidden="true"></i> <a href="{{ route('driver.edit', $driver) }}">Editar</a>
   </button>
  <button type="button" href="{{route('driver.index')}}"  class="btn btn-info pull-left" >
     <i class="fa fa-list" aria-hidden="true"></i>  <a href="{{ route('driver.index') }}">Listado</a>
   </button>

      <br><br>
</section>

<section class="content">
<div class="box">
<div class="box-body">


    <div class="box-header">
      <h3 class="box-title">Información</h3>
    </div>
    <div class="box-body">

    <table id="personales" name="drivers"  width="100%" align="left">
      <tr>
        <td colspan="4" height="30px"><pre><i class="fa fa-user"></i> - <b>Datos Personales</b></pre></td>
      <tr>
      <tr>
        <td>Nombres:</td>
        <td>{{ $driver->name }}</td6>
        <td>Apellidos:</td>
        <td>{{ $driver->lastname }}</td>
      </tr>
      <tr>
        <td>Fecha de Nacimiento</td>
        <td>{{ $driver->birthdate }}</td>
        <td>Pais de Nacimiento</td>
        <td>{{ $driver->getContryNationality->description }}</td>
      </tr>
      <tr>
        <td>Correo</td>
        <td>{{ $driver->email }}</td>
        <td>Telefono</td>
        <td>{{ $driver->phone }}</td>
      </tr>
      <tr>
        <td></i> DNI </td>
        <td colspan="3">{{ $driver->document }}</td>
      </tr>
      <tr>
        <td colspan="4" height="30px"><pre><i class="fa fa-child"></i> - <b>Dirección</b></pre></td>
      <tr>
      <tr>
        <td> Pais </td>
        <td>{{ $driver->getContryAddress->description }}</td6>
        <td>Departamento</td>
        <td>{{ $driver->getStateAddress->description }}</td>
      </tr>
      <tr>
        <td> Provincia </td>
        <td>{{ $driver->getContryAddress->description }}</td6>
        <td>Distrito</td>
        <td>{{ $driver->getStateAddress->description }}</td>
      </tr>
      <tr>
        <td>Descripción</td>
        <td colspan="3"> {{ $driver->address }} </td>
      </tr>
      <tr>
        <td colspan="4" height="30px"><pre><i class="fa fa-car"></i> - <b>Ruta del Conductor</b></pre></td>
      <tr>
      <tr>
        <td colspan="4"> {{ $driver->getCityDriver->description }} </td>
      </tr>
      @if( $driver->getVehicle )
      <tr>
        <td colspan="4" height="30px"><pre><i class="fa fa-car"></i> - <b>Información del Vehiculo</b></pre></td>
      <tr>
      <tr>
        <td>Modelo</td>
        <td>{{ $driver->getVehicle->model }}</td6>
        <td>Serial</td>
        <td>{{ $driver->getVehicle->serial }}</td>
      </tr>
      <tr>
        <td>Año</td>
        <td>{{ $driver->getVehicle->model_year }}</td>
        <td>Color</td>
        <td>{{ $driver->getVehicle->color }}</td>
      </tr>
      <tr>
        <td>Placa</td>
        <td colspan="3">{{ $driver->getVehicle->plate }}</td>
      </tr>
      @endif

  </table>
</div>
</div>


</div>
</section>






@endsection

@section('js')

@endsection
