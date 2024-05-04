<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use function Laravel\Prompts\password;

class UserController extends Controller
{
    use HasApiTokens;
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
            'email' => 'required|email|unique:usuario',
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
            'email' => $request->email,
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

    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:usuario,email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
            'status' => 422
        ], 422);
    }

    $user = Usuario::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Credenciales incorrectas'
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Usuario logeado',
        'token' => $token,
        'status' => 200
    ], 200);
}
}