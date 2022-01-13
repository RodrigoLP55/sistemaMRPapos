@extends('layouts.main', ['activePage' => 'proveedores', 'titlePage' => __('Registrar Nuevo Proveedor')])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('regProveedor') }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-azulejo">
                            <h3 class="card-title fuenteNueva">PROVEEDORES</h3>
                            <h4 class="card-title ">Ingresar datos</h4>
                        </div>
                        <div class="card-body">
                            <!--RAZON SOCIAL-->
                            <div class="row">
                                <label for="razon_social" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNeg">Razon Social</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="razon_social" placeholder="Ingresa al razon social del proveedor" autofocus>

                                </div>
                            </div>

                            <!--EMAIL-->
                            <div class="row">
                                <label for="email" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNeg">Email</label>
                                <div class="col-sm-7">
                                    <input type="email" class="form-control" name="email" placeholder="Ingresa el Email" autofocus>

                                </div>
                            </div>

                            <div class="row">
                                <!--SALTO DE LINEA-->
                                <label for="email" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNegr"></label>

                            </div>

                            <div class="row">
                                <label for="email" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNegr">DIRECCION:</label>

                            </div>

                            <!--ESTADO-->
                            <div class="row">
                                <label for="estado" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNeg">Estado</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="estado" placeholder="Ingresa el Estado" autofocus>

                                </div>
                            </div>

                            <!--MUNICIPIO-->
                            <div class="row">
                                <label for="municipio" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNeg">Municipio</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="municipio" placeholder="Ingresa el Municipio">

                                </div>
                            </div>

                            <!--COLONIA-->
                            <div class="row">
                                <label for="colonia" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNeg">Colonia</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="colonia" placeholder="Ingresa la Colonia">

                                </div>
                            </div>

                            <!--CALLE-->
                            <div class="row">
                                <label for="calle" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNeg">Calle</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="calle" placeholder="Ingresa la Calle">

                                </div>
                            </div>

                            <!--NUMERO-->
                            <div class="row">
                                <label for="numero" class="col-sm-2 col-form-label text-dark fuenteEtiquetaNeg">Numero</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="numero" placeholder="Ingresa el Numero">

                                </div>
                            </div>

                            <!--CODIGO POSTAL-->
                            <div class="row">
                                <label for="codigo_postal" class="col-sm-2 col-form-label text-dark fuenteEtiquetaNeg">Codigo postal</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="codigo_postal" placeholder="Ingresa el Codigo postal">

                                </div>
                            </div>
                            <div class="row">
                                <!--SALTO DE LINEA-->
                                <label for="email" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNegr"></label>
                            </div>

                            <div class="row">
                                <label for="email" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNegr">CONTACTO:</label>

                            </div>

                            <!--TELEFONO-->
                            <div class="row">
                                <label for="num_telefono" class="col-sm-2 col-form-label text-dark fuenteEtiquetaNeg">Telefono</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="num_telefono" placeholder="Ingresa el Numero de Telefono">

                                </div>
                            </div>

                        </div>
                        <!--Footer-->
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn colorBtnGuardar fuenteEtiquetaNeg">Guardar</button>
                        </div>
                        <!--End Footer-->

                    </div>

                    <div class="row">
                        <div class="col-sm-1">
                            <a href="{{ route('obtenerProveedores') }}"><button type="button" class="btn fuenteBtn colorBtnAtras">Atras</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection