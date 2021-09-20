@extends('layout-simple')
@section('title', 'Productos')
@section('content')
        <div class="container" >
          <div class="row"style="margin-top:2%;margin-bottom:2%;">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            @foreach ($product as $key => $value)
              <form method="get" action="/producto/registro-pago/{{$value->precio->id}}" enctype="multipart/form-data">
                <div id="fa2" style=" padding: 40px; font-weight: bold; font-size: x-large;background-color:white;margin-right:1%;margin-left:1%;margin-bottom:1%; color:black;border-radius: 4px 3px 6px / 2px 4px;" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 btn-loquiero" >
                    <center>
                      <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{$value->product->url_imagen}}" alt="Card image cap" width="200" height="200">
                        <div class="card-body">
                          <h5 class="card-title"><p><b>{{$value->product->description}}</b></p></h5>
                          <p class="card-text">{{$value->moneda->symbol}}  {{$value->precio->price}}</p>
                          <button class="btn btn-primary" type="submit"><b>Lo quiero</b></button>
                        </div>
                      </div>
                  </center>
                </div>
              </form>
            @endforeach
            {{--
            --}}
          </div>
        </div>
@endsection
