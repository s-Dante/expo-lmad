
const materiaSelect = document.getElementById('materia_id');

materiaSelect.addEventListener('change', function() {
    const opcionSeleccionada = this.options[this.selectedIndex];

    const planAcademico = opcionSeleccionada.getAttribute('data-plan');
    const semestre = opcionSeleccionada.getAttribute('data-semestre');
    
    const planInput = document.getElementById('in_planAcademico');
    const semestreInput = document.getElementById('in_semestre');

    planInput.value = planAcademico;
    semestreInput.value = semestre;
});