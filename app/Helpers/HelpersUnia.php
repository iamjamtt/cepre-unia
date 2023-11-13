<?php

namespace App\Helpers;

use App\Exports\Reportes\InscripcionesByCiclo;
use App\Models\Archivo;
use App\Models\Ciclo;
use App\Models\Inscripcion;
use App\Models\Persona;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class HelpersUnia {
    public static function getIdCiclo() {
        $ciclo = Ciclo::where('estado', 1)->where('activo', 1)->first();
        return $ciclo->id;
    }

    public static function getNombreCiclo() {
        $ciclo = Ciclo::where('estado', 1)->where('activo', 1)->first();
        return $ciclo->nombre;
    }

    public static function getCicloInicio() {
        $ciclo = Ciclo::where('estado', 1)->where('activo', 0)->first();
        return $ciclo->fechaInicio;
    }

    public static function getCicloFin() {
        $ciclo = Ciclo::where('estado', 1)->where('activo', 0)->first();
        return $ciclo->fechaFin;
    }

    public static function getRol() {
        $user = auth()->user();
        if (!$user) {
            return null;
        }
        $rol = $user->roles->first();
        return $rol;
    }

    public static function getRolByUser($user_id) {
        $rol = User::find($user_id)->roles->first();
        return $rol;
    }

    public static function getNombreCompleto($persona_id) {
        $persona = Persona::find($persona_id);
        $nombre = $persona->nombres;
        $apePaterno = $persona->apePaterno;
        $apeMaterno = $persona->apeMaterno;
        return $apePaterno . ' ' . $apeMaterno . ', ' . $nombre;
    }

    public static function getSexo($value) {
        if ($value == 'M') {
            return 'MASCULINO';
        } else {
            return 'FEMENINO';
        }
    }

    public static function convertirFecha($value) {
        return date('d/m/Y', strtotime($value));
    }

    public static function convertirFechaHora($value) {
        return date('d/m/Y h:i A', strtotime($value));
    }

    public static function convertirFechaTexto($fecha) {
        $date = Carbon::parse($fecha, 'UTC');
        return $date->isoFormat('D MMMM YYYY');
    }

    public static function existeArchivoFoto($ciclo_id, $persona_id) {
        $archivo = Archivo::where('ciclo_id', $ciclo_id)
            ->where('persona_id', $persona_id)
            ->where('tipo', 1)
            ->where('activo', 1)
            ->where('borrado', 0)
            ->first();

        $inscripcion = Inscripcion::where('persona_id', $persona_id)
            ->where('ciclo_id', $ciclo_id)
            ->where('activo', 1)
            ->where('borrado', 0)
            ->first();

        if ($archivo && $inscripcion && $inscripcion->foto == 1) {
            return [
                'existe' => true,
                'ruta' => $archivo->ruta,
            ];
        } else {
            $rol = auth()->user()->roles->first();
            $sexo = auth()->user()->persona->sexo;
            if ($rol->id == 2) {
                return [
                    'existe' => false,
                    'ruta' => $sexo == "M" ? "static/avatar-m-trabajador.png" : "static/avatar-f-trabajador.jpg",
                ];
            } elseif ($rol->id == 4) {
                return [
                    'existe' => false,
                    'ruta' => $sexo == "M" ? "static/avatar-m-postulante.jpg" : "static/avatar-f-postulante.jpg",
                ];
            } else {
                return [
                    'existe' => false,
                    'ruta' => "static/avatar.png"
                ];
            }
        }
    }

    public static function existeArchivo($ciclo_id, $persona_id, $tipo) {
        $archivo = Archivo::where('ciclo_id', $ciclo_id)
            ->where('persona_id', $persona_id)
            ->where('tipo', $tipo)
            ->where('activo', 1)
            ->where('borrado', 0)
            ->first();
        return $archivo;
    }

    public static function existeArchivoEnProyecto($archivo) {
        return File::exists($archivo);
    }

    public static function getRouteHome() {
        $rol = HelpersUnia::getRol();
        if (!$rol) {
            return 'login';
        }
        if ($rol->id == 1) {
            return 'administrador.home';
        } elseif ($rol->id == 2) {
            return 'trabajador.home';
        } elseif ($rol->id == 4) {
            $persona = auth()->user()->persona;
            $inscripcion = Inscripcion::where('persona_id', $persona->id)
                ->where('user_id', auth()->user()->id)
                ->where('ciclo_id', HelpersUnia::getIdCiclo())
                ->where('activo', 1)
                ->where('borrado', 0)
                ->first();
            if (!$inscripcion) {
                return 'postulante.matricula';
            }
            return 'postulante.home';
        }else {
            return 'perfil';
        }
    }

    public static function getRouteInscripciones() {
        $rol = HelpersUnia::getRol();
        if (!$rol) {
            return 'login';
        }
        if ($rol->id == 1) {
            return 'administrador.inscripciones';
        } elseif ($rol->id == 2) {
            return 'trabajador.inscripciones';
        } else {
            return 'perfil';
        }
    }

    public static function getRouteIngresantes() {
        $rol = HelpersUnia::getRol();
        if (!$rol) {
            return 'login';
        }
        if ($rol->id == 1) {
            return 'administrador.ingresantes';
        } elseif ($rol->id == 2) {
            return 'trabajador.ingresantes';
        } else {
            return 'perfil';
        }
    }

    public static function getRoutePostulantes() {
        $rol = HelpersUnia::getRol();
        if (!$rol) {
            return 'login';
        }
        if ($rol->id == 1) {
            return 'administrador.buscar-postulantes';
        } elseif ($rol->id == 2) {
            return 'trabajador.buscar-postulantes';
        } else {
            return 'perfil';
        }
    }

    public static function subirArchivo($file, $carpeta, $tipo, $ciclo_id, $persona_id) {
        $dimension = 1024;
        if ($tipo == 1) {
            $nombre = 'foto';
            $dimension = 400;
        } elseif ($tipo == 2) {
            $nombre = 'dni';
        } elseif ($tipo == 3) {
            $nombre = 'pago';
        } elseif ($tipo == 4) {
            $nombre = 'certificado';
        } elseif ($tipo == 5) {
            $nombre = 'patida';
        } elseif ($tipo == 6) {
            $nombre = 'constancia';
        }

        $dni = Persona::find($persona_id)->dni;
        $archivo = Archivo::where('tipo', $tipo)
            ->where('ciclo_id', $ciclo_id)
            ->where('persona_id', $persona_id)
            ->where('activo', 1)
            ->where('borrado', 0)
            ->first();

        if ($file) {
            $tamanio = $file->getSize();
            $ImageUpload = Image::make($file);
            $path = 'uploads/' . $carpeta . '/' . HelpersUnia::getNombreCiclo() . '/';
            $filename = time() . $dni . HelpersUnia::getNombreCiclo() . uniqid() . '.' . $file->getClientOriginalExtension();
            $ImageUpload->resize($dimension, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $filename);

            if (!$archivo) {
                $archivo = new Archivo();
            } else {
                File::delete($archivo->ruta);
            }
            $archivo->nombre = $dni . '-' . $nombre;
            $archivo->ruta = $path . $filename;
            $archivo->tipo = $tipo;
            $archivo->estado = 1;
            $archivo->size = $tamanio;
            $archivo->ciclo_id = $ciclo_id;
            $archivo->persona_id = $persona_id;
            $archivo->save();
        }
    }
}
