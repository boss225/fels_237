$(document).ready(function() {
    var _token = $('input[name=_token]').val();

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

    $(document).on('click', '#saveChange', function(event) {
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
});

