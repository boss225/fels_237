@extends('layouts.layout')

@section('title')
    {{ trans('settings.layout.following') }}
@endsection

@section('content')
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading text-xs-center">
            <h3 class="panel-title">{{ trans('settings.layout.following') }}</h3>
        </div>
        <div class="panel-body">                
        @forelse ($followings as $following)
            <div class="media m-b-25">
                <div class="media-left media-img">
                    <img src="{{ $following->avatar }}">
                </div>
                <div class="media-body">
                    <strong>{{ $following->name }} {{ $following->location ? '- ' . $following->location : null }}</strong></br>
                    <small>{{ $following->email }}</small>
                </div>
                <div class="media-right"> 
                    <button class="btn btn-success" id="userFollow"
                        data-id="{{ $following->id }}" 
                        data-title="{{ trans('settings.layout.btn_follow') }}" 
                        data-url="{{ action('User\UserController@addRelationship') }}">
                        {{ trans('settings.layout.btn_unFollow') }}
                    </button>                       
                </div>
            </div>
        @empty
            <li class="list-group-item">{{ trans('settings.empty_message') }}</li>
        @endforelse
        </div>
        {{ $followings->links() }}
    </div>
@endsection

