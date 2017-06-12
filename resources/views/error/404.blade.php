<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('settings.title.error404') }}</title>

    <!-- Styles -->
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.5/css/bootstrap.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}
    {{ Html::style('css/styles.css') }}

</head>
<body class="animsition page-error page-error-404 layout-full">
    <div class="page vertical-align text-xs-center">
        <div class="page-content vertical-align-middle">
        <header>
            <h1>{{ trans('settings.title.error404') }}</h1>
            <p>{{ trans('settings.error.not_found') }}</p>
        </header>
        <p class="error-advise">{{ trans('settings.error.text') }}</p>
        <a class="btn btn-primary btn-round" href="/">{{ trans('settings.error.go_home') }}</a>
        </div>
    </div>

    <!-- Scripts -->
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.5/js/bootstrap.min.js') }}
    {{ Html::script('js/app.js') }}
</body>
</html>
