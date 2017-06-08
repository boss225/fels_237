@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.manage_lesson') }}
@endsection

@section('content')
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('settings.title.manage_lesson') }}</h3>
        </div>
        <table class="table table-hover">
            <thead>
                <tr class="table-info">
                    <th>{{ trans('settings.layout.admin.name_account') }}</th>                
                    <th>{{ trans('settings.layout.user.lesson') }}</th>
                    <th>{{ trans('settings.layout.user.lesson_spentTime') }}</th>
                    <th>{{ trans('settings.layout.user.lesson_result') }}</th>
                    <th>{{ trans('settings.layout.user.lesson_createdAt') }}</th>
                    <th>{{ trans('settings.layout.admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->user->name }}</td>
                        <td>{{ $lesson->category->title }}</td>
                        <td>{{ $lesson->spent_time }}</td>
                        <td>{{ $lesson->result }}/{{ $lesson->test->question_number }}</td>
                        <td>{{ $lesson->created_at }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" id="deleteLesson"
                                data-id="{{ $lesson->id }}"
                                data-msg="{{ trans('settings.confirm_message') }}"
                                data-url="{{ action('Admin\LessonController@destroy', $lesson->id) }}">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $lessons->links() }}
    </div>
@endsection

