$(document).ready(function(){

    const dentist_id = $('#dentist_id').val();
    const auth_role = $('#auth_role').val();
    var year = $('#year');
    var month = $('#month');
    var flat_price_month = $('#flat_price_month');
    var rate_month = $('#rate_month');

    var total_leads = $('#total_leads');
    var total_visited = $('#total_visited');
    var total_cancelled_visits = $('#total_cancelled_visits');
    var total_quotations_given = $('#total_quotations_given');
    var total_accepted_quotations = $('#total_accepted_quotations');
    var total_not_accepted_quotation = $('#total_not_accepted_quotation');
    var total_accepted_quotation_amount = $('#total_accepted_quotation_amount');

    var gaining_percent = $('#gaining_percent');
    var flat_price = $('#flat_price');
    var gaining = $('#gaining');
    var calculated_gaining = $('#calculated_gaining');
    var roi = $('#roi');
    var roi_percent = $('#roi_percent');
    var total_flat_price = $('#total_flat_price');

    var vartotal = $('#var-total').text();
    var var_visited_patients = $('#var-visited-patients').text();
    var var_cancelled_patients = $('#var-cancelled-patients').text();
    var var_quotation_given = $('#var-quotation-given').text();
    var var_accepted_quotations = $('#var-accepted-quotations').text();
    var var_waiting = $('#var-waiting').text();
    var var_saved_successfully = $('#var-saved-successfully').text();
    var var_success = $('#var-success').text();
    var var_error= $('#var-error').text();


    if( year.val() != '' && month.val() != ''){
        var post_data = $('#frm_report').serialize();
        $.post('/get-report-data', post_data)
            .then(function (response) {
                console.log(response);
                updateReports(response.result);
            })
    }

     $('.tr-result').hide();

    /** Charts */

    var options_1 = {
        series: [parseInt(total_visited.text()), parseInt(total_cancelled_visits.text())],
        labels: [var_visited_patients, var_cancelled_patients],
        chart: {
            type: 'donut'
        },
        plotOptions: {
            pie: {
                size: 200,
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '22px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 600,
                            color: undefined,
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            fontSize: '16px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 400,
                            color: undefined,
                            offsetY: 16,
                            formatter: function (val) {
                                return val
                            }
                        },
                        total: {
                            show: true,
                            showAlways: false,
                            label: vartotal,
                            fontSize: '22px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 600,
                            color: '#373d3f',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => {
                                    return a + b
                                }, 0)
                            }
                        }
                    }
                }
            }
        },
        legend: {
            position: 'bottom'
        },
        responsive: [{
            breakpoint: 200,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart_1 = new ApexCharts(document.querySelector("#chart_1"), options_1);
    chart_1.render();

    var options_2 = {
        series: [parseInt(total_quotations_given.text()), parseInt(total_accepted_quotations.text()), parseInt(total_not_accepted_quotation.text())],
        labels: [var_quotation_given, var_accepted_quotations, var_waiting],
        chart: {
            type: 'donut',
        },
        plotOptions: {
            pie: {
                size: 200,
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '22px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 600,
                            color: undefined,
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            fontSize: '16px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 400,
                            color: undefined,
                            offsetY: 16,
                            formatter: function (val) {
                                return val
                            }
                        },
                        total: {
                            show: true,
                            showAlways: false,
                            label: vartotal,
                            fontSize: '22px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 600,
                            color: '#373d3f',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => {
                                    return a + b
                                }, 0)
                            }
                        }
                    }
                }
            }
        },
        legend: {
            position: 'bottom'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart_2 = new ApexCharts(document.querySelector("#chart_2"), options_2);
    chart_2.render();


    year.on('change', function(e){
        var post_data = $('#frm_report').serialize();
        flat_price_month.val('');
        rate_month.val('');
        $.post('/get-report-data', post_data)
            .then(function(response){
                console.log(response);
                updateReports(response.result);
            })
    });

    month.on('change', function(e){
        var post_data = $('#frm_report').serialize();
        flat_price_month.val('');
        rate_month.val('');
        $.post('/get-report-data', post_data)
            .then(function (response) {
                console.log(response);
                updateReports(response.result);
            })
    });

    $('#btn_save').on('click', function(e){
        e.preventDefault();
        var post_data = $('#frm_report').serialize();

        $.post('/update-report', post_data)
            .then(function (response) {
                console.log(response);
                if(response.error){
                    var error_msg = "";
                    $.each(response.error, function(key, value){
                        error_msg = error_msg + value + '</br>';
                    });
                    toastr.error(error_msg, var_error);
                }else {
                    toastr.success(var_saved_successfully, var_success);
                    updateReports(response.result);
                }
            });

    });


    function updateReports(report_data){

        // Update Report content
        total_leads.text( report_data.total_count ? report_data.total_count : '');
        total_visited.text( report_data.visited_patients ? report_data.visited_patients: '');
        total_cancelled_visits.text( report_data.cancelled_visits ? report_data.cancelled_visits : '');
        total_quotations_given.text(report_data.quotations_given ? report_data.quotations_given: '');
        total_accepted_quotations.text(report_data.accepted_quotation ? report_data.accepted_quotation: '');
        total_not_accepted_quotation.text(report_data.not_accepted_quotation ? report_data.not_accepted_quotation: '');
        total_accepted_quotation_amount.text(report_data.total_accepted_quotation_amount ? report_data.total_accepted_quotation_amount: '');

        // Pie chart update


        series_1 = [parseInt(report_data.visited_patients), parseInt(report_data.cancelled_visits)];
        chart_1.updateSeries(series_1)

        series_2 = [parseInt(report_data.quotations_given), parseInt(report_data.accepted_quotation), parseInt(report_data.not_accepted_quotation)];
        chart_2.updateSeries(series_2);

        if( report_data.flat_price_month && report_data.rate_month ){
            flat_price_month.val(report_data.flat_price_month);
            rate_month.val(report_data.rate_month);
        }


        gaining_percent.text('');
        if (report_data.flat_price_month && report_data.rate_month) {

            // Update table content
            flat_price.text(report_data.flat_price_month);
            gaining_percent.text(report_data.rate_month);
            gaining.text(report_data.total_accepted_quotation_amount ? report_data.total_accepted_quotation_amount : '');
            calculated_gaining.text(report_data.calculated_gaining ? report_data.calculated_gaining : '');
            roi.text(report_data.roi ? report_data.roi : '');
            roi_percent.text(report_data.roi_percent ? report_data.roi_percent : '');
            total_flat_price.text(report_data.total_investment ? report_data.total_investment : '');

            // Toggle table content
            $('.tr-error').hide();
            $('.tr-result').show();
        } else {
            $('.tr-error').show();
            $('.tr-result').hide();
        }
    }


})
