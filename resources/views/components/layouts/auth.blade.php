<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Cepre Unia' }}</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/demo.min.css?1684106062') }}" rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
    <!-- Tabler Core -->
    <script src="{{ asset('dist/js/tabler.min.js?1684106062') }}" defer data-navigate-track></script>
    <script src="{{ asset('dist/js/demo.min.js?1684106062') }}" defer data-navigate-track></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" data-navigate-track></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js" data-navigate-track></script>
</head>

<body class="d-flex flex-column bg-white">
    <script src="{{ asset('dist/js/demo-theme.min.js?1684106062') }}" data-navigate-track></script>

    {{ $slot }}

    <script data-navigate-track>
        document.addEventListener('livewire:navigated', () => {
            window.addEventListener('toast-basico', event => {
                let color = event.detail.color
                color == 'danger' ? (color = '#d63939') : color;
                color == 'success' ? (color = '#0ca678') : color;
                color == 'warning' ? (color = '#f59f00') : color;
                color == 'info' ? (color = '#4299e1') : color;
                color == 'question' ? (color = '#0054a6') : color;
                Toastify({
                    text: event.detail.text,
                    duration: 5000,
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "center", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: color,
                    }
                }).showToast();
            })
            window.addEventListener('modal', event => {
                $(event.detail.modal).modal(event.detail.action)
            })
        })
    </script>

</body>

</html>
