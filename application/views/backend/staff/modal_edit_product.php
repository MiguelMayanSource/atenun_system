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
    <form action="<?php echo base_url();?>staff/inventory_products/update_product/<?php echo $row['product_id'];?>" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="inventory_id" value="<?php echo $row['inventory_id']; ?>">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <label class="form-label" for="exampleFormControlSelect9">Catégoria:</label><span style="color:red">*</span>
                            <select class=" mb3 select2" required name="category_id">
                                <option value="">Seleccionar</option>
                                <?php  $cats = $this->db->get_where('category', array('status'=>1))->result_array();
                                        foreach ($cats as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $row['category_id']? 'selected':'';?>><?php echo $cat['name']?></option>
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

                        <div class="col-md-4 col-ms-12 mb-3">
                            <label for="price_1" class="form-label">Precio 1(Atenun)</label><span style="color:red">*</span>
                            <input type="number" step="any" class="form-control" name="price_1" required value="<?php echo $row['price_1'];?>">
                        </div>
                        <div class="col-md-4 col-ms-12 mb-3">
                            <label for="price_2" class="form-label">Precio 2 (Empresas)</label>
                            <input type="number" step="any" class="form-control" name="price_2" value="<?php echo $row['price_2'];?>">
                        </div>
                        <div class="col-md-4 col-ms-12 mb-3">
                            <label for="price_3" class="form-label">Precio 3 (Seguro)</label>
                            <input type="number" step="any" class="form-control" name="price_3" value="<?php echo $row['price_3'];?>">
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
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Actualizar</button>
        </div>
    </form>
</div>
<script>

document.getElementById('apply').onchange = function () {
   var filename = this.value.replace(/C:\\fakepath\\/i, '')
   $( "#fileResponse" ).html('<b>Archivo seleccionado:</b> '+filename);
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
</script>
<?php endforeach;?>