<?php

namespace App\Http\Controllers;

use App\Models\CalzadoHasNumero;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use App\Models\DetalleVenta;
use PhpParser\Node\Expr\Cast\Double;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    //OBTENER VENTAS
    public function getVentas()
    {
        //---Numero de zapatos e ID
        $datosVenta = DB::table('venta')
            ->select('id_venta', 'id_user_v', 'nombre', 'fecha_hora', 'total')
            ->get();

        return view('auth.ventas.ventas', compact('datosVenta'));
    }

      //OBTENER VENTAS CON PAGINA
      public function getVentasPaginas()
      {
          //---Numero de zapatos e ID
          $datosVenta = Venta::paginate(5);
          return view('auth.ventas.ventas', compact('datosVenta'));
      }


    //VER FORMULARIO
    public function setFormVenta()
    {
        $user = Auth::user();
        $iduser = $user->name;

        return view('auth.ventas.iniVenta', compact('iduser'));
    }

    //CREAR VENTA
    public function createVenta(Request $request)
    {

        $user = Auth::user();
        $iduser = $user->id;

        $mytime = Carbon::now();

        Venta::create([
            'nombre' => $request['nombre'],
            'id_user_v' => $iduser,
            'fecha_hora' => $mytime,
            'total' => 0,
        ]);


        /**-----------SE MOSTRARA LOS PRODUCTOS AGRGADOS A LA VENTA ACTUAL------------ */
        $ventaAgregada = Venta::latest('id_venta')->first();
        //---Venta ID
        $venta = DB::table('venta')
            ->select('id_venta', 'fecha_hora', 'nombre', 'total')
            ->where('id_venta', '=', $ventaAgregada['id_venta'])
            ->get();
        $idnum = count($venta);

        //---DETALLES DE VENTA
        $detallesVenta = DB::table('detalle_venta')
            ->select('id_detalle_venta', 'id_calzado_dv', 'numero_dv', 'cant_dv', 'precio_uni', 'subtotal')
            ->where('id_venta_dv', '=', $ventaAgregada['id_venta'])
            ->get();

        //DETALLES DEL CALZADO VENDIDO
        //--Get Numeros
        $numeros = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
            ->get();

        return redirect()->route('calzadoListV', compact('detallesVenta', 'zapatos', 'numeros', 'venta'))->with('success', 'Venta comenzada correctamente');
    }

    //CREAR DETALLE VENTA
    public function createDetalleVenta(Request $request)
    {
        $calzadoVendido = DB::table('calzado')
            ->select('precio_v')
            ->where('id_calzado', '=', $request['id_calzado_dv'])
            ->first();

        $precioCalzado = (double)$calzadoVendido -> precio_v;


        $ventaAgregada = Venta::latest('id_venta')->first();

        DetalleVenta::create([
            'id_venta_dv' => $ventaAgregada['id_venta'],
            'id_calzado_dv' => $request['id_calzado_dv'],
            'numero_dv' => $request['numero'],
            'cant_dv' => $request['cantidad'],
            'precio_uni' => $precioCalzado,
            'subtotal' => 0.00,
        ]);

        //obtenerDatosDetalleVenta
        $detalleVentaObtenida = DetalleVenta::latest('id_detalle_venta')->first();
        $numeroC = $detalleVentaObtenida['numero_dv'];
        $idCalzado = $detalleVentaObtenida['id_calzado_dv'];
        $cantidadC = $detalleVentaObtenida['cant_dv'];

        $subtotaldv = $precioCalzado*$cantidadC;

        //OBTENER EXISTENCIAS
        $calzadohn = DB::table('calzado_has_numero')
        ->where('id_calzado_chn', '=', $idCalzado)
        ->where('id_numero_chn', '=', $numeroC)
        ->first();
        
        $existencias = (int)$calzadohn -> existencias;

        $cantidadRestante = $existencias - $cantidadC;

        //disminuir existencias en inventario
        $disminucion = DB::table('calzado_has_numero')
        ->where('id_calzado_chn', '=', $idCalzado)
        ->where('id_numero_chn', '=', $numeroC)
        ->update(['existencias' => $cantidadRestante]);

        //multiplicar precio por cantidad
        $multiplicacionTotal = DB::table('detalle_venta')
        ->where('id_detalle_venta', '=', $detalleVentaObtenida -> id_detalle_venta)
        ->update(['subtotal' => $subtotaldv]);

        /**-----------SE MOSTRARA LOS PRODUCTOS AGRGADOS A LA VENTA ACTUAL------------ */
        //---Venta ID
        $venta = DB::table('venta')
            ->select('id_venta', 'fecha_hora', 'nombre', 'total')
            ->where('id_venta', '=', $ventaAgregada['id_venta'])
            ->get();
        $idnum = count($venta);

        //---DETALLES DE VENTA
        $detallesVenta = DB::table('detalle_venta')
            ->select('id_detalle_venta', 'id_calzado_dv', 'numero_dv', 'cant_dv', 'precio_uni', 'subtotal')
            ->where('id_venta_dv', '=', $ventaAgregada['id_venta'])
            ->get();

        //DETALLES DEL CALZADO VENDIDO
        //--Get Numeros
        $numeros = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
            ->get();

        return redirect()->route('calzadoListV', compact('detallesVenta', 'zapatos', 'numeros', 'venta'))->with('success', 'Producto agregado correctamente');
    }

    //COMPLETAR VENTA
    public function completeVenta()
    {
        $ventaAgregada = Venta::latest('id_venta')->first();
        $totalVenta = 0.0;

        $detallesVenta = DB::table('detalle_venta')
            ->select('id_detalle_venta', 'id_venta_dv', 'id_calzado_dv', 'subtotal')
            ->where('id_venta_dv', '=', $ventaAgregada['id_venta'])
            ->get();
        

        $venta = DB::table('venta')
            ->where('id_venta', '=', $ventaAgregada['id_venta'])
            ->update(
                [
                    'total' => (double)$detallesVenta->sum('subtotal')
                ],
            );
        return redirect()->route('listVentas')->with('success', 'Venta Realizada Correctamente');
    }


    public function showVenta($id)
    {
        //---Venta ID
        $venta = DB::table('venta')
            ->select('id_venta', 'fecha_hora', 'nombre', 'total')
            ->where('id_venta', '=', $id)
            ->get();
        $idnum = count($venta);

        //---DETALLES DE VENTA
        $detallesVenta = DB::table('detalle_venta')
            ->select('id_detalle_venta', 'id_calzado_dv', 'numero_dv', 'cant_dv', 'precio_uni', 'subtotal')
            ->where('id_venta_dv', '=', $id)
            ->get();

        //DETALLES DEL CALZADO VENDIDO
        //--Get Numeros
        $numeros = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
            ->get();


            $idVenta = $id;    
        return view('auth.ventas.detallesventa', compact('detallesVenta', 'zapatos', 'numeros', 'venta', 'idVenta'));
    }


    /**---------------------------------------------METODOS DEL LISTADO DE PRODUCTOS -------------------------------------*/
    //--------------OBTENER TODOS LOS CALZADOS
    public function getCalzados()
    {

        //----CLIENTE-----
        $ventaAgregada = Venta::latest('id_venta')->first();

        $idVenta = $ventaAgregada -> id_venta;

        $nombreCliente = $ventaAgregada['nombre'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
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
        //---Venta ID
        $venta = DB::table('venta')
            ->select('id_venta', 'fecha_hora', 'nombre', 'total')
            ->where('id_venta', '=', $ventaAgregada['id_venta'])
            ->get();
        $idnum = count($venta);

        //---DETALLES DE VENTA
        $detallesVenta = DB::table('detalle_venta')
            ->select('id_detalle_venta', 'id_calzado_dv', 'numero_dv', 'cant_dv', 'precio_uni', 'subtotal')
            ->where('id_venta_dv', '=', $ventaAgregada['id_venta'])
            ->get();

        //DETALLES DEL CALZADO VENDIDO
        //--Get Numeros
        $numeroscv = DB::table('numero')
            ->select('id_numero', 'numero')
            ->get();

        //---Get Calzados    
        $zapatos = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
            ->get();   

        return view('auth.ventas.addproductosventa', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreCliente', 'detallesVenta', 'zapatos', 'numeroscv', 'venta', 'idVenta'));
    }

    //--------------OBTENER CALZADO DE NIÑO
    public function getCalzadosNinio()
    {
        //----CLIENTE-----
        $ventaAgregada = Venta::latest('id_venta')->first();

        $idVenta = $ventaAgregada -> id_venta;

        $nombreCliente = $ventaAgregada['nombre'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 1)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
            ->where('id_tipo_c', '=', 1)
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
         $ventaAgregada = Venta::latest('id_venta')->first();
         //---Venta ID
         $venta = DB::table('venta')
             ->select('id_venta', 'fecha_hora', 'nombre', 'total')
             ->where('id_venta', '=', $ventaAgregada['id_venta'])
             ->get();
         $idnum = count($venta);
 
         //---DETALLES DE VENTA
         $detallesVenta = DB::table('detalle_venta')
             ->select('id_detalle_venta', 'id_calzado_dv', 'numero_dv', 'cant_dv', 'precio_uni', 'subtotal')
             ->where('id_venta_dv', '=', $ventaAgregada['id_venta'])
             ->get();
 
         //DETALLES DEL CALZADO VENDIDO
         //--Get Numeros
         $numeroscv = DB::table('numero')
             ->select('id_numero', 'numero')
             ->get();
 
         //---Get Calzados    
         $zapatos = DB::table('calzado')
             ->select('id_calzado', 'marca', 'modelo', 'precio_v')
             ->get();   
 
         return view('auth.ventas.addproductosventa', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreCliente', 'detallesVenta', 'zapatos', 'numeroscv', 'venta', 'idVenta'));
    }

    //--------------OBTENER CALZADO DE NIÑA
    public function getCalzadosNinia()
    {
        //----CLIENTE-----
        $ventaAgregada = Venta::latest('id_venta')->first();

        $idVenta = $ventaAgregada -> id_venta;

        $nombreCliente = $ventaAgregada['nombre'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 2)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
            ->where('id_tipo_c', '=', 2)
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
         $ventaAgregada = Venta::latest('id_venta')->first();
         //---Venta ID
         $venta = DB::table('venta')
             ->select('id_venta', 'fecha_hora', 'nombre', 'total')
             ->where('id_venta', '=', $ventaAgregada['id_venta'])
             ->get();
         $idnum = count($venta);
 
         //---DETALLES DE VENTA
         $detallesVenta = DB::table('detalle_venta')
             ->select('id_detalle_venta', 'id_calzado_dv', 'numero_dv', 'cant_dv', 'precio_uni', 'subtotal')
             ->where('id_venta_dv', '=', $ventaAgregada['id_venta'])
             ->get();
 
         //DETALLES DEL CALZADO VENDIDO
         //--Get Numeros
         $numeroscv = DB::table('numero')
             ->select('id_numero', 'numero')
             ->get();
 
         //---Get Calzados    
         $zapatos = DB::table('calzado')
             ->select('id_calzado', 'marca', 'modelo', 'precio_v')
             ->get();   
 
         return view('auth.ventas.addproductosventa', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreCliente', 'detallesVenta', 'zapatos', 'numeroscv', 'venta', 'idVenta'));
    }

    //--------------OBTENER CALZADO DE CABALLERO
    public function getCalzadosCaba()
    {
        //----CLIENTE-----
        $ventaAgregada = Venta::latest('id_venta')->first();

        $idVenta = $ventaAgregada -> id_venta;

        $nombreCliente = $ventaAgregada['nombre'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 3)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
            ->where('id_tipo_c', '=', 3)
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
         $ventaAgregada = Venta::latest('id_venta')->first();
         //---Venta ID
         $venta = DB::table('venta')
             ->select('id_venta', 'fecha_hora', 'nombre', 'total')
             ->where('id_venta', '=', $ventaAgregada['id_venta'])
             ->get();
         $idnum = count($venta);
 
         //---DETALLES DE VENTA
         $detallesVenta = DB::table('detalle_venta')
             ->select('id_detalle_venta', 'id_calzado_dv', 'numero_dv', 'cant_dv', 'precio_uni', 'subtotal')
             ->where('id_venta_dv', '=', $ventaAgregada['id_venta'])
             ->get();
 
         //DETALLES DEL CALZADO VENDIDO
         //--Get Numeros
         $numeroscv = DB::table('numero')
             ->select('id_numero', 'numero')
             ->get();
 
         //---Get Calzados    
         $zapatos = DB::table('calzado')
             ->select('id_calzado', 'marca', 'modelo', 'precio_v')
             ->get();   
 
         return view('auth.ventas.addproductosventa', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreCliente', 'detallesVenta', 'zapatos', 'numeroscv', 'venta', 'idVenta'));
    }

    //--------------OBTENER CALZADO DE DAMA
    public function getCalzadosDama()
    {
        //----CLIENTE-----
        $ventaAgregada = Venta::latest('id_venta')->first();

        $idVenta = $ventaAgregada -> id_venta;

        $nombreCliente = $ventaAgregada['nombre'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 4)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
            ->where('id_tipo_c', '=', 4)
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
         $ventaAgregada = Venta::latest('id_venta')->first();
         //---Venta ID
         $venta = DB::table('venta')
             ->select('id_venta', 'fecha_hora', 'nombre', 'total')
             ->where('id_venta', '=', $ventaAgregada['id_venta'])
             ->get();
         $idnum = count($venta);
 
         //---DETALLES DE VENTA
         $detallesVenta = DB::table('detalle_venta')
             ->select('id_detalle_venta', 'id_calzado_dv', 'numero_dv', 'cant_dv', 'precio_uni', 'subtotal')
             ->where('id_venta_dv', '=', $ventaAgregada['id_venta'])
             ->get();
 
         //DETALLES DEL CALZADO VENDIDO
         //--Get Numeros
         $numeroscv = DB::table('numero')
             ->select('id_numero', 'numero')
             ->get();
 
         //---Get Calzados    
         $zapatos = DB::table('calzado')
             ->select('id_calzado', 'marca', 'modelo', 'precio_v')
             ->get();   
 
         return view('auth.ventas.addproductosventa', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreCliente', 'detallesVenta', 'zapatos', 'numeroscv', 'venta', 'idVenta'));
    }

    //--------------OBTENER CALZADO BUSCADO POR MODELO
    public function getCalzadosBuscado(Request $request)
    {
        //----CLIENTE-----
        $ventaAgregada = Venta::latest('id_venta')->first();

        $idVenta = $ventaAgregada -> id_venta;

        $nombreCliente = $ventaAgregada['nombre'];

        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('modelo', 'like', $request['busqueda'])
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
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
         $ventaAgregada = Venta::latest('id_venta')->first();
         //---Venta ID
         $venta = DB::table('venta')
             ->select('id_venta', 'fecha_hora', 'nombre', 'total')
             ->where('id_venta', '=', $ventaAgregada['id_venta'])
             ->get();
         $idnum = count($venta);
 
         //---DETALLES DE VENTA
         $detallesVenta = DB::table('detalle_venta')
             ->select('id_detalle_venta', 'id_calzado_dv', 'numero_dv', 'cant_dv', 'precio_uni', 'subtotal')
             ->where('id_venta_dv', '=', $ventaAgregada['id_venta'])
             ->get();
 
         //DETALLES DEL CALZADO VENDIDO
         //--Get Numeros
         $numeroscv = DB::table('numero')
             ->select('id_numero', 'numero')
             ->get();
 
         //---Get Calzados    
         $zapatos = DB::table('calzado')
             ->select('id_calzado', 'marca', 'modelo', 'precio_v')
             ->get();   
 
         return view('auth.ventas.addproductosventa', compact('datosZapato', 'numeros', 'colores', 'tipos', 'nombreCliente', 'detallesVenta', 'zapatos', 'numeroscv', 'venta', 'idVenta'));
    }

    //-------SHOW CLAZADO
    public function showCalzadoV($id)
    {
        //---zapatos ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_calzado', '=', $id)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v')
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
        return view('auth.ventas.escogerCalzado', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }
}
