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


class ConfirmacionController extends Controller
{
    //--------------PANEL DE CONFIRMACION CALZADO---------------------------------------
    //vista
    public function viewConfirmacionCalzado()
    {

        return view('');
    }
    
    //-----CONFIRMAR
    public function confirmarCalzado($id_calzado)
    {  
        $datosCalzado = DB::table('calzado')
            ->select('id_calzado', 'marca', 'modelo')
            ->where('id_calzado', '=', $id_calzado)
            ->first();

        return view('auth.confirmacion.confirmarcalzado', compact('datosCalzado'));
    }

    //------ELIMINAR
    public function deleteCalzado($id)
    {
        DB::table('calzado_has_numero')->where('id_calzado_chn', '=', $id)->delete();
        DB::table('calzado_has_proveedor')->where('id_calzado_chp', '=', $id)->delete();
        DB::table('calzado')->where('id_calzado', '=', $id)->delete();
        return redirect()->route('calzadoList')->with('success', 'Calzado eliminado correctamente');
    }
    
    //-----CANCELAR
    public function cancelarECalzado()
    {   
        return redirect()->route('calzadoList');
    }
   
    //------------------------PANEL DE REABASTECER O REGRESAR
    //-----CONFIRMAR
    public function reabastecerOCancelar()
    {  
        return view('auth.confirmacion.reabastecercalzado');
    }
    //-----CANCELAR
    public function cancelarReabastecerCalzado()
    {   
        return redirect()->route('calzadoList')->with('success', 'Calzado creado correctamente');

    }
}
