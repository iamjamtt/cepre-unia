<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Declaración Jurada</title>
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
            DECLARACIÓN JURADA
        </div>
        <div class="text-center text-xl fw-extrabold text-zinc-700">
            CEPRE UNIA {{ HelperUnia::getNombreCiclo() }}
        </div>
        <div class="mt-5">
            <div class="text-zinc-700 mt-3 text-lg" style="line-height: 25px;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yo, <b>{{$persona->apePaterno}} {{$persona->apeMaterno}} {{$persona->nombres}}</b>,  identificado con DNI Nº <b>{{$persona->dni}}</b> domiciliado en {{$persona->direccion}} en el Distrito de .............................,  de la  Provincia de ................................, del  Departamento de ................................, alumno de la CEPRE UNIA {{ $inscripcion->ciclo->nombre }}.<br>
                Que, los documentos presentados ante el CENTRO PREUNIERSITARIO de la UNIA son auténticos, los mismos que a continuación se detallan:
                <ol>
                    <li>Certificado de estudios visado por la UGEL respectiva (&nbsp;&nbsp; )</li>
                    <li>Partida de nacimiento original (&nbsp;&nbsp;)</li>
                    <li>Copia de dni legalizada (&nbsp;&nbsp;)</li>
                    <li>1 (una) foto tamaño jumbo (&nbsp;&nbsp;)</li>
                    <li>Constancia de la comunidad de origen (&nbsp;&nbsp;)</li>
                </ol>
                <p>
                    Me reafirmo y me ratifico en lo expresado, en señal de lo cual firmo el presente documento.
                </p>
            </div>
            <div class="text-lg text-right mt-10 fw-bold text-zinc-700">
                Yarinacocha, {{ HelperUnia::convertirFechaTexto($inscripcion->created_at) }}.
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
