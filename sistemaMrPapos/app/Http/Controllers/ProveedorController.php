<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Telefono;
use App\Models\Direccion;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{

    public function viewProveedores(){
        $proveedores = Proveedor::all(); 
        $telefonos = Telefono::all();
        $direcciones = Direccion::all();
        return view('auth.proveedores.proveedores', compact('proveedores'), compact('telefonos'), compact('direcciones'));
    }

    public function viewFormuProveedores(){
        
        return view('auth.proveedores.formularioProveedor');
    }

    //--------------CREAR PROVEEDOR----------------
    public function createProveedor(Request $request)
    {
        
        Direccion::create($request->all());
        $datad = Direccion::latest('id_direccion')->first();
        print_r($datad);
        
        Telefono::create($request->all());
        $data = Telefono::latest('id_telefono')->first();
        print_r($data);
        
        Proveedor::create([
            'razon_social' => $request['razon_social'],
            'email' => $request['email'],   
            'id_telefono_p' => (int)$datad['id_direccion'],
            'id_direccion_p' => (int)$data['id_telefono'],
        ]);

        return redirect()->back();
    }


    public function viewProfile()
    {
        return view('auth.users.perfil');
    }


 //-------------METODOS JOIN---------------------------------------   

    public function getProveedores()
    {
        $proveedores = DB::table('proveedor')
            ->join('telefono', 'proveedor.id_telefono_p', '=', 'telefono.id_telefono')
            ->join('direccion', 'proveedor.id_direccion_p', '=', 'direccion.id_direccion')
            ->select('proveedor.*', 'telefono.num_telefono', 'direccion.*')
            ->get();
        return view('auth.proveedores.proveedores', compact('proveedores'));
    }
}
