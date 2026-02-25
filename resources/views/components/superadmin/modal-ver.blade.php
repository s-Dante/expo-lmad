<div id="modal-proyecto" class="modal-overlay hidden" data-copy-icon="{{ asset('assets/teacher/CopiarVector.png') }}">
   

    <section class="project-card">
         <button id="btn-x-modal" class="modal-x-btn">&times;</button>
        <div class="card-inner">
            <h2 class="inner-title" id="modal-titulo">Título del Proyecto</h2>
            <p class="inner-subject" id="modal-materia">Nombre de la Materia</p>

            <div class="project-content">
                <div class="info-side">
                    <div class="group-container header-info">
                        <div class="info-row">
                            <span class="label">ID DEL PROYECTO:</span>
                            <span class="value val-id" id="modal-id"></span>
                            <span class="label label-inline">SEMESTRE:</span>
                            <span class="value" id="modal-semestre"></span>
                        </div>
                        <div class="info-row">
                            <span class="label">MAESTRO:</span>
                            <span class="value" id="modal-maestro"></span>
                        </div>
                    </div>

                    <div class="group-container students-section">
                        <div class="info-row">
                            <span class="label">ALUMNOS:</span>
                            <div class="students-list" id="students-list">
                            </div>
                        </div>
                    </div>

                    <div class="group-container links-section" id="modal-links-section">
                        <div class="info-row">
                            <span class="label">VIDEO PROMOCIONAL:</span>
                            <div class="link-wrapper">
                                <a href="#" id="modal-video-url" class="url-text" target="_blank">Cargando enlace...</a>
                                <button class="btn-copy">
                                    <img src="{{ asset('assets/teacher/CopiarVector.png') }}" alt="Copiar">
                                </button>
                            </div>
                        </div>

                        <div class="info-row">
                            <span class="label">ENLACE A PROYECTO:</span>
                            <div class="link-wrapper">
                                <a href="#" id="modal-proyecto-url" class="url-text" target="_blank">Cargando enlace...</a>
                                <button class="btn-copy">
                                    <img src="{{ asset('assets/teacher/CopiarVector.png') }}" alt="Copiar">
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="group-container description-section">
                        <div class="info-row">
                            <span class="label">DESCRIPCIÓN:</span>
                            <p class="description-text" id="modal-descripcion">
                            
                            </p>
                        </div>
                    </div>
                </div>

                <div class="image-side">
                    <div class="image-box">
                        <img src="{{ asset('assets/placeholder-img.png') }}" id="modal-imagen" alt="Proyecto">
                    </div>
                </div>
            </div>

            <div class="project-actions">
                <div class="row-top">
                    <button id="btn-mandar-modal" class="btn-pill btn-magenta">
                        Mandar a revisión
                    </button>
                  <!--  <button id="btn-cerrar-modal" class="btn-pill btn-purple">
                        Regresar
                    </button> -->
                </div>
            </div>
        </div>
    </section>

</div>