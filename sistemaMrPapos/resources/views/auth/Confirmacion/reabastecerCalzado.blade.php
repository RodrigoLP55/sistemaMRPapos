@extends('layouts.main', ['activePage' => '', 'titlePage' => __('CONFIRMACION')])

@section('content')
<div class="content">
  <div class="container-fluid">

    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-azulejo">
            <h4 class="card-title fuenteNueva">¿Deseas comenzar a reabastecer el calzado?</h4>           
          </div>
          <div class="card-body">
            Puedes reabastecer las tallas despues en el modulo de Reabastecimiento si asi lo deseas.
            <br>
            <br>
            <div class="row justify-content-md-center">
            
              <a class="btn colorBtnGuardar" href="{{ route('continuarR') }}">
                <i class="material-icons">delete_forever</i>Reabastecer
              </a>

              <a class="btn colorBtnAtras" href="{{ route('cancelarRCalzado') }}">
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