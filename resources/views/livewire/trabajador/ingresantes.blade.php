<div>
    <!-- Page header -->
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title text-uppercase">
                        Ingresantes del Ciclo {{ HelperUnia::getNombreCiclo() }}
                    </h2>
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route(HelperUnia::getRouteHome()) }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Ingresantes</a></li>
                        </ol>
                    </div>
                </div>
                <!-- Page title actions -->
                {{-- <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button type="button" class="btn btn-teal d-none d-sm-inline-block" data-bs-toggle="modal"
                            wire:click="create" data-bs-target="#modal-rol">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Crear nuevo rol
                        </button>
                        <button type="button" class="btn btn-teal d-sm-none btn-icon" data-bs-toggle="modal"
                            wire:click="create" data-bs-target="#modal-rol" aria-label="Crear nuevo rol">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </button>
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
                    A continuación se muestra el panel de control, el cual le permitirá gestionar, subir y ver la
                    información de los ingresantes en el presente ciclo académico activo.
                </span>
            </div>
            @if($fecha_examen && $fecha_examen > now())
            <div class="alert alert-red m-0 mb-3 animate__animated animate__fadeIn animate__faster">
                <span class="fw-bold">
                    Recuerde que solo se pográ registrar a los ingresantes el mismo día del examen de cepre o posterior a este.
                </span>
            </div>
            @endif
            <div class="row g-3">
                @if ($ingresantes_count == 0)
                    <div class="col-12">
                        <div class="card animate__animated animate__fadeIn animate__faster">
                            <div class="card-body" style="padding-top: 5rem; padding-bottom: 5rem;">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <span class="rounded-pill border border-4 border-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="60"
                                            height="60" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M18 6l-12 12"></path>
                                            <path d="M6 6l12 12"></path>
                                        </svg>
                                    </span>
                                    <div class="mt-3">
                                        <span class="fs-3 text-secondary fw-semibold">
                                            No hay ingresantes registrados
                                        </span>
                                    </div>
                                    <div class="mt-4">
                                        <button
                                            type="button" class="btn btn-cyan px-4" data-bs-toggle="modal" data-bs-target="#modal-ingresantes"
                                            wire:click="abrir_modal"
                                            @if($fecha_examen == null)
                                                disabled
                                            @else
                                                {{ $fecha_examen > now() ? 'disabled' : '' }}
                                            @endif
                                            >
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-users-plus" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4c.96 0 1.84 .338 2.53 .901"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                <path d="M16 19h6"></path>
                                                <path d="M19 16v6"></path>
                                            </svg>
                                            Registrar Ingresantes del Ciclo {{ HelperUnia::getNombreCiclo() }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($resultados as $item)
                    <div class="col-lg-6">
                        <div class="card animate__animated animate__fadeIn animate__faster card-body-scrollable card-body-scrollable-shado"
                            style="height: 20rem;">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">
                                    {{ $item['carrera'] }}
                                </h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap table-striped  datatable">
                                    <thead>
                                        <tr>
                                            <th class="w-1">No.</th>
                                            <th class="col-1">Dni</th>
                                            <th class="col-4">Postulante</th>
                                            <th>Grupo Étnico</th>
                                            <th>Puntaje</th>
                                            <th class="col-2">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($item['inscripciones'] as $item2)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $item2->persona->dni }}
                                            </td>
                                            <td>
                                                {{ HelperUnia::getNombreCompleto($item2->persona_id) }}
                                            </td>
                                            <td class="text-secondary">
                                                {{ $item2->persona->grupo->nombre }}
                                            </td>
                                            <td>
                                                {{ $item2->puntaje }}
                                            </td>
                                            <td>
                                                @if ($item2->ingreso == 1)
                                                    <span class="badge bg-blue-lt py-1 px-2">Ingreso</span>
                                                @else
                                                    <span class="badge bg-red-lt py-1 px-2">No ingreso</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr style="height: 14.25rem;">
                                            <td colspan="6">
                                                <div class="d-flex justify-content-center align-item-center"">
                                                    <span class="text-secondary">
                                                        No hay resultados para mostrar
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    {{-- modal ingresantes --}}
    <div class="modal" id="modal-ingresantes" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Subir Documento de Resultados del Examén (<strong>Excel</strong>)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="cancelar_modal"></button>
                </div>
                <form autocomplete="off" novalidate wire:submit="subir_documento">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="text-dark mb-2">
                                <label for="documento" class="form-label required">
                                    Subir documento Excel
                                </label>
                                <input type="file" class="form-control @error('documento') is-invalid @enderror"
                                    id="documento" wire:model.live="documento" accept=".xlsx, .xls">
                                @error('documento')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close" wire:click="cancelar_modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-teal ms-auto" @if ($documento==null)
                            wire:target="documento" @endif wire:loading.attr="disabled" wire:target="subir_documento">
                            <div wire:loading.remove wire:target="subir_documento">
                                Subir Documento
                            </div>
                            <div wire:loading wire:target="subir_documento">
                                Procesando <span class="spinner-border spinner-border-sm align-middle"></span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
