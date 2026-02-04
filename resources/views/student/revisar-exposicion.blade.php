<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EXPO LMAD - Estudiante</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/student/revisar-exposicion.css'
    ])

</head>

<style>
    @import url(/resources/css/tokens.css);

    h1 {
        color: var(--clr-blue-100);
        font-family: var(--font-display);
        font-weight: 10;
        text-align: center;
    }

    h2,
    h3 {
        font-family: var(--font-main);
        margin: 0rem;
    }

    h2 {
        color: var(--clr-blue-200);
    }

    h3 {
        font-size: 1rem;
        color: var(--clr-purple-200);
    }

    span {
        color: var(--clr-white);
        font-family: var(--font-body);
    }

    main {
        top: 4rem;
        position: absolute;
        padding: 1rem;
        width: -webkit-fill-available;
        justify-content: center;
        display: grid;
    }

    .container-warning span{
        font-family: var(--font-main);
        color: var(--clr-gray);
    }

    .expo-card {
        display: flex;
        justify-content: center;
        width: auto;
        height: fit-content;
        padding: 1.5rem;
        position: relative;
        border-radius: 18px;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .expo-card::before {
        content: "";
        position: absolute;
        inset: 0;
        padding: 1.5px 3px 3px 1.5px;
        border-radius: 18px;

        background: conic-gradient(from -70deg,
                var(--contrast-color-C),
                var(--contrast-color-D),
                var(--contrast-color-E),
                var(--contrast-color-E));

        -webkit-mask:
            linear-gradient(#000 0 0) content-box,
            linear-gradient(#000 0 0);
        mask:
            linear-gradient(#000 0 0) content-box,
            linear-gradient(#000 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;

        box-shadow:
            0 0 12px rgba(127, 0, 255, 0.45),
            inset 0 0 12px rgba(0, 234, 255, 0.25);

        pointer-events: none;
    }

    @media (min-width: 650px) {
        main {
            margin-left: 7.5rem;
            top: 1rem;
        }
    }

    @media (min-width: 1350px) {
        main {
            padding-inline: 15rem;
        }
    }
</style>

<body>
    <x-sidebar />

    <main>
        <h1>Respuesta al proyecto enviado</h1>

        <container class="container-warning">
            <span>
                Tras enviar tu proyecto al CONGRESO LMAD, se realizará una revisión para verificar que se cumpla con
                los estándares esperados del evento. En este apartado podrás ver la respuesta tras que sea revisado, a
                su vez, se enviará un aviso a tu correo universitario si necesita hacerle cambios para su aceptación.

                Favor de estar al pendiente una vez enviado el proyecto. No olvides revisar tu correo spam!
            </span>
        </container>

    </main>

</body>