@extends('layouts.test')

@section('title')
    {{ trans('settings.title.test') }}
@endsection

@section('content')
    <div class="panel panel-primary panel-line">
        <div class="panel-heading">
            <p class="panel-title">{{ trans('settings.layout.exam_date') }} : {{ $createdAt }}</p>
            <h3 class="panel-title text-xs-center">{{ $categoryName }}</h3>
        </div>
        <hr>
        <div class="panel-body">
            @if (isset($questions) && $questions->isNotEmpty())
                {{ Form::open([
                    'action' => ['User\LessonController@update', Request::route('lesson')],
                    'method' => 'PATCH',
                    'role' => 'form',
                ]) }}
                    @foreach ($questions as $question)
                        <div class="border-bottom">
                            <h4 class="question">{{ $loop->iteration }} . {{ $question->word }}</h4>
                            <div class="section-answer">
                                @foreach ($question->options as $option)
                                <div class="radio">
                                    <label>
                                        {{ Form::radio('word[' . $question->id . ']', $option->option) }}
                                        {{ $option->option }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        {{ Form::radio('word[' . $question->id . ']', 'null', true, [
                            'class' => 'hidden',
                        ]) }}                                                                    
                        <br>
                    @endforeach
                    {{ Form::hidden('time', $timer) }}
                    {{ Form::submit(trans('settings.layout.btn_finish'), ['class' => 'btn btn-primary']) }}
                {{ Form::close() }}
            @elseif (isset($viewTests) && $viewTests->isNotEmpty())
                @foreach ($viewTests as $viewTest)
                    <div class="border-bottom">
                        <h4 class="question">{{ $loop->iteration }} . {{ $viewTest->word }}</h4>
                        <div class="section-answer">
                            @foreach ($viewTest->options as $option)
                            <div class="radio">
                                <label {{ setAnswer($viewTest->answer, $option->option) }}> 
                                    @foreach ($viewTest->results as $result)
                                        @if ($result->lesson_id == Request::route('id'))                                     
                                            <input type="radio" disabled {{ setChecked($result->user_answer, $option->option) }}>
                                        @endif
                                    @endforeach
                                    {{ $option->option }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <br>
                @endforeach
            @else
                <p class="text-success">
                    {{ trans('settings.empty_message') }}
                </p>
            @endif
        </div>
    </div>
@endsection

