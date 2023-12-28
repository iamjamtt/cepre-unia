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
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-12">
                    <div class="alert alert-yellow mb-3 animate__animated animate__fadeIn animate__faster">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9h.01"></path>
                            <path d="M11 12h1v4h1"></path>
                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                        </svg>
                        <strong>
                            Por favor recuerde que debe realizar el pago de matrícula para poder continuar con el
                            proceso final de matrícula.
                        </strong>
                    </div>
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-header bg-pink-lt">
                            <h3 class="card-title">
                                Requisitos de matrícula
                            </h3>
                        </div>
                        <div class="card-body my-3">
                            <div class="row g-3">
                                <div class="col-xxl-4 col-xl-6 col-lg-6">
                                    <div
                                        class="card card-stacked card-link card-link-pop bg-indigo-lt shadow shadow-sm">
                                        <div class="card-body">
                                            <h3 class="card-title fs-1" style="font-weight: 800;">
                                                Paso 1
                                            </h3>
                                            <span class="fw-bold fs-3">
                                                Subir Fotografía
                                            </span>
                                            <p class="text-dark mt-3 text-justify">
                                                El Administrador del sistema validará su Fotografía digital, sin lentes,
                                                fondo blanco y a colores. No se aceptan selfies, fotos borrosas, éstas
                                                automáticamente serán desaprobadas.
                                            </p>
                                            @if ($foto_archivo)
                                                <div class="d-flex justify-content-center mb-3">
                                                    <img src="{{ asset($foto_archivo->ruta) }}" class="rounded"
                                                        height="130px" alt="Foto">
                                                </div>
                                                <div class="text-center">
                                                    @if ($inscripcion->foto == 1)
                                                        <span class="badge bg-teal px-3 py-2 shadow shadow-sm fs-4"
                                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                                            title="Para editar la foto ve al módulo de documentos">
                                                            Fotografía verificada
                                                        </span>
                                                    @else
                                                        <span class="badge bg-yellow px-3 py-2 shadow shadow-sm fs-4"
                                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                                            title="Para editar la foto ve al módulo de documentos">
                                                            Fotografía por verificar
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                @if ($foto)
                                                    <div class="d-flex justify-content-center mb-2">
                                                        <img src="{{ $foto->temporaryUrl() }}" class="img-fluid rounded"
                                                            width="120px" alt="Foto">
                                                    </div>
                                                @endif
                                                <div class="text-dark">
                                                    <label for="foto" class="form-label required">
                                                        Subir foto
                                                    </label>
                                                    <input type="file"
                                                        class="form-control @error('foto') is-invalid @enderror"
                                                        id="foto" wire:model.live="foto"
                                                        accept="image/jpeg,image/png,image/jpg" />
                                                    <small class="form-hint">
                                                        - La fotografía debe ser nítida. <br>
                                                        - Se aceptan los formatos JPG, JPEG y PNG.
                                                    </small>
                                                    @error('foto')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="d-flex flex-column">
                                                    {{-- <button type="button" class="btn btn-indigo mt-3" @if ($foto == null)
                                                    wire:target="foto" @endif wire:loading.attr="disabled"
                                                    wire:target="guardar_foto" wire:click="guardar_foto">
                                                    <div wire:loading.remove wire:target="guardar_foto">
                                                        Guardar
                                                    </div>
                                                    <div wire:loading wire:target="guardar_foto">
                                                        <span
                                                            class="spinner-border spinner-border-sm align-middle"></span>
                                                    </div>
                                                </button> --}}
                                                    <button type="button" class="btn btn-indigo mt-3" wire:click="guardar_foto">
                                                        Guardar
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-6 col-lg-6">
                                    <div
                                        class="card card-stacked card-link card-link-pop bg-indigo-lt shadow shadow-sm">
                                        <div class="card-body">
                                            <h3 class="card-title fs-1" style="font-weight: 800;">
                                                Paso 2
                                            </h3>
                                            <span class="fw-bold fs-3">
                                                Subir Documentos
                                            </span>
                                            <p class="text-dark mt-3 text-justify">
                                                Los documentos deben ser imágenes escaneadas o fotografías nítidas,
                                                legibles y a colores. No se aceptan documentos borrosos, éstos
                                                automáticamente serán desaprobados.
                                            </p>
                                            @if ($dni_archivo)
                                                <span
                                                    class="badge bg-indigo px-3 py-2 shadow shadow-sm fs-4 w-full mb-3"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Para editar el DNI ve al módulo de documentos">
                                                    DNI subido con exito
                                                </span>
                                            @else
                                                <div class="text-dark mb-2">
                                                    <label for="dni" class="form-label required">
                                                        Copia ampliada de dni
                                                    </label>
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <input type="file"
                                                                class="form-control @error('dni') is-invalid @enderror"
                                                                id="dni" wire:model.live="dni"
                                                                accept="image/jpeg,image/png,image/jpg" />
                                                            @error('dni')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-auto">
                                                            <button class="btn btn-icon btn-blue"
                                                                wire:click="subir_dni">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-arrow-bar-up"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M12 4l0 10" />
                                                                    <path d="M12 4l4 4" />
                                                                    <path d="M12 4l-4 4" />
                                                                    <path d="M4 20l16 0" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($certificado_archivo)
                                                <span
                                                    class="badge bg-indigo px-3 py-2 shadow shadow-sm fs-4 w-full mb-3"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Para editar el Certificado de Estudios ve al módulo de documentos">
                                                    Certificado de estudios subido con exito
                                                </span>
                                            @else
                                                <div class="text-dark mb-2">
                                                    <label for="certificado" class="form-label required">
                                                        Certificado de estudios
                                                    </label>
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <input type="file"
                                                                class="form-control @error('certificado') is-invalid @enderror"
                                                                id="certificado" wire:model.live="certificado"
                                                                accept="image/jpeg,image/png,image/jpg" />
                                                            @error('certificado')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-auto">
                                                            <button class="btn btn-icon btn-blue"
                                                                wire:click="subir_certificado">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-arrow-bar-up"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M12 4l0 10" />
                                                                    <path d="M12 4l4 4" />
                                                                    <path d="M12 4l-4 4" />
                                                                    <path d="M4 20l16 0" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($partida_archivo)
                                                <span
                                                    class="badge bg-indigo px-3 py-2 shadow shadow-sm fs-4 w-full mb-3"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Para editar la Partida de Nacimiento ve al módulo de documentos">
                                                    Partida de nacimiento subido con exito
                                                </span>
                                            @else
                                                <div class="text-dark mb-2">
                                                    <label for="partida" class="form-label required">
                                                        Partida de nacimiento
                                                    </label>
                                                    <div class="row g-2">
                                                        <div class="col">
                                                            <input type="file"
                                                                class="form-control @error('partida') is-invalid @enderror"
                                                                id="partida" wire:model.live="partida"
                                                                accept="image/jpeg,image/png,image/jpg" />
                                                            @error('partida')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-auto">
                                                            <button class="btn btn-icon btn-blue"
                                                                wire:click="subir_partida">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-arrow-bar-up"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M12 4l0 10" />
                                                                    <path d="M12 4l4 4" />
                                                                    <path d="M12 4l-4 4" />
                                                                    <path d="M4 20l16 0" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($mestizo == false)
                                                @if ($constancia_archivo)
                                                    <span
                                                        class="badge bg-indigo px-3 py-2 shadow shadow-sm fs-4 w-full mb-3"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Para editar la Constancia de Comunidad ve al módulo de documentos">
                                                        Constancia de comunidad subido con exito
                                                    </span>
                                                @else
                                                    <div class="text-dark mb-2">
                                                        <label for="constancia" class="form-label required">
                                                            Constancia de comunidad u otros
                                                        </label>
                                                        <div class="row g-2">
                                                            <div class="col">
                                                                <input type="file"
                                                                    class="form-control @error('constancia') is-invalid @enderror"
                                                                    id="constancia" wire:model.live="constancia"
                                                                    accept="image/jpeg,image/png,image/jpg" />
                                                                @error('constancia')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-auto">
                                                                <button class="btn btn-icon btn-blue"
                                                                    wire:click="subir_constancia">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-arrow-bar-up"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24" stroke-width="2"
                                                                        stroke="currentColor" fill="none"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path d="M12 4l0 10" />
                                                                        <path d="M12 4l4 4" />
                                                                        <path d="M12 4l-4 4" />
                                                                        <path d="M4 20l16 0" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (!$dni_archivo || !$certificado_archivo || !$partida_archivo)
                                                <div>
                                                    <small class="form-hint">
                                                        - La fotografía debe ser nítida. <br>
                                                        - Se aceptan los formatos JPG, JPEG y PNG.
                                                    </small>
                                                </div>
                                            @else
                                                @if ($inscripcion->documento == 1)
                                                    <span class="badge bg-teal px-3 py-2 shadow shadow-sm fs-4 w-full"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Para editar los documentos ve al módulo de documentos">
                                                        Documentos verificados
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-yellow px-3 py-2 shadow shadow-sm fs-4 w-full"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Para editar los documentos ve al módulo de documentos">
                                                        Documentos por verificar
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-6 col-lg-6">
                                    <div
                                        class="card card-stacked card-link card-link-pop bg-indigo-lt shadow shadow-sm">
                                        <div class="card-body">
                                            <h3 class="card-title fs-1" style="font-weight: 800;">
                                                Paso 3
                                            </h3>
                                            <span class="fw-bold fs-3">
                                                Descargar Ficha de Matrícula
                                            </span>
                                            <p class="text-dark mt-3 text-justify">
                                                Puedes descargar tu Ficha de Matrícula en esta sección, no olvides
                                                revisar que tu información sea correcta, caso contrario comunícate con
                                                nosotros.<br>
                                                Para bajar o descargar tu Ficha de Matrícula, sólo debes hacer clic en
                                                la sigueinte icono.
                                            </p>
                                            @if ($inscripcion->estado == 2)
                                                <div class="d-flex flex-column">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="m-auto"
                                                        width="85" height="85" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                        <path
                                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                                        </path>
                                                        <path d="M12 17v-6"></path>
                                                        <path d="M9.5 14.5l2.5 2.5l2.5 -2.5"></path>
                                                    </svg>
                                                    <a href="{{ route('reporte.ficha-matricula', $inscripcion->id) }}"
                                                        target="_blank" class="btn btn-indigo mt-3"
                                                        wire:click="guardar_foto">
                                                        Descargar Ficha de Matrícula
                                                    </a>
                                                </div>
                                            @else
                                                <div class="d-flex flex-column">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="mx-auto mb-2 text-red" width="53" height="53"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z">
                                                        </path>
                                                        <path d="M9 9l6 6m0 -6l-6 6"></path>
                                                    </svg>
                                                    <div class="alert alert-important alert-danger mb-0">
                                                        <div class="text-center">
                                                            Ups... el administrador del sistema aún <strong>no valida tu
                                                                matrícula</strong>, esta verificación puede tardar hasta
                                                            24
                                                            horas.
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
