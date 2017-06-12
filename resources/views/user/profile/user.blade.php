@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.search_user') }}
@endsection

@section('content')
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading text-xs-center">
            <h3 class="panel-title">{{ trans('settings.title.search_user') }}</h3>
        </div>
        <div class="panel-body">               
        @forelse ($users as $user)
            <div class="media m-b-25">
                <div class="media-left media-img">
                    <img src="{{ $user->avatar }}">
                </div>
                <div class="media-body">
                    <strong> {{ $user->name }} {{ $user->location ? '- ' . $user->location : null }} </strong></br>
                    <small>{{ $user->email }}</small>
                </div>
                <div class="media-right">
                @if ($user->relationships->count() == config('settings.lesson.default_result'))
                    <button class="btn btn-primary" id="userFollow"
                        data-id="{{ $user->id }}" 
                        data-title="{{ trans('settings.layout.btn_unFollow') }}" 
                        data-url="{{ action('User\UserController@addRelationship') }}">
                        {{ trans('settings.layout.btn_follow') }}
                    </button>
                @else  
                    <button class="btn btn-success" id="userFollow"
                        data-id="{{ $user->id }}" 
                        data-title="{{ trans('settings.layout.btn_follow') }}" 
                        data-url="{{ action('User\UserController@addRelationship') }}">
                        {{ trans('settings.layout.btn_unFollow') }}
                    </button>                      
                @endif
                </div>
            </div>
        @empty
            <li class="list-group-item">{{ trans('settings.empty_message') }}</li>
        @endforelse
        </div>
        {{ $users->links() }}
    </div>
@endsection

