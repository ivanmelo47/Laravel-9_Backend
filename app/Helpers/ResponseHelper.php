<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function jsonResponse($status, $validation, $code, $message, $notifications, $data = null)
    {
        return response()->json([
            'status' => $status,
            'validation' => $validation,
            'code' => $code,
            'message' => $message,
            'notifications' => $notifications,
            'data' => $data,
        ], $code);
    }
}
