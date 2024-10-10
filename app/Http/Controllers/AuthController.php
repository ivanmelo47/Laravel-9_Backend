<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Asegúrate de importar la clase Str
use App\Helpers\ResponseHelper; // Importar la clase Helper
use App\Helpers\EmailHelper; // Importar la clase Helper

class AuthController extends Controller
{
    // Método para iniciar sesión
    public function login(Request $request)
    {
        DB::beginTransaction(); // Iniciar una transacción

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            // Si la validación falla, retornar errores
            if ($validator->fails()) {
                return ResponseHelper::jsonResponse(false, false, 422, 'Error al validar los datos.', $validator->errors()->all());
            }

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return ResponseHelper::jsonResponse(false, true, 401, 'Credenciales incorrectas.', ['Credenciales incorrectas.']);
            } else if ($user->status == 0) {
                return ResponseHelper::jsonResponse(false, true, 403, 'El usuario se encuentra inactivo. Por favor contacte al administrador.', ['El usuario se encuentra inactivo. Por favor contacte al administrador.']);
            }

            $token = $user->createToken('authToken', ['view', 'create'], Carbon::now()->addHours(12))->plainTextToken;

            $user_data = DB::table('personal_data as pd')
                ->join('users', 'pd.user_id', '=', 'users.user_id') // Join entre pd y users
                ->select('pd.name', 'users.username', 'users.email', 'users.uuid as user_uuid', 'users.role', 'users.url_img') // Campos que quieres seleccionar
                ->where('users.uuid', $user->uuid)
                ->first();

            // Asignar el token y tipo de token
            $user_data = (object) array_merge((array) $user_data, [
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

            // Confirmar la transacción
            DB::commit();

            return ResponseHelper::jsonResponse(true, true, 200, 'Inicio de sesion exitoso.', ['Inicio de sesion exitoso.'], $user_data);
        } catch (\Exception $e) {
            // Deshacer la transacción en caso de error
            DB::rollBack();

            // Retornar error
            return response()->json([
                'status' => false,
                'validation' => null,
                'code' => 500,
                'message' => 'Error con el servidor al iniciar sesión.',
                'notifications' => ['Error con el servidor al iniciar sesión.'],
                'data' => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }

    // Método para cerrar SESION
    public function logout(Request $request)
    {
        // Verifica si el usuario está autenticado
        if (!$request->user()) {
            return ResponseHelper::jsonResponse(false, false, 401, 'No estás autenticado.', ['No estás autenticado.']);
        }

        try {
            // Revocar el token del usuario autenticado
            $request->user()->currentAccessToken()->delete();

            return ResponseHelper::jsonResponse(true, true, 200, 'Haz cerrado sesión.', ['Haz cerrado sesión.']);
        } catch (\Exception $e) {
            // Retornar error
            return response()->json([
                'status' => false,
                'validation' => null,
                'code' => 500,
                'message' => 'Error con el servidor al cerrar sesión.',
                'notifications' => ['Error con el servidor al cerrar sesión.'],
                'data' => [
                    'error' => $e->getMessage(),
                ],
            ], 500);
        }
    }

    // Método para registrar un nuevo usuario
    public function register(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users',
            'name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'second_last_name' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Si la validación falla, retornar errores
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'validation' => false,
                'code' => 422,
                'message' => 'Error al validar los datos.',
                'notifications' => $validator->errors()->all(),
                'data' => null,
            ], 422);
        }

        // Iniciar una transacción
        DB::beginTransaction();

        try {
            $user_uuid = Str::uuid()->toString();
            $personal_token = Str::random(50);

            // Crear el usuario en la tabla 'users' usando Query Builder
            $userId = DB::table('users')->insertGetId([
                'personal_token' => $personal_token,
                'uuid' => $user_uuid,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Asegúrate de hashear la contraseña
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $personal_uuid = Str::uuid()->toString();

            // Guardar los datos personales en la tabla 'personal_data'
            DB::table('personal_data')->insert([
                'uuid' => $personal_uuid,
                'user_id' => $userId,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'second_last_name' => $request->second_last_name,
                'phone' => $request->phone,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Recuperar el usuario creado para generar el token
            $user = User::findOrFail($userId); // Asegúrate de que el modelo User esté importado

            // Generar el token de acceso
            $token = $user->createToken('registerToken')->plainTextToken;

            // Enviar Email
            EmailHelper::enviarVerificacion($user->uuid);

            // Confirmar la transacción
            DB::commit();

            // Retornar respuesta exitosa
            return response()->json([
                'status' => true,
                'validation' => true,
                'code' => 201,
                'message' => 'Usuario registrado exitosamente.',
                'notifications' => ['Usuario registrado exitosamente.'],
                'data' => [
                    /* 'id' => $userId,
                    'uuid' => $user_uuid,
                    'username' => $request->username,
                    'email' => $request->email,
                    'access_token' => $token,
                    'token_type' => 'Bearer' */],
            ], 201);
        } catch (\Exception $e) {
            // Deshacer la transacción en caso de error
            DB::rollBack();

            // Retornar error
            return response()->json([
                'status' => false,
                'validation' => null,
                'code' => 500,
                'message' => 'Error con el servidor al registrar el usuario.',
                'notifications' => ['Error con el servidor al registrar el usuario.'],
                'data' => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }
}
