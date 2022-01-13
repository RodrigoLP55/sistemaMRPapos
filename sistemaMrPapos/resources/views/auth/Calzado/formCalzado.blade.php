@extends('layouts.main', ['activePage' => 'productosA', 'titlePage' => __('Formulario')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('addCalzado') }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-azulejo">
                            <h3 class="card-title  font-weight-bold text-align-center">NUEVO CALZADO</h3>
                            <h4 class="card-title  font-weight-bold">Ingrersar datos</h4>

                        </div>
                        <div class="card-body">

                            <div class="row">

                                <!--MARCA-->
                                <H4 for="marca" class="col-sm-2 fuenteEtiquetaNeg">Marca:</H4>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="marca" placeholder="Ingresa la Marca" autofocus>
                                </div>

                                <!--MODELO-->
                                <H4 for="marca" class="col-sm-2 fuenteEtiquetaNeg">Modelo:</H4>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="modelo" placeholder="Ingresa el Modelo" autofocus>
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

                            <!--TIPO-->
                            <div class="row">
                                <H4 for="marca" class="col-sm-2 fuenteEtiquetaNeg">Tipo:</H4>
                                <div class="col-sm-4">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary active">
                                            <input type="radio" name="tipo" id="2" autocomplete="off" checked value="1">NIÑO
                                        </label>
                                        <label class="btn btn-secondary">
                                            <input type="radio" name="tipo" id="1" autocomplete="off" value="2"> NIÑA
                                        </label>
                                        <label class="btn btn-secondary">
                                            <input type="radio" name="tipo" id="4" autocomplete="off" value="3"> CABALLERO
                                        </label>
                                        <label class="btn btn-secondary">
                                            <input type="radio" name="tipo" id="3" autocomplete="off" value="4"> DAMA
                                        </label>
                                    </div>
                                </div>

                                <!--PROVEEDOR-->
                                <H4 for="marca" class="col-sm-2 fuenteEtiquetaNeg">Proveedor:</H4>
                                <div class="col-sm-4">
                                    <div class="input-group">

                                        <select class="custom-select" id="proveedores" name="proveedor">
                                            <option>Seleccionar...</option>
                                            @foreach($proveedores as $prov)
                                            <option name="proveedor" value="<?= isset($prov->rfc) ? htmlspecialchars($prov->rfc) : '' ?>">{{ $prov->razon_social }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-prepend">
                                            <button class="btn-secondary" type="button">+</button>
                                        </div>
                                    </div>
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



                            <!--espaciofilas-->
                            <div class="row">
                                <label for="marca" class="col-sm-2 col-form-label font-weight-bold"></label>
                            </div>
                            <!--espaciofilas-->
                            <div class="row">
                                <label for="marca" class="col-sm-2 col-form-label font-weight-bold"></label>
                            </div>

                            <div class="row">

                                <!--PRECIO C-->
                                <H4 for="marca" class="col-sm-2 fuenteEtiquetaNeg">Precio de Compra:</H4>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="precio_c" placeholder="$" autofocus>
                                </div>

                                <!--PRECIO V-->
                                <H4 for="marca" class="col-sm-2 fuenteEtiquetaNeg">Precio de Venta:</H4>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="precio_v" placeholder="$" autofocus>
                                </div>


                            </div>




                        </div>
                        <!--Footer-->
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn colorBtnGuardar fuenteBtn">Guardar</button>
                        </div>
                        <!--End Footer-->
                </form>

            </div>
            <div class="row">
                <div class="col-sm-1">
                    <a href="{{ route('calzadoList') }}"><button type="button" class="btn fuenteBtn colorBtnAtras">Atras</button></a>
                </div>
            </div>
        </div>





    </div>
</div>




@endsection