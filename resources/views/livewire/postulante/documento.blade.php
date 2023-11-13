<div>
    <!-- Page header -->
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title text-uppercase">
                        Documentos
                    </h2>
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('postulante.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Documentos</a></li>
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
                A continuación se muestra el panel de documentos, en el cual podrá visualizar los documentos que ha subido y subir nuevos documentos.
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <div class="card animate__animated animate__fadeIn animate__faster">
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped  datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Documento</th>
                                        <th>Estado</th>
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
                                            {{ $item['nombre'] }}
                                        </td>
                                        <td>
                                            @if ($item['archivo'])
                                            <span class="badge bg-blue-lt py-1 px-3">
                                                Documento Subido
                                            </span>
                                            @else
                                            <span class="badge bg-red-lt py-1 px-3">
                                                Documento Pendiente
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                @if ($item['archivo'])
                                                    <a href="{{ asset($item['ruta']) }}" target="_blank" class="btn btn-sm">
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
                                                @endif
                                                @if ($item['archivo'])
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-indigo"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-documento"
                                                    wire:click="modal_documento({{ $item['tipo'] ?? $item['id'] }}, true)"
                                                    >
                                                    Editar
                                                </button>
                                                @else
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-teal }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-documento"
                                                    wire:click="modal_documento({{ $item['tipo'] ?? $item['id'] }}, false)"
                                                    >
                                                    Subir
                                                </button>
                                                @endif
                                            </div>
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
                                            Carta de Compromiso
                                        </td>
                                        <td>
                                            <span class="badge bg-blue-lt py-1 px-3">
                                                Documento Generado
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                <a href="{{ route('reporte.carta-compromiso', $inscripcion->id) }}" target="_blank" class="btn btn-sm">
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
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-azure"
                                                    disabled
                                                    >
                                                    Editar
                                                </button>
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
                                            Declaración Jurada
                                        </td>
                                        <td>
                                            <span class="badge bg-blue-lt py-1 px-3">
                                                Documento Generado
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                <a href="{{ route('reporte.declaracion-jurada', $inscripcion->id) }}" target="_blank" class="btn btn-sm">
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
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-azure"
                                                    disabled
                                                    >
                                                    Editar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @if ($inscripcion->estado == 2)
                                    <tr>
                                        <td>
                                            <span class="text-secondary">
                                                {{ $documentos->count() + 3 }}
                                            </span>
                                        </td>
                                        <td class="fw-bold">
                                            Ficha de Matrícula
                                        </td>
                                        <td>
                                            <span class="badge bg-blue-lt py-1 px-3">
                                                Documento Generado
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap justify-content-end">
                                                <a href="{{ route('reporte.ficha-matricula', $inscripcion->id) }}" target="_blank" class="btn btn-sm">
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
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-azure"
                                                    disabled
                                                    >
                                                    Editar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal documentos --}}
    <div class="modal" id="modal-documento" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_modal }} - {{ $nombre_documento ?? '' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" novalidate wire:submit="guardar_documento">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="text-dark mb-2">
                                <label for="documento" class="form-label required">
                                    {{ $nombre_documento ?? '' }}
                                </label>
                                <input type="file" class="form-control @error('documento') is-invalid @enderror"
                                    id="documento" wire:model.live="documento" accept="image/jpeg,image/png,image/jpg" />
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
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close" wire:click="limpiar_modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-teal ms-auto" @if ($documento==null)
                            wire:target="documento" @endif wire:loading.attr="disabled" wire:target="guardar_documento">
                            <div wire:loading.remove wire:target="guardar_documento">
                                Guardar
                            </div>
                            <div wire:loading wire:target="guardar_documento">
                                Procesando <span class="spinner-border spinner-border-sm align-middle ms-1"></span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
