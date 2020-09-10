$(document).ready(function() {

    var _token = $('meta[name="csrf-token"]').attr('content');

    var var_save_success = $('#var_save_success').text();
    var var_success = $('#var_success').text();

    $(document).on('change', '.manager_id', function(){

        var dentist_id = ($(this).attr('id')).replace('assignTo_', '');

        $.post('/assign-manager', {
            _token: _token,
            id:dentist_id,
            manager_id: $(this).val()
        })
        .done(function (response) {
            if (response.result == true) {
                toastr.success(var_success, var_save_success);
            }
        });

    });


    $("#dentists_table").DataTable({
        language: {
           "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Italian.json"
         },
        fixedHeader: true,
        pageLength: 15,
        lengthMenu: [5, 15, 25, 50, 100],
        ordering: true,
        columnDefs: [{
            "targets": [0,],
            "orderable": true
        }],
        responsive: true,
    });




});
