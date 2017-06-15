$(document).ready(function() {
    var _token = $('meta[name="csrf-token"]').attr('content');
    $(function() {
        $('[data-toggle="popover"]').popover()
    });
    $('#dataTable').DataTable({
        'info': false,
        'lengthChange': false,
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

    $('#addNew').prop('disabled',true);
    $('#saveChange').prop('disabled',true);
    $('.modal-category .modal-body input').keyup(function() {
        var empty = false;
        $('.modal-category .modal-body input').each(function() {
            if ($(this).val() == '') {
                empty = true;
            }
        });

        $('#addNew').prop('disabled', empty ? true : false);
        $('#saveChange').prop('disabled', empty ? true : false);
    });

    $('#addNew').click(function(event) {
        var title =  $('#title_modal').val();
        var question_number =  $('#question_number').val();
        var url = $(this).data().url;
        $.ajax({
            url: url,
            type: 'POST',
            data: {'title': title, 'question_number': question_number, '_token': _token},
            success: function(data) {
                $('table.table-hover').load(location.href + ' table.table-hover');
                $.notify({ message: data.message },{ type: 'success' }); 
            },
            error: function(data) {
                $.notify({ message: 'error !' },{ type: 'danger' }); 
            } 
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
                    $.notify({ message: data.message },{ type: 'success' }); 
                },
                error: function(data) {
                    $.notify({ message: 'error !' },{ type: 'danger' }); 
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
                $.notify({ message: data.message },{ type: 'success' }); 
            },
            error: function(data) {
                $.notify({ message: 'error !' },{ type: 'danger' }); 
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
                    $.notify({ message: data.message },{ type: 'success' }); 
                },
                error: function(data) {
                    $.notify({ message: 'error !' },{ type: 'danger' }); 
                }
            });
        }
    });

    // Word list
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
                    $.notify({ message: data.message },{ type: 'success' }); 
                },
                error: function(data) {
                    $.notify({ message: 'error !' },{ type: 'danger' }); 
                }
            });
        }
    });

    $('.group-answer').on('click', '.delete-answer', function () {
        $(this).closest('.input-answer').remove();
    });

    $('#addAnswer').click(function () {
        var numItems = $("input[name='check_answer']").length;        
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
            error: function(data) { $.notify({ message: 'error !' },{ type: 'danger' }); }
        });

    });


    $('#addNewAnswer').click(function () {
        var numEdit = $("input[name='check_answer']").length;        
        var url = $(this).data().url;

        $.ajax({
            url: url,
            type: 'get',
            data: { 
                'numEdit': numEdit,
            },
            success: function(data) {
                $("div.group-answer").append(data);   
                numEdit++;            
            },
            error: function(data) { $.notify({ message: 'error !' },{ type: 'danger' }); }
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
                    $.notify({ message: data.message },{ type: 'success' }); 
                },
                error: function(data) {
                    $.notify({ message: 'error !' },{ type: 'danger' }); 
                } 
                
            });
        }
    });

    //follow
    $('button#userFollow').on('click', function () {
        var self = $(this);
        var id = self.data().id;
        var url = self.data().url;
        var title = self.attr('data-title').trim();
        var titleNew = self.text().trim();
        var count_following = parseInt($('.counter-number.following').text().trim());
        $.ajax({
            url: url,
            type: "post",
            data: {'id': id, '_token': _token},
            success : function (data) {
                if (data.status) {
                    if (data.result == 'add') {
                        self.removeClass('btn-primary')
                            .addClass('btn-success')
                            .attr('data-title', titleNew)
                            .text(title);
                        $('.counter-number.following').text(++count_following);
                    } else {
                        self.removeClass('btn-success')
                            .addClass('btn-primary')
                            .attr('data-title', titleNew)
                            .text(title);
                        $('.counter-number.following').text(--count_following);
                    }
                }
            },
            error: function(data) {
                $.notify({ message: 'error !' },{ type: 'danger' }); 
            }
        });
    });
});

