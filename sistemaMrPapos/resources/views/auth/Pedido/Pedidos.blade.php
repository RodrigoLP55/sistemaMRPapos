@extends('layouts.main', ['activePage' => 'pedido', 'titlePage' => __('Ventas')])

@section('content')
<div class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-azulejo">
          <div class="row justify-content-between">
            <div class="col-4">
              <h3 class="card-title fuenteNueva">PEDIDS</h3>
              <h5 class="card-title fuenteNueva">Lista de Pedidos:</h5>
            </div>
            <div class="col-3">
              <a href="{{ route('inicioPedido') }}"><button type="button" class="btn btn-success fuenteBtnV "><i class="material-icons">add_circle</i> COMENZAR PEDIDO</button></a>
            </div>
          </div>

        </div>
        <div class="card-body">
          @if(session('success'))
          <div class="alert alert-success" role="success">
            {{ session('success') }}
          </div>
          @endif

          <div class="row">
            <div class="col-md-auto">

            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="fontHeadTable">
                <th>
                  ID VENTA

                </th>

                <th>
                  PROVEEDOR

                </th>
                <th>
                  USUARIO

                </th>
                <th>
                  FECHA
                </th>
                <th>
                  TOTAL

                </th>
                <th>
                  ACCIONES

                </th>
              </thead>
              <tbody class="fontBodyTable">
                @foreach($datosPedido as $pedido)
                <tr>
                  <td>

                    {{ $pedido->id_pedido }}
                  </td>

                  <td>
                    {{ $pedido->id_proveedor_p }}

                  </td>
                  <td>
                    {{ $pedido->id_user_p }}

                  </td>
                  <td>
                    {{ $pedido->fecha_hora }}

                  </td>
                  <td>
                    {{ $pedido->total_p }}

                  </td>
                  <!--BOTONES DE ACCIONES-->
                  <td class="td-actions text-left">
                    <a href="{{ route('detallesPedido', $pedido->id_pedido) }}"><button type="button" title="Visualizar" class="btn colorBtnAzul btn-sm">
                        <i class="material-icons">visibility</i>
                      </button></a>


                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

          </div>

        </div>
      </div>
    </div>
  </div>

</div>
@endsection