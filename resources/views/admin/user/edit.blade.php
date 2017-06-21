@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.manage_edit_account') }}
@endsection

@section('content')    
    @if (!empty(session('status')))
        <div class="alert alert-{{ session('status') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('message') }}
        </div>
    @endif   
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading text-xs-center">
            <h3 class="panel-title">{{ trans('settings.title.manage_edit_account') }}</h3>
        </div>
        <div class="panel-body">
            {{ Form::open([
                'class' => 'form-horizontal',
                'role' => 'form',
                'method' => 'PATCH',
                'action' => ['Admin\AccountController@update', $user->id],
                'enctype' => 'multipart/form-data',
            ]) }}
                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                    {{ Form::select('role', [
                        '0' => 'Admin', 
                        '1' => 'Member'
                        ], $user->role, [
                        'class' => 'form-control',
                        'id' => 'role',
                        'required',
                    ]) }}

                    @if ($errors->has('role'))
                        <span class="help-block">
                            <strong>{{ $errors->first('role') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {{ Form::text('name', $user->name, [
                        'class' => 'form-control',
                        'id' => 'name',
                        'placeholder' => "User Name",
                        'required',
                    ]) }}

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                    {{ Form::text('location', $user->location, [
                        'class' => 'form-control',
                        'id' => 'location',
                        'placeholder' => "Location",
                        'required',
                    ]) }}

                    @if ($errors->has('location'))
                        <span class="help-block">
                            <strong>{{ $errors->first('location') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                    {{ Form::textarea('note', $user->note, [
                        'class' => 'form-control',
                        'id' => 'note',
                        'rows' => '3',
                        'placeholder' => "Note",
                        'required',
                    ]) }}

                    @if ($errors->has('note'))
                        <span class="help-block">
                            <strong>{{ $errors->first('note') }}</strong>
                        </span>
                    @endif
                </div>
                <hr>

                {{ Form::submit(trans('settings.layout.admin.btn_saveChange'), [
                    'class' => 'btn btn-primary',
                    'id' => 'saveUpdate',
                ]) }}
            {{ Form::close() }}
        </div>
    </div>
@endsection
