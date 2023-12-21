<?php

namespace App\Livewire\Trabajador;

use App\Helpers\HelpersUnia;
use App\Imports\Reportes\ResultadosIngresantes;
use App\Models\Carrera;
use App\Models\Fecha;
use App\Models\Ingresante;
use App\Models\Inscripcion;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Ingresantes extends Component
{
    use WithFileUploads;

    #[Rule("required|file|mimes:xlsx,xls")]
    public $documento;

    public function abrir_modal() {
        $this->cancelar_modal();
    }

    public function cancelar_modal() {
        $this->reset([
            "documento"
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function subir_documento() {
        // validamos el documento
        $this->validate();
        // importamos el documento
        if ($this->documento) {
            Excel::import(new ResultadosIngresantes, $this->documento);
        }
        // mostrar mensaje de exito
        $this->dispatch('toast-basico',
            text: 'Se ha subido el documento correctamente',
            color: 'success'
        );
        // cerrar modal
        $this->dispatch('modal',
            modal: '#modal-ingresantes',
            action: 'hide'
        );
    }

    public function render() {
        $ingresantes_count = Ingresante::where("ciclo_id", HelpersUnia::getIdCiclo())->count();
        $carreras = Carrera::where('activo', 1)->get();
        $resultados = collect();
        foreach ($carreras as $item) {
            $inscripciones = Inscripcion::where('ciclo_id', HelpersUnia::getIdCiclo())
                ->where('carrera_id', $item->id)
                ->where('activo', 1)
                ->where('borrado', 0)
                ->orderBy('puntaje','desc')
                ->get();
            $resultados[] = [
                'carrera' => $item->nombre,
                'inscripciones' => $inscripciones,
            ];
        }
        $fecha_examen = Fecha::where('ciclo_id', HelpersUnia::getIdCiclo())
            ->first()->diaExamen;
        return view('livewire.trabajador.ingresantes', [
            'ingresantes_count'=> $ingresantes_count,
            'resultados' => $resultados,
            'fecha_examen' => $fecha_examen
        ]);
    }
}
