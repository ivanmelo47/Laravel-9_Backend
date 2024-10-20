<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\ResponseHelper; // Importar la clase Helper

class AdminController extends Controller
{
    public function usuarios(Request $request)
    {
        // Obtener la cabecera 'Authorization'
        $header = $request->header('Authorization');
        $role = $request->header('Role');

        $usuarios = DB::table('users')->get();

        $user_data = DB::table('personal_data as pd')
            ->join('users', 'pd.user_id', '=', 'users.user_id') // Join entre pd y users
            ->select(
                'pd.name',
                'users.username',
                'users.email',
                'users.uuid as user_uuid',
                'users.role',
                'users.url_img'
            )
            ->get();

        return response()->json([
            'status' => true,
            'validation' => true,
            'code' => 200,
            'message' => 'Usuarios',
            'notifications' => ['Usuarios'],
            'data' => $usuarios
        ], 200);

        return ResponseHelper::jsonResponse(true, true, 200, 'Usuarios', ['Usuarios'], $usuarios);
    }
}
