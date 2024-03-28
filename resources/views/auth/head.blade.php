<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon.png') }}">
</head>
<body>

<main class="main-content">
    <div class="admin" style="background-image:url({{ asset('assets/img/admin-bg-light.png') }}); height:100vh">
        <div class="container-fluid">
            <div class="row justify-content-center h-100vh align-items-center">
                <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-8">
                    <div class="edit-profile my-auto">
                        <div class="edit-profile__logos">
{{--                            <img class="dark" src="{{ asset('assets//img/canopy.png') }}" alt="">--}}
{{--                            <img class="light" src="{{ asset('assets/img/canopy.png') }}" alt="">--}}
                        </div>

                        @yield('content')

                        @include('partials.script')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
