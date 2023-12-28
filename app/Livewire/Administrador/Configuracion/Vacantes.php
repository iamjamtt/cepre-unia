<?php

namespace App\Livewire\Administrador\Configuracion;

use App\Helpers\HelpersUnia;
use App\Models\Carrera;
use App\Models\Ciclo;
use App\Models\Vacante as VacanteModel;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Vacantes extends Component
{
    use WithPagination;

    #[Url('mostrar')]
    public $mostrar_paginate = '10';

    #[Url('buscar')]
    public $search = '';

    #[Url('ciclo')]
    public $ciclo_filtro;

    // variables modal
    public $title_modal = 'Crear nueva vacante';
    public $button_modal = 'Crear vacante';
    public $modo = 'create';

    // variables ciclo
    public $vacante_id;
    #[Rule('required|numeric')]
    public $vacante;
    #[Rule('required|exists:carreras,id')]
    public $carrera;
    #[Rule('required|exists:ciclos,id')]
    public $ciclo;

    public function mount() {
        $this->ciclo_filtro = HelpersUnia::getIdCiclo();
    }

    public function updatingSearch() {
        $this->resetPage();
    }

    public function limpiar_modal() {
        $this->reset([
            'vacante_id',
            'vacante',
            'carrera',
            'ciclo'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function create() {
        $this->limpiar_modal();
        $this->modo = 'create';
        $this->title_modal = 'Crear nueva vacante';
        $this->button_modal = 'Crear vacante';
    }

    public function edit_vacante($id) {
        $this->limpiar_modal();
        $this->modo = 'edit';
        $this->title_modal = 'Editar vacante';
        $this->button_modal = 'Guardar';
        // buscamos el rol
        $vacante = VacanteModel::find($id);
        // asignamos los valores
        $this->vacante_id = $vacante->id;
        $this->vacante = $vacante->vacantes;
        $this->carrera = $vacante->carrera_id;
        $this->ciclo = $vacante->ciclo_id;
    }

    public function guardar() {
        // validamos los campos
        $this->validate();
        if ($this->modo == 'create') {
            // validamos si se esta queriendo registrar una vacante en la misma carrera y ciclo
            $vacante = VacanteModel::where('carrera_id', $this->carrera)
                ->where('ciclo_id', $this->ciclo)
                ->first();
            if ($vacante) {
                // mostramos el mensaje de error
                $this->dispatch('toast-basico',
                    text: 'Ya existe una vacante para la carrera y ciclo seleccionado',
                    color: 'danger'
                );
                return;
            }
            // creamos el nueva vacante
            $vacante = new VacanteModel();
            $vacante->vacantes = $this->vacante;
            $vacante->carrera_id = $this->carrera;
            $vacante->ciclo_id = $this->ciclo;
            $vacante->modalidad_id = 1;
            $vacante->save();
            // mostramos el mensaje de exito
            $this->dispatch('toast-basico',
                text: 'Se ha creado la vacante con exito',
                color: 'success'
            );
        } else {
            // actualizamos la vacante
            $vacante = VacanteModel::find($this->vacante_id);
            $vacante->vacantes = $this->vacante;
            $vacante->carrera_id = $this->carrera;
            $vacante->ciclo_id = $this->ciclo;
            $vacante->modalidad_id = 1;
            $vacante->save();
            // mostramos el mensaje de exito
            $this->dispatch('toast-basico',
                text: 'Se ha actualizado la vacante con exito',
                color: 'success'
            );
        }
        // cerramos el modal
        $this->dispatch('modal',
            modal: '#modal-vacante',
            action: 'hide'
        );
        // limpiamos los campos
        $this->limpiar_modal();
    }

    public function delete($id) {
        // buscamos la vacante
        $vaca = VacanteModel::find($id);
        // eliminamos la vacante
        $vaca->delete();
        // mostramos el mensaje de exito
        $this->dispatch('toast-basico',
            text: 'Se ha eliminado la vacante con exito',
            color: 'success'
        );
    }

    public function render() {
        $vacantes = VacanteModel::where(function ($query) {
                $query->where('vacantes', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('id', 'LIKE', '%'. $this->search .'%');
            })
            ->where('ciclo_id', $this->ciclo_filtro ? $this->ciclo_filtro : '!=', null)
            ->orderBy('id', 'DESC')
            ->paginate($this->mostrar_paginate);
        $ciclos = Ciclo::where('activo', 1)
            ->orderBy('id','DESC')
            ->get();
        $carreras = Carrera::where('activo',1)->get();
        return view('livewire.administrador.configuracion.vacantes', [
            'ciclos' => $ciclos,
            'carreras' => $carreras,
            'vacantes' => $vacantes
        ]);
    }
}
