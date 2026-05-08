import { show_hide_list } from '../components/show-hide-elements.js';

document.addEventListener("DOMContentLoaded", async () => {
    const selectFacultad      = document.getElementById("select-facultad");
    const selectCarrera       = document.getElementById("select-carrera");
    const containerCarrera    = document.getElementById("container-carrera");
    const containerDependencia= document.getElementById("container-dependencia");
    const inputDependencia    = document.getElementById("input-dependencia");
    const selectEventos       = document.getElementById("conferencias");

    // Retiramos d-none para que el componente manipule el elemento mediante style.display
    if (containerDependencia && containerDependencia.classList.contains("d-none")) {
        containerDependencia.classList.remove("d-none");
        containerDependencia.style.display = "none";
    }

    // ── 1. Cargar facultades desde el JSON mantenible ─────────────────────────
    let facultades = [];
    try {
        const resp = await fetch('/data/facultades.json');
        facultades = await resp.json();

        if (selectFacultad) {
            while (selectFacultad.options.length > 1) selectFacultad.remove(1);
            facultades.forEach(f => {
                const opt = document.createElement('option');
                opt.value = f.clave;
                opt.textContent = f.nombre;
                selectFacultad.appendChild(opt);
            });
        }
    } catch (e) {
        console.warn('No se pudo cargar facultades.json', e);
    }

    // ── 2. Actualizar carreras al cambiar facultad ────────────────────────────
    function actualizarCarreras(claveFacultad) {
        if (!selectCarrera) return;
        while (selectCarrera.options.length > 1) selectCarrera.remove(1);
        selectCarrera.value = "";

        if (claveFacultad === "NP" || !claveFacultad) {
            selectCarrera.disabled = true;
            return;
        }

        const facultad = facultades.find(f => f.clave === claveFacultad);
        if (facultad && facultad.carreras && facultad.carreras.length > 0) {
            facultad.carreras.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.clave;
                opt.textContent = c.nombre;
                selectCarrera.appendChild(opt);
            });
            selectCarrera.disabled = false;
        } else {
            selectCarrera.disabled = true;
        }
    }

    if (selectFacultad && selectCarrera) {
        selectFacultad.addEventListener("change", function () {
            actualizarCarreras(this.value);

            if (this.value === "NP") {
                show_hide_list([containerCarrera], 'none');
                show_hide_list([containerDependencia], 'block');
            } else {
                show_hide_list([containerCarrera], 'block');
                show_hide_list([containerDependencia], 'none');
                if (inputDependencia) inputDependencia.value = "";
            }
        });
    }

    // ── 3. Cargar eventos activos en el select de conferencias ───────────────
    if (selectEventos) {
        try {
            const resp = await fetch('/api/eventos-activos', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await resp.json();

            while (selectEventos.options.length > 0) selectEventos.remove(0);

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Selecciona una conferencia / taller';
            placeholder.disabled = true;
            placeholder.selected = true;
            selectEventos.appendChild(placeholder);

            if (data.eventos && data.eventos.length > 0) {
                data.eventos.forEach(ev => {
                    const opt = document.createElement('option');
                    opt.value = ev.id;
                    opt.textContent = ev.titulo;
                    selectEventos.appendChild(opt);
                });
            } else {
                const opt = document.createElement('option');
                opt.value = "";
                opt.textContent = "No hay eventos disponibles";
                opt.disabled = true;
                selectEventos.appendChild(opt);
            }
        } catch (e) {
            console.warn('No se pudieron cargar los eventos.', e);
        }
    }

    // ── 4. Envío del formulario de REGISTRO ───────────────────────────────────
    const formRegistro = document.getElementById("form-registro");
    const btnRegistrar = document.getElementById("btn-registrar");
    const msgRegistro  = document.getElementById("msg-registro");

    if (formRegistro) {
        formRegistro.addEventListener("submit", async function (e) {
            e.preventDefault();
            if (btnRegistrar) btnRegistrar.disabled = true;

            const nombre    = document.getElementById("input-nombre")?.value.trim();
            const matricula = document.getElementById("input-matricula")?.value.trim();
            // El input solo guarda el prefijo; añadimos el dominio antes de enviar
            const correoPrefijo = document.getElementById("input-correo")?.value.trim();
            const correo    = correoPrefijo ? correoPrefijo + '@uanl.edu.mx' : null;
            const facultad  = selectFacultad?.value;
            const carrera   = selectCarrera?.value;
            const dependencia = inputDependencia?.value.trim();
            const eventoId  = selectEventos?.value;

            try {
                const res = await fetch('/api/registro-asistencia', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',  // ← forzar respuesta JSON en errores
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    },
                    body: JSON.stringify({
                        nombre, matricula, correo,
                        facultad, carrera, dependencia,
                        evento_id: eventoId,
                    }),
                });

                const data = await res.json();

                if (res.ok) {
                    mostrarMensaje(msgRegistro, data.mensaje ?? '¡Registro exitoso!', 'success');
                    formRegistro.reset();
                    if (selectCarrera) selectCarrera.disabled = true;
                } else {
                    // Puede traer errores de validación en data.errors
                    const errores = data.errors
                        ? Object.values(data.errors).flat().join(' | ')
                        : (data.mensaje ?? data.message ?? 'Hubo un error al registrar.');
                    mostrarMensaje(msgRegistro, errores, 'error');
                }
            } catch (err) {
                console.error('Error en fetch registro:', err);
                mostrarMensaje(msgRegistro, 'Error de conexión. Verifica tu internet e intenta de nuevo.', 'error');
            } finally {
                if (btnRegistrar) btnRegistrar.disabled = false;
            }
        });
    }
});

// ── Utilidad para mostrar mensajes inline ─────────────────────────────────────
function mostrarMensaje(el, texto, tipo) {
    if (!el) return;
    el.textContent = texto;
    el.className = 'form-msg form-msg--' + tipo;
    el.style.display = 'block';
    if (tipo === 'success') {
        setTimeout(() => { el.style.display = 'none'; }, 7000);
    }
}
