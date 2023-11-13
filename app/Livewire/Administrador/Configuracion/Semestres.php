<?php

namespace App\Livewire\Administrador\Configuracion;

use App\Helpers\HelpersUnia;
use App\Models\Ciclo;
use App\Models\Fecha;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Ciclos - CEPRE UNIA')]
#[Layout('components.layouts.app')]
class Semestres extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Url('mostrar')]
    public $mostrar_paginate = '10';

    #[Url('buscar')]
    public $search = '';

    // variables modal
    public $title_modal = 'Crear nuevo ciclo';
    public $button_modal = 'Crear ciclo';
    public $modo = 'create';

    // variables ciclo
    public $ciclo_id;
    #[Rule('required|max:50')]
    public $nombre;
    #[Rule('nullable|max:100')]
    public $descripcion;
    #[Rule('required|date')]
    public $fecha_inicio;
    #[Rule('required|date|after_or_equal:fecha_inicio')]
    public $fecha_fin;
    #[Rule('nullable|file|max:4096|mimes:pdf')]
    public $resolucion;
    #[Rule('nullable|boolean')]
    public $estado = false;

    #[Rule('required|date|after_or_equal:fecha_inicio')]
    public $fecha_inicio_inscripcion;
    #[Rule('required|date|after_or_equal:fecha_inicio_inscripcion')]
    public $fecha_extemporanea;
    #[Rule('required|date|after_or_equal:fecha_extemporanea')]
    public $fecha_fin_inscripcion;
    #[Rule('nullable|date')]
    public $fecha_examen;

    public function updatingSearch() {
        $this->resetPage();
    }

    public function limpiar_modal() {
        $this->reset([
            'ciclo_id',
            'nombre',
            'descripcion',
            'fecha_inicio',
            'fecha_fin',
            'resolucion',
            'estado',
            'fecha_inicio_inscripcion',
            'fecha_extemporanea',
            'fecha_fin_inscripcion',
            'fecha_examen'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function create() {
        $this->limpiar_modal();
        $this->modo = 'create';
        $this->title_modal = 'Crear nuevo ciclo';
        $this->button_modal = 'Crear ciclo';
    }

    public function edit_ciclo($id) {
        $this->limpiar_modal();
        $this->modo = 'edit';
        $this->title_modal = 'Editar ciclo';
        $this->button_modal = 'Guardar';
        // buscamos el ciclo
        $ciclo = Ciclo::find($id);
        $this->ciclo_id = $ciclo->id;
        $this->nombre = $ciclo->nombre;
        $this->descripcion = $ciclo->descripcion;
        $this->fecha_inicio = $ciclo->fechaInicio;
        $this->fecha_fin = $ciclo->fechaFin;
        $this->estado = $ciclo->estado ? true : false;
        // buscamos las fechas de inscripcion
        $fecha = Fecha::where('ciclo_id', $ciclo->id)->first();
        $this->fecha_inicio_inscripcion = $fecha->iniInscripcion;
        $this->fecha_extemporanea = $fecha->iniExtemporaneo;
        $this->fecha_fin_inscripcion = $fecha->finInscripcion;
        $this->fecha_examen = $fecha->diaExamen;
    }

    public function show($id) {
        // buscamos el ciclo
        $ciclo = Ciclo::find($id);
        $this->title_modal = 'Ver ciclo ' . $ciclo->nombre;
        $this->ciclo_id = $ciclo->id;
        $this->nombre = $ciclo->nombre;
        $this->descripcion = $ciclo->descripcion;
        $this->resolucion = $ciclo->resolucion_ruta;
        $this->fecha_inicio = $ciclo->fechaInicio;
        $this->fecha_fin = $ciclo->fechaFin;
        $this->estado = $ciclo->estado ? true : false;
        // buscamos las fechas de inscripcion
        $fecha = Fecha::where('ciclo_id', $ciclo->id)->first();
        $this->fecha_inicio_inscripcion = $fecha->iniInscripcion;
        $this->fecha_extemporanea = $fecha->iniExtemporaneo;
        $this->fecha_fin_inscripcion = $fecha->finInscripcion;
        $this->fecha_examen = $fecha->diaExamen;
    }

    public function guardar_ciclo() {
        // validamos los campos
        if ($this->modo == 'create') {
            $this->validate([
                'nombre' => 'required|max:50|unique:ciclos,nombre',
                'descripcion' => 'nullable|max:100',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'resolucion' => 'required|file|max:4096|mimes:pdf',
                'estado' => 'nullable|boolean',
                'fecha_inicio_inscripcion' => 'required|date|after_or_equal:fecha_inicio',
                'fecha_extemporanea' => 'required|date|after_or_equal:fecha_inicio_inscripcion',
                'fecha_fin_inscripcion' => 'required|date|after_or_equal:fecha_extemporanea',
                'fecha_examen' => 'nullable|date'
            ]);
        } else {
            $this->validate([
                'nombre' => 'required|max:50|unique:ciclos,nombre,' . $this->ciclo_id,
                'descripcion' => 'nullable|max:100',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'resolucion' => 'nullable|file|max:4096|mimes:pdf',
                'estado' => 'nullable|boolean',
                'fecha_inicio_inscripcion' => 'required|date|after_or_equal:fecha_inicio',
                'fecha_extemporanea' => 'required|date|after_or_equal:fecha_inicio_inscripcion',
                'fecha_fin_inscripcion' => 'required|date|after_or_equal:fecha_extemporanea',
                'fecha_examen' => 'nullable|date'
            ]);
        }
        // si el estado es activo, desactivamos los ciclos con estado activo
        if ($this->estado) {
            // buscamos si existen ciclos con estado activo
            $ciclos_activos = Ciclo::where('estado', 1)
                ->where('activo', 1)
                ->get();
            // si existe un ciclo con estado activo, lo desactivamos
            foreach ($ciclos_activos as $ciclo_activo) {
                $ciclo_activo->estado = 0;
                $ciclo_activo->save();
            }
        }
        // creamos las rutas de los archivos y fotos
        $path_archivos = 'uploads/archivos/';
        $path_photos = 'uploads/photos/';
        // creamos o editamos el ciclo y sus fechas de inscripcion
        if ($this->modo == 'create') {
            // creamos el nuevo ciclo
            $ciclo = new Ciclo();
            $ciclo->nombre = strtoupper(str_replace(' ', '', $this->nombre));
            $ciclo->descripcion = $this->descripcion;
            if ($this->resolucion) {
                $path = 'uploads/archivos/' . $ciclo->nombre . '/';
                $filename = time() . $ciclo->nombre . uniqid() . '.pdf';
                $this->resolucion->storeAs($path, $filename, 'file_public');
                $ciclo->resolucion_ruta = $path . $filename;
            }
            $ciclo->fechaInicio = $this->fecha_inicio;
            $ciclo->fechaFin = $this->fecha_fin;
            $ciclo->estado = $this->estado ? 1 : 0;
            $ciclo->activo = 1;
            $ciclo->borrado = 0;
            $ciclo->save();
            // creamos las fechas de inscripcion
            $fecha = new Fecha();
            $fecha->iniInscripcion = $this->fecha_inicio_inscripcion;
            $fecha->iniExtemporaneo = $this->fecha_extemporanea;
            $fecha->finInscripcion = $this->fecha_fin_inscripcion;
            $fecha->diaExamen = $this->fecha_examen;
            $fecha->activo = 1;
            $fecha->ciclo_id = $ciclo->id;
            $fecha->save();
            // mostramos el mensaje de exito
            $this->dispatch('toast-basico',
                text: 'Se ha creado un nuevo ciclo',
                color: 'success'
            );
        } else {
            $ciclo = Ciclo::find($this->ciclo_id);
            $ciclo->nombre = strtoupper(str_replace(' ', '', $this->nombre));
            $ciclo->descripcion = $this->descripcion;
            if ($this->resolucion) {
                if (File::exists($ciclo->resolucion_ruta)) {
                    File::delete($ciclo->resolucion_ruta);
                }
                $path = 'uploads/archivos/' . $ciclo->nombre . '/';
                $filename = time() . $ciclo->nombre . uniqid() . '.pdf';
                $this->resolucion->storeAs($path, $filename, 'file_public');
                $ciclo->resolucion_ruta = $path . $filename;
            }
            $ciclo->fechaInicio = $this->fecha_inicio;
            $ciclo->fechaFin = $this->fecha_fin;
            $ciclo->estado = $this->estado ? 1 : 0;
            $ciclo->save();
            // actualizamos las fechas de inscripcion
            $fecha = Fecha::where('ciclo_id', $ciclo->id)->first();
            $fecha->iniInscripcion = $this->fecha_inicio_inscripcion;
            $fecha->iniExtemporaneo = $this->fecha_extemporanea;
            $fecha->finInscripcion = $this->fecha_fin_inscripcion;
            $fecha->diaExamen = $this->fecha_examen;
            $fecha->save();
            // mostramos el mensaje de exito
            $this->dispatch('toast-basico',
                text: 'Se ha actualizado el ciclo',
                color: 'success'
            );
        }
        // creamos la ruta de la carpeta donde se guardaran los archivos y fotos
        if (!File::isDirectory(public_path($path_archivos . strtoupper(str_replace(' ', '', $this->nombre)) . '/'))) {
            File::makeDirectory(public_path($path_archivos . strtoupper(str_replace(' ', '', $this->nombre)) . '/'), 0755, true, true);
        }
        if (!File::isDirectory(public_path($path_photos . strtoupper(str_replace(' ', '', $this->nombre)) . '/'))) {
            File::makeDirectory(public_path($path_photos . strtoupper(str_replace(' ', '', $this->nombre)) . '/'), 0755, true, true);
        }
        // cerramos el modal
        $this->dispatch('modal',
            modal: '#modal-ciclo',
            action: 'hide'
        );
        // limpiamos los campos
        $this->limpiar_modal();
    }

    public function render() {
        $ciclos = Ciclo::where('activo', 1)
            ->where('borrado', 0)
            ->search($this->search)
            ->orderBy('id', 'desc')
            ->paginate($this->mostrar_paginate);

        return view('livewire.administrador.configuracion.semestres', [
            'ciclos' => $ciclos
        ]);
    }
}
