<!doctype html>
<html
    lang=""{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ (Session::get('layout')=='rtl' ? 'rtl' : 'ltr') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{$description}}"/>
    <title>{{env('APP_NAME')}} | {{$title}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset( 'assets/css/plugin' . Helper::rlt_ext() . '.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style' . Helper::rlt_ext() . '.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/variables' . Helper::rlt_ext() . '.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app' . Helper::rlt_ext() . '.min.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
</head>
<body class="layout-light side-menu">
<div class="mobile-author-actions"></div>
<main class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="min-vh-100 content-center">
                    <div class="error-page text-center">
                        <img src="{{ asset('assets/img/svg/404.svg') }}" alt="404" class="svg">
                        <div class="error-page__title">404</div>
                        <h5 class="fw-500">Sorry! the page you are looking for doesn't exist.</h5>
                        <div class="content-center mt-30">
                            <a href="/dashboard" class="btn btn-primary btn-default btn-squared px-30">Return
                                Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer-wrapper">
        @include('partials._footer')
    </footer>
</main>
<div id="overlayer">
        <span class="loader-overlay">
            <div class="dm-spin-dots spin-lg">
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
            </div>
        </span>
</div>
<div class="overlay-dark-sidebar"></div>
<div class="customizer-overlay"></div>
<div class="customizer-wrapper">
    @include('partials._customizer')
</div>

<script>
    var env = {
        iconLoaderUrl: "{{ asset('assets/js/json/icons.json') }}",
        googleMarkerUrl: "{{ asset('assets/img/markar-icon.png') }}",
        editorIconUrl: "{{ asset('assets/img/ui/icons.svg') }}",
        mapClockIcon: "{{ asset('assets/img/svg/clock-ticket1.sv') }}g"
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDduF2tLXicDEPDMAtC6-NLOekX0A5vlnY"></script>
<script src="{{ asset('assets/js/plugins.min.js') }}"></script>
<script src="{{ asset('assets/js/script.min.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
</body>
</html>
