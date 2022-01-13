@extends('layouts.main', ['activePage' => 'ventas', 'titlePage' => __('Detalle Venta')])

@section('content')
<div class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="card">

        <div class="card-header card-header-azulejo">
          <h4 class="card-title fuenteNueva">DETALLE DE VENTA</h4>
          <p class="card-category fuenteBtn">Numero: <strong> {{ $idVenta}} </strong></p>

        </div>
        <div class="card-body">

          @foreach($venta as $vent)
          <div class="row">
            <div class="col-sm-4">
              <h4 class="card-title fuenteNueva">Nombre del Cliente:</h4>
              <p class="ventaFont">{{ $vent->nombre }}</p>
            </div>

            <div class="col-sm-4">
              <h4 class="card-title fuenteNueva">Fecha y Hora:</h4>
              <p class="ventaFont">{{ $vent->fecha_hora }}</p>
            </div>
          
          </div>
          @endforeach

          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="fontHeadTable">
                <th>
                  MARCA
                </th>

                <th>
                  MODELO
                </th>

                <th>
                  NUMERO
                </th>

                <th>
                  PRECIO UNITARIO
                </th>

                <th>
                  CANTIDAD
                </th>

                <th>
                  SUBTOTAL
                </th>
              </thead>
              <tbody class="fontBodyTable">
                @foreach($detallesVenta as $detaVen)
                <tr>
                  <!--MARCA-->
                  <td>
                    @foreach($zapatos as $zapato)
                    @if($zapato->id_calzado == $detaVen->id_calzado_dv)
                    {{ $zapato->marca }}
                    @endif
                    @endforeach
                  </td>

                  <!--MODELO-->
                  <td>
                    @foreach($zapatos as $zapato)
                    @if($zapato->id_calzado == $detaVen->id_calzado_dv)
                    {{ $zapato->modelo }}
                    @endif
                    @endforeach
                  </td>

                  <!--NUMERO-->
                  <td>
                    @foreach($numeros as $numero)
                    @if($numero->id_numero == $detaVen->numero_dv)
                    {{ $numero->numero }}
                    @endif
                    @endforeach
                  </td>

                  <!--PRECIO UNITARIO-->
                  <td>
                    @foreach($zapatos as $zapato)
                    @if($zapato->id_calzado == $detaVen->id_calzado_dv)
                    {{ $zapato->precio_v }}
                    @endif
                    @endforeach
                  </td>

                  <!--CANTIDAD-->
                  <td>
                    {{ $detaVen->cant_dv }}
                  </td>



                  <!--SUBTOTAL-->
                  <td>
                    {{ $detaVen->subtotal }}
                  </td>


                </tr>
                @endforeach
              </tbody>
            </table>


          </div>
          <div class="row">
            <!--SALTO DE LINEA-->
            <label for="email" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNegr"></label>
          </div>

          @foreach($venta as $vent)
          <div class="row justify-content-end">
            <div class="col-sm-1">
              <h4 class="card-title fuenteNueva">Total:</h4>
            </div>
            <div class="col-sm-2">
              <p class="ventaFont">$ {{ $vent->total }}</p>
            </div>
          </div>
          @endforeach
          
        </div>
        
      </div>
      <a href="{{ route('listVentas') }}"><button type="button" class="btn colorBtnAtras font-weight-bold text-white"><i class="material-icons">check</i> Regresar</button></a>
    </div>
  </div>

</div>
@endsection