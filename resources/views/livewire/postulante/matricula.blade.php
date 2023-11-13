<div>
    <!-- Page header -->
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title text-uppercase">
                        Finalizar Matrícula
                    </h2>
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Finalizar Matrícula</a></li>
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
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="animate__animated animate__fadeIn animate__faster">
                        <ul class="steps steps-teal steps-counter my-4">
                            <li class="step-item {{ $paso == 1 ? 'active' : '' }}">
                                Información de Pago
                            </li>
                            <li class="step-item {{ $paso == 2 ? 'active' : '' }}">
                                Datos de Matrícula
                            </li>
                            <li class="step-item {{ $paso == 3 ? 'active' : '' }}">
                                Información Adicional
                            </li>
                            <li class="step-item {{ $paso == 4 ? 'active' : '' }}">
                                Finalizar
                            </li>
                        </ul>
                    </div>
                    <div class="alert alert-orange mb-3 animate__animated animate__fadeIn animate__faster">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9h.01"></path>
                            <path d="M11 12h1v4h1"></path>
                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                        </svg>
                        <strong>
                            Por favor recuerde que debe realizar el pago de matrícula para poder continuar con el proceso final de matrícula.
                        </strong>
                    </div>
                    @if($paso == 1)
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-header bg-yellow-lt">
                            <h3 class="card-title">Información de Pago</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xl-6 col-lg-12 col-md-12">
                                    <label for="metodo_pago" class="form-label required">
                                        Metodo de Pago
                                    </label>
                                    <select class="form-select @error('metodo_pago') is-invalid @enderror"
                                        id="metodo_pago" wire:model.live="metodo_pago">
                                        <option value="">Seleccione su metodo de pago</option>
                                        @foreach ($tipos_pagos as $item)
                                        <option value="{{ $item->id }}">
                                            S/. {{ number_format($item->costo, 2, ',', ' ') }} - {{ $item->grupo == 1 ? 'MESTIZOS' : 'PUEBLOS ORIGINARIOS' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('metodo_pago')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-12">
                                    <label for="lugar_pago" class="form-label required">
                                        Lugar de Pago
                                    </label>
                                    <select class="form-select @error('lugar_pago') is-invalid @enderror"
                                        id="lugar_pago" wire:model.live="lugar_pago">
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
                                    <label for="fecha_pago" class="form-label required">
                                        Fecha de Pago
                                    </label>
                                    <input type="date" class="form-control @error('fecha_pago') is-invalid @enderror" id="fecha_pago"
                                        wire:model.live="fecha_pago" />
                                    @error('fecha_pago')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-12">
                                    <label for="voucher" class="form-label required">
                                        Fotografía del Voucher de Pago
                                    </label>
                                    <input type="file" class="form-control @error('voucher') is-invalid @enderror" id="voucher"
                                        wire:model.live="voucher" acept="image/jpeg,image/png,image/jpg" />
                                    <small class="form-hint">
                                        - La fotografía debe ser nítida. <br>
                                        - Se aceptan los formatos JPG, JPEG y PNG.
                                    </small>
                                    @error('voucher')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($paso == 2)
                    <div class="alert alert-info mb-3 animate__animated animate__fadeIn animate__faster">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9h.01"></path>
                            <path d="M11 12h1v4h1"></path>
                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                        </svg>
                        <strong>
                            Por favor recuerde que una vez elegido su carrera, no podrá cambiarla.
                        </strong>
                    </div>
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-header bg-yellow-lt">
                            <h3 class="card-title">Datos de Matrícula</h3>
                        </div>
                        <div class="card-body mb-1">
                            <div class="row g-3">
                                <div class="col-xl-5 col-lg-12 col-md-12">
                                    <label for="area" class="form-label required">
                                        Área
                                    </label>
                                    <select class="form-select @error('area') is-invalid @enderror"
                                        id="area" wire:model.live="area">
                                        <option value="">Seleccione su área</option>
                                            @foreach ($areas as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }} - {{ $item->descripcion }}</option>
                                            @endforeach
                                    </select>
                                    @error('area')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-7 col-lg-12 col-md-12">
                                    <label for="carrera" class="form-label required">
                                        Carrera
                                    </label>
                                    <select class="form-select @error('carrera') is-invalid @enderror"
                                        id="carrera" wire:model.live="carrera">
                                        <option value="">Seleccione su área</option>
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
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <label for="turno" class="form-label required">
                                        Turno
                                    </label>
                                    <select class="form-select @error('turno') is-invalid @enderror"
                                        id="turno" wire:model.live="turno">
                                        <option value="">Seleccione su turno</option>
                                        @foreach ($turnos   as $item)
                                        <option value="{{ $item->id }}">TURNO {{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('turno')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($paso == 3)
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-header bg-yellow-lt">
                            <h3 class="card-title">Información de Adicional</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @foreach ($preguntas as $item)
                                <div class="col-xl-12 col-lg-12 col-md-12" wire:key="{{ $item->id }}">
                                    <label for="{{ $item->id }}" class="form-label required">
                                        {{ $item->nombre }}
                                    </label>
                                    <div>
                                        @foreach ($item->respuestas as $respuesta)
                                            @if ($item->respuestas->count() == 1)
                                            <input type="text" class="form-control @error('respuesta.{{ $item->id }}') is-invalid @enderror"
                                                id="{{ $item->id }}" wire:model.live="respuesta.{{ $item->id }}" placeholder="{{ $item->item == 2 ? 'Ejemplo: Estidiante, etc' : ( $item->item == 3 ? 'Ejemplo: Cantar, Leer, Bailar, etc' : 'Ejemplo: Ingles, Shipibo, Portugues, etc' ) }}">
                                            @else
                                            <label class="form-check form-check-inline" wire:key="{{ $respuesta->id }}">
                                                <input class="form-check-input @error('respuesta.{{ $item->id }}') is-invalid @enderror" type="radio" id="{{ $respuesta->id }}"
                                                    wire:model.live="respuesta.{{ $item->id }}" value="{{ $respuesta->id }}">
                                                <span class="form-check-label @error('respuesta.{{ $item->id }}') text-danger @enderror">
                                                    {{ $respuesta->nombre }}
                                                </span>
                                            </label>
                                            @endif
                                        @endforeach
                                    </div>
                                    @error('respuesta.{{ $item->id }}')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    @if ($paso == 4)
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body text-center my-5">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-teal" width="120" height="120"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3">
                                    </path>
                                </svg>
                            </div>
                            <span class="fs-1 fw-bold">
                                Gracias por completar su matrícula.
                            </span>
                            <div class="alert alert-red mt-5 py-4">
                                <div class="d-flex flex-column mx-auto">
                                    <div>
                                        <h4 class="alert-title text-red fs-2 mb-2">¡Advertencia!</h4>
                                        <div class="text-secondary fs-3 px-5">
                                            La información que estás proporcionando no se puede modificar una vez finalizado el proceso de matrícula.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="d-flex justify-content-{{ $paso == 1 ? 'end' : 'between' }} align-items-center mt-3 animate__animated animate__fadeIn animate__faster">
                        @if ($paso == 2 || $paso == 3 || $paso == 4)
                        <button type="button" class="btn" wire:click="atras">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mx-4" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M12 15v3.586a1 1 0 0 1 -1.707 .707l-6.586 -6.586a1 1 0 0 1 0 -1.414l6.586 -6.586a1 1 0 0 1 1.707 .707v3.586h3v6h-3z">
                                </path>
                                <path d="M21 15v-6"></path>
                                <path d="M18 15v-6"></path>
                            </svg>
                        </button>
                        @endif
                        @if ($paso == 1 || $paso == 2 || $paso == 3)
                        <button type="button" class="btn" wire:click="siguiente">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mx-4" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M12 9v-3.586a1 1 0 0 1 1.707 -.707l6.586 6.586a1 1 0 0 1 0 1.414l-6.586 6.586a1 1 0 0 1 -1.707 -.707v-3.586h-3v-6h3z">
                                </path>
                                <path d="M3 9v6"></path>
                                <path d="M6 9v6"></path>
                            </svg>
                        </button>
                        @endif
                        @if ($paso == 4)
                        <button type="button" class="btn btn-outline-teal" wire:click="finalizar_matricula">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mx-4" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M7 12l5 5l10 -10"></path>
                                <path d="M2 12l5 5m5 -5l5 -5"></path>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
