<div>
    <div class="page-body">
        <div class="container-xl">
            <div class="d-flex justify-content-center align-items-center animate__animated animate__fadeIn animate__faster">
                <span class="fs-2 fw-bold text-uppercase">
                    Bienvenidos al Sistema de Matrícula de la CEPRE UNIA {{ HelperUnia::getNombreCiclo() }}
                </span>
            </div>
            <div class="row">
                <div class="col-12 animate__animated animate__fadeIn animate__faster">
                    <ul class="steps steps-teal steps-counter my-4">
                        <li class="step-item {{ $paso == 1 ? 'active' : '' }}">
                            Datos Personales
                        </li>
                        <li class="step-item {{ $paso == 2 ? 'active' : '' }}">
                            Datos de Colegio
                        </li>
                        <li class="step-item {{ $paso == 3 ? 'active' : '' }}">
                            Datos de Inicio de Sesión
                        </li>
                        <li class="step-item {{ $paso == 4 ? 'active' : '' }}">
                            Finalizar
                        </li>
                    </ul>
                </div>
                <div class="col-12 px-5 mb-3">
                    <div class="alert alert-warning mb-3 animate__animated animate__fadeIn animate__faster">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9h.01"></path>
                            <path d="M11 12h1v4h1"></path>
                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                        </svg>
                        <strong>
                            Por favor llene los datos requeridos para iniciar con su matrícula.
                        </strong>
                    </div>
                    <div class="alert alert-info mb-3 animate__animated animate__fadeIn animate__faster">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9h.01"></path>
                            <path d="M11 12h1v4h1"></path>
                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                        </svg>
                        <strong>
                            Si ya realizo el registro en anteriores convocatorias, ya no es necesario volver a registrarse, solo ingrese con su DNI y contraseña.
                        </strong>
                    </div>
                    @if ($paso == 1)
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-header bg-teal-lt">
                            <h3 class="card-title">Datos Personales</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label for="dni" class="form-label required">
                                        DNI
                                    </label>
                                    <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni"
                                        wire:model.live="dni" placeholder="Ingrese su dni" />
                                    @error('dni')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
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
                                <div class="col-xl-3 col-lg-4 col-md-6">
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
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label for="nombres" class="form-label required">
                                        Nombres
                                    </label>
                                    <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres"
                                        wire:model.live="nombres" placeholder="Ingrese su nombre" />
                                    @error('nombres')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label for="sexo" class="form-label required">
                                        Sexo
                                    </label>
                                    <select class="form-select @error('sexo') is-invalid @enderror" id="sexo"
                                        wire:model.live="sexo">
                                        <option value="">Seleccione su sexo</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    @error('sexo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
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
                                <div class="col-xl-3 col-lg-6 col-md-6">
                                    <label for="grupo_etnico" class="form-label required">
                                        Grupo Étnico
                                    </label>
                                    <select class="form-select @error('grupo_etnico') is-invalid @enderror" id="grupo_etnico"
                                        wire:model.live="grupo_etnico">
                                        <option value="">Seleccione su grupo étnico</option>
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
                                <div class="col-xl-3 col-lg-6 col-md-6">
                                    <label for="lengua_materna" class="form-label required">
                                        Lengua Materna
                                    </label>
                                    <select class="form-select @error('lengua_materna') is-invalid @enderror"
                                        id="lengua_materna" wire:model.live="lengua_materna">
                                        <option value="">Seleccione su lengua materna</option>
                                        @foreach ($lenguas_maternas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('lengua_materna')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <label for="dominio_lengua" class="form-label">
                                        Dominio de Lengua Materna
                                    </label>
                                    <div>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="dominio_lengua"
                                                wire:model.live="dominio_lengua" value="Solo entiendo">
                                            <span class="form-check-label">Solo entiendo</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="dominio_lengua"
                                                wire:model.live="dominio_lengua" value="Hablo">
                                            <span class="form-check-label">Hablo</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="dominio_lengua"
                                                wire:model.live="dominio_lengua" value="Leo">
                                            <span class="form-check-label">Leo</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="dominio_lengua"
                                                wire:model.live="dominio_lengua" value="Escribo">
                                            <span class="form-check-label">Escribo</span>
                                        </label>
                                    </div>
                                    @error('dominio_lengua')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6">
                                    <label for="segunda_lengua" class="form-label">
                                        Segunda Lengua
                                    </label>
                                    <input type="text" class="form-control @error('segunda_lengua') is-invalid @enderror"
                                        id="segunda_lengua" wire:model.live="segunda_lengua"
                                        placeholder="Ingrese su segunda lengua" />
                                    @error('segunda_lengua')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label for="correo_electronico" class="form-label required">
                                        Correo Electrónico
                                    </label>
                                    <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror"
                                        id="correo_electronico" wire:model.live="correo_electronico"
                                        placeholder="Ingrese su correo electronico" />
                                    @error('correo_electronico')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <label for="celular" class="form-label required">
                                        Celular del Postulante
                                    </label>
                                    <input type="text" class="form-control @error('celular') is-invalid @enderror" id="celular"
                                        wire:model.live="celular" placeholder="Ingrese su celular. Ejemplo: 987654321" />
                                    @error('celular')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label for="celular_apoderado" class="form-label">
                                            Celular del Apoderado
                                        </label>
                                        <input type="text" class="form-control @error('celular_apoderado') is-invalid @enderror"
                                            id="celular_apoderado" wire:model.live="celular_apoderado"
                                            placeholder="Ingrese su celular de su apoderado" />
                                        @error('celular_apoderado')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <label for="direccion" class="form-label required">
                                        Dirección Actual
                                    </label>
                                    <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                                        id="direccion" wire:model.live="direccion" placeholder="Ingrese su dirección actual" />
                                    @error('direccion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="">
                                        <label for="region" class="form-label required">
                                            Región de Nacimiento
                                        </label>
                                        <select class="form-select @error('region') is-invalid @enderror" id="region"
                                            wire:model.live="region">
                                            <option value="">Seleccione su región de nacimiento</option>
                                            @foreach ($departamentos as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('region')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="">
                                        <label for="provincia" class="form-label required">
                                            Provincia de Nacimiento
                                        </label>
                                        <select class="form-select @error('provincia') is-invalid @enderror" id="provincia"
                                            wire:model.live="provincia">
                                            <option value="">Seleccione su provincia de nacimiento</option>
                                            @foreach ($provincias as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('provincia')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="">
                                        <label for="distrito" class="form-label required">
                                            Distrito de Nacimiento
                                        </label>
                                        <select class="form-select @error('distrito') is-invalid @enderror" id="distrito"
                                            wire:model.live="distrito">
                                            <option value="">Seleccione su distrito de nacimiento</option>
                                            @foreach ($distritos as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('distrito')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="">
                                        <label for="comunidad" class="form-label">
                                            Comunidad o Pueblo de Nacimiento
                                        </label>
                                        <input type="text" class="form-control @error('comunidad') is-invalid @enderror"
                                            id="comunidad" wire:model.live="comunidad" placeholder="Ingrese su comunidad" />
                                        @error('comunidad')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if ($paso == 2)
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-header bg-teal-lt">
                            <h3 class="card-title">Datos de Colegio</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <label for="region_colegio" class="form-label required">
                                        Región del Colegio
                                    </label>
                                    <select class="form-select @error('region_colegio') is-invalid @enderror"
                                        id="region_colegio" wire:model.live="region_colegio">
                                        <option value="">Seleccione su region del colegio</option>
                                        @foreach ($departamentos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('region_colegio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <label for="provincia_colegio" class="form-label required">
                                        Provincia del Colegio
                                    </label>
                                    <select class="form-select @error('provincia_colegio') is-invalid @enderror"
                                        id="provincia_colegio" wire:model.live="provincia_colegio">
                                        <option value="">Seleccione su provincia del colegio</option>
                                        @foreach ($provincias_colegios as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('provincia_colegio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <label for="distrito_colegio" class="form-label required">
                                        Distrito del Colegio
                                    </label>
                                    <select class="form-select @error('distrito_colegio') is-invalid @enderror"
                                        id="distrito_colegio" wire:model.live="distrito_colegio">
                                        <option value="">Seleccione su distrito del colegio</option>
                                        @foreach ($distritos_colegios as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('distrito_colegio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-12">
                                    <label for="nombre_colegio" class="form-label required">
                                        Nombre del Colegio
                                    </label>
                                    <select class="form-select @error('nombre_colegio') is-invalid @enderror"
                                        id="nombre_colegio" wire:model.live="nombre_colegio" wire:key="nombre_colegio">
                                        <option value="">Seleccione su colegio</option>
                                        @foreach ($colegios as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('nombre_colegio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <label for="año_termino_colegio" class="form-label required">
                                        Año que terminó el colegio
                                    </label>
                                    <input type="text" class="form-control @error('año_termino_colegio') is-invalid @enderror"
                                        id="año_termino_colegio" wire:model.live="año_termino_colegio"
                                        placeholder="Ejemplo: 2021" />
                                    @error('año_termino_colegio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if ($paso == 3)
                    <div class="alert alert-info mb-3 animate__animated animate__fadeIn animate__faster">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9h.01"></path>
                            <path d="M11 12h1v4h1"></path>
                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                        </svg>
                        <strong>
                            Por favor recuerde su usuario y contraseña para iniciar sesión en el sistema.
                        </strong>
                    </div>
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-header bg-teal-lt">
                            <h3 class="card-title">Datos de Inicio de Sesión</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <label for="usuario" class="form-label required">
                                        Usuario
                                    </label>
                                    <input type="text" class="form-control @error('usuario') is-invalid @enderror" id="usuario"
                                        wire:model.live="usuario" placeholder="Ingresse su usuario" readonly />
                                    @error('usuario')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <label for="contraseña" class="form-label required">
                                        Contraseña
                                    </label>
                                    <input type="password" class="form-control @error('contraseña') is-invalid @enderror"
                                        id="contraseña" wire:model.live="contraseña" placeholder="Ingrese su contraseña" />
                                    @error('contraseña')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12">
                                    <label for="contraseña_confirmacion" class="form-label required">
                                        Confirmar Contraseña
                                    </label>
                                    <input type="password"
                                        class="form-control @error('contraseña_confirmacion') is-invalid @enderror"
                                        id="contraseña_confirmacion" wire:model.live="contraseña_confirmacion"
                                        placeholder="Confirme su contraseña" />
                                    @error('contraseña_confirmacion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if ($paso == 4)
                    <div class="card card-stacke animate__animated animate__fadeIn animate__faster">
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
                                Gracias por registrar tus datos, ahora podrás realizar tu matrícula.
                            </span>
                            <div class="alert alert-red mt-5 py-4">
                                <div class="d-flex flex-column mx-auto">
                                    <div>
                                        <h4 class="alert-title text-red fs-2 mb-2">¡Advertencia!</h4>
                                        <div class="text-secondary fs-3 px-5">
                                            La información que estás proporcionando se considerará como Declaración Jurada, en
                                            caso de falsedad se le sancionará de acuerdo al Reglamento de la CEPRE UNIA.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="d-flex justify-content-{{ $paso == 1 ? 'end' : 'between' }} align-items-center px-5 animate__animated animate__fadeIn animate__faster">
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
                    <button type="button" class="btn btn-outline-teal" wire:click="finalizar_registro">
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
@push('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {
        // region_colegio select2
        // $(document).ready(function () {
        //     $('#region_colegio').select2({
        //         placeholder: 'Seleccione su region del colegio',
        //         allowClear: true,
        //         width: '100%',
        //         selectOnClose: true,
        //         theme: "bootstrap4",
        //         language: {
        //             noResults: function () {
        //                 return "No se encontraron resultados";
        //             },
        //             searching: function () {
        //                 return "Buscando...";
        //             }
        //         }
        //     });
        //     $('#region_colegio').on('change', function(){
        //         @this.set('region_colegio', this.value);
        //     });
        //     Livewire.hook('element.prepare', (el, component) => {
        //         $('#region_colegio').select2({
        //             placeholder: 'Seleccione su region del colegio',
        //             allowClear: true,
        //             width: '100%',
        //             selectOnClose: true,
        //             theme: "bootstrap4",
        //             language: {
        //                 noResults: function () {
        //                     return "No se encontraron resultados";
        //                 },
        //                 searching: function () {
        //                     return "Buscando...";
        //                 }
        //             }
        //         });
        //         $('#region_colegio').on('change', function(){
        //             @this.set('region_colegio', this.value);
        //         });
        //     });
        // });
    });
</script>
@endpush
