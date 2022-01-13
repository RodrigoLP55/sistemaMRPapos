@extends('layouts.main', ['activePage' => 'productosA', 'titlePage' => 'Detalles del calzado'])
@section('content')
<div class="content">
    <div class="container-fluid">
        

        <div class="container py-4 my-4 mx-auto d-flex flex-column">
            <div class="header">
                <div class="row r1">
                    <div class="col-md-9 abc">
                        <h1>@foreach($datosZapato as $zapato)
                            {{ $zapato->marca }}
                            @endforeach

                            @foreach($datosZapato as $zapato)
                            {{ $zapato->modelo }}
                            @endforeach
                        </h1>

                    </div>
                    <div class="col-md-3 text-right pqr"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <p class="text-right para"></p>
                </div>
            </div>
            <div class="container-body mt-4">
                <div class="row r3">
                    <div class="col-md-5 p-0 klo">
                        <ul>
                            <li>Numeros Disponibles:</li>
                            
                            @foreach($numeros as $numero)
                            <li> {{ $numero->numero }} : {{ $numero->existencias }}<br> </li>
                                                        @endforeach
                           
                            
                        </ul>
                    </div>
                    <div class="col-md-7"> <img src="https://static.nike.com/a/images/t_default/nkj4hukaeyfjq1hefn1b/calzado-air-force-1-07-yATkW1Bp.png" width="90%" height="95%"> </div>
                </div>
            </div>
            <div class="footer d-flex flex-column mt-5">
                <div class="row r4">
                    <div class="col-md-2 myt des"><a href="#">Description</a></div>
                    <div class="col-md-2 myt "><a href="#">Review</a></div>
                    <div class="col-md-2 mio offset-md-4"><a href="#">ADD TO CART</a></div>
                    <div class="col-md-2 myt "><button type="button" class="btn btn-outline-warning"><a href="#">BUY NOW</a></button></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection