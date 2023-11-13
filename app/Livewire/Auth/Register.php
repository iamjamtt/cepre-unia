<?php

namespace App\Livewire\Auth;

use App\Models\Departamento;
use App\Models\Grupo;
use App\Models\Language;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Registrar Cuenta - Cepre Unia')]
#[Layout('components.layouts.register')]
class Register extends Component
{
    public $paso = 1;
    public $totalPasos = 4;

    // variables de paso 1
    #[Rule('required|digits:8|unique:personas,dni')]
    public $dni;
    #[Rule('required|string|max:50')]
    public $apellido_paterno;
    #[Rule('required|string|max:50')]
    public $apellido_materno;
    #[Rule('required|string|max:100')]
    public $nombres;
    #[Rule('required|string|max:1')]
    public $sexo;
    #[Rule('required|date')]
    public $fecha_nacimiento;
    #[Rule('required|integer')]
    public $grupo_etnico;
    #[Rule('required|integer')]
    public $lengua_materna;
    #[Rule('nullable|array')]
    public $dominio_lengua = [];
    #[Rule('nullable|string|max:50')]
    public $segunda_lengua;
    #[Rule('required|email|unique:users,email')]
    public $correo_electronico;
    #[Rule('required|numeric|digits:9')]
    public $celular;
    #[Rule('nullable|numeric|digits:9')]
    public $celular_apoderado;
    #[Rule('required|string|max:100')]
    public $direccion;
    #[Rule('required|numeric')]
    public $region = null;
    public $provincias = [];
    #[Rule('required|numeric')]
    public $provincia = null;
    public $distritos = [];
    #[Rule('required|numeric')]
    public $distrito = null;
    #[Rule('nullable|string|max:100')]
    public $comunidad;

    // variables de paso 2
    #[Rule('required|numeric')]
    public $region_colegio = null;
    public $provincias_colegios = [];
    #[Rule('required|numeric')]
    public $provincia_colegio = null;
    public $distritos_colegios = [];
    #[Rule('required|numeric')]
    public $nombre_colegio = null;
    public $colegios = [];
    #[Rule('required|numeric')]
    public $distrito_colegio = null;
    #[Rule('required|numeric|digits:4')]
    public $año_termino_colegio;

    // variables de paso 3
    #[Rule('required')]
    public $usuario;
    #[Rule('required|min:8')]
    public $contraseña;
    #[Rule('required|min:8|same:contraseña')]
    public $contraseña_confirmacion;

    public function atras() {
        if ($this->paso > 1) {
            $this->paso--;
        }
    }

    public function siguiente() {
        if ($this->paso == 1) {
            $this->validate([
                'dni' => 'required|digits:8|unique:personas,dni',
                'apellido_paterno' => 'required|string|max:50',
                'apellido_materno' => 'required|string|max:50',
                'nombres' => 'required|string|max:100',
                'sexo' => 'required|string|max:1',
                'fecha_nacimiento' => 'required|date',
                'grupo_etnico' => 'required|numeric',
                'lengua_materna' => 'required|numeric',
                'dominio_lengua' => 'nullable|array',
                'segunda_lengua' => 'nullable|string|max:50',
                'correo_electronico' => 'required|email|unique:users,email',
                'celular' => 'required|numeric|digits:9',
                'celular_apoderado' => 'nullable|numeric|digits:9',
                'direccion' => 'required|string|max:100',
                'region' => 'required|numeric',
                'provincia' => 'required|numeric',
                'distrito' => 'required|numeric',
                'comunidad' => 'nullable|string|max:100',
            ]);
        }
        if ($this->paso == 2) {
            $this->validate([
                'region_colegio' => 'required|integer',
                'provincia_colegio' => 'required|integer',
                'distrito_colegio' => 'required|integer',
                'nombre_colegio' => 'required|integer',
                'año_termino_colegio' => 'required|numeric|digits:4',
            ]);
        }
        if ($this->paso == 3) {
            $this->validate([
                'usuario' => 'required',
                'contraseña' => 'required|min:8',
                'contraseña_confirmacion' => 'required|min:8|same:contraseña',
            ]);
        }
        if ($this->paso < $this->totalPasos) {
            $this->paso++;
        }
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updatedDni($value) {
        $this->usuario = $value;
    }

    public function updatedRegion($value) {
        if ($value == null) {
            $this->provincias = [];
            $this->distritos = [];
            $this->provincia = null;
            $this->distrito = null;
            return;
        }
        $this->provincias = Departamento::find($value)->provincias;
        $this->distritos = [];
        $this->provincia = null;
        $this->distrito = null;
    }

    public function updatedProvincia($value) {
        if ($value == null) {
            $this->distritos = [];
            $this->distrito = null;
            return;
        }
        $this->distritos = Departamento::find($this->region)->provincias->find($value)->distritos;
        $this->distrito = null;
    }

    public function updatedRegionColegio($value) {
        if ($value == null) {
            $this->provincias_colegios = [];
            $this->distritos_colegios = [];
            $this->colegios = [];
            $this->provincia_colegio = null;
            $this->distrito_colegio = null;
            $this->nombre_colegio = null;
            return;
        }
        $this->provincias_colegios = Departamento::find($value)->provincias;
        $this->distritos_colegios = [];
        $this->colegios = [];
        $this->provincia_colegio = null;
        $this->distrito_colegio = null;
        $this->nombre_colegio = null;
    }

    public function updatedProvinciaColegio($value) {
        if ($value == null) {
            $this->distritos_colegios = [];
            $this->colegios = [];
            $this->distrito_colegio = null;
            $this->nombre_colegio = null;
            return;
        }
        $this->distritos_colegios = Departamento::find($this->region_colegio)->provincias->find($value)->distritos;
        $this->colegios = [];
        $this->distrito_colegio = null;
        $this->nombre_colegio = null;
    }

    public function updatedDistritoColegio($value) {
        if ($value == null) {
            $this->colegios = [];
            $this->nombre_colegio = null;
            return;
        }
        $this->colegios = Departamento::find($this->region_colegio)->provincias->find($this->provincia_colegio)->distritos->find($value)->colegios;
        $this->nombre_colegio = null;
    }

    public function finalizar_registro() {
        // creamos la persona
        $persona = new Persona();
        $persona->nombres = strtoupper($this->nombres);
        $persona->apePaterno = strtoupper($this->apellido_paterno);
        $persona->apeMaterno = strtoupper($this->apellido_materno);
        $persona->dni = $this->dni;
        $persona->celular = $this->celular;
        $persona->celularApoderado = $this->celular_apoderado ?? null;
        $persona->direccion = $this->direccion ?? null;
        $persona->fechaNac = $this->fecha_nacimiento;
        $persona->sexo = $this->sexo;
        $persona->dominio_lengua = json_encode($this->dominio_lengua) ?? null;
        $persona->segunda_lengua = $this->segunda_lengua ?? null;
        $persona->comunidad = $this->comunidad ?? null;
        $persona->colegioFin = $this->año_termino_colegio;
        $persona->observacion = null;
        $persona->activo = 1;
        $persona->borrado = 0;
        $persona->completo = 1;
        $persona->colegio_id = $this->nombre_colegio;
        $persona->distrito_id = $this->distrito;
        $persona->grupo_id = $this->grupo_etnico;
        $persona->language_id = $this->lengua_materna;
        $persona->save();
        // creamos su usuario
        $user = new User();
        $user->name = $this->usuario;
        $user->email = $this->correo_electronico;
        $user->password = Hash::make($this->contraseña);
        $user->activo = 1;
        $user->borrado = 0;
        $user->persona_id = $persona->id;
        $user->save();
        // creamos su rol
        $user->roles()->attach(4); // 4 es el id del rol postulante
        // creamos su sesion
        auth()->login($user);
        // redireccionamos a la pagina de inicio
        return redirect()->route('postulante.matricula');
    }

    public function render() {
        $grupos = Grupo::where('activo', 1)
            ->get();
        $lenguas_maternas = Language::where('activo', 1)
            ->get();
        $departamentos = Departamento::where('activo', 1)
            ->where('countrie_id', 179)
            ->get();

        return view('livewire.auth.register', [
            'grupos' => $grupos,
            'lenguas_maternas' => $lenguas_maternas,
            'departamentos' => $departamentos,
        ]);
    }
}
