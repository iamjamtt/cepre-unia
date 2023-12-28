<?php

namespace App\Livewire\Postulante;

use App\Helpers\HelpersUnia;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Home - CEPRE UNIA')]
#[Layout('components.layouts.app')]
class Home extends Component
{
    use WithFileUploads;

    #[Rule('required|image|max:2048')]
    public $foto;
    #[Rule('required|image|max:2048')]
    public $dni;
    #[Rule('required|image|max:2048')]
    public $certificado;
    #[Rule('required|image|max:2048')]
    public $partida;
    #[Rule('required|image|max:2048')]
    public $constancia;


    public $foto_archivo;
    public $dni_archivo;
    public $certificado_archivo;
    public $partida_archivo;
    public $constancia_archivo;

    #[On('mensaje-bienvenida')]
    public function mensaje() {
        $this->dispatch('toast-basico',
            text: 'Bienvenido a la plataforma de CEPRE UNIA.',
            color: 'info'
        );
    }

    public function guardar_foto() {
        $this->validate([
            'foto' => 'required|image|max:4096'
        ]);
        if ($this->foto) {
            HelpersUnia::subirArchivo($this->foto, 'photos', 1, HelpersUnia::getIdCiclo(), auth()->user()->persona->id);
        }
        // evento de toast basica
        $this->dispatch('toast-basico',
            text: 'Se ha guardado la fotografía correctamente.',
            color: 'success'
        );
        // evento de toast basica
        $this->dispatch('toast-basico',
            text: 'La fotografía será revisada y validada por el administrador.',
            color: 'success'
        );
    }

    public function guardar_documentos() {
        $persona = auth()->user()->persona;
        $mestizo = $persona->grupo_id == 1 ? true : false;
        // validacion de documentos
        if ($mestizo) {
            $this->validate([
                'dni' => 'required|image|max:4096',
                'certificado' => 'required|image|max:4096',
                'partida' => 'required|image|max:4096'
            ]);
        } else {
            if ($this->dni_archivo && $this->certificado_archivo && $this->partida_archivo && $this->constancia_archivo == null) {
                $this->validate([
                    'constancia' => 'required|image|max:4096'
                ]);
            } else {
                $this->validate([
                    'dni' => 'required|image|max:4096',
                    'certificado' => 'required|image|max:4096',
                    'partida' => 'required|image|max:4096',
                    'constancia' => 'required|image|max:4096'
                ]);
            }
        }
        // subir documento de dni
        if ($this->dni) {
            HelpersUnia::subirArchivo($this->dni, 'archivos', 2, HelpersUnia::getIdCiclo(), $persona->id); // dni
        }
        // subir documento de certificado
        if ($this->certificado) {
            HelpersUnia::subirArchivo($this->certificado, 'archivos', 4, HelpersUnia::getIdCiclo(), $persona->id); // certificado
        }
        // subir documento de partida
        if ($this->partida) {
            HelpersUnia::subirArchivo($this->partida, 'archivos', 5, HelpersUnia::getIdCiclo(), $persona->id); // partida
        }
        // subir documento de constancia
        if (!$mestizo) {
            if ($this->constancia) {
                HelpersUnia::subirArchivo($this->constancia, 'archivos', 6, HelpersUnia::getIdCiclo(), $persona->id); // constancia
            }
        }
        // evento de toast basica
        $this->dispatch('toast-basico',
            text: 'Se han guardado los documentos correctamente.',
            color: 'success'
        );
    }

    public function subir_dni() {
        $this->validate([
            'dni' => 'required|image|max:4096'
        ]);
        if ($this->dni) {
            HelpersUnia::subirArchivo($this->dni, 'archivos', 2, HelpersUnia::getIdCiclo(), auth()->user()->persona->id);
        }
        // evento de toast basica
        $this->dispatch('toast-basico',
            text: 'Se ha guardado el documento correctamente.',
            color: 'success'
        );
    }

    public function subir_certificado() {
        $this->validate([
            'certificado' => 'required|image|max:4096'
        ]);
        if ($this->certificado) {
            HelpersUnia::subirArchivo($this->certificado, 'archivos', 4, HelpersUnia::getIdCiclo(), auth()->user()->persona->id);
        }
        // evento de toast basica
        $this->dispatch('toast-basico',
            text: 'Se ha guardado el documento correctamente.',
            color: 'success'
        );
    }

    public function subir_partida() {
        $this->validate([
            'partida' => 'required|image|max:4096'
        ]);
        if ($this->partida) {
            HelpersUnia::subirArchivo($this->partida, 'archivos', 5, HelpersUnia::getIdCiclo(), auth()->user()->persona->id);
        }
        // evento de toast basica
        $this->dispatch('toast-basico',
            text: 'Se ha guardado el documento correctamente.',
            color: 'success'
        );
    }

    public function subir_constancia() {
        $this->validate([
            'constancia' => 'required|image|max:4096'
        ]);
        if ($this->constancia) {
            HelpersUnia::subirArchivo($this->constancia, 'archivos', 6, HelpersUnia::getIdCiclo(), auth()->user()->persona->id);
        }
        // evento de toast basica
        $this->dispatch('toast-basico',
            text: 'Se ha guardado el documento correctamente.',
            color: 'success'
        );
    }

    public function render() {
        $user = auth()->user();
        $persona = $user->persona;
        $inscripcion = $persona
            ->inscripciones()
            ->where('ciclo_id', HelpersUnia::getIdCiclo())
            ->where('activo', 1)
            ->where('borrado', 0)
            ->orderBy('id', 'desc')
            ->first();
        $this->foto_archivo = HelpersUnia::existeArchivo(HelpersUnia::getIdCiclo(), $persona->id, 1);
        $mestizo = $persona->grupo_id == 1 ? true : false;
        $this->dni_archivo = HelpersUnia::existeArchivo(HelpersUnia::getIdCiclo(), $persona->id, 2);
        $this->certificado_archivo = HelpersUnia::existeArchivo(HelpersUnia::getIdCiclo(), $persona->id, 4);
        $this->partida_archivo = HelpersUnia::existeArchivo(HelpersUnia::getIdCiclo(), $persona->id, 5);
        $this->constancia_archivo = HelpersUnia::existeArchivo(HelpersUnia::getIdCiclo(), $persona->id, 6);
        return view('livewire.postulante.home', [
            'user' => $user,
            'persona' => $persona,
            'inscripcion' => $inscripcion,
            'mestizo' => $mestizo,
        ]);
    }
}
