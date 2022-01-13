<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Color;

class ColorController extends Controller
{
    public function createColor(Request $request)
    {
        Color::create([
            'nombre_color' => $request['nombreColor'],
        ]);

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

    public function viewFormColor()
    {

        return view('auth.calzado.formcolor');
    }
}
