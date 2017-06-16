@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.manage_word') }}
@endsection

@section('content')
    @if (!empty(session('status')))
        <div class="alert alert-{{ session('status') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('message') }}
        </div>
    @endif
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('settings.title.manage_word') }}</h3>
            <div class="panel-actions">
                <a class="btn btn-primary" id="addWord" href="{{ action('Admin\WordController@create') }}">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('settings.layout.admin.btn_add') }}
                </a>
            </div>
        </div>
        <table class="table table-hover" id="dataTable">
            <thead>
                <tr class="table-info">
                    <th></th>
                    <th>{{ trans('settings.layout.admin.category') }}</th>
                    <th>{{ trans('settings.layout.admin.word') }}</th>
                    <th>{{ trans('settings.layout.admin.answer') }}</th>
                    <th>{{ trans('settings.layout.admin.create_at') }}</th>
                    <th>{{ trans('settings.layout.admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->category->title }}</td>
                    <td>{{ $item->word }}</td>
                    <td>{{ $item->answer }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a class="btn btn-success btn-sm wordItem" href="{{ action('Admin\WordController@edit', $item->id) }}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <button class="btn btn-danger btn-sm" id="deleteWord"
                            data-id="{{ $item->id }}"
                            data-msg="{{ trans('settings.confirm_message') }}"
                            data-url="{{ action('Admin\WordController@destroy', $item->id) }}">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">{{ trans('settings.empty_message') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

