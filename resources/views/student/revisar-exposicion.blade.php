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
        margin: 0rem;
    }

    h2 {
        font-family: var(--font-main);
        color: var(--clr-blue-200);
        font-size: 2.1rem;
    }

    h3 {
        text-transform: uppercase;
        font-size: 2rem;
        color: var(--clr-purple-200);
        font-family: var(--font-title-bold);
    }

    h4 {
        font-family: var(--font-main);
        color: var(--clr-cian-300);
        font-size: 1.4em;
    }

    span {
        color: var(--clr-white);
        font-family: var(--font-body);
        font-size: 1.5rem;
    }

    p {
        font-size: 1.2rem;
    }

    main {
        top: 4rem;
        position: absolute;
        padding: 1rem;
        width: -webkit-fill-available;
        justify-content: center;
        display: grid;
    }

    center {
        margin-top: 3rem;
        width: -webkit-fill-available;
    }

    .input-c {
        background: var(--input-flat);
        border: 0;
        border-bottom: 3px solid var(--contrast-color-D);
        border-radius: 10px;
        color: var(--text-primary);
        font-family: var(--font-main);
        padding: 8px 15px;
        outline: none;
        text-align: center;
        position: relative;
        text-align: left;
        font-size: 1rem;
        width: -webkit-fill-available;
    }

    .div-btn-changeimage{
        margin-top: 1rem;
    }

    .input-description {
        background: var(--input-flat);
        border: 0;
        border-bottom: 3px solid var(--contrast-color-D);
        border-radius: 10px;
        color: var(--text-primary);
        font-family: var(--font-main);
        padding: 8px 15px;
        outline: none;
        position: relative;
        width: -webkit-fill-available;
        height: 10rem;
        text-align: start;
        font-size: 1rem;
    }

    .project-retro p {
        font-family: var(--font-main);
        color: var(--clr-gray);
    }

    .project-retro-msg span {
        font-family: var(--font-main);
        color: var(--clr-white);
        font-weight: 400;
        margin-bottom: 1rem;
    }

    .project-retro-msg p {
        font-family: var(--font-main);
        color: var(--clr-white);
    }

    .section-project-header {
        margin-bottom: 1.5rem;
    }

    .container-warning {
        text-align: center;
    }

    .container-warning span {
        font-family: var(--font-main);
        color: var(--clr-gray);
        font-size: 1rem;
    }

    .expo-card {
        background: linear-gradient(0deg, #111b2c, #131f33);
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

    .div-btns-project {
        margin-top: 1rem;
        display: grid;
        width: auto;
        gap: 1rem;
        justify-content: center;
    }

    .btn {
        font-size: 1.2rem;
    }

    .section-project-data {
        margin-top: 3rem;
    }

    #link-repo-project,
    #link-video-project,
    #description-project {
        width: auto;
        word-wrap: break-word;
    }

    .three-rows-grid {
        width: min-content;
        display: grid;
        gap: 2rem;
    }

    .two-columns-grid,
    .three-columns-grid {
        max-width: 75vw;
    }

    .two-category-grid span,
    .three-category-grid span {
        margin: 0rem;
        text-align: center;
        font-family: var(--font-title-bold);
        color: var(--clr-cian-300);
        text-transform: uppercase;
    }

    .two-category-grid p,
    .three-category-grid p {
        margin: 0rem;
        text-align: center;
        font-family: var(--font-main);
        color: var(--clr-white);
    }

    .img-icon {
        width: 1.8rem;
    }

    .btn-icon {
        margin-top: 1rem;
        padding: 0.5rem;
        padding-inline: 0.8rem;
        width: fit-content;
    }

    .img-project {
        margin-top: 1rem;
    }

    @media(min-width: 1235px) {
        .div-btns-project {
            grid-template-columns: auto auto;
        }

        .three-rows-grid {
            display: grid;
            gap: 2rem;
            width: -webkit-fill-available;
        }

        .two-columns-grid {
            display: grid;
            grid-template-columns: auto auto;
        }

        .two-category-grid {
            grid-template-columns: 13rem auto;
            gap: 0.5rem;
            align-items: baseline;
        }

        .two-category-grid span {
            margin: 0rem;
            text-align: right;
            font-family: var(--font-title-bold);
            color: var(--clr-cian-300);
            text-transform: uppercase;
        }

        .two-category-grid p {
            margin: 0rem;
            text-align: left;
            font-family: var(--font-main);
            color: var(--clr-white);
        }

        .three-columns-grid {
            display: grid;
            grid-template-columns: auto auto auto;
        }

        .three-category-grid {
            grid-template-columns: 13rem 23rem 4rem;
            gap: 0.5rem;
            align-items: baseline;
        }

        .three-category-grid span {
            margin: 0rem;
            text-align: right;
            font-family: var(--font-title-bold);
            color: var(--clr-cian-300);
            text-transform: uppercase;
        }

        .three-category-grid p {
            margin: 0rem;
            text-align: left;
            font-family: var(--font-main);
            color: var(--clr-white);
        }

        .general-grid {
            gap: 2rem;
            grid-template-columns: auto 19rem;
        }

        .expo-card {
            padding: 4rem;
        }

        .project-retro-msg {
            max-width: 50rem;
        }

        .container-warning {
            text-align: center;
            padding-inline: 10rem;
        }
    }

    @media (min-width: 650px) {
        main {
            margin-left: 7.5rem;
            top: 1rem;
        }
    }

    @media (min-width: 1350px) {
        main {
            padding-inline: 6rem;
        }
    }

    @media(max-width: 1000px) {

        .two-columns-grid,
        .three-columns-grid {
            justify-items: center;
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
                <br><br>
                Favor de estar al pendiente una vez enviado el proyecto. No olvides revisar tu correo spam!
            </span>
        </container>

        <section class="section-project-data">
            <container class="expo-card main-card">

                <form>
                    <div class="section-project-header">
                        <h2 id="name">Nombre del proyecto</h2>
                        <h3 id="subject">Materia</h3>
                    </div>

                    <div class="two-columns-grid general-grid">
                        <div class="three-rows-grid">

                            <div class="two-columns-grid">

                                <div class="two-columns-grid two-category-grid">
                                    <span>Id del proyecto:</span>
                                    <p id="id">123</p>
                                    <span>Maestro:</span>
                                    <p id="teacher">Severus Snape</p>
                                </div>

                                <div class="two-columns-grid two-category-grid">
                                    <span>Semestre:</span>
                                    <p id="semester">Sexto</p>
                                </div>

                            </div>

                            <div class="two-columns-grid two-category-grid">
                                <span>Alumnos:</span>

                                <div class="two-columns-grid">
                                    <p>Tilin Campana Feliz</p>
                                    <p>1234567</p>

                                    <p>Concho Champurrado</p>
                                    <p>1234567</p>

                                    <p>Amarillo Evaristo</p>
                                    <p>1234567</p>
                                </div>
                            </div>

                            <div class="three-rows-grid">

                                <div class="three-columns-grid three-category-grid">
                                    <span>Video promocional:</span>
                                    <!--<p id="link-video-project" id="link-promotional">https://unlinkrandomayoutube.com/nose</p>-->
                                    <input type="text" class="input-c" id="link-promotional-edit"/>
                                    <!--<button class="btn btn-purple btn-icon" id="link-promotional-copy"><img
                                            src="{{ asset('assets/guest/upload.png') }}"></button>-->
                                </div>

                                <div class="three-columns-grid three-category-grid">
                                    <span>Enlace a proyecto:</span>
                                    <!--<p id="link-repo-project" id="link-repo">https://otrolinkrandomgithub.com/nosetampoco</p>-->
                                    <input type="text" class="input-c" id="link-repo-edit"/>
                                    <!--<button class="btn btn-purple btn-icon" id="link-repo-copy"><img
                                            src="{{ asset('assets/guest/upload.png') }}"></button>-->
                                </div>

                                <div class="two-columns-grid two-category-grid">
                                    <span>Descripción:</span>
                                    <!--<p id="description-project">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Pellentesque ullamcorper porta feugiat.
                                        Pellentesque volutpat massa et neque facilisis pellentesque.
                                        Mauris id urna et libero luctus tincidunt tincidunt non ipsum.
                                        Nullam suscipit dapibus nunc quis suscipit.
                                        Aenean molestie laoreet volutpat. </p>-->
                                    <textarea class="input-description"></textarea>
                                </div>

                            </div>

                        </div>

                        <div class="img-project">
                            <img src="{{ asset('assets/guest/imageloading.png') }}" class="img-fluid">

                            <div class="div-btn-changeimage">
                                <button type="button" class="btn btn-blue">Cambiar imagen</button>
                            </div>
                        </div>

                    </div>
                </form>

                <center>
                    <input type="text" disabled class="hr-gradient">
                </center>

                <section class="project-retro">
                    <h4>Estado del proyecto</h4>
                    <p id="state">En revisión, ¡No olvides estar al pendiente!</p>

                    <container class="expo-card project-retro-msg" id="message">
                        <span>Mensaje del congreso:</span>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Pellentesque ullamcorper porta feugiat.
                            Pellentesque volutpat massa et neque facilisis pellentesque.
                            Mauris id urna et libero luctus tincidunt tincidunt non ipsum.
                            Nullam suscipit dapibus nunc quis suscipit.
                            Aenean molestie laoreet volutpat. </p>
                    </container>

                    <div class="div-btns-project">
                        <button type="button" class="btn btn-blue" id="edit">Editar proyectos</button>
                        <button type="button" class="btn btn-darkpur" id="resend">Reenviar proyecto</button>

                        <button type="button" class="btn btn-blue" id="save">Guardar cambios</button>
                        <button type="button" class="btn btn-purple" id="back">Regresar</button>
                    </div>

                </section>

            </container>

        </section>

    </main>

</body>