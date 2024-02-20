<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Importar productos desde excel</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>admin/inventory_products/product_import/<?php echo  $param2;?>" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <a class="btn btn-info text-white btn-lg" href="<?php echo base_url();?>admin/download_example/Implementos_servicios" style="width:100%;"><i class="picons-thin-icon-thin-0123_download_cloud_file_sync"></i> Descargar formato</a>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="file" name="files" required="">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Importar</button>
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