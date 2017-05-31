<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.5/css/bootstrap.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}
    {{ Html::style('css/styles.css') }}

</head>
<body class="page-login layout-full page-dark">
    <div class="page vertical-align text-xs-center">
        <div class="page-content vertical-align-middle">
            <div class="brand">
                <img src="/uploads/page/logo.png" alt="e-learning">
                <h2 class="brand-text">{{ trans('settings.app.brand_text') }}</h2>
            </div>
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.5/js/bootstrap.min.js') }}
    {{ Html::script('js/app.js') }}
</body>
</html>
