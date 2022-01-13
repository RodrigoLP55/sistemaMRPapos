@extends('layouts.main', ['activePage' => 'productosA', 'titlePage' => __('Formulario')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('addColor') }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h3 class="card-title  font-weight-bold text-align-center">NUEVO COLOR</h3>

                        </div>
                        <div class="card-body">

                            <div class="row">
                            
                                <!--COLOR-->
                                <H4 for="marca" class="col-sm-2 fuenteEtiquetaNeg">Nuevo Color:</H4>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="nombreColor" placeholder="Ingresa el nuevo Color" autofocus>
                                </div>   

                            </div>

                            <!--espaciofilas-->
                            <div class="row">
                                <label for="marca" class="col-sm-2 col-form-label font-weight-bold"></label>
                            </div>
                            <!--espaciofilas-->
                            <div class="row">
                                <label for="marca" class="col-sm-2 col-form-label font-weight-bold"></label>
                            </div>           


                        </div>
                        <!--Footer-->
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                        <!--End Footer-->
                </form>

            </div>
        </div>


        <div class="row">
            <div class="col-sm-1">
                <a href="{{ route('calzadoList') }}"><button type="button" class="btn btn-secondarys">Atras</button></a>
            </div>
        </div>


    </div>
</div>




@endsection