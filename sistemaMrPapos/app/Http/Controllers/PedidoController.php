<?php

namespace App\Http\Controllers;

use App\Models\CalzadoHasNumero;
use App\Models\DetallePedido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;
use App\Models\Proveedor;
use PhpParser\Node\Expr\Cast\Double;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    //'id_user_p',
    //'id_proveedor_p',
    //'fecha_hora',
    //'total_p',

    //OBTENER PEDIDOIS
    public function getPedidos()
    {
        //---Numero de zapatos e ID
        $datosPedido = DB::table('pedido')
            ->select('id_pedido', 'id_user_p', 'id_proveedor_p', 'fecha_hora', 'total_p')
            ->get();

        return view('auth.pedido.pedidos', compact('datosPedido'));
    }

    //OBTENER VENTAS CON PAGINA
    public function getVentasPaginas()
    {
        //---Numero de zapatos e ID
        $datosVenta = Pedido::paginate(5);
        return view('auth.pedido.pedidos', compact('datosVenta'));
    }


    //VER FORMULARIO
    public function setFormPedido()
    {
        $user = Auth::user();
        $iduser = $user->name;

        $proveedores = DB::table('proveedor')
            ->select('rfc', 'razon_social')
            ->get();

        return view('auth.pedido.iniPedido', compact('iduser', 'proveedores'));
    }

    //CREAR PEDIDO
    public function createPedido(Request $request)
    {

        $user = Auth::user();
        $iduser = $user->id;

        $mytime = Carbon::now();

        Pedido::create([
            'id_proveedor_p' => $request['proveedor'],
            'id_user_p' => $iduser,
            'fecha_hora' => $mytime,
            'total_p' => 0,
        ]);


        /**-----------SE MOSTRARA LOS PRODUCTOS AGRGADOS AL PEDIDO ACTUAL------------ */
        $PedidoAgregado = Pedido::latest('id_pedido')->first();
        //---PEDIDO ID
        $pedido = DB::table('pedido')
            ->select('id_pedido', 'fecha_hora', 'id_proveedor_p', 'total_p')
            ->where('id_pedido', '=', $PedidoAgregado['id_pedido'])
            ->get();
        $idnum = count($pedido);

        //---DETALLES DE PEDIDO
        $detallesPedido = DB::table('detalle_pedido')
            ->select('id_detalle_pedido', 'id_calzado_dp', 'numero', 'cant_dp', 'precio_uni', 'subtotal')
            ->where('id_pedido_dp', '=', $PedidoAgregado['id_pedido'])
            ->get();

        //DETALLES DEL CALZADO VENDIDO
        //--Get Numeros
        $numeros = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_c')
            ->get();

        return redirect()->route('calzadoListP', compact('detallesPedido', 'zapatos', 'numeros', 'pedido'))->with('success', 'Pedido comenzada correctamente');
    }

    //CREAR DETALLE PEDIDO
    public function createDetallePedido(Request $request)
    {
        $calzadoPedido = DB::table('calzado')
            ->select('precio_c')
            ->where('id_calzado', '=', $request['id_calzado_dp'])
            ->first();

        $precioCalzado = (float)$calzadoPedido->precio_c;


        $pedidoAgregado = Pedido::latest('id_pedido')->first();

        /**
         *id_detalle_pedido
         *id_pedido_dp
         *id_calzado_dp
         *numero
         *cant_dp
         *precio_uni
         *subtotal
         */
        DetallePedido::create([
            'id_pedido_dp' => $pedidoAgregado['id_pedido_dp'],
            'id_calzado_dp' => $request['id_calzado_dp'],
            'numero' => $request['numero'],
            'cant_dp' => $request['cantidad'],
            'precio_uni' => $precioCalzado,
            'subtotal' => 0.00,
        ]);

        //obtenerDatosDetallePedido
        $detallePedidoObtenido = DetallePedido::latest('id_detalle_pedido')->first();
        $numeroC = $detallePedidoObtenido['numero'];
        $idCalzado = $detallePedidoObtenido['id_calzado_dp'];
        $cantidadC = $detallePedidoObtenido['cant_dp'];

        $subtotaldp = $precioCalzado * $cantidadC;

        //OBTENER EXISTENCIAS
        $calzadohn = DB::table('calzado_has_numero')
            ->where('id_calzado_chn', '=', $idCalzado)
            ->where('id_numero_chn', '=', $numeroC)
            ->first();

        $existencias = (int)$calzadohn->existencias;

        $cantidadAumentada = $existencias + $cantidadC;

        //Aumentar existencias en inventario
        $aumento = DB::table('calzado_has_numero')
            ->where('id_calzado_chn', '=', $idCalzado)
            ->where('id_numero_chn', '=', $numeroC)
            ->update(['existencias' => $cantidadAumentada]);

        //multiplicar precio por cantidad
        $multiplicacionTotal = DB::table('detalle_pedido')
            ->where('id_detalle_pedido', '=', $detallePedidoObtenido->id_detalle_pedido)
            ->update(['subtotal' => $subtotaldp]);

        /**-----------SE MOSTRARA LOS PRODUCTOS AGRGADOS AL PEDIDO ACTUAL ACTUAL------------ */
        //---Pedido ID
        $pedido = DB::table('pedido')
            ->select('id_pedido', 'fecha_hora', 'id_proveedor_p', 'total_p')
            ->where('id_pedido', '=', $pedidoAgregado['id_pedido'])
            ->get();
        $idnum = count($pedido);

        //---DETALLES DE PEDIDO
        $detallesPedido = DB::table('detalle_pedido')
            ->select('id_detalle_pedido', 'id_calzado_dp', 'numero', 'cant_dp', 'precio_uni', 'subtotal')
            ->where('id_calzado_dp', '=', $pedidoAgregado['id_pedido'])
            ->get();

        //DETALLES DEL CALZADO PEDIDO
        //--Get Numeros
        $numeros = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_c')
            ->get();

        return redirect()->route('calzadoListP', compact('detallesPedido', 'zapatos', 'numeros', 'pedido'))->with('success', 'Producto agregado correctamente');
    }

    //COMPLETAR Pedido
    public function completePedido()
    {
        $PedidoAgregado = Pedido::latest('id_pedido')->first();
        $totalPedido = 0.0;

        $detallesPedido = DB::table('detalle_pedido')
            ->select('id_detalle_pedido', 'id_pedido_dp', 'id_calzado_dp', 'subtotal')
            ->where('id_pedido_dp', '=', $PedidoAgregado['id_pedido'])
            ->get();


        $pedido = DB::table('pedido')
            ->where('id_pedido', '=', $PedidoAgregado['id_pedido'])
            ->update(
                [
                    'total_p' => (float)$detallesPedido->sum('subtotal')
                ],
            );
        return redirect()->route('listPedidos')->with('success', 'Pedido Realizada Correctamente');
    }


    public function showPedido($id)
    {

        //---Pedido ID
        $pedido = DB::table('pedido')
            ->select('id_pedido', 'fecha_hora', 'id_proveedor_p', 'total_p')
            ->where('id_pedido', '=', $id)
            ->get();
        $idnum = count($pedido);

        //---DETALLES DE PEDIDO
        $detallesPedido = DB::table('detalle_pedido')
            ->select('id_detalle_pedido', 'id_calzado_dp', 'numero', 'cant_dp', 'precio_uni', 'subtotal')
            ->where('id_calzado_dp', '=', $id)
            ->get();

        //DETALLES DEL CALZADO PEDIDO
        //--Get Numeros
        $numeros = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_c')
            ->get();

        $idPedido = $id;

        return view('auth.pedido.detallespedido', compact('detallesPedido', 'zapatos', 'numeros', 'pedido', 'idPedido'));
    }


    /**---------------------------------------------METODOS DEL LISTADO DE PRODUCTOS -------------------------------------*/
    //--------------OBTENER TODOS LOS CALZADOS
    public function getCalzadosP()
    {

        //----PEDIDO-----
        $pedidoAgregado = Pedido::latest('id_pedido')->first();

        $idPedido = $pedidoAgregado->id_pedido;

        $nombreProveedor = $pedidoAgregado['id_proveedor_p'];

        $proveedor = $pedidoAgregado['id_proveedor_p'];
        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio

        $datosZapato = DB::table('calzado')
            ->join('calzado_has_proveedor', 'calzado.id_calzado', '=', 'calzado_has_proveedor.id_calzado_chp')
            ->where('calzado_has_proveedor.id_proveedor_chp', '=', $proveedor)
            ->get();

        //--Get Numeros
        $numeros = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_calzado_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.numero')
            ->where('existencias', '>', 0)
            ->get();

        //--Get Colores
        $colores = DB::table('calzado')
            ->join('calzado_has_color', 'calzado.id_calzado', '=', 'calzado_has_color.id_calzado_chc')
            ->join('color', 'color.id_color', '=', 'calzado_has_color.id_color_chc')
            ->select('calzado.id_calzado', 'color.nombre_color')
            ->get();

        //--Get TIPO
        $tipos = DB::table('calzado')
            ->join('tipo_calzado', 'calzado.id_tipo_c', '=', 'tipo_calzado.id_tipo_calzado')
            ->select('calzado.id_calzado', 'tipo_calzado.tipo')
            ->get();


        /**-----------SE MOSTRARA LOS PRODUCTOS AGRGADOS A LA VENTA ACTUAL------------ */
        //---Pedido ID
        $pedido = DB::table('pedido')
            ->select('id_pedido', 'fecha_hora', 'id_proveedor_p', 'total_p')
            ->where('id_pedido', '=', $pedidoAgregado['id_pedido'])
            ->get();
        $idnum = count($pedido);

        //---DETALLES DE PEDIDO
        $detallesPedido = DB::table('detalle_pedido')
            ->select('id_detalle_pedido', 'id_calzado_dp', 'numero', 'cant_dp', 'precio_uni', 'subtotal')
            ->where('id_calzado_dp', '=', $pedidoAgregado['id_pedido'])
            ->get();

        //DETALLES DEL CALZADO PEDIDO
        //--Get Numeros
        $numeroscp = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_c')
            ->get();

        return view('auth.pedido.addproductospedido', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreProveedor', 'detallesPedido', 'zapatos', 'numeroscp', 'pedido', 'idPedido'));
    }

    //--------------OBTENER CALZADO DE NIÑO
    public function getCalzadosNinio()
    {
        //----CLIENTE-----
        $pedidoAgregado = Pedido::latest('id_pedido')->first();

        $idPedido = $pedidoAgregado->id_pedido;

        $nombreProveedor = $pedidoAgregado['id_proveedor_p'];

        $proveedor = $pedidoAgregado['id_proveedor_p'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 1)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->join('calzado_has_proveedor', 'calzado.id_calzado', '=', 'calzado_has_proveedor.id_calzado_chp')
            ->where('calzado_has_proveedor.id_proveedor_chp', '=', $proveedor)
            ->where('calzado.id_tipo_c', '=', 1)
            ->get();


        //--Get Numeros
        $numeros = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_calzado_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.numero')
            ->where('existencias', '>', 0)
            ->get();

        //--Get Colores
        $colores = DB::table('calzado')
            ->join('calzado_has_color', 'calzado.id_calzado', '=', 'calzado_has_color.id_calzado_chc')
            ->join('color', 'color.id_color', '=', 'calzado_has_color.id_color_chc')
            ->select('calzado.id_calzado', 'color.nombre_color')
            ->get();

        //--Get TIPO
        $tipos = DB::table('calzado')
            ->join('tipo_calzado', 'calzado.id_tipo_c', '=', 'tipo_calzado.id_tipo_calzado')
            ->select('calzado.id_calzado', 'tipo_calzado.tipo')
            ->get();


        /**-----------SE MOSTRARA LOS PRODUCTOS AGRGADOS A LA VENTA ACTUAL------------ */
        //---Pedido ID
        $pedido = DB::table('pedido')
            ->select('id_pedido', 'fecha_hora', 'id_proveedor_p', 'total_p')
            ->where('id_pedido', '=', $pedidoAgregado['id_pedido'])
            ->get();
        $idnum = count($pedido);

        //---DETALLES DE PEDIDO
        $detallesPedido = DB::table('detalle_pedido')
            ->select('id_detalle_pedido', 'id_calzado_dp', 'numero', 'cant_dp', 'precio_uni', 'subtotal')
            ->where('id_calzado_dp', '=', $pedidoAgregado['id_pedido'])
            ->get();

        //DETALLES DEL CALZADO PEDIDO
        //--Get Numeros
        $numeroscp = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_c')
            ->get();
        return view('auth.pedido.addproductospedido', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreProveedor', 'detallesPedido', 'zapatos', 'numeroscp', 'pedido', 'idPedido'));
    }

    //--------------OBTENER CALZADO DE NIÑA
    public function getCalzadosNinia()
    {
        //----CLIENTE-----
        $pedidoAgregado = Pedido::latest('id_pedido')->first();

        $idPedido = $pedidoAgregado->id_pedido;

        $nombreProveedor = $pedidoAgregado['id_proveedor_p'];

        $proveedor = $pedidoAgregado['id_proveedor_p'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 2)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->join('calzado_has_proveedor', 'calzado.id_calzado', '=', 'calzado_has_proveedor.id_calzado_chp')
            ->where('calzado_has_proveedor.id_proveedor_chp', '=', $proveedor)
            ->where('calzado.id_tipo_c', '=', 2)
            ->get();

        //--Get Numeros
        $numeros = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_calzado_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.numero')
            ->where('existencias', '>', 0)
            ->get();

        //--Get Colores
        $colores = DB::table('calzado')
            ->join('calzado_has_color', 'calzado.id_calzado', '=', 'calzado_has_color.id_calzado_chc')
            ->join('color', 'color.id_color', '=', 'calzado_has_color.id_color_chc')
            ->select('calzado.id_calzado', 'color.nombre_color')
            ->get();

        //--Get TIPO
        $tipos = DB::table('calzado')
            ->join('tipo_calzado', 'calzado.id_tipo_c', '=', 'tipo_calzado.id_tipo_calzado')
            ->select('calzado.id_calzado', 'tipo_calzado.tipo')
            ->get();


        /**-----------SE MOSTRARA LOS PRODUCTOS AGRGADOS A LA VENTA ACTUAL------------ */
        //---Pedido ID
        $pedido = DB::table('pedido')
            ->select('id_pedido', 'fecha_hora', 'id_proveedor_p', 'total_p')
            ->where('id_pedido', '=', $pedidoAgregado['id_pedido'])
            ->get();
        $idnum = count($pedido);

        //---DETALLES DE PEDIDO
        $detallesPedido = DB::table('detalle_pedido')
            ->select('id_detalle_pedido', 'id_calzado_dp', 'numero', 'cant_dp', 'precio_uni', 'subtotal')
            ->where('id_calzado_dp', '=', $pedidoAgregado['id_pedido'])
            ->get();

        //DETALLES DEL CALZADO PEDIDO
        //--Get Numeros
        $numeroscp = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_c')
            ->get();
        return view('auth.pedido.addproductospedido', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreProveedor', 'detallesPedido', 'zapatos', 'numeroscp', 'pedido', 'idPedido'));
    }


    //--------------OBTENER CALZADO DE CABALLERO
    public function getCalzadosCaba()
    {
        //----CLIENTE-----
        $pedidoAgregado = Pedido::latest('id_pedido')->first();

        $idPedido = $pedidoAgregado->id_pedido;

        $nombreProveedor = $pedidoAgregado['id_proveedor_p'];

        $proveedor = $pedidoAgregado['id_proveedor_p'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 3)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->join('calzado_has_proveedor', 'calzado.id_calzado', '=', 'calzado_has_proveedor.id_calzado_chp')
            ->where('calzado_has_proveedor.id_proveedor_chp', '=', $proveedor)
            ->where('calzado.id_tipo_c', '=', 3)
            ->get();

        //--Get Numeros
        $numeros = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_calzado_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.numero')
            ->where('existencias', '>', 0)
            ->get();

        //--Get Colores
        $colores = DB::table('calzado')
            ->join('calzado_has_color', 'calzado.id_calzado', '=', 'calzado_has_color.id_calzado_chc')
            ->join('color', 'color.id_color', '=', 'calzado_has_color.id_color_chc')
            ->select('calzado.id_calzado', 'color.nombre_color')
            ->get();

        //--Get TIPO
        $tipos = DB::table('calzado')
            ->join('tipo_calzado', 'calzado.id_tipo_c', '=', 'tipo_calzado.id_tipo_calzado')
            ->select('calzado.id_calzado', 'tipo_calzado.tipo')
            ->get();


        /**-----------SE MOSTRARA LOS PRODUCTOS AGRGADOS A LA VENTA ACTUAL------------ */
        //---Pedido ID
        $pedido = DB::table('pedido')
            ->select('id_pedido', 'fecha_hora', 'id_proveedor_p', 'total_p')
            ->where('id_pedido', '=', $pedidoAgregado['id_pedido'])
            ->get();
        $idnum = count($pedido);

        //---DETALLES DE PEDIDO
        $detallesPedido = DB::table('detalle_pedido')
            ->select('id_detalle_pedido', 'id_calzado_dp', 'numero', 'cant_dp', 'precio_uni', 'subtotal')
            ->where('id_calzado_dp', '=', $pedidoAgregado['id_pedido'])
            ->get();

        //DETALLES DEL CALZADO PEDIDO
        //--Get Numeros
        $numeroscp = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_c')
            ->get();
        return view('auth.pedido.addproductospedido', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreProveedor', 'detallesPedido', 'zapatos', 'numeroscp', 'pedido', 'idPedido'));
    }



    //--------------OBTENER CALZADO DE DAMA
    public function getCalzadosDama()
    {
        //----CLIENTE-----
        $pedidoAgregado = Pedido::latest('id_pedido')->first();

        $idPedido = $pedidoAgregado->id_pedido;

        $nombreProveedor = $pedidoAgregado['id_proveedor_P'];

        $proveedor = $pedidoAgregado['id_proveedor_p'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 4)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->join('calzado_has_proveedor', 'calzado.id_calzado', '=', 'calzado_has_proveedor.id_calzado_chp')
            ->where('calzado_has_proveedor.id_proveedor_chp', '=', $proveedor)
            ->where('calzado.id_tipo_c', '=', 4)
            ->get();


        //--Get Numeros
        $numeros = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_calzado_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.numero')
            ->where('existencias', '>', 0)
            ->get();

        //--Get Colores
        $colores = DB::table('calzado')
            ->join('calzado_has_color', 'calzado.id_calzado', '=', 'calzado_has_color.id_calzado_chc')
            ->join('color', 'color.id_color', '=', 'calzado_has_color.id_color_chc')
            ->select('calzado.id_calzado', 'color.nombre_color')
            ->get();

        //--Get TIPO
        $tipos = DB::table('calzado')
            ->join('tipo_calzado', 'calzado.id_tipo_c', '=', 'tipo_calzado.id_tipo_calzado')
            ->select('calzado.id_calzado', 'tipo_calzado.tipo')
            ->get();


        /**-----------SE MOSTRARA LOS PRODUCTOS AGRGADOS A LA VENTA ACTUAL------------ */
        //---Pedido ID
        $pedido = DB::table('pedido')
            ->select('id_pedido', 'fecha_hora', 'id_proveedor_p', 'total_p')
            ->where('id_pedido', '=', $pedidoAgregado['id_pedido'])
            ->get();
        $idnum = count($pedido);

        //---DETALLES DE PEDIDO
        $detallesPedido = DB::table('detalle_pedido')
            ->select('id_detalle_pedido', 'id_calzado_dp', 'numero', 'cant_dp', 'precio_uni', 'subtotal')
            ->where('id_calzado_dp', '=', $pedidoAgregado['id_pedido'])
            ->get();

        //DETALLES DEL CALZADO PEDIDO
        //--Get Numeros
        $numeroscp = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_c')
            ->get();
        return view('auth.pedido.addproductospedido', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreProveedor', 'detallesPedido', 'zapatos', 'numeroscp', 'pedido', 'idPedido'));
    }


    //--------------OBTENER CALZADO BUSCADO POR MODELO
    public function getCalzadosBuscado(Request $request)
    {
        //----CLIENTE-----
        $pedidoAgregado = Pedido::latest('id_pedido')->first();

        $idPedido = $pedidoAgregado->id_pedido;

        $nombreProveedor = $pedidoAgregado['id_proveedor_p'];

        $proveedor = $pedidoAgregado['id_proveedor_p'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_proveedor', '=', $proveedor)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->join('calzado_has_proveedor', 'calzado.id_calzado', '=', 'calzado_has_proveedor.id_calzado_chp')
            ->where('calzado_has_proveedor.id_proveedor_chp', '=', $proveedor)
            ->where('modelo', 'like', $request['busqueda'])
            ->get();

        //--Get Numeros
        $numeros = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_calzado_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.numero')
            ->where('existencias', '>', 0)
            ->get();

        //--Get Colores
        $colores = DB::table('calzado')
            ->join('calzado_has_color', 'calzado.id_calzado', '=', 'calzado_has_color.id_calzado_chc')
            ->join('color', 'color.id_color', '=', 'calzado_has_color.id_color_chc')
            ->select('calzado.id_calzado', 'color.nombre_color')
            ->get();

        //--Get TIPO
        $tipos = DB::table('calzado')
            ->join('tipo_calzado', 'calzado.id_tipo_c', '=', 'tipo_calzado.id_tipo_calzado')
            ->select('calzado.id_calzado', 'tipo_calzado.tipo')
            ->get();


        /**-----------SE MOSTRARA LOS PRODUCTOS AGRGADOS A LA VENTA ACTUAL------------ */
        //---Pedido ID
        $pedido = DB::table('pedido')
            ->select('id_pedido', 'fecha_hora', 'id_proveedor_p', 'total_p')
            ->where('id_pedido', '=', $pedidoAgregado['id_pedido'])
            ->get();
        $idnum = count($pedido);

        //---DETALLES DE PEDIDO
        $detallesPedido = DB::table('detalle_pedido')
            ->select('id_detalle_pedido', 'id_calzado_dp', 'numero', 'cant_dp', 'precio_uni', 'subtotal')
            ->where('id_calzado_dp', '=', $pedidoAgregado['id_pedido'])
            ->get();

        //DETALLES DEL CALZADO PEDIDO
        //--Get Numeros
        $numeroscp = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_c')
            ->get();
        return view('auth.pedido.addproductospedido', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreProveedor', 'detallesPedido', 'zapatos', 'numeroscp', 'pedido', 'idPedido'));
    }

    //-------SHOW CLAZADO
    public function showCalzadoP($id)
    {
        //---zapatos ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_calzado', '=', $id)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_c')
            ->where('id_calzado', '=', $id)
            ->get();

        //--Get Numeros
        $numeros = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_calzado_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.numero', 'numero.id_numero', 'calzado_has_numero.existencias')
            ->where('existencias', '>', 0)
            ->where('id_calzado', '=', $id)
            ->get();

        //--Get Colores
        $colores = DB::table('calzado')
            ->join('calzado_has_color', 'calzado.id_calzado', '=', 'calzado_has_color.id_calzado_chc')
            ->join('color', 'color.id_color', '=', 'calzado_has_color.id_color_chc')
            ->select('calzado.id_calzado', 'color.nombre_color')
            ->where('id_calzado', '=', $id)
            ->get();

        //--Get TIPO
        $tipos = DB::table('calzado')
            ->join('tipo_calzado', 'calzado.id_tipo_c', '=', 'tipo_calzado.id_tipo_calzado')
            ->select('calzado.id_calzado', 'tipo_calzado.tipo')
            ->where('id_calzado', '=', $id)
            ->get();
        //dd($datosZapato);
        return view('auth.pedido.escogerCalzadoPedido', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }
}
