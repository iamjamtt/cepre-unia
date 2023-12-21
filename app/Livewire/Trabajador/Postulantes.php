<?php

namespace App\Livewire\Trabajador;

use App\Helpers\HelpersUnia;
use App\Models\Inscripcion;
use App\Models\Pago;
use App\Models\Persona;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Postulantes - CEPRE UNIA')]
#[Layout('components.layouts.register')]
class Postulantes extends Component
{
    #[Url('dni')]
    #[Rule('required|numeric|digits:8')]
    public $buscar;
    public $persona = null;
    public $user = null;
    public $inscripcion = null;
    public $carrera = null;
    public $pago = null;
    public $fotografia = null;
    public $documentos = [];

    public function buscar_postulante() {
        if ($this->buscar == null || $this->buscar == '') {
            // mostrar mensaje de error
            $this->dispatch('toast-basico',
                text: 'Campo de búsqueda vacío',
                color: 'danger'
            );
            return;
        }
        // buscar persona
        $persona = Persona::where('dni', $this->buscar)
            ->where('activo', 1)
            ->where('borrado', 0)
            ->first();
        if (!$persona) {
            // mostrar mensaje de error
            $this->dispatch('toast-basico',
                text: 'El DNI ingresado no pertenece a un postulante',
                color: 'danger'
            );
            return;
        }
        $user = $persona->user;
        $rol = $user->roles->first();
        if ($rol && $rol->id != 4) {
            // mostrar mensaje de error
            $this->dispatch('toast-basico',
                text: 'El DNI ingresado no pertenece a un postulante',
                color: 'danger'
            );
            $this->reset(['persona', 'user', 'inscripcion', 'pago', 'fotografia', 'documentos']);
            return;
        }
        $this->persona = $persona;
        $this->user = $user;
        $this->inscripcion = Inscripcion::where('persona_id', $this->persona->id)->orderBy('id', 'desc')->first();
        if (!$this->inscripcion) {
            // mostrar mensaje de error
            $this->dispatch('toast-basico',
                text: 'El DNI ingresado no cuenta con una inscripción',
                color: 'danger'
            );
            $this->reset(['persona', 'user', 'inscripcion', 'pago', 'fotografia', 'documentos']);
            return;
        }
        $this->carrera = $this->inscripcion->carrera->nombre;
        $this->pago = Pago::where('inscripcion_id', $this->inscripcion->id)->first();
        $archivo_foto = HelpersUnia::existeArchivo($this->inscripcion->ciclo_id, $this->inscripcion->persona_id, 1); // 1 = foto
        $this->fotografia = $archivo_foto->ruta ?? null;
        $archivo_dni = HelpersUnia::existeArchivo($this->inscripcion->ciclo_id, $this->inscripcion->persona_id, 2); // 2 = dni
        $archivo_pago = HelpersUnia::existeArchivo($this->inscripcion->ciclo_id, $this->inscripcion->persona_id, 3); // 3 = pago
        $archivo_certificado = HelpersUnia::existeArchivo($this->inscripcion->ciclo_id, $this->inscripcion->persona_id, 4); // 4 = certificado
        $archivo_partida = HelpersUnia::existeArchivo($this->inscripcion->ciclo_id, $this->inscripcion->persona_id, 5); // 5 = partida de naicimiento
        $archivo_constancia = HelpersUnia::existeArchivo($this->inscripcion->ciclo_id, $this->inscripcion->persona_id, 6); // 6 = constancia de egresado
        if ($persona->grupo_id == 1) {
            $this->documentos = collect([
                ['id' => '1', 'nombre' => 'Fotografía', 'archivo' => $archivo_foto, 'ruta' => $archivo_foto->ruta ?? ''],
                ['id' => '2', 'nombre' => 'DNI', 'archivo' => $archivo_dni, 'ruta' => $archivo_dni->ruta ?? ''],
                ['id' => '3', 'nombre' => 'Pago', 'archivo' => $archivo_pago, 'ruta' => $archivo_pago->ruta ?? ''],
                ['id' => '4', 'nombre' => 'Certificado de Estudios', 'archivo' => $archivo_certificado, 'ruta' => $archivo_certificado->ruta ?? ''],
                ['id' => '5', 'nombre' => 'Partida de Nacimiento', 'archivo' => $archivo_partida, 'ruta' => $archivo_partida->ruta ?? '']
            ]);
        } else {
            $this->documentos = collect([
                ['id' => '1', 'nombre' => 'Fotografía', 'archivo' => $archivo_foto, 'ruta' => $archivo_foto->ruta ?? ''],
                ['id' => '2', 'nombre' => 'DNI', 'archivo' => $archivo_dni, 'ruta' => $archivo_dni->ruta ?? ''],
                ['id' => '3', 'nombre' => 'Pago', 'archivo' => $archivo_pago, 'ruta' => $archivo_pago->ruta ?? ''],
                ['id' => '4', 'nombre' => 'Certificado de Estudios', 'archivo' => $archivo_certificado, 'ruta' => $archivo_certificado->ruta ?? ''],
                ['id' => '5', 'nombre' => 'Partida de Nacimiento', 'archivo' => $archivo_partida, 'ruta' => $archivo_partida->ruta ?? ''],
                ['id' => '6', 'nombre' => 'Constancia de Comunidad', 'archivo' => $archivo_constancia, 'ruta' => $archivo_constancia->ruta ?? '']
            ]);
        }
    }

    public function limpiar() {
        $this->reset(['buscar', 'persona', 'user', 'inscripcion', 'pago', 'fotografia', 'documentos']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render() {
        return view('livewire.trabajador.postulantes');
    }
}
