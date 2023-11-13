<?php

namespace App\Livewire\Administrador\Configuracion;

use App\Models\Roles as ModelsRoles;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Roles - CEPRE UNIA')]
#[Layout('components.layouts.app')]
class Roles extends Component
{
    use WithPagination;

    #[Url('mostrar')]
    public $mostrar_paginate = '10';

    #[Url('buscar')]
    public $search = '';

    // variables modal
    public $title_modal = 'Crear nuevo ciclo';
    public $button_modal = 'Crear ciclo';
    public $modo = 'create';

    // variables ciclo
    public $rol_id;
    public $nombre;

    public function rules() {
        return [
            'nombre' => 'required|max:50|unique:roles,nombre,' . $this->rol_id . ',id',
        ];
    }

    public function updatingSearch() {
        $this->resetPage();
    }

    public function limpiar_modal() {
        $this->reset([
            'rol_id',
            'nombre',
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function create() {
        $this->limpiar_modal();
        $this->modo = 'create';
        $this->title_modal = 'Crear nuevo rol';
        $this->button_modal = 'Crear rol';
    }

    public function edit_rol($id) {
        $this->limpiar_modal();
        $this->modo = 'edit';
        $this->title_modal = 'Editar rol';
        $this->button_modal = 'Guardar';
        // buscamos el rol
        $rol = ModelsRoles::find($id);
        // asignamos los valores
        $this->rol_id = $rol->id;
        $this->nombre = $rol->nombre;
    }

    public function guardar() {
        $this->validate();

        if ($this->modo == 'create') {
            // creamos el nuevo rol
            $rol = new ModelsRoles();
            $rol->nombre = $this->nombre;
            $rol->activo = 1;
            $rol->borrado = 0;
            $rol->save();
            // mostramos el mensaje de exito
            $this->dispatch('toast-basico',
                text: 'Se ha creado un nuevo rol',
                color: 'success'
            );
        } else {
            // actualizamos el rol
            $rol = ModelsRoles::find($this->rol_id);
            $rol->nombre = $this->nombre;
            $rol->save();
            // mostramos el mensaje de exito
            $this->dispatch('toast-basico',
                text: 'Se ha actualizado el ciclo',
                color: 'success'
            );
        }
        // cerramos el modal
        $this->dispatch('modal',
            modal: '#modal-rol',
            action: 'hide'
        );
        // limpiamos los campos
        $this->limpiar_modal();
    }

    public function delete($id) {
        // verificar si el rol tiene usuarios asignados
        $rol = ModelsRoles::find($id);
        if ($rol->users->count() > 0) {
            $this->dispatch('toast-basico',
                text: 'No se puede eliminar el rol porque tiene usuarios asignados',
                color: 'danger'
            );
            return;
        }
        // buscamos el rol
        $rol = ModelsRoles::find($id);
        // eliminamos el rol
        $rol->activo = 0;
        $rol->borrado = 1;
        $rol->save();
        // mostramos el mensaje de exito
        $this->dispatch('toast-basico',
            text: 'Se ha eliminado el rol',
            color: 'success'
        );
    }

    public function render()
    {
        $roles = ModelsRoles::where('nombre', 'LIKE', '%' . $this->search . '%')
            ->where('activo', 1)
            ->orderBy('id', 'DESC')
            ->paginate($this->mostrar_paginate);

        return view('livewire.administrador.configuracion.roles', [
            'roles' => $roles
        ]);
    }
}
