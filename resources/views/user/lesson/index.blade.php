@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.lesson') }}
@endsection

@section('content') 
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading text-xs-center">
            <h3 class="panel-title">{{ trans('settings.layout.user.lesson_title') }}</h3>
        </div>
        <div class="panel-body">
            {{ Form::open([
                'class' => 'form-horizontal',
                'role' => 'form',
                'action' => 'User\LessonController@store',
            ]) }}
                <div class="input-group{{ $errors->has('test_id') ? ' has-error' : '' }}">
                    {{ Form::select('test_id', $categories, null, [
                        'class' => 'form-control',
                        'id' => 'lesson_category',
                        'placeholder' => trans('settings.title.choice_category'),
                        'required',
                    ]) }}
                    <span class="input-group-btn">
                        {{ Form::submit(trans('settings.layout.user.btn_createLesson'), [
                            'class' => 'btn btn-primary p-t-10',
                            'id' => 'create-lesson',
                        ]) }}
                    </span>
                </div>
                @if ($errors->has('test_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('test_id') }}</strong>
                    </span>
                @endif
                    
            {{ Form::close() }}
            <hr>
            @if (!empty(session('status')))
                <div class="alert alert-{{ session('status') }}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('message') }}
                </div>
            @endif
            <h3>{{ trans('settings.layout.user.lesson_list') }}</h3>
        </div>
        <table class="table table-hover">
            <thead>
                <tr class="table-info">
                    <th>{{ trans('settings.layout.user.lesson_createdAt') }}</th>
                    <th>{{ trans('settings.layout.user.lesson') }}</th>
                    <th>{{ trans('settings.layout.user.lesson_number') }}</th>
                    <th>{{ trans('settings.layout.user.lesson_spentTime') }}</th>
                    <th>{{ trans('settings.layout.user.lesson_result') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse ($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->created_at->format('Y-m-d G:i a') }}</td>
                    <td>{{ $lesson->category->title }}</td>
                    <td>{{ $lesson->test->question_number }}</td>
                    <td>{{ $lesson->spent_time }}</td>
                    <td>{{ $lesson->result }}/{{ $lesson->test->question_number }}</td>
                    <td>
                    @if ($lesson->result == config('settings.lesson.default_result') && $lesson->spent_time == config('settings.lesson.default_time'))
                        <a href="{{ action('User\LessonController@show', $lesson->id) }}" class="btn btn-primary btn-sm">
                            {{ trans('settings.layout.user.btn_start') }}
                        </a>
                    @else
                        <a href="{{ action('User\LessonController@view', $lesson->id) }}" class="btn btn-success btn-sm">
                            {{ trans('settings.layout.user.btn_view') }}
                        </a>
                    @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">{{ trans('settings.empty_message') }}</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $lessons->links() }}
    </div>
@endsection
