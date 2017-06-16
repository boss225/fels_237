@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.manage_category') }}
@endsection

@section('content')
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('settings.title.manage_category') }}</h3>
            <div class="panel-actions">
                <button class="btn btn-primary" id="addCategory" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('settings.layout.admin.btn_add') }}
                </button>
            </div>
        </div>
        <table class="table table-hover" id="dataTable">
            <thead>
                <tr class="table-info">
                    <th></th>
                    <th>{{ trans('settings.layout.admin.title_category') }}</th>
                    <th>{{ trans('settings.layout.admin.question_number_category') }}</th>
                    <th>{{ trans('settings.layout.admin.number_word_category') }}</th>
                    <th>{{ trans('settings.layout.admin.created_category') }}</th>
                    <th>{{ trans('settings.layout.admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->test->question_number }}</td>
                    <td>{{ $item->words_count }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <button class="btn btn-success btn-sm ourItem" data-toggle="modal" data-target="#myModal" 
                            data-id="{{ $item->id }}" 
                            data-title="{{ $item->title }}"
                            data-number="{{ $item->test->question_number }}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" id="deleteCategory"
                            data-id="{{ $item->id }}"
                            data-msg="{{ trans('settings.confirm_message') }}"
                            data-url="{{ action('Admin\CategoryController@destroy', $item->id) }}">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade modal-category" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title" id="title">{{ trans('settings.title.manage_category') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::text('title', old('title'), [
                            'class' => 'form-control',
                            'id' => 'title_modal',
                            'placeholder' => "Title",
                            'required',
                        ]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::number('question_number', old('question_number'), [
                            'class' => 'form-control',
                            'id' => 'question_number',
                            'placeholder' => "Question Number",
                            'required',
                        ]) }}
                    </div>
                </div>
                <input type="hidden" id="idCategory">
                
                <div class="modal-footer">
                    <button class="btn btn-primary" id="addNew" data-dismiss="modal" data-url="{{ action('Admin\CategoryController@store') }}">
                        {{ trans('settings.layout.admin.btn_addNew') }}
                    </button>
                    <button class="btn btn-primary" id="saveChange" data-dismiss="modal" data-url="{{ action('Admin\CategoryController@index') }}">
                        {{ trans('settings.layout.admin.btn_saveChange') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{ csrf_field() }}
@endsection

