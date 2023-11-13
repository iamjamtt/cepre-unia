<?php

namespace App\Livewire\Components;

use App\Helpers\HelpersUnia;
use App\Models\Inscripcion;
use Livewire\Component;

class Sidebar extends Component
{
    public function logout() {
        auth()->logout();
        return redirect()->route('login');
    }

    public function render() {
        $user = auth()->user();
        $persona = $user->persona;
        $rol = $user->roles->first();

        $inscripcion = Inscripcion::where('persona_id', $persona->id)
            ->where('user_id', $user->id)
            ->where('ciclo_id', HelpersUnia::getIdCiclo())
            ->where('activo', 1)
            ->where('borrado', 0)
            ->first();

        return view('livewire.components.sidebar', [
            'user' => $user,
            'persona' => $persona,
            'rol' => $rol,
            'inscripcion' => $inscripcion,
        ]);
    }
}
