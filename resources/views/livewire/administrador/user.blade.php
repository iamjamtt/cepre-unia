<div>
    <!-- Page header -->
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title text-uppercase">
                        Usuarios
                    </h2>
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route(HelperUnia::getRouteHome()) }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Usuarios</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="alert alert-info m-0 mb-3 fw-bold animate__animated animate__fadeIn animate__faster">
                A continuación se muestra el panel de control del administrador, el cual le permitirá gestionar, ver y
                crear nuevos
                usuarios.
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
                                        <th>Persona</th>
                                        <th>Dni</th>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Sexo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $item)
                                    <tr>
                                        <td>
                                            <span class="text-secondary">{{ $item->id }}</span>
                                        </td>
                                        <td class="fw-bold">
                                            {{ HelperUnia::getNombreCompleto($item->persona_id) }}
                                        </td>
                                        <td class="text-secondary">
                                            {{ $item->dni }}
                                        </td>
                                        <td class="text-secondary">
                                            {{ $item->name }}
                                        </td>
                                        <td class="text-secondary">
                                            {{ $item->email ?? '-' }}
                                        </td>
                                        <td class="text-secondary text-uppercase">
                                            @if (HelperUnia::getRolByUser($item->id)->id == 1)
                                            <span class="badge bg-teal-lt me-1">
                                                {{ HelperUnia::getRolByUser($item->id)->nombre }}
                                            </span>
                                            @elseif (HelperUnia::getRolByUser($item->id)->id == 2)
                                            <span class="badge bg-orange-lt me-1">
                                                {{ HelperUnia::getRolByUser($item->id)->nombre }}
                                            </span>
                                            @elseif (HelperUnia::getRolByUser($item->id)->id == 3)
                                            <span class="badge bg-purple-lt me-1">
                                                {{ HelperUnia::getRolByUser($item->id)->nombre }}
                                            </span>
                                            @elseif (HelperUnia::getRolByUser($item->id)->id == 4)
                                            <span class="badge bg-indigo-lt me-1">
                                                {{ HelperUnia::getRolByUser($item->id)->nombre }}
                                            </span>
                                            @else
                                            <span class="badge bg-red-lt me-1">
                                                {{ HelperUnia::getRolByUser($item->id)->nombre }}
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->sexo == 'M')
                                            <span class="badge bg-cyan-lt">
                                                {{ HelperUnia::getSexo($item->sexo) }}
                                            </span>
                                            @else
                                            <span class="badge bg-pink-lt">
                                                {{ HelperUnia::getSexo($item->sexo) }}
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                <button type="button" class="btn btn-sm btn-outline-orange"
                                                    wire:click="edit_contraseña({{ $item->id }})" data-bs-toggle="modal"
                                                    data-bs-target="#modal-edit-contraseña">
                                                    Modificar Contraseña
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-azure"
                                                    data-bs-toggle="modal" data-bs-target="#modal-user"
                                                    wire:click="edit_user({{ $item->id }})">
                                                    Editar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    @if ($users->count() == 0 && $search != '')
                                    <tr>
                                        <td colspan="8">
                                            <div class="text-center" style="padding-bottom: 5rem; padding-top: 5rem;">
                                                <span class="text-secondary">
                                                    No se encontraron resultados para "<strong>{{ $search }}</strong>"
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="8">
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
                        <div class="card-footer {{ $users->hasPages() ? 'py-0' : '' }}">
                            @if ($users->hasPages())
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $users->firstItem() }} - {{ $users->lastItem() }} de {{
                                    $users->total()}} registros
                                </div>
                                <div class="mt-3">
                                    {{ $users->links() }}
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $users->firstItem() }} - {{ $users->lastItem() }} de {{
                                    $users->total()}} registros
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal usuario --}}
    <div class="modal" id="modal-user" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
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
                                    <span class="fw-bold fs-3 text-secondary">
                                        Datos personales
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="alert alert-info m-0">
                                    <span>
                                        Próximamente se podrá editar los datos personales del usuario.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <span class="fw-bold fs-3 text-secondary">
                                        Datos de usuario
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label required">
                                        Nombre de usuario
                                    </label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                        id="nombre" wire:model.live="nombre" placeholder="Ingrese su nombre usuario" />
                                    @error('nombre')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="rol" class="form-label required">
                                        Rol
                                    </label>
                                    <select class="form-select @error('rol') is-invalid @enderror"
                                        id="rol" wire:model.live="rol">
                                        <option value="">Seleccione un rol</option>
                                        @foreach ($roles as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('rol')
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
    {{-- modal cambiar contraseña --}}
    <div class="modal" id="modal-edit-contraseña" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Modificar contraseña
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" novalidate wire:submit="update_contraseña">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="contraseña" class="form-label required">
                                        Contraseña
                                    </label>
                                    <input type="password"
                                        class="form-control @error('contraseña') is-invalid @enderror" id="contraseña"
                                        wire:model.live="contraseña" placeholder="Ingrese la contraseña..." />
                                    @error('contraseña')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="contraseña_confirmation" class="form-label required">
                                        Confirmar Contraseña
                                    </label>
                                    <input type="password"
                                        class="form-control @error('contraseña_confirmation') is-invalid @enderror"
                                        id="contraseña_confirmation" wire:model.live="contraseña_confirmation"
                                        placeholder="Confirme la contraseña..." />
                                    @error('contraseña_confirmation')
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
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
