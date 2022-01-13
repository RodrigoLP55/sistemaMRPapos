@extends('layouts.main', ['activePage' => 'usuarios', 'titlePage' => __('Usuario')])

@section('content')

<div class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-azulejo">
          <h3 class="card-title fuenteNueva">USUARIOS</h3>
        </div>
        <div class="card-body">
          <div class="row">
            @foreach($users as $user)
            <!--TARJETA DE USUARIO-->
            <div class="card card-profile ml-auto mr-auto" style="max-width: 360px">
              <div class="card-header card-header-image">
                <a href="#pablo">
                  <img class="img" src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
                </a>
              </div>

              <div class="card-body ">
                <h4 class="card-title">{{ $user->name }}</h4>
                <h6 class="card-category text-gray">Administrador</h6>
                <h6 class="card-subtitle mb-2 text-muted">{{ $user->email }}</h6>
                <h6 class="card-subtitle mb-2 text-muted">{{ $user->num_telefono }}</h6>
                  <p class="card-text">{{ $user->estado }}. {{ $user->municipio }}. {{ $user->colonia }}.
                    {{ $user->calle }}. {{ $user->numero }}.
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
              <a href="{{ route('vistaFormu') }}"><button type="button" class="btn fuenteBtn colorBtn">NUEVO USUARIO</button></a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>
@endsection