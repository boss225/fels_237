@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.import_excel') }}
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
            <h3 class="panel-title">{{ trans('settings.title.import_excel') }}</h3>
        </div>
        <div class="panel-body">
            {{ Form::open([
                'class' => 'form-horizontal',
                'role' => 'form',
                'method' => 'post',
                'action' => 'Admin\ExcelController@postImport',
                'enctype' => 'multipart/form-data',
            ]) }}
                <div class="form-group">
                    {{ Form::file('file', [
                        'class' => 'form-control-file',
                        'id' => 'file',
                        'required',
                    ]) }}
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
