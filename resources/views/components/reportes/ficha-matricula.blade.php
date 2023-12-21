<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ficha de Matrícula</title>
    <link rel="stylesheet" href="{{ public_path('dist/pdf/pdf.css') }}" />
    <style>
        @font-face {
            font-family: 'Inter';
            src: url({{ public_path('fonts/Inter-Regular.ttf') }}) format('truetype');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'Inter';
            src: url({{ public_path('fonts/Inter-Bold.ttf') }}) format('truetype');
        font-weight: 700;
        font-style: normal;
        }

        @font-face {
            font-family: 'Inter';
            src: url({{ public_path('fonts/Inter-ExtraBold.ttf') }}) format('truetype');
            font-weight: 800;
            font-style: normal;
        }

        @page {
            margin: 0rem;
            font-family: "Inter", sans-serif;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('static/portada.webp') }}" style="width: 100%" alt="portada">
    </header>

    <main class="mt-3">
        <div class="text-center text-2xl fw-extrabold text-zinc-700">
            FICHA DE MATRÍCULA
        </div>
        <div class="text-center text-xl fw-extrabold text-zinc-700">
            CEPRE UNIA {{ HelperUnia::getNombreCiclo() }}
        </div>
        <div class="mt-5">
            <table class="w-full table mt-3">
                <tr class="text-xs bg-indigo-50 fw-regular text-indigo-900">
                    <th class="text-left py-1 px-2" colspan="4" style="border: 1px solid; border-color: #71717a">
                        Datos Personales
                    </th>
                    <th class="text-center py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Fotografía
                    </th>
                </tr>
                <tr class="text-xs text-indigo-900">
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        DNI:
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Apellido Paterno:
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Apellido Materno:
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Nombres:
                    </th>
                    <th rowspan="6" style="border: 1px solid; border-color: #71717a">
                        <img src="{{ public_path(HelperUnia::existeArchivoFoto($inscripcion->ciclo_id, $persona->id)['ruta']) }}" alt="Foto del Alumno" style="width: 110px; height: 150px;">
                    </th>
                </tr>
                <tr class="text-xs">
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->dni }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->apePaterno }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->apeMaterno }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->nombres }}
                    </td>
                </tr>
                <tr class="text-xs text-indigo-900">
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Fecha Nac:
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Sexo:
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Celular:
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Cel. Apoderado:
                    </th>
                </tr>
                <tr class="text-xs">
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ HelperUnia::convertirFecha($persona->fechaNac) }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ HelperUnia::getSexo($persona->sexo) }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->celular }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->celularApoderado ?? '-' }}
                    </td>
                </tr>
                <tr class="text-xs text-indigo-900">
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Grupo Étnico:
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Lengua Materna:
                    </th>
                    <th colspan="2" class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Email:
                    </th>
                </tr>
                <tr class="text-xs">
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->grupo->nombre }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->language->nombre }}
                    </td>
                    @if (!empty($user->email))
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a" colspan="2">
                        {{ $user->email }}
                    </td>
                    @else
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a" colspan="2">
                        -
                    </td>
                    @endif
                </tr>
                <tr class="text-xs">
                    <th class="text-left py-1 px-2 text-indigo-900" style="border: 1px solid; border-color: #71717a">
                        Dirección:
                    </th>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a" colspan="4">
                        {{ $persona->direccion }}
                    </td>
                </tr>
            </table>

            <table class="w-full table mt-3">
                <tr class="text-xs bg-indigo-50 fw-regular text-indigo-900">
                    <th class="text-left py-1 px-2" colspan="4" style="border: 1px solid; border-color: #71717a">
                        Lugar de Nacimiento
                    </th>
                </tr>
                <tr class="text-xs text-indigo-900">
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Departamento:
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Provincia:
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Distrito:
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Comunidad:
                    </th>
                </tr>
                <tr class="text-xs">
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->distrito->provincia->departamento->nombre }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->distrito->provincia->nombre }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->distrito->nombre }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $persona->comunidad ?? '-' }}
                    </td>
                </tr>
            </table>

            <table class="w-full table mt-3">
                <tr class="text-xs bg-indigo-50 fw-regular text-indigo-900">
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Colegio de Procendencia
                    </th>
                </tr>
                <tr class="text-xs">
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $colegio->nombre }} ({{ $colegio->gestion == 1 ? 'ESTATAL' : 'PARTICULAR' }}) <br>
                        <strong>Distrito: </strong> {{ $colegio->distrito->nombre }} -
                        <strong>Provincia: </strong> {{ $colegio->distrito->provincia->nombre }} -
                        <strong>Departamento: </strong> {{ $colegio->distrito->provincia->departamento->nombre }} -
                        <strong>Año de egreso: </strong> {{ $persona->colegioFin }}
                    </td>
                </tr>
            </table>

            <table class="w-full table mt-3">
                <tr class="text-xs bg-indigo-50 fw-regular text-indigo-900">
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Ciclo
                    </th>
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Carrea Elegida
                    </th>
                </tr>
                <tr class="text-xs">
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $inscripcion->modalidad->nombre }} {{ $inscripcion->ciclo->nombre }}
                    </td>
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        {{ $inscripcion->carrera->nombre }}
                    </td>
                </tr>
            </table>

            <table class="w-full table mt-3">
                <tr class="text-xs bg-indigo-50 fw-regular text-indigo-900">
                    <th class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        Declaración Jurada
                    </th>
                </tr>
                <tr class="text-xs">
                    <td class="text-left py-1 px-2" style="border: 1px solid; border-color: #71717a">
                        <strong>Declaro bajo juramento que:</strong>
                        <ol>
                            <li>
                                <font style="vertical-align: inherit;">
                                    La información consignada al momento de matricularse es válida y de
                                    mi entera responsabilidad.
                                </font>
                            </li>
                            <li>
                                <font style="vertical-align: inherit;">
                                    Conozco y acepto todos los artículos del Reglamento del CEPRE UNIA,
                                    publicado en el página web de la Dirección del CEPRE UNIA, al cual
                                    me someto.
                                </font>
                            </li>
                            <li>
                                <font style="vertical-align: inherit;">
                                    En caso de obtener una vacante me comprometo a presentar los
                                    documentos originales de acuerdo a lo establecido en el Reglamento
                                    del CEPRE UNIA en las fechas programadas en el cronograma.
                                </font>
                            </li>
                            <li>
                                <font style="vertical-align: inherit;">
                                    No registrar antecedentes penales.
                                </font>
                            </li>
                        </ol>
                    </td>
                </tr>
            </table>

            <div class="text-xs text-right mt-5 fw-bold">
                Yarinacocha, {{ HelperUnia::convertirFechaTexto($inscripcion->updated_at) }}.
            </div>
        </div>
    </main>

    <footer class="text-center w-full">
        <div class="mt-3">
            <span class="text-xs">
                "Somos una universidad <strong>Licenciada</strong>, nuestra meta la <strong>Acreditación</strong>"
            </span>
        </div>
    </footer>
</body>

</html>
