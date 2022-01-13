<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Telefono;
use Illuminate\Support\Facades\Validator;

class TelefonoController extends Controller
{
    //
    public function create(array $input)
    {
        Validator::make($input, [
            'num_telefono' => ['required', 'string', 'max:255'],
        ])->validate();

        return Telefono::create([
            'num_telefono' => $input['num_telefono'],       
        ]);
    }

    public function store(Request $request)
    {
        Telefono::create($request->all());
        return redirect()->back();
    }
}
