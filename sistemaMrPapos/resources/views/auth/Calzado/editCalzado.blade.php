@extends('layouts.main', ['activePage' => 'productosA', 'titlePage' => __('Formulario')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-12">
                @foreach($datosZapato as $zapatog)
                <form action="{{ route('actualizarCalzado', $zapatog->id_calzado) }}" method="post" class="form-horizontal">
                   
                    @csrf
                    @method('PUT')
                    
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title  font-weight-bold text-align-center">EDITAR CALZADO</h4>
                            <h5 class="card-title  font-weight-bold">Actualiza los datos</h5>
                            <h4 class="card-title  font-weight-bold"></h4>
                            
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <!--MARCA-->

                                    <label for="marca" class="col-sm-2 col-form-label font-weight-bold">Marca:</label>
        
                               
                                @foreach($datosZapato as $zapato)                                    
                                    <div class="col-sm-3">
                                    <input type="text" class="form-control" name="marca" value="{{ $zapato->marca }}">
                                </div>
                                @endforeach                             
                            </div>

                            <div class="row">
                                <!--MODELO-->
                                <label for="modelo" class="col-sm-2 col-form-label font-weight-bold">Modelo:</label>
                                @foreach($datosZapato as $zapato)                                    
                                    <div class="col-sm-3">
                                    <input type="text" class="form-control" name="modelo" value="{{ $zapato->modelo }}">
                                </div>
                                @endforeach
                            </div>


                            <div class="row">                           

                                <!--PRECIO C-->
                                <label for="precio_c" class="col-sm-2 col-form-label font-weight-bold">Precio de Compra:</label>
                                @foreach($datosZapato as $zapato)    
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="precio_c" value="{{ $zapato->precio_c }}" >
                                </div>
                                @endforeach

                            </div>

                            <div class="row">
                                <!--PRECIO V-->
                                <label for="precio_v" class="col-sm-2 col-form-label font-weight-bold">Precio de Venta:</label>
                                @foreach($datosZapato as $zapato)    
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="precio_v" value="{{ $zapato->precio_v }}" >
                                </div>
                                @endforeach
                            </div>

                            <!--
                            <div class="row">
                                    <label for="numeros" class="col-sm-3 col-form-label font-weight-bold">Numeros:</label>
                            </div>

                            <div class="row align-items-end">                            
                                <!--N. 16--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">16:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n16" placeholder="" value="0" autofocus>
                                </div>      
                                
                                <!--N. 17--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">17:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n17" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 18--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">18:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n18" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 19--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">19:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n19" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 20--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">20:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n20" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 21--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">21:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n21" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 22--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">22:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n22" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 23--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">23:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n23" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 24--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">24:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n24" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 25--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">25:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n25" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 26--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">26:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n26" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 27--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">27:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n27" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 28--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">N.28:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n28" placeholder="" value="0" autofocus>
                                </div>

                                <!--N. 29--
                                <label for="precio_c" class="col-sm col-form-label font-weight-bold">29:</label>
                                <div class="col-sm">
                                    <input type="text" class="form-control" name="n29" placeholder="" value="0" autofocus>
                                </div>



                            </div-->


                        </div>
                        <!--Footer-->
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                        <!--End Footer-->
                </form>
                @endforeach

            </div>
        </div>


        <div class="row">
            <div class="col-sm-1">
                <a href="{{ route('calzadoList') }}"><button type="button" class="btn btn-secondarys">Atras</button></a>
            </div>
        </div>


    </div>
</div>




@endsection