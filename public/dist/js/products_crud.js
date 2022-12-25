

$(document).ready(function() {
    var table = $('.user_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('#create_record').click(function() {
        $('.modal-title').text('Add New Record');
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#form_result').html('');
        $('#formModal').modal('show');
    });
    $('#sample_form').on('submit', function(event) {
        event.preventDefault();
        var action_url = '';
        if ($('#action').val() == 'Add') {
            action_url = "{{ route('users.store') }}";

        }
        if ($('#action').val() == 'Edit') {
            action_url = "{{ route('users.update') }}";

        }


        $.ajax({
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: action_url,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                console.log('success: ' + data);
                var html = '';
                if (data.errors) {
                    html = '<div class="alert alert-danger">';
                    for (var count = 0; count < data.errors.length; count++) {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if (data.success) {

                    html = '<div class="alert alert-success">' + data.success +
                        '</div>';
                    $('#sample_form')[0].reset();
                    $('#user_table').DataTable().ajax.reload();
                }
                $('#form_result').html(html);
            },
            error: function(data) {
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });
    $(document).on('click', '.edit', function(event) {
        event.preventDefault();
        var id = $(this).attr('id');
        alert(id);
        $('#form_result').html('');
        $.ajax({
            url: "users/edit/" + id + "/",
            headers: {
                'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(data) {
                console.log('success: ' + data);
                $('#name').val(data.result.name);
                $('#email').val(data.result.email);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Record');
                $('#action_button').val('Update');
                $('#action').val('Edit');
                $('.editpass').hide();
                $('#formModal').modal('show');
            },
            error: function(data) {
                var errors = data.responseJSON;
                console.log(errors);
            }
        })
    });

    var user_id;
    $(document).on('click', '.delete', function() {
        user_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });
    $('#ok_button').click(function() {
        $.ajax({
            url: "users/destroy/" + user_id,
            beforeSend: function() {
                $('#ok_button').text('Deleting...');
            },
            success: function(data) {
                // setTimeout(function() {
                //     $('#confirmModal').modal('fade');
                //     $('#user_table').DataTable().ajax.reload();
                //     alert('Data Deleted');
                // }, 2000);
                $('#confirmModal').modal('hide');
                $('#user_table').DataTable().ajax.reload();
                alert('Data Deleted');
            }

        })
    });
});
