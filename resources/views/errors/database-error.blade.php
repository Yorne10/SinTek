{{--
Company: CETAM
Project: ST
File: database-error.blade.php
Created on: 14/12/2025
Created by: Alfonso Angel Garcia Hernandez
--}}

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Conexión - {{ config('app.name', 'SinTek') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .error-container {
            max-width: 500px;
            width: 100%;
            padding: 20px;
        }

        .error-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem 2rem;
            text-align: center;
        }

        .error-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: pulse 2s infinite;
        }

        .error-icon i {
            font-size: 3rem;
            color: white;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .error-title {
            color: #2d3748;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .error-message {
            color: #718096;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-retry {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-retry:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .help-text {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
            color: #a0aec0;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-card">
            <div class="error-icon">
                <i class="fas fa-database"></i>
            </div>
            <h1 class="error-title">Problema de Conexión</h1>
            <p class="error-message">
                {{ $message ?? 'No se pudo establecer conexión con la base de datos. Por favor, intenta nuevamente.' }}
            </p>
            <a href="{{ $redirectUrl ?? route(config('proj.route_name_prefix', 'proj') . '.auth.login') }}"
                class="btn-retry">
                <i class="fas fa-redo me-2"></i>
                Intentar de nuevo
            </a>
            <div class="help-text">
                <p class="mb-1">
                    <i class="fas fa-info-circle me-1"></i>
                    Si el problema persiste, contacta al administrador del sistema.
                </p>
            </div>
        </div>
    </div>
</body>

</html>