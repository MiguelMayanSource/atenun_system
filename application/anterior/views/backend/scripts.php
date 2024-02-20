    <!--<script>
        $('aside').toggleClass('side-nav-small');
        $('.contentWrapper').toggleClass('side-nav-small');
    </script>
 
    <script>
        $('.mCustomScrollbar').perfectScrollbar();
    </script>-->
    <?php if($page_name == 'quote'):?>
    <script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
    <?php endif;?>
    <script src="<?php echo base_url();?>public/assets/theme/js/moment.min.js"></script>

    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/datepicker.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/popper.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/perfect-scrollbar-config.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap-tour-standalone.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap-tour-config.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/colorPick.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/colorpicker.js"></script>
    <script>
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
    if($('#mainTable').length > 1)
    $('#mainTable').DataTable();

    $(".typehead").each(function() {

        table = $(this).data('table');
        field = $(this).attr('name');
        console.log($(this).attr('name'))

        $(this).attr('onclick', `openSelect('${table}',this.value,'${field}')`);
        $(this).attr('id', field + '_name');


        $(this).after(`<div style="position: fixed;width: 96%;z-index: 99999999;" >
                            <table  id='${field}_search' class='table' style="background:#dee2e6;margin-bottom: 0;border:1px solid #dee2e6;" ></table>
                            <div id="loader_${field}" class="spinner-border text-primary" style="display:none;" role="status"><span class="sr-only">Loading...</span></div>
                            <table  id='${field}_options' class='table' 'style="background:white;"></table>
                        </div>
                        `);
    });


});

function openSelect(table, value, field) {

    $('#loader_' + field).show();
    $.ajax({
        url: "<?php echo base_url().'admin/openSelect/';?>",
        type: "POST",
        data: {
            table: table,
            field: field,
            name: value,
        },
        success: function(response) {

            $('#loader_' + field).hide();
            $('#' + field + '_name').html('');
            $('#' + field + '_search').html(response);
            $('#' + field + '_new').focus();
            //console.log(response);
        },
        error: function() {
            console.log("error");
        }
    });

}

function getValues(table, value, field) {

    $('#loader_' + field).show();
    $.ajax({
        url: "<?php echo base_url().'admin/getValues/';?>",
        type: "POST",
        data: {
            table: table,
            field: field,
            name: value,
        },
        success: function(response) {

            $('#loader_' + field).hide();
            $('#' + field + '_options').html(response);
            //console.log(response);
        },
        error: function() {
            console.log("error");
        }
    });

}


function selectValue(table, id, name, field) {

    if (field != "") {
        $('#' + field + '_search').html('');
        $('#' + field + '_options').html('');
        $('#' + field + '_name').append(`<option value="${id}" selected>${name}</option>`);
    }
}

function addValue(table, field) {

    value = $('#' + field + '_new').val();
    if (value != "") {
        $('#loader_' + field).show();
        $.ajax({
            url: "<?php echo base_url().'admin/addValue/';?>",
            type: "POST",
            data: {
                table: table,
                name: value,
            },
            success: function(response) {
                $('#loader_' + field).hide();
                $('#' + field + '_search').html('');
                $('#' + field + '_options').html('');
                $('#' + field + '_name').append(`<option value="${response}" selected>${value}</option>`);
                //console.log(response);
            },
            error: function() {
                console.log("error");
            }
        });
    }
}

function deleteValue(table, element) {

    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            console.log($(element).data('id'));
            if (table != "") {

                $.ajax({
                    url: "<?php echo base_url().'admin/deleteValue/';?>",
                    type: "POST",
                    data: {
                        table: table,
                        id: $(element).data('id'),

                    },
                    success: function(response) {
                        element.parentElement.remove();
                        element.remove();

                        //console.log(response);
                    },
                    error: function() {
                        console.log("error");
                    }
                });
            }

        }
    })
}
    </script>
    <?php if ($this->session->flashdata('flash_message') != ""):?>
    <script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 5000
});
Toast.fire({
    type: 'success',
    title: '<?php echo $this->session->flashdata("flash_message");?>'
})
    </script>
    <?php endif;?>

    <?php if ($this->session->flashdata('error_message') != ""):?>
    <script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 5000
});
Toast.fire({
    type: 'error',
    title: '<?php echo $this->session->flashdata("error_message");?>'
})
    </script>
    <?php endif;?>
    <script src="<?php echo base_url();?>public/assets/appointments/js/reservation_wizard_func.js"></script>
    <script src="<?php echo base_url();?>public/assets/appointments/js/common_scripts.js"></script>
    <script src="<?php echo base_url();?>public/assets/appointments/js/velocity.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/appointments/js/main.js"></script>
    <script src="<?php echo base_url();?>public/assets/appointments/js/functions.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/script.js"></script>
    <script>

if($('#zero-config').length > 1)
{
$('#zero-config').DataTable({
    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
    "oLanguage": {
        "oPaginate": {
            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
        },
        "sInfo": "Showing page _PAGE_ of _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Search...",
        "sLengthMenu": "Results :  _MENU_",
    },
    "stripeClasses": [],
    "lengthMenu": [7, 10, 20, 50],
    "pageLength": 7,
    "ordering": false
});

}
    </script>