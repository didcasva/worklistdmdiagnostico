// ==========================
// 📷 Manejo de cámara
// ==========================
let stream;
const videoPreview = document.getElementById('videoPreview');
let isCameraActive = false;
let fotofrente = false;
let fotoreverso = false;
// Configurar el videoPreview para que no se muestre inicialmente
function toggleCamara() {
    const btnActivarCamara = document.getElementById('btnActivarCamara');
    if (!isCameraActive) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(s => {
                stream = s;
                videoPreview.srcObject = stream;
                videoPreview.style.display = 'initial';
                btnActivarCamara.textContent = 'Desactivar Cámara';
                isCameraActive = true;
            })
            .catch(error => {
                console.error("Error al activar la cámara:", error);
                alert("⚠️ No se pudo activar la cámara.");
            });
    } else {
        stream.getTracks().forEach(track => track.stop());
        videoPreview.style.display = 'hidden';
        btnActivarCamara.textContent = 'Activar Cámara';
        isCameraActive = false;
    }
}
// Capturar imagen y asignarla al input correspondiente
function capturarImagen(tipo) {
    if (!isCameraActive) {
        alert("⚠️ Activa la cámara primero.");
        return;
    }
    const videoElement = videoPreview;
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    const imgElement = tipo === 'frente'
        ? document.getElementById('ftoFrenteId')
        : document.getElementById('ftoReversoId');
    const input = tipo === 'frente'
        ? document.getElementById('frenteInput')
        : document.getElementById('reversoInput');

    canvas.width = 300;
    canvas.height = 200;
    context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

    imgElement.src = canvas.toDataURL('image/png');
    imgElement.style.display = 'block';
    input.value = imgElement.src;

    if (tipo === 'frente') fotofrente = true;
    if (tipo === 'reverso') fotoreverso = true;
}

// ==========================
// 👨‍⚕️ Manejo de pacientes (AJAX con jQuery)
// ==========================
$(document).ready(function () {
    cargarPacientes('hoy');

    $('#filtroSelect').on('change', function () {
        let filtro = $(this).val();
        cargarPacientes(filtro);
    });

    function cargarPacientes(filtro = 'todo', page = 1, perPage = 100) {
        $.ajax({
            url: `/dmlist/public/pacientes/${filtro}`,
            method: 'GET',
            data: { page, per_page: perPage },
            success: function (data) {
                console.log("Respuesta del servidor:", data);
                let tabla = $('#tablaPacientes');
                let totalPacientes = $('#totalPacientes');
                let pagination = $('#pagination');
                totalPacientes.text(`Total: ${data.total}`);
                tabla.empty();
                if (data.data.length > 0) {
                    data.data.forEach(paciente => {
                        // 👉 Aquí armamos el botón según el campo atencionsiono
                    let botonAccion = '';

                    if (paciente.atencionsiono == 0) {
                        // Si NO se dejó atender, no hay botón
                        botonAccion = `<span class="badge bg-secondary">No atendido</span>`;
                    } else {
                        // Si se dejó atender, aparece Editar/Actualizar
                        botonAccion = `
                            <a href="/dmlist/public/pacientes/${paciente.N_Orden}/editar" 
                               class="btn btn-sm ${paciente.estado === 'pendiente' ? 'btn-warning' : 'btn-success'}">
                               ${paciente.estado === 'pendiente' ? 'Editar' : 'Actualizar'}
                            </a>
                        `;
                    }
                        tabla.append(`
                            <tr>
                                <td>${paciente.N_Orden ?? 'N/A'}</td>
                                <td>${paciente.Cedula ?? 'N/A'}</td>
                                <td>${paciente.Nombre_Completo ?? 'N/A'}</td>
                                <td>${paciente.Fecha_Estudio ?? 'N/A'}</td>
                                <td>${paciente.Entidad ?? 'N/A'}</td>
                                <td>${paciente.Lugar ?? 'N/A'}</td>
                                <td>${botonAccion}</td>
                            </tr>
                        `);
                    });
                } else {
                    tabla.append('<tr><td colspan="6">No hay pacientes para mostrar.</td></tr>');
                }
                pagination.html('');
                if (data.prev_page_url) {
                    pagination.append(`<button onclick="cargarPacientes('${filtro}', ${data.current_page - 1}, ${perPage})">Anterior</button>`);
                }
                pagination.append(` Página ${data.current_page} de ${data.last_page} `);
                if (data.next_page_url) {
                    pagination.append(`<button onclick="cargarPacientes('${filtro}', ${data.current_page + 1}, ${perPage})">Siguiente</button>`);
                }
            },
            error: function (xhr) {
                console.error("Error en AJAX:", xhr.responseText);
                alert("Hubo un error al obtener los datos.");
            }
        });
    }
});

// ==========================
// 🔎 Búsqueda
// ==========================
$('#buscarBtn').on('click', function () {
    let campo = $('#campoBusqueda').val();
    let valor = $('#valorBusqueda').val();
    $.ajax({
        url: `/dmlist/public/pacientes/buscar`,
        method: 'GET',
        data: { campo, valor },
        success: function (data) {
            let tabla = $('#tablaPacientes');
            let totalPacientes = $('#totalPacientes');
            totalPacientes.text(`Total: ${data.total}`);
            tabla.empty();
            if (data.pacientes.length > 0) {
                data.pacientes.forEach(paciente => {
                      // 👉 Aquí armamos el botón según el campo atencionsiono
                    let botonAccion = '';

                    if (paciente.atencionsiono == 0) {
                        // Si NO se dejó atender, no hay botón
                        botonAccion = `<span class="badge bg-secondary">No atendido</span>`;
                    } else {
                        // Si se dejó atender, aparece Editar/Actualizar
                        botonAccion = `
                            <a href="/dmlist/public/pacientes/${paciente.N_Orden}/editar" 
                               class="btn btn-sm ${paciente.estado === 'pendiente' ? 'btn-warning' : 'btn-success'}">
                               ${paciente.estado === 'pendiente' ? 'Editar' : 'Actualizar'}
                            </a>
                        `;
                    }
                    tabla.append(`
                        <tr>
                            <td>${paciente.N_Orden}</td>
                            <td>${paciente.Cedula}</td>
                            <td>${paciente.Nombre_Completo}</td>
                            <td>${paciente.Fecha_Estudio}</td>
                            <td>${paciente.Entidad}</td>
                            <td>${paciente.Lugar}</td>
                            <td>${botonAccion}</td>
                        </tr>
                    `);
                });
            } else {
                tabla.append('<tr><td colspan="6">No hay pacientes para mostrar.</td></tr>');
            }
        }
    });
});

// ==========================
// 📤 Exportación de archivo plano csv
// ==========================
document.querySelector('.exportarBtn').addEventListener('click', function (event) {
    event.preventDefault();
    const mensajeNotificacion = document.getElementById('mensajeNotificacion');
    mensajeNotificacion.style.display = 'none';
    fetch('/dmlist/public/pacientes/exportar')
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    mensajeNotificacion.textContent = data.message || 'No hay registros disponibles.';
                    mensajeNotificacion.style.display = 'block';
                    throw new Error(data.message);
                });
            }
            return response.blob().then(blob => {
                const disposition = response.headers.get('Content-Disposition');
                let filename = "export.csv";
                if (disposition && disposition.includes('filename=')) {
                    filename = disposition.split('filename=')[1].trim();
                }
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename.replace(/"/g, '');
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            });
        })
        .catch(error => console.error('Error en la exportación:', error));
});
// ==========================
// 📤 Exportación 4505 en Excel
// ==========================
document.querySelector('.exportarexcelBtn').addEventListener('click', function (event) {
    event.preventDefault();

    const mensajeNotificacion = document.getElementById('mensajeNotificacion');
    mensajeNotificacion.style.display = 'none';

    fetch('/dmlist/public/pacientes/exportar-4505')
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    mensajeNotificacion.textContent = data.message || 'No hay registros disponibles.';
                    mensajeNotificacion.style.display = 'block';
                    throw new Error(data.message);
                });
            }

            return response.blob().then(blob => {
                const disposition = response.headers.get('Content-Disposition');
                let filename = "formato_4505.xlsx";

                if (disposition && disposition.includes('filename=')) {
                    filename = disposition.split('filename=')[1].trim();
                }

                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename.replace(/"/g, '');
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            });
        })
        .catch(error => console.error('Error en la exportación 4505:', error));
});
// ==========================
// ✅ Validaciones
// ==========================
// Establecer fecha máxima en el campo de fecha de nacimiento
document.addEventListener("DOMContentLoaded", function () {
    let today = new Date().toISOString().split("T")[0];
    document.getElementById("nacimiento").setAttribute("max", today);
});
//borar ceros a la izquierda en el campo identificacion 
document.getElementById('identificacion').addEventListener('input', function () {
    this.value = this.value.replace(/^0+(\d)/, '$1');
});
// Convertir a mayúsculas y eliminar espacios al inicio en campos específicos
document.addEventListener("DOMContentLoaded", function () {
    const camposEspecificos = ["apellido1", "apellido2", "nombre", "nombre2", "entidad", "lugar", "direccion"];
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

// ==========================
// 📝 Manejo de formulario
// ==========================

//evitar envio doble del primer formulario
document.getElementById('miFormulario').addEventListener('submit', function (event) {
    let boton = document.getElementById('guardar');
    if (boton.disabled) {
        event.preventDefault(); // Evita el envío doble
    } else {
        boton.disabled = true;
    }
});
// ==========================
// Guardar selección de tecnología para el día actual
// ==========================
document.addEventListener('DOMContentLoaded', function () {
    const selectTecnologia = document.getElementById('tecnologa');
    const today = new Date().toISOString().split('T')[0];
    const storageKey = `tecnologa_seleccionada_${today}`;

    // Recuperar valor guardado
    const tecnologiaGuardada = localStorage.getItem(storageKey);

    if (tecnologiaGuardada && [...selectTecnologia.options].some(opt => opt.value === tecnologiaGuardada)) {
        selectTecnologia.value = tecnologiaGuardada;
    }

    // Guardar al cambiar
    selectTecnologia.addEventListener('change', function () {
        localStorage.setItem(storageKey, this.value);
    });

    // Limpiar claves viejas (otros días)
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key.startsWith('tecnologa_seleccionada_') && key !== storageKey) {
            localStorage.removeItem(key);
        }
    }
});


// ==========================
// ⏳ Cronómetro 2 min y deshabilitar botón guardar
// ==========================
let tiempo = 120;
const contador = document.getElementById("contador");
const btnGuardar = document.getElementById("guardar");

function actualizarContador() {
    let minutos = Math.floor(tiempo / 60);
    let segundos = tiempo % 60;
    minutos = minutos < 10 ? "0" + minutos : minutos;
    segundos = segundos < 10 ? "0" + segundos : segundos;
    contador.textContent = "Tiempo restante: " + minutos + ":" + segundos;
    if (tiempo > 0) {
        tiempo--;
    } else {
        btnGuardar.disabled = true;
        btnGuardar.style.backgroundColor = "gray";
        btnGuardar.style.cursor = "not-allowed";
        contador.textContent = "Tiempo agotado. Refresca el formulario.";
    }
}
setInterval(actualizarContador, 1000);

// ==========================
// Persistir Entidad y Lugar por día
// ==========================
document.addEventListener('DOMContentLoaded', function () {
    const entidadInput = document.getElementById('entidad');
    const lugarInput   = document.getElementById('lugar');

    const today = new Date().toISOString().split('T')[0];
    const storageKeyEntidad = `entidad_${today}`;
    const storageKeyLugar   = `lugar_${today}`;

    // Cargar valores guardados si existen
    const entidadGuardada = localStorage.getItem(storageKeyEntidad);
    const lugarGuardada   = localStorage.getItem(storageKeyLugar);

    if (entidadGuardada) entidadInput.value = entidadGuardada;
    if (lugarGuardada)   lugarInput.value = lugarGuardada;

    // Guardar al cambiar (cuando la tecnóloga edita una vez)
    entidadInput.addEventListener('change', function () {
        localStorage.setItem(storageKeyEntidad, this.value);
    });

    lugarInput.addEventListener('change', function () {
        localStorage.setItem(storageKeyLugar, this.value);
    });

    // Limpiar datos de días anteriores
    Object.keys(localStorage).forEach(key => {
        if (key.startsWith('entidad_') && key !== storageKeyEntidad) {
            localStorage.removeItem(key);
        }
        if (key.startsWith('lugar_') && key !== storageKeyLugar) {
            localStorage.removeItem(key);
        }
    });
});

