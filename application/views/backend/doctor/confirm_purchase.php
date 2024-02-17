<?php 
 $cash = $this->crud_model->getNomenCash();
 $brl = $this->crud_model->getAccountByBankName("Banrural");
 $bam = $this->crud_model->getAccountByBankName("BAM");
    $pedidos = $this->db->get_where('pedidos',array('pedidos_id'=>$pedido_id))->result_array(); 
    foreach ($pedidos as $pedido):

?>
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link  " href="<?php echo base_url();?>doctor/inventory/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                        <span>Inventarios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>doctor/purchases/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0101_notes_text_notebook"></i></div>
                        <span>Ordenes de compra</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <form action="<?php echo base_url();?>doctor/purchases/confirm_solicitud/<?php echo $pedido_id; ?>" method="POST">
        <div class="row">
            <div class="col-md-12">
                <div class="order-box">
                    <div class="order-details-box">
                        <div class="order-main-info">
                            <strong style="font-size:28px;">Confirmar orden de compra</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="order-items-table">
                        <style>
                        .dropdown-menu {
                            overflow-y: scroll;
                            max-height: 250px !important;
                        }
                        </style>
                        <link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">
                        <div class="social-l col-lg-12 col m-b-30 row">
                            <div class="order-controls row col-sm-12">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Código de orden</label>
                                        <input type="text" readonly class="form-control form-control-sm" name="code" required="" value="<?php echo $pedido['code'];?>">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Fecha</label>
                                        <input type="date" readonly class="form-control form-control-sm" name="date" required value="<?php echo $pedido['date'];?>">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Proveedor</label>
                                        <input type="text" readonly class="form-control form-control-sm" required value="<?php echo $this->db->get_where('provider',array('provider_id'=>$pedido['provider_id']))->row()->name;?>">
                                        <input type="hidden" readonly class="form-control form-control-sm" name="provider_id" required value="<?php echo $pedido['provider_id'];?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12 mb-2">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">Método de pago</label>
                                                <select name="method" id="method" class="form-control" onchange="verifyMethod()">
                                                    <option value="1" selected>Efectivo</option>
                                                    <option value="3">Transacción Bancaria</option>
                                                    <option value="4">Crédito</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-2">
                                            <div class="row">
                                                <div class="col-lg-12 mb-2" id="divCash" style="">
                                                    <div class="form-group">
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
                                                            <?php foreach($bam->result_array() AS $ct):?>
                                                            <option value="<?php echo $ct['bank_account_id'];?>"><?php echo $ct['name'].' '.$ct['code'];?></option>
                                                            <?php endforeach;?>
                                                            <?php foreach($brl->result_array() AS $ct):?>
                                                            <option value="<?php echo $ct['bank_account_id'];?>"><?php echo $ct['name'].' '.$ct['code'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" id="divTypeTransfer" style="display:none;">
                                                    <h5 class="font-size-14 mt-2 mb-2">Método de transacción</h5>
                                                    <div class="row">
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
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-12" id="fact">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">No. factura/Recibo</label></label>
                                                <div class="form-group">
                                                    <input type="text" name="invoice_code" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12" id="fact2">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Subir imagen</label>
                                                <label class="labelx" for="apply"><input type="file" required name="invoice_file" class="inputx" id="apply" accept="image/*,.pdf">Seleccionar</label>
                                                <small id="fileResponse"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-8" id="products">
                                <table class="table">
                                    <tr>
                                        <th>Fecha de expiración </th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio unitario</th>
                                        <th>Total</th>
                                    </tr>
                                    <?php 
                                        $total = 0 ;
                                        $products = unserialize($pedido['products']);
                                        foreach($products as $prod):
                                            $total += $prod['total'];
                                    ?>

                                    <tr>
                                        <td>
                                            <input type="date" class="form-control" name="date_<?php echo $prod['product_id'];?>">
                                        </td>
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
                                            <?php echo $currency.number_format($prod['total'],2,'.',','); ?>
                                        </td>
                                    </tr>

                                    <?php endforeach; ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <th> Total</th>
                                        <th> <?php echo $currency.number_format($total,2,'.',',') ?></th>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-4" style="margin-top: 15px;">
                                <div class="order-foot">
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <h5>Nota: </h5>
                                            <div class="form-group">
                                                <textarea class="form-control" name="description" placeholder="Escribe una nota a esta venta..." rows="7"><?php echo $prod['note']; ?></textarea>
                                            </div>

                                            <button class="btn btn-success pull-right" type="submit">Confirmar orden</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </form>
</div>
<script src="<?php echo base_url();?>public/assets/search/bootstrap3-typeahead.js"></script>
<script>
$('.select2').select2();
</script>
<script type="text/javascript">
$(document).ready(function() {
    document.getElementById('apply').onchange = function() {
        var filename = this.value.replace(/C:\\fakepath\\/i, '')
        $("#fileResponse").html('<b>Archivo seleccionado:</b> ' + filename);
    };

    document.getElementById('apply2').onchange = function() {
        var filename = this.value.replace(/C:\\fakepath\\/i, '')
        $("#fileResponse2").html('<b>Archivo seleccionado:</b> ' + filename);
    };
});
var count = 1;
$("input[type='radio'][name='type_invoice']").change(function() {
    var val = this.value;
    if (val == 'C') {
        $("#method").val(4);
        $("#divTelefono").show(500);
    } else if (val == 'N') {
        $("#method").val(1);
        $("#divTelefono").hide(500);
    }
    verifyMethod();
});

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

function verifyCredit() {
    var method = $("#method").val();
    if (method == 4) {
        var client_id = $("#client_id").val();
        var full_name = $("#full_name").val();
        var phone = $("#phone").val();
        var days = $("#days").val();
        if (days == '') days = 0;
        if (client_id != '' && full_name != '' && days > 0) credit = true;
        else credit = false;
    } else {
        credit = true;
    }

}

function checkCash(id) {
    var method = $("#method").val();
    if (method == 1 && id != '') cash = true;
    else if (method == 1 && id == '') cash = false;
    else if (method != 1) cash = true;
    verifyData();
}

function checkAccount(id) {
    var method = $("#method").val();
    if (method == 3 && id != '') bank = true;
    else if (method == 3 && id == '') bank = false;
    else if (method != 3) bank = true;
    verifyData();
}


function getPres(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>doctor/get_product_pres/' + product_id,
        success: function(response) {
            jQuery('#unity_' + variant_id).html(response);
        }
    });
}

function generateUniqueId() {
    var timestamp = new Date().valueOf(); // Get the current timestamp as a starting point
    var randomId = Math.random().toString(36).substring(2); // Generate a random string
    var uniqueId = timestamp + "-" + randomId; // Combine the timestamp and random string to create the unique ID
    return uniqueId;
}


function addProduct() {
    $id = generateUniqueId();
    console.log($id);
    $('#products').append(`
    <div class="col-sm-12 row">
        <div class="col-sm-12 col-md-4 mb-3">
            <select class="form-control mb3 select2" data-table="" required name="product_id[]" onchange="getPres(this.value,'${$id}')" ;>
                <option value="">Seleccionar</option>
                <?php  $products = $this->db->get_where('product', array('type'=>1,'status'=>1))->result_array();
                foreach ($products as $product): ?>
                <option value="<?php echo $product['product_id']; ?>" ><?php echo $product['code'].' - '.$product['name']?></option>
                <?php endforeach;  ?>
            </select>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <div class="input-group">
                    <input type="number" step="any" class="form-control" name="amount[]" required="" onchange="getSbtotal('${$id}')" onKeyUp="getSbtotal('${$id}')" id="amount_${$id}">
                    <div class="input-group-append">
                        <select name="unity[]" class="form-control" id="unity_${$id}" required>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <div class="input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </div>
                    <input required type="number" step="any" class="form-control" name="subtotal[]" required="" id="sb_${$id}" onchange="getSbtotal('${$id}')" onKeyUp="getSbtotal('${$id}')">
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <span id="tl_${$id}">Q.</span>
                <input type="hidden" id="inputtl_${$id}" value="0" name="total[]">
            </div>
        </div>
        <div class="col-md-1 col-ms-12">
            <i onclick="delete_element(this)" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="color:#fd4f57;cursor:pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i>
        </div>
    </div>
    `);

    $('.select2').select2();
}

function deleteParentElement(n) {
    n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    calculate_grand_total();
}

function getSbtotal(variant_id) {
    var cant = $('#amount_' + variant_id).val() || 0;
    var sub = $('#sb_' + variant_id).val() || 0;

    var total = cant * sub;

    $('#tl_' + variant_id).html('Q' + total.toFixed(2));
    $('#inputtl_' + variant_id).val(total.toFixed(2));
    console.log(total);

}

function delete_element(obj) {
    $(obj).parent().parent().remove();
}
</script>
<?php endforeach; ?>