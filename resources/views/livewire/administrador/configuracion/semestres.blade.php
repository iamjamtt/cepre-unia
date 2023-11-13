<div>
    <!-- Page header -->
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title text-uppercase">
                        Ciclos
                    </h2>
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route(HelperUnia::getRouteHome()) }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Ciclos</a></li>
                        </ol>
                    </div>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button type="button" class="btn btn-teal d-none d-sm-inline-block" data-bs-toggle="modal"
                            wire:click="create" data-bs-target="#modal-ciclo">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Crear nuevo ciclo
                        </button>
                        <button type="button" class="btn btn-teal d-sm-none btn-icon" data-bs-toggle="modal"
                            wire:click="create" data-bs-target="#modal-ciclo" aria-label="Crear nuevo ciclo">
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
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="alert alert-info m-0 mb-3 fw-bold animate__animated animate__fadeIn animate__faster">
                A continuación se muestra el panel de control del administrador, el cual le permitirá gestionar, ver y crear nuevos
                ciclos.
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <div class="card animate__animated animate__fadeIn animate__faster">
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select form-select-sm">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="ms-auto text-secondary">
                                    Buscar:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model.live.debounce.500ms="search" aria-label="Search invoice">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped  datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Ciclo</th>
                                        <th>Descripción</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ciclos as $item)
                                    <tr>
                                        <td>
                                            <span class="text-secondary">{{ $item->id }}</span>
                                        </td>
                                        <td class="fw-bold">
                                            Ciclo {{ $item->nombre }}
                                        </td>
                                        <td class="text-secondary">
                                            {{ $item->descripcion ?? 'Sin descripción' }}
                                        </td>
                                        <td>
                                            {{ HelperUnia::convertirFecha($item->fechaInicio) }}
                                        </td>
                                        <td>
                                            {{ HelperUnia::convertirFecha($item->fechaFin) }}
                                        </td>
                                        <td>
                                            @if ($item->estado == 1)
                                                <span
                                                    class="status status-teal px-2 py-1"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    title="Recuerda! Solo puede haber un ciclo activo"
                                                    >
                                                    <span class="status-dot status-dot-animated"></span>
                                                    Activo
                                                </span>
                                            @else
                                                <span
                                                    class="status status-red px-2 py-1"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="left"
                                                    title="Recuerda! Solo puede haber un ciclo activo"
                                                    >
                                                    <span class="status-dot status-dot-animated"></span>
                                                    Inactivo
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                <button type="button" class="btn btn-sm btn-outline"
                                                    data-bs-toggle="modal" data-bs-target="#modal-ciclo-ver"
                                                    wire:click="show({{ $item->id }})">
                                                    Ver
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-azure"
                                                    data-bs-toggle="modal" data-bs-target="#modal-ciclo"
                                                    wire:click="edit_ciclo({{ $item->id }})">
                                                    Editar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    @if ($ciclos->count() == 0 && $search != '')
                                    <tr>
                                        <td colspan="7">
                                            <div class="text-center" style="padding-bottom: 5rem; padding-top: 5rem;">
                                                <span class="text-secondary">
                                                    No se encontraron resultados para "<strong>{{ $search }}</strong>"
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="7">
                                            <div class="text-center" style="padding-bottom: 5rem; padding-top: 5rem;">
                                                <span class="text-secondary">
                                                    No hay ciclos registrados
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer {{ $ciclos->hasPages() ? 'py-0' : '' }}">
                            @if ($ciclos->hasPages())
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $ciclos->firstItem() }} - {{ $ciclos->lastItem() }} de {{
                                    $ciclos->total()}} registros
                                </div>
                                <div class="mt-3">
                                    {{ $ciclos->links() }}
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $ciclos->firstItem() }} - {{ $ciclos->lastItem() }} de {{
                                    $ciclos->total()}} registros
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal ciclo --}}
    <div class="modal" id="modal-ciclo" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $title_modal }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" novalidate wire:submit="guardar_ciclo">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label required">
                                        Nombre del ciclo
                                    </label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                        id="nombre" wire:model.live="nombre" placeholder="Ejemplo: 2023 - I" />
                                    @error('nombre')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">
                                        Descripcion
                                    </label>
                                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror"
                                        id="descripcion" wire:model.live="descripcion" />
                                    @error('descripcion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="fecha_inicio" class="form-label required">
                                        Fecha de inicio
                                    </label>
                                    <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror"
                                        id="fecha_inicio" wire:model.live="fecha_inicio" />
                                    @error('fecha_inicio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="fecha_fin" class="form-label required">
                                        Fecha de fin
                                    </label>
                                    <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror"
                                        id="fecha_fin" wire:model.live="fecha_fin" />
                                    @error('fecha_fin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="resolucion" class="form-label {{ $modo == 'create' ? 'required' : '' }}">
                                        Resolución
                                    </label>
                                    <input type="file" class="form-control @error('resolucion') is-invalid @enderror"
                                        id="resolucion" wire:model.live="resolucion" accept="application/pdf" />
                                    <small class="form-hint">
                                        @if ($modo == 'create')
                                        <span class="text-secondary">
                                            Recuerda que la resolución debe ser en formato PDF
                                        </span>
                                        @else
                                        <span class="text-secondary">
                                            Si no desea cambiar la resolución, deje este campo vacío
                                        </span>
                                        @endif
                                    </small>
                                    @error('resolucion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="">
                                    <div class="form-label">Estado</div>
                                    <label class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model="estado">
                                        <span class="form-check-label">Activo</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <span class="text-secondary fw-bold fs-3">
                                    Fechas de inscripciones
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="fecha_inicio_inscripcion" class="form-label required">
                                        Fecha de inicio de Inscripciones
                                    </label>
                                    <input type="datetime-local" class="form-control @error('fecha_inicio_inscripcion') is-invalid @enderror"
                                        id="fecha_inicio_inscripcion" wire:model.live="fecha_inicio_inscripcion" />
                                    @error('fecha_inicio_inscripcion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="fecha_extemporanea" class="form-label required">
                                        Fecha Extemporanea de Inscripciones
                                    </label>
                                    <input type="date" class="form-control @error('fecha_extemporanea') is-invalid @enderror"
                                        id="fecha_extemporanea" wire:model.live="fecha_extemporanea" />
                                    @error('fecha_extemporanea')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="fecha_fin_inscripcion" class="form-label required">
                                        Fecha de fin de Inscripciones
                                    </label>
                                    <input type="datetime-local" class="form-control @error('fecha_fin_inscripcion') is-invalid @enderror"
                                        id="fecha_fin_inscripcion" wire:model.live="fecha_fin_inscripcion" />
                                    @error('fecha_fin_inscripcion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="fecha_examen" class="form-label">
                                        Fecha de Examen
                                    </label>
                                    <input type="date" class="form-control @error('fecha_examen') is-invalid @enderror"
                                        id="fecha_examen" wire:model.live="fecha_examen" />
                                    @error('fecha_examen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="limpiar_modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-teal ms-auto">
                            {{ $button_modal }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal ver ciclo --}}
    <div class="modal" id="modal-ciclo-ver" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $title_modal }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="limpiar_modal"></button>
                </div>
                <div class="modal-body mb-2">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Ciclo</div>
                            <div class="datagrid-content">
                                Ciclo {{ $nombre }}
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Descripción</div>
                            <div class="datagrid-content">
                                {{ $descripcion ?? 'Sin descripción' }}
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Fecha de Inicio</div>
                            <div class="datagrid-content">
                                {{ HelperUnia::convertirFecha($fecha_inicio) }}
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Fecha de Fin</div>
                            <div class="datagrid-content">
                                {{ HelperUnia::convertirFecha($fecha_fin) }}
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Estado</div>
                            <div class="datagrid-content">
                                @if ($estado)
                                <span class="badge bg-teal-lt px-2 py-1">Activo</span>
                                @else
                                <span class="badge bg-red-lt px-2 py-1">Inactivo</span>
                                @endif
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Resolución</div>
                            <div class="datagrid-content">
                                @if ($resolucion)
                                <a href="{{ asset($resolucion) }}" target="_blank" class="btn btn-sm">
                                    Abrir resolución
                                </a>
                                @else
                                <span class="badge bg-secondary-lt px-2 py-1">
                                    No hay resolución
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mt-4">
                        <div class="text-secondary fw-bold fs-3">
                            Fechas de inscripciones
                        </div>
                    </div>
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Fecha de Inicio de Inscripcion</div>
                            <div class="datagrid-content">
                                {{ HelperUnia::convertirFechaHora($fecha_inicio_inscripcion) }}
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Fecha de Inscripcion Extemporanea</div>
                            <div class="datagrid-content">
                                {{ HelperUnia::convertirFecha($fecha_extemporanea) }}
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Fecha de Fin de Inscripcion</div>
                            <div class="datagrid-content">
                                {{ HelperUnia::convertirFechaHora($fecha_fin_inscripcion) }}
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Fecha de Examen</div>
                            <div class="datagrid-content">
                                {{ HelperUnia::convertirFecha($fecha_examen) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
