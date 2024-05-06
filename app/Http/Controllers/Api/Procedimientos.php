<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehiculo;
use App\Models\Garaje;
use App\Models\Seccion;
class Procedimientos extends Controller
{

    public function showUser(Request $request){
        if (!$request->bearerToken()) {
            return response()->json([
                'message' => 'No se ha proporcionado un token de autenticación',
                'status' => 401
            ], 401);
        }

        $user = $request -> user();
        if (!$user) {
            return response()->json([
                'message' => 'Token inválido o usuario no autenticado',
                'status' => 401
            ], 401);
        }


        return response()-> json([
            'message' => 'usuario encontrado',
            'status' => 200,
            'usuario' => $user
        ], 200);
    }



    public function show(Request $request)
    {
        if (!$request->bearerToken()) {
            return response()->json([
                'message' => 'No se ha proporcionado un token de autenticación',
                'status' => 401
            ], 401);
        }

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Token inválido o usuario no autenticado',
                'status' => 401
            ], 401);
        }

        $vehiculos = Vehiculo::where('id_usuario', $user->id_usuario)->get();

        if ($vehiculos->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron vehículos para el usuario',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'message' => 'Vehículos encontrados exitosamente',
            'vehiculos' => $vehiculos,
            'status' => 200
        ], 200);
    }

    public function storeVehiculo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'marca' => 'required|max:255',
            'matricula' => 'required|unique:vehiculo,matricula',
            'color' => 'required|max:255',
            'altura' => 'required|max:255',
            'ancho' => 'required|max:255',
            'largo' => 'required|max:255',
            'modelo' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $user = $request->user(); 
        if ($user == Null) {
            return response()->json([
                'message' => 'No se ha encontrado un usuario autenticado. Asegúrate de que el token sea válido.',
                
                'status' => 401
            ], 401);
        }
        
        $vehiculo = Vehiculo::create([
            'marca' => $request->marca,
            'matricula' => $request->matricula,
            'color' => $request->color,
            'altura' => $request->altura,
            'ancho' => $request->ancho,
            'largo' => $request->largo,
            'modelo' => $request->modelo,
            'id_usuario' => $user->id_usuario 
        ]);

        if (!$vehiculo) {
            return response()->json([
                'message' => 'Error al crear vehículo',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'message' => 'Vehículo creado exitosamente',
            'vehiculo' => $vehiculo,
            'status' => 200
        ], 200);
    }

    

    public function storeGaraje(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado',
                'status' => 401
            ], 401);
        }
    
        $validator = Validator::make($request->all(), [
            'imagen_garaje' => 'nullable|url',
            'ancho' => 'required|numeric',
            'largo' => 'required|numeric',
            'direccion' => 'required|string',
            'notas' => 'nullable|string',
            'referencias' => 'nullable|string',
            'latitud' => 'nullable|string',
            'longitud' => 'nullable|string',
            'secciones' => 'required|array',
            'secciones.*.imagen_seccion' => 'nullable|url',
            'secciones.*.ancho' => 'required|numeric',
            'secciones.*.largo' => 'required|numeric',
            'secciones.*.hora_inicio' => 'required|date_format:H:i',
            'secciones.*.hora_final' => 'required|date_format:H:i',
            'secciones.*.estado' => 'required|string',
            'secciones.*.altura' => 'required|numeric'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $validatedData = $validator->validated();
    
        try {
            $garaje = new Garaje($validatedData);
            $garaje->id_usuario = $user->id_usuario;
            $garaje->save();
    
            foreach ($validatedData['secciones'] as $secData) {
                $secData['id_garaje'] = $garaje->id_garaje;
                $seccion = new Seccion($secData);
                $seccion->save();
            }
    
            $garaje->load('secciones');
    
            return response()->json([
                'message' => 'Garaje y secciones creadas exitosamente',
                'garaje' => $garaje,
                'secciones' => $garaje->secciones
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar el garaje y las secciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function showGaraje(Request $request)
    {

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado',
                'status' => 401
            ], 401);
        }

        $garajes = Garaje::with('secciones')
                        ->where('id_usuario', $user->id_usuario)
                        ->get();

        if ($garajes->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron garajes para el usuario',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'message' => 'Garajes encontrados exitosamente',
            'garajes' => $garajes,
            'status' => 200
        ], 200);
    }


}
