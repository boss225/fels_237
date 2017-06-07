$(document).ready(function() {
    var _token = $('meta[name="csrf-token"]').attr('content');
    $(function() {
        $('[data-toggle="popover"]').popover()
    });

    // categories     
    $(document).on('click', '.ourItem', function(event) {
        var id = $(this).data().id;
        var title = $(this).data().title;
        var number = $(this).data().number;
        $('#title_modal').val(title);
        $('#question_number').val(number);
        $('#idCategory').val(id);
        $('#saveChange').show();
        $('#addNew').hide();
    });

    $(document).on('click', '#addCategory', function(event) {
        $('#title_modal').val('');
        $('#question_number').val('');
        $('#saveChange').hide();
        $('#addNew').show();
    });

    $('#addNew').click(function(event) {
        var title =  $('#title_modal').val();
        var question_number =  $('#question_number').val();
        var url = $(this).data().url;
        $.post(url, {'title': title, 'question_number': question_number, '_token': _token}, function(data) {
            $('table.table-hover').load(location.href + ' table.table-hover');
            alert(data.message);                        
        });
    });

    $(document).on('click', '#deleteCategory', function(event) {
        var id = $(this).data().id;
        var url = $(this).data().url;
        var message = $(this).data().msg;
        if (confirm(message) == true) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {'id': id, '_token': _token},
                success: function(data) {
                    $('table.table-hover').load(location.href + ' table.table-hover');
                    alert(data.message);
                }
            });
        }
    });

    $('#myModal').on('click', '#saveChange', function(event) {
        var id =  $('#idCategory').val();
        var title =  $('#title_modal').val();
        var question_number =  $('#question_number').val();
        var url = $(this).data().url;
        $.ajax({
            url: url + '/' + id,
            type: 'PUT',
            data: { 'id': id, 'title': title, 'question_number': question_number, '_token': _token },
            success: function(data) {
                $('table.table-hover').load(location.href + ' table.table-hover');
                alert(data.message); 
            }
        });
    });

    // Account
    $(document).on('click', '#deleteUser', function(event) {
        var id = $(this).data().id;
        var url = $(this).data().url;
        var message = $(this).data().msg;
        if (confirm(message) == true) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {'id': id, '_token': _token},
                success: function(data) {
                    $('table.table-hover').load(location.href + ' table.table-hover');
                    alert(data.message);
                }
            });
        }
    });

    // Word list
    $(document).on('click', '#addWord', function(e) {
        $('#word_category').val('');
        $('#nameWord').val('');
        $('#description').val('');
        $.each($('input[name="answer[]"]'), function() {
            $(this).val('');
        });
        $('input[name=check_answer]').prop('checked', false);
        $('#saveChange').hide();
        $('#addNewWord').show();
    });

    $('#addNewWord').click(function(e) {      
        var category_id =  $('#word_category').val();
        var word =  $('#nameWord').val();
        var description = $('#description').val();
        var options = $("input[name='answer[]']").map(function (){ 
            return $(this).val() 
        }).get();
        var checkAnswer = $('input[name=check_answer]:checked').val()
        $.each(options, function( id, value ) {
            if (id == checkAnswer){
                checkAnswer = value;
            }
        });
        var url = $(this).data().url;
        $.ajax({
            url: url,
            type: 'post',
            data: { 
                'category_id': category_id, 
                'word': word, 
                'description': description, 
                'answer': checkAnswer, 
                'options': options, 
                '_token': _token,
            },
            success: function(data) {
                $('table.table-hover').load(location.href + ' table.table-hover');
                alert(data.message);
            },
            error: function(data) { alert(data.responseText) }
        });
    });

    $(document).on('click', '#deleteWord', function(event) {
        var id = $(this).data().id;
        var url = $(this).data().url;
        var message = $(this).data().msg;
        if (confirm(message) == true) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {'id': id, '_token': _token},
                success: function(data) {
                    $('table.table-hover').load(location.href + ' table.table-hover');
                    alert(data.message);
                },
                error: function(data) { alert(data.responseText) }
            });
        }
    });

    $(document).on('click', '.wordItem', function(e) {
        var id = $(this).data().id;
        var category = $(this).data().category;
        var title = $(this).data().title;
        var description = $(this).data().description;
        var url = $(this).data().url;

        $.ajax({
            url: url,
            type: 'get',
            data: { 
                'id': id,
            },
            success: function(data) {
                $(".group-answer").html(data);               
            },
            error: function(data) { alert(data.responseText) }
        });

        $('#word_category').val(category);
        $('#description').val(description);
        $('#nameWord').val(title);
        $('#idWord').val(id);
        $('#saveChange').show();
        $('#addNewWord').hide();
    });

    $('#wordModal').on('click', '#saveChange', function(event) {
        var id =  $('#idWord').val();
        var category_id =  $('#word_category').val();
        var word =  $('#nameWord').val();
        var description = $('#description').val();
        var checkAnswer = $('input[name=check_answer]:checked').val();
        var url = $(this).data().url;

        var options = $("input[name='answer[]']").map(function (){ 
            return $(this).val() 
        }).get();
        var idOptions = $("input[name='idAnswer[]']").map(function (){ 
            return $(this).val() 
        }).get();
        var ans = {}
        for (var i = 0; i < options.length; i++) {
            ans[idOptions[i]] = options[i];
        }
        $.each(options, function( id, value ) {
            if (id == checkAnswer){
                checkAnswer = value;
            }
        });

        $.ajax({
            url: url + '/' + id,
            type: 'PUT',
            data: { 
                'id': id,
                'category_id': category_id, 
                'word': word, 
                'description': description, 
                'answer': checkAnswer, 
                'options': ans,  
                'idOptions': idOptions,  
                '_token': _token,
            },
            success: function(data) {
                $('table.table-hover').load(location.href + ' table.table-hover');
                alert(data.message);
            },
            error: function(data) { alert(data.responseText) }
        });
    });

    $('#wordModal').on('click', '.delete-answer', function () {
        $(this).closest('.input-answer').remove();
    });

    var numItems = $("input[name='check_answer']").length;
    $('#wordModal').on('click', '#addAnswer', function () {
        var url = $(this).data().url;

        $.ajax({
            url: url,
            type: 'get',
            data: { 
                'numItems': numItems,
            },
            success: function(data) {
                $("div.group-answer").append(data);   
                numItems++;            
            },
            error: function(data) { alert(data.responseText) }
        });

    });

    // Lesson
    $(document).on('click', '#deleteLesson', function(e) {
        var id = $(this).data().id;
        var url = $(this).data().url;
        var message = $(this).data().msg;
        if (confirm(message) == true) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {'id': id, '_token': _token},
                success: function(data) {
                    $('table.table-hover').load(location.href + ' table.table-hover');
                    alert(data.message);
                }
            });
        }
    });
});

