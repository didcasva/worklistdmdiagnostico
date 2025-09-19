document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("updateformulario");
    const tdHoraIngreso = document.querySelector("[data-hora-ingreso]");
    const tdEstado = document.querySelector("[data-estado]");
    const atendidoField = document.getElementById("atendido"); // tu nuevo select o input radio

    if (form && tdHoraIngreso && tdEstado && atendidoField) {
        const horaIngreso = new Date(tdHoraIngreso.dataset.horaIngreso);
        const estado = tdEstado.dataset.estado;

        form.addEventListener("submit", function (e) {
            const atendido = atendidoField.value; // "si" o "no"

            if (estado === "pendiente" && atendido === "si") {
                const ahora = new Date();

                // Diferencia en milisegundos
                const diffMs = ahora - horaIngreso;
                const diffMin = diffMs / 1000 / 60; // minutos

                if (diffMin < 4) {
                    e.preventDefault();
                    alert("⚠️ El tiempo de atención no puede ser menor a 4 minutos");
                }
            }
            // ⚠️ Si atendido = "no", no validamos el tiempo, Laravel ya lo marca como completado.
        });
    }
});

// Convertir a mayúsculas y eliminar espacios al inicio en campos específicos
document.addEventListener("DOMContentLoaded", function () {
    const camposEspecificos = ["observaciones"];
    camposEspecificos.forEach(id => {
        const campo = document.getElementById(id);
        if (campo) {
            campo.addEventListener("input", function () {
                this.value = this.value.toUpperCase().trimStart();
            });
            campo.addEventListener("blur", function () {
                this.value = this.value.trim();
            });
        }
    });
});

// Validar que se seleccione una opción en el campo "¿Se dejó atender?"
document.addEventListener("DOMContentLoaded", function () {
    const atencionSelect = document.getElementById("atencionsiono");
    const camposTecnicos = document.querySelectorAll("input[name$='kv'], input[name$='mas'], input[name$='espesor'],input[name='lado_'], #numeroplacas, #observaciones"); 
    const estadoField = document.createElement("input");

    // Campo oculto para forzar el estado "completado"
    estadoField.type = "hidden";
    estadoField.name = "estado";
    document.getElementById("updateformulario").appendChild(estadoField);

    function toggleCampos() {
        if (atencionSelect.value === "0") {
            // Si el paciente NO se dejó atender
            camposTecnicos.forEach(campo => {
                campo.value = "";       // Limpia valores
                campo.disabled = true;  // Deshabilita edición
            });
            estadoField.value = "completado"; // Forzar estado
        } else {
            // Si el paciente sí se atendió
            camposTecnicos.forEach(campo => campo.disabled = false);
            estadoField.value = "pendiente"; // Mantener flujo normal
        }
    }

    // Ejecutar al cargar
    toggleCampos();

    // Ejecutar al cambiar selección
    atencionSelect.addEventListener("change", toggleCampos);
});
