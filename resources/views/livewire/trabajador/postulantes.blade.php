<div>
    <!-- Page header -->
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title text-uppercase">
                        Postulantes
                    </h2>
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route(HelperUnia::getRouteHome()) }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Postulantes</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="alert alert-info m-0 mb-3 animate__animated animate__fadeIn animate__faster">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 9h.01"></path>
                    <path d="M11 12h1v4h1"></path>
                    <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                </svg>
                <span class="fw-bold">
                    A continuación podrá buscar a los postulantes por su DNI para ver los datos
                    y así validar al postulante.
                </span>
            </div>
            <div class="row g-3">
                <div class="col-lg-3">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">
                            <form wire:submit="buscar_postulante" class="d-flex flex-column gap-2">
                                <span class="fw-bold fs-3 text-gray-600">
                                    Buscar Postulante:
                                </span>
                                <input type="text" wire:model.live="buscar" class="form-control mb-2"
                                    placeholder="Ingrese el DNI del postulante">
                                @error('buscar')
                                <span class="text-danger mb-2">
                                    {{ $message }}
                                </span>
                                @enderror
                                <button type="submit" class="btn mb-1">
                                    Buscar
                                </button>
                                <button type="button" wire:click="limpiar" class="btn btn-outline-red">
                                    Limpiar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    @if ($persona)
                    <div class="card card-stacked mb-3 animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-4 d-flex align-items-center">
                                    @php
                                    // verificar si existe en los archivos
                                    $existe = $fotografia ? HelperUnia::existeArchivoEnProyecto($fotografia) : false;
                                    @endphp
                                    @if ($existe)
                                    <img src="{{ asset($fotografia ?? 'static/avatar-none.webp') }}" width="100%"
                                        alt="Fotografía">
                                    @else
                                    <img src="{{ asset('static/avatar-none.webp') }}" width="100%" alt="Fotografía">
                                    @endif
                                </div>
                                <div class="col-lg-8">
                                    <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                        <span class="fw-bold fs-3 mt-2 d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                            DNI:
                                            <span class="fw-normal">
                                                {{ $persona->dni }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                        <span class="fw-bold fs-3 mt-2 d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                            Nombres:
                                            <span class="fw-normal">
                                                {{ $persona->apePaterno }} {{ $persona->apeMaterno }} {{
                                                $persona->nombres }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                        <span class="fw-bold fs-3 mt-2 d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                            Fecha de Nacimiento:
                                            <span class="fw-normal">
                                                {{ HelperUnia::convertirFecha($persona->fechaNac) }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                        <span class="fw-bold fs-3 mt-2 d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                            Sexo:
                                            <span class="fw-normal">
                                                {{ HelperUnia::getSexo($persona->sexo) }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                        <span class="fw-bold fs-3 mt-2 d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                            Grupo Étnico:
                                            <span class="fw-normal">
                                                {{ $persona->grupo->nombre }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-star gap-1 mb-2 border-bottom pb-3">
                                        <span class="fw-bold fs-3 mt-2 d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                            Lengua Materna:
                                            <span class="fw-normal">
                                                {{ $persona->language->nombre }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-star gap-1 mb-2">
                                        <span class="fw-bold fs-3 mt-2 d-flex align-items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                            Correo Electrónico:
                                            <span class="fw-normal">
                                                {{ $user->email ?? '-' }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-stacked mb-3 animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="text-azure" width="32" height="32"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z"></path>
                                                <path d="M19 16h-12a2 2 0 0 0 -2 2"></path>
                                                <path d="M9 8h6"></path>
                                            </svg>
                                        </div>
                                        <div class="col text-truncate d-flex justify-content-start align-items-center">
                                            <div class="fw-bold fs-3">
                                                Carrera:
                                            </div>
                                            <div class="fw-normal fs-3 ms-3">
                                                {{ $carrera }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-stacked mb-3 animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">
                            <div class="row g-4">
                                @foreach ($documentos as $item)
                                <div class="col-6">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            @if ($item['archivo'])
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-teal" width="30"
                                                height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M9 11l3 3l8 -8"></path>
                                                <path
                                                    d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9">
                                                </path>
                                            </svg>
                                            @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-red" width="28"
                                                height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z">
                                                </path>
                                                <path d="M9 9l6 6m0 -6l-6 6"></path>
                                            </svg>
                                            @endif
                                        </div>
                                        <div class="col text-truncate">
                                            <span class="fw-bold fs-3">
                                                {{ $item['nombre'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="alert alert-secondary m-0 d-flex flex-column align-items-center py-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="" width="90" height="90"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="12" cy="12" r="9"></circle>
                                            <line x1="9" y1="10" x2="9.01" y2="10"></line>
                                            <line x1="15" y1="10" x2="15.01" y2="10"></line>
                                            <path d="M9.5 16a10 10 0 0 1 6 -1.5"></path>
                                        </svg>
                                        <span class="fw-bold fs-2 mt-3">
                                            Para buscar un postulante ingrese su DNI
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
