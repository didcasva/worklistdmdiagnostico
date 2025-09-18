<x-layout>
    <x-slot name="title">
        DM-LIST
    </x-slot>
    <header class="header">
        <meta charset="UTF-8"> <!-- Aquí es donde colocas la etiqueta -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <div id="contador" 
            style="font-weight: bold; font-size: 20px; color: red; text-align: left;">
            Tiempo restante: 02:00
        </div>
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
    <script src="{{ asset('js/app.js') }}"></script>




</x-layout>
