@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.profile') }}
@endsection

@section('content')       
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading text-xs-center">
            <h3 class="panel-title">{{ trans('settings.layout.user.profile') }}</h3>
        </div>
        <div class="panel-body">
            {{ Form::open([
                'class' => 'form-horizontal',
                'role' => 'form',
                'method' => 'PATCH',
                'action' => ['User\UserController@update', auth()->id()],
                'enctype' => 'multipart/form-data',
            ]) }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label>{{ trans('settings.layout.user.profile_name') }}</label>
                    {{ Form::text('name', Auth::user()->name, [
                        'class' => 'form-control',
                        'id' => 'name',
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
                    <label>{{ trans('settings.layout.user.profile_email') }}</label>
                    {{ Form::email('email', Auth::user()->email, [
                        'class' => 'form-control',
                        'id' => 'email',
                        'required',
                    ]) }}

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                    <label>{{ trans('settings.layout.user.profile_location') }}</label>
                    {{ Form::text('location', Auth::user()->location, [
                        'class' => 'form-control',
                        'id' => 'location',
                        'required',
                    ]) }}

                    @if ($errors->has('location'))
                        <span class="help-block">
                            <strong>{{ $errors->first('location') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                    <label>{{ trans('settings.layout.user.profile_note') }}</label>
                    {{ Form::textarea('note', Auth::user()->note, [
                        'class' => 'form-control',
                        'id' => 'note',
                        'rows' => '3',
                        'required',
                    ]) }}

                    @if ($errors->has('note'))
                        <span class="help-block">
                            <strong>{{ $errors->first('note') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>{{ trans('settings.layout.user.profile_password') }}</label>
                    {{ Form::password('password', [
                        'class' => 'form-control',
                        'id' => 'password-new',
                    ]) }}

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>{{ trans('settings.layout.user.profile_passConfirm') }}</label>
                    {{ Form::password('password_confirmation', [
                        'class' => 'form-control',
                        'id' => 'password-new-confirm',
                    ]) }}                
                </div>
                <div class="form-group">
                    <label>{{ trans('settings.layout.user.profile_avatar') }}</label>
                    {{ Form::file('avatar', [
                        'class' => 'form-control-file',
                        'id' => 'avatar',
                    ]) }}
                </div>
                <div class="form-group">
                    <label>{{ trans('settings.layout.user.profile_cover') }}</label>
                    {{ Form::file('cover', [
                        'class' => 'form-control-file',
                        'id' => 'cover',
                    ]) }}
                </div>
                <hr>
                {{ Form::submit(trans('settings.layout.user.btn_save'), [
                    'class' => 'btn btn-primary',
                    'id' => 'update-profile',
                ]) }}
            {{ Form::close() }}
        </div>
    </div>
@endsection
