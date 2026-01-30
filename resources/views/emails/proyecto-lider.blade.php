<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { background-color: #4f46e5; color: #fff; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .token-box { background-color: #eef2ff; border: 2px dashed #4f46e5; padding: 15px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 2px; color: #4f46e5; margin: 20px 0; border-radius: 5px; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px; }
        .btn { display: inline-block; background-color: #4f46e5; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Eres Líder de Equipo!</h1> <!-- Cambiar ese encabezado -->
        </div>
        
        <div class="content">
            <p>Hola <strong>{{ $usuario->nombre }}</strong>,</p>
            
            <p>Tu profesor te ha registrado como el <strong>Líder del Proyecto</strong> para la materia de <em>{{ $proyecto->materia->nombre ?? 'la materia' }}</em> en la próxima Expo LMAD.</p>
            
            <p><strong>Proyecto:</strong> {{ $proyecto->titulo ?? 'Sin título definido (Borrador)' }}</p>

            <p>Para poder registrar la información de tu equipo, subir el póster y completar los datos, necesitarás el siguiente código de seguridad único:</p>

            <div class="token-box">
                {{ $codigoAcceso }}
            </div>

            <p>Por favor, ingresa a la plataforma con tu cuenta de estudiante y ve a la sección "Mis Proyectos" para completar el registro.</p>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('login') }}" class="btn">Ir a Expo LMAD</a>
            </div>
        </div>

        <div class="footer">
            <p>Este es un mensaje automático del sistema Expo LMAD.<br>
            Si crees que esto es un error, contacta a tu profesor.</p>
        </div>
    </div>
</body>
</html>