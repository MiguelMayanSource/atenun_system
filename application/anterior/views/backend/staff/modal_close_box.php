<?php 
 $cash = $this->crud_model->getNomenCash();
 $brl = $this->crud_model->getAccountByBankName("Banrural");
 $bam = $this->crud_model->getAccountByBankName("BAM");
 $box = $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1));
?>
<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Apertura de caja</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>staff/box/close_box/<?php echo $box->row()->box_id; ?>" method="POST">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="card card-custom gutter-b">
                            <div class="card-body d- flex f lex-column">
                                <div class="d-f lex align-ite ms-center justify-con tent -between flex-g row-1">
                                    <div class="mr-2">
                                        <h3 class="font-weight-bolder"><?php echo $this->accounts_model->get_name($box->row()->user_type,$box->row()->user_id); ?></h3>
                                    </div>
                                    <div class="font-weight-boldest font-size-h1 ">
                                        <?php echo $box->row()->start_time; ?> </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="ingresos" name="ingresos" value="0" step="0.01" class="form-control" aria-label="Text input with checkbox" readonly="true">
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="card card-custom gutter-b">
                            <div class="card-body d- flex f lex-column">
                                <div class="d-f lex align-ite ms-center justify-con tent -between flex-g row-1">
                                    <div class="mr-2">
                                        <h3 class="font-weight-bolder">Caja chica:</h3>
                                    </div>
                                    <div class="font-weight-boldest font-size-h1 text-warning">
                                        Q<?php echo $this->inventory_model->get_total_cajac($box->row()->box_id);?></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="monto_limite" value="98" step="0.01" class="form-control" aria-label="Text input with checkbox" readonly="true">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="card card-custom gutter-b">
                            <div class="card-body d- flex f lex-column">
                                <div class="d-f lex align-ite ms-center justify-con tent -between flex-g row-1">
                                    <div class="mr-2">
                                        <h3 class="font-weight-bolder">Caja de ventas:</h3>
                                    </div>
                                    <div class="font-weight-boldest font-size-h1 text-success">
                                        Q<?php echo $this->inventory_model->get_total_cajav($box->row()->box_id);?> </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="ingresos" name="ingresos" value="0" step="0.01" class="form-control" aria-label="Text input with checkbox" readonly="true">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="card card-custom gutter-b">
                            <div class="card-body d- flex f lex-column">
                                <div class="d-f lex align-ite ms-center justify-con tent -between flex-g row-1">
                                    <div class="mr-2">
                                        <h3 class="font-weight-bolder">Banco:</h3>
                                    </div>
                                    <div class="font-weight-boldest font-size-h1 text-info">
                                        Q<?php echo $this->inventory_model->get_total_banco($box->row()->box_id);?> </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="caja_nueva" id="caja_nueva" step="0.01" value="0" class="form-control" aria-label="Text input with checkbox" readonly="true">
                    </div>
                </div>
  
           <div class="col-sm-6">
                    <div class="form-group">
                        <h3 class="font-weight-bolder"><b>Total en la caja chica</b> <span class="text-danger">*</span></h3>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-boldest font-size-h1">Q</span>
                            </div>
                            <input type="number" name="ver_caja" id="ver_caja" value="0.00" step="0.01" required="true" min="0" class="form-control font-weight-boldest font-size-h1" aria-label="Text input with checkbox" oninput="verificar()">
                        </div>
                    </div>
                    <div class="form-group">
                        <h3 class="font-weight-bolder"><b>Total en la caja de ventas</b> <span class="text-danger">*</span></h3>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-boldest font-size-h1">Q</span>
                            </div>
                            <input type="number" name="ver_caja" id="ver_caja" value="0.00" step="0.01" required="true" min="0" class="form-control font-weight-boldest font-size-h1" aria-label="Text input with checkbox" oninput="verificar()">
                        </div>
                    </div>
                    <div class="form-group">
                        <h3 class="font-weight-bolder"><b>Total en bancos</b> <span class="text-danger">*</span></h3>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-boldest font-size-h1">Q</span>
                            </div>
                            <input type="number" name="ver_caja" id="ver_caja" value="0.00" step="0.01" required="true" min="0" class="form-control font-weight-boldest font-size-h1" aria-label="Text input with checkbox" oninput="verificar()">
                        </div>
                    </div>
                    <div class="form-group">
                        <h3 class="font-weight-bolder"><b>Notas:</b></h3>
                        <div class="input-group">
                            <textarea class="form-control" name="notes" aria-label="Text input with checkbox" rows="3">Ninguna</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Cerrar caja</button>
                </div> 
            </div>
       
        </div>

        <div class="modal-footer">
            <button type="submit" class="button-confirm">Actualizar</button>
        </div>
         </form>
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
        url: '<?php echo base_url();?>staff/get_product_pres/' + product_id,
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
        url: "<?php echo base_url().'staff/openSelect/';?>",
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
        url: "<?php echo base_url().'staff/getValues/';?>",
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
            url: "<?php echo base_url().'staff/addValue/';?>",
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
                    url: "<?php echo base_url().'staff/deleteValue/';?>",
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