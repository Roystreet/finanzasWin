@extends('layouts.app')
@section('title', 'Error 403')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
@endsection

@section('content')
<div class="container">
  <br><br><br>
  <img src="https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Ferror403.jpeg?alt=media&token=1739e380-373f-4ffd-a43f-26175add2028" style="display: block; margin-left: auto; margin-right: auto; width: 40%;">
  <center><h3>Usted no tiene permisos. Contactese con el administrador!</h3></center>
</div>
@endsection
