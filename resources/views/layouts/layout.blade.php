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
    {{ Html::style('https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css') }}
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
                    <li class="nav-item {{ setActive(action('User\WordController@showList')) }}">
                        <a href="{{ action('User\WordController@showList') }}" class="nav-link">{{ trans('settings.layout.btn_word') }}</a>
                    </li>
                    <li class="nav-item {{ setActive(action('User\LessonController@index')) }}">
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
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
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
    <div class="profile card card-shadow text-xs-center">
        <div class="card-header card-header-transparent cover overlay">
            <img class="cover-image" src="{{ Auth::user()->cover }}" >
            <div class="overlay-panel vertical-align">
                <div class="vertical-align-middle">
                    <div class="avatar avatar-100 bg-white m-b-10 m-xs-0 img-bordered">
                        <img src="{{ Auth::user()->avatar }}" >
                    </div>
                    <div class="font-size-20 userName">{{ Auth::user()->name }}</div>
                    <div class="font-size-20">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="counter">
                                    <div class="counter-label">{{ trans('settings.layout.followers') }}</div>
                                    <span class="counter-number">{{ $followers }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="counter">
                                    <div class="counter-label">{{ trans('settings.layout.following') }}</div>
                                    <span class="counter-number following">{{ $followings }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="counter">
                                    <div class="counter-label">{{ trans('settings.layout.word_memorised') }}</div>
                                    <span class="counter-number">{{ $memoriedWord }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <nav class="navbar navbar-inverse bg-blue-grey-700" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggler hamburger hamburger-close collapsed" data-target="#example-navbar-search-overlap-collapse" data-toggle="collapse">
                        <span class="sr-only"></span>
                        <span class="hamburger-bar"></span>
                    </button>
                    <button type="button" class="navbar-toggler collapsed" data-target="#example-navbar-search-overlap" data-toggle="collapse">
                        <span class="sr-only"></span>
                        <i class="icon wb-search" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="example-navbar-search-overlap-collapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item {{ setActive(action('HomeController@index')) }}">
                            <a class="nav-link" href="/">{{ trans('settings.layout.btn_activity') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" aria-expanded="false" data-animation="slide-bottom" role="button">
                            {{ trans('settings.layout.btn_category') }} <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </a>
                            <ul class="dropdown-menu" role="menu">
                            @foreach ($categories as $category)
                                <li><a href="{{ action('User\WordController@wordsCategory', $category->id) }}" class="dropdown-item">{{ $category->title }}</a></li>
                            @endforeach
                            </ul>
                        </li>
                        <li class="nav-item {{ setActive(action('User\UserController@followers')) }}">
                            <a class="nav-link" href="{{ action('User\UserController@followers') }}">{{ trans('settings.layout.followers') }}</a>
                        </li>
                        <li class="nav-item {{ setActive(action('User\UserController@following')) }}">
                            <a class="nav-link" href="{{ action('User\UserController@following') }}">{{ trans('settings.layout.following') }}</a>
                        </li>
                        @if (Auth::user()->role == config('settings.role_admin'))
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" aria-expanded="false" data-animation="slide-bottom" role="button">
                                {{ trans('settings.layout.admin_manage') }} <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ action('Admin\AccountController@index') }}" class="dropdown-item">{{ trans('settings.layout.manage_account') }}</a></li>
                                <li><a href="{{ action('Admin\CategoryController@index') }}" class="dropdown-item">{{ trans('settings.layout.manage_category') }}</a></li>
                                <li><a href="{{ action('Admin\WordController@index') }}" class="dropdown-item">{{ trans('settings.layout.manage_word') }}</a></li>
                                <li><a href="{{ action('Admin\LessonController@index') }}" class="dropdown-item">{{ trans('settings.layout.manage_lesson') }}</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        @yield('content')
    </div>

    <!-- Scripts -->
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.5/js/bootstrap.min.js') }}
    {{ Html::script('http://bootstrap-notify.remabledesigns.com/js/bootstrap-notify.min.js') }}
    {{ Html::script('https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js') }}
    {{ Html::script('js/script.js') }}
</body>
</html>

