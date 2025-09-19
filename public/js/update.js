document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("updateformulario");
    const tdHoraIngreso = document.querySelector("[data-hora-ingreso]");
    const tdEstado = document.querySelector("[data-estado]");

    if (form && tdHoraIngreso && tdEstado) {
        const horaIngreso = new Date(tdHoraIngreso.dataset.horaIngreso);
        const estado = tdEstado.dataset.estado;

        form.addEventListener("submit", function (e) {
            if (estado === "pendiente") {
                const ahora = new Date();

                // Diferencia en milisegundos
                const diffMs = ahora - horaIngreso;
                const diffMin = diffMs / 1000 / 60; // minutos

                if (diffMin < 4) {
                    e.preventDefault();
                    alert("⚠️ El tiempo de atención no puede ser menor a 4 minutos");
                }
            }
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