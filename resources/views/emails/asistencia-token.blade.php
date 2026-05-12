<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>Token de asistencia · Expo LMAD</title>
</head>
<body style="margin:0; padding:0; background-color:#07101e; font-family:'Segoe UI', Arial, sans-serif; -webkit-text-size-adjust:100%;">

    <!-- Spacer top -->
    <div style="height:32px;"></div>

    <!-- Card wrapper -->
    <div style="max-width:580px; margin:0 auto; border-radius:16px; overflow:hidden; box-shadow:0 8px 40px rgba(0,0,0,0.6); border:1px solid rgba(108,71,182,0.25);">

        <!-- Accent bar -->
        <div style="height:4px; background:linear-gradient(90deg, #6c47b6, #3b7dd8, #6c47b6);"></div>

        <!-- Header -->
        <div style="background:#091220; padding:28px 36px 24px; text-align:center; border-bottom:1px solid rgba(108,71,182,0.2);">
            <div style="font-size:1.5rem; font-weight:800; letter-spacing:0.12em; color:#dde8f5; text-transform:uppercase;">
                EXPO <span style="color:#8b5cf6;">LMAD</span>
            </div>
            <div style="font-size:0.72rem; color:#4a6a8a; letter-spacing:0.2em; margin-top:5px; text-transform:uppercase;">
                FCFM &nbsp;·&nbsp; UANL
            </div>
        </div>

        <!-- Body -->
        <div style="background:#0c1829; padding:36px 40px;">

            <!-- Icon + title -->
            <div style="text-align:center; margin-bottom:28px;">
                <div style="display:inline-block; background:rgba(108,71,182,0.15); border:1px solid rgba(108,71,182,0.4); border-radius:50%; width:56px; height:56px; line-height:56px; font-size:1.6rem; text-align:center;">
                    🎟
                </div>
                <div style="margin-top:14px; font-size:1.2rem; font-weight:700; color:#dde8f5; letter-spacing:0.02em;">
                    Tu token de asistencia
                </div>
                <div style="margin-top:6px; font-size:0.85rem; color:#5a7a9a;">
                    Guárdalo — lo necesitarás al salir del evento
                </div>
            </div>

            <!-- Greeting -->
            <p style="margin:0 0 12px; font-size:0.95rem; color:#b0c8e0;">
                Hola <strong style="color:#dde8f5;">{{ $nombreVisitante }}</strong>,
            </p>
            <p style="margin:0 0 20px; font-size:0.9rem; color:#7a9ab8; line-height:1.7;">
                Tu registro fue exitoso para el siguiente evento:
            </p>

            <!-- Event name -->
            <div style="background:#0a1525; border-left:3px solid #8b5cf6; border-radius:0 8px 8px 0; padding:12px 16px; margin-bottom:24px;">
                <span style="font-size:0.95rem; font-weight:600; color:#a78bfa;">{{ $tituloEvento }}</span>
            </div>

            <p style="margin:0 0 20px; font-size:0.9rem; color:#7a9ab8; line-height:1.7;">
                Al <strong style="color:#b0c8e0;">finalizar el evento</strong>, ingresa a <strong style="color:#b0c8e0;">/Asistencia</strong> en el sitio de la Expo e introduce el siguiente código para confirmar tu asistencia:
            </p>

            <!-- Token box -->
            <div style="background:#060f1c; border:1.5px dashed rgba(139,92,246,0.6); border-radius:12px; padding:24px 16px; text-align:center; margin:0 0 24px;">
                <div style="font-size:0.7rem; color:#4a6a8a; letter-spacing:0.25em; text-transform:uppercase; margin-bottom:12px;">
                    Código de confirmación
                </div>
                <div style="font-size:2.4rem; font-weight:800; letter-spacing:0.35em; color:#a78bfa; font-family:'Courier New', monospace;">
                    {{ $token }}
                </div>
            </div>

            <p style="margin:0; font-size:0.82rem; color:#4a6680; line-height:1.7;">
                Este token es personal e intransferible. Toma una captura de pantalla o cópialo antes de que termine el evento.<br><br>
                Si no realizaste este registro, puedes ignorar este mensaje con seguridad.
            </p>

        </div>

        <!-- Footer -->
        <div style="background:#070f1c; padding:18px 40px; text-align:center; border-top:1px solid rgba(255,255,255,0.05);">
            <p style="margin:0; font-size:0.72rem; color:#2e4a62; line-height:1.8;">
                Mensaje automático · Sistema <strong style="color:#3a5a7a;">Expo LMAD</strong><br>
                Facultad de Ciencias Físico Matemáticas &nbsp;·&nbsp; UANL<br>
                No respondas a este correo
            </p>
        </div>

    </div>

    <!-- Spacer bottom -->
    <div style="height:40px;"></div>

</body>
</html>
