@extends('layouts.main', ['activePage' => 'productosA', 'titlePage' => __('Formulario')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <form action="{{ route('inicventa') }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-azulejo">
                            <h4 class="card-title  font-weight-bold text-align-center fuenteNueva">Comenzar Venta</h4>
                            <h5 class="card-title  font-weight-bold">Ingresar datos del cliente</h5>
                            <h4 class="card-title  font-weight-bold"></h4>

                        </div>
                        <div class="card-body">

                            <div class="row">
                                <!--USUARIO-->
                                <label for="marca" class="col-sm-2 col-form-label fuenteEtiquetaNeg">Usuario:</label>
                                <label for="marca" class="col-sm-2 col-form-label fuenteEtiquetaNeg">{{ $iduser }}</label>
                            </div>

                            <div class="row">
                                <!--NOMBRE CLIENTE-->
                                <label for="modelo" class="col-sm-2 col-form-label fuenteEtiquetaNeg">Nombre del Cliente:</label>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="nombre" value="">
                                </div>
                            </div>

                        </div>
                        <!--Footer-->
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn colorBtnSiguiente">Siguiente</button>
                        </div>
                        <!--End Footer-->
                </form>

            </div>
            <div class="row">
                <div class="col-sm-1">
                    <a href="{{ route('calzadoListV') }}"><button type="button" class="btn colorBtnAtras">Atras</button></a>
                </div>
            </div>
        </div>





    </div>
</div>




@endsection