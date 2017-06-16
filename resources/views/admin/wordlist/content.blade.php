@if (!isset($numItems))
    <div class="input-group m-b-5 input-answer">
        <span class="input-group-addon">
            <input name="check_answer" type="radio" value="{{ $numEdit }}">
        </span>
        <input class="form-control" id="answer_{{ $numEdit }}" required autofocus name="answer[new_{{ $numEdit }}][ans]" type="text">
        <span class="input-group-btn">
            <button class="btn btn-danger p-t-10 delete-answer" type="button">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
        </span>
    </div>
@else
    <div class="input-group m-b-5 input-answer">
        <span class="input-group-addon">
            <input name="check_answer" type="radio" value="{{ $numItems }}">
        </span>
        <input class="form-control" id="answer_{{ $numItems }}" required autofocus name="answer[]" type="text">
        <span class="input-group-btn">
            <button class="btn btn-danger p-t-10 delete-answer" type="button">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
        </span>
    </div>
@endif
