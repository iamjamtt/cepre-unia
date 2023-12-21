<div>
    <!-- Page header -->
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title text-uppercase">
                        Home
                    </h2>
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Home</a></li>
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
            <div class="alert alert-info m-0 mb-3 animate__animated animate__fadeIn animate__faster">
                <span class="fw-bold">
                    A continuación se muestra el panel Home o Inicio, el cual le permitirá ver direferentes tarjetas
                    informativas, las cuales le permitirán ver las
                    inscripciones y generar reportes.
                </span>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">
                            <div class="d-flex flex-column justify-content-center align-items-center my-2">
                                <div class="mb-3">
                                    <span class="bg-primary text-white avatar avatar-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M3 19l18 0"></path>
                                            <path
                                                d="M5 6m0 1a1 1 0 0 1 1 -1h12a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-12a1 1 0 0 1 -1 -1z">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mb-3 text-center">
                                    <div class="fw-bold fs-2">
                                        Inscripciones
                                    </div>
                                    <div class="text-secondary mt-2">
                                        {{ $inscripciones->count() }} inscripciones en el Ciclo {{
                                        HelperUnia::getNombreCiclo() }}
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route(HelperUnia::getRouteInscripciones()) }}"
                                        class="btn btn-outline-primary px-4">
                                        Ver inscripciones
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">
                            <div class="d-flex flex-column justify-content-center align-items-center my-2">
                                <div class="mb-3">
                                    <span class="bg-cyan-lt text-white avatar avatar-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                            <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                            <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="text-center">
                                    <div class="fw-bold fs-2">
                                        Mestizos
                                    </div>
                                    <div class="text-secondary mt-1">
                                        en el Ciclo {{ HelperUnia::getNombreCiclo() }}
                                    </div>
                                    <div class="text-secondary mt-2" style="font-size: 2.1rem; font-weight: 700;">
                                        {{ $mestizos->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body position-relative">
                            <div class="d-flex flex-column justify-content-center align-items-center my-2">
                                <div class="mb-3">
                                    <span class="bg-cyan-lt text-white avatar avatar-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                            <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                            <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                        </svg>
                                    </span>
                                    <div class="position-absolute top-0 end-0 mt-3 me-4">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                {{ $nombre_pueblos_originarios }}
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end card-body-scrollable card-body-scrollable-shadow"
                                                style="height: 18rem;">
                                                <a class="dropdown-item {{ $grupo_id == null ? 'active' : '' }}"
                                                    style="cursor: pointer"
                                                    wire:click="seleccionar_pueblo_originario('')">
                                                    TODOS LOS PUEBLOS ORIGINARIOS
                                                </a>
                                                @foreach ($grupos_pueblos_originarios as $item)
                                                <a class="dropdown-item {{ $item->id == $grupo_id ? 'active' : '' }}"
                                                    style="cursor: pointer"
                                                    wire:click="seleccionar_pueblo_originario({{ $item->id }})">
                                                    {{ $item->nombre }}
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="fw-bold fs-2">
                                        {{ $nombre_pueblos_originarios }}
                                    </div>
                                    <div class="text-secondary mt-1">
                                        en el Ciclo {{ HelperUnia::getNombreCiclo() }}
                                    </div>
                                    <div class="text-secondary mt-2" style="font-size: 2.1rem; font-weight: 700;">
                                        {{ $pueblos_originarios->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">
                            <div class="d-flex flex-column justify-content-center align-items-center my-2">
                                <div class="mb-3">
                                    <span class="bg-teal-lt text-white avatar avatar-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M3 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z">
                                            </path>
                                            <path
                                                d="M9 8m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z">
                                            </path>
                                            <path
                                                d="M15 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z">
                                            </path>
                                            <path d="M4 20l14 0"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mb-3 text-center">
                                    <div class="fw-bold fs-2">
                                        Reporte
                                    </div>
                                    <div class="text-secondary mt-2">
                                        de inscritos en el Ciclo {{ HelperUnia::getNombreCiclo() }}
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-teal px-4"
                                        wire:click="reporte_inscritos">
                                        Descargar reporte
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">
                            <div class="d-flex flex-column justify-content-center align-items-center my-2">
                                <div class="mb-3">
                                    <span class="bg-yellow-lt text-white avatar avatar-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 9m-6 0a6 6 0 1 0 12 0a6 6 0 1 0 -12 0"></path>
                                            <path d="M12 15l3.4 5.89l1.598 -3.233l3.598 .232l-3.4 -5.889"></path>
                                            <path d="M6.802 12l-3.4 5.89l3.598 -.233l1.598 3.232l3.4 -5.889"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mb-3 text-center">
                                    <div class="fw-bold fs-2">
                                        Reporte
                                    </div>
                                    <div class="text-secondary mt-2">
                                        de ingresantes en el Ciclo {{ HelperUnia::getNombreCiclo() }}
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-yellow px-4"
                                        wire:click="reporte_ingresantes" @if($ingresantes_count == 0) disabled @endif>
                                        Descargar reporte
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">
                            <div class="d-flex flex-column justify-content-center align-items-center my-2">
                                <div class="mb-3">
                                    <span class="bg-pink-lt text-white avatar avatar-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 9m-6 0a6 6 0 1 0 12 0a6 6 0 1 0 -12 0"></path>
                                            <path d="M12 15l3.4 5.89l1.598 -3.233l3.598 .232l-3.4 -5.889"></path>
                                            <path d="M6.802 12l-3.4 5.89l3.598 -.233l1.598 3.232l3.4 -5.889"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mb-3 text-center">
                                    <div class="fw-bold fs-2">
                                        Reporte por Grupo Étnico y Carreras
                                    </div>
                                    <div class="text-secondary mt-2">
                                        de postulantes e ingresantes en el Ciclo {{ HelperUnia::getNombreCiclo() }}
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-pink px-4"
                                        wire:click="reporte_by_grupo_etnico_and_carreras">
                                        Descargar reporte
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
