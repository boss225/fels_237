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
<body>
    <nav class="navbar navbar-default navbar-inverse nav-bg-gk navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggler collapsed" data-target="#example-navbar-toolbar-1" data-toggle="collapse">
                    <span class="sr-only"></span>
                    <i class="fa fa-navicon" aria-hidden="true"></i>
                </button>
                <button type="button" class="navbar-toggler collapsed" data-target="#example-navbar-search-1" data-toggle="collapse">
                    <span class="sr-only"></span>
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
                <a class="navbar-brand" href="/">
                    <img class="brand-img" src="/uploads/page/logo.png" >
                </a>
            </div>
            <div class="collapse navbar-search navbar-left">
                {{ Form::open([
                    'action' => 'User\UserController@searchUser',
                    'class' => 'navbar-form form-inline quick-search',
                    'role' => 'form',
                ]) }}
                    <div class="input-group">
                        {{ Form::text('search', old('search'), [
                            'class' => 'form-control',
                            'id' => 'search',
                            'placeholder' => "Search user or email",
                        ]) }}
                        <div class="input-group-addon">
                            {{ Form::button('<span class="fa fa-2x fa-angle-double-right"></span>', [
                                'type' => 'submit', 
                                'class' => 'btn',
                            ]) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
            <div class="collapse navbar-collapse navbar-collapse-toolbar" id="example-navbar-toolbar-1">
                <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                    <li class="nav-item">
                        <a href="{{ action('User\WordController@showList') }}" class="nav-link">{{ trans('settings.layout.btn_word') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ action('User\LessonController@index') }}" class="nav-link">{{ trans('settings.layout.btn_lesson') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link navbar-avatar dropdown-toggle" data-toggle="dropdown" aria-expanded="true" role="button">
                            <span class="avatar avatar-online">
                                <img src="{{ Auth::user()->avatar }}" >
                            </span>
                            <span class="fullName">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ action('User\UserController@edit', auth()->id()) }}" class="dropdown-item">
                                    <i class="fa fa-user"></i> {{ trans('settings.layout.profile') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('Auth\LoginController@logout') }}" class="dropdown-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                   <i class="fa fa-lock"></i> {{ trans('settings.title.logout') }}
                                </a>
                                {{ Form::open([
                                    'id' => 'logout-form',
                                    'action' => 'Auth\LoginController@logout',
                                    'method' => 'POST',
                                    'style' => 'display:none',
                                ]) }}
                                {{ Form::close() }}
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </br>
    <div class="container">
        @yield('content')
    </div>

    <!-- Scripts -->
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.5/js/bootstrap.min.js') }}
    {{ Html::script('js/script.js') }}
</body>
</html>

