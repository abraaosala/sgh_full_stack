<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>{{ $title ?? 'SGH' }} {{ $sistem ?? '' }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="author" content="{{ $dev ?? '' }}">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('img/logoM.png') }}" type="image/x-icon">
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- [Generic CSS] -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">

    <!-- [Bootstrap] -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- [Icons] -->
    <link href="{{ asset('fonts/tabler-icons.min.css', true) }}" rel="stylesheet">
    <link href="{{ asset('fonts/feather.css', true) }}" rel="stylesheet">
    <link href="{{ asset('fonts/fontawesome.css', true) }}" rel="stylesheet">

    <!-- [Plugins] -->
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('css/style.css', true) }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('css/style-preset.css', true) }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">

    @include('layouts.partials.sidebar')

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            @yield('content')

        </div>
    </div>
    <!-- [ Main Content ] end -->

    @include('layouts.partials.footer')

    <!-- [Scripts] -->
    @if (isset($dashboard) && $dashboard)
        <script src="{{ asset('js/plugins/apexcharts.min.js', true) }}"></script>
        <script src="{{ asset('js/pages/dashboard-default.js', true) }}"></script>
    @endif
    <script src="{{ asset('js/plugins/popper.min.js', true) }}"></script>
    <script src="{{ asset('js/plugins/simplebar.min.js', true) }}"></script>
    <script src="{{ asset('js/plugins/sweetalert2.all.min.js', true) }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('js/pcoded.js', true) }}"></script>
    <script src="{{ asset('js/plugins/feather.min.js', true) }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script>
        layout_change('light');
    </script>
    <script>
        change_box_container('false');
    </script>
    <script>
        layout_rtl_change('false');
    </script>
    <script>
        preset_change("preset-1");
    </script>
    <script>
        font_change("Public-Sans");
    </script>

</body>

</html>