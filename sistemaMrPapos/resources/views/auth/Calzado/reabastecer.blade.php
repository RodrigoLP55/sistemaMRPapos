@extends('layouts.main', ['activePage' => 'reabastecer', 'titlePage' => __('Reabastecimiento')])

@section('content')
<div class="content">
  <!--div class="row">
    @foreach($datosZapato as $zapato)
    <div class="col-sm-3">
      <div class="card" style="width: 15rem;">
        <div class="card-body">
          <--h4 class="card-title"></h4--
          <h5 class="card-subtitle mb-2 text-muted">{{ $zapato->marca }}</h5>
          <h6 class="card-subtitle mb-2 text-muted">{{ $zapato->modelo }}</h6>
          <h6 class="card-subtitle mb-2 text-muted">$ {{ $zapato->precio_v }}</h6>
          <h6 class="card-subtitle mb-2 text-muted">
            @foreach($tipos as $tipoZap)
            @if($zapato->id_calzado == $tipoZap->id_calzado)
            {{ $tipoZap->tipo }}
            @endif
            @endforeach

          </h6>
          <h6 class="card-subtitle mb-2 text-muted">
            @foreach($numeros as $numeroZap)
            @if($zapato->id_calzado == $numeroZap->id_calzado)
            {{ $numeroZap->numero }}
            @endif
            @endforeach
          </h6>

          <h6 class="card-subtitle mb-2 text-muted">
            @foreach($colores as $colorZap)
            @if($zapato->id_calzado == $colorZap->id_calzado)
            {{ $colorZap->nombre_color }}
            @endif
            @endforeach
          </h6>

          <a href="#" class="card-link">Opcion 1</a>
          <a href="#" class="card-link">Opcion 1</a>
        </div>
      </div>
    </div>
    @endforeach


  </div-->
  <div class="row">
    <div class="col-md-12">   
      <div class="card">
        <div class="card-header card-header-azulejo">
          <h3 class="card-title fuenteNueva">REABASTECIMIENTO</h3>
          <h5 class="card-title">Ordenar productos por:</h5>
        </div>
        <div class="card-body">
          @if(session('success'))
          <div class="alert alert-success" role="success">
              {{ session('success') }}
            </div>
          @endif
            
          <div class="row">
            <div class="col-md-auto">
              <a href="{{ route('calzadoListReabastecer') }}"><button type="button" class="btn fuenteBtn colorBtn">MOSTRAR TODOS</button></a>
            </div>

            <div class="col-md-auto">
              <a href="{{ route('calzadoNinioReabastecer') }}"><button type="button" class="btn btn-default fuenteBtn">NIÑO</button></a>
            </div>

            <div class="col-md-auto">
              <a href="{{ route('calzadoNiniaReabastecer') }}"><button type="button" class="btn btn-default fuenteBtn">NIÑA</button></a>
            </div>

            <div class="col-md-auto">
              <a href="{{ route('calzadoCabaReabastecer') }}"><button type="button" class="btn btn-default fuenteBtn">CABALLERO</button></a>
            </div>

            <div class="col-md-auto">
              <a href="{{ route('calzadoDamaReabastecer') }}"><button type="button" class="btn btn-default fuenteBtn">DAMA</button></a>
            </div>


            <div class="col-sm-3">
              <form action="{{ route('calzadoBuscReabastecer') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                  <input type="text" class="form-control fuenteBtn" name="busqueda" placeholder="Buscar por modelo" aria-describedby="button-addon2">
                  <button type="submit" class="btn btn-default fuenteBtn"><i class="material-icons">search</i></button>
                </div>
              </form>

            </div>

          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="fontHeadTable">
                <th>
                <B class="fuenteNueva">ID MARCA</B>
                </th>
                <th>
                  
                  <B class="fuenteNueva">MODELO</B>
                </th>
                <th>
                  
                  <B class="fuenteNueva">TIPO</B>
                </th>
                <th>
                  
                  <B class="fuenteNueva">N. DISPONIBLES</B>
                </th>
                
                <th>
                  
                  <B class="fuenteNueva">PRECIO</B>
                </th>
                <th>
                  
                  <B class="fuenteNueva">ACCIONES</B>
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
                    <B> {{ $numeroZap->numero }} </B>
                    
                    @endif
                    @endforeach
                  </td>
                  
                  <td>
                  $ {{ $zapato->precio_v }}
                   
                  </td>

                  <!--BOTONES DE ACCIONES-->
                  <td class="td-actions text-left">
                    <a href="{{ route('formReabastecer', $zapato->id_calzado) }}"><button type="button" title="Reabastecer" class="btn colorBtnAzul btn-sm">
                        <i class="material-icons">archive</i>
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