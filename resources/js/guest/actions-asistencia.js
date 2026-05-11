/**
 * actions-asistencia.js
 * Lógica para la vista /Asistencia
 *
 * Maneja:
 *  - Tabs de opciones (Opción 1: matrícula / Opción 2: token)
 *  - Carga dinámica de eventos activos en el select de Opción 1
 *  - Envío AJAX de ambos formularios de confirmación
 */

document.addEventListener("DOMContentLoaded", async () => {

    // ── Tabs ─────────────────────────────────────────────────────────────────
    const tabBtns   = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;

            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.classList.remove('active'));

            btn.classList.add('active');
            document.getElementById('panel-' + target)?.classList.add('active');
        });
    });

    // ── Cargar eventos activos (Opción 1) ────────────────────────────────────
    const selectOp1 = document.getElementById('select-evento-op1');

    if (selectOp1) {
        try {
            const resp = await fetch('/api/eventos-activos');
            const data = await resp.json();

            // Limpiar placeholder
            while (selectOp1.options.length > 0) selectOp1.remove(0);

            if (data.eventos && data.eventos.length > 0) {
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = 'Selecciona el evento';
                placeholder.disabled = true;
                placeholder.selected = true;
                selectOp1.appendChild(placeholder);

                data.eventos.forEach(ev => {
                    const opt = document.createElement('option');
                    opt.value = ev.id;
                    opt.textContent = ev.titulo;
                    selectOp1.appendChild(opt);
                });
            } else {
                const opt = document.createElement('option');
                opt.value = '';
                opt.textContent = 'No hay eventos disponibles';
                opt.disabled = true;
                selectOp1.appendChild(opt);
            }
        } catch (e) {
            console.warn('Error cargando eventos.', e);
        }
    }

    // ── Formulario Opción 1: confirmar por matrícula ──────────────────────────
    const formOp1        = document.getElementById('form-opcion1');
    const btnOp1         = document.getElementById('btn-confirmar-op1');
    const msgOp1         = document.getElementById('msg-opcion1');
    const inputMatricula = document.getElementById('input-matricula-op1');

    if (formOp1) {
        formOp1.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (btnOp1) btnOp1.disabled = true;

            const matricula = inputMatricula?.value.trim();
            const eventoId  = selectOp1?.value;

            if (!matricula || !eventoId) {
                mostrarMensaje(msgOp1, 'Por favor completa todos los campos.', 'error');
                if (btnOp1) btnOp1.disabled = false;
                return;
            }

            try {
                const res  = await fetch('/api/confirmar-matricula', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    },
                    body: JSON.stringify({ matricula, evento_id: eventoId }),
                });
                const data = await res.json();
                mostrarMensaje(msgOp1, data.mensaje, res.ok ? 'success' : 'error');

                if (res.ok) formOp1.reset();
            } catch (err) {
                mostrarMensaje(msgOp1, 'Error de conexión. Intenta de nuevo.', 'error');
            } finally {
                if (btnOp1) btnOp1.disabled = false;
            }
        });
    }

    // ── Formulario Opción 2: confirmar por token ──────────────────────────────
    const formOp2   = document.getElementById('form-opcion2');
    const btnOp2    = document.getElementById('btn-confirmar-op2');
    const msgOp2    = document.getElementById('msg-opcion2');
    const inputCorr = document.getElementById('input-correo-op2');
    const inputTok  = document.getElementById('input-token-op2');

    // Forzar uppercase en el input del token mientras se escribe
    if (inputTok) {
        inputTok.addEventListener('input', () => {
            inputTok.value = inputTok.value.toUpperCase();
        });
    }

    if (formOp2) {
        formOp2.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (btnOp2) btnOp2.disabled = true;

            const correo = (inputCorr?.value.trim() ?? '') + '@uanl.edu.mx';
            const token  = inputTok?.value.trim().toUpperCase();

            if (!correo || !token) {
                mostrarMensaje(msgOp2, 'Por favor completa todos los campos.', 'error');
                if (btnOp2) btnOp2.disabled = false;
                return;
            }

            try {
                const res  = await fetch('/api/confirmar-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    },
                    body: JSON.stringify({ correo, token }),
                });
                const data = await res.json();
                mostrarMensaje(msgOp2, data.mensaje, res.ok ? 'success' : 'error');

                if (res.ok) formOp2.reset();
            } catch (err) {
                mostrarMensaje(msgOp2, 'Error de conexión. Intenta de nuevo.', 'error');
            } finally {
                if (btnOp2) btnOp2.disabled = false;
            }
        });
    }
});

// ── Utilidad: mostrar mensajes inline ─────────────────────────────────────────
function mostrarMensaje(el, texto, tipo) {
    if (!el) return;
    el.textContent = texto;
    el.className   = 'form-msg form-msg--' + tipo;
    el.style.display = 'block';
    // Ocultar automáticamente después de 7s solo en caso de éxito
    if (tipo === 'success') {
        setTimeout(() => { el.style.display = 'none'; }, 7000);
    }
}
