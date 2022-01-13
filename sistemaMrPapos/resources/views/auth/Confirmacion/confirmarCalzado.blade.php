@extends('layouts.main', ['activePage' => '', 'titlePage' => __('CONFIRMACION')])

@section('content')
<div class="content">
  <div class="container-fluid">

    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-deleteconfirm">
            <h4 class="card-title fuenteNueva">¿Seguro que deseas eliminar este registro?</h4>           
          </div>
          <div class="card-body">
            Este registro se eliminara y no sera posible recuperarlo
            <br>
            <br>
            <div class="row justify-content-md-center">

              <a class="btn colorBtnEliminar" href="{{ route('eliminarCalzado', $datosCalzado -> id_calzado )}}">
                <i class="material-icons">delete_forever</i>Eliminar registro
              </a>

              <a class="btn colorBtnAtras" href="{{ route('cancelarECalzado') }}">
                <i class="material-icons">arrow_back</i>Cancelar y regresar
              </a>

            </div>


          </div>
        </div>
      </div>
    </div>




  </div>
</div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    md.initDashboardPageCharts();
  });
</script>
@endpush