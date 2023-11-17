<?php

namespace App\Livewire\Postulante;

use App\Helpers\HelpersUnia;
use App\Models\Area;
use App\Models\Fecha;
use App\Models\Inscripcion;
use App\Models\LugarPago;
use App\Models\Pago;
use App\Models\Pregunta;
use App\Models\TipoPago;
use App\Models\Turno;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Finalizar Matricuala - Cepre Unia')]
#[Layout('components.layouts.app')]
class Matricula extends Component
{
    use WithFileUploads;

    public $paso = 1;
    public $totalPasos = 4;

    // variables paso 1
    #[Rule('required|numeric')]
    public $metodo_pago;
    #[Rule('required|numeric')]
    public $lugar_pago;
    #[Rule('required|date')]
    public $fecha_pago;
    #[Rule('required|image|max:2048')]
    public $voucher;
    // variables paso 2
    #[Rule('required|numeric')]
    public $area;
    public $carreras = [];
    #[Rule('required|numeric')]
    public $carrera = null;
    #[Rule('required|numeric')]
    public $turno;
    // variables paso 3
    #[Rule('required|array')]
    public $respuesta = [];

    public function atras() {
        if ($this->paso > 1) {
            $this->paso--;
        }
    }

    public function siguiente() {
        if ($this->paso == 1) {
            $this->validate([
                'metodo_pago' => 'required|numeric',
                'lugar_pago' => 'required|numeric',
                'fecha_pago' => 'required|date',
                'voucher' => 'required|image|max:2048',
            ]);
        }
        if ($this->paso == 2) {
            $this->validate([
                'area' => 'required|numeric',
                'carrera' => 'required|numeric',
                'turno' => 'required|numeric',
            ]);
        }
        if ($this->paso == 3) {
            $this->validate([
                'respuesta' => 'required|array'
            ]);
            // validar si hay respuestas vacias
            if (count($this->respuesta) != count(Pregunta::where('activo', 1)->get())) {
                // evento de toast basica
                $this->dispatch('toast-basico',
                    text: 'Debe responder todas las preguntas.',
                    color: 'danger'
                );
                return;
            }
            // validar si hay respuestas vacias
            foreach ($this->respuesta as $key => $value) {
                if ($value == null) {
                    // evento de toast basica
                    $this->dispatch('toast-basico',
                        text: 'Debe responder todas las preguntas.',
                        color: 'danger'
                    );
                    return;
                }
            }
        }
        if ($this->paso < $this->totalPasos) {
            $this->paso++;
        }
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updatedArea($value) {
        if ($value) {
            $this->carreras = Area::find($value)->carreras;
            $this->carrera = null;
        } else {
            $this->carreras = collect([]);
            $this->carrera = null;
        }
    }

    public function finalizar_matricula() {
        // creamos la matricula
        $inscripcion = new Inscripcion();
        $inscripcion->estado = 1;
        $inscripcion->aula = null;
        $inscripcion->numero = null;
        $inscripcion->fecha = null;
        $inscripcion->foto = 0;
        $inscripcion->documento = 0;
        $inscripcion->ingreso= null;
        $inscripcion->opcion = 1;
        $inscripcion->carrera_id = $this->carrera;
        $inscripcion->carrera2_id = null;
        $inscripcion->ciclo_id = HelpersUnia::getIdCiclo();
        $inscripcion->modalidad_id = 1;
        $inscripcion->persona_id = auth()->user()->persona->id;
        $inscripcion->turno_id = $this->turno;
        $inscripcion->user_id = auth()->user()->id;
        $inscripcion->save();
        // creamos el pago
        $pago = new Pago();
        $pago->codigo = null;
        $pago->fecha = $this->fecha_pago;
        $pago->verificacion = 0;
        $pago->ciclo_id = HelpersUnia::getIdCiclo();
        $pago->inscripcion_id = $inscripcion->id;
        $pago->lugarpago_id = $this->lugar_pago;
        $pago->tipopago_id = $this->metodo_pago;
        $pago->verification_id = null;
        $pago->save();
        // creamos las respuestas
        $persona = auth()->user()->persona;
        foreach ($this->respuesta as $key => $value) {
            $persona->preguntas()->attach($key, ['ciclo_id' => HelpersUnia::getIdCiclo(), 'valor' => $value]);
        }
        // creamos el voucher en el modelo de archivo
        if ($this->voucher) {
            HelpersUnia::subirArchivo($this->voucher, 'archivos', 3, HelpersUnia::getIdCiclo(), $persona->id); // 3 = pago
        }
        // evento de toast basica
        $this->dispatch('toast-basico',
            text: 'Se ha registrado su matricula correctamente.',
            color: 'success'
        );
        // redireccionamos al home
        return redirect()->route('postulante.home');
    }

    public function render() {
        $persona = auth()->user()->persona;
        $tipos_pagos = TipoPago::where('grupo', $persona->grupo_id == 1 ? 1 : 0)
            ->where('activo', 1)
            ->where('modalidad_id', 1)
            ->get();
        $lugar_pagos = LugarPago::where('activo', 1)->get();
        $areas = Area::where('activo', 1)
            ->where('borrado', 0)
            ->get();
        $turnos = Turno::where('activo', 1)->get();
        $preguntas = Pregunta::where('activo', 1)->get();

        return view('livewire.postulante.matricula', [
            'tipos_pagos' => $tipos_pagos,
            'lugar_pagos' => $lugar_pagos,
            'areas' => $areas,
            'turnos' => $turnos,
            'preguntas' => $preguntas,
        ]);
    }
}
