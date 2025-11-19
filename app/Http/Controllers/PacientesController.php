<?php

namespace App\Http\Controllers;

use App\Models\N_PATIENT;
use App\Models\REQUESTED_PROCEDURE;
use App\Models\SCHED_PROC_STEP;
use App\Models\SERVICE_REQUEST;
use App\Models\Tecnologa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\UnidadMovil;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Symfony\Component\HttpFoundation\StreamedResponse;

// importar modelo unidad movil
class PacientesController extends Controller
{
    public function index()
    {     
         return view('welcome'); 
    }

    public function pacientes(Request $request, $filtro = null)
    {
        $today = Carbon::today()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();
        
        // Obtener el número de registros por página (default: 100)
        $perPage = $request->input('per_page', 100);
    
        // 🔹 Definir columnas a seleccionar
        $columns = [
            'id_log',
            'N_Orden',
            'Cedula',
            'Nombre_Completo',
            'Fecha_Estudio',
            'Entidad',
            'Lugar',
            'estado',
            'atencionsiono'
        ];
    
        switch ($filtro) {
            case 'hoy':
                $query = Paciente::select($columns)->whereDate('Fecha_Estudio', $today);
                break;
            case 'ayer':
                $query = Paciente::select($columns)->whereDate('Fecha_Estudio', $yesterday);
                break;
            case 'todo':
            default:
                $query = Paciente::select($columns);
                break;
        }
    
        // Aplicar paginación en la consulta
        $pacientes = $query->orderBy('id_log', 'desc')->paginate($perPage);
    

        return response()->json($pacientes);
    }
    



    public function buscar(Request $request)
    {
        $campo = $request->input('campo');
        $valor = $request->input('valor');

        $columns = [
            'id_log',
            'N_Orden',
            'Cedula',
            'Nombre_Completo',
            'Fecha_Estudio',
            'Entidad',
            'Lugar',
            'atencionsiono',
        ];

        $query = Paciente::select($columns);

        // Detecta si el campo es Fecha y convierte el formato
        if ($campo === 'Fecha') {
            try {
                $valor = Carbon::createFromFormat('d-m-Y', $valor)->format('Y-m-d');
            } catch (\Exception $e) {
                try {
                    $valor = Carbon::createFromFormat('d/m/Y', $valor)->format('Y-m-d');
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Formato de fecha incorrecto'], 400);
                }
            }
        }
        // Valida que el campo sea uno de los permitidos
        if (in_array($campo, ['Identificacion', 'Fecha', 'Nombre']) && $valor) {
            if ($campo === 'Identificacion') {
                $query->where('Cedula', $valor);
            } elseif ($campo === 'Fecha') {
                $query->whereDate('Fecha_Estudio', $valor);
            } elseif ($campo === 'Nombre') {
                $query->where('Nombre_Completo', 'like', "%{$valor}%");
            }
        }

        $pacientes = $query->orderBy('id_log', 'desc')->get();
         // Convertir caracteres antes de devolver la respuesta
 
       // dd($pacientes);
        return response()->json([
            'total' => $pacientes->count(),
            'pacientes' => $pacientes // Ya no usamos json_encode para evitar null
        ]);
    }
    public function store(Request $request)
    {
        
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'id_tipo' => 'required|string|max:2',
            'identificacion' => 'required|string',
            'apellido1' => 'required|string|max:50',
            'apellido2' => 'nullable|string|max:50',
            'nombre' => 'required|string|max:50',
            'nombre2' => 'nullable|string|max:50',
            'sexo' => 'required|string|max:1',
            'nacimiento' => 'required|date|before_or_equal:today',
            'rh' => 'required|string|max:3',
            'est_tipo' => 'required|string|max:50',
            'entidad' => 'required|string|max:100',
            'lugar' => 'required|string|max:100',
            'direccion' => 'required|string|max:120',
            'telefono' => 'required|string|max:50',
            'frente' => 'required|string',
            'reverso' => 'required|string',
            'tecnologa' => 'required|string',
        ], [
            'id_tipo.required' => 'El tipo de identificación es obligatorio.',
            'id_tipo.max' => 'El tipo de identificación no puede tener más de 2 caracteres.',
            'identificacion.required' => 'La identificación es obligatoria.',
            'apellido1.required' => 'El primer apellido es obligatorio.',
            'apellido1.max' => 'El primer apellido no puede tener más de 50 caracteres.',
            'apellido2.max' => 'El segundo apellido no puede tener más de 50 caracteres.',
            'nombre.required' => 'El primer nombre es obligatorio.',
            'nombre.max' => 'El primer nombre no puede tener más de 50 caracteres.',
            'nombre2.max' => 'El segundo nombre no puede tener más de 50 caracteres.',
            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.max' => 'El sexo no puede tener más de 1 carácter.',
            'nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'before_or_equal' => 'El campo fecha de nacimiento debe ser una fecha anterior o igual a hoy.',
            'rh.required' => 'El grupo sanguíneo es obligatorio.',
            'rh.max' => 'El grupo sanguíneo no puede tener más de 3 caracteres.',
            'est_tipo.required' => 'El tipo de estado es obligatorio.',
            'est_tipo.max' => 'El tipo de estado no puede tener más de 50 caracteres.',
            'entidad.required' => 'La entidad es obligatoria.',
            'entidad.max' => 'La entidad no puede tener más de 100 caracteres.',
            'lugar.required' => 'El lugar es obligatorio.',
            'lugar.max' => 'El lugar no puede tener más de 100 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede tener más de 120 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede tener más de 50 caracteres.',
            'frente.required'=> 'Falta Foto del documento FRENTE',
            'frente.image'=> 'Falta Foto del documento FRENTE',
            'reverso.image'=> 'Falta Foto del Documento REVERSO',
            'reverso.required'=> 'Falta Foto del Documento REVERSO',
            'tecnologa.required' => 'Falta Selecionar Tecnologa',
            ]);
            
    try {
        // Obtener datos de la tabla UNIDADMOVIL
        $unidadMovil = UnidadMovil::first();
        if (!$unidadMovil) {
            return back()->withErrors('No se encontró la unidad móvil.');
        }
        $logid =Paciente::count() + 1;
        // Concatenar MOVIL y contador para N_Orden
        $contador = $unidadMovil->contador;
        $nOrden = $unidadMovil->unidad .'-' . $contador;
        // Crear el nombre completo en el backend
        $apellido1 = trim($request->apellido1);
        $apellido2 = trim($request->apellido2);
        $nombre = trim($request->nombre);
        $nombre2 = trim($request->nombre2);
        // Verificar si apellido2 y nombre2 están vacíos
        $nombreCompleto = $apellido1;
        if (!empty($apellido2)) {
            $nombreCompleto .= ' ' . $apellido2;
        }
        $nombreCompleto .= ' ' . $nombre;
        if (!empty($nombre2)) {
            $nombreCompleto .= ' ' . $nombre2;
        }

        // Resultado con nombre completo formateado
        $nombreCompleto = trim($nombreCompleto);
        // Calcular la edad
        $fechaNacimiento = $request->nacimiento;
        $edad = \Carbon\Carbon::parse($fechaNacimiento)->age;
        // Extraer día, mes y año
        $fechaNacimiento = \Carbon\Carbon::parse($request->input('nacimiento'));
        $dia = $fechaNacimiento->day;
        $mes = $fechaNacimiento->month;
        $ano = $fechaNacimiento->year;
        // Obtén la fecha actual para la carpeta
        $fecha = date('dmY'); // 28102024


        $documentoPaciente = strtoupper(trim($request->identificacion));;

        // Define la ruta para guardar las imágenes
        $rutaBase = "public/cedulas/$fecha/$documentoPaciente";

        // Guarda el frente de la imagen
        $frentePath = $this->saveBase64Image($request->input('frente'), "$rutaBase/foto1.png");
        // Buscar la tecnóloga que atendió al paciente usando id
        $tecnologa = Tecnologa::where('id', $request->tecnologa)->first();
        // Guarda el reverso de la imagen
        $reversoPath = $this->saveBase64Image($request->input('reverso'), "$rutaBase/foto2.png");
         // Insertar el nuevo paciente en la base de datos
        $paciente = new Paciente();
        $paciente-> Id_Log = $logid;
        $paciente-> N_Orden = $nOrden;
        $paciente->Tipo_Documento = $request->id_tipo;
        $paciente->Cedula = strtoupper(trim($request->identificacion));
        $paciente->P_Apellido = strtoupper(trim($request->apellido1));
        $paciente->S_Apellido = strtoupper(trim($request->apellido2));
        $paciente->P_Nombre = strtoupper(trim($request->nombre));
        $paciente->S_Nombre = strtoupper(trim($request->nombre2));
        $paciente->Sexo = strtoupper($request->sexo);
        $paciente->Fecha_Nacimiento = $fechaNacimiento;
        $paciente->Edad = $edad;
        $paciente->Dia = $dia;
        $paciente->Mes = $mes;
        $paciente->Ano = $ano;
        $paciente->Rh = strtoupper(trim($request->rh));
        $paciente->Tipo_Estudio = strtoupper($request->est_tipo);
        $paciente->Fecha_Estudio = \Carbon\Carbon::now();
        $paciente->HoraAtencion = Carbon::now()->format('H:i:s');
        $paciente->Entidad = strtoupper(trim($request->entidad));
        $paciente->Lugar =strtoupper(trim($request->lugar));
        $paciente->Nombre_Completo = strtoupper($nombreCompleto);
        $paciente->Direccion = strtoupper(trim($request->direccion));
        $paciente->Telefono =  strtoupper(trim($request->telefono));
        // Asignar la tecnóloga si se encontró
        if ($tecnologa) {
        $paciente->tecnologa_id = $tecnologa->id;
        }
        // Guardar el paciente
        $paciente->save();
        //Incrementar el contador en UNIDADMOVIL
        $unidadMovil->contador += 1; // Asegúrate de que este campo exista y sea un entero
        $unidadMovil->save();

        // Aquí empieza la inserción en la tabla N_PATIENT
        $apellido1 = strtoupper(trim($request->apellido1));
        $apellido2 = !empty(trim($request->apellido2)) ? strtoupper(trim($request->apellido2)) : ''; // Verifica si está vacío
        $nombre1 = strtoupper(trim($request->nombre));
        $nombre2 = !empty(trim($request->nombre2)) ? strtoupper(trim($request->nombre2)) : ''; // Verifica si está vacío
        $nPatient = new N_PATIENT();
        $nPatient->patient_id = $request->identificacion; // Cedula
        $nPatient->patient_name = "{$apellido1}" . (!empty($apellido2) ? " {$apellido2}" : "") . "^{$nombre1}" . (!empty($nombre2) ? " {$nombre2}" : "");
        $nPatient->birth_date = $request->nacimiento; // Fecha de nacimiento
        $nPatient->sex =strtoupper($request->sexo) ; // Sexo
        // Guarda en N_PATIENT
        $nPatient->save();

        // Aquí empieza la inserción en la tabla SERVICE_REQUEST
        $serviceRequest = new SERVICE_REQUEST();
        $serviceRequest->accession_number = $nOrden;
        // Guarda en SERVICE_REQUEST
        $serviceRequest->save();

        // Generar el study_instance_uid
        $baseId = '12345.';
        $staticPart = '204';
        $timestamp = Carbon::now()->format('md.Y.H.i.s.u'); // Usar Carbon para el formato
        $studyInstanceUid = $baseId . $staticPart . '.' . $timestamp;
        // Insertar en REQUESTED_PROCEDURE
        $requestedProcedure = new REQUESTED_PROCEDURE();
        $requestedProcedure->study_instance_uid = $studyInstanceUid; // Usar el UID generado
        $requestedProcedure->service_request_id = $serviceRequest->id; // Usar el id de SERVICE_REQUEST
        $requestedProcedure->patient_internal_id = $nPatient->id; // Usar el id de N_PATIENT
        // Guarda en REQUESTED_PROCEDURE
        $requestedProcedure->save();

        // Ahora insertar en SCHED_PROC_STEP
        $schedProcStep = new SCHED_PROC_STEP();
        $schedProcStep->modality = 'MG'; // Establecer modalidad por defecto
        $schedProcStep->scheduled_station_ae_title = $unidadMovil->unidad;
        $schedProcStep->start_date_time = Carbon::now(); // Establecer la fecha y hora actual
        $schedProcStep->sched_proc_step_id = 'SPSID1'; // Asumir que es un valor fijo o el que necesites
        $schedProcStep->req_proc_id = $requestedProcedure->id; // Usar el id de REQUESTED_PROCEDURE

        // Guarda en SCHED_PROC_STEP
        $schedProcStep->save();
        // Obtener pacientes del día actual
        $pacientesHoy = Paciente::whereDate('Fecha_Estudio', Carbon::today())->get();

       // Redirigir directamente al formulario de edición
        return redirect()->route('pacientes.edit', $paciente->N_Orden)
                     ->with('success', 'Paciente guardado exitosamente, ahora completa la atención.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Ocurrió un error al guardar los datos: ' . $e->getMessage()]);

    }
    }
    // Función para convertir Base64 a binario
    protected function saveBase64Image($base64Image, $path)
    {
        // Decodifica la imagen en base64
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

        // Guarda la imagen en el almacenamiento
        Storage::put($path, $imageData);

        // Devuelve la ruta de acceso público para la imagen
        return Storage::url($path);
    }
    public function edit($N_Orden)
    {
        $paciente = Paciente::where('N_Orden', $N_Orden)->firstOrFail();
    return view('indice', compact('paciente'));
    }

    public function update(Request $request, $N_Orden)
        {
        $request->validate([
        'CCDkv' => 'nullable|integer|min:20|max:35',
        'CCDmas' => 'nullable|integer|min:10|max:200',
        'MLDkv' => 'nullable|integer|min:20|max:35',
        'MLDmas' => 'nullable|integer|min:10|max:200',
        'CCIkv' => 'nullable|integer|min:20|max:35',
        'CCImas' => 'nullable|integer|min:10|max:200',
        'MLIkv' => 'nullable|integer|min:20|max:35',
        'MLImas' => 'nullable|integer|min:10|max:200',
        'numeroplacas' => 'nullable|integer|min:1|max:16',
        'observaciones' => 'nullable|string|max:255',
        'CCDespesor' => 'nullable|integer|min:1|max:1000',
        'MLDespesor' => 'nullable|integer|min:1|max:1000',
        'CCIespesor' => 'nullable|integer|min:1|max:1000',
        'MLIespesor' => 'nullable|integer|min:1|max:1000',
        'lado_derecho' => 'nullable|boolean',
        'lado_izquierdo' => 'nullable|boolean',
        'atencionsiono' => 'required|boolean',
        ]);
            // función que calcula dosis para cualquier vista
        function calcularDosis($kv, $mas, $espesor_cm, $calibracion = 0.09998, $ffa = 1.000) {
            if (is_null($kv) || is_null($mas) || is_null($espesor_cm) || $espesor_cm <= 0) {
                return null; // Retorna null si falta algún dato o espesor es inválido
            }
            // cálculo de dosis
            $fk  = 0.1046 * $kv - 1.9518;
            $inv = pow((60 / (60 - $espesor_cm)), 2);
            $dosis = $fk * $inv * $mas * $ffa * $calibracion;

            return $dosis;
        }

        $paciente = Paciente::findOrFail($N_Orden); 
       
     // Caso: Paciente NO se dejó atender
        if ($request->atencionsiono == false) {
            $paciente->atencionsiono = false;
            $paciente->estado = 'completado';
            $paciente->observaciones = 'El paciente NO se dejó atender';
            $paciente->horafin = Carbon::now()->format('H:i:s');
            $paciente->save();
            return redirect('/')->with('success', 'Paciente marcado como NO atendido.');
        }
        // Caso: Paciente se atendió, validar campos obligatorios
        $paciente->CCDkv = $request->CCDkv;
        $paciente->CCDmas = $request->CCDmas;
        $paciente->MLDkv = $request->MLDkv;
        $paciente->MLDmas = $request->MLDmas;
        $paciente->CCIkv = $request->CCIkv;
        $paciente->CCImas = $request->CCImas;
        $paciente->MLIkv = $request->MLIkv;
        $paciente->MLImas = $request->MLImas;
        $paciente->CCDespesor = $request->CCDespesor;
        $paciente->MLDespesor = $request->MLDespesor;
        $paciente->CCIespesor = $request->CCIespesor;
        $paciente->MLIespesor = $request->MLIespesor;
        $paciente->CCDdosis = calcularDosis($request->CCDkv, $request->CCDmas, $request->CCDespesor);
        $paciente->MLDdosis = calcularDosis($request->MLDkv, $request->MLDmas, $request->MLDespesor);
        $paciente->CCIdosis = calcularDosis($request->CCIkv, $request->CCImas, $request->CCIespesor);
        $paciente->MLIdosis = calcularDosis($request->MLIkv, $request->MLImas, $request->MLIespesor);
        $paciente->total_dosis = ($paciente->CCDdosis ?? 0) + ($paciente->MLDdosis ?? 0) + ($paciente->CCIdosis ?? 0) + ($paciente->MLIdosis ?? 0);
        $paciente->lado_derecho = $request->lado_derecho;
        $paciente->lado_izquierdo = $request->lado_izquierdo;
        $paciente->numeroplacas = $request->numeroplacas;
        $paciente->observaciones = strtoupper(trim($request->observaciones));
        if ($paciente->estado === 'pendiente') {
        $paciente->horafin = Carbon::now()->format('H:i:s');
        $paciente->estado = 'completado';
        }
        $paciente->save();

        return redirect('/')->with('success', 'Paciente actualizado correctamente.');

    }


    
    public function exportar()
    {
        // Obtén la fecha de hoy
        $hoy = Carbon::today()->toDateString();
        
        // 🔹 Obtén la unidad desde la tabla unidamovil
        $unidad = UnidadMovil::value('unidad'); // asume que solo hay 1 registro
        if (!$unidad) {
            return response()->json([
                'message' => 'No se encontró unidad en la base de datos.'
            ], 404);
        }
        // Filtra los registros de la tabla `pacientes` por la fecha de hoy en `Fecha_Estudio` y la tecnologa
        $pacientes = Paciente::with('tecnologa')
        ->whereDate('Fecha_Estudio', $hoy)
        ->get();
        // Verifica si hay registros para exportar
        if ($pacientes->isEmpty()) {
            return response()->json([
                'message' => 'No hay registros disponibles para exportar en la fecha seleccionada.'
            ], 404);
        }
        // Validar que todos los pacientes estén en estado "completado"
        $pendientes = $pacientes->where('estado', 'pendiente');
        if ($pendientes->isNotEmpty()) {
            return response()->json([
                'message' => 'Existen pacientes en estado pendiente. Todos deben estar completados antes de exportar.'
            ], 400);
        }
        // Define los encabezados del archivo CSV
        $columnHeaders = [
            'N_Orden',
            'Tipo_Documento',
            'Cedula',
            'P_Apellido',
            'S_Apellido',
            'P_Nombre',
            'S_Nombre',
            'Sexo',
            'Ano',
            'Mes',
            'Dia',
            'Rh',
            'Edad',
            'FechaNacimiento',
            'Entidad',
            'Lugar',
            'Fecha_Estudio',
            'HoraAtencion',
            'Direccion',
            'Telefono',
            'Tecnologa_CodigoRM',
            'Tecnologa_NumDocumento',
            'Tecnologa_NombreCompleto',
            'FechaHoraAtencion',
            'FechaHoraSalida',
            'HoraFin',
            'NumeroPlacas',
            'MinutosAtencion',
            'Observaciones',
            'CCDkv',
            'CCDmas',
            'CCDdosis',
            'MLDkv',
            'MLDmas',
            'MLDdosis',
            'CCIkv',
            'CCImas',
            'CCIdosis',
            'MLIkv',
            'MLImas',
            'MLIdosis',
            'total_dosis',
            'CCDespesor',
            'MLDespesor',
            'CCIespesor',
            'MLIespesor',
            'Lado_Derecho',
            'Lado_Izquierdo'
        ];

        // Genera el contenido del archivo CSV
        $callback = function() use ($pacientes, $columnHeaders) {
            $file = fopen('php://output', 'w');

            // Escribe los encabezados
            fputcsv($file, $columnHeaders);

            // Escribe cada fila de la consulta en el archivo
            foreach ($pacientes as $paciente) {
                // Concatenar fecha y hora en un solo campo
                $fechaHoraAtencion = \Carbon\Carbon::parse($paciente->Fecha_Estudio . ' ' . $paciente->HoraAtencion)->format('d/m/Y H:i');
                $fechaHoraSalida = \Carbon\Carbon::parse($paciente->Fecha_Estudio . ' ' . $paciente->horafin)->format('d/m/Y H:i');
                $fechanacimieto = \Carbon\Carbon::createFromDate(
                    $paciente->Ano,
                    $paciente->Mes,
                    $paciente->Dia
                )->format('d/m/Y');
                $horaInicio = Carbon::parse($paciente->HoraAtencion);
                $horaFin = Carbon::parse($paciente->horafin);
                // Diferencia en minutos
                $minutosAtencion = $horaInicio->diffInMinutes($horaFin);
                fputcsv($file, [
                    $paciente->N_Orden,
                    $paciente->Tipo_Documento,
                    $paciente->Cedula,
                    $paciente->P_Apellido,
                    $paciente->S_Apellido,
                    $paciente->P_Nombre,
                    $paciente->S_Nombre,
                    $paciente->Sexo,
                    $paciente->Ano,
                    $paciente->Mes,
                    $paciente->Dia,
                    $paciente->Rh,
                    $paciente->Edad,
                    $fechanacimieto,
                    $paciente->Entidad,
                    $paciente->Lugar,
                    $paciente->Fecha_Estudio,
                    $paciente->HoraAtencion,
                    $paciente->Direccion,
                    $paciente->Telefono,
                    $paciente->tecnologa->CodigoRM,
                    $paciente->tecnologa->NumDocumento,
                    $paciente->tecnologa->NombreCompleto,
                    $fechaHoraAtencion,
                    $fechaHoraSalida,
                    $paciente->horafin,
                    $paciente->numeroplacas,
                    $minutosAtencion,
                    $paciente->observaciones,
                    $paciente->CCDkv,
                    $paciente->CCDmas,
                    number_format($paciente->CCDdosis, 2),   // <-- 2 decimales
                    $paciente->MLDkv,
                    $paciente->MLDmas,
                    number_format($paciente->MLDdosis, 2),   // <-- 2 decimales
                    $paciente->CCIkv,
                    $paciente->CCImas,
                    number_format($paciente->CCIdosis, 2),   // <-- 2 decimales
                    $paciente->MLIkv,
                    $paciente->MLImas,
                    number_format($paciente->MLIdosis, 2),   // <-- 2 decimales
                    number_format($paciente->total_dosis, 2),// <-- 2 decimales
                    $paciente->CCDespesor,
                    $paciente->MLDespesor,
                    $paciente->CCIespesor,
                    $paciente->MLIespesor,
                    $paciente->lado_derecho ? 'Si' : 'No',
                    $paciente->lado_izquierdo ? 'Si' : 'No',
                ]);
            }

            fclose($file);
        };
        // 🔹 Usa la unidad en el nombre del archivo
        $filename = "pacientes_{$unidad}_{$hoy}.csv";
        // Retorna el archivo CSV para descarga
       return Response::stream($callback, 200, [
        "Content-Type" => "application/csv",
        "Content-Disposition" => "attachment; filename={$filename}",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ]);
    }
    public function exportar4505()
    {
        // Fecha de hoy
        $hoy = Carbon::today()->toDateString();
        $ano = Carbon::now()->year;

        // Unidad móvil
        $unidad = UnidadMovil::value('unidad');
        if (!$unidad) {
            return response()->json([
                'message' => 'No se encontró unidad en la base de datos.'
            ], 404);
        }

        // Mismos pacientes que usas para el CSV
        $pacientes = Paciente::with('tecnologa')
            ->whereDate('Fecha_Estudio', $hoy)
            ->get();

        if ($pacientes->isEmpty()) {
            return response()->json([
                'message' => 'No hay registros disponibles para exportar en la fecha seleccionada.'
            ], 404);
        }

        // Validar estados
        $pendientes = $pacientes->where('estado', 'pendiente');
        if ($pendientes->isNotEmpty()) {
            return response()->json([
                'message' => 'Existen pacientes en estado pendiente. Todos deben estar completados antes de exportar.'
            ], 400);
        }

        // Ruta plantilla
        $templatePath = storage_path('app/plantillas/4505_BASE.xlsx');
        if (!file_exists($templatePath)) {
            return response()->json([
                'message' => 'No se encontró la plantilla 4505_BASE.xlsx en storage/app/plantillas.'
            ], 500);
        }

        // Cargar plantilla
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getSheetByName('BASE') ?? $spreadsheet->getActiveSheet();

        // En tu plantilla, los encabezados están en la fila 8/9.
        // Los datos empiezan en la fila 10.
        $row = 10;
        $consecutivo = 1;

        foreach ($pacientes as $paciente) {

            // 📅 Fechas y tiempos (lo mismo que hacías en CSV)
            $fechaHoraAtencion = Carbon::parse($paciente->Fecha_Estudio . ' ' . $paciente->HoraAtencion);
            $fechaHoraSalida   = Carbon::parse($paciente->Fecha_Estudio . ' ' . $paciente->horafin);

            $fechanacimieto = Carbon::createFromDate(
                $paciente->Ano,
                $paciente->Mes,
                $paciente->Dia
            );

            $horaInicio = Carbon::parse($paciente->HoraAtencion);
            $horaFin    = Carbon::parse($paciente->horafin);
            $minutosAtencion = $horaInicio->diffInMinutes($horaFin);

            // 🔢 A: Consecutivo
            $sheet->setCellValue("A{$row}", $consecutivo);

            // B: No. Orden
            $sheet->setCellValue("B{$row}", $paciente->N_Orden);

            // C: Tipo de Documento
            $sheet->setCellValue("C{$row}", $paciente->Tipo_Documento);

            // D: Número
            $sheet->setCellValue("D{$row}", $paciente->Cedula);

            // E–H: Nombres y apellidos
            $sheet->setCellValue("E{$row}", $paciente->P_Apellido);
            $sheet->setCellValue("F{$row}", $paciente->S_Apellido);
            $sheet->setCellValue("G{$row}", $paciente->P_Nombre);
            $sheet->setCellValue("H{$row}", $paciente->S_Nombre);

            // I: Sexo
            $sheet->setCellValue("I{$row}", $paciente->Sexo);

            // J–L: Año, Mes, Día de nacimiento (grupo "Fecha De Nacimiento")
            $sheet->setCellValue("J{$row}", $paciente->Ano);
            $sheet->setCellValue("K{$row}", $paciente->Mes);
            $sheet->setCellValue("L{$row}", $paciente->Dia);

            // M: RH
            $sheet->setCellValue("M{$row}", $paciente->Rh);

            // N: Edad
            $sheet->setCellValue("N{$row}", $paciente->Edad);

            // O: FECHA DE NACIMIENTO (fecha completa en tipo fecha Excel)
            $sheet->setCellValue("O{$row}", ExcelDate::PHPToExcel($fechanacimieto));
            $sheet->getStyle("O{$row}")
                ->getNumberFormat()
                ->setFormatCode('dd/mm/yyyy');

            // P: Tipo de Estudio (si tienes ese campo en la tabla, si no, déjalo en null)
            $sheet->setCellValue("P{$row}", $paciente->Tipo_Estudio ?? null);

            // Q: Entidad
            $sheet->setCellValue("Q{$row}", $paciente->Entidad);

            // R: Lugar
            $sheet->setCellValue("R{$row}", $paciente->Lugar);

            // S: Nombre Completo (lo armamos aquí)
            $sheet->setCellValue("S{$row}", trim(
                "{$paciente->P_Nombre} {$paciente->S_Nombre} {$paciente->P_Apellido} {$paciente->S_Apellido}"
            ));

            // T–U: Resultado de Mamografía / BI-RADS (si tienes esos campos, si no quedan vacíos)
            // $sheet->setCellValue("T{$row}", $paciente->resultado_mamografia ?? null);
            // $sheet->setCellValue("U{$row}", $paciente->birads ?? null);

            // V: Fecha de estudio
            $sheet->setCellValue("V{$row}", ExcelDate::PHPToExcel(
                Carbon::parse($paciente->Fecha_Estudio)
            ));
            $sheet->getStyle("V{$row}")
                ->getNumberFormat()
                ->setFormatCode('dd/mm/yyyy');

            // W: Hora atención (como texto, o puedes formatear hora)
            $HoraAtencion = \Carbon\Carbon::parse($paciente->HoraAtencion);
            $sheet->setCellValue("W{$row}", ExcelDate::PHPToExcel($HoraAtencion));
            $sheet->getStyle("W{$row}")
                ->getNumberFormat()
                ->setFormatCode('hh:mm:ss');

            // X: Dirección
            $sheet->setCellValue("X{$row}", $paciente->Direccion);

            // Y: Teléfono
            $sheet->setCellValue("Y{$row}", $paciente->Telefono);

            // Z–AB: Tecnóloga
            $sheet->setCellValue("Z{$row}", optional($paciente->tecnologa)->CodigoRM);
            $sheet->setCellValue("AA{$row}", optional($paciente->tecnologa)->NumDocumento);
            $sheet->setCellValue("AB{$row}", optional($paciente->tecnologa)->NombreCompleto);

            // AC: FechaHoraAtencion
            $sheet->setCellValue("AC{$row}", ExcelDate::PHPToExcel($fechaHoraAtencion));
            $sheet->getStyle("AC{$row}")
                ->getNumberFormat()
                ->setFormatCode('dd/mm/yyyy hh:mm');

            // AD: FechaHoraSalida
            $sheet->setCellValue("AD{$row}", ExcelDate::PHPToExcel($fechaHoraSalida));
            $sheet->getStyle("AD{$row}")
                ->getNumberFormat()
                ->setFormatCode('dd/mm/yyyy hh:mm');

            // AE: HoraFin
            $horaFin = \Carbon\Carbon::parse($paciente->horafin);
            $sheet->setCellValue("AE{$row}", ExcelDate::PHPToExcel($horaFin));
            $sheet->getStyle("AE{$row}")
                ->getNumberFormat()
                ->setFormatCode('hh:mm:ss');

            // AF: NumeroPlacas
            $sheet->setCellValue("AF{$row}", $paciente->numeroplacas);

            // AG: MinutosAtencion
            $sheet->setCellValue("AG{$row}", $minutosAtencion);

            // AH: Observaciones
            $sheet->setCellValue("AH{$row}", $paciente->observaciones);

            // AI–AK: CCD
            $sheet->setCellValue("AI{$row}", $paciente->CCDkv);
            $sheet->setCellValue("AJ{$row}", $paciente->CCDmas);
            $sheet->setCellValue("AK{$row}", round($paciente->CCDdosis, 2));

            // AL–AN: MLD
            $sheet->setCellValue("AL{$row}", $paciente->MLDkv);
            $sheet->setCellValue("AM{$row}", $paciente->MLDmas);
            $sheet->setCellValue("AN{$row}", round($paciente->MLDdosis, 2));

            // AO–AQ: CCI
            $sheet->setCellValue("AO{$row}", $paciente->CCIkv);
            $sheet->setCellValue("AP{$row}", $paciente->CCImas);
            $sheet->setCellValue("AQ{$row}", round($paciente->CCIdosis, 2));

            // AR–AT: MLI
            $sheet->setCellValue("AR{$row}", $paciente->MLIkv);
            $sheet->setCellValue("AS{$row}", $paciente->MLImas);
            $sheet->setCellValue("AT{$row}", round($paciente->MLIdosis, 2));

            // AU: total_dosis
            $sheet->setCellValue("AU{$row}", round($paciente->total_dosis, 2));

            // AV–AY: espesores
            $sheet->setCellValue("AV{$row}", $paciente->CCDespesor);
            $sheet->setCellValue("AW{$row}", $paciente->MLDespesor);
            $sheet->setCellValue("AX{$row}", $paciente->CCIespesor);
            $sheet->setCellValue("AY{$row}", $paciente->MLIespesor);

            // AZ–BA: Lado derecho/izquierdo
            $sheet->setCellValue("AZ{$row}", $paciente->lado_derecho ? 'Si' : 'No');
            $sheet->setCellValue("BA{$row}", $paciente->lado_izquierdo ? 'Si' : 'No');

            $row++;
            $consecutivo++;
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $filename = "RES.4505-{$paciente->Lugar}-{$ano}.xlsx";

        return new StreamedResponse(function () use ($writer) {
             if (ob_get_length()) {
                 ob_end_clean();
            }
            $writer->save('php://output');
        }, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment;filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }

}
