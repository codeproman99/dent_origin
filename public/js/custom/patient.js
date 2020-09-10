$(document).ready(function() {

    var frm_patient = $('#frm_patient');
    var submit_button = $('#btn_save');

    var var_saved_saved = $('#var_saved_saved').text();
    var var_saved_fail = $('#var_saved_fail').text();
    var var_saved_success = $('#var_saved_success').text();
    var var_saved_warning = $('#var_saved_warning').text();

    submit_button.on('click', function(e){
        e.preventDefault();

        var post_data = frm_patient.serialize();
        console.log(post_data);

        $.post("/update-patient-info", post_data)
        .then(function(response){
            console.log(response);
            if(response.success == true){
                toastr.success(var_saved_saved, var_saved_success);
            }else {
                toastr.error(var_saved_fail, var_saved_warning)
            }
        })
    })

});
