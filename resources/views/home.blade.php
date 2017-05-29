@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.homepage') }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('settings.layout.homePage.head') }}</div>

                <div class="panel-body">
                    {{ trans('settings.layout.homePage.body') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
