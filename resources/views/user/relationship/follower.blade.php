@extends('layouts.layout')

@section('title')
    {{ trans('settings.layout.followers') }}
@endsection

@section('content')
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading text-xs-center">
            <h3 class="panel-title">{{ trans('settings.layout.followers') }}</h3>
        </div>
        <div class="panel-body">              
        @forelse ($followers as $follower)
            <div class="media m-b-25">
                <div class="media-left media-img">
                    <img src="{{ $follower->avatar }}">
                </div>
                <div class="media-body">
                    <strong> {{ $follower->name }} {{ $follower->location ? '- ' . $follower->location : null }} </strong></br>
                    <small>{{ $follower->email }}</small>
                </div>
                <div class="media-right">
                
                </div>
            </div>
        @empty
            <li class="list-group-item">{{ trans('settings.empty_message') }}</li>
        @endforelse
        </div>
        {{ $followers->links() }}
    </div>
@endsection

