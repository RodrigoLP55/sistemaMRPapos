@extends('layouts.main', ['activePage' => 'ventas', 'titlePage' => 'Detalles del calzado'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-azulejo">
                        <div class="card-title">Detalles</div>
                        <p class="card-category">Vista detallada del Calzado:
                            @foreach($datosZapato as $zapato)
                            {{ $zapato->marca }} - {{ $zapato->modelo }} -
                            @endforeach

                            @foreach($tipos as $tipo)
                            {{ $tipo->tipo }}
                            @endforeach

                        </p>
                    </div>
                    <!--body-->
                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success" role="success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <form action="{{ route('addDetalleVenta') }}" method="post" class="form-horizontal">
                            @csrf
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="card card-user">
                                        <div class="card-body">
                                            <p class="card-text">
                                            <div class="author">
                                                <a href="#" class="d-flex">
                                                    <img src="{{ asset('/img/zapato.jpg') }}" alt="image" class="avatar">
                                                    <h5 class="title mx-3"></h5>
                                                </a>

                                                <div class="row">
                                                    <div class="col-6">

                                                        <h4><b>Marca: </b>
                                                            @foreach($datosZapato as $zapato)
                                                            {{ $zapato->marca }}
                                                            @endforeach
                                                        </h4>
                                                        <h4><b>Modelo: </b>
                                                            @foreach($datosZapato as $zapato)
                                                            {{ $zapato->modelo }}
                                                            <input type="hidden" class="form-control" name="id_calzado_dv" value="{{ $zapato->id_calzado }}">
                                                            @endforeach
                                                        </h4>

                                                        <h4><b>Numeros Disponibles: </b>
                                                        </h4>
                                                        <div class="">
                                                            <div class="input-group">
                                                                <select class="custom-select col-sm-4" id="numeros" name="numero">
                                                                    <option>Seleccionar...</option>
                                                                    @foreach($numeros as $numero)
                                                                    <option name="numero" value="<?= isset($numero->id_numero) ? htmlspecialchars($numero->id_numero) : '' ?>">{{ $numero->numero }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <br>
                                                        </div>

                                                        <h5><b>Cantidad: </b>
                                                        </h5>
                                                        <input type="text" class="form-control" name="cantidad" value="">
                                                        
                                                    </div>


                                                    <div class="col-6">
                                                        <h1>
                                                            @foreach($datosZapato as $zapato)
                                                            $ {{ $zapato->precio_v }}
                                                            @endforeach
                                                        </h1>

                                                    </div>
                                                </div>
                                            </div>
                                            </p>

                                        </div>
                                        <div class="card-footer">
                                            <div class="button-container">
                                                <a href="{{ route('calzadoListV') }}" class="btn btn-sm colorBtnAtras mr-3"> Volver </a>
                                                <button type="submit" class="btn colorGuardar">Agregar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card user 2-->



                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection