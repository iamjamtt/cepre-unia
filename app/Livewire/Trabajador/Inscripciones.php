<?php

namespace App\Livewire\Trabajador;

use App\Helpers\HelpersUnia;
use App\Models\Archivo;
use App\Models\Carrera;
use App\Models\Ciclo;
use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\Language;
use App\Models\LugarPago;
use App\Models\TipoPago;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Inscripciones - CEPRE UNIA')]
#[Layout('components.layouts.app')]
class Inscripciones extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Url('ciclo')]
    public $ciclo_filtro;
    #[Url('grupo')]
    public $grupo_filtro = 'all';

    #[Url('mostrar')]
    public $mostrar_paginate = '10';

    #[Url('buscar')]
    public $search = '';

    public $inscripcion_id;
    public $pago;
    public $modo = 'create';
    public $tipo_documento;
    public $nombre_documento;
    public Collection $documentos;

    // variables de modal pago
    #[Rule('required|numeric')]
    public $lugar_pago;
    #[Rule('required|date')]
    public $fecha_pago;
    #[Rule('required')]
    public $codigo_pago;
    #[Rule('required|numeric')]
    public $verificar_pago;

    // variables de modal documentos
    public $archivo_foto;
    public $archivo_dni;
    public $archivo_pago;
    public $archivo_certificado;
    public $archivo_partida;
    public $archivo_constancia;

    // variables de modal subir documentos
    #[Rule('required|image|max:2048')]
    public $documento;

    // variables de modal postulante
    #[Rule('required')]
    public $apellido_paterno;
    #[Rule('required')]
    public $apellido_materno;
    #[Rule('required')]
    public $nombre;
    #[Rule('required|date')]
    public $fecha_nacimiento;
    #[Rule('required')]
    public $sexo;
    #[Rule('required|numeric|digits:9')]
    public $celular;
    #[Rule('required')]
    public $grupo_etnico;
    #[Rule('required')]
    public $lengua_materna;
    #[Rule('nullable')]
    public $comunidad;
    #[Rule('nullable')]
    public $direccion;
    #[Rule('required|numeric')]
    public $carrera;

    // variable para el filtro
    public $nombre_filtro = 'Filtros: Todas las inscripciones';
    public $color_filtro = 'btn-outline-blue';
    #[Url('filtro')]
    public $filtro = 0;

    public function mount() {
        $this->ciclo_filtro = $this->ciclo_filtro ?? Ciclo::where('estado', 1)->first()->id;
        $this->documentos = collect([]);
    }

    public function updatedCicloFiltro() {
        $this->resetPage();
    }

    public function updatedSearch() {
        $this->resetPage();
    }

    public function limpiar_modal_pago() {
        $this->reset([
            'lugar_pago',
            'fecha_pago',
            'codigo_pago',
            'verificar_pago',
            'archivo_pago'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function cargar_pago($inscripcion_id) {
        $inscripcion = Inscripcion::find($inscripcion_id);
        $this->pago = $inscripcion->pago;
        $this->archivo_pago = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 3); // 3 = pago
        $this->lugar_pago = $this->pago->lugarpago_id;
        $this->fecha_pago = $this->pago->fecha;
        $this->codigo_pago = $this->pago->codigo;
        $this->verificar_pago = $this->pago->verificacion;
    }

    public function guardar_pago() {
        $this->validate([
            'lugar_pago' => 'required|numeric',
            'fecha_pago' => 'required|date',
            'codigo_pago' => 'required',
            'verificar_pago' => 'required|numeric'
        ]);
        // verificamos el pago
        if ($this->verificar_pago == 1) {
            $this->pago->codigo = $this->codigo_pago;
            $this->pago->verificacion = 1;
            $this->pago->save();
            // mostramos el mensaje de exito
            $this->dispatch('toast-basico',
                text: 'Se ha verificado el pago con exito',
                color: 'success'
            );
        } else {
            $this->pago->codigo = $this->codigo_pago;
            $this->pago->verificacion = 0;
            $this->pago->save();
            // mostramos el mensaje
            $this->dispatch('toast-basico',
                text: 'No se ha verificado el pago con exito',
                color: 'success'
            );
        }
        // cerramos el modal
        $this->dispatch('modal',
            modal: '#modal-pago',
            action: 'hide'
        );
    }

    public function aprobar_foto($inscripcion_id , $value) {
        $inscripcion = Inscripcion::find($inscripcion_id);
        if ($value == true) {
            $inscripcion->foto = 1;
            $inscripcion->save();
            // mostramos el mensaje
            $this->dispatch('toast-basico',
                text: 'Se ha aprobado la foto con exito',
                color: 'success'
            );
        } else {
            $inscripcion->foto = 0;
            $inscripcion->save();
            // mostramos el mensaje
            $this->dispatch('toast-basico',
                text: 'La foto ha sido desaprobada con exito',
                color: 'success'
            );
        }
    }

    public function resetear_password($inscripcion_id) {
        $inscripcion = Inscripcion::find($inscripcion_id);
        $persona = $inscripcion->persona;
        $user = $persona->user;
        $user->password = Hash::make($persona->dni);
        $user->save();
        // mostramos el mensaje
        $this->dispatch('toast-basico',
            text: 'Se ha reseteado la contraseña con exito',
            color: 'success'
        );
    }

    public function aprobar_documentos($inscripcion_id , $value) {
        $inscripcion = Inscripcion::find($inscripcion_id);
        if ($value == true) {
            $inscripcion->documento = 1;
            $inscripcion->save();
            // mostramos el mensaje
            $this->dispatch('toast-basico',
                text: 'Se han aprobado los documentos con exito',
                color: 'success'
            );
        } else {
            $inscripcion->documento = 0;
            $inscripcion->save();
            // mostramos el mensaje
            $this->dispatch('toast-basico',
                text: 'Los documentos han sido desaprobados con exito',
                color: 'success'
            );
        }
    }

    public function cargar_documentos($inscripcion_id) {
        $inscripcion = Inscripcion::find($inscripcion_id);
        $this->inscripcion_id = $inscripcion->id;
        $persona = $inscripcion->persona;
        $this->archivo_foto = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 1); // 1 = foto
        $this->archivo_dni = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 2); // 2 = dni
        $this->archivo_pago = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 3); // 3 = pago
        $this->archivo_certificado = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 4); // 4 = certificado
        $this->archivo_partida = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 5); // 5 = partida de naicimiento
        $this->archivo_constancia = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 6); // 6 = constancia de egresado
        if ($persona->grupo_id == 1) {
            $this->documentos = collect([
                ['id' => '1', 'nombre' => 'Foto', 'archivo' => $this->archivo_foto, 'ruta' => $this->archivo_foto->ruta ?? ''],
                ['id' => '2', 'nombre' => 'DNI', 'archivo' => $this->archivo_dni, 'ruta' => $this->archivo_dni->ruta ?? ''],
                ['id' => '3', 'nombre' => 'Pago', 'archivo' => $this->archivo_pago, 'ruta' => $this->archivo_pago->ruta ?? ''],
                ['id' => '4', 'nombre' => 'Certificado de Estudios', 'archivo' => $this->archivo_certificado, 'ruta' => $this->archivo_certificado->ruta ?? ''],
                ['id' => '5', 'nombre' => 'Partida de Nacimiento', 'archivo' => $this->archivo_partida, 'ruta' => $this->archivo_partida->ruta ?? '']
            ]);
        } else {
            $this->documentos = collect([
                ['id' => '1', 'nombre' => 'Foto', 'archivo' => $this->archivo_foto, 'ruta' => $this->archivo_foto->ruta ?? ''],
                ['id' => '2', 'nombre' => 'DNI', 'archivo' => $this->archivo_dni, 'ruta' => $this->archivo_dni->ruta ?? ''],
                ['id' => '3', 'nombre' => 'Pago', 'archivo' => $this->archivo_pago, 'ruta' => $this->archivo_pago->ruta ?? ''],
                ['id' => '4', 'nombre' => 'Certificado de Estudios', 'archivo' => $this->archivo_certificado, 'ruta' => $this->archivo_certificado->ruta ?? ''],
                ['id' => '5', 'nombre' => 'Partida de Nacimiento', 'archivo' => $this->archivo_partida, 'ruta' => $this->archivo_partida->ruta ?? ''],
                ['id' => '6', 'nombre' => 'Constancia de Comunidad', 'archivo' => $this->archivo_constancia, 'ruta' => $this->archivo_constancia->ruta ?? '']
            ]);
        }
    }

    public function limpiar_modal_documentos() {
        $this->reset([
            'archivo_foto',
            'archivo_dni',
            'archivo_pago',
            'archivo_certificado',
            'archivo_partida',
            'archivo_constancia'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function modo_documento($tipo_documento, $modo) {
        $this->tipo_documento = $tipo_documento;
        if ($tipo_documento == 1) {
            $this->nombre_documento = 'Fotografía';
        } elseif ($tipo_documento == 2) {
            $this->nombre_documento = 'DNI';
        } elseif ($tipo_documento == 3) {
            $this->nombre_documento = 'Pago';
        } elseif ($tipo_documento == 4) {
            $this->nombre_documento = 'Certificado de estudios';
        } elseif ($tipo_documento == 5) {
            $this->nombre_documento = 'Partida de nacimiento';
        } elseif ($tipo_documento == 6) {
            $this->nombre_documento = 'Constancia de comunidad';
        }
        $this->dispatch('modal',
            modal: '#modal-documentos',
            action: 'hide'
        );
        $this->dispatch('modal',
            modal: '#modal-subir-documentos',
            action: 'show'
        );
        if ($modo == 'create') {
            $this->modo = 'create';
        } else {
            $this->modo = 'edit';
        }
    }

    public function cancelar_subida_documentos() {
        $this->cargar_documentos($this->inscripcion_id);
        $this->dispatch('modal',
            modal: '#modal-subir-documentos',
            action: 'hide'
        );
        $this->dispatch('modal',
            modal: '#modal-documentos',
            action: 'show'
        );
        $this->reset([
            'documento'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function guardar_documento() {
        $this->validate([
            'documento' => 'required|image|max:2048'
        ]);

        if ($this->tipo_documento == 1) {
            $carpeta = 'photos';
        } else {
            $carpeta = 'archivos';
        }

        $inscripcion = Inscripcion::find($this->inscripcion_id);

        // creamos el voucher en el modelo de archivo
        if ($this->documento) {
            HelpersUnia::subirArchivo($this->documento, $carpeta, $this->tipo_documento, $inscripcion->ciclo_id, $inscripcion->persona_id);
        }

        if ($this->modo == 'create') {
            // mostramos el mensaje
            $this->dispatch('toast-basico',
                text: 'Se ha subido el documento con exito',
                color: 'success'
            );
        } else {
            // mostramos el mensaje
            $this->dispatch('toast-basico',
                text: 'Se ha actualizado el documento con exito',
                color: 'success'
            );
        }

        $this->cancelar_subida_documentos();
    }

    public function cargar_postulante($inscripcion_id) {
        $this->inscripcion_id = $inscripcion_id;
        $inscripcion = Inscripcion::find($inscripcion_id);
        $persona = $inscripcion->persona;
        $this->apellido_paterno = $persona->apePaterno;
        $this->apellido_materno = $persona->apeMaterno;
        $this->nombre = $persona->nombres;
        $this->fecha_nacimiento = $persona->fechaNac;
        $this->sexo = $persona->sexo;
        $this->celular = $persona->celular;
        $this->grupo_etnico = $persona->grupo_id;
        $this->lengua_materna = $persona->language_id;
        $this->comunidad = $persona->comunidad;
        $this->direccion = $persona->direccion;
        $this->carrera = $inscripcion->carrera_id;
    }

    public function limpiar_modal_postulante() {
        $this->reset([
            'apellido_paterno',
            'apellido_materno',
            'nombre',
            'fecha_nacimiento',
            'sexo',
            'celular',
            'grupo_etnico',
            'lengua_materna',
            'comunidad',
            'direccion',
            'carrera'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function guardar_datos_postulante() {
        $this->validate([
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'nombre' => 'required',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required',
            'celular' => 'required|numeric|digits:9',
            'grupo_etnico' => 'required',
            'lengua_materna' => 'required',
            'carrera' => 'required'
        ]);
        // guardamos los datos de la inscripcion
        $inscripcion = Inscripcion::find($this->inscripcion_id);
        $inscripcion->carrera_id = $this->carrera;
        $inscripcion->save();
        // guardamos los datos del postulante
        $persona = $inscripcion->persona;
        $persona->apePaterno = $this->apellido_paterno;
        $persona->apeMaterno = $this->apellido_materno;
        $persona->nombres = $this->nombre;
        $persona->fechaNac = $this->fecha_nacimiento;
        $persona->sexo = $this->sexo;
        $persona->celular = $this->celular;
        $persona->grupo_id = $this->grupo_etnico;
        $persona->language_id = $this->lengua_materna;
        $persona->comunidad = $this->comunidad;
        $persona->direccion = $this->direccion;
        $persona->save();
        // mostramos el mensaje
        $this->dispatch('toast-basico',
            text: 'Se ha actualizado los datos del postulante con exito',
            color: 'success'
        );
        // cerramos el modal
        $this->dispatch('modal',
            modal: '#modal-postulante',
            action: 'hide'
        );
        // limpiamos el modal
        $this->limpiar_modal_postulante();
    }

    public function finalizar_matricula($inscripcion_id, $value) {
        $inscripcion = Inscripcion::find($inscripcion_id);
        if ($value == true) {
        $inscripcion->estado = 2;
        } else {
            $inscripcion->estado = 1;
        }
        $inscripcion->save();
        // mostramos el mensaje
        if ($value == true) {
            $this->dispatch('toast-basico',
                text: 'Se ha finalizado la matricula con exito',
                color: 'success'
            );
        } else {
            $this->dispatch('toast-basico',
                text: 'Se ha cancelado la matricula con exito',
                color: 'success'
            );
        }
    }

    public function filtro_inscripcion($value) {
        if ($value == 1) {
            $this->nombre_filtro = 'Filtros: Inscripciones completadas';
            $this->color_filtro = 'btn-outline-blue';
            $this->filtro = 1;
        } elseif ($value == 2) {
            $this->nombre_filtro = 'Filtros: Fotografías aprobadas';
            $this->color_filtro = 'btn-outline-teal';
            $this->filtro = 2;
        } elseif ($value == 3) {
            $this->nombre_filtro = 'Filtros: Fotografías desaprobadas';
            $this->color_filtro = 'btn-outline-teal';
            $this->filtro = 3;
        } elseif ($value == 4) {
            $this->nombre_filtro = 'Filtros: Sin fotografías';
            $this->color_filtro = 'btn-outline-teal';
            $this->filtro = 4;
        } elseif ($value == 5) {
            $this->nombre_filtro = 'Filtros: Pagos verificados';
            $this->color_filtro = 'btn-outline-indigo';
            $this->filtro = 5;
        } elseif ($value == 6) {
            $this->nombre_filtro = 'Filtros: Pagos no verificados';
            $this->color_filtro = 'btn-outline-indigo';
            $this->filtro = 6;
        } elseif ($value == 7) {
            $this->nombre_filtro = 'Filtros: Documentos completados';
            $this->color_filtro = 'btn-outline-orange';
            $this->filtro = 7;
        } elseif ($value == 8) {
            $this->nombre_filtro = 'Filtros: Sin documentos';
            $this->color_filtro = 'btn-outline-orange';
            $this->filtro = 8;
        } elseif ($value == 9) {
            $this->nombre_filtro = 'Filtros: Inscripciones no finalizadas';
            $this->color_filtro = 'btn-outline-blue';
            $this->filtro = 9;
        } else {
            $this->nombre_filtro = 'Filtros: Todas las inscripciones';
            $this->color_filtro = 'btn-outline-blue';
            $this->filtro = 0;
        }
    }

    public function eliminar($inscripcion_id) {
        $inscripcion = Inscripcion::find($inscripcion_id);
        $persona = $inscripcion->persona;
        $ciclo_id = $inscripcion->ciclo_id;
        $persona_id = $inscripcion->persona_id;
        // eliminamos los archivos de esta inscripcion
        $archivos = Archivo::where('ciclo_id', $ciclo_id)
            ->where('persona_id', $persona_id)
            ->where('activo', 1)
            ->where('borrado', 0)
            ->get();
        foreach ($archivos as $archivo) {
            $archivo->activo = 0;
            $archivo->borrado = 1;
            $archivo->save();
            // eliminamos el archivo del servidor
            if (File::exists($archivo->ruta)) {
                File::delete($archivo->ruta);
            }
        }
        // eliminamos el pago de esta inscripcion
        $pago = $inscripcion->pago;
        $pago->activo = 0;
        $pago->borrado = 1;
        $pago->save();
        // eliminamos las preguntas de esta inscripcion
        $preguntas = $persona->preguntas()->where('ciclo_id', $ciclo_id)->get();
        foreach ($preguntas as $pregunta) {
            $pregunta->delete();
        }
        // eliminamos la inscripcion
        $inscripcion->activo = 0;
        $inscripcion->borrado = 1;
        $inscripcion->save();
        // mostramos el mensaje
        $this->dispatch('toast-basico',
            text: 'Se ha eliminado la inscripcion con exito',
            color: 'success'
        );
    }

    public function render() {
        $ciclos = Ciclo::where('activo', 1)
            ->orderBy('id', 'desc')
            ->get();
        $grupos = Grupo::where('activo',1)
            ->get();
        $inscripciones = Inscripcion::join('personas', 'personas.id', '=', 'inscripcions.persona_id')
                ->join('ciclos', 'ciclos.id', '=', 'inscripcions.ciclo_id')
                ->join('grupos', 'grupos.id', '=', 'personas.grupo_id')
                ->join('pagos', 'pagos.inscripcion_id', '=', 'inscripcions.id')
                ->where('inscripcions.ciclo_id', $this->ciclo_filtro)
                ->where('personas.grupo_id', $this->grupo_filtro == 'all' ? '!=' : '=', $this->grupo_filtro)
                ->where(
                    function ($query) {
                        if ($this->filtro == 1) {
                            $query->where('inscripcions.estado', 2);
                        } elseif ($this->filtro == 2) {
                            $query->where('inscripcions.foto', 1);
                        } elseif ($this->filtro == 3) {
                            $query->where('inscripcions.foto', 0);
                        } elseif ($this->filtro == 5) {
                            $query->where('pagos.verificacion', 1);
                        } elseif ($this->filtro == 6) {
                            $query->where('pagos.verificacion', 0);
                        } elseif ($this->filtro == 7) {
                            $query->where('inscripcions.documento', 1);
                        } elseif ($this->filtro == 8) {
                            $query->where('inscripcions.documento', 0);
                        } elseif ($this->filtro == 9) {
                            $query->where('inscripcions.estado', 1);
                        }
                    }
                )
                ->where(function ($query) {
                    $query->where(DB::raw("CONCAT(personas.nombres,' ',personas.apePaterno,' ',personas.apeMaterno)"), 'like', '%' . $this->search . '%')
                        ->orWhere('personas.dni', 'like', '%' . $this->search . '%');
                })
                ->where('inscripcions.activo', 1)
                ->where('inscripcions.borrado', 0)
                ->select('inscripcions.*', 'grupos.nombre as nombre_grupo', 'personas.dni', 'ciclos.nombre as ciclo_nombre', 'personas.celular', 'personas.celularApoderado')
                ->orderBy('inscripcions.id', 'desc')
                ->paginate($this->mostrar_paginate);
        $lugar_pagos = LugarPago::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $lenguas = Language::where('activo', 1)->get();
        $carreras = Carrera::where('activo', 1)->get();
        return view('livewire.trabajador.inscripciones', [
            'ciclos' => $ciclos,
            'inscripciones' => $inscripciones,
            'lugar_pagos' => $lugar_pagos,
            'grupos' => $grupos,
            'lenguas' => $lenguas,
            'carreras' => $carreras
        ]);
    }
}
