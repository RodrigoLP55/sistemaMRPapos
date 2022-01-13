<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Calzado;

use App\Models\Color;
use App\Models\Numero;
use App\Models\Proveedor;

use App\Models\CalzadoHasColor;
use App\Models\CalzadoHasNumero;
use App\Models\CalzadoHasProveedor;

use App\Models\TipoCalzado;


class CalzadoController extends Controller
{
    //--------------FORMULARIO---------------------------------------
    //vista
    public function viewFormProductos()
    {

        return view('auth.calzado.formcalzado');
    }
    //llenarFormulario

    public function setForm()
    {
        $proveedores = DB::table('proveedor')
            ->select('rfc', 'razon_social')
            ->get();


        $numeros = DB::table('numero')
            ->select('numero')
            ->get();


        //--Get Colores
        $colores = DB::table('color')         
            ->select('id_color', 'nombre_color')
            ->get();

        return view('auth.calzado.formcalzado', compact('proveedores', 'numeros', 'colores'));
    }

    //--------------CREAR CALZADO---------------------------------------
    public function createCalzado(Request $request)
    {
        Calzado::create([
            'marca' => $request['marca'],
            'modelo' => $request['modelo'],
            'id_tipo_c' => (int)$request['tipo'],
            'precio_c' => $request['precio_c'],
            'precio_v' => $request['precio_v'],

        ]);


        $calzadoAgregado = Calzado::latest('id_calzado')->first();
        print_r($calzadoAgregado);

        CalzadoHasProveedor::create([
            'id_calzado_chp' => $calzadoAgregado['id_calzado'],
            'id_proveedor_chp' => (int)$request['proveedor'],
        ]);


        $tipo = (int)$request['tipo'];

        //NIÑO
        if ($tipo == 1) {
            for ($i = 1; $i < 7; $i++) {
                CalzadoHasNumero::create([
                    'id_calzado_chn' => $calzadoAgregado['id_calzado'],
                    'id_numero_chn' => $i,
                    'existencias' => 0,
                ]);
            }
        }

        //NIÑA
        else if ($tipo == 2) {
            for ($i = 1; $i < 7; $i++) {
                CalzadoHasNumero::create([
                    'id_calzado_chn' => $calzadoAgregado['id_calzado'],
                    'id_numero_chn' => $i,
                    'existencias' => 0,
                ]);
            }
        }

        //CABALLERO
        else if ($tipo == 3) {
            for ($i = 7; $i < 15; $i++) {
                CalzadoHasNumero::create([
                    'id_calzado_chn' => $calzadoAgregado['id_calzado'],
                    'id_numero_chn' => $i,
                    'existencias' => 0,
                ]);
            }
        }

        //DAMA
        else if ($tipo == 4) {
            for ($i = 7; $i < 15; $i++) {
                CalzadoHasNumero::create([
                    'id_calzado_chn' => $calzadoAgregado['id_calzado'],
                    'id_numero_chn' => $i,
                    'existencias' => 0,
                ]);
            }
        }




        return redirect()->route('reabastecerOCancel');
    }

    //--------------CONSULTAS---------------------------------------

    //--------------OBTENER TODOS LOS CALZADOS
    public function getCalzados()
    {
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

        $tableName = 'calzado';

        return view('auth.calzado.productos', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    //--------------OBTENER CALZADO DE NIÑO
    public function getCalzadosNinio()
    {
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

        return view('auth.calzado.productos', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    //--------------OBTENER CALZADO DE NIÑA
    public function getCalzadosNinia()
    {
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

        return view('auth.calzado.productos', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    //--------------OBTENER CALZADO DE CABALLERO
    public function getCalzadosCaba()
    {
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

        return view('auth.calzado.productos', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    //--------------OBTENER CALZADO DE DAMA
    public function getCalzadosDama()
    {
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

        return view('auth.calzado.productos', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    //--------------OBTENER CALZADO BUSCADO POR MODELO
    public function getCalzadosBuscado(Request $request)
    {
        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 4)
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

        return view('auth.calzado.productos', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }


    //---------------------ACCIONES--------------------------------------------------------------------------

    //------EDITAR
    public function editCalzado($id)
    {
        $proveedores = DB::table('proveedor')
            ->select('rfc', 'razon_social')
            ->get();

        //---zapatos ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_calzado', '=', $id)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v', 'precio_c')
            ->where('id_calzado', '=', $id)
            ->get();

        //--Get Numeros
        $numeros = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_calzado_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.numero', 'calzado_has_numero.existencias')
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
        return view('auth.calzado.editCalzado', compact('proveedores', 'datosZapato', 'numeros', 'colores', 'tipos'));
    }

     //------ACTUALIZAR CALZADO
    public function updateCalzado(Request $request, $id)
    {
        $calzado = DB::table('calzado')
            ->where('id_calzado', $id)
            ->update(
                [
                    'marca' => $request['marca'],
                    'modelo' => $request['modelo'],
                    'precio_c' => $request['precio_c'],
                    'precio_v' => $request['precio_v']
                ],
            );
        return redirect()->route('calzadoList')->with('success', 'Calzado actualizado correctamente');
    }

    //------ELIMINAR
    public function deleteCalzado($id)
    {
        DB::table('calzado_has_numero')->where('id_calzado_chn', '=', $id)->delete();
        DB::table('calzado_has_proveedor')->where('id_calzado_chp', '=', $id)->delete();
        DB::table('calzado')->where('id_calzado', '=', $id)->delete();
        return redirect()->route('calzadoList')->with('success', 'Calzado eliminado correctamente');
    }

    public function getNumbers($id)
    {
        $datosZapato = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_numero_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.numero')
            ->where('id_calzado', '=', $id)
            ->get();
    }

    //-------SHOW CLAZADO
    public function show($id)
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
            ->select('calzado.id_calzado', 'numero.numero', 'calzado_has_numero.existencias')
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
        return view('auth.calzado.detallesCalzado', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    /**---------------------------------------------------MODULO DE REABASTECIMIENTO------------------------------------------------------*/

    //-------VISTA GENERAL-----
    //vista
    public function viewReabastecimiento()
    {

        return view('auth.calzado.reabastecer');
    }

    //-------FORMULARIO-----

    public function setFormReabastecimiento()
    {
        $proveedores = DB::table('proveedor')
            ->select('rfc', 'razon_social')
            ->get();


        $numeros = DB::table('numero')
            ->select('numero')
            ->get();
        return view('auth.calzado.formcalzado', compact('proveedores', 'numeros'));
    }

    

    //--------------OBTENER TODOS LOS CALZADOS DEL REABASTECIMIENTO
    public function getCalzadosReabastecer()
    {
        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v', 'id_tipo_c')
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

        return view('auth.calzado.reabastecer', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    //--------------OBTENER CALZADO DE NIÑO  DEL REABASTECIMIENTO
    public function getCalzadosNinioReabastecer()
    {
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

        return view('auth.calzado.reabastecer', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    //--------------OBTENER CALZADO DE NIÑA  DEL REABASTECIMIENTO
    public function getCalzadosNiniaReabastecer()
    {
        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 2)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v', 'id_tipo_c')
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

        return view('auth.calzado.reabastecer', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    //--------------OBTENER CALZADO DE CABALLERO  DEL REABASTECIMIENTO
    public function getCalzadosCabaReabastecer()
    {
        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 3)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v', 'id_tipo_c')
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

        return view('auth.calzado.reabastecer', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    //--------------OBTENER CALZADO DE DAMA DEL REABASTECIMIENTO
    public function getCalzadosDamaReabastecer()
    {
        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 4)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v', 'id_tipo_c')
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

        return view('auth.calzado.reabastecer', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    //--------------OBTENER CALZADO BUSCADO POR MODELO DEL REABASTECIMIENTO
    public function getCalzadosBuscadoReabastecer(Request $request)
    {
        //---Numero de zapatos e ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_tipo_c', '=', 4)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v', 'id_tipo_c')
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

        return view('auth.calzado.reabastecer', compact('datosZapato', 'numeros', 'colores', 'tipos'));
    }

    /**VISTA DEL FORMULARIO DE ABASTECIMIENTO */
    public function setFormReabastecer2()
    {
        $proveedores = DB::table('proveedor')
            ->select('rfc', 'razon_social')
            ->get();


        $numeros = DB::table('numero')
            ->select('numero')
            ->get();
        return view('auth.calzado.formcalzado', compact('proveedores', 'numeros'));
    }


    public function setFormReabastecer($id)
    {
        //---zapatos ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_calzado', '=', $id)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v', 'id_tipo_c')
            ->where('id_calzado', '=', $id)
            ->get();

        //--Get Numeros
        $numeros = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_calzado_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.id_numero', 'numero.numero', 'calzado_has_numero.existencias')
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
            ->select('calzado.id_calzado', 'tipo_calzado.tipo', 'tipo_calzado.id_tipo_calzado')
            ->where('id_calzado', '=', $id)
            ->get();

        //--Get Colores
        $coloresList = DB::table('color')         
            ->select('id_color', 'nombre_color')
            ->get();
        //dd($datosZapato);


        return view('auth.calzado.formreabastecer', compact('datosZapato', 'numeros', 'colores', 'tipos', 'coloresList'));
    }

//--------------REABASTECER CALZADO---------------------------------------
    public function reabastecerCalzado(Request $request, $id, $tipo)
    {
   
        if($tipo == 1) //NIÑO
        {
            for ($i = 1; $i < 7; $i++)
            {
                $calzadoReabastecido = DB::table('calzado_has_numero')
                ->where('id_calzado_chn', $id)
                ->where('id_numero_chn', $i)
                ->update(
                    [
                        'existencias' => $request[$i],
                    ],
                );
            }

            
        }
        else if($tipo == 2) //NIÑA
        {
            for ($i = 1; $i < 7; $i++)
            {
                $calzadoReabastecido = DB::table('calzado_has_numero')
                ->where('id_calzado_chn', $id)
                ->where('id_numero_chn', $i)
                ->update(
                    [
                        'existencias' => $request[$i],
                    ],
                );
            }
        }
        else if($tipo == 3) //CABALLERO
        {
            for ($i = 7; $i < 15; $i++)
            {
                $calzadoReabastecido = DB::table('calzado_has_numero')
                ->where('id_calzado_chn', $id)
                ->where('id_numero_chn', $i)
                ->update(
                    [
                        'existencias' => $request[$i],
                    ],
                );
            }
        }
        else if($tipo == 4) //DAMA
        {
            for ($i = 7; $i < 15; $i++)
            {
                $calzadoReabastecido = DB::table('calzado_has_numero')
                ->where('id_calzado_chn', $id)
                ->where('id_numero_chn', $i)
                ->update(
                    [
                        'existencias' => $request[$i],
                    ],
                );
            }
        }


       
        return redirect()->route('calzadoListReabastecer')->with('success', 'Calzado reabastecido correctamente');
    }


    
    public function ASFASF(Request $request)
    {
        Calzado::create([
            'marca' => $request['marca'],
            'modelo' => $request['modelo'],
            'id_tipo_c' => (int)$request['tipo'],
            'precio_c' => $request['precio_c'],
            'precio_v' => $request['precio_v'],

        ]);


        $calzadoAgregado = Calzado::latest('id_calzado')->first();
        print_r($calzadoAgregado);

        CalzadoHasProveedor::create([
            'id_calzado_chp' => $calzadoAgregado['id_calzado'],
            'id_proveedor_chp' => (int)$request['proveedor'],
        ]);


        $tipo = (int)$request['tipo'];

        //NIÑO
        if ($tipo == 1) {
            for ($i = 1; $i < 7; $i++) {
                CalzadoHasNumero::create([
                    'id_calzado_chn' => $calzadoAgregado['id_calzado'],
                    'id_numero_chn' => $i,
                    'existencias' => 0,
                ]);
            }
        }

        //NIÑA
        else if ($tipo == 2) {
            for ($i = 1; $i < 7; $i++) {
                CalzadoHasNumero::create([
                    'id_calzado_chn' => $calzadoAgregado['id_calzado'],
                    'id_numero_chn' => $i,
                    'existencias' => 0,
                ]);
            }
        }

        //CABALLERO
        else if ($tipo == 3) {
            for ($i = 7; $i < 15; $i++) {
                CalzadoHasNumero::create([
                    'id_calzado_chn' => $calzadoAgregado['id_calzado'],
                    'id_numero_chn' => $i,
                    'existencias' => 0,
                ]);
            }
        }

        //DAMA
        else if ($tipo == 4) {
            for ($i = 7; $i < 15; $i++) {
                CalzadoHasNumero::create([
                    'id_calzado_chn' => $calzadoAgregado['id_calzado'],
                    'id_numero_chn' => $i,
                    'existencias' => 0,
                ]);
            }
        }




        return redirect()->route('calzadoList')->with('success', 'Calzado creado correctamente');
    }



    /**---------------------------------------------FINALIZA MODULO DE REABASTECIMIENTO------------------------------------------------------*/

    /**-------------------------CONTINUAR AL AGREGAR PARA REABASTECER AL MISMO TIEMPO-------------------------*/
    public function continuarReabastecer()
    {
        $calzadoAgregado = Calzado::latest('id_calzado')->first();

        $id = $calzadoAgregado['id_calzado'];

        //---zapatos ID
        $zapatosId = DB::table('calzado')
            ->select('id_calzado')
            ->where('id_calzado', '=', $id)
            ->get();
        $idnum = count($zapatosId);

        //--Get Marcas, Modelo, Precio
        $datosZapato = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo', 'precio_v', 'id_tipo_c')
            ->where('id_calzado', '=', $id)
            ->get();

        //--Get Numeros
        $numeros = DB::table('calzado')
            ->join('calzado_has_numero', 'calzado.id_calzado', '=', 'calzado_has_numero.id_calzado_chn')
            ->join('numero', 'numero.id_numero', '=', 'calzado_has_numero.id_numero_chn')
            ->select('calzado.id_calzado', 'numero.id_numero', 'numero.numero', 'calzado_has_numero.existencias')
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
            ->select('calzado.id_calzado', 'tipo_calzado.tipo', 'tipo_calzado.id_tipo_calzado')
            ->where('id_calzado', '=', $id)
            ->get();

        //--Get Colores
        $coloresList = DB::table('color')         
            ->select('id_color', 'nombre_color')
            ->get();
        //dd($datosZapato);


        return view('auth.calzado.formreabastecernuevo', compact('datosZapato', 'numeros', 'colores', 'tipos', 'coloresList'));
    }

    public function reabastecerCalzadoNuevo(Request $request, $id, $tipo)
    {
   
        if($tipo == 1) //NIÑO
        {
            for ($i = 1; $i < 7; $i++)
            {
                $calzadoReabastecido = DB::table('calzado_has_numero')
                ->where('id_calzado_chn', $id)
                ->where('id_numero_chn', $i)
                ->update(
                    [
                        'existencias' => $request[$i],
                    ],
                );
            }

            
        }
        else if($tipo == 2) //NIÑA
        {
            for ($i = 1; $i < 7; $i++)
            {
                $calzadoReabastecido = DB::table('calzado_has_numero')
                ->where('id_calzado_chn', $id)
                ->where('id_numero_chn', $i)
                ->update(
                    [
                        'existencias' => $request[$i],
                    ],
                );
            }
        }
        else if($tipo == 3) //CABALLERO
        {
            for ($i = 7; $i < 15; $i++)
            {
                $calzadoReabastecido = DB::table('calzado_has_numero')
                ->where('id_calzado_chn', $id)
                ->where('id_numero_chn', $i)
                ->update(
                    [
                        'existencias' => $request[$i],
                    ],
                );
            }
        }
        else if($tipo == 4) //DAMA
        {
            for ($i = 7; $i < 15; $i++)
            {
                $calzadoReabastecido = DB::table('calzado_has_numero')
                ->where('id_calzado_chn', $id)
                ->where('id_numero_chn', $i)
                ->update(
                    [
                        'existencias' => $request[$i],
                    ],
                );
            }
        }


       
        return redirect()->route('calzadoList')->with('success', 'Calzado agregado y reabastecido correctamente');
    }

}
