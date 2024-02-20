<?php 
    $info = $this->db->get_where('pedidos', array('pedidos_id' => $param2))->result_array();
    foreach($info as $row):
        
    if ($row['products'] != "" || $row['products'] != null) {
        $products = unserialize($row['products']);
    } else {
        $products = array();
    }
   
  ?>

<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>staff/solicitudes/update/<?php echo $param2;?>" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                    Agregar nuevo pedido. </span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="background-color:#f1f3f7;">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 row">
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Producto</label>
                                    <input type="text" name="products[]" class="form-control" id="product_modal">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Descripción</label>
                                    <input type="text" name="description[]" class="form-control" id="description_modal">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Cantidad</label>
                                    <input type="number" name="amount[]" class="form-control" id="amount_modal">
                                </div>
                            </div>
                            <div class="col-sm-2 ">
                                <div class="form-group m-b-15">
                                    <br>
                                    <a class="btn btn-info" onclick="addProductModal()" href="javascript:void(0);">+</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="rows_modal">
                        <div class="col-sm-12 row">
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Producto</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Descripción</label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Cantidad</label>
                                </div>
                            </div>
                            <div class="col-sm-2 ">
                                <div class="form-group m-b-15">
                                    <br>
                                </div>
                            </div>
                        </div>
                        <?php 
                        $cont = 0;
                        foreach ($products as $product): 
                        
                        ?>
                        <div class="col-sm-12 row" style="" id="option-<?php echo $cont?>">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="products[]" required="" value="<?php echo $product['product']?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <input type="text" name="description[]" required="" value="<?php echo $product['description']?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="number" name="amount[]" required="" value="<?php echo $product['amount']?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <a style="color:red" class="btn btn-sm  text-center" href="javascript:void(0);" onclick="removeOptionModal('<?php echo $cont++?>')"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer text-right">
            <div>
                <button type="submit" class="button-confirm">Guardar</button>
            </div>
        </div>
    </form>
</div>

<?php endforeach;?>

<script>
function addProductModal() {

    id = Math.floor(Math.random() * 300) + 10;
    product = $('#product_modal').val();
    description = $('#description_modal').val();
    amount = $('#amount_modal').val();
    var html = `<div class="col-sm-12 row" style="" id="option-${id}">
                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="text" name="products[]" required="" value="${product}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group ">
                        <input type="text" name="description[]" required="" value="${description}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <input type="number" name="amount[]" required="" value="${amount}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2" >
                    <a style="color:red" class="btn btn-sm  text-center" href="javascript:void(0);" onclick="removeOptionModal('${id}')"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                </div>
        </div>`;
    $('#product_modal').val('');
    $('#description_modal').val('');
    $('#amount_modal').val('');

    $('#rows_modal').append(html);

}

function removeOptionModal(i) {

    console.log(i);
    $('#option-' + i).remove();

}
</script>