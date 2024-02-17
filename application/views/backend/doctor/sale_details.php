<?php 
 $cash = $this->crud_model->getNomenCash();
 $banks = $this->crud_model->getAccountsBankNomen();
?>
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>doctor/sales/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0466_shopping_cart_basket_store_successful"></i></div><span>Ventas</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/new_sale/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0172_structure_menu_submenu_navigation"></i></div> <span>Nueva ventas</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <?php
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $cart_total = 0;
        $cart_id = base64_decode($id_);
        $this->db->where('sale_id', $cart_id);
        $info = $this->db->get('sale')->result_array();    
        foreach($info as $details):
        ?>

    <div class="row">
        <div class="col-md-8">
            <div class="order-box">
                <div class="order-details-box">
                    <div class="order-main-info">
                        <strong style="font-size:25px;"><?php if($details['status']==1) echo 'Detalles de venta'; else echo 'Detalles de la cotización';?></strong>
                    </div>
                    <div class="dropdown" style="float:right">
                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right; margin-top:15px;margin-right:10%;background:#0176fe; color:#fff; border:0px;border-radius:5px;-webkit-box-shadow: 0px 2px 14px rgba(1, 118, 254, 0.40); box-shadow: 0px 2px 14px rgba(1,118, 254, 0.40); ">
                            <i class="batch-icon-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:auto; text-align:left;overflow-y:hidden">
                            <a class="dropdown-item" target="_blank" href="<?php echo base_url();?>doctor/print_receipt/<?php echo $details['sale_id'];?>/<?php echo $details['patient_id'];?>">Imprimir</a>
                            <a class="dropdown-item" href="<?php echo base_url();?>doctor/sale_details/pdf/<?php echo $details['sale_id'];?>/<?php echo $details['patient_id'];?>">Descargar PDF</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="send_email(<?php echo $details['sale_id'];?>,'<?php echo $details['patient_id'];?>')">Enviar por correo</a>
                        </div>
                    </div>
                </div>
                <div class="order-items-table">
                    <style>
                    .dropdown-menu {
                        overflow-y: scroll;
                        max-height: 250px !important;
                    }
                    </style>
                    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">
                    <div class="social-l col-lg-12 col m-b-30">


                        <div class="col-md-12">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>P/U</th>
                                                <th>Descuento</th>
                                                <th>Subtotal</th>
                                            </tr>
                                            <?php  $detalles = unserialize($details['products']);  
                                        foreach($detalles as $prod): 
                                        $cart_total += $prod['ordered_quantity']*$item['selling_price'];
                                    ?>
                                            <tr>
                                                <td>
                                                    <?php  $products = $this->db->get_where('product', array('product_id'=>$prod['product_id']))->result_array();
                                            foreach ($products as $product): ?>
                                                    <?php echo $product['code'].' - '.$product['name']?>
                                                    <?php endforeach;  ?>
                                                </td>
                                                <td>
                                                    <?php echo $prod['amount'].' '.$this->crud_model->pluralizar($prod['amount'],$this->db->get_where('unity',array('code'=>$prod['unity']))->row()->name); ?>
                                                </td>
                                                <td>
                                                    <?php echo $currency.number_format($prod['subtotal'],2,'.',','); ?>
                                                </td>
                                                <td>
                                                    <?php echo $currency.number_format($prod['discount'],2,'.',','); ?>
                                                </td>
                                                <td>
                                                    <?php echo $currency.number_format($prod['total'],2,'.',','); ?>
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="col-sm-12">
                                <hr />
                            </div>


                        </div>

                    </div>
                    <div class="col-sm-12" style="margin-top: 15px;">
                        <div class="order-foot">
                            <div class="row">
                                <div class="col-md-7">
                                    <h5>Nota</h5>
                                    <div class="form-group">
                                        <textarea readonly class="form-control" style="background:#fff;" name="description" rows="7"><?php echo $details['description'];?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <h5 class="order-section-heading">Resumen de la venta</h5>
                                    <div class="order-summary-row">
                                        <div class="order-summary-label">
                                            <span>Método de pago</span>
                                        </div>
                                        <div class="order-summary-value"><?php 
                                        if($details['method'] == 1){
                                            $status .= 'Efectivo';
                                            }
                                            elseif($details['method'] == 3)
                                            {
                                                if($details['type_transfer'] == 'T'){
                                                    $status .= 'Transferencia';
                                                    }
                                                    elseif($details['type_transfer'] == 'T')
                                                    {
                                                    $status.= 'Depósito';
                                                    }
                                                    elseif($details['type_transfer'] == 'C')
                                                    {
                                                    $status.= 'Cheque';
                                                    }
                                                    elseif($details['type_transfer'] == 'Tr')
                                                    {
                                                    $status.= 'Tarjeta';
                                                    }
                                            }elseif($details['method'] == 4){
                                                $status .= 'Crédito';
                                                }
                                            elseif($details['method'] == 0 | $details['method'] == "")
                                            {
                                            $status.= 'n/d';
                                            }
                                            echo $status;
                                        ?></div>
                                    </div>
                                    <div class="order-summary-row as-total">
                                        <div class="order-summary-label"><span>Total</span></div>
                                        <div class="order-summary-value"><?php echo $currency.'. '.number_format($details['total'],'2','.',',');?></div>
                                    </div>
                                </div>
                                <form action="<?php echo base_url();?>doctor/sales/create_special_sale" method="POST">
                                <input type="hidden" name="sale_id" value="<?php echo $details['sale_id'];?>">
                                <div class="col-md-12 row" id="confirmSaleDiv" style="display:none;">
                                  
                                        <div class="col-lg-4 col-md-4 col-ms-12 mb-2">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha de emisión: <span class="text-danger">*</span></label>
                                                <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d');?>" required />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-ms-12 mb-2">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">
                                                    Establecimiento: <span class="text-danger">*</span>
                                                </label>
                                                <select name="institution_id" id="institution_id" class="form-select form-control" required onchange="getDataInstitution()">
                                                    <option value="">Seleccione un establecimiento</option>
                                                    <?php $insts = $this->crud_model->getInstitutionMode();
                                                                foreach ($insts->result_array() as $in):?>
                                                    <option value="<?php echo $in['institution_id'];?>"><?php echo $in['name']." (".$in['afiliation'].")";?></option>
                                                    <?php endforeach;?>
                                                </select>
                                                <small class="text-danger">(Cualquier cambio del registro de sus establecimientos en la SAT, favor de informar para actualización)</small>

                                            </div>
                                        </div>
                                        <input type="hidden" name="regime" id="regime" value="G" />
                                        <div class="col-lg-4 col-md-4 col-ms-12 mb-2">
                                            <h5 class="font-size-14 mt-2">Tipo de Factura: <span class="text-danger">*</span></h5>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-check form-check-right mb-1">
                                                        <input class="form-check-input" type="radio" name="type_invoice" id="type_invoice_1" value="N" checked />
                                                        <label class="form-check-label" for="type_invoice_1">Normal</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-check form-check-right mb-1">
                                                        <input class="form-check-input" type="radio" name="type_invoice" id="type_invoice_2" value="C" />
                                                        <label class="form-check-label" for="type_invoice_2">Cambiaria</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <div class="">
                                                <label for="" class="col-form-label">Método de pago</label>
                                                <select name="method" id="method" class="form-control" onchange="verifyMethod()">
                                                    <option value="1" selected>Efectivo</option>
                                                    <option value="3">Transacción Bancaria</option>
                                                    <option value="4">Crédito</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-2">
                                            <div class="row">

                                                <div class="col-lg-12 mb-2" id="divCash" style="">
                                                    <div class="">
                                                        <label for="cash_id" class="col-form-label">Cuenta de caja</label><br>
                                                        <select name="cash_id" id="cash_id" class="form-control select2-cash" required onchange="checkCash(this.value)">
                                                            <option value="">Seleccione una cuenta</option>
                                                            <?php foreach($cash->result_array() AS $ch): ?>

                                                            <option value="<?php echo $ch['nomenclature_id'];?>"><?php echo $ch['name'].' '.$ch['code'];?></option>
                                                            <?php  endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 mb-2" id="divAccounts" style="display:none;">
                                                    <div class="form-group">
                                                        <label for="bank_account_id" class="col-form-label">Cuenta bancaria</label><br>
                                                        <select name="bank_account_id" id="bank_account_id" class="form-control select2-bank" onchange="checkAccount(this.value)">
                                                            <option value="">Seleccione una cuenta</option>
                                                            <?php foreach($banks->result_array() AS $ct):?>
                                                            <option value="<?php echo $ct['nomenclature_id'];?>"><?php echo $ct['name'].' '.$ct['code'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" id="divTypeTransfer" style="display:none;">
                                                    <h5 class="font-size-14 mt-2 mb-2">Método de transacción</h5>
                                                    <div class="">
                                                        <div class="col-lg-3">
                                                            <div class="form-check form-check-right mb-3">
                                                                <input class="form-check-input" type="radio" name="type_transfer" id="type_transfer_1" value="T" checked />
                                                                <label class="form-check-label" for="type_transfer_1">Transferencia</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-check form-check-right mb-3">
                                                                <input class="form-check-input" type="radio" name="type_transfer" id="type_transfer_2" value="C" />
                                                                <label class="form-check-label" for="type_transfer_2">Cheque</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-check form-check-right mb-3">
                                                                <input class="form-check-input" type="radio" name="type_transfer" id="type_transfer_3" value="D" />
                                                                <label class="form-check-label" for="type_transfer_3">Depósito</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-check form-check-right mb-3">
                                                                <input class="form-check-input" type="radio" name="type_transfer" id="type_transfer_4" value="Tr" />
                                                                <label class="form-check-label" for="type_transfer_4">Tarjeta</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12" id="fact">
                                                            <div class="form-group m-b-15">
                                                                <label for="simpleinput">No. referencia</label></label>
                                                                <div class="form-group">
                                                                    <input type="text" name="reference_code" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12" id="fact2">
                                                            <div class="form-group m-b-15">
                                                                <label for="simpleinput">Subir imagen</label>
                                                                <label class="labelx" for="apply2"><input type="file" name="reference_file" class="inputx" id="apply2" accept="image/*,.pdf">Seleccionar</label>
                                                                <small id="fileResponse2"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" id="divDays" style="display:none;">
                                                    <div class="form-group">
                                                        <label for="bank_account_id" class="col-form-label">Dias</label>
                                                        <input type="number" class="form-control" name="days" id="days" value="0" step="1" min="0" oninput="verifyCredit()" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit" >Confirmar venta</button>
                                </div>
                                </div>
                                <div class="col-md-12">
                                
                                </div>
                                
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ecommerce-customer-info">
                <h5 style="color:#43485c">Detalles del paciente</h5>
                <hr>
                <div class="ecommerce-customer-main-info">
                    <div class="ecc-avatar" style="background-image: url(<?php echo $this->accounts_model->get_photo('CF',$details['patient_id']);?>)"></div>
                    <div class="ecc-name">
                        <?php echo  $details['name'] ;?>
                    </div>
                </div>
                <div class="ecommerce-customer-sub-info">
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Correo
                        </div>
                        <div class="sub-info-value">
                            <?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->email;?>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Celular
                        </div>
                        <div class="sub-info-value">

                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Dirección
                        </div>
                        <div class="sub-info-value">
                            <p> <?php echo $details['address'];?></p>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Fecha y hora de la venta
                        </div>
                        <div class="sub-info-value">
                            <span><?php echo $details['date'];?></span>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Responsable de la venta
                        </div>
                        <div class="sub-info-value">
                            <span>
                                <? 
                                        if($details['user_type'] == 'admin')
                                        {
                                            echo $this->accounts_model->gender($details['user_id']);
                                        }
                                    ?>
                                <?php echo $this->accounts_model->short_name($details['user_type'],$details['user_id']);?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>


<script type="text/javascript">
    function confirmSale()
    {
        $('#confirmSaleDiv').css({'display':'flex'});
        $('.confirm').css({'display':'none'});
    }
function send_email(sale_id, element_id2) {
    Swal.fire({
        title: 'Confirmar esta acción',
        text: "Se enviará un correo al paciente con la información de la compra con su receta, si la tuviera. ¿Seguro deseas continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/sale_details/email/" + sale_id + '/' + element_id2;
        }
    })
}
</script>



<script type="text/javascript">
function send_email_sin_receta(sale_id, element_id2) {
    Swal.fire({
        title: 'Confirmar esta acción',
        text: "Se enviará un correo al paciente con la información de la compra. ¿Seguro deseas continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/sale_details/email2/" + sale_id + '/' + element_id2;
        }
    })
}


function verifyMethod() {
    var cash_id = $("#cash_id").val();
    var account_id = $("#bank_account_id").val();
    var val = $("#method").val();
    if (val == 1) {
        $("#divAccounts").hide(300);
        $("#divTypeTransfer").hide(300);
        $("#divDays").hide(300);
        $("#divCash").show(300);
        $("#divTelefono").hide(300);

        $("#cash_id").attr('required', true);
        $("#bank_account_id").attr('required', false);
        $("#days").attr('required', false);

        if (cash_id == '') cash = false;
        else cash = true;
        bank = true;
    } else if (val == 3 || val == 2) {
        $("#divAccounts").show(300);
        $("#divTypeTransfer").show(300);
        $("#divDays").hide(300);
        $("#divCash").hide(300);
        $("#divTelefono").hide(300);

        $("#cash_id").attr('required', false);
        $("#bank_account_id").attr('required', true);
        $("#days").attr('required', false);

        if (account_id == '') bank = false;
        else bank = true;
        cash = true;
    } else if (val == 4) {
        $("#divAccounts").hide(300);
        $("#divTypeTransfer").hide(300);
        $("#divDays").show(300);
        $("#divCash").hide(300);
        $("#divTelefono").show(300);
        bank = true;
        cash = true;

        $("#cash_id").attr('required', false);
        $("#bank_account_id").attr('required', false);
        $("#days").attr('required', true);

    } else {
        $("#divAccounts").hide(300);
        $("#divTypeTransfer").hide(300);
        $("#divDays").hide(300);
        $("#divCash").hide(300);
        $("#divTelefono").hide(300);
        bank = true;
        cash = true;


    }

    if (val != 4) $("#type_invoice_1").prop("checked", true);
    else $("#type_invoice_2").prop("checked", true);
    verifyCredit();
}

function show_response(variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>doctor/sales_order_entry_response/' + variant_id,
        success: function(response) {
            jQuery('#sales_order_entry_1').html(response);
        }
    });
}

function append_sales_order_entry() {
    var selected_variants = '';
    $(".variant").each(function() {
        selected_variants += $(this).val() + '.';
        console.log(selected_variants);
    });
    count++;
    $.ajax({
        url: '<?php echo base_url();?>doctor/sales_order_append_entry_response/' + count + '/' + selected_variants,
        success: function(response) {
            jQuery('#sales_order_entry_append').append(response);
        }
    });
}

function deleteParentElement(n) {
    n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    calculate_grand_total();
}

$("input[type='radio'][name='type_id']").change(function() {
    var val = this.value;
    if (val == "NIT") {
        $("#divCUI").hide(300);
        $("#divNIT").show(300);

    } else if (val == "CUI") {
        $("#divNIT").hide(500);
        $("#divCUI").show(300);
    }
    verifyClient();
});

function verifyClient() {
    var type = $('input[name="type_id"]:checked').val();
    if (type == "NIT") {
        var nit = $("#nit").val();
        var val = $.trim(nit.toUpperCase());
        if (nit == '') {
            $("#divConsFinal").hide(300);
            $(".msgClient").text("Debe ingresar el nit del cliente");
            $("#dataClient").hide(500);
            client = false;
            verifyData();
        } else if (val == 'CF' || val == 'C/F' || val == 'C F' || val == 'C /F' || val == 'C/ F') {
            $("#divConsFinal").hide(300);
            $("#client_id").val('0');
            $("#first_name").val("Consumidor");
            $("#last_name").val("Final");
            $("#full_name").val("Consumidor Final");
            $("#phone").val('');
            $("#address").val("Ciudad");
            $("#type_client").val("C");
            client = true;
            verifyTotal();
        } else if (nit == 'CONSUMIDOR FINAL') {
            $("#divConsFinal").show(300);
            setNewClient();
        } else {
            $("#divConsFinal").hide(300);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>doctor/getClientJson/",
                data: {
                    type: type,
                    nit: nit,
                },
                dataType: "json",
                beforeSend: function() {
                    $(".msgClient").text("Buscando...");
                },
                success: function(data) {
                    console.log(data);
                    if (data.results > 0) {
                        client = true;
                        $(".msgClient").text('');
                        $("#first_name").val(data.first_name);
                        $("#last_name").val(data.last_name);
                        $("#full_name").val(data.first_name + ' ' + data.last_name);
                        if (data.exist > 0) {
                            $("#client_id").val(data.client_id);
                            if (data.address != '') {

                                $("#address").val(data.address);
                            }
                            $("#phone").val(data.phone);
                            $("#type_client").val(data.type);
                        } else {
                            $("#client_id").val('N');
                            $("#address").val("Ciudad");
                            $("#phone").val('');
                            $("#type_client").val('C');
                        }
                    } else {
                        client = false;
                        $("#client_id").val('N');
                        $("#first_name").val('');
                        $("#last_name").val('');
                        $("#full_name").val('');
                        $("#address").val('');
                        $("#phone").val('');
                        $("#type_client").val('C');
                        $(".msgClient").text("No se ha encontrado el nit");
                    }

                    verifyData();
                },
                error: function(e) {
                    console.log("Error: ", e);
                    client = false;
                    $(".msgClient").text("Error al buscar los datos del cliente");
                    $("#dataClient").hide(500);
                    verifyData();
                }
            });
        }
    } else if (type == "CUI") {
        $("#divConsFinal").hide(300);
        var cui = $("#cui").val();
        var val = $.trim(cui.toUpperCase());
        if (cui == '') {
            $(".msgClient").text("Debe ingresar el cui del cliente");
            $("#dataClient").hide(500);
            client = false;
            verifyData();
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>doctor/getClientJson/",
                data: {
                    type: type,
                    cui: cui,
                },
                dataType: "json",
                beforeSend: function() {
                    $(".msgClient").text("Buscando...");
                },
                success: function(data) {
                    console.log(data);
                    if (data.results > 0) {
                        $("#first_name").val(data.first_name);
                        $("#last_name").val(data.last_name);
                        $("#full_name").val(data.first_name + ' ' + data.last_name);
                        if (data.dead) {
                            client = false;
                            $(".msgClient").text("La persona consultada, falleció");
                        } else {
                            client = true;
                            $(".msgClient").text('');
                            if (data.exist > 0) {
                                $("#client_id").val(data.client_id);
                                if (data.address != '') {
                                    $("#address").val(data.address);
                                }
                                $("#phone").val(data.phone);
                                $("#type_client").val(data.type);
                            } else {
                                $("#client_id").val('N');
                                $("#address").val("Ciudad");
                                $("#phone").val('');
                                $("#type_client").val('C');
                            }
                        }
                    } else {
                        client = false;
                        $("#client_id").val('N');
                        $("#first_name").val('');
                        $("#last_name").val('');
                        $("#full_name").val('');
                        $("#address").val('');
                        $("#phone").val('');
                        $("#type_client").val('C');
                        $(".msgClient").text("No se ha encontrado el cui");
                    }
                    verifyData();
                },
                error: function(e) {
                    console.log("Error: ", e);
                    client = false;
                    $(".msgClient").text("Error al buscar los datos del cliente");
                    $("#dataClient").hide(500);
                    verifyData();
                }
            });
        }
    } else {
        client = false;
        $(".msgClient").text("Debe seleccionar un tipo de identificador del sistema");
        $("#dataClient").hide(500);
        verifyData();
    }
}
</script>