@extends('layouts.app')

@section('title')
    {{ trans('settings.title.register') }}
@endsection

@section('content')
    <p>{{ trans('settings.app.register.title') }}</p>
    {{ Form::open([
        'class' => 'form-horizontal',
        'role' => 'form',
        'method' => 'POST',
        'action' => 'Auth\RegisterController@register',
        'enctype' => 'multipart/form-data',
    ]) }}
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {{ Form::text('name', old('name'), [
                'class' => 'form-control',
                'id' => 'name',
                'placeholder' => "Name",
                'required',
                'autofocus'
            ]) }}
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {{ Form::email('email', old('email'), [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => "Email",
                'required',
            ]) }}
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
            {{ Form::text('location', old('location'), [
                'class' => 'form-control',
                'id' => 'location',
                'placeholder' => "Location",
                'required'
            ]) }}
            @if ($errors->has('location'))
                <span class="help-block">
                    <strong>{{ $errors->first('location') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {{ Form::password('password', [
                'class' => 'form-control',
                'id' => 'password',
                'placeholder' => "Password",
                'required',
            ]) }}
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            {{ Form::password('password_confirmation', [
                'class' => 'form-control',
                'id' => 'password-confirm',
                'placeholder' => "Confirm Password",
                'required',
            ]) }}
        </div>
        {{ Form::submit(trans('settings.app.register.btn_register'), ['class' => 'btn btn-primary btn-block']) }}
    {{ Form::close() }}

    <p>{{ trans('settings.app.register.text') }} <a href="{{ action('Auth\LoginController@showLoginForm') }}">{{ trans('settings.title.login') }}</a></p>
@endsection
