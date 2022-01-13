@extends('layouts.main', ['activePage' => 'pedidos', 'titlePage' => __('Detalle Pedido')])

@section('content')
<div class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="card">

        <div class="card-header card-header-azulejo">
          <h4 class="card-title fuenteNueva">DETALLE DEL PEDIDO</h4>
          <p class="card-category fuenteBtn">Numero: <strong> {{ $idPedido}} </strong></p>

        </div>
        <div class="card-body">

          @foreach($pedido as $pedi)
          <div class="row">
            <div class="col-sm-4">
              <h4 class="card-title fuenteNueva">Proveedor:</h4>
              <p class="ventaFont">{{ $pedi->id_proveedor_p }}</p>
            </div>

            <div class="col-sm-4">
              <h4 class="card-title fuenteNueva">Fecha y Hora:</h4>
              <p class="ventaFont">{{ $pedi->fecha_hora }}</p>
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
                @foreach($detallesPedido as $detaPed)
                <tr>
                  <!--MARCA-->
                  <td>
                    @foreach($zapatos as $zapato)
                    @if($zapato->id_calzado == $detaPed->id_calzado_dp)
                    {{ $zapato->marca }}
                    @endif
                    @endforeach
                  </td>

                  <!--MODELO-->
                  <td>
                    @foreach($zapatos as $zapato)
                    @if($zapato->id_calzado == $detaPed->id_calzado_dp)
                    {{ $zapato->modelo }}
                    @endif
                    @endforeach
                  </td>

                  <!--NUMERO-->
                  <td>
                    @foreach($numeros as $numero)
                    @if($numero->id_numero == $detaPed->numero)
                    {{ $numero->numero }}
                    @endif
                    @endforeach
                  </td>

                  <!--PRECIO UNITARIO-->
                  <td>
                    @foreach($zapatos as $zapato)
                    @if($zapato->id_calzado == $detaPed->id_calzado_dp)
                    {{ $zapato->precio_c }}
                    @endif
                    @endforeach
                  </td>

                  <!--CANTIDAD-->
                  <td>
                    {{ $detaPed->cant_dp }}
                  </td>



                  <!--SUBTOTAL-->
                  <td>
                    {{ $detaPed->subtotal }}
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

          @foreach($pedido as $pedi)
          <div class="row justify-content-end">
            <div class="col-sm-1">
              <h4 class="card-title fuenteNueva">Total:</h4>
            </div>
            <div class="col-sm-2">
              <p class="ventaFont">$ {{ $pedi->total_p }}</p>
            </div>
          </div>
          @endforeach
          
        </div>
        
      </div>
      <a href="{{ route('listPedidos') }}"><button type="button" class="btn colorBtnAtras font-weight-bold text-white"><i class="material-icons">check</i> Regresar</button></a>
    </div>
  </div>

</div>
@endsection