<?php

namespace App\Helpers;

use App\Services\EmailService;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmailHelper
{
    public static function enviarVerificacion($uuid)
    {
        $user = DB::table('users')
            ->select('username', 'email', 'personal_token') // Campos que quieres seleccionar
            ->where('uuid', $uuid)
            ->first();

        // Datos para la vista del correo
        $data = [
            'nombre' => $user->username,
            'token' => $user->personal_token,
        ];

        // Enviar el correo usando el servicio de EmailService
        EmailService::sendMail(
            $user->email,
            'Verificación de correo electrónico',
            'emails.verificacion', // La vista Blade
            $data
        );

        return response()->json(['message' => 'Correo de verificación enviado.']);
    }
}
