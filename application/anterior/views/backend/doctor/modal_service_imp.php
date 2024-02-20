<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Agregar implementos para prestar el servicio</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>doctor/inventory_products/service_implementos/<?php echo  $param2;?>" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <h3><?php echo $this->db->get_where('product', array('product_id' => $param2))->row()->code.' - '.$this->db->get_where('product', array('product_id' => $param2))->row()->name  ?></h3>
                    <hr>
                    <div class="row" id="products">
                        <?php
                            $this->db->where('service_id', $param2);
                            $products = $this->db->get('service_imp')->result_array();

                            if(count($products) > 0):
                                foreach($products as $row):
                            ?>

                        <div class="col-sm-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label> Cantidad y unidad </label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="amount[]" required="" aria-label="Text input with dropdown button" value="<?php echo $row['amount'];?>">
                                        <div class="input-group-append">
                                            <select name="unity[]" class="form-control">

                                                <optgroup label="Otras">
                                                    <option value="gt" <?php echo $row['unity']== 'gt'?'Selected':'';?>>Goteros</option>
                                                    <option value="am" <?php echo $row['unity']== 'am'?'Selected':'';?>>Ampollas</option>
                                                    <option value="pil" <?php echo $row['unity']== 'pil'?'Selected':'';?>>Pildoras</option>
                                                    <option value="pas" <?php echo $row['unity']== 'pas'?'Selected':'';?>>Pastillas</option>
                                                    <option value="un" <?php echo $row['unity']== 'un'?'Selected':'';?>>Unidades</option>
                                                </optgroup>
                                                <optgroup label="Unidades de Peso">
                                                    <option value="lb" <?php echo $row['unity']== 'lb'?'Selected':'';?>>Libras</option>
                                                    <option value="oz" <?php echo $row['unity']== 'oz'?'Selected':'';?>>Onzas</option>
                                                </optgroup>
                                                <optgroup label="Unidades de Liquidos">
                                                    <option value="ml" <?php echo $row['unity']== 'ml'?'Selected':'';?>>Mililitros</option>
                                                    <option value="lt" <?php echo $row['unity']== 'lt'?'Selected':'';?>>Litros</option>
                                                    <option value="gl" <?php echo $row['unity']== 'gl'?'Selected':'';?>>Galones</option>
                                                </optgroup>
                                                <optgroup label="Unidades de longitud">
                                                    <option value="pl" <?php echo $row['unity']== 'pl'?'Selected':'';?>>pulgadas</option>
                                                    <option value="pie" <?php echo $row['unity']== 'pie'?'Selected':'';?>>pie</option>
                                                    <option value="yd" <?php echo $row['unity']== 'yd'?'Selected':'';?>>Yarda</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5 mb-3">
                                <label class="form-label" for="exampleFormControlSelect9">Producto:</label><span style="color:red">*</span>
                                <select class="form-control mb3 select2" data-table="" required name="product_id[]">
                                    <option value="">Seleccionar</option>
                                    <?php  $products = $this->db->get_where('product', array('type'=>1,'status'=>1))->result_array();
                                    foreach ($products as $product): ?>
                                    <option value="<?php echo $product['product_id']; ?>" <?php echo $product['product_id']==$row['product_id']?'Selected':'';?>><?php echo $product['code'].' - '.$product['name']?></option>
                                    <?php endforeach;  ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-ms-12 mb-3">
                                <label for="codigoProducto" class="form-label">Costo</label><span style="color:red">*</span>
                                <input type="number" class="form-control" name="cost[]" required value="<?php echo $row['cost'];?>">
                            </div>
                            <div class="col-md-1 col-ms-12 mb-3">
                                <br>
                                <i onclick="delete_element(this)" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="font-size:22px;color:#fd4f57;cursor:pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i>
                            </div>
                        </div>
                        <?php
                                endforeach;
                            else:
                        ?>
                        <div class="col-sm-12 row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label> Cantidad y unidad </label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="amount[]" required="" aria-label="Text input with dropdown button" value="<?php echo $row['u_amount'];?>">
                                        <div class="input-group-append">
                                            <select name="unity[]" class="form-control">
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
                            <div class="col-sm-12 col-md-5 mb-3">
                                <label class="form-label" for="exampleFormControlSelect9">Producto:</label><span style="color:red">*</span>
                                <select class="form-control mb3 select2" data-table="" required name="product_id[]">
                                    <option value="">Seleccionar</option>
                                    <?php  $products = $this->db->get_where('product', array('type'=>1,'status'=>1))->result_array();
                                foreach ($products as $product): ?>
                                    <option value="<?php echo $product['product_id']; ?>"><?php echo $product['code'].' - '.$product['name']?></option>
                                    <?php endforeach;  ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-ms-12 mb-3">
                                <label for="codigoProducto" class="form-label">Costo</label><span style="color:red">*</span>
                                <input type="number" class="form-control" name="cost[]" required value="<?php echo $row['code'];?>">
                            </div>
                            <div class="col-md-1 col-ms-12 mb-3">
                                <br>
                                <i onclick="delete_element(this)" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="font-size:22px;color:#fd4f57;cursor:pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i>
                            </div>
                        </div>
                        <?php  endif;?>
                    </div>
                    <div class="col-sm-12 text-right">
                        <a class="btn btn-success " onclick="addProduct()" href="#"><i class="picons-thin-icon-thin-0151_plus_add_new"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Guardar</button>
        </div>
    </form>
</div>
<script>
$(document).ready(function() {
    $('.select2').select2();
})

function delete_element(obj) {
    $(obj).parent().parent().remove();
}


function addProduct() {

    $('#products').append(`
    <div class="col-sm-12 row">
        <div class="col-sm-4">
            <div class="form-group">
                <label> Cantidad y unidad </label><span class="text-danger">*</span>
                <div class="input-group">
                    <input type="number" step="any" class="form-control" name="amount[]" required="" aria-label="Text input with dropdown button" value="<?php echo $row['u_amount'];?>">
                    <div class="input-group-append">
                        <select name="unity[]" class="form-control">
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
        <div class="col-sm-12 col-md-5 mb-3">
            <label class="form-label" for="exampleFormControlSelect9">Producto:</label><span style="color:red">*</span>
            <select class="form-control mb3 select2" data-table="" required name="product_id[]">
                <option value="">Seleccionar</option>
                <?php  $products = $this->db->get_where('product', array('type'=>1,'status'=>1))->result_array();
            foreach ($products as $product): ?>
                <option value="<?php echo $product['product_id']; ?>"><?php echo $product['code'].' - '.$product['name']?></option>
                <?php endforeach;  ?>
            </select>
        </div>
        <div class="col-md-2 col-ms-12 mb-3">
            <label for="codigoProducto" class="form-label">Costo</label><span style="color:red">*</span>
            <input type="number" class="form-control" name="cost[]" required value="<?php echo $row['code'];?>">
        </div>
        <div class="col-md-1 col-ms-12 mb-3">
            <br>
            <i onclick="delete_element(this)" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="font-size:22px;color:#fd4f57;cursor:pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i>
        </div>
    </div>
    `);

    $('.select2').select2();
}
</script>