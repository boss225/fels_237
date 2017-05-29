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

    <p>{{ trans('settings.app.login.text') }} <a href="{{ action('Auth\RegisterController@showRegistrationForm') }}">{{ trans('settings.title.register') }}</a></p>
@endsection
