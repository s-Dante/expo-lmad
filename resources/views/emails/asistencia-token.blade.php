<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <style>
        body        { font-family: Arial, sans-serif; background-color: #0a1c33; color: #e0e6f0; line-height: 1.6; margin: 0; padding: 0; }
        .wrapper    { max-width: 600px; margin: 30px auto; background: #112244; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.4); }
        .header     { background: linear-gradient(135deg, #1c481a, #0a1c33); padding: 28px 30px; text-align: center; }
        .header img { height: 60px; }
        .header h1  { margin: 12px 0 0; font-size: 1.4rem; color: #c8d93d; letter-spacing: 0.05em; }
        .content    { padding: 28px 36px; }
        .content p  { margin: 0 0 14px; }
        .token-box  {
            background: #0b2040;
            border: 2px dashed #c8d93d;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 6px;
            color: #c8d93d;
            margin: 24px 0;
        }
        .note       { font-size: 0.85rem; color: #8899aa; margin-top: 20px; border-top: 1px solid #1e3a5f; padding-top: 14px; }
        .event-name { color: #7eceff; font-weight: bold; }
        .footer     { font-size: 0.78rem; color: #556677; text-align: center; padding: 16px 24px; background: #0d1e36; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>🎟 TOKEN DE ASISTENCIA</h1>
        </div>

        <div class="content">
            <p>Hola <strong>{{ $nombreVisitante }}</strong>,</p>

            <p>Te has registrado exitosamente en el evento:</p>
            <p class="event-name">&nbsp;&nbsp;{{ $tituloEvento }}</p>

            <p>Al <strong>finalizar el evento</strong>, escanea el código QR de salida o visita <strong>/Asistencia</strong> e ingresa el siguiente token para confirmar que asististe:</p>

            <div class="token-box">{{ $token }}</div>

            <p>Este token es personal e intransferible. Guárdalo en tu celular o toma una captura de pantalla.</p>

            <div class="note">
                <p>Si no te registraste en este evento, ignora este correo.<br>
                Cualquier duda, acércate con el staff de la Expo LMAD.</p>
            </div>
        </div>

        <div class="footer">
            Mensaje automático del sistema Expo LMAD &mdash; FCFM, UANL
        </div>
    </div>
</body>
</html>
