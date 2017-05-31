@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.homepage') }}
@endsection

@section('content')
    <div class="col-md-4 col-xs-6">
        <div class="panel panel-bordered panel-dark">
            <div class="panel-heading text-xs-center">
                <h3 class="panel-title">{{ Auth::user()->name }}</h3>
            </div>
            <ul class="list-group list-group-bordered">
                <li class="list-group-item">
                    <i class="fa fa-envelope m-r-5"></i> {{ trans('settings.layout.homePage.email') }} : {{ Auth::user()->email }}
                </li>
                <li class="list-group-item">
                    <i class="fa fa-map-marker m-r-5"></i> {{ trans('settings.layout.homePage.location') }} : {{ Auth::user()->location }}
                </li>
                <li class="list-group-item">
                    <i class="fa fa-file-text-o m-r-5"></i> {{ trans('settings.layout.homePage.note') }} : {{ Auth::user()->note }}
                </li>
            </ul>
        </div>
    </div>
@endsection
