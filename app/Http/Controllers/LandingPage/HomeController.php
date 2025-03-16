<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\ResponseHelper; // Importar la clase Helper
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function personalDataGet(Request $request)
    {
        $uuid = '1936e2fc-48bf-48a1-ad37-53b2d441acfc';

        try {
            $user = DB::table('users')
                ->join('personal_data', 'users.user_id', '=', 'personal_data.user_id')
                ->join('sobre_mi', 'users.user_id', '=', 'sobre_mi.user_id')
                ->select(
                    'personal_data.nombres',
                    'personal_data.apellido_paterno',
                    'personal_data.apellido_materno',
                    'personal_data.telefono',
                    'personal_data.url_img',
                    'personal_data.cumpleanios',
                    'personal_data.linkedin',
                    'personal_data.especialidad',
                    'personal_data.cargo',
                    'personal_data.direccion',
                    'sobre_mi.parrafo',
                )
                ->where('users.uuid', $uuid)
                ->first();

            return ResponseHelper::jsonResponse(true, true, 200, 'Datos del usuario', ['Datos del usuario'], $user);
        } catch (\Exception $e) {
            // Deshacer la transacción en caso de error
            DB::rollBack();

            // Retornar error
            return response()->json([
                'status' => false,
                'validation' => null,
                'code' => 500,
                'message' => 'Error con el servidor al listar los datos usuario.',
                'notifications' => ['Error con el servidor al listar los datos usuario.'],
                'data' => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function redesSocialesGet(Request $request)
    {
        $uuid = '1936e2fc-48bf-48a1-ad37-53b2d441acfc';

        try {
            $data = DB::table('users')
                ->join('redes_sociales', 'users.user_id', '=', 'redes_sociales.user_id')
                ->select(
                    'redes_sociales.nombre',
                    'redes_sociales.url_red',
                    'redes_sociales.logo',
                )
                ->whereNull('redes_sociales.deleted_at')
                ->where('users.uuid', $uuid)
                ->get();

            return ResponseHelper::jsonResponse(true, true, 200, 'Redes sociales del Usuario', ['Redes sociales del Usuario'], $data);
        } catch (\Exception $e) {
            // Deshacer la transacción en caso de error
            DB::rollBack();

            // Retornar error
            return response()->json([
                'status' => false,
                'validation' => null,
                'code' => 500,
                'message' => 'Error con el servidor al listar los datos usuario.',
                'notifications' => ['Error con el servidor al listar los datos usuario.'],
                'data' => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function skillsGet(Request $request)
    {
        $uuid = '1936e2fc-48bf-48a1-ad37-53b2d441acfc';

        try {
            $data = DB::table('users')
                ->join('skills', 'users.user_id', '=', 'skills.user_id')
                ->select(
                    'skills.nombre',
                    'skills.logo',
                    'skills.tipo',
                    'skills.tipo_nombre as titulo',
                )
                ->whereNull('skills.deleted_at')
                ->where('users.uuid', $uuid)
                ->get();

            return ResponseHelper::jsonResponse(true, true, 200, 'Skills del Usuario', ['Skills del Usuario'], $data);
        } catch (\Exception $e) {
            // Deshacer la transacción en caso de error
            DB::rollBack();

            // Retornar error
            return response()->json([
                'status' => false,
                'validation' => null,
                'code' => 500,
                'message' => 'Error con el servidor al listar los datos usuario.',
                'notifications' => ['Error con el servidor al listar los datos usuario.'],
                'data' => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }
    public function interesesGet(Request $request)
    {
        $uuid = '1936e2fc-48bf-48a1-ad37-53b2d441acfc';

        try {
            $data = DB::table('users')
                ->join('intereses', 'users.user_id', '=', 'intereses.user_id')
                ->select(
                    'intereses.nombre',
                    'intereses.logo',
                )
                ->whereNull('intereses.deleted_at')
                ->where('users.uuid', $uuid)
                ->get();

            return ResponseHelper::jsonResponse(true, true, 200, 'Intereses del Usuario', ['Intereses del Usuario'], $data);
        } catch (\Exception $e) {
            // Deshacer la transacción en caso de error
            DB::rollBack();

            // Retornar error
            return response()->json([
                'status' => false,
                'validation' => null,
                'code' => 500,
                'message' => 'Error con el servidor al listar los datos usuario.',
                'notifications' => ['Error con el servidor al listar los datos usuario.'],
                'data' => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function curriculumGet(Request $request){
        $uuid = '1936e2fc-48bf-48a1-ad37-53b2d441acfc';

        try {
            $data = DB::table('users')
                ->join('curriculum', 'users.user_id', '=', 'curriculum.user_id')
                ->select(
                    'curriculum.nombre',
                    'curriculum.empresa',
                    DB::raw('YEAR(curriculum.inicio) as inicio'),
                    DB::raw('YEAR(curriculum.fin) as fin'),
                    'curriculum.actualmente',
                    'curriculum.tipo',
                    'curriculum.descripcion',
                )
                ->whereNull('curriculum.deleted_at')
                ->where('users.uuid', $uuid)
                ->get();

            return ResponseHelper::jsonResponse(true, true, 200, 'Curriculum del Usuario', ['Curriculum del Usuario'], $data);
        } catch (\Exception $e) {
            // Deshacer la transacción en caso de error
            DB::rollBack();

            // Retornar error
            return response()->json([
                'status' => false,
                'validation' => null,
                'code' => 500,
                'message' => 'Error con el servidor al listar los datos usuario.',
                'notifications' => ['Error con el servidor al listar los datos usuario.'],
                'data' => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function recibirMensaje(Request $request){
        $uuid = '1936e2fc-48bf-48a1-ad37-53b2d441acfc';

        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string',
                'email' => 'required|string|email',
                'mensaje' => 'required|string',
            ]);

            // Si la validación falla, retornar errores
            if ($validator->fails()) {
                return ResponseHelper::jsonResponse(false, false, 422, 'Error al validar los datos.', $validator->errors()->all());
            }

            $usuario = DB::table('users')
                ->select('users.user_id')
                ->where('users.uuid', $uuid)
                ->first();

            $mensaje = DB::table('mensajes_entrantes')
                ->insertGetId([
                    'user_id'       => $usuario->user_id,
                    'nombre'        => $request->nombre,
                    'telefono'      => $request->telefono,
                    'email'         => $request->email,
                    'tema'          => $request->tema,
                    'mensaje'       => $request->mensaje,
                ]);

            // Dividir el nombre completo en un array
            $nombres = explode(' ', $request->nombre);

            return ResponseHelper::jsonResponse(true, true, 200, 'Mensaje enviado', ["Gracias por contactarme $nombres[0] 😄🤩"], null);
        } catch (\Exception $e) {
            // Deshacer la transacción en caso de error
            DB::rollBack();

            // Retornar error
            return response()->json([
                'status' => false,
                'validation' => null,
                'code' => 500,
                'message' => 'Error con el servidor al enviar el mensaje.',
                'notifications' => ['Error con el servidor al enviar el mensaje.'],
                'data' => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }
}
