@extends('layouts.main', ['activePage' => 'reabastecer', 'titlePage' => 'Detalles del calzado'])
@section('content')
<div class="content">
    <div class="container-fluid">

        <!--INICIO DEL FORMULARIO AÑADIDO-->
        <div class="row">
        @foreach($datosZapato as $zapatog)
            <div class="col-md-12">
                <form action="{{ route('reabastecerCalzado', [$zapatog->id_calzado, $zapatog->id_tipo_c]) }}" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    
                    <div class="card">
                        <div class="card-header card-header-azulejo">
                            <h3 class="card-title  fuenteNueva text-align-center">REABASTECER CALZADO -
                                @foreach($tipos as $tipo)
                                {{ $tipo->tipo }}
                                @endforeach
                            </h3>

                        </div>
                        <div class="card-body">

                            <div class="row">
                                <!--MARCA-->
                                <H4 for="marca" class="col-sm-2 fuenteEtiquetaNeg">Marca:</H4>
                                <h4 for="marca" class="col-sm-3 fuenteEtiqueta">

                                    @foreach($datosZapato as $zapato)
                                    {{ $zapato->marca }}
                                    @endforeach

                                </h4>

                                <!--MODELO-->
                                <H4 for="mnodelo" class="col-sm-2 fuenteEtiquetaNeg">Modelo:</H4>
                                <h4 for="mnodelo" class="col-sm-3 fuenteEtiqueta">

                                    @foreach($datosZapato as $zapato)
                                    {{ $zapato->modelo }}
                                    @endforeach

                                </h4>

                            </div>
                            <!--espaciofilas-->
                            <div class="row">
                                <label for="marca" class="col-sm-2 col-form-label font-weight-bold"></label>
                            </div>
                            <!--espaciofilas-->
                            <div class="row">
                                <label for="marca" class="col-sm-2 col-form-label font-weight-bold"></label>
                            </div>

                            <div class="row">
                                <!--NUMEROS DISPONIBLES-->
                                <H4 for="marca" class="col-sm-2 fuenteEtiquetaNeg">Numeros Disponibles:</H4>
                            </div>
                           
                            @foreach($numeros as $numero)
                            <div class="row">
                                
                                <h4 for="marca" class="col-sm-1 fuenteEtiqueta">
                                    {{ $numero->numero }} :
                                </h4>

                                <div class="col-sm-1">
                                    <input type="text" class="form-control fuenteEtiqueta" name="{{ $numero->id_numero }}" placeholder="" value="{{ $numero->existencias }}">
                                </div>                               
                            </div>
                            @endforeach

                        </div>
                        <!--Footer-->
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn colorBtnGuardar fuenteBtn">Guardar</button>
                        </div>
                        <!--End Footer-->
                </form>               
            </div>
        @endforeach
        <div class="row">
                        <div class="col-sm-1">
                            <a href="{{ route('calzadoListReabastecer') }}"><button type="button" class="btn fuenteBtn colorBtnAtras">Atras</button></a>
                        </div>
                    </div>
        </div>

        <!--FIN DEL FORMULARIO AÑADIDO-->
        
        
    </div>
</div>
@endsection