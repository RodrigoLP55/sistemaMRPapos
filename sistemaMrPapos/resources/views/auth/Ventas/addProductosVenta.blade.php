@extends('layouts.main', ['activePage' => 'ventas', 'titlePage' => __('Venta')])

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-azulejo">
          <div class="row">
            <div class="col-sm-6">
              <h3 class="card-title fuenteNueva">Continuar con Venta</h3>
              <p class="card-category fuenteBtn">Numero: <strong> {{ $idVenta}} </strong></p>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-6">
                  <h4 class="card-title fuenteNueva">Cliente: </h4>
                  <p class="card-category"> {{ $nombreCliente}} </p>
                </div>
                <div class="col-sm-6">
                  <h4 class="card-title fuenteNueva">Finalizar Venta: </h4>
                  <a href="{{ route('completarVenta') }}"><button type="button" class="btn btn-success font-weight-bold text-white"><i class="material-icons">check</i> Terminar Venta</button></a>
                </div>

              </div>
            </div>
          </div>


        </div>
        <div class="card-body">
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          @endif

          <!--TABLA PARA VER EL DETALLE DE LA VENTA-->
          <div class="row">
            <label for="productos" class="col-sm-4 col-form-label font-weight-bold text-dark fuenteEtiquetaNegr">PRODUCTOS ACTUALES:</label>
          </div>


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
                    @foreach($numeroscv as $numero)
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


          <!--TERMINA TABLA PARA VER EL DETALLE DE LA VENTA-->

          <div class="row">
            <!--SALTO DE LINEA-->
            <label for="email" class="col-sm-2 col-form-label font-weight-bold text-dark fuenteEtiquetaNegr"></label>
          </div>


          <!--TABLA PARA ESCOGER PRODUCTOS-->
          <div class="row">
            <label for="productos" class="col-sm-4 col-form-label font-weight-bold text-dark fuenteEtiquetaNegr">SELECCIONAR PRODUCTOS:</label>
          </div>
          <div class="row">
            <div class="col-md-auto">
              <a href="{{ route('calzadoListV') }}"><button type="button" class="btn btn-default font-weight-bold text-dark">MOSTRAR TODOS</button></a>
            </div>

            <div class="col-md-auto">
              <a href="{{ route('calzadoNinioV') }}"><button type="button" class="btn btn-default ">NIÑO</button></a>
            </div>

            <div class="col-md-auto">
              <a href="{{ route('calzadoNiniaV') }}"><button type="button" class="btn btn-default ">NIÑA</button></a>
            </div>

            <div class="col-md-auto">
              <a href="{{ route('calzadoCabaV') }}"><button type="button" class="btn btn-default ">CABALLERO</button></a>
            </div>

            <div class="col-md-auto">
              <a href="{{ route('calzadoDamaV') }}"><button type="button" class="btn btn-default ">DAMA</button></a>
            </div>


            <div class="col-sm-3">
              <form action="{{ route('calzadoBuscV') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="busqueda" placeholder="Buscar por modelo" aria-describedby="button-addon2">
                  <button type="submit" class="btn btn-default "><i class="material-icons">search</i></button>
                </div>
              </form>

            </div>
          </div>


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
                  TIPO
                </th>
                <th>
                  N. DISPONIBLES
                </th>
                <th>
                  COLORES
                </th>
                <th>
                  PRECIO
                </th>
                <th>
                  ACCIONES
                </th>
              </thead>
              <tbody class="fontBodyTable">
                @foreach($datosZapato as $zapato)
                <tr>
                  <td>
                    {{ $zapato->marca }}
                  </td>
                  <td>
                    {{ $zapato->modelo }}
                  </td>
                  <td>
                    @foreach($tipos as $tipoZap)
                    @if($zapato->id_calzado == $tipoZap->id_calzado)
                    {{ $tipoZap->tipo }}
                    @endif
                    @endforeach
                  </td>
                  <td>
                    @foreach($numeros as $numeroZap)
                    @if($zapato->id_calzado == $numeroZap->id_calzado)
                    {{ $numeroZap->numero }}
                    @endif
                    @endforeach
                  </td>
                  <td>
                    @foreach($colores as $colorZap)
                    @if($zapato->id_calzado == $colorZap->id_calzado)
                    {{ $colorZap->nombre_color }}
                    @endif
                    @endforeach
                  </td>
                  <td>
                    $ {{ $zapato->precio_v }}
                  </td>

                  <!--BOTONES DE ACCIONES-->
                  <td class="td-actions text-left">
                    <a href="{{ route('escogeCalzado', $zapato->id_calzado) }}"><button type="button" title="Agregar a Venta" class="btn colorBtnAzul btn-sm">
                        <i class="material-icons">add_circle</i>
                      </button></a>

                    <!--
                    <a href="#"><button type="button" title="Remover" class="btn btn-primary btn-link btn-sm">
                        <i class="material-icons">close</i>
                      </button></a>
                      -->

                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!--TERMINA TABLA PARA ESCOGER PRODUCTOS-->

        </div>
      </div>
    </div>
  </div>

</div>
@endsection