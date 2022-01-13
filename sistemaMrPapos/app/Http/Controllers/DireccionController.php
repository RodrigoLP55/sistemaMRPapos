<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Direccion;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class DireccionController extends Controller
{
    //
    public function view(){
        return view('auth.users.formulario');
    }

    public function create(array $input)
    {
        Validator::make($input, [
            'estado' => ['required', 'string'],
            'municipio' => ['required', 'string'],
            'colonia' => ['required', 'string'],
            'calle' => ['required', 'string'],
            'numero' => ['required', 'string'],
            'codigo_postal' => ['required', 'string'],
        ])->validate();

        return Direccion::create([
            'estado' => $input['estado'],
            'municipio' => $input['municipio'],       
            'colonia' => $input['emcoloniaail'],   
            'calle' => $input['calle'],   
            'numero' => $input['numero'],   
            'codigo_postal' => $input['codigo_postal'],         
        ]);
        
    }

    public function store(Request $request)
    {
        Direccion::create($request->all());
        return redirect()->back();
    }

    public function lastIdDireccion(){
        $productId = Direccion::getPdo()->lastInsertId();
        print_r($productId);
        return $productId;
    }


}
