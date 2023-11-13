<?php

namespace App\Livewire\Trabajador;

use App\Exports\Reportes\IngresantesByCiclo;
use App\Helpers\HelpersUnia;
use App\Models\Inscripcion;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Reportes\InscripcionesByCiclo;
use App\Models\Grupo;
use App\Models\Ingresante;
use Livewire\Attributes\Url;

#[Title('Home - CEPRE UNIA')]
#[Layout('components.layouts.app')]
class Home extends Component
{
    #[Url('pueblos-originarios')]
    public $nombre_pueblos_originarios = 'Pueblos Originarios';
    #[Url('grupo')]
    public $grupo_id = '';
    public $hidde = false;

    public function reporte_inscritos() {
        $nombre_excel = 'listado de postulantes inscritos en el ciclo';
        $nombre_excel = Str::slug($nombre_excel, '-') . '-' . HelpersUnia::getNombreCiclo() . '.xlsx';
        return Excel::download(new InscripcionesByCiclo(HelpersUnia::getIdCiclo()), $nombre_excel);
    }

    public function seleccionar_pueblo_originario($grupo_id) {
        $this->grupo_id = $grupo_id;
        if ($grupo_id != '') {
            $grupo = Grupo::find($grupo_id);
            $this->nombre_pueblos_originarios = $grupo->nombre;
        } else {
            $this->nombre_pueblos_originarios = 'Pueblos Originarios';
        }
        $this->hidde = true;
    }

    public function reporte_ingresantes() {
        $nombre_excel = 'listado de postulantes ingresantes en el ciclo';
        $nombre_excel = Str::slug($nombre_excel, '-') . '-' . HelpersUnia::getNombreCiclo() . '.xlsx';
        return Excel::download(new IngresantesByCiclo(HelpersUnia::getIdCiclo()), $nombre_excel);
    }

    public function render() {
        $inscripciones = Inscripcion::where('ciclo_id', HelpersUnia::getIdCiclo())
            ->where('activo', 1)
            ->get();
        $mestizos = Inscripcion::join('personas', 'inscripcions.persona_id','=','personas.id')
            ->where('inscripcions.ciclo_id', HelpersUnia::getIdCiclo())
            ->where('inscripcions.activo', 1)
            ->where('personas.grupo_id', 1)
            ->get();
        $pueblos_originarios = Inscripcion::join('personas', 'inscripcions.persona_id','=','personas.id')
            ->where('inscripcions.ciclo_id', HelpersUnia::getIdCiclo())
            ->where('personas.grupo_id', $this->grupo_id == null ? '!=' : '=', $this->grupo_id == null ? 1 : $this->grupo_id)
            ->where('inscripcions.activo', 1)
            ->get();
        $grupos_pueblos_originarios = Grupo::where('id', '!=', 1)->get();
        $ingresantes_count = Ingresante::where("ciclo_id", HelpersUnia::getIdCiclo())->count();
        return view('livewire.trabajador.home', [
            'inscripciones' => $inscripciones,
            'mestizos' => $mestizos,
            'pueblos_originarios' => $pueblos_originarios,
            'grupos_pueblos_originarios' => $grupos_pueblos_originarios,
            'ingresantes_count' => $ingresantes_count
        ]);
    }
}
