@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.manage_account') }}
@endsection

@section('content')
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('settings.title.manage_account') }}</h3>
        </div>
        <table class="table table-hover">
            <thead>
                <tr class="table-info">
                    <th>{{ trans('settings.layout.admin.id_account') }}</th>
                    <th>{{ trans('settings.layout.admin.name_account') }}</th>
                    <th>{{ trans('settings.layout.admin.email_account') }}</th>
                    <th>{{ trans('settings.layout.admin.create_at') }}</th>
                    <th>{{ trans('settings.layout.admin.role_account') }}</th>
                    <th>{{ trans('settings.layout.admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->name }}</td>
                    <td>{{ $account->email }}</td>
                    <td>{{ $account->created_at }}</td>
                    <td>{{ $account->role == config('settings.role_admin') ? config('settings.role_name.admin') : config('settings.role_name.member') }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" id="deleteUser"
                            data-id="{{ $account->id }}"
                            data-msg="{{ trans('settings.confirm_message') }}"
                            data-url="{{ action('Admin\AccountController@destroy', $account->id) }}">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ csrf_field() }}
@endsection

