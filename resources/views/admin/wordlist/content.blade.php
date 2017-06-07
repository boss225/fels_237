@if (!isset($numItems))
    @foreach ($answers as $answer)
        <div class="input-group m-b-5 input-answer">
            <span class="input-group-addon">
                <input name="check_answer" type="radio" value="{{ $loop->iteration - 1 }}" {{ ( $answer->option == $checkAnswer[0] ) ? 'checked' : '' }}>
            </span>
            <input class="form-control" id="answer_{{ $loop->iteration }}" required autofocus name="answer[]" type="text" value="{{ $answer->option }}">
            <input name="idAnswer[]" type="hidden" value="{{ $answer->id }}">
            <span class="input-group-btn">
                <button class="btn btn-danger p-t-10 delete-answer" type="button">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </span>
        </div>
    @endforeach
@else
    <div class="input-group m-b-5 input-answer">
        <span class="input-group-addon">
            <input name="check_answer" type="radio" value="{{ $numItems }}">
        </span>
        <input class="form-control" id="answer_{{ $numItems }}" required autofocus name="answer[]" type="text">
        <input name="idAnswer[]" type="hidden">
        <span class="input-group-btn">
            <button class="btn btn-danger p-t-10 delete-answer" type="button">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
        </span>
    </div>
@endif
