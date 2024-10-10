<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            line-height: 1.5;
            margin-bottom: 20px;
        }
        a {
            display: inline-block;
            padding: 12px 20px;
            font-size: 18px;
            color: #fff;
            background-color: #4CAF50;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        a:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            h1 {
                font-size: 22px;
            }
            a {
                font-size: 16px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hola, {{ $nombre }}!</h1>
        <p>Gracias por registrarte en nuestra aplicación. Haz clic en el botón a continuación para verificar tu cuenta:</p>
        <a href="{{ config('app.url').'/verify-email?token=' . $token }}">Verificar Cuenta</a>
        <p>Si no solicitaste esta verificación, ignora este mensaje.</p>
    </div>
</body>
</html>
