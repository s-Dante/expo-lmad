<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>Asignación a proyecto · Expo LMAD</title>
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
                <div style="display:inline-block; background:rgba(59,125,216,0.15); border:1px solid rgba(59,125,216,0.4); border-radius:50%; width:56px; height:56px; line-height:56px; font-size:1.6rem; text-align:center;">
                    👥
                </div>
                <div style="margin-top:14px; font-size:1.2rem; font-weight:700; color:#dde8f5; letter-spacing:0.02em;">
                    Fuiste asignado a un equipo
                </div>
                <div style="margin-top:6px; font-size:0.85rem; color:#5a7a9a;">
                    Ya formas parte del proyecto en la Expo LMAD
                </div>
            </div>

            <!-- Greeting -->
            <p style="margin:0 0 16px; font-size:0.95rem; color:#b0c8e0;">
                Hola <strong style="color:#dde8f5;">{{ $usuario->nombre }}</strong>,
            </p>
            <p style="margin:0 0 22px; font-size:0.9rem; color:#7a9ab8; line-height:1.7;">
                Tu profesor te ha registrado como <strong style="color:#60a5fa;">integrante de equipo</strong> para la próxima Expo LMAD. A continuación encontrarás los detalles de tu asignación:
            </p>

            <!-- Project info -->
            <div style="background:#0a1525; border:1px solid rgba(59,125,216,0.25); border-radius:10px; padding:20px 22px; margin-bottom:24px;">
                <div style="font-size:0.7rem; color:#4a6a8a; letter-spacing:0.18em; text-transform:uppercase; margin-bottom:14px;">
                    Tu proyecto
                </div>

                <!-- Row: Materia -->
                <div style="display:flex; align-items:baseline; gap:10px; margin-bottom:10px;">
                    <div style="font-size:0.75rem; color:#4a6a8a; min-width:70px; flex-shrink:0;">Materia</div>
                    <div style="font-size:0.92rem; color:#dde8f5; font-weight:500;">{{ $proyecto->materia->nombre ?? '—' }}</div>
                </div>

                <!-- Divider -->
                <div style="height:1px; background:rgba(255,255,255,0.05); margin:8px 0;"></div>

                <!-- Row: Proyecto -->
                <div style="display:flex; align-items:baseline; gap:10px; margin-bottom:10px;">
                    <div style="font-size:0.75rem; color:#4a6a8a; min-width:70px; flex-shrink:0;">Proyecto</div>
                    <div style="font-size:0.92rem; color:#dde8f5; font-weight:500;">{{ $proyecto->titulo ?? 'Pendiente de definir' }}</div>
                </div>

                <!-- Divider -->
                <div style="height:1px; background:rgba(255,255,255,0.05); margin:8px 0;"></div>

                <!-- Row: Rol -->
                <div style="display:flex; align-items:baseline; gap:10px;">
                    <div style="font-size:0.75rem; color:#4a6a8a; min-width:70px; flex-shrink:0;">Tu rol</div>
                    <div style="font-size:0.92rem; color:#60a5fa; font-weight:600;">Integrante</div>
                </div>
            </div>

            <!-- Info callout -->
            <div style="background:rgba(59,125,216,0.08); border-left:3px solid #3b7dd8; border-radius:0 8px 8px 0; padding:14px 16px; margin-bottom:24px;">
                <p style="margin:0; font-size:0.88rem; color:#7aabda; line-height:1.65;">
                    El <strong style="color:#a0c8f0;">Líder de tu equipo</strong> recibirá las credenciales para completar y gestionar el proyecto en la plataforma. Coordínate con él para entregar la información a tiempo.
                </p>
            </div>

            <!-- CTA -->
            <div style="text-align:center; margin-bottom:24px;">
                <a href="{{ route('login') }}"
                   style="display:inline-block; background:linear-gradient(135deg, #1a3a6e, #2a5aaa); color:#a0c8f0; text-decoration:none; font-size:0.88rem; font-weight:700; padding:12px 32px; border-radius:50px; letter-spacing:0.04em; border:1px solid rgba(59,125,216,0.5);">
                    Ver mi proyecto en Expo LMAD
                </a>
            </div>

            <p style="margin:0; font-size:0.82rem; color:#4a6680; line-height:1.7;">
                Si crees que esta asignación fue un error, comunícate con tu profesor directamente.
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
