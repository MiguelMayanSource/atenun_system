<?php
        $this->db->where('product_id', $param2);
        $products = $this->db->get('product')->result_array();
        foreach($products as $row):
    ?>
<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Actualizar producto</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>admin/inventory_products/update_product/<?php echo $row['product_id'];?>" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="inventory_id" value="<?php echo $row['inventory_id']; ?>">
                        <div class="col-sm-12 col-md-6 mb-3">
                            <label class="form-label" for="exampleFormControlSelect9">Catégoria:</label><span style="color:red">*</span>
                            <select class=" mb3 select2" required name="category_id" onchange="getSubcategories(this.value);">
                                <option value="">Seleccionar</option>
                                <?php  $cats = $this->db->get_where('category', array('status'=>1))->result_array();
                                        foreach ($cats as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $row['category_id']? 'selected':'';?>><?php echo $cat['name']?></option>
                                <?php endforeach;  ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-3">
                            <label class="form-label " for="exampleFormControlSelect9">Subcategoría:</label>
                            <select class=" mb3 select2" name="subcategory_id">
                                <option value="">Seleccionar</option>
                                <?php  $sbcats = $this->db->get_where('subcategory', array('status'=>1,'category_id'=>$row['category_id']))->result_array();
                                        foreach ($sbcats as $sbcat): ?>
                                <option value="<?php echo $sbcat['id']; ?>" <?php echo $sbcat['id'] == $row['subcategory_id']? 'selected':'';?>><?php echo $sbcat['name']?></option>
                                <?php endforeach;  ?>
                            </select>
                        </div>
                        <div class="col-md-8 col-ms-12 mb-3">
                            <label for="nombre" class="form-label">Nombre del producto</label><span style="color:red">*</span>
                            <input type="text" class="form-control" name="name" required value="<?php echo $row['name'];?>">
                        </div>
                        <div class="col-md-4 col-ms-12 mb-3">
                            <label for="codigoProducto" class="form-label">Código de producto</label><span style="color:red">*</span>
                            <input type="text" class="form-control" name="code" required value="<?php echo $row['code'];?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="exampleFormControlSelect9">Proveedor:</label><span style="color:red">*</span>
                            <select class="form-control mb3 " name="provider_id">
                                <option value="">Seleccionar</option>
                                <?php 
                                    $provaider = $this->db->get_where('staff',array('status'=>1,'category'=>3))->result_array(); 
                                    foreach($provaider as $rowp):
                                ?>
                                <option value="<?php echo $rowp['staff_id'];?>" <?php echo $rowp['staff_id'] == $row['provider']? 'selected':'';?>><?php echo $rowp['first_name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-6 col-ms-12 mb-3">
                            <label for="expiration" class="form-label">Fecha de expiración</label>
                            <input type="date" class="form-control" name="expiration" value="<?php echo $row['expiration'];?>">
                        </div>
                        <div class="col-md-3 col-ms-12 mb-3">
                            <label for="alert" class="form-label">Cantidad para alertar</label><span style="color:red">*</span>
                            <input type="number" class="form-control" name="alert" required value="<?php echo $row['amount_alert'];?>">
                        </div>
                        <div class="col-md-3 col-ms-12 mb-3">
                            <label for="alert" class="form-label">Puntos de descuento</label><span style="color:red">*</span>
                            <input type="number" class="form-control" name="points" required value="<?php echo $row['points'];?>">
                        </div>
                        <div class="col-md-6 col-ms-12 mb-3">
                            <label for="costo" class="form-label">Costo</label><span style="color:red">*</span>
                            <input type="number" step="any" class="form-control" name="cost" required value="<?php echo $row['cost'];?>">
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label> Kit </label><span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" name="pa_amount" aria-label="Text input with dropdown button" value="<?php echo $row['pa_amount'];?>">
                                    <div class="input-group-append">
                                        <select name="packaging" class="form-control">
                                            <option value="">Seleccionar</option>
                                            <option value="cj">Caja</option>
                                            <option value="fr">Frasco</option>
                                            <option value="gl">Galón</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label> Presentación </label><span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" name="p_amount" aria-label="Text input with dropdown button" value="<?php echo $row['p_amount'];?>">
                                    <div class="input-group-append">
                                        <select name="presentation" class="form-control">
                                            <option value="">Seleccionar</option>
                                            <option value="cj">Caja</option>
                                            <option value="bl">Blisters</option>
                                            <option value="fr">Frascos</option>
                                            <option value="rl">Rollos</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label> Unidades </label><span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" name="u_amount" required="" aria-label="Text input with dropdown button" value="<?php echo $row['u_amount'];?>">
                                    <div class="input-group-append">
                                        <select name="unity" class="form-control">
                                            <optgroup label="Otras">
                                                <option value="gt">Goteros</option>
                                                <option value="am">Ampollas</option>
                                                <option value="pil">Pildoras</option>
                                                <option value="pas">Pastillas</option>
                                                <option value="un">Unidades</option>
                                            </optgroup>
                                            <optgroup label="Unidades de Peso">
                                                <option value="lb">Libras</option>
                                                <option value="oz">Onzas</option>
                                            </optgroup>
                                            <optgroup label="Unidades de Liquidos">
                                                <option value="ml">Mililitros</option>
                                                <option value="lt">Litros</option>
                                                <option value="gl">Galones</option>
                                            </optgroup>
                                            <optgroup label="Unidades de longitud">
                                                <option value="pl">pulgadas</option>
                                                <option value="pie">pie</option>
                                                <option value="yd">Yarda</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Imagen</label>
                            <label class="labelx" for="apply"><input type="file" name="image" class="inputx" id="apply" accept="image/*">Seleccionar</label>
                            <small id="fileResponse"></small>
                        </div>
                    </div>
                    <div class="col-sm-12 row">
                         <div class="col-md-4 col-ms-12 mb-3">
                            <label for="price_1" class="form-label">Precio Atenun(normal)</label><span style="color:red">*</span>
                            <input type="number" step="any" class="form-control" name="price[]" required value="<?php echo $this->db->get_where('product_price',array('product_id'=>$row['product_id'],'insurance_id'=>0))->row()->price;?>">
                            <input type="hidden" name="insurance_id[]" value="0" >
                        </div>
                    </div>
                   
                    <div class="col-sm-12 row" id="prices">
                            <?php $prices = $this->db->get_where('product_price',array('product_id'=>$row['product_id'],'insurance_id !='=>0))->result_array();?>
                            <?php foreach($prices as $price):?>
                            <div class="col-sm-12 row">
                                 <div class="col-md-4 col-ms-12 mb-3">
                                    <label for="price_1" class="form-label">Precio</label><span style="color:red">*</span>
                                    <input type="number" step="any" class="form-control" name="price[]" required value="<?php echo $price['price'];?>">
                                </div>
                                <div class="col-md-4 col-ms-12 mb-3">
                                    <label for="price_2" class="form-label">Establecimiento</label>
                                    <select class="form-control" name="insurance_id[]" required>
                                        <option value="">Seleccionar</option>
                                        <?php $insurances =  $this->db->get_where('insurance',array('status'=>1))->result_array(); ?>
                                        <?php foreach($insurances as $insurance):?>
                                            <option value="<?= $insurance['insurance_id']; ?>" <?php echo $insurance['insurance_id'] == $price['insurance_id']?'Selected':'';?> ><?= $insurance['name']; ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-ms-12 mb-3 pt-4">
                                    <a class="" style="color:red;font-size:20px;" onclick="removePrice(this);"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                </div>
                            </div>
                            <?php endforeach;?>
                    </div>
                    <div class="col-sm-12 row">
                         <div class="col-md-4 col-ms-12 mb-3">
                            <a class="btn btn-info" style="color:white;cursor:pointer;" onclick="addPrice()"><i class="picons-thin-icon-thin-0151_plus_add_new"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Actualizar</button>
        </div>
    </form>
</div>
<script>
document.getElementById('apply').onchange = function() {
    var filename = this.value.replace(/C:\\fakepath\\/i, '')
    $("#fileResponse").html('<b>Archivo seleccionado:</b> ' + filename);
};
$(function() {

    // Busca la opción con valor "valor-a-buscar"
    var opcion = $('select[name="unity"]').find('option[value="<?php echo $row['unity']?>"]');

    // Selecciona la opción encontrada
    opcion.prop('selected', true);

    // Busca la opción con valor "valor-a-buscar"
    var opcion = $('select[name="presentation"]').find('option[value="<?php echo $row['presentation']?>"]');

    // Selecciona la opción encontrada
    opcion.prop('selected', true);

    // Busca la opción con valor "valor-a-buscar"
    var opcion = $('select[name="packaging"]').find('option[value="<?php echo $row['packaging']?>"]');

    // Selecciona la opción encontrada
    opcion.prop('selected', true);



});


$(function() {

    $(".select2").select2({
        width: '100%'
    });

});

function getSubcategories(id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_subcategories/' + id,
        success: function(response) {
            jQuery('select[name="subcategory_id"]').html(response);
            $(".select2").select2({
                width: '100%'
            });
        }
    });
}

function addPrice()
{
    var html = ` <div class="col-sm-12 row">
                         <div class="col-md-4 col-ms-12 mb-3">
                            <label for="price_1" class="form-label">Precio</label><span style="color:red">*</span>
                            <input type="number" step="any" class="form-control" name="price[]" required value="">
                        </div>
                        <div class="col-md-4 col-ms-12 mb-3">
                            <label for="price_2" class="form-label">Establecimiento</label>
                            <select class="form-control" name="insurance_id[]" required>
                                <option value="">Seleccionar</option>
                                <?php $insurances =  $this->db->get_where('insurance',array('status'=>1))->result_array(); ?>
                                <?php foreach($insurances as $insurance):?>
                                    <option value="<?= $insurance['insurance_id']; ?>"><?= $insurance['name']; ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-4 col-ms-12 mb-3 pt-4">
                            <a class="" style="color:red;font-size:20px;" onclick="removePrice(this);"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                        </div>
                    </div>
                `;
                
        $('#prices').append(html);
    
}

function removePrice(element)
{
    
    $(element).parent().parent().remove();
    
}
</script>
<?php endforeach;?>