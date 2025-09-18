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
    <div class="container-formulario">
        <div class="container-update">
        <nav class="nav">
            <h1>FICHA DEL PACIENTE</h1>

                <table class="table">
                    <tr><th>N. Orden</th><td>{{ $paciente->N_Orden }}</td></tr>
                    <tr><th>Cédula</th><td>{{ $paciente->Cedula }}</td></tr>
                    <tr><th>Nombre</th><td>{{ $paciente->Nombre_Completo }}</td></tr>
                    <tr><th>Entidad</th><td>{{ $paciente->Entidad }}</td></tr>
                    <tr><th>Lugar</th><td>{{ $paciente->Lugar }}</td></tr>
                    <tr><th>Estado</th><td data-estado="{{ $paciente->estado }}">
                     {{ ucfirst($paciente->estado) }}
                    </td></tr>
                    <tr><th>Hora Ingreso</th><  <td data-hora-ingreso="{{ \Carbon\Carbon::parse($paciente->HoraAtencion)->format('Y-m-d H:i:s') }}">
                     {{ \Carbon\Carbon::parse($paciente->HoraAtencion)->format('H:i') }}
                    </td></tr>
                    <tr><th>Hora Salida</th><td>{{ $paciente->horafin ? \Carbon\Carbon::parse($paciente->horafin)->format('H:i') : '-' }}</td></tr>
                </table>

               <form action="{{ route('pacientes.update', $paciente->N_Orden) }}" id="updateformulario" method="POST" class="form" enctype="multipart/form-data">
              @csrf


                <table class="tabla-vistas">
                    <thead>
                        <tr>
                            <th>Vista</th>
                            <th>KV</th>
                            <th>mAs</th>
                            <th>Espesor (mm)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>CCD</td>
                        <td><input type="number" name="CCDkv" value="{{ old('CCDkv', $paciente->CCDkv ?? 28) }}" min="20" max="35" required></td>
                        <td><input type="number" name="CCDmas" value="{{ old('CCDmas', $paciente->CCDmas ?? 80) }}" min="10" max="200" required></td>
                        <td><input type="number" name="CCDespesor" value="{{ old('CCDespesor', $paciente->CCDespesor) }}" min="1" max="1000" ></td>
                        </tr>
                        <tr>
                        <td>MLD</td>
                        <td><input type="number" name="MLDkv" value="{{ old('MLDkv', $paciente->MLDkv ?? 28) }}" min="20" max="35" required></td>
                        <td><input type="number" name="MLDmas" value="{{ old('MLDmas', $paciente->MLDmas ?? 80) }}" min="10" max="200" required></td>
                        <td><input type="number" name="MLDespesor" value="{{ old('MLDespesor', $paciente->MLDespesor) }}" min="1" max="1000" ></td>
                        </tr>
                        <tr>
                        <td>CCI</td>
                        <td><input type="number" name="CCIkv" value="{{ old('CCIkv', $paciente->CCIkv ?? 28) }}" min="20" max="35" required></td>
                        <td><input type="number" name="CCImas" value="{{ old('CCImas', $paciente->CCImas ?? 80) }}" min="10" max="200" required></td>
                        <td><input type="number" name="CCIespesor" value="{{ old('CCIespesor', $paciente->CCIespesor) }}" min="1" max="1000" ></td>
                        </tr>
                        <tr>
                        <td>MLI</td>
                        <td><input type="number" name="MLIkv" value="{{ old('MLIkv', $paciente->MLIkv ?? 28) }}" min="20" max="35" required></td>
                        <td><input type="number" name="MLImas" value="{{ old('MLImas', $paciente->MLImas ?? 80) }}" min="10" max="200" required></td>
                        <td><input type="number" name="MLIespesor" value="{{ old('MLIespesor', $paciente->MLIespesor) }}" min="1" max="1000" ></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tabla-vistas">
     
                <thead>
                    <tr>
                    <th colspan="2" style="text-align: center;">Implantes O Prótesis</th>
                    </tr>
                    <tr>
                        <th>Derecho</th>
                        <th>Izquierdo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label>
                                <input type="radio" name="lado_derecho" value="1" 
                                    {{ old('lado_derecho', $paciente->lado_derecho) == 1 ? 'checked' : '' }}>
                                Sí
                            </label>
                            <label>
                                <input type="radio" name="lado_derecho" value="0" 
                                    {{ old('lado_derecho', $paciente->lado_derecho) == 0 ? 'checked' : '' }}>
                                No
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="radio" name="lado_izquierdo" value="1" 
                                    {{ old('lado_izquierdo', $paciente->lado_izquierdo) == 1 ? 'checked' : '' }}>
                                Sí
                            </label>
                            <label>
                                <input type="radio" name="lado_izquierdo" value="0" 
                                    {{ old('lado_izquierdo', $paciente->lado_izquierdo) == 0 ? 'checked' : '' }}>
                                No
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>


    <div class="inputContainer">
        <input type="number" id="numeroplacas" name="numeroplacas" class="input"
               value="{{ old('numeroplacas', $paciente->numeroplacas) }}"
               min="1" max="16" required>
        <label for="numeroplacas" class="label">Número De Placas</label>
    </div>

    <div class="inputContainer">
        <input type="text" id="observaciones" name="observaciones" class="input"
               value="{{ old('observaciones', $paciente->observaciones) }}">
        <label for="observaciones" class="label">Observaciones (Opcional)</label>
    </div>

    <div class="buttonContainer2">
        <input type="submit" class="submitBtn" value="Guardar" id="btnguardar">
    </div>
</form>

        </nav>
         </div>
    </div>

        
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/update.js') }}"></script>
</x-layout>