@extends('layouts.app')

@section('title')
    {{ trans('settings.title.login') }}
@endsection

@section('content')
    <p>{{ trans('settings.app.login.title') }}</p>
    {{ Form::open([
        'method' => 'POST',
        'class' => 'form-horizontal',
        'action' => 'Auth\LoginController@login',
        'role' => 'form',
    ]) }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {{ Form::email('email', old('email'), [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'Email',
                'required',
                'autofocus'
            ]) }}
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {{ Form::password('password', [
                'class' => 'form-control',
                'id' => 'password',
                'placeholder' => 'Password',
                'required',
            ]) }}
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <div class="checkbox-custom checkbox-inline checkbox-primary pull-xs-left">
                {{ Form::checkbox('remember', null) }}
                <label for="inputCheckbox">{{ trans('settings.app.login.remember_me') }}</label>
            </div>
            <a class="pull-xs-right" href="{{ action('Auth\ForgotPasswordController@showLinkRequestForm') }}">
                {{ trans('settings.app.login.btn_forgotPass') }}
            </a>
        </div>
        {{ Form::submit(trans('settings.app.login.btn_login'), ['class' => 'btn btn-primary btn-block']) }}
    {{ Form::close() }}

     <div class="login-social">
        <div class="btn-group">
            <a href="{{ action('Auth\SocialAuthController@redirectToProvider', 'facebook') }}" class="btn btn-primary social-facebook">
                <i class="fa fa-facebook m-r-5"></i> {{ trans('settings.social.facebook') }}
            </a>
            <a href="{{ action('Auth\SocialAuthController@redirectToProvider', 'google') }}" class="btn btn-danger social-google">
                <i class="fa fa-google m-r-5"></i> {{ trans('settings.social.google') }}
            </a>
            <a href="{{ action('Auth\SocialAuthController@redirectToProvider', 'twitter') }}" class="btn btn-info social-twitter">
                <i class="fa fa-twitter m-r-5"></i> {{ trans('settings.social.twitter') }}
            </a>
        </div>
    </div>

    <p>{{ trans('settings.app.login.text') }} <a href="{{ action('Auth\RegisterController@showRegistrationForm') }}">{{ trans('settings.title.register') }}</a></p>
@endsection
