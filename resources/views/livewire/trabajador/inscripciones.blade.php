<div>
    <!-- Page header -->
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title text-uppercase">
                        Inscripciones
                    </h2>
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route(HelperUnia::getRouteHome()) }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Inscripciones</a></li>
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
                <span class="fw-bold">
                    A continuación se muestra el panel de control, el cual le permitirá gestionar, ver y
                    crear nuevos
                    ciclos.
                </span>
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <div class="card animate__animated animate__fadeIn animate__faster">
                        <div class="card-body py-3">
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select form-select-sm">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="ms-auto text-secondary">
                                    <div class="d-inline-block">
                                        <select wire:model.live="grupo_filtro" class="form-select form-select-sm">
                                            <option value="all">
                                                Todos los grupos
                                            </option>
                                            @foreach ($grupos as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="ciclo_filtro" class="form-select form-select-sm">
                                            @foreach ($ciclos as $item)
                                            <option value="{{ $item->id }}">
                                                Centro Preuniversitario UNIA - Ciclo {{ $item->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    Buscar estudiante:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model.live.debounce.500ms="search" aria-label="Search invoice">
                                    </div>
                                    <div class="ms-2 d-inline-block">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm {{ $color_filtro }} dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                                {{ $nombre_filtro }}
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item"
                                                    wire:click="filtro_inscripcion(0)">
                                                    Todas las inscripciones
                                                </button>
                                                <button type="button" class="dropdown-item"
                                                    wire:click="filtro_inscripcion(1)">
                                                    Inscripciones completadas
                                                </button>
                                                <button type="button" class="dropdown-item"
                                                    wire:click="filtro_inscripcion(9)">
                                                    Inscripciones no finalizadas
                                                </button>
                                                <div class="dropdown-divider"></div>
                                                <button type="button" class="dropdown-item"
                                                    wire:click="filtro_inscripcion(2)">
                                                    Fotografías aprobadas
                                                </button>
                                                <button type="button" class="dropdown-item"
                                                    wire:click="filtro_inscripcion(3)">
                                                    Fotografías desaprobadas
                                                </button>
                                                <div class="dropdown-divider"></div>
                                                <button type="button" class="dropdown-item"
                                                    wire:click="filtro_inscripcion(5)">
                                                    Pagos verificados
                                                </button>
                                                <button type="button" class="dropdown-item"
                                                    wire:click="filtro_inscripcion(6)">
                                                    Pagos no verificados
                                                </button>
                                                <div class="dropdown-divider"></div>
                                                <button type="button" class="dropdown-item"
                                                    wire:click="filtro_inscripcion(7)">
                                                    Documentos completados
                                                </button>
                                                <button type="button" class="dropdown-item"
                                                    wire:click="filtro_inscripcion(8)">
                                                    Sin documentos
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-bottom {{ $inscripciones->hasPages() ? 'py-0' : '' }}">
                            @if ($inscripciones->hasPages())
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $inscripciones->firstItem() }} - {{ $inscripciones->lastItem() }} de {{
                                    $inscripciones->total()}} registros
                                </div>
                                <div class="mt-3">
                                    {{ $inscripciones->links() }}
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $inscripciones->firstItem() }} - {{ $inscripciones->lastItem() }} de {{
                                    $inscripciones->total()}} registros
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th class="col-6">Postulante</th>
                                        <th class="col-3 col-xl-2">Estado de Matrícula</th>
                                        <th class="col-2 col-xl-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{--
                                    <livewire:components.inscripciones.list-inscripcion
                                        :inscripciones="$inscripciones" /> --}}
                                    @forelse ($inscripciones as $item)
                                    <tr>
                                        <td>
                                            <span class="text-secondary">{{ $item->id }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-3 align-items-center justify-content-start">
                                                <div>
                                                    @php
                                                    $foto =
                                                    HelperUnia::existeArchivo($item->ciclo_id,$item->persona_id,1);
                                                    // verificar si existe en los archivos
                                                    $existe = $foto ? HelperUnia::existeArchivoEnProyecto($foto->ruta) :
                                                    false;
                                                    @endphp
                                                    @if ($existe)
                                                    <img src="{{ asset($foto->ruta ?? 'static/avatar-none.webp') }}"
                                                        width="110px" alt="Fotografía">
                                                    @else
                                                    <img src="{{ asset('static/avatar-none.webp') }}" width="110px"
                                                        alt="Fotografía">
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-column gap-2">
                                                    <span>
                                                        <strong class="text-blue">Nombre:</strong> {{
                                                        HelperUnia::getNombreCompleto($item->persona_id) }}
                                                    </span>
                                                    <span>
                                                        <strong class="text-blue">DNI:</strong> {{ $item->dni }}
                                                    </span>
                                                    <span>
                                                        <strong class="text-blue">Celular:</strong> {{ $item->celular }}
                                                        {{ $item->celularApoderado ? '- ' . $item->celularApoderado : ''
                                                        }}
                                                    </span>
                                                    <span>
                                                        <strong class="text-blue">Carrera:</strong> {{
                                                        $item->carrera->nombre }}
                                                    </span>
                                                    <span>
                                                        <strong class="text-blue">Grupo Étnico:</strong> {{
                                                        $item->nombre_grupo }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-secondary">
                                            <div class="d-flex flex-column gap-2">
                                                @if ($item->pago->verificacion == 1)
                                                <span class="badge bg-teal-lt py-2 px-3">Pago Verificado</span>
                                                @else
                                                <span class="badge bg-red-lt py-2 px-3">Pago No Verificado</span>
                                                @endif
                                                @if ($item->foto == 1)
                                                <span class="badge bg-teal-lt py-2 px-3">Foto Aprobado</span>
                                                @else
                                                <span class="badge bg-red-lt py-2 px-3">Foto No Aprobado</span>
                                                @endif
                                                @if ($item->documento == 1)
                                                <span class="badge bg-teal-lt py-2 px-3">Documentos Entregados</span>
                                                @else
                                                <span class="badge bg-red-lt py-2 px-3">Sin Documentos</span>
                                                @endif
                                                @if ($item->estado == 2)
                                                <span class="badge bg-azure-lt py-2 px-3">Matrícula Finalizada</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row g-2">
                                                <div class="col-xxl-6">
                                                    <button type="button" class="btn btn-sm btn-outline-azure w-full"
                                                        data-bs-toggle="modal" data-bs-target="#modal-pago"
                                                        wire:click="cargar_pago({{ $item->id }})">
                                                        Ver Pago
                                                    </button>
                                                </div>
                                                <div class="col-xxl-6">
                                                    <button type="button" class="btn btn-sm btn-outline-azure w-full"
                                                        data-bs-toggle="modal" data-bs-target="#modal-postulante"
                                                        wire:click="cargar_postulante({{ $item->id }})">
                                                        Editar Datos
                                                    </button>
                                                </div>
                                                <div class="col-xxl-6">
                                                    @if ($item->foto == 0)
                                                    <button type="button" class="btn btn-sm btn-outline-teal w-full"
                                                        wire:click="aprobar_foto({{ $item->id }}, true)">
                                                        Aprobar Foto
                                                    </button>
                                                    @else
                                                    <button type="button" class="btn btn-sm btn-outline-red w-full"
                                                        wire:click="aprobar_foto({{ $item->id }}, false)">
                                                        Desaprobar Foto
                                                    </button>
                                                    @endif
                                                </div>
                                                <div class="col-xxl-6">
                                                    <button type="button" class="btn btn-sm btn-outline-indigo w-full"
                                                        data-bs-toggle="modal" data-bs-target="#modal-documentos"
                                                        wire:click="cargar_documentos({{ $item->id }})">
                                                        Ver Documentos
                                                    </button>
                                                </div>
                                                <div class="col-xxl-6">
                                                    @if ($item->documento == 0)
                                                    <button type="button" class="btn btn-sm btn-outline-teal w-full"
                                                        wire:click="aprobar_documentos({{ $item->id }}, true)">
                                                        Aprobar Documentos
                                                    </button>
                                                    @else
                                                    <button type="button" class="btn btn-sm btn-outline-red w-full"
                                                        wire:click="aprobar_documentos({{ $item->id }}, false)">
                                                        Desaprobar Documentos
                                                    </button>
                                                    @endif
                                                </div>
                                                <div class="col-xxl-6">
                                                    <button type="button" class="btn btn-sm btn-outline-indigo w-full"
                                                        wire:confirm="¿Esta seguro de resetear la contraseña?"
                                                        wire:click="resetear_password({{ $item->id }})">
                                                        Resetear Contraseña
                                                    </button>
                                                </div>
                                                <div class="col-xxl-6">
                                                    @if ($item->estado == 1)
                                                    <button type="button" class="btn btn-sm btn-outline-blue w-full"
                                                        wire:confirm="¿Esta seguro de finalizar la matrícula con id {{ $item->id }}?"
                                                        wire:click="finalizar_matricula({{ $item->id }}, true)">
                                                        Finalizar Matrícula
                                                    </button>
                                                    @else
                                                    <button type="button" class="btn btn-sm btn-outline-red w-full"
                                                        wire:confirm="¿Esta seguro de cancelar la matrícula con id {{ $item->id }}?"
                                                        wire:click="finalizar_matricula({{ $item->id }}, false)">
                                                        Cancelar Matrícula
                                                    </button>
                                                    @endif
                                                </div>
                                                <div class="col-xxl-6">
                                                    <button type="button" class="btn btn-sm btn-outline-red w-full"
                                                        wire:confirm="¿Esta seguro de eliminar la inscripción con id {{ $item->id }}?"
                                                        wire:click="eliminar({{ $item->id }})">
                                                        Eliminar
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    @if ($inscripciones->count() == 0 && $search != '')
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center" style="padding-bottom: 5rem; padding-top: 5rem;">
                                                <span class="text-secondary">
                                                    No se encontraron resultados para "<strong>{{ $search }}</strong>"
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center" style="padding-bottom: 5rem; padding-top: 5rem;">
                                                <span class="text-secondary">
                                                    No hay inscripciones registrados
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer {{ $inscripciones->hasPages() ? 'py-0' : '' }}">
                            @if ($inscripciones->hasPages())
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $inscripciones->firstItem() }} - {{ $inscripciones->lastItem() }} de {{
                                    $inscripciones->total()}} registros
                                </div>
                                <div class="mt-3">
                                    {{ $inscripciones->links() }}
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $inscripciones->firstItem() }} - {{ $inscripciones->lastItem() }} de {{
                                    $inscripciones->total()}} registros
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal pago --}}
    <div class="modal" id="modal-pago" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Ver Pago
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="limpiar_modal_pago"></button>
                </div>
                <form autocomplete="off" novalidate wire:submit="guardar_pago">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label for="lugar_pago" class="form-label required">
                                    Lugar de Pago
                                </label>
                                <select class="form-select @error('lugar_pago') is-invalid @enderror" id="lugar_pago"
                                    wire:model.live="lugar_pago">
                                    <option value="">Seleccione su lugar de pago</option>
                                    @foreach ($lugar_pagos as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('lugar_pago')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label for="codigo_pago" class="form-label required">
                                    Código de Pago
                                </label>
                                <input type="text" class="form-control @error('codigo_pago') is-invalid @enderror"
                                    id="codigo_pago" wire:model.live="codigo_pago"
                                    placeholder="Ingrese el código de pago" />
                                @error('codigo_pago')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label for="fecha_pago" class="form-label required">
                                    Fecha de Pago
                                </label>
                                <input type="date" class="form-control @error('fecha_pago') is-invalid @enderror"
                                    id="fecha_pago" wire:model.live="fecha_pago" />
                                @error('fecha_pago')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12">
                                <label for="verificar_pago" class="form-label required">
                                    Verificar Pago
                                </label>
                                <select class="form-select @error('verificar_pago') is-invalid @enderror"
                                    id="verificar_pago" wire:model.live="verificar_pago">
                                    <option value="">Seleccione una opción</option>
                                    <option value="1">Verificar pago</option>
                                    <option value="0">No Verificar pago</option>
                                </select>
                                @error('verificar_pago')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label text-center mt-2">
                                    Fotografía de Voucher de Pago
                                </label>
                                <div class="text-center">
                                    <img src="{{ asset($archivo_pago->ruta ?? '') }}" class="img-fluid" width="90%"
                                        alt="voucher">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="limpiar_modal_pago">
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
    {{-- modal documentos --}}
    <div class="modal" id="modal-documentos" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Documentos
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="limpiar_modal_documentos"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap table-striped  datatable">
                                    <thead>
                                        <tr>
                                            <th class="w-1">No.</th>
                                            <th class="col-6">Documento</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documentos as $item)
                                        <tr>
                                            <td>
                                                <span class="text-secondary">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </td>
                                            <td class="fw-bold">
                                                Documento de {{ $item['nombre'] }}
                                            </td>
                                            <td>
                                                <div class="row g-1">
                                                    @if ($item['archivo'])
                                                    <div class="col-lg-6">
                                                        <span class="badge bg-teal-lt py-2 px-3 w-full">Archivo
                                                            subido</span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <a href="{{ asset($item['ruta']) }}" target="_blank"
                                                            class="btn btn-sm py-1 px-2 rounded w-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M4 20l16 0"></path>
                                                                <path d="M12 14l0 -10"></path>
                                                                <path d="M12 14l4 -4"></path>
                                                                <path d="M12 14l-4 -4"></path>
                                                            </svg>
                                                            Ver documento
                                                        </a>
                                                    </div>
                                                    @else
                                                    <div class="col-lg-12">
                                                        <span class="badge bg-red-lt py-2 px-3 w-full">Sin
                                                            archivo</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if ($item['archivo'])
                                                <button type="button" {{-- data-bs-toggle="modal"
                                                    data-bs-target="#modal-subir-documentos" --}}
                                                    wire:click="modo_documento({{ $item['id'] }}, 'edit')"
                                                    class="btn btn-sm btn-outline-orange py-1 px-2 rounded w-full">
                                                    Editar documento
                                                </button>
                                                @else
                                                <button type="button" {{-- data-bs-toggle="modal"
                                                    data-bs-target="#modal-subir-documentos" --}}
                                                    wire:click="modo_documento({{ $item['id'] }}, 'create')"
                                                    class="btn btn-sm btn-outline-indigo py-1 px-2 rounded w-full">
                                                    Subir documento
                                                </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                <span class="text-secondary">
                                                    {{ $documentos->count() + 1 }}
                                                </span>
                                            </td>
                                            <td class="fw-bold">
                                                Ficha de Matrícula
                                            </td>
                                            <td colspan="2">
                                                <div class="row g-1">
                                                    <div class="col-lg-12">
                                                        <a href="{{ route('reporte.ficha-matricula', $inscripcion_id ?? 0) }}"
                                                            target="_blank" class="btn btn-sm py-1 px-2 rounded w-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M4 20l16 0"></path>
                                                                <path d="M12 14l0 -10"></path>
                                                                <path d="M12 14l4 -4"></path>
                                                                <path d="M12 14l-4 -4"></path>
                                                            </svg>
                                                            Ver documento
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-secondary">
                                                    {{ $documentos->count() + 2 }}
                                                </span>
                                            </td>
                                            <td class="fw-bold">
                                                Carta de compromiso
                                            </td>
                                            <td colspan="2">
                                                <div class="row g-1">
                                                    <div class="col-lg-12">
                                                        <a href="{{ route('reporte.carta-compromiso', $inscripcion_id ?? 0) }}"
                                                            target="_blank" class="btn btn-sm py-1 px-2 rounded w-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M4 20l16 0"></path>
                                                                <path d="M12 14l0 -10"></path>
                                                                <path d="M12 14l4 -4"></path>
                                                                <path d="M12 14l-4 -4"></path>
                                                            </svg>
                                                            Ver documento
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-secondary">
                                                    {{ $documentos->count() + 3 }}
                                                </span>
                                            </td>
                                            <td class="fw-bold">
                                                Declaración Jurada
                                            </td>
                                            <td colspan="2">
                                                <div class="row g-1">
                                                    <div class="col-lg-12">
                                                        <a href="{{ route('reporte.declaracion-jurada', $inscripcion_id ?? 0) }}"
                                                            target="_blank" class="btn btn-sm py-1 px-2 rounded w-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M4 20l16 0"></path>
                                                                <path d="M12 14l0 -10"></path>
                                                                <path d="M12 14l4 -4"></path>
                                                                <path d="M12 14l-4 -4"></path>
                                                            </svg>
                                                            Ver documento
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal documentos edit | create --}}
    <div class="modal" id="modal-subir-documentos" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Subir Documento - {{ $nombre_documento ?? '' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form autocomplete="off" novalidate wire:submit="guardar_documento">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="text-dark mb-2">
                                <label for="documento" class="form-label required">
                                    Subir documento
                                </label>
                                <input type="file" class="form-control @error('documento') is-invalid @enderror"
                                    id="documento" wire:model.live="documento"
                                    accept="image/jpeg,image/png,image/jpg" />
                                <small class="form-hint">
                                    - La fotografía debe ser nítida. <br>
                                    - Se aceptan los formatos JPG, JPEG y PNG.
                                </small>
                                @error('documento')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="cancelar_subida_documentos">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-teal ms-auto" @if ($documento==null)
                            wire:target="documento" @endif wire:loading.attr="disabled" wire:target="guardar_documento">
                            <div wire:loading.remove wire:target="guardar_documento">
                                Guardar
                            </div>
                            <div wire:loading wire:target="guardar_documento">
                                Procesando <span class="spinner-border spinner-border-sm align-middle"></span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal editar datos postulante --}}
    <div class="modal" id="modal-postulante" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Editar Datos del Postulante
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="limpiar_modal_postulante"></button>
                </div>
                <form autocomplete="off" novalidate wire:submit="guardar_datos_postulante">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <span class="fw-bold fs-2 text-secondary">
                                    Datos Personales
                                </span>
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <label for="apellido_paterno" class="form-label required">
                                    Apellido Paterno
                                </label>
                                <input type="text" class="form-control @error('apellido_paterno') is-invalid @enderror"
                                    id="apellido_paterno" wire:model.live="apellido_paterno"
                                    placeholder="Ingrese su apellido paterno" />
                                @error('apellido_paterno')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <label for="apellido_materno" class="form-label required">
                                    Apellido Materno
                                </label>
                                <input type="text" class="form-control @error('apellido_materno') is-invalid @enderror"
                                    id="apellido_materno" wire:model.live="apellido_materno"
                                    placeholder="Ingrese su apellido materno" />
                                @error('apellido_materno')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <label for="nombre" class="form-label required">
                                    Nombres
                                </label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                    id="nombre" wire:model.live="nombre" placeholder="Ingrese su nombre" />
                                @error('nombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <label for="fecha_nacimiento" class="form-label required">
                                    Fecha de Nacimiento
                                </label>
                                <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                    id="fecha_nacimiento" wire:model.live="fecha_nacimiento" />
                                @error('fecha_nacimiento')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <label for="sexo" class="form-label required">
                                    Sexo
                                </label>
                                <select class="form-select @error('sexo') is-invalid @enderror" id="sexo"
                                    wire:model.live="sexo">
                                    <option value="">Seleccione una opción</option>
                                    <option value="M">MASCULINO</option>
                                    <option value="F">FEMENINO</option>
                                </select>
                                @error('sexo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <label for="celular" class="form-label required">
                                    Celular
                                </label>
                                <input type="text" class="form-control @error('celular') is-invalid @enderror"
                                    id="celular" wire:model.live="celular" placeholder="Ingrese su celular" />
                                @error('celular')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <label for="grupo_etnico" class="form-label required">
                                    Grupo Étnico
                                </label>
                                <select class="form-select @error('grupo_etnico') is-invalid @enderror"
                                    id="grupo_etnico" wire:model.live="grupo_etnico">
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($grupos as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('grupo_etnico')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <label for="lengua_materna" class="form-label required">
                                    Lengua Materna
                                </label>
                                <select class="form-select @error('lengua_materna') is-invalid @enderror"
                                    id="lengua_materna" wire:model.live="lengua_materna">
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($lenguas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('lengua_materna')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <label for="comunidad" class="form-label">
                                    Comunidad
                                </label>
                                <input type="text" class="form-control @error('comunidad') is-invalid @enderror"
                                    id="comunidad" wire:model.live="comunidad" placeholder="Ingrese su comunidad" />
                                @error('comunidad')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <label for="direccion" class="form-label">
                                    Dirección
                                </label>
                                <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                                    id="direccion" wire:model.live="direccion" placeholder="Ingrese su direccion" />
                                @error('direccion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <span class="fw-bold fs-2 text-secondary">
                                    Datos de Inscripción
                                </span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <label for="carrera" class="form-label required">
                                    Carrera
                                </label>
                                <select class="form-select @error('carrera') is-invalid @enderror" id="carrera"
                                    wire:model.live="carrera">
                                    <option value="">Seleccione una opción</option>
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="limpiar_modal_postulante">
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