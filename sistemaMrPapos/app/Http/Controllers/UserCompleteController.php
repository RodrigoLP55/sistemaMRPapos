<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Direccion;
use App\Models\Telefono;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\DB;

class UserCompleteController extends Controller
{
    //
    public function view(){
        
        return view('auth.users.formulario');
    }

    public function viewUsers(){
        $users = User::all(); 
        $telefonos = Telefono::all();
        $direcciones = Direccion::all();
        return view('auth.users.usuarios', compact('users'), compact('telefonos'), compact('direcciones'));
    }

    public function viewProfile()
    {
        return view('auth.users.perfil');
    }


    public function store(Request $request)
    {
        Direccion::create($request->all());
        return redirect()->back();
    }


 //-------------METODOS JOIN---------------------------------------   

    public function userWhithTel()
    {
        $users = DB::table('users')
            ->join('telefono', 'users.telefono_u', '=', 'telefono.id_telefono')
            ->join('direccion', 'users.direccion_u', '=', 'direccion.id_direccion')
            ->select('users.*', 'telefono.num_telefono', 'direccion.*')
            ->get();
        return view('auth.users.usuarios', compact('users'));
    }
    

//--------------CREAR USUARIO----------------
    public function createUser(Request $request)
    {
        
        Direccion::create($request->all());
        $datad = Direccion::latest('id_direccion')->first();
        print_r($datad);
        
        Telefono::create($request->all());
        $data = Telefono::latest('id_telefono')->first();
        print_r($data);
        
        User::create([
            'name' => $request['name'],
            'direccion_u' => (int)$datad['id_direccion'],
            'telefono_u' => (int)$data['id_telefono'],
            'email' => $request['email'],            
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->back();
    }


}
