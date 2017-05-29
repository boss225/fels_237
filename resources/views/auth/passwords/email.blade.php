@extends('layouts.app')

@section('title')
    {{ trans('settings.title.reset_password') }}
@endsection

@section('content')
    <p>{{ trans('settings.app.email.title') }}</p>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ Form::open([
        'method' => 'POST',
        'class' => 'form-horizontal',
        'action' => 'Auth\ForgotPasswordController@sendResetLinkEmail',
        'role' => 'form',
    ]) }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	    {{ Form::email('email', old('email'), [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'Email',
                'required'
            ]) }}

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

	{{ Form::submit(trans('settings.app.email.btn_send'), ['class' => 'btn btn-primary btn-block']) }}
    {{ Form::close() }}

    <p>{{ trans('settings.app.email.text') }} <a href="{{ action('Auth\LoginController@showLoginForm') }}">{{ trans('settings.title.login') }}</a></p>
@endsection
