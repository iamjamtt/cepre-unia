<?php

namespace App\Livewire\Auth;

use App\Helpers\HelpersUnia;
use App\Models\Ciclo;
use App\Models\Fecha;
use App\Models\Inscripcion;
use App\Models\Persona;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login - Cepre Unia')]
#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Rule('required|numeric|digits:8')]
    public $dni;

    #[Rule('required')]
    public $contraseña;

    // variables de ciclo
    public $ciclo;
    public $fechas;
    public $usuario;

    public function mount() {
        $this->ciclo = Ciclo::find(HelpersUnia::getIdCiclo());
        $this->fechas = Fecha::where('ciclo_id', $this->ciclo->id)->first();
    }

    public function ingresar() {
        $this->validate();

        $user = User::where('name', $this->dni)->first();

        if (!$user) {
            $this->addError('dni', 'Credenciales incorrectas.');
            // evento de toast basica
            $this->dispatch('toast-basico',
                text: 'Credenciales incorrectas.',
                color: 'danger'
            );
            return;
        }

        if ($user->activo == 0) {
            $this->addError('dni', 'Usuario desactivado.');
            // evento de toast basica
            $this->dispatch('toast-basico',
                text: 'Usuario desactivado.',
                color: 'danger'
            );
            return;
        }

        if (Hash::check($this->contraseña, $user->password)) {
            $rol = HelpersUnia::getRolByUser($user->id);

            if ($rol->id == 1) {
                auth()->login($user);
                return redirect()->route('administrador.home');
            } elseif ($rol->id == 2) {
                auth()->login($user);
                return redirect()->route('trabajador.home');
            } elseif ($rol->id == 4) {
                $fechaInicio = $this->fechas->iniInscripcion;
                $fechaFin = $this->fechas->finInscripcion;
                if (Carbon::now()->between($fechaInicio, $fechaFin)) {
                    $persona = $user->persona;
                    $inscripcion = Inscripcion::where('persona_id', $persona->id)
                        ->where('user_id', $user->id)
                        ->where('ciclo_id', HelpersUnia::getIdCiclo())
                        ->where('activo', 1)
                        ->where('borrado', 0)
                        ->first();
                    if (!$inscripcion) {
                        $ultima_inscripcion = Inscripcion::where('persona_id', $persona->id)
                            ->where('user_id', $user->id)
                            ->where('ciclo_id', '!=', HelpersUnia::getIdCiclo())
                            ->where('borrado', 0)
                            ->orderBy('id', 'desc')
                            ->first();
                        if ($ultima_inscripcion) {
                            // dd($ultima_inscripcion);
                            $this->dispatch('modal',
                                modal: '#modal-opciones',
                                action: 'show'
                            );
                            $this->usuario = $user;
                            return;
                        }
                        auth()->login($user);
                        return redirect()->route('postulante.matricula');
                    }
                    auth()->login($user);
                    return redirect()->route('postulante.home');
                } else {
                    // evento de toast basica
                    $this->dispatch('toast-basico',
                        text: 'El Ciclo ' . $this->ciclo->nombre . ' se encuentra cerrado.',
                        color: 'danger'
                    );
                }
            }else {
                return;
            }
        } else {
            $this->addError('dni', 'Credenciales incorrectas.');
            // evento de toast basica
            $this->dispatch('toast-basico',
                text: 'Credenciales incorrectas.',
                color: 'danger'
            );
            return;
        }
    }

    public function continuar() {
        auth()->login($this->usuario);
        return redirect()->route('postulante.matricula');
    }

    public function registro() {
        $fechaInicio = $this->fechas->iniInscripcion;
        $fechaFin = $this->fechas->finInscripcion;
        if (Carbon::now()->between($fechaInicio, $fechaFin)) {
            return redirect()->route('registro.postulantes');
        } else {
            // evento de toast basica
            $this->dispatch('toast-basico',
                text: 'El Ciclo ' . $this->ciclo->nombre . ' se encuentra cerrado.',
                color: 'danger'
            );
        }
    }

    public function render() {
        return view('livewire.auth.login');
    }
}
