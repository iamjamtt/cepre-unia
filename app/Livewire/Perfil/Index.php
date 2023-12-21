<?php

namespace App\Livewire\Perfil;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Perfil - CEPRE UNIA')]
#[Layout('components.layouts.app')]
class Index extends Component
{
    public function render()
    {
        $user = auth()->user();
        $persona = $user->persona;
        $rol = $user->roles->first();

        return view('livewire.perfil.index', [
            'user' => $user,
            'persona' => $persona,
            'rol' => $rol,
        ]);
    }
}
