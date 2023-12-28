<div>
    <!-- Page header -->
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title text-uppercase">
                        Perfil
                    </h2>
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route(HelperUnia::getRouteHome()) }}" wire:navigate>Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Perfil</a></li>
                        </ol>
                    </div>
                </div>
                <!-- Page title actions -->
                {{-- <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="#" class="btn">
                                New view
                            </a>
                        </span>
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-report">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new report
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#modal-report" aria-label="Create new report">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-md-6 col-lg-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center my-3 flex-column align-items-center">
                                        @php
                                            $foto = HelperUnia::existeArchivoFoto(HelperUnia::getIdCiclo(), $persona->id);
                                            $existeFoto = $foto['existe'];
                                            if ($foto['existe'] == true) {
                                                // verificamos si existe la foto en la ruta definida
                                                $file = Illuminate\Support\Facades\File::exists($foto['ruta']);
                                                if ($file) {
                                                    $foto = Intervention\Image\Facades\Image::make($foto['ruta']);
                                                    $foto->crop(400, 400);
                                                    $foto = $foto->encode('webp')->encoded;
                                                    $foto = 'data:image/webp;base64,' . base64_encode($foto);
                                                } else {
                                                    $foto = $foto['ruta'];
                                                }
                                            } else {
                                                $foto = $foto['ruta'];
                                            }
                                        @endphp
                                        <img class="avatar avatar-xl"
                                            src="{{ $existeFoto ? $foto : asset($foto) }}"
                                            alt="avatar perfil">
                                        <span class="fw-bold fs-3 mt-3 text-center">
                                            {{ $persona->apePaterno }} {{ $persona->apeMaterno }} {{ $persona->nombres }}
                                        </span>
                                        <span class="fw-medium fs-4 mt-2">
                                            DNI: {{ $persona->dni }}
                                        </span>
                                        <div class="mt-3 px-3">
                                            <span class="badge bg-teal-lt px-5 py-2">
                                                {{ $rol->nombre }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                                <div class="card-header bg-teal-lt">
                                    <h3 class="card-title text-uppercase fw-bold">
                                        Sobre mí
                                    </h3>
                                </div>
                                <div class="card-body mb-1">
                                    <div class="d-flex justify-content-center flex-column">
                                        <div class="d-flex justify-content-center flex-column gap-1 mb-1 border-bottom pb-2">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z"></path>
                                                    <path d="M19 16h-12a2 2 0 0 0 -2 2"></path>
                                                    <path d="M9 8h6"></path>
                                                </svg>
                                                Educación
                                            </span>
                                            <span>
                                                {{ $persona->colegio->nombre }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center flex-column gap-1 mb-1 border-bottom pb-2">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                                    <path
                                                        d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z">
                                                    </path>
                                                </svg>
                                                Ubicación
                                            </span>
                                            <span>
                                                {{ $persona->distrito->nombre }}, {{ $persona->distrito->provincia->nombre }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-center flex-column gap-1">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                    <path
                                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                                    </path>
                                                    <path d="M9 9l1 0"></path>
                                                    <path d="M9 13l6 0"></path>
                                                    <path d="M9 17l6 0"></path>
                                                </svg>
                                                Nota
                                            </span>
                                            <span>
                                                Alumno matriculado al CEPRE UNIA {{ HelperUnia::getNombreCiclo() }}, este ciclo se desarollará por la modalidad
                                                presencial
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-8">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                                <div class="card-header bg-yellow-lt">
                                    <h3 class="card-title text-uppercase fw-bold">
                                        Datos personales
                                    </h3>
                                </div>
                                <div class="card-body mb-1">
                                    <div class="d-flex justify-content-center flex-column">
                                        <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                                DNI:
                                                <span class="fw-normal fs-4">
                                                    {{ $persona->dni }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                                Nombres:
                                                <span class="fw-normal fs-4">
                                                    {{ $persona->apePaterno }} {{ $persona->apeMaterno }} {{ $persona->nombres }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                                Fecha de Nacimiento:
                                                <span class="fw-normal fs-4">
                                                    {{ HelperUnia::convertirFecha($persona->fechaNac) }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                                Sexo:
                                                <span class="fw-normal fs-4">
                                                    {{ HelperUnia::getSexo($persona->sexo) }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                                Grupo Étnico:
                                                <span class="fw-normal fs-4">
                                                    {{ $persona->grupo->nombre }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                                Lengua Materna:
                                                <span class="fw-normal fs-4">
                                                    {{ $persona->language->nombre }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                                Celular:
                                                <span class="fw-normal fs-4">
                                                    {{ $persona->celular }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                                Celular del Apoderado:
                                                <span class="fw-normal fs-4">
                                                    {{ $persona->celularApoderado ?? '-' }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-star gap-1 mb-2">
                                            <span class="fw-bold fs-4 mt-2 d-flex align-items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                                Correo Electrónico:
                                                <span class="fw-normal fs-4">
                                                    {{ $user->email ?? '-' }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
