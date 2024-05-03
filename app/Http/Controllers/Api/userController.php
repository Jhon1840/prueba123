<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index()
    {   
        $usuarios = Usuario::all();
        $data = [
            'usuarios' => $usuarios->isEmpty() ? 'No se encontraron usuarios' : $usuarios,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required',
            'ci' => 'required',
            'correo' => 'required|email|unique:usuario',
            'telefono' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'ci' => $request->ci,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password) 
        ]);

        if (!$usuario) {
            $data = [
                'message' => 'Error al crear usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'usuario' => $usuario,
            'status' => 201,
        ];
        return response()->json($data, 201);
    }

    public function show($id){
        $usuarios = Usuario::find($id);
        if(!$usuarios){
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        $data =[
            'usuario' =>$usuarios,
            'status' =>200
        ];
        return response()->json($data,200);
    }

    public function destroy($id){
        $usuario = Usuario::find($id);
        if(!$usuario){
            $data = [
                'message' => 'Usuario no encontado',
                'status' =>404
            ];
            return response() ->json($data,404);
        }
        $usuario -> delete();
        $data = [
            'message' => 'usuario eliminado',
            'status'=>200
        ];
        return response()->json($data,200);
    }
}
