<div class="row g-0 flex-fill">
    <div
        class="col-12 col-lg-6 col-xl-4 border-top-wide border-teal d-flex flex-column justify-content-center animate__animated animate__fadeIn animate__faster">
        <div class="container container-tight my-5 px-lg-5">
            <div class="text-center mb-5">
                <img src="{{ asset('static/portada.webp') }}" alt="portada">
            </div>
            <h2 class="fs-2 text-center mb-5">
                Ingresa a tu cuenta
            </h2>
            <p class="text-muted text-center mb-4">
                Los postulantes podrán acceder al sistema cuando ya hayan creado su cuenta, podrán verificar el estado
                de su inscripción.
            </p>
            <div class="alert alert-info m-0 mb-4">
                <strong>
                    Si ya realizo el registro en anteriores convocatorias, ya no es necesario volver a registrarse, solo ingrese con su DNI y contraseña.
                </strong>
            </div>
            <form wire:submit.prevent="ingresar" class="row g-3" autocomplete="off" novalidate>
                <div class="col-md-12">
                    <label class="form-label" for="dni">
                        Dni <span class="text-danger">*</span>
                    </label>
                    <input type="text" wire:model.live="dni" id="dni"
                        class="form-control @error('dni') is-invalid @enderror" placeholder="00000000"
                        autocomplete="off">
                    @error('dni')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="contraseña">
                        Contraseña <span class="text-danger">*</span>
                    </label>
                    <div class="input-group input-group-flat" x-data="{ modo_password: 'password' }">
                        <input x-bind:type="modo_password"
                            class="form-control @error('contraseña') is-invalid @enderror"
                            wire:model.live="contraseña" placeholder="********" autocomplete="off">
                        <span class="input-group-text @error('contraseña') border border-danger @enderror">
                            <a style="cursor: pointer;" class="link-secondary"
                                x-on:click="modo_password == 'password' ? modo_password = 'text' : modo_password = 'password'">
                                <svg x-show="modo_password == 'text'" xmlns="http://www.w3.org/2000/svg"
                                    class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path
                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                </svg>
                                <svg x-show="modo_password == 'password'" xmlns="http://www.w3.org/2000/svg"
                                    class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                    <path
                                        d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                    <path d="M3 3l18 18" />
                                </svg>
                            </a>
                        </span>
                    </div>
                    @error('contraseña')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-teal w-100">
                        Ingresar
                    </button>
                </div>
            </form>
            <div class="text-center text-muted mt-3">
                ¿No tienes una cuenta?
            </div>
            <div class="mt-2">
                <button type="button" wire:click="registro" class="btn btn-indigo w-100">
                    Registrate
                </button>
            </div>
            <div class="hr-text">x</div>
            <div class=" mt-3">
                <a href="{{ asset('static/manuales/manual-usuario-postulante.pdf') }}" target="_blank"
                    class="card card-link card-link-pop">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-muted" width="28" height="28"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                <path d="M17 18h2" />
                                <path d="M20 15h-3v6" />
                                <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                            </svg>
                            <span class="fs-3 text-muted">
                                Descargar Manual de Usuario
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
        <div class="bg-cover h-100 min-vh-100" style="background-image: url({{ asset('static/fondo-login.webp') }})">
        </div>
    </div>
    <div class="modal" id="modal-opciones" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-info"></div>
                <div class="modal-body text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-3 text-info icon-lg" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                        <path d="M19 22v.01" />
                        <path d="M19 19a2.003 2.003 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
                    </svg>
                    <div class="mb-3">
                        Usted ya cuenta con un registro en el sistema, si continua se redireccionará al modulo para realizar su matrícula final.
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <button type="button" class="btn btn-info" wire:click="continuar">
                            Continuar
                        </button>
                        <button type="button" class="btn" data-bs-dismiss="modal">
                            Salir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
