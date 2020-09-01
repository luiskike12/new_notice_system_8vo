<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;

class RolController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax())return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            //se crea un array de todo lo que devuelva el metodo
            $roles = Rol::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $roles = Rol::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(3);
        }
        
        return[
            'pagination' => [
                'total'         => $roles->total(),
                'current_page'  => $roles->currentPage(),
                'per_page'      => $roles->perPage(),
                'last_page'     => $roles->lastPage(),
                'from'          => $roles->firstItem(),
                'to'            => $roles->lastItem(),
            ],
            'roles' => $roles
        ];

    }

    public function selectRol(){
        // $roles = Rol::where('condicion', '=', '1')
        // ->select('id', 'nombre')
        // ->orderBy('nombre', 'asc')->get();

        $roles = Rol::where('condicion', '=', '1')
        ->select('id', 'nombre')
        ->get();

        return ['roles' => $roles];
    }

}
