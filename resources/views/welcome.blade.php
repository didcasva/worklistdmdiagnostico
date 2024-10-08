<x-layout>
    <x-slot name="title">
        DM-LIST
    </x-slot>
    <header class="header">
        <div class="header-icons">
            <h1>REGISTRO DE PACIENTES</h1>
            <div class="account">
                <img src="/imgs/LOGO%20DM.png">
            </div>
        </div>
    </header>
    <div class="container">
        <nav>
            <form action="" class="form">
                <h1 class="title">INFORMACION PACIENTE</h1>
                <hr/>
                <div class="inputContainer">
                    <select name="id_tipo" id="tipo_doc">
                        <option value="CC">CEDULA</option>
                        <option value="TI">TARJETA DE IDENTIDAD</option>
                        <option value="CE">CEDULA EXTRANJERIA</option>
                        <option value="RC">REGISTRO CIVIL</option>
                        <option value="CI">CARNET IDENTIDADI</option>
                        <option value="PA">PASAPORTE</option>
                    </select>
                    <label for=" " class="label">Tipo de identificacion</label>
                </div>

                <div class="inputContainer">
                    <input type="number" class="input" placeholder="a" id="identificacion">
                    <label for="" class="label">Identificacion</label>
                </div>

                <div class="inputContainer">
                    <input type="text" id="apellido1" class="input" placeholder="a" PATTERN="[A-Z]">
                    <label for="" class="label">1er Apellido</label>
                </div>

                <div class="inputContainer">
                    <input type="text" id="apellido2" class="input" placeholder="a">
                    <label for="" class="label">2do Apellido</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="nombre" class="input" placeholder="a">
                    <label for="" class="label">1er Nombre</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="nombre2" class="input" placeholder="a">
                    <label for="" class="label">2do Nombre</label>
                </div>
                <div class="inputContainer">
                    <select name="est_tipo" id="sexo">
                        <option value="F">F</option>
                        <option value="M">M</option>
                    </select>
                    <label for="" class="label">Sexo</label>
                </div>
                <div class="inputContainer">
                    <input type="date" id="nacimiento" class="input"  min="1910-01-01" >
                    <label for="" class="label">Fecha de nacimiento</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="rh" class="input" placeholder="a">
                    <label for="" class="label">RH</label>
                </div>
                <div class="inputContainer">
                    <select name="est_tipo" id="estudio">
                        <option value="Primer Estudio">Primer estudio</option>
                        <option value="Mamografía bilateral">Mamografía bilateral</option>
                        <option value="Mamografía de control">Mamografía de control</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <label for="" class="label">Tipo de estudio</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="entidad" class="input" placeholder="a">
                    <label for="" class="label">Entidad</label>
                </div>
                <div class="inputContainer">
                    <input type="text" id="direccion" class="input" placeholder="a">
                    <label for="" class="label">Direccion</label>
                </div>
                <div class="inputContainer">
                    <input type="number" id="telefono" class="input" placeholder="a">
                    <label for="" class="label">Telefono</label>
                </div>
                <div class="buttonContainer">
                    <input type="submit" id="guardar" class="submitBtn" value="Guardar">
                    <input type="reset" class="resetBtn" value="Limpiar">
                </div>
            </form>
        </nav>
        <div class="main-body">
            <div class="container1">
                <h1>ADJUNTE DOCUMENTOS</h1>
                <hr/>
                <div class="card_container">
                    <div class="imagen">
                        <div class="titulo">FRENTE</div>
                        <div class="ftoCedula">
                            <img id="ftoFrenteId" src="/imgs/LOGO%20DM.png" >
                        </div>
                        <div class="fotoBtn">
                            <a>Tomar</a>
                        </div>
                    </div>

                    <div class="imagen">
                        <div class="titulo">REVERSO</div>
                        <div class="ftoCedula">
                            <img id="ftoReversoId" src="/imgs/LOGO%20DM.png" >
                        </div>
                        <div class="fotoBtn">
                            <a>Tomar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container2">
                <h1>PACIENTES</h1>
                <hr/>
                <div class="buttonContainer">
                    <input type="submit" class="hoyBtn" value="Hoy">
                    <input type="submit" class="todoBtn" value="Todo">
                    <input type="submit" class="pacBtn" value="Pacientes atendidas hoy">
                    <input type="submit" class="exportarBtn" value="Exportar">

                </div>
                <div class="buttonContainer">
                    <div class="filtroContainer">
                        <select name="est_tipo" id="lang">
                            <option value="Identificacion">Identificacion</option>
                            <option value="Fecha">Fecha</option>
                            <option value="Nombre">Nombre</option>
                            <option value="Apellido">Apellido</option>
                            <option value="Entidad">Entidad</option>
                        </select>
{{--                        <label for="" class="labelBuscar">Filtro</label>--}}
                    </div>
                    <div class="inputFiltroContainer">
                        <input type="text" class="input" placeholder="a">
                    </div>
                    <input type="submit" class="buscarBtn" value="Buscar">

                </div>
                <hr>
                <div class="patient_lists">
                    <div class="list">
                        <table>
                            <thead>
                            <tr>
                                <th>IDENTIFICACION</th>
                                <th>NOMBRE COMPLETO</th>
                                <th>FECHA DE NACIMIENTO</th>
                                <th>RH</th>
                                <th>ENTIDAD</th>
                                <th>TELEFONO</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>2, Aug, 2022</td>
                                <td>Sam Tonny</td>
                                <td>Premimum</td>
                                <td>$2000.00</td>
                                <td>3225046859</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>29, July, 2022</td>

                                <td>Code Info</td>
                                <td>Silver</td>
                                <td>$5,000.00</td>
                                <td>3125046859</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>15, July, 2022</td>

                                <td>Jhon David</td>
                                <td>Startup</td>
                                <td>$3000.00</td>
                                <td>3225046959</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>5, July, 2022</td>
                                <td>Salina Gomiz</td>
                                <td>Premimum</td>
                                <td>$7000.00</td>
                                <td>3225146859</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>29, June, 2022</td>
                                <td>Gomiz</td>
                                <td>Gold</td>
                                <td>$4000.00</td>
                                <td>3225066859</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>28, June, 2022</td>
                                <td>Elyana Jhon</td>
                                <td>Premimum</td>
                                <td>$2000.00</td>
                                <td>3225045859</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr/>

            </div>

        </div>
    </div>

    <hr/>
    <div CLASS="footer">© 2024 DM DIAGNOSTICO MEDICO SAS</div>

</x-layout>
