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

        $usuarios = DB::table('users')->get();

        return response()->json([
            'status' => true,
            'validation' => true,
            'code' => 200,
            'message' => 'Usuarios',
            'notifications' => ['Usuarios'],
            'data' => $usuarios,
            'header' => $header,
        ], 200);

        return ResponseHelper::jsonResponse(true, true, 200, 'Usuarios', ['Usuarios'], $usuarios);
    }
}
