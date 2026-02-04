<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EXPO LMAD - Estudiante</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/student/lista-exposiones.css'
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

    .section-expositions {
        display: grid;
        gap: 1rem;
    }

    .div-project-data {
        margin-bottom: 1rem;
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

    .btn {
        display: grid;
        font-size: 1.5rem;
    }

    .legend {
        font-family: var(--font-dislay);
        font-size: 0.8rem;
    }

    @media (min-width: 650px) {
        main {
            margin-left: 7.5rem;
            top: 1rem;
        }
    }

    @media (min-width: 900px) {
        .section-expositions {
            grid-template-columns: auto auto;
        }

        .expo-card {
            height: auto;
        }
    }

    @media (min-width: 1200px) {
        .section-expositions {
            grid-template-columns: auto auto auto;
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
        <h1>Exposiciones</h1>

        <section class="section-expositions">

            <x-student.project-card
                titulo="Proyecto rimbombástico"
                materia="Programación orientada a objetos"
                estado="En revisión"
            />

            <x-student.project-card
                titulo="Proyecto rimbombástico"
                materia="Programación orientada a objetos"
                estado="Correciones"
            />

            <x-student.project-card
                titulo="Proyecto rimbombástico"
                materia="Programación orientada a objetos"
                estado="Aceptado"
            />

            <x-student.project-card
                titulo="Proyecto rimbombástico"
                materia="Programación orientada a objetos"
                estado="Rechazado"
            />

        </section>

    </main>

</body>