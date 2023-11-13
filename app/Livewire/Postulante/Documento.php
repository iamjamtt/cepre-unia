<?php

namespace App\Livewire\Postulante;

use App\Helpers\HelpersUnia;
use App\Models\Inscripcion;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Documento extends Component
{
    use WithFileUploads;

    public $user;
    public $persona;

    // variable para modal
    public $titulo_modal = 'Subir Documento';
    public $nombre_documento = '';
    public $tipo_documento;
    public $tipo_modal = 'create';
    #[Rule('required|image|max:2048')]
    public $documento;

    public function mount() {
        $this->user = auth()->user();
        $this->persona = $this->user->persona;
    }

    public function modal_documento($tipo, $value) {
        $this->limpiar_modal();
        $this->tipo_documento = $tipo;
        if ($tipo == 1) {
            $this->nombre_documento = 'Fotografía';
        } elseif ($tipo == 2) {
            $this->nombre_documento = 'DNI';
        } elseif ($tipo == 3) {
            $this->nombre_documento = 'Documento de Pago';
        } elseif ($tipo == 4) {
            $this->nombre_documento = 'Certificado de Estudios';
        } elseif ($tipo == 5) {
            $this->nombre_documento = 'Partida de Nacimiento';
        } elseif ($tipo == 6) {
            $this->nombre_documento = 'Constancia de Comunidad';
        }
        if ($value == true) {
            $this->titulo_modal = 'Editar Documento';
            $this->tipo_modal = 'edit';
        } else {
            $this->titulo_modal = 'Subir Documento';
            $this->tipo_modal = 'create';
        }
    }

    public function limpiar_modal() {
        $this->documento = null;
        $this->titulo_modal = 'Subir Documento';
        $this->nombre_documento = '';
        $this->tipo_modal = 'create';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function guardar_documento() {
        $this->validate();
        if ($this->tipo_documento == 1) {
            $carpeta = 'photos';
        } else {
            $carpeta = 'archivos';
        }
        $inscripcion = $this->persona->inscripciones()->orderBy('id', 'desc')->first();
        // creamos el voucher en el modelo de archivo
        if ($this->documento) {
            HelpersUnia::subirArchivo($this->documento, $carpeta, $this->tipo_documento, $inscripcion->ciclo_id, $inscripcion->persona_id);
        }
        // mostramos el mensaje
        if ($this->tipo_modal == 'create') {
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
        // cerramos el modal
        $this->dispatch('modal',
            modal: '#modal-documento',
            action: 'hide'
        );
        // limpiamos el modal
        $this->limpiar_modal();
    }

    public function render() {
        $inscripcion = $this->persona
            ->inscripciones()
            ->where('ciclo_id', HelpersUnia::getIdCiclo())
            ->where('activo', 1)
            ->where('borrado', 0)
            ->orderBy('id', 'desc')
            ->first();
        $archivo_foto = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 1); // 1 = foto
        $archivo_dni = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 2); // 2 = dni
        $archivo_pago = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 3); // 3 = pago
        $archivo_certificado = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 4); // 4 = certificado
        $archivo_partida = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 5); // 5 = partida de naicimiento
        $archivo_constancia = HelpersUnia::existeArchivo($inscripcion->ciclo_id, $inscripcion->persona_id, 6); // 6 = constancia de egresado
        if ($this->persona->grupo_id == 1) {
            $documentos = collect([
                ['id' => '1', 'nombre' => 'Fotografía', 'archivo' => $archivo_foto, 'ruta' => $archivo_foto->ruta ?? '', 'tipo' => $archivo_foto->tipo ?? null],
                ['id' => '2', 'nombre' => 'DNI', 'archivo' => $archivo_dni, 'ruta' => $archivo_dni->ruta ?? '', 'tipo' => $archivo_dni->tipo ?? null],
                ['id' => '3', 'nombre' => 'Pago', 'archivo' => $archivo_pago, 'ruta' => $archivo_pago->ruta ?? '', 'tipo' => $archivo_pago->tipo ?? null],
                ['id' => '4', 'nombre' => 'Certificado de Estudios', 'archivo' => $archivo_certificado, 'ruta' => $archivo_certificado->ruta ?? '', 'tipo' => $archivo_certificado->tipo ?? null],
                ['id' => '5', 'nombre' => 'Partida de Nacimiento', 'archivo' => $archivo_partida, 'ruta' => $archivo_partida->ruta ?? '', 'tipo' => $archivo_partida->tipo ?? null]
            ]);
        } else {
            $documentos = collect([
                ['id' => '1', 'nombre' => 'Fotografía', 'archivo' => $archivo_foto, 'ruta' => $archivo_foto->ruta ?? '', 'tipo' => $archivo_foto->tipo ?? null],
                ['id' => '2', 'nombre' => 'DNI', 'archivo' => $archivo_dni, 'ruta' => $archivo_dni->ruta ?? '', 'tipo' => $archivo_dni->tipo ?? null],
                ['id' => '3', 'nombre' => 'Pago', 'archivo' => $archivo_pago, 'ruta' => $archivo_pago->ruta ?? '', 'tipo' => $archivo_pago->tipo ?? null],
                ['id' => '4', 'nombre' => 'Certificado de Estudios', 'archivo' => $archivo_certificado, 'ruta' => $archivo_certificado->ruta ?? '', 'tipo' => $archivo_certificado->tipo ?? null],
                ['id' => '5', 'nombre' => 'Partida de Nacimiento', 'archivo' => $archivo_partida, 'ruta' => $archivo_partida->ruta ?? '', 'tipo' => $archivo_partida->tipo ?? null],
                ['id' => '6', 'nombre' => 'Constancia de Comunidad', 'archivo' => $archivo_constancia, 'ruta' => $archivo_constancia->ruta ?? '', 'tipo' => $archivo_constancia->tipo ?? null]
            ]);
        }
        return view('livewire.postulante.documento', [
            'inscripcion' => $inscripcion,
            'documentos' => $documentos
        ]);
    }
}
