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


    /**
 * @OA\Post(
 *     path="/api/usuarios",
 *     tags={"Usuarios"},
 *     summary="Crear un nuevo usuario",
 *     description="Crea un nuevo usuario con los datos proporcionados.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nombre", "apellido", "ci", "correo", "telefono", "password"},
 *             @OA\Property(property="nombre", type="string"),
 *             @OA\Property(property="apellido", type="string"),
 *             @OA\Property(property="ci", type="string"),
 *             @OA\Property(property="correo", type="string", format="email"),
 *             @OA\Property(property="telefono", type="string"),
 *             @OA\Property(property="password", type="string", format="password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuario creado exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="usuario", ref="#/components/schemas/Usuario"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validación de datos"
 *     )
 * )
 */
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
            'status' => 200,
        ];
        return response()->json($data, 200);
    }

    /**
 * @OA\Get(
 *     path="/api/usuarios/{id}",
 *     tags={"Usuarios"},
 *     summary="Mostrar usuario",
 *     description="Muestra los detalles de un usuario específico por ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID del usuario",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(ref="#/components/schemas/Usuario")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuario no encontrado"
 *     )
 * )
 */
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


    /**
 * @OA\Schema(
 *     schema="Usuario",
 *     type="object",
 *     required={"nombre", "apellido", "ci", "correo", "telefono", "password"},
 *     @OA\Property(property="nombre", type="string"),
 *     @OA\Property(property="apellido", type="string"),
 *     @OA\Property(property="ci", type="string"),
 *     @OA\Property(property="correo", type="string", format="email"),
 *     @OA\Property(property="telefono", type="string"),
 *     @OA\Property(property="password", type="string", format="password")
 * )
 */


    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'correo' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Error en la validación de datos',
            'errors' => $validator->errors()
        ], 422);
    }

    $user = Usuario::where('correo', $request->correo)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Credenciales incorrectas'
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Usuario logeado',
        'token' => $token
    ], 200);
    }

    public function logout(Request $request)
    {
    
        $request->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json(['message' => 'Has cerrado sesión correctamente y todos los tokens han sido revocados']);
    }

}



/**
 * @OA\OpenApi(
 *   @OA\Info(
 *     title="API de Usuarios",
 *     version="1.0.0",
 *     description="API para la gestión de usuarios en Laravel",
 *     @OA\Contact(
 *       email="soporte@tudominio.com",
 *       name="Soporte Técnico"
 *     )
 *   ),
 *   @OA\Server(
 *     description="Servidor principal",
 *     url="http://localhost:8000/api"
 *   )
 * )
 */
