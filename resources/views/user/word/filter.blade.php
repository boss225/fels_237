@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.word_list') }}
@endsection

@section('content') 
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading text-xs-center">
            <h3 class="panel-title">{{ trans('settings.layout.user.word_title') }} {{ Request::route('id') ? '- ' . $categories->title : null }}</h3>
        </div>
        <ul class="list-group list-group-bordered">
            <li class="list-group-item">
                {{ Form::open([
                    'action' => Request::route('id') ? ['User\WordController@wordsCategoryFilter', Request::route('id')] : 'User\WordController@wordsFilter',
                    'class' => 'form-inline',
                ]) }}
                    <div class="input-group input-word-group">
                        <span class="input-group-btn">
                            {{ Form::submit(trans('settings.layout.user.word_btnFilter'), [
                                'class' => 'btn btn-primary p-t-10',
                            ]) }}
                        </span>
                        {{ Form::text('key', $filterKey, [
                            'class' => 'form-control input-sm',
                            'id' => 'key',
                            'placeholder' => "Key word",
                            'class' => 'form-control',
                            'maxlength' => "10",
                        ]) }}
                        {{ Form::select('arrange',
                            ['A -> Z', 'Z -> A'],
                            $filterArrange,
                            ['class' => 'form-control']
                        ) }} 
                        <span class="input-group-addon">
                            <span class="checkbox-inline">
                                {{ Form::radio('rdOption', config('settings.filter.learned'), $filterOption !== config('settings.filter.no_learned') ? true : null) }}
                                {{ trans('settings.layout.user.word_unlearned') }}
                            </span>
                            <span class="checkbox-inline">
                                {{ Form::radio('rdOption', config('settings.filter.no_learned'), $filterOption === config('settings.filter.no_learned') ? true : null) }}
                                {{ trans('settings.layout.user.word_learned') }}
                            </span>
                        </span>                 
                    </div>                                    
                {{ Form::close() }}
            </li>
            @forelse ($words as $word)
                <li class="list-group-item">
                    <a class="learned {{ $word->users->count() > 0 ? 'memorised' : '' }}" tabindex="0" data-html="true"
                        data-toggle="popover" 
                        data-trigger="focus" 
                        title="Meaning:" 
                        data-content='{{ $word->description ?: null }}'>
                        <i class="fa {{ $word->users->count() > 0 ? 'fa-check-circle' : 'fa-info-circle' }} m-r-5"></i> {{ $word->word }} : {{ $word->answer }}
                    </a>
                </li>            
            @empty
                <li class="list-group-item">{{ trans('settings.empty_message') }}</li>
            @endforelse
        </ul>
        {{ $words->links() }}
    </div>
@endsection
