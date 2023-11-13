<?php

namespace App\Livewire\Administrador;

use App\Models\Roles;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Usuarios - CEPRE UNIA')]
#[Layout('components.layouts.app')]
class User extends Component
{
    use WithPagination;

    #[Url('mostrar')]
    public $mostrar_paginate = '10';

    #[Url('buscar')]
    public $search = '';

    // variables modal edit contraseña
    public $user_id;
    #[Rule('required')]
    public $contraseña;
    #[Rule('required|same:contraseña')]
    public $contraseña_confirmation;

    // variante modal user
    public $title_modal = 'Crear nuevo usuario';
    public $button_modal = 'Crear usuario';
    public $modo = 'create';
    #[Rule('required|max:50|unique:users,name')]
    public $nombre;
    #[Rule('required')]
    public $rol;

    public function updatingSearch() {
        $this->resetPage();
    }

    public function limpiar_modal() {
        $this->reset([
            'user_id',
            'contraseña',
            'contraseña_confirmation',
            'nombre',
            'rol',
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function edit_contraseña($id) {
        $this->limpiar_modal();
        $this->user_id = $id;
    }

    public function update_contraseña() {
        $this->validate([
            'contraseña' => 'required',
            'contraseña_confirmation' => 'required|same:contraseña'
        ]);
        // buscar usuario
        $user = ModelsUser::find($this->user_id);
        $user->password = Hash::make($this->contraseña);
        $user->save();
        // mensaje de exito
        $this->dispatch('toast-basico',
            text: 'Se actualizó la contraseña correctamente',
            color: 'success'
        );
        // cerrar modal
        $this->dispatch('modal',
            modal: '#modal-edit-contraseña',
            action: 'hide'
        );
        // limpiar modal
        $this->limpiar_modal();
    }

    public function edit_user($id) {
        $this->limpiar_modal();
        $this->modo = 'edit';
        $this->title_modal = 'Editar usuario';
        $this->button_modal = 'Guardar';
        $this->user_id = $id;
        $user = ModelsUser::find($id);
        $this->nombre = $user->name;
        $this->rol = $user->roles->first()->id;
    }

    public function guardar() {
        $this->validate([
            'nombre' => 'required|max:50|unique:users,name,' . $this->user_id . ',id',
            'rol' => 'required',
        ]);

        if ($this->modo == 'create') {
            // mostramos el mensaje de exito
            $this->dispatch('toast-basico',
                text: 'Se ha creado un nuevo usuario',
                color: 'success'
            );
        } elseif ($this->modo == 'edit') {
            // actualizamos el usuario
            $user = ModelsUser::find($this->user_id);
            $user->name = $this->nombre;
            $user->save();
            // actualizamos el rol
            $user->roles()->sync($this->rol);
            // mostramos el mensaje de exito
            $this->dispatch('toast-basico',
                text: 'Se ha actualizado el usuario',
                color: 'success'
            );
        }
        // cerrar modal
        $this->dispatch('modal',
            modal: '#modal-user',
            action: 'hide'
        );
        // limpiar modal
        $this->limpiar_modal();
    }

    public function render() {
        $users = ModelsUser::join('personas', 'personas.id', '=', 'users.persona_id')
            ->select('users.*', 'personas.nombres', 'personas.apePaterno', 'personas.apeMaterno', 'personas.dni', 'personas.sexo')
            ->where('users.borrado', 0)
            ->where('users.activo', 1)
            ->where('users.id', '!=', auth()->user()->id)
            ->where(function ($query) {
                $query->where(DB::raw("CONCAT(personas.nombres, ' ', personas.apePaterno, ' ', personas.apeMaterno)"), 'like', '%' . $this->search . '%')
                    ->orWhere('personas.dni', 'like', '%' . $this->search . '%')
                    ->orWhere('users.name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('personas.id', 'desc')
            ->paginate($this->mostrar_paginate);

        $roles = Roles::where('borrado', 0)
            ->where('activo', 1)
            ->get();

        return view('livewire.administrador.user', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
