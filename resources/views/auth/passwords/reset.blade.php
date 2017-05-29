@extends('layouts.app')

@section('title')
    {{ trans('settings.title.reset_password') }}
@endsection

@section('content')
    <p>{{ trans('settings.app.reset.title') }}</p>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ Form::open([
        'method' => 'POST',
        'class' => 'form-horizontal',
        'action' => 'Auth\ResetPasswordController@reset',
        'role' => 'form',
    ]) }}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">	    
	    {{ Form::email('email', $email or old('email'), [
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
                'placeholder' => 'New Password',
                'required',
            ]) }}

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	    {{ Form::password('password_confirmation', [
                'class' => 'form-control',
                'id' => 'password-confirm',
                'placeholder' => "Confirm New Password",
                'required',
            ]) }}

            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>

	{{ Form::submit(trans('settings.app.reset.btn_submit'), ['class' => 'btn btn-primary btn-block']) }}
    {{ Form::close() }}

    <p>{{ trans('settings.app.reset.text') }} <a href="{{ action('Auth\LoginController@showLoginForm') }}">{{ trans('settings.title.login') }}</a></p>
@endsection
