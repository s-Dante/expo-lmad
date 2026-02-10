<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { background-color: #6b7280; color: #fff; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .info-box { background-color: #f3f4f6; padding: 15px; border-left: 4px solid #6b7280; margin: 20px 0; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Asignación de Proyecto</h1>
        </div>
        
        <div class="content">
            <p>Hola <strong>{{ $usuario->nombre }}</strong>,</p>
            
            <p>Te informamos que has sido registrado exitosamente como integrante de un equipo para la <strong>Expo LMAD</strong>.</p>
            
            <div class="info-box">
                <p style="margin:0;"><strong>Materia:</strong> {{ $proyecto->materia->nombre ?? 'N/A' }}</p>
                <p style="margin:5px 0 0 0;"><strong>Proyecto ID:</strong> #{{ $proyecto->id }}</p>
            </div>

            <p>Tu compañero designado como <strong>Líder de Equipo</strong> ha recibido las credenciales necesarias para subir la información del proyecto, el póster y los detalles técnicos.</p>
            
            <p>Te recomendamos ponerte en contacto con tu equipo para coordinar la entrega de la información antes de la fecha límite.</p>
            
            <p>Puedes ingresar al sistema para ver el estatus de tu proyecto.</p>
        </div>

        <div class="footer">
            <p>Este es un mensaje automático del sistema Expo LMAD.</p>
        </div>
    </div>
</body>
</html>