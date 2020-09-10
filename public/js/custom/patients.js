$(document).ready(function() {
    $("#patients_table").DataTable({
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
