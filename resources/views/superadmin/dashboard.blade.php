<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Dashboard</title>
    @vite([
    "resources/css/superadmin/dashboard.css"
    ])
</head>

<body>
    <x-sidebar />
    <div class="main-content">

        <header>
            <h1 class="text-main">DATA</h1>
            <span class="line"></span>
        </header>

        <section class="general-section">
            <h2 class="section-title">Asistencia general</h2>

            <div class="stats-container">

                <div class="stat-card main-circle">
                    <div class="circle-content">
                        <span class="number">549</span>
                        <span class="label">TOTAL DE ASISTIDOS</span>
                    </div>
                </div>

                <div class="stat-card tall-card">
                    <span class="number">516</span>
                    <span class="label">ALUMNOS</span>
                </div>

                <div class="stat-card combined-card">
                    <div class="top-val">
                        <span class="number">33</span>
                        <span class="label">EXTERNOS</span>
                    </div>

                    <div class="bottom-vals">
                        <div><span class="sub-num">12</span><span class="sub-label">FEMENINO</span></div>
                        <div><span class="sub-num">21</span><span class="sub-label">MASCULINO</span></div>
                    </div>

                    <div class="no-binario-val">
                        <span class="sub-num">—</span>
                        <span class="sub-label">NO BINARIO</span>
                    </div>
                </div>

                <div class="stat-card mini-cards-col">
                    <div class="mini-card">
                        <img src="{{ asset('assets/superadmin/calendario-1.png') }}" alt="Eventos" class="mini-icon">
                        <div class="mini-data">
                            <span class="mini-number">13</span>
                            <span class="mini-label">EVENTOS</span>
                        </div>
                    </div>

                    <div class="mini-card">
                        <img src="{{ asset('assets/superadmin/empresa-1.png') }}" alt="Empresas" class="mini-icon">
                        <div class="mini-data">
                            <span class="mini-number">1</span>
                            <span class="mini-label">EMPRESAS</span>
                        </div>
                    </div>
                </div>
        </section>

        <span class="line2"></span>

        <section class="events-section">
            <h2 class="section-title">Asistencia a eventos</h2>

            <div class="events-grid">

                <div class="event-name">FROM IDEA TO SCREEN: DEVELOPING, WRITING AND DIRECTING A FILM</div>
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: 90%;"></div>
                </div>
                <div class="event-number">120</div>

                <div class="event-name">DIBUJANDO MIS SUEÑOS</div>
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: 45%;"></div>
                </div>
                <div class="event-number">47</div>

                <div class="event-name">TALLER: APRENDE A PROGRAMAR CON CODEWARS</div>
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: 25%;"></div>
                </div>
                <div class="event-number">20</div>

                 <div class="event-name">FROM IDEA TO SCREEN: DEVELOPING, WRITING AND DIRECTING A FILM</div>
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: 60%;"></div>
                </div>
                <div class="event-number">120</div>

                <div class="event-name">DIBUJANDO MIS SUEÑOS</div>
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: 23%;"></div>
                </div>
                <div class="event-number">47</div>

                <div class="event-name">TALLER: APRENDE A PROGRAMAR CON CODEWARS</div>
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: 10%;"></div>
                </div>
                <div class="event-number">20</div>

            </div>

            <div class="export-container">
                <button class="btn-export">Exportar a excel</button>
            </div>


        </section>


    </div>

</body>

</html>