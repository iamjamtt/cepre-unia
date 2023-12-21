<div>
    <!-- Page header -->
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title text-uppercase">
                        Vacantes
                    </h2>
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route(HelperUnia::getRouteHome()) }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Vacantes</a></li>
                        </ol>
                    </div>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button type="button" class="btn btn-teal d-none d-sm-inline-block" data-bs-toggle="modal"
                            wire:click="create" data-bs-target="#modal-vacante">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Crear nueva vacante
                        </button>
                        <button type="button" class="btn btn-teal d-sm-none btn-icon" data-bs-toggle="modal"
                            wire:click="create" data-bs-target="#modal-vacante" aria-label="Crear nueva vacante">
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
                A continuación se muestra el panel de control del administrador, el cual le permitirá gestionar, ver y crear nuevas vacantes.
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
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="ciclo_filtro" class="form-select form-select-sm">
                                            @foreach ($ciclos as $item)
                                            <option value="{{ $item->id }}">
                                                CICLO {{ $item->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                        <th>Vacante</th>
                                        <th>Carrera</th>
                                        <th>Ciclo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($vacantes as $item)
                                    <tr>
                                        <td>
                                            <span class="text-secondary">{{ $item->id }}</span>
                                        </td>
                                        <td class="fw-bold">
                                            @if ($item->vacantes == 1)
                                                {{ $item->vacantes }} vacante
                                            @else
                                                {{ $item->vacantes }} vacantes
                                            @endif
                                        </td>
                                        <td class="text-secondary">
                                            {{ $item->carrera->nombre }}
                                        </td>
                                        <td class="text-secondary">
                                            CICLO {{ $item->ciclo->nombre }}
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                <button type="button" class="btn btn-sm btn-outline-azure"
                                                    data-bs-toggle="modal" data-bs-target="#modal-vacante"
                                                    wire:click="edit_vacante({{ $item->id }})">
                                                    Editar
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-red"
                                                    wire:click="delete({{ $item->id }})"
                                                    wire:confirm="¿Está seguro de eliminar la vacante? Esta acción no se puede deshacer."
                                                    >
                                                    Eliminar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        @if ($vacantes->count() == 0 && $search != '')
                                        <tr>
                                            <td colspan="5">
                                                <div class="text-center" style="padding-bottom: 5rem; padding-top: 5rem;">
                                                    <span class="text-secondary">
                                                        No se encontraron resultados para "<strong>{{ $search }}</strong>"
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td colspan="5">
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
                        <div class="card-footer {{ $vacantes->hasPages() ? 'py-0' : '' }}">
                            @if ($vacantes->hasPages())
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $vacantes->firstItem() }} - {{ $vacantes->lastItem() }} de {{
                                    $vacantes->total()}} registros
                                </div>
                                <div class="mt-3">
                                    {{ $vacantes->links() }}
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $vacantes->firstItem() }} - {{ $vacantes->lastItem() }} de {{
                                    $vacantes->total()}} registros
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal vacante --}}
    <div class="modal" id="modal-vacante" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $title_modal }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" novalidate wire:submit="guardar">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="vacante" class="form-label required">
                                        Cantidad de vacantes
                                    </label>
                                    <input type="number" class="form-control @error('vacante') is-invalid @enderror"
                                        id="vacante" wire:model.live="vacante" placeholder="Ejemplo: 10" />
                                    @error('vacante')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="carrera" class="form-label required">
                                        Carrera
                                    </label>
                                    <select wire:model="carrera" class="form-select @error('carrera') is-invalid @enderror">
                                        <option value="">Seleccione una carrera</option>
                                        @foreach ($carreras as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('carrera')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="ciclo" class="form-label required">
                                        Ciclo
                                    </label>
                                    <select wire:model="ciclo" class="form-select @error('ciclo') is-invalid @enderror">
                                        <option value="">Seleccione un ciclo</option>
                                        @foreach ($ciclos as $item)
                                            <option value="{{ $item->id }}">CICLO {{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('ciclo')
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
</div>
