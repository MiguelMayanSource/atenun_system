<?php 
    $pedidos = $this->db->get_where('pedidos',array('pedidos_id'=>$pedido_id))->result_array(); 
    foreach ($pedidos as $pedido):

?>
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link  " href="<?php echo base_url();?>admin/inventory/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                        <span>Inventarios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>admin/purchases/">
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

    <form action="<?php echo base_url();?>admin/purchases/update_solicitud/<?php echo $pedido_id; ?>" method="POST">
        <div class="row">
            <div class="col-md-12">
                <div class="order-box">
                    <div class="order-details-box">
                        <div class="order-main-info">
                            <strong style="font-size:28px;">Editar solicitud de compra</strong>
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
                                        <input type="text" class="form-control form-control-sm" name="code" required="" value="<?php echo $pedido['code'];?>">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Fecha</label>
                                        <input type="date" class="form-control form-control-sm" name="date" required value="<?php echo $pedido['date'];?>">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Proveedor</label>
                                        <select class="form-control form-control-sm" style="min-width:100%" name="provider_id" required="">
                                            <option value="">Seleccionar</option>
                                            <?php 
                                                $query = $this->db->get_where('provider', array('status' => '1'))->result_array();
                                                foreach($query as $pat):
                                            ?>
                                            <option value="<?php echo $pat['provider_id'];?>" <?php echo $pat['provider_id']==$pedido['provider_id']?'Selected':'';?>><?php echo $pat['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <hr />
                            </div>
                            <div class="col-sm-12" id="products">
                                <div class="col-sm-12 row">
                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label" for="exampleFormControlSelect9"><b>Producto:</b></label><span style="color:red">*</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label> <b>Unidades</b> </label><span class="text-danger">*</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><b> C/U </b></label><span class="text-danger">*</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label> <b>Total </b></label><span class="text-danger">*</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-ms-12">
                                        -
                                    </div>
                                </div>
                                <?php 
                                $total = 0;
                                    $products = unserialize($pedido['products']);
                                    foreach($products as $prod):
                                ?>
                                <div class="col-sm-12 row">
                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <select class="form-control mb3 select2" required name="product_id[]" onchange="getPres(this.value,'<?php $_id = uniqid(); echo $_id;?>')" ;>
                                            <option value="">Seleccionar</option>
                                            <?php  $products = $this->db->get_where('product', array('type'=>1,'status'=>1))->result_array();
                                            foreach ($products as $product): ?>
                                            <option value="<?php echo $product['product_id']; ?>" <?php echo $product['product_id']==$prod['product_id']?'Selected':'';?>><?php echo $product['code'].' - '.$product['name']?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="number" step="any" value="<?php echo $prod['amount']; ?>" class="form-control" name="amount[]" required="" onchange="getSbtotal('<?php echo $_id; ?>')" onKeyUp="getSbtotal('<?php echo $_id; ?>')" id="amount_<?php echo $_id; ?>">
                                                <div class="input-group-append">
                                                    <select name="unity[]" class="form-control" id="unity_<?php echo $_id; ?>" required>
                                                        <option value="<?php echo $product['unity']; ?>"><?php echo $this->db->get_where('unity',array('code'=>$prod['unity']))->row()->name; ?></option>
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
                                                <input required type="number" step="any" value="<?php echo $prod['subtotal']; ?>" class="form-control" name="subtotal[]" required="" id="sb_<?php echo $_id; ?>" onchange="getSbtotal('<?php echo $_id; ?>')" onKeyUp="getSbtotal('<?php echo $_id; ?>')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <span id="tl_<?php echo $_id; ?>">Q<?php echo $prod['total']; ?></span>
                                            <input type="hidden" id="inputtl_<?php echo $_id; ?>" name="total[]" value="<?php echo $prod['total']; ?>" class="total">
                                            <?php $total += $prod['total']; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-ms-12">
                                        <i onclick="delete_element(this)" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="color:#fd4f57;cursor:pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                        <div class="col-sm-12" style="margin-top: 15px;">
                            <button type="button" class="btn btn-info btn-sm" onclick="addProduct()">Agregar otro producto</button>
                        </div>
                        <div class="col-sm-12" style="margin-top: 15px;display: flex;text-align: right;justify-content: right;">
                            <h3 id="grand_total" class="order-summary-value"><?php echo $currency.number_format($total,'2','.',',');?></h3>
                        </div>
                    </div>
                    <div class="col-sm-12" style="margin-top: 15px;">
                        <div class="order-foot">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <h5>Nota: </h5>
                                    <div class="form-group">
                                        <textarea class="form-control" name="description" placeholder="Escribe una nota a esta venta..." rows="7"><?php echo $prod['note']; ?></textarea>
                                    </div>
                                    <button class="btn btn-success pull-right" type="submit">Guardar</button>
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

function getPres(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_product_pres/' + product_id,
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
                <input type="hidden" id="inputtl_${$id}" value="0" name="total[]" class="total">
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
    calculate_grand_total()

}

function delete_element(obj) {
    $(obj).parent().parent().remove();
    calculate_grand_total()
}

function calculate_grand_total() {
    var total = 0;
    $('.total').each(function() {
        total += parseFloat($(this).val());
    })
    $('#grand_total').html('Q' + total.toFixed(2));
    console.log(total.toFixed(2));


}
</script>
<?php endforeach; ?>