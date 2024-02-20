<?php $benefit = $this->db->get_where('membership_benefit',array('membership_benefit_id'=>base64_decode($param2)))->row_array();?>
<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Editar beneficio</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div> 
    <form action="<?php echo base_url();?>admin/membership_details/edit_benefit/<?php echo $param2; ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="membership_id" value="<?php echo base64_decode($param2);?>">
                        <div class="col-md-12 row" id="is_exist">
                            <div class="col-sm-12 col-md-12 mb-3">
                                <label class="form-label" for="exampleFormControlSelect9" ><b>Seleccionar:</b></label><span style="color:red">*</span>
                                <select class="form-control mb3 select2"  name="benefit_type" onchange="typeBenefit(this.value)">
                                    <option value="">Seleccionar</option>
                                    <option value="1" <?php echo $benefit['benefit_type'] == 1 ? 'Selected':''; ?>>Categoria</option>
                                    <option value="2" <?php echo $benefit['benefit_type'] == 2 ? 'Selected':''; ?>>Producto/Servicio</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-3 ">
                                <label class="form-label" for="exampleFormControlSelect9"><b>Categoría:</b></label><span style="color:red">*</span>
                                <select class="form-control mb3 select2" required name="cat_id" onchange="getProducts(this.value,'<?php $_id = uniqid(); echo $_id;?>')" ;>
                                    <option value="">Seleccionar</option>
                                    <option value="0">Todos</option>
                                    <?php  $products = $this->db->get_where('category', array('status'=>1))->result_array();
                                        foreach ($products as $product): ?>
                                    <option value="<?php echo $product['id']; ?>" <?php echo $benefit['category_id'] == $product['id'] ? 'Selected':''; ?>><?php echo $product['name']?></option>
                                    <?php endforeach;  ?>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-3 products" style="display:<?php echo $benefit['benefit_type'] == 2 ? 'block':'none'; ?>">
                                <label class="form-label" for="exampleFormControlSelect9"><b>Producto/Servicio:</b></label><span style="color:red">*</span>
                                <select class="form-control mb3 select2"  name="product_id" id="prod_<?php echo $_id; ?>" onchange="getPres(this.value,'<?php echo $_id;?>')" ;>
                                    <option value="">Seleccionar</option>
                                    <?php  $products = $this->db->get_where('product', array('category_id'=>$benefit['category_id'],'status'=>1))->result_array();
                                        foreach ($products as $product): ?>
                                    <option value="<?php echo $product['product_id']; ?>" <?php echo $benefit['product_id'] == $product['product_id'] ? 'Selected':''; ?>><?php echo $product['name']?></option>
                                    <?php endforeach;  ?>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-3">
                                <label class="form-label" for="exampleFormControlSelect9" ><b>Seleccionar:</b></label><span style="color:red">*</span>
                                <select class="form-control mb3 select2"  name="type_amount" id="type_amount" onchange="typeAmount(this.value)">
                                    <option value="">Seleccionar</option>
                                    <option value="1" <?php echo $benefit['type_amount'] == 1 ? 'Selected':''; ?>>Cantidad</option>
                                    <option value="2" <?php echo $benefit['type_amount'] == 2 ? 'Selected':''; ?>>Porcentaje de descuento</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-3 amount" style="display:none">
                                <div class="form-group">
                                    <label> <b>Cantidad</b> </label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="amount" value="<?= $benefit['amount']; ?>" >
                                        <div class="input-group-append" id="unity_<?php echo $_id; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 mb-3 porcent" style="display:none">
                                <div class="form-group">
                                    <label> <b>Porcentaje</b> </label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="porcent" value="<?= $benefit['porcent']; ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

 
    
    $('#prod_<?= $_id?>').trigger('change');
    $('#type_amount').trigger('change');
    
});

function typeBenefit(type) {
    console.log(type);
   if(type == 1){
        $('.products').hide(500);
   }else
   {
    $('.products').show(500);
   }
}


function typeAmount(type) {
    console.log(type);
   if(type == 1){
        $('.amount').show(500);
        $('.porcent').hide(500);
   }else
   {
        $('.amount').hide(500);
        $('.porcent').show(500);
   }
}


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

function getPres(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_product_pres/' + product_id,
        success: function(response) {
            console.log('opciones '+response);
            if (response !== "")
                jQuery('#unity_' + variant_id).html(` <select name="unity"  id="unity" class = "form-control" required = "" >${response} < /select>`);
            else
                jQuery('#unity_' + variant_id).html('');
        }
    }).done(function(){
        
        $('#unity').val('<?= $benefit['unity']; ?>').change();
    });
}


</script>