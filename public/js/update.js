document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("updateformulario");
    const tdHoraIngreso = document.querySelector("[data-hora-ingreso]");
    const tdEstado = document.querySelector("[data-estado]");
    const atendidoField = document.getElementById("atencionsiono"); // corregido

    if (form && tdHoraIngreso && tdEstado && atendidoField) {
        const horaIngreso = new Date(tdHoraIngreso.dataset.horaIngreso);
        const estado = tdEstado.dataset.estado;

        form.addEventListener("submit", function (e) {
            const atendido = atendidoField.value; // "1" o "0"

            if (estado === "pendiente" && atendido === "1") {
                const ahora = new Date();

                // Diferencia en milisegundos
                const diffMs = ahora - horaIngreso;
                const diffMin = diffMs / 1000 / 60; // minutos

                if (diffMin < 4) {
                    e.preventDefault();
                    alert("⚠️ El tiempo de atención no puede ser menor a 4 minutos");
                }
            }
            // ⚠️ Si atendido === "0", no validamos el tiempo.
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

document.addEventListener("DOMContentLoaded", function () {
    const atencionSelect = document.getElementById("atencionsiono");
    const camposTecnicos = document.querySelectorAll(
        "input[name$='kv'], input[name$='mas'], input[name$='espesor'], input[name='lado_'], #numeroplacas, #observaciones"
    ); 
    const hiddenAtencionsiono = document.getElementById("hiddenAtencionsiono");

    // Crear input hidden para estado y asignar valor inicial desde Blade
    const estadoField = document.createElement("input");
    estadoField.type = "hidden";
    estadoField.name = "estado";
    estadoField.value = document.querySelector("td[data-estado]")?.dataset.estado || "pendiente"; 
    document.getElementById("updateformulario").appendChild(estadoField);

    function toggleCampos() {
        if (atencionSelect.value === "0") {
            // Paciente NO atendido
            camposTecnicos.forEach(campo => {
                campo.value = "";
                campo.disabled = true;
            });
            estadoField.value = "completado";   // cerrar registro
            hiddenAtencionsiono.value = 0;       // actualizar hidden
        } else {
            // Paciente SÍ atendido
            camposTecnicos.forEach(campo => campo.disabled = false);

            // Solo poner pendiente si no estaba completado
            if (estadoField.value !== "completado") {
                estadoField.value = "pendiente";
            }
            hiddenAtencionsiono.value = 1;       // actualizar hidden
        }
    }

    // Ejecutar al cargar
    toggleCampos();

    // Ejecutar al cambiar selección
    atencionSelect.addEventListener("change", toggleCampos);
});
