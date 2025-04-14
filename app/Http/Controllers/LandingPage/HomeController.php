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
        $uuid = '208a4b11-5eb5-484e-818a-008cc896e117';

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

    /* CRUD Para redes sociales */
    public function redesSocialesGet(Request $request)
    {
        $uuid = $request['user_uuid'];

        try {
            $data = DB::table('users')
                ->join('redes_sociales', 'users.user_id', '=', 'redes_sociales.user_id')
                ->select(
                    'redes_sociales.redes_sociales_id as id',
                    'redes_sociales.nombre',
                    'redes_sociales.url_red',
                    'redes_sociales.logo',
                    'redes_sociales.updated_at'
                )
                ->whereNull('redes_sociales.deleted_at')
                ->where('users.uuid', $uuid)
                ->get();

            return ResponseHelper::jsonResponse(true, true, 200, 'Redes sociales del Usuario', ['Datos cargados correctamente!'], $data);
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
    public function redesSocialesSave(Request $request)
    {
        $uuid = $request->input('user_uuid');

        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'user_uuid' => 'required|uuid',
            'nombre' => 'required|string|max:255',
            'url_red' => 'required|url|max:255',
            'logo' => 'required|string|max:255', // Asumo que el logo es una URL o nombre de archivo
        ]);

        if ($validator->fails()) {
            return ResponseHelper::jsonResponse(
                false,
                false,
                422,
                'Error de validación',
                $validator->errors()->all(),
                null
            );
        }

        DB::beginTransaction();

        try {
            // Obtener el user_id basado en el uuid
            $user = DB::table('users')
                ->where('uuid', $uuid)
                ->first();

            if (!$user) {
                return ResponseHelper::jsonResponse(
                    false,
                    false,
                    404,
                    'Usuario no encontrado',
                    ['El usuario especificado no existe'],
                    null
                );
            }

            // Insertar los datos en la tabla redes_sociales
            $redSocialId = DB::table('redes_sociales')->insertGetId([
                'nombre' => $request->input('nombre'),
                'url_red' => $request->input('url_red'),
                'logo' => $request->input('logo'),
                'user_id' => $user->user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Obtener el registro recién creado
            $redSocial = DB::table('redes_sociales')
                ->where('redes_sociales_id', $redSocialId)
                ->first();

            DB::commit();

            return ResponseHelper::jsonResponse(
                true,
                true,
                201,
                'Red social creada exitosamente',
                ['La red social se ha guardado correctamente'],
                $redSocial
            );

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'validation' => null,
                'code' => 500,
                'message' => 'Error al guardar la red social',
                'notifications' => ['Error al guardar la red social'],
                'data' => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }

    public function skillsGet(Request $request)
    {
        $uuid = '208a4b11-5eb5-484e-818a-008cc896e117';

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
        $uuid = '208a4b11-5eb5-484e-818a-008cc896e117';

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

    public function curriculumGet(Request $request)
    {
        $uuid = '208a4b11-5eb5-484e-818a-008cc896e117';

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

    public function recibirMensaje(Request $request)
    {
        $uuid = '208a4b11-5eb5-484e-818a-008cc896e117';

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
                    'user_id' => $usuario->user_id,
                    'nombre' => $request->nombre,
                    'telefono' => $request->telefono,
                    'email' => $request->email,
                    'tema' => $request->tema,
                    'mensaje' => $request->mensaje,
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
