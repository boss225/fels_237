@extends('layouts.layout')

@section('title')
    {{ trans('settings.title.manage_word') }}
@endsection

@section('content')
    <div class="panel panel-bordered panel-dark">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('settings.title.manage_word') }}</h3>
            <div class="panel-actions">
                <button class="btn btn-primary" id="addWord" data-toggle="modal" data-target="#wordModal">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('settings.layout.admin.btn_add') }}
                </button>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr class="table-info">
                    <th></th>
                    <th>{{ trans('settings.layout.admin.category') }}</th>
                    <th>{{ trans('settings.layout.admin.word') }}</th>
                    <th>{{ trans('settings.layout.admin.answer') }}</th>
                    <th>{{ trans('settings.layout.admin.create_at') }}</th>
                    <th>{{ trans('settings.layout.admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($items))
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->category->title }}</td>
                            <td>{{ $item->word }}</td>
                            <td>{{ $item->answer }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <button class="btn btn-success btn-sm wordItem" data-toggle="modal" data-target="#wordModal" 
                                    data-id="{{ $item->id }}" 
                                    data-category="{{ $item->category->id }}"
                                    data-title="{{ $item->word }}"
                                    data-url="{{ action('Admin\WordController@wordContent') }}"
                                    data-description="{{ $item->description }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" id="deleteWord"
                                    data-id="{{ $item->id }}"
                                    data-msg="{{ trans('settings.confirm_message') }}"
                                    data-url="{{ action('Admin\WordController@destroy', $item->id) }}">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="6">{{ trans('settings.empty_message') }}</td></tr>
                @endif
            </tbody>
        </table>
        {{ $items->links() }}
    </div>

    <div class="modal fade" id="wordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title" id="title">{{ trans('settings.title.manage_word') }}</h4>
                </div>
                <form class="modal-body form-answer">
                    <div class="form-group">
                        {{ Form::select('category_id', $categories, null, [
                            'class' => 'form-control',
                            'id' => 'word_category',
                            'placeholder' => trans('settings.title.choice_category'),
                            'required',
                        ]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::text('word', old('word'), [
                            'class' => 'form-control',
                            'id' => 'nameWord',
                            'placeholder' => "Word",
                            'required',
                        ]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::textarea('description', old('description'), [
                            'class' => 'form-control',
                            'id' => 'description',
                            'placeholder' => "Description",
                            'rows' => '3',
                        ]) }}
                    </div>
                    <label for="basic-url">{{ trans('settings.layout.admin.answer') }}</label>                    
                    <div class="form-group group-answer">
                        @for ($i=0; $i < config('settings.number_answer'); $i++)
                            <div class="input-group m-b-5 input-answer">
                                <span class="input-group-addon">
                                    {{ Form::radio('check_answer', $i) }}
                                </span>
                                {{ Form::text('answer[]', null, [
                                    'class' => 'form-control',
                                    'id' => 'answer_'.$i,
                                    'required',
                                    'autofocus',
                                ]) }}
                                {{ Form::hidden('idAnswer[]', null) }}
                                <span class="input-group-btn">
                                    <button class="btn btn-danger p-t-10 delete-answer" type="button">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </div>
                        @endfor
                    </div>
                </form>
                <input type="hidden" id="idWord">
                
                <div class="modal-footer">
                    <button id="addAnswer" class="btn btn-success" data-url="{{ action('Admin\WordController@wordContent') }}">
                        {{ trans('settings.layout.admin.btn_addAnswer') }}
                    </button>
                    <button class="btn btn-primary" id="addNewWord" data-dismiss="modal" data-url="{{ action('Admin\WordController@store') }}">
                        {{ trans('settings.layout.admin.btn_addNew') }}
                    </button>
                    <button class="btn btn-primary" id="saveChange" data-dismiss="modal" data-url="{{ action('Admin\WordController@index') }}">
                        {{ trans('settings.layout.admin.btn_saveChange') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

