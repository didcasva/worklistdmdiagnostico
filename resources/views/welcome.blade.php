<x-layout>
    <x-slot name="title">
        DM-LIST
    </x-slot>
    <header class="header">
        <meta charset="UTF-8"> <!-- Aquí es donde colocas la etiqueta -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <div class="header-icons">
            <h1>REGISTRO DE PACIENTES DM DIAGNOSTICO MEDICO SAS</h1>
        </div>
    </header>
    <div class="container">
        <nav>
            <form id="miFormulario" action="{{ url('/pacientes') }}" method="POST" class="form" enctype="multipart/form-data"  >
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px;">
                        <h4 style="color: #d60b0b;">Oops! Algo salio mal:</h4>
                        <ul style="list-style-type: square; margin-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li style="font-size: 16px; color: #b71c1c;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px;">
                        {{ session('success') }}
                    </div>
                @endif
                <h1 class="title" >INFORMACIÓN PACIENTE</h1>
                <hr/>
                <div class="inputContainer">
                    <select name="id_tipo" id="tipo_doc" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="CC">CÉDULA DE CIUDADANIA</option>
                        <option value="TI">TARJETA DE IDENTIDAD</option>
                        <option value="CE">CÉDULA EXTRANJERIA</option>
                        <option value="RC">REGISTRO CIVIL</option>
                        <option value="CI">CARNET IDENTIDAD</option>
                        <option value="PA">PASAPORTE</option>
                        <option value="PE">PERMISO ESPECIAL</option>
                        <option value="PT">PERMISO TEMPORAL</option>
                    </select>
                    <label for="tipo_doc" class="label">Tipo de identificación</label>
                </div>

                <div class="inputContainer">
                    <input type="text" class="input" placeholder="a" id="identificacion" name="identificacion" required>
                    <label for="identificacion"  class="label">Identificación</label>
                </div>

                <div class="inputContainer">
                    <input type="text" id="apellido1" name="apellido1" class="input" placeholder="a" required >
                    <label for="apellido1"  class="label">1er Apellido</label>
                </div>

                <div class="inputContainer">
                    <input type="text" id="apellido2" name="apellido2" class="input" placeholder="a">
                    <label for="apellido2" class="label">2do Apellido</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="nombre" name="nombre" class="input" placeholder="a" required>
                    <label  for="nombre" class="label">1er Nombre</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="nombre2" name="nombre2" class="input" placeholder="a">
                    <label  for="nombre2" class="label">2do Nombre</label>
                </div>
                <div class="inputContainer">
                    <select name="sexo" id="sexo" required>
                        <option value="F">F</option>
                        <option value="M">M</option>
                    </select>
                    <label for="sexo" class="label">Sexo</label>
                </div>
                <div class="inputContainer">
    <input type="date" id="nacimiento" name="nacimiento" class="input" min="1930-01-01" required>
    <label for="nacimiento" class="label">Fecha de nacimiento</label>
</div>
                <div class="inputContainer">
                     <select id="rh" name="rh" required>
                         <option value="" selected disabled>Seleccione una opción</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
			<option value="NS">No Sabe</option>
                    </select>
                    <label for="rh" class="label">RH</label>
                </div>
                <div class="inputContainer">
                    <select name="est_tipo" id="estudio" required>
                        <option value="Primer Estudio">Primer estudio</option>
                        <option value="Mamografía bilateral">Mamografía bilateral</option>
                        <option value="Mamografía de control">Mamografía de control</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <label for="estudio" class="label">Tipo de estudio</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="entidad" name="entidad" class="input" placeholder="a" required>
                    <label for="entidad" class="label">Entidad</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="lugar" name="lugar" class="input" placeholder="a" required>
                    <label for="lugar" class="label">Lugar</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="direccion" name="direccion" class="input" placeholder="a" required>
                    <label for="direccion" class="label">Dirección</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="telefono" name="telefono" class="input" placeholder="a" required>
                    <label for="telefono" class="label">Teléfono</label>
                </div>
                <div class="inputContainer">
                    <select name="tecnologa" id="tecnologa" required>
                        <option value="" selected disabled>Seleccione la Tecnóloga</option>
                        @foreach($tecnologas as $tecnologa)
                            <option value="{{ $tecnologa->id }}">{{ $tecnologa->NombreCompleto }}</option>
                        @endforeach
                    </select>
                    <label for="tecnologa" class="label">Tecnóloga</label>
                </div>

                <div class="buttonContainer">
                    <input type="submit" id="guardar" name="guardar" class="submitBtn" value="Guardar">
                    <input type="reset" class="resetBtn" value="Limpiar">
                </div>
                <!-- Campos ocultos para enviar las imágenes -->
                <input type="hidden" name="frente" id="frenteInput" required>
                <input type="hidden" name="reverso" id="reversoInput" required>

            </form>
        </nav>
        <div class="main-body" >
            <div class="card_container">

                <!-- Vista previa de la cámara -->
                <div class="imagen">
                    <div class="titulo">CAMARA</div>
                    <div>
                        <video id="videoPreview" width="300" height="200" autoplay style="display:initial;"></video>
                        <canvas id="canvasPreview" width="300" height="200" style="display:none;" ></canvas>
                    </div>
                    <div class="buttonContainer">
                        <button type="button" id="btnActivarCamara" class="fotoBtn" onclick="toggleCamara()">Activar Cámara</button>
                    </div>
                </div>

                <!-- Div para captura del Frente -->
                <div class="imagen">
                    <div class="titulo">FRENTE</div>
                    <div class="ftoCedula">
                        <img id="ftoFrenteId" src="imgs/LOGO%20DM.png" style="display:initial; width:300px; height:200px;">
                    </div>
                    <div class="buttonContainer">
                        <button type="button" id="btnTomarFrente" class="fotoBtn" onclick="capturarImagen('frente')">Tomar Frente</button>
                    </div>
                </div>

                <!-- Div para captura del Reverso -->
                <div class="imagen">
                    <div class="titulo">REVERSO</div>
                    <div class="ftoCedula">
                        <img id="ftoReversoId" src="imgs/LOGO%20DM.png" style="display:initial; width:300px; height:200px;">
                    </div>
                    <div class="buttonContainer">
                        <button type="button" id="btnTomarReverso" class="fotoBtn" onclick="capturarImagen('reverso')">Tomar Reverso</button>
                    </div>
                </div>

            </div>

            <div class="container2">
                <h1>PACIENTES</h1>
                <hr/>
                <!-- Formulario de Filtro de Pacientes -->
                    <div class="buttonContainer">
                        <div class="filtroContainer">
                        <select name="filtro" id="filtroSelect">
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="todo">Todos los pacientes</option>
                            <option value="hoy">Pacientes atendidos hoy</option>
                            <option value="ayer">Pacientes atendidos ayer</option>
                        </select>
                        <label for="filtroSelect" class="label">Filtrar Pacientes</label>
                    </div>
                        <!-- Cantidad de Pacientes -->
                        <p id="totalPacientes">Total: </p>
                        <button class="exportarBtn">Exportar</button>
                        <p id="mensajeNotificacion" style="color: red; display: none;"></p> <!-- Para mensajes de error -->

                    </div>

                <div class="buttonContainer">
                    <div class="filtroContainer">
                        <select name="est_tipo" id="campoBusqueda">
                            <option value="Identificacion">Identificación</option>
                            <option value="Fecha">Fecha</option>
                            <option value="Nombre">Nombre</option>
                        </select>
                    </div>
                    <div class="inputFiltroContainer">
                        <input type="text" id="valorBusqueda" class="input" placeholder="Buscar">
                    </div>
                    <button type="submit" class="buscarBtn" id="buscarBtn" name="buscarBtn">Buscar</button>
                </div>
                <hr>
                <div class="patient_lists">
                    <div class="list">
                        <table>
                            <thead>
                            <tr>
                                <th>N. Orden</th>
                                <th>Cédula</th>
                                <th>Nombre Completo</th>
                                <th>Fecha de Estudio</th>
                                <th>Entidad</th>
                                <th>Lugar</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody id="tablaPacientes">
                            <tr><td colspan="6">Selecciona un filtro para ver los pacientes.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr/>
            </div>


        </div>
    </div>
    <div CLASS="footer">© 2025 DM DIAGNÓSTICO MÉDICO SAS By  didcasva and devRox11</div>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script>
        let stream; // Variable para guardar el stream de la cámara
        const videoPreview = document.getElementById('videoPreview');
        let isCameraActive = false; // Variable para verificar el estado de la cámara
        let fotofrente = false;
        let fotoreverso= false;

        // Función para activar/desactivar la cámara
        function toggleCamara() {
            const btnActivarCamara = document.getElementById('btnActivarCamara');

            if (!isCameraActive) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(s => {
                        stream = s;
                        videoPreview.srcObject = stream;
                        videoPreview.style.display = 'initial'; // Mostrar video
                        btnActivarCamara.textContent = 'Desactivar Cámara';
                        isCameraActive = true; // Actualizar estado
                    })
                    .catch(error => {
                        console.error("Error al activar la cámara:", error);
                        alert("No se pudo activar la cámara. Asegúrate de que no esté siendo utilizada por otra aplicación.");
                    });
            } else {
                // Detener la cámara y ocultar el video
                stream.getTracks().forEach(track => track.stop());
                videoPreview.style.display = 'hidden'; // Ocultar video
                btnActivarCamara.textContent = 'Activar Cámara';
                isCameraActive = false; // Actualizar estado
            }
        }

        // Función para capturar imagen (frente o reverso)
        function capturarImagen(tipo) {
            if (!isCameraActive) {
                alert("La cámara no está activa. Por favor, enciende la cámara antes de tomar la foto.");
                return;
            }

            const videoElement = videoPreview; // Usar videoPreview como fuente
            const canvas = document.createElement('canvas'); // Crear canvas temporal
            const context = canvas.getContext('2d');
            const imgElement = tipo === 'frente' ? document.getElementById('ftoFrenteId') : document.getElementById('ftoReversoId');
            const input = tipo === 'frente' ? document.getElementById('frenteInput') : document.getElementById('reversoInput');

            canvas.width = 300; // Establecer ancho
            canvas.height = 200; // Establecer altura

            // Tomar la imagen del video
            context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            imgElement.src = canvas.toDataURL('image/png'); // Guarda la imagen en base64
            imgElement.style.display = 'block'; // Muestra la imagen capturada
            input.value = imgElement.src; // Guarda la imagen en el input

            // Actualizar el estado de las variables fotofrente y fotoreverso
            if (tipo === 'frente') {
                fotofrente = true;
                // alert("Imagen de frente capturada");
            } else if (tipo === 'reverso') {
                fotoreverso = true;
                // alert("Imagen de reverso capturada");
            }
        }

    </script>

    <script>
   $(document).ready(function () {
    // Al cargar la página, mostrar los pacientes del día automáticamente
    cargarPacientes('hoy');

    // Cuando cambia el filtro, se recargan los pacientes
    $('#filtroSelect').on('change', function() {
        let filtro = $(this).val();
        cargarPacientes(filtro);
    });

    // Cargar pacientes según el filtro seleccionado
    function cargarPacientes(filtro = 'todo', page = 1, perPage = 100) {
        $.ajax({
            url: `{{ url('/pacientes') }}/${filtro}`,
            method: 'GET',
            data: { page: page, per_page: perPage }, // Agregamos paginación
            success: function(data) {
                console.log("Respuesta del servidor:", data);

                let tabla = $('#tablaPacientes');
                let totalPacientes = $('#totalPacientes');
                let pagination = $('#pagination'); // Contenedor de paginación

                // 🔹 Mostrar el total de pacientes en la BD
                totalPacientes.text(`Total: ${data.total}`);

                // 🔹 Limpia la tabla y la actualiza
                tabla.empty();
                if (data.data.length > 0) { // Laravel devuelve los datos en 'data'
                    data.data.forEach(paciente => {
                        tabla.append(`
                            <tr>
                                <td>${paciente.N_Orden ?? 'N/A'}</td>
                                <td>${paciente.Cedula ?? 'N/A'}</td>
                                <td>${paciente.Nombre_Completo ?? 'N/A'}</td>
                                <td>${paciente.Fecha_Estudio ?? 'N/A'}</td>
                                <td>${paciente.Entidad ?? 'N/A'}</td>
                                <td>${paciente.Lugar ?? 'N/A'}</td>
                                 <td>
                                    <a href="/dmlist/public/pacientes/${paciente.N_Orden}/editar" 
                                class="btn btn-sm ${paciente.estado === 'pendiente' ? 'btn-warning' : 'btn-success'}">
                                    ${paciente.estado === 'pendiente' ? 'Editar' : 'Actualizar'}
                                </a>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tabla.append('<tr><td colspan="6">No hay pacientes para mostrar.</td></tr>');
                }

                // 🔹 Actualizar botones de paginación
                pagination.html('');
                if (data.prev_page_url) {
                    pagination.append(`<button onclick="cargarPacientes('${filtro}', ${data.current_page - 1}, ${perPage})">Anterior</button>`);
                }
                pagination.append(` Página ${data.current_page} de ${data.last_page} `);
                if (data.next_page_url) {
                    pagination.append(`<button onclick="cargarPacientes('${filtro}', ${data.current_page + 1}, ${perPage})">Siguiente</button>`);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", xhr.responseText);
                alert("Hubo un error al obtener los datos.");
            }
        });
    }

    // 🔹 Ejecutar la búsqueda automáticamente después de guardar un paciente
    $('#guardarPacienteBtn').on('click', function() {
        $.ajax({
            url: `{{ url('/pacientes/guardar') }}`, // Ajusta la URL según tu endpoint en Laravel
            method: 'POST',
            data: $('#formularioPaciente').serialize(),
            success: function(response) {
                if (response.success) {
                    console.log("Paciente guardado correctamente.");
                    cargarPacientes('hoy'); // Recarga la lista automáticamente con los atendidos hoy
                } else {
                    alert("Error al guardar el paciente.");
                }
            },
            error: function(xhr) {
                console.error("Error al guardar el paciente:", xhr.responseText);
                alert("No se pudo guardar el paciente.");
            }
        });
    });
    });
    </script>
    <script>
        $('#buscarBtn').on('click', function() {
            let campo = $('#campoBusqueda').val();
            let valor = $('#valorBusqueda').val();
            console.log("Campo:", campo);
            console.log("Valor:", valor);
            $.ajax({
                url: `{{ url('/pacientes/buscar') }}`,
                method: 'GET',
                data: {
                    campo: campo,
                    valor: valor
                },
                success: function(data) {
                    let tabla = $('#tablaPacientes');
                    let totalPacientes = $('#totalPacientes');

                    // Actualiza el total de pacientes
                    totalPacientes.text(`Total: ${data.total}`);

                    // Limpia la tabla y la actualiza
                    tabla.empty();
                    if (data.pacientes.length > 0) {
                        data.pacientes.forEach(paciente => {
                            tabla.append(`
                            <tr>
                                <td>${paciente.N_Orden}</td>
                                <td>${paciente.Cedula}</td>
                                <td>${paciente.Nombre_Completo}</td>
                                <td>${paciente.Fecha_Estudio}</td>
                                <td>${paciente.Entidad}</td>
                                <td>${paciente.Lugar}</td>
                                <td>
                                <a href="/dmlist/public/pacientes/${paciente.N_Orden}/editar" 
                                class="btn btn-sm ${paciente.estado === 'pendiente' ? 'btn-warning' : 'btn-success'}">
                                    ${paciente.estado === 'pendiente' ? 'Editar' : 'Actualizar'}
                                </a>
                            </td>
                            </tr>
                        `);
                        });
                    } else {
                        tabla.append('<tr><td colspan="6">No hay pacientes para mostrar.</td></tr>');
                    }
                }
            });
        });
    </script>
    <script>
        document.querySelector('.exportarBtn').addEventListener('click', function (event) {
    event.preventDefault();

    const mensajeNotificacion = document.getElementById('mensajeNotificacion');
    mensajeNotificacion.style.display = 'none';

    fetch('{{ url('/pacientes/exportar') }}')
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    mensajeNotificacion.textContent = data.message || 'No hay registros disponibles para exportar.';
                    mensajeNotificacion.style.display = 'block';
                    throw new Error(data.message);
                });
            }
            return response.blob().then(blob => {
                // 📌 Extraemos el nombre desde el header Content-Disposition
                const disposition = response.headers.get('Content-Disposition');
                let filename = "export.csv"; // fallback por si no viene
                if (disposition && disposition.includes('filename=')) {
                    filename = disposition.split('filename=')[1].trim();
                }

                // Descarga el archivo con el nombre correcto
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename.replace(/"/g, ''); // limpia comillas si vienen
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            });
        })
        .catch(error => console.error('Error en la exportación:', error));
});


    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split("T")[0]; // Obtiene la fecha actual
            document.getElementById("nacimiento").setAttribute("max", today);
        });
    </script>
    <script>
        document.getElementById('identificacion').addEventListener('input', function (e) {
            // Elimina los ceros a la izquierda, pero permite el "0" solo si es el único dígito
            this.value = this.value.replace(/^0+(\d)/, '$1');
        });
    document.addEventListener("DOMContentLoaded", function () {
    // IDs de los campos específicos que queremos modificar
    const camposEspecificos = ["apellido1", "apellido2", "nombre", "nombre2","entidad","lugar","direccion"];

    camposEspecificos.forEach(id => {
        const campo = document.getElementById(id);
        if (campo) {
            campo.addEventListener("input", function () {
                this.value = this.value.toUpperCase().trimStart(); // Mayúsculas y quita espacios al inicio
            });

            campo.addEventListener("blur", function () {
                this.value = this.value.trim(); // Quita espacios al final al salir del campo
            });
        }
            });
        });


    </script>
    <script>
        document.getElementById('miFormulario').addEventListener('submit', function (event) {
            let boton = document.getElementById('guardar');
            if (boton.disabled) {
                event.preventDefault(); // Evita el envío doble
            } else {
                boton.disabled = true;
            }
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectTecnologia = document.getElementById('tecnologa');
        
        // Genera una clave única para hoy 
        const today = new Date().toISOString().split('T')[0];
        const storageKey = `tecnologa_seleccionada_${today}`;
        
        // Recupera la selección guardada para hoy
        const tecnologiaGuardada = localStorage.getItem(storageKey);
        
        if (tecnologiaGuardada) {
            selectTecnologia.value = tecnologiaGuardada;
        }
        
        // Guarda la selección cuando cambie
        selectTecnologia.addEventListener('change', function() {
            localStorage.setItem(storageKey, this.value);
        });
        
        // Opcional: Limpiar selecciones de días anteriores
        Object.keys(localStorage).forEach(key => {
            if (key.startsWith('tecnologa_seleccionada_') && key !== storageKey) {
                localStorage.removeItem(key);
            }
        });
    });
    </script>

</x-layout>
