<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Part\DataPart;

class EmailService
{
    public static function sendMail($to, $subject, $view, $data = [])
    {
        // Enviar el correo usando la vista Blade y los datos proporcionados
        try {
            // Enviar el correo usando la vista Blade y los datos proporcionados
            Mail::send($view, $data, function ($message) use ($to, $subject) {
                $message->to($to)
                    ->from(config('mail.from.address'), config('mail.from.name')) // Especificar remitente desde config
                    ->subject($subject);
            });

            return response()->json(['message' => 'Correo enviado correctamente'], 200);
        } catch (\Exception $e) {
            // Manejar la excepción y devolver un mensaje de error
            return response()->json(['message' => 'Error al enviar correo: ' . $e->getMessage()], 500);
        }
    }

    /* public static function sendMail($to, $subject, $view, $data = [])
    {
        $nombre = 'Nombre del Usuario'; // Aquí deberías obtener el nombre del usuario real
        $token = 'el_token_de_verificacion'; // Aquí deberías obtener el token real
        $textContent = 'Contenido en texto plano';

        // Contenido HTML
        $data = ['nombre' => $nombre, 'token' => $token];

        // Contenido en texto plano
        $textContent = "Hola, $nombre!\n\n" .
            "Gracias por registrarte en nuestra aplicación.\n" .
            "Haz clic en el siguiente enlace para verificar tu cuenta:\n" .
            config('app.url') . "/verify-email?token=$token\n\n" .
            "Si no solicitaste esta verificación, ignora este mensaje.";

        // Enviar el correo usando la vista Blade y los datos proporcionados
        try {
            Mail::send($view, $data, function ($message) use ($to, $subject, $textContent) {
                $message->to($to)
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject($subject);

                // Crear un DataPart para el contenido de texto plano
                $plainPart = new DataPart($textContent, 'text/plain');

                // Agregar el contenido de texto plano al mensaje
                $message->addPart($plainPart);
            });

            return response()->json(['message' => 'Correo enviado correctamente'], 200);
        } catch (\Exception $e) {
            // Manejar la excepción y devolver un mensaje de error
            return response()->json(['message' => 'Error al enviar correo: ' . $e->getMessage()], 500);
        }
    } */
}
