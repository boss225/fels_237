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
    <div class="col-md-8 col-xs-6">
        <div class="panel panel-bordered panel-dark">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans('settings.home.activity_title') }}</h3>
            </div>
            <ul class="list-group list-group-bordered overflow">      
            @forelse ($userActivities as $userActivity)
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <a class="avatar">
                                <img src="{{ Auth::user()->avatar }}" class="height-auto">
                            </a>
                        </div>
                        <div class="media-body">
                        @if ($userActivity->action_type == config('settings.action.type_category'))
                            <small>{{ trans('settings.activities.category', [
                                        'userName' => Auth::user()->name,
                                        'nameCategory' => $categories[$userActivity->action_id],
                                    ]) }}
                            </small>
                        @else
                            @foreach ($lessons as $lesson)
                                @if ($userActivity->action_id == $lesson->id)
                                    <small>{{ trans('settings.activities.lesson', [
                                                'userName' => Auth::user()->name,
                                                'result' => $lesson->result,
                                                'wordMemory' => substr($userActivity->action_type, config('settings.substr_actionType')),
                                                'nameCategory' => $lesson->category->title,
                                            ]) }}
                                    </small>
                                @endif
                            @endforeach
                        @endif
                            <br><small>{{ $userActivity->created_at->format('Y-m-d G:i a') }}</small>
                        </div>
                    </div>
                </li>
            @empty
                <li class="list-group-item">
                    {{ trans('settings.home.no_activity') }}
                </li>
            @endforelse
            </ul>
        </div>
        <div class="panel panel-bordered panel-dark">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans('settings.home.activity_follow_title') }}</h3>
            </div>
            <ul class="list-group list-group-bordered overflow">      
            @forelse ($userFollowActivities as $userFollowActivity)
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <a class="avatar">
                                <img src="{{ $userFollowActivity->user->avatar }}" class="height-auto">
                            </a>
                        </div>
                        <div class="media-body">
                        @if ($userFollowActivity->action_type == config('settings.action.type_category'))
                            <small>{{ trans('settings.activities.category', [
                                        'userName' => $userFollowActivity->user->name,
                                        'nameCategory' => $categories[$userFollowActivity->action_id],
                                    ]) }}
                            </small>
                        @else
                            @foreach ($userFollowLessons as $userFollowLesson)
                                @if ($userFollowActivity->action_id == $userFollowLesson->id)
                                    <small>{{ trans('settings.activities.lesson', [
                                                'userName' => $userFollowActivity->user->name,
                                                'result' => $userFollowLesson->result,
                                                'wordMemory' => substr($userFollowActivity->action_type, config('settings.substr_actionType')),
                                                'nameCategory' => $userFollowLesson->category->title,
                                            ]) }}
                                    </small>
                                @endif
                            @endforeach
                        @endif
                            <br><small>{{ $userFollowActivity->created_at->format('Y-m-d G:i a') }}</small>
                        </div>
                    </div>
                </li>
            @empty
                <li class="list-group-item">
                    {{ trans('settings.home.no_activity') }}
                </li>
            @endforelse
            </ul>
        </div>
    </div>
@endsection
