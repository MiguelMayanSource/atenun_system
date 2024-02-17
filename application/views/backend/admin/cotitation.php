<?php 
 $cash = $this->crud_model->getNomenCash();
 $banks = $this->crud_model->getAccountsBankNomen();
?>
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link " href="<?php echo base_url();?>admin/sales/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0466_shopping_cart_basket_store_successful"></i></div><span>Ventas</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>admin/new_sale/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0172_structure_menu_submenu_navigation"></i></div> <span>Nueva ventas</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <form action="<?php echo base_url();?>admin/sales/create_sale" method="POST">
        <div class="row">
            <div class="col-md-12">
                <div class="order-box">
                    <div class="order-details-box">
                        <div class="order-main-info">
                            <strong style="font-size:38px;">Formulario de ventas</strong>
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
                        <div class="social-l col-lg-12 col m-b-30">
                            <div class="order-controls">
                                <div class="row">
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
                                    <div class="col-lg-6 col-md-6 col-ms-12 mb-2 row">
                                        <div class="col-lg-6 col-md-6 col-ms-12 mb-2">
                                            <h5 class="font-size-14 mt-2">Tipo de Identificador: <span class="text-danger">*</span></h5>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-check form-check-right mb-1">
                                                        <input class="form-check-input" type="radio" name="type_id" id="type_id_1" value="NIT" checked />
                                                        <label class="form-check-label" for="type_id_1">NIT</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-check form-check-right mb-1">
                                                        <input class="form-check-input" type="radio" name="type_id" id="type_id_2" value="CUI" />
                                                        <label class="form-check-label" for="type_id_2">CUI</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-ms-12 mb-2">
                                            <div class="" id="divNIT">
                                                <div class="col-form-label">NIT:</div>
                                                <input type="text" class="form-control" name="nit" id="nit" value="CF" placeholder="NIT" onblur="verifyClient()" />
                                                <small class="text-danger msgClient"></small>
                                            </div>
                                            <div class="" id="divCUI" style="display:none;">
                                                <div class="col-form-label">CUI:</div>
                                                <input type="text" class="form-control" name="cui" id="cui" value="" placeholder="CUI" onblur="verifyClient()" maxlength="15" />
                                                <small class="text-danger msgClient"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-ms-12 mb-2" style="display:none;" id="divConsFinal">
                                            <div class="">
                                                <div class="col-form-label">CONSUMIDOR FINAL</div>
                                                <select name="" id="final_consumer" class="form-select" onchange="setNewClient()">
                                                    <option value="N" selected>Nuevo</option>
                                                    <?php $final_cons = $this->crud_model->getClientsCF();
                                                                foreach($final_cons->result_array() as $fn):?>
                                                    <option value="<?php echo $fn['client_id'];?>"><?php echo $fn['first_name'].' '.$fn['last_name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="client_id" id="client_id" value="0" />
                                        <input type="hidden" name="type_client" id="type_client" value="C" />
                                        <input type="hidden" name="first_name" id="first_name" value="CONSUMIDOR" />
                                        <input type="hidden" name="last_name" id="last_name" value="FINAL" />
                                        <div class="col-sm-12 mb-2">
                                            <div class="">
                                                <div class="col-form-label">Nombre:</div>
                                                <input type="text" class="form-control" name="full_name" required id="full_name" value="CONSUMIDOR FINAL" placeholder="" oninput="changeFullName()">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-2" id="divTelefono" style="display:none;">
                                            <div class="">
                                                <div class="col-form-label">Teléfono:</div>
                                                <input type="text" class="form-control" name="phone" id="phone" value="" placeholder="" oninput="verifyCredit()" />
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-2">
                                            <div class="">
                                                <div class="col-form-label">Dirección:</div>
                                                <textarea name="address" id="address" rows="1" required class="form-control" placeholder="">Ciudad</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-1" style="display:none;">
                                            <div class="">
                                                <label for="" class="col-form-label">Exento de IVA</label><br>
                                                <input type="checkbox" id="check_exempt" name="exempt" switch="info" value="1" />
                                                <label for="check_exempt" data-on-label="Si" data-off-label="No"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-ms-12 mb-2 row">
                                        <div class="col-lg-6 col-md-6 col-ms-12 mb-2">
                                            <h5 class="font-size-14 mt-2">Tipo de cliente: <span class="text-danger">*</span></h5>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-check form-check-right mb-1">
                                                        <input class="form-check-input" type="radio" name="ctype_id" id="ctype_id_1" value="1" checked />
                                                        <label class="form-check-label" for="ctype_id_1">Atenun</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-check form-check-right mb-1">
                                                        <input class="form-check-input" type="radio" name="ctype_id" id="ctype_id_2" value="2" />
                                                        <label class="form-check-label" for="ctype_id_2">Empresa</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-check form-check-right mb-1">
                                                        <input class="form-check-input" type="radio" name="ctype_id" id="ctype_id_2" value="3" />
                                                        <label class="form-check-label" for="ctype_id_2">Seguro</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-2">
                                            <div class="">
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
                            </div>
                        </div>
                        <table class="table " id="products">
                            <tr>
                                <td class="col-sm-12 col-md-2 mb-3">
                                    <label class="form-label" for="exampleFormControlSelect9"><b>Categoría:</b></label><span style="color:red">*</span>
                                    <select class="form-control mb3 select2" required name="cat_id[]" onchange="getProducts(this.value,'<?php $_id = uniqid(); echo $_id;?>')" ;>
                                        <option value="">Seleccionar</option>
                                        <option value="0">Todos</option>
                                        <?php  $products = $this->db->get_where('category', array('status'=>1))->result_array();
                                            foreach ($products as $product): ?>
                                        <option value="<?php echo $product['id']; ?>"><?php echo $product['name']?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </td>
                                <td class="col-sm-12 col-md-3 mb-3">
                                    <label class="form-label" for="exampleFormControlSelect9"><b>Producto:</b></label><span style="color:red">*</span>
                                    <select class="form-control mb3 select2" required name="product_id[]" id="prod_<?php echo $_id; ?>" onchange="getPres(this.value,'<?php echo $_id;?>')" ;>
                                        <option value="">Seleccionar</option>
                                    </select>
                                </td>
                                <td class="col-sm-2">
                                    <div class="form-group">
                                        <label> <b>Cantidad</b> </label><span class="text-danger">*</span>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="amount[]" required="" onchange="getSbtotal('<?php echo $_id; ?>')" onKeyUp="getSbtotal('<?php echo $_id; ?>')" id="amount_<?php echo $_id; ?>">
                                            <div class="input-group-append" id="unity_<?php echo $_id; ?>">

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-sm-2">
                                    <div class="form-group">
                                        <label><b> C/U </b></label><span class="text-danger">*</span>
                                        <div class="input-group">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Q</span>
                                            </div>
                                            <input required type="number" step="any" class="form-control" name="subtotal[]" required="" id="sb_<?php echo $_id; ?>" onchange="getSbtotal('<?php echo $_id; ?>')" onKeyUp="getSbtotal('<?php echo $_id; ?>')">
                                        </div>
                                    </div>
                                </td>
                                <td class="col-sm-2">
                                    <div class="form-group">
                                        <label><b>Descuento</b></label>
                                        <div class="input-group">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Q</span>
                                            </div>
                                            <input required type="number" step="any" class="form-control" name="discount[]" required="" id="des_<?php echo $_id; ?>" onchange="getSbtotal('<?php echo $_id; ?>')" onKeyUp="getSbtotal('<?php echo $_id; ?>')">
                                        </div>
                                    </div>
                                </td>
                                <td class="col-sm-1">
                                    <div class="form-group">
                                        <label> <b>Total </b></label>
                                        <br>
                                        <span id="tl_<?php echo $_id; ?>">Q.</span>
                                        <input class="total" type="hidden" id="inputtl_<?php echo $_id; ?>" value="0" name="total[]">
                                    </div>
                                </td>
                                <td class="col-sm-1">

                                </td>
                            </tr>
                        </table>
                        <div class="col-sm-12" style="margin-top: 15px;">
                            <button type="button" class="btn btn-info btn-sm" onclick="addProduct()">Agregar otro producto</button>
                        </div>
                        <div class="col-sm-12" style="margin-top: 15px;display: flex;text-align: right;justify-content: right;">
                            <h3 id="grand_total" class="order-summary-value"><?php echo $currency.number_format($details['charges']+$lab_total,'2','.',',');?></h3>
                        </div>
                        <div class="col-sm-12" style="margin-top: 15px;">
                            <div class="order-foot">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <h5>Nota: </h5>
                                        <div class="form-group">
                                            <textarea class="form-control" name="description" placeholder="Escribe una nota a esta venta..." rows="7"></textarea>
                                        </div>
                                        <button class="btn btn-success" type="submit">Confirmar venta</button>
                                    </div>

                                </div>
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
$('.itemName1').select2();
</script>
<script type="text/javascript">
var count = 1;
$(document).ready(function() {
    document.getElementById('apply2').onchange = function() {
        var filename = this.value.replace(/C:\\fakepath\\/i, '')
        $("#fileResponse2").html('<b>Archivo seleccionado:</b> ' + filename);
    };
})

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
        url: '<?php echo base_url();?>admin/sales_order_entry_response/' + variant_id,
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
        url: '<?php echo base_url();?>admin/sales_order_append_entry_response/' + count + '/' + selected_variants,
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
                url: "<?php echo base_url();?>admin/getClientJson/",
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
                url: "<?php echo base_url();?>admin/getClientJson/",
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

function verifyData() {
    /*var mensaje = '';
    if (stock && credit && bank && cash && sale_type && client && consumer) {
        $("#saveSale").prop("disabled", false);
        $("#saveForm").prop("disabled", false);
        $("#previewSale").prop("disabled", false);
    } else {
        $("#saveSale").prop("disabled", true);
        $("#saveForm").prop("disabled", true);
        $("#previewSale").prop("disabled", true);
    }

    if (stock == false) mensaje += 'En por lo menos uno de los productos no hay suficiente stock para la venta.<br>';
    if (credit == false) mensaje += 'El cliente no puede estar vacio o faltan los datos del cliente para la factura cambiaria o establecer días de crédito.<br>';
    if (bank == false) mensaje += 'Debe seleccionar una cuenta bacaria.<br>';
    if (cash == false) mensaje += 'Debe seleccionar un rubro de caja.<br>';
    if (sale_type == false) mensaje += 'Verifique bien los datos de tipo de venta y visitador.<br>';
    if (client == false) mensaje += 'Cliente no válido.<br>';
    if (consumer == false) mensaje += 'El consumidor final no puede exceder una cantidad mayor a 2500.<br>';

    if (mensaje.length > 0) {
        $("#msgVerifyData").html(mensaje);
    } else {
        $("#msgVerifyData").html('');
    }*/
}

var count = 1;

function getProducts(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_products/' + product_id,
        success: function(response) {
            console.log(response);
            if (response != "")
                jQuery('#prod_' + variant_id).html(response);
            else
                jQuery('#prod_' + variant_id).html('');
        }
    });
}


function getPrice(product_id, variant_id) {

    var price = $('input[name="ctype_id"]:checked').val();
    console.log(price);
    $.ajax({
        url: '<?php echo base_url();?>admin/get_product_price/' + product_id + '/' + price,
        success: function(response) {
            console.log(response);
            jQuery('#sb_' + variant_id).val(response);
            jQuery('#sb_' + variant_id).attr('readonly', true);
            jQuery('#des_' + variant_id).attr('max', response);

        }
    });
}

function getPres(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_product_pres/' + product_id,
        success: function(response) {
            console.log(response);
            if (response != "")
                jQuery('#unity_' + variant_id).html(` <select name = "unity[]" class = "form-control" required = "" >${response} < /select>`);
            else
                jQuery('#unity_' + variant_id).html('');
            getPrice(product_id, variant_id)

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
    <tr>
        <td >
            <select class="form-control mb3 select2" required name="cat_id[]" onchange="getProducts(this.value,'${$id}')" ;>
                <option value="">Seleccionar</option>
                <option value="0">Todos</option>
                <?php  $products = $this->db->get_where('category', array('status'=>1))->result_array();
                    foreach ($products as $product): ?>
                <option value="<?php echo $product['id']; ?>"><?php echo $product['name']?></option>
                <?php endforeach;  ?>
            </select>
        </td>
        <td >
            <select class="form-control mb3 select2" id="prod_${$id}" required name="product_id[]" onchange="getPres(this.value,'${$id}')" ;>
                <option value="">Seleccionar</option>
            </select>
        </td>
        <td >
            <div class="form-group">
                <div class="input-group">
                    <input type="number" step="any" class="form-control" name="amount[]" required="" onchange="getSbtotal('${$id}')" onKeyUp="getSbtotal('${$id}')" id="amount_${$id}">
                    <div class="input-group-append">
                        <select name="unity[]" class="form-control" id="unity_${$id}" required>
                        </select>
                    </div>
                </div>
            </div>
        </td>
        <td >
            <div class="form-group">
                <div class="input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </div>
                    <input required type="number" step="any" class="form-control" name="sbtotal[]" required="" id="sb_${$id}" onchange="getSbtotal('${$id}')" onKeyUp="getSbtotal('${$id}')">
                </div>
            </div>
        </td>
        <td >
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </div>
                    <input required type="number" step="any" class="form-control" name="discount[]" required="" id="des_${$id}" onchange="getSbtotal('${$id}')" onKeyUp="getSbtotal('${$id}')">
                </div>
            </div>
        </td>
        <td class="col-sm-1">
            <div class="form-group">
                <span id="tl_${$id}">Q.</span>
                <input class="total" type="hidden" id="inputtl_${$id}" value="0" name="total[]">
            </div>
        </td>
        <td class="col-sm-1">
            <i onclick="delete_element(this)" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="color:#fd4f57;cursor:pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i>
        </td>
    </tr>
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
    var des = $('#des_' + variant_id).val() || 0;

    var total = (cant * sub) - des;

    $('#tl_' + variant_id).html('Q' + total.toFixed(2));
    $('#inputtl_' + variant_id).val(total.toFixed(2));

    calculate_grand_total();

}

function calculate_grand_total() {
    var total = 0;
    $('.total').each(function() {
        total += parseFloat($(this).val());
    })
    $('#grand_total').html('Q' + total.toFixed(2));
    console.log(total.toFixed(2));


}

function delete_element(obj) {
    $(obj).parent().parent().remove();
}
</script>