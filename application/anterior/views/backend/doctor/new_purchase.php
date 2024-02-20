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

    <form action="<?php echo base_url();?>doctor/purchases/create_solicitud" method="POST">
        <div class="row">
            <div class="col-md-12">
                <div class="order-box">
                    <div class="order-details-box">
                        <div class="order-main-info">
                            <strong style="font-size:28px;">Nueva solicitud de compra</strong>
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
                            <div class="order-controls row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Código de orden</label>
                                        <input type="text" class="form-control form-control-sm" name="code" required="">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Fecha</label>
                                        <input type="date" class="form-control form-control-sm" name="date" required value="<?php echo date('Y-m-d');?>">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Proveedor</label>
                                        <select class="form-control form-control-sm" style="min-width:100%" name="provider_id" id="provider_id" required="" onchange="selectProvider(this.value)">
                                            <option value="">Seleccionar</option>
                                            <?php 
                                                $query = $this->db->get_where('provider', array('status' => '1'))->result_array();
                                                foreach($query as $pat):
                                            ?>
                                            <option value="<?php echo $pat['provider_id'];?>"><?php echo $pat['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-ms-12 mb-2">
                                    <h5 class="font-size-14 mt-2">Tipo de orden: <span class="text-danger">*</span></h5>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-check form-check-right mb-1">
                                                <input class="form-check-input" type="radio" name="order_type" id="ctype_id_1" value="1" checked />
                                                <label class="form-check-label" for="ctype_id_1">Productos</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check form-check-right mb-1">
                                                <input class="form-check-input" type="radio" name="order_type" id="ctype_id_2" value="2" />
                                                <label class="form-check-label" for="ctype_id_2">Servicios</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div> <button type="button" class="btn btn-info btn-sm btn-products" style="margin-bottom:10px;display:none" onclick="addProduct()">Agregar otro Producto</button></div>

                            <table class="table " id="products" style="display:none">
                                <tr>

                                    <td class="col-sm-12 col-md-3 mb-3">
                                        <label class="form-label" for="exampleFormControlSelect9"><b>Producto:</b></label><span style="color:red">*</span>

                                    </td>
                                    <td class="col-sm-2">
                                        <div class="form-group">
                                            <label> <b>Cantidad</b> </label><span class="text-danger">*</span>

                                        </div>
                                    </td>
                                    <td class="col-sm-2">
                                        <div class="form-group">
                                            <label><b> C/U </b></label><span class="text-danger">*</span>

                                        </div>
                                    </td>
                                    <td class="col-sm-1">
                                        <div class="form-group">
                                            <label> <b>Total </b></label>
                                            <br>

                                        </div>
                                    </td>
                                    <td class="col-sm-1">

                                    </td>
                                </tr>
                            </table>
                            <div><button type="button" class="btn btn-info btn-sm btn-services" style="margin-bottom:10px; display:none" onclick="addService()">Agregar otro servicio</button></div>

                            <table class="table " id="services_table" style="display:none">
                                <tbody id="services">

                                    <tr>
                                        <th>
                                            Servicio
                                        </th>
                                        <th>
                                            Monto
                                        </th>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12" style="margin-top: 15px;">

                        </div>

                    </div>
                    <div class="col-sm-12" style="margin-top: 15px;">
                        <div class="order-foot">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <h5>Nota: </h5>
                                    <div class="form-group">
                                        <textarea class="form-control" name="description" placeholder="Escribe una nota a esta venta..." rows="7"></textarea>
                                    </div>
                                    <button class="btn btn-success pull-right" type="submit">Confirmar venta</button>
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
var count = 1;

$(document).ready(function() {
    $('input[name="order_type"]').on('click', function() {
        if ($(this).val() == 2) {
            $('#products').hide(300);
            $('#services_table').show(300);
            $('.btn-products').hide(300);
            $('.btn-services').show(300);
        }

        if ($(this).val() == 1) {
            $('#services_table').hide(300);
            $('#products').show(300);
            $('.btn-products').show(300);
            $('.btn-services').hide(300);
        }
    })


})

function selectProvider() {
    $('#products').html('');
    $('#services').html('');
    addProduct();
    addService();

}

function getServicesProvider(provider_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>doctor/get_services_provider/' + provider_id,
        success: function(response) {
            console.log(response);
            if (response != "")
                jQuery('#ser_' + variant_id).html(response);
            else
                jQuery('#ser_' + variant_id).html('');
        }
    });
}




function getProductsProvider(provider_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>doctor/get_products_provider/' + provider_id,
        success: function(response) {
            console.log(response);
            if (response != "")
                jQuery('#prod_' + variant_id).html(response);
            else
                jQuery('#prod_' + variant_id).html('');
        }
    });
}



function getPres(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>doctor/get_product_pres/' + product_id,
        success: function(response) {
            console.log(response);
            if (response != "")
                jQuery('#unity_' + variant_id).html(` <select name = "unity[]" class = "form-control" required = "" >${response} < /select>`);
            else
                jQuery('#unity_' + variant_id).html('');
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
    provider_id = $('#provider_id').val();
    $id = generateUniqueId();
    console.log($id);
    $('#products').append(`
    <tr>
        <td>
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
    getProductsProvider(provider_id, $id)
    $('.select2').select2();
}

function addService() {
    provider_id = $('#provider_id').val();
    $id = generateUniqueId();
    console.log($id);
    $('#services').append(`
    <tr>
        <td >
            <select class="form-control mb3 select2" required name="service_id[]" id="ser_${$id}" >
                <option value="">Seleccionar</option>
            </select>
        </td>
        <td >
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </div>
                    <input required type="number" step="any" class="form-control" name="service_subtotal[]" required="" id="ser_${$id}" onchange="getSbtotal('${$id}')" onKeyUp="getSbtotal('${$id}')">
                </div>
            </div>
        </td>
        <td>
            <i onclick="delete_element(this)" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="color:#fd4f57;cursor:pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i>
        </td>
    </tr>
    `);
    getServicesProvider(provider_id, $id)
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