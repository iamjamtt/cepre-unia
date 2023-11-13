<div class="row g-0 flex-fill">
    <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-teal d-flex flex-column justify-content-center animate__animated animate__fadeIn animate__faster">
        <div class="container container-tight my-5 px-lg-5">
            <div class="text-center mb-5">
                <img src="{{ asset('static/portada.webp') }}" alt="portada">
            </div>
            <h2 class="fs-2 text-center mb-5">
                Ingresa a tu cuenta
            </h2>
            <p class="text-muted text-center mb-5">
                Los postulantes podrán acceder al sistema cuando ya hayan creado su cuenta, podrán verificar el estado
                de su inscripción.
            </p>
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
                    <input type="password" wire:model.live="contraseña"
                        id="contraseña" class="form-control @error('contraseña') is-invalid @enderror"
                        placeholder="********">
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
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
        <!-- Photo -->
        <div class="bg-cover h-100 min-vh-100" style="background-image: url({{ asset('static/fondo-login.webp') }})">
        </div>
    </div>
</div>
