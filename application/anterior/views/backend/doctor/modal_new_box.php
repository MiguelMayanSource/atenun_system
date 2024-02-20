<?php 
 $cash = $this->crud_model->getNomenCash();
 $brl = $this->crud_model->getAccountByBankName("Banrural");
 $bam = $this->crud_model->getAccountByBankName("BAM");
?>
<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Apertura de caja</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>doctor/box/new_box/" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <label class="form-label" for="exampleFormControlSelect9"><b>Encargado:</b></label><span style="color:red">*</span>
                            <input type="text" class="form-control" disabled value="<?php echo $this->accounts_model->get_name('admin',$this->session->userdata('login_user_id'));?>">
                        </div>
                        <div class="col-md-12 col-ms-12 mb-3">
                            <label for="codigoProducto" class="form-label">Monto de caja chica</label><span style="color:red">*</span>
                            <input type="number" step="any" class="form-control" required name="start_amount" placeholder="0.00">
                        </div>
                        <div class="col-md-12 col-ms-12 mb-3">
                            <label for="codigoProducto" class="form-label">Monto de caja de ventas</label><span style="color:red">*</span>
                            <input type="number" step="any" class="form-control" required name="start_amount2" placeholder="0.00">
                        </div>
                        <div class="col-lg-12 mb-2">
                            <div class="form-group">
                                <label for="bank_account_id" class="col-form-label">Cuenta bancaria</label><br>
                                <select name="bank_account_id" required id="bank_account_id" class="form-control select2-bank">
                                    <option value="">Seleccione una cuenta</option>
                                    <?php $bank_account = $this->db->get_where('bank_account',array('status'=>1));
                                     foreach($bank_account->result_array() AS $ct):?>
                                    <option value="<?php echo $ct['bank_account_id'];?>"><?php echo $ct['name'].' '.$ct['code'];?></option>
                                    <?php endforeach;?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-ms-12 mb-3">
                            <label for="codigoProducto" class="form-label">Monto de inicio de la cuenta</label><span style="color:red">*</span>
                            <input type="number" step="any" class="form-control" required name="banck_amount" placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="button-confirm">Actualizar</button>
        </div>
</div>
<script>
$(function() {

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

function getPres(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>doctor/get_product_pres/' + product_id,
        success: function(response) {
            jQuery('#unity_' + variant_id).html(response);
        }
    });
}


function validate($type) {
    if ($type == 0) {
        $('#is_exist').show(300);
        $('#is_new').hide(300);


        $('select[name="product_id"]').attr('required', true);

        $('select[name="category_id"]').attr('required', false);
        $('input[name="name"]').attr('required', false);
        $('input[name="code"]').attr('required', false);
        $('select[name="provider_id"]').attr('required', false);
        $('input[name="cost"]').attr('required', false);
        $('input[name="price_1"]').attr('required', false);
        $('input[name="u_amount"]').attr('required', false);
        $('input[name="unity"]').attr('required', false);
        $('input[name="alert"]').attr('required', false);

    }
    if ($type == 1) {
        $('#is_exist').hide(300);
        $('#is_new').show(300);

        $('select[name="product_id"]').attr('required', false);

        $('select[name="category_id"]').attr('required', true);
        $('input[name="name"]').attr('required', true);
        $('input[name="code"]').attr('required', true);
        $('select[name="provider_id"]').attr('required', true);
        $('input[name="cost"]').attr('required', true);
        $('input[name="price_1"]').attr('required', true);
        $('input[name="u_amount"]').attr('required', true);
        $('input[name="unity"]').attr('required', true);
        $('input[name="alert"]').attr('required', true);
    }
}

function openSelect(table, value, field) {

    $('#loader_' + field).show();
    $.ajax({
        url: "<?php echo base_url().'doctor/openSelect/';?>",
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
        url: "<?php echo base_url().'doctor/getValues/';?>",
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
            url: "<?php echo base_url().'doctor/addValue/';?>",
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
                    url: "<?php echo base_url().'doctor/deleteValue/';?>",
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