@extends('layouts.main', ['activePage' => 'proveedores', 'titlePage' => __('Proveedores')])

@section('content')

<div class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-azulejo">
          <h3 class="card-title fuenteNueva">PROVEEDORES</h3>
        </div>
        <div class="card-body">
          <div class="row">
            @foreach($proveedores as $proveedor)
            <!--TARJETA DE USUARIO-->
            <div class="card card-profile ml-auto mr-auto" style="max-width: 360px">
              <div class="card-header card-header-image">
                <a href="#pablo">
                  <img class="img" src="https://pngimage.net/wp-content/uploads/2018/06/proveedores-icono-png-4.png">
                </a>
              </div>

              <div class="card-body ">
                <h4 class="card-title">{{ $proveedor->razon_social }}</h4>
                <h6 class="card-category text-gray">Proveedor</h6>
                <h6 class="card-subtitle mb-2 text-muted">{{ $proveedor->email }}</h6>
                <h6 class="card-subtitle mb-2 text-muted">{{ $proveedor->num_telefono }}</h6>
                  <p class="card-text">{{ $proveedor->estado }}. {{ $proveedor->municipio }}. {{ $proveedor->colonia }}.
                    {{ $proveedor->calle }}. {{ $proveedor->numero }}.
                  </p>
              </div>
              <div class="card-footer justify-content-center">
                <a href="#pablo" class="btn btn-just-icon btn-twitter btn-round">
                  <i class="fa fa-twitter"></i>
                </a>
                <a href="#pablo" class="btn btn-just-icon btn-facebook btn-round">
                  <i class="fa fa-facebook-square"></i>
                </a>
                <a href="#pablo" class="btn btn-just-icon btn-google btn-round">
                  <i class="fa fa-google"></i>
                </a>
              </div>
            </div>
            @endforeach
            <!--FINAL DE LA TARJETA-->
          </div>
          <div class="row">
            <div class="col-md-auto">
              <a href="{{ route('formularioProveedores') }}"><button type="button" class="btn fuenteBtn colorBtn">NUEVO PROVEEDOR</button></a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>
@endsection