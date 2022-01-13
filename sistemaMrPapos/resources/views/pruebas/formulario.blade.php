@extends('layouts.main', ['activePage' => 'formulario', 'titlePage' => __('Formulario')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('pruebas.guardarreg') }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">USUARIOS</h4>
                            <p class="card-category">Ingresar datos</p>
                        </div>
                        <div class="card-body">
                            <!--NOMBRE-->
                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label font-weight-bold text-dark ">Nombre</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="name" placeholder="Ingresa el Nombre" autofocus>

                                </div>
                            </div>

                            <!--EMAIL-->
                            <div class="row">
                                <label for="email" class="col-sm-2 col-form-label font-weight-bold text-dark">Email</label>
                                <div class="col-sm-7">
                                    <input type="email" class="form-control" name="email" placeholder="Ingresa el Email" autofocus>

                                </div>
                            </div>

                            <!--PASSWORD-->
                            <div class="row">
                                <label for="password" class="col-sm-2 col-form-label font-weight-bold text-dark">Contraseña</label>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control" name="password" placeholder="Contraseña" autofocus>

                                </div>
                            </div>

                            <!--CONFIRM PASS-->
                            <div class="row">
                                <label for="password_confirmation" class="col-sm-2 col-form-label font-weight-bold text-dark">Confirmar Contraseña</label>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Contraseña" autofocus>

                                </div>
                            </div>

                            <!--ESTADO-->
                            <div class="row">
                                <label for="estado" class="col-sm-2 col-form-label font-weight-bold text-dark">Estado</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="estado" placeholder="Ingresa el Estado" autofocus>

                                </div>
                            </div>

                            <!--MUNICIPIO-->
                            <div class="row">
                                <label for="municipio" class="col-sm-2 col-form-label font-weight-bold text-dark">Municipio</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="municipio" placeholder="Ingresa el Municipio">

                                </div>
                            </div>

                            <!--COLONIA-->
                            <div class="row">
                                <label for="colonia" class="col-sm-2 col-form-label font-weight-bold text-dark">Colonia</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="colonia" placeholder="Ingresa la Colonia">

                                </div>
                            </div>

                            <!--CALLE-->
                            <div class="row">
                                <label for="calle" class="col-sm-2 col-form-label font-weight-bold text-dark">Calle</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="calle" placeholder="Ingresa la Calle">

                                </div>
                            </div>

                            <!--NUMERO-->
                            <div class="row">
                                <label for="numero" class="col-sm-2 col-form-label text-dark">Numero</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="numero" placeholder="Ingresa el Numero">

                                </div>
                            </div>

                            <!--CODIGO POSTAL-->
                            <div class="row">
                                <label for="codigo_postal" class="col-sm-2 col-form-label text-dark">Codigo postal</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="codigo_postal" placeholder="Ingresa el Codigo postal">

                                </div>
                            </div>

                            <!--TELEFONO-->
                            <div class="row">
                                <label for="num_telefono" class="col-sm-2 col-form-label text-dark">Telefono</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="num_telefono" placeholder="Ingresa el Numero de Telefono">

                                </div>
                            </div>

                        </div>
                        <!--Footer-->
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                        <!--End Footer-->

                    </div>
                    <a class="nav-link" href="{{ route('usuariosList') }}">
                        <i class="material-icons">add_circle</i>
                        <p>{{ __('Atras') }}</p>
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection