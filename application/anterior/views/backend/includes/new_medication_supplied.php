<h5 class="panel-content-title">Agregar medicamento</h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-md-12">
        <div class="row" style="overflow-y:auto">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <input type="datetime-local" class="form-control" name="order_date" id="order_date" placeholder="Fecha" value="<?php echo date('Y-m-d\TH:i');?>" onfocus="this.showPicker()">
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="dosis" id="dosis" placeholder="Dosis" value="">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <select class="itemName form-control select2" style="width:100%" name="laboratory_id" id="product_id">
                        <option value="">Seleccionar</option>
                        <?php $products = $this->db->where('type',1)->where('status',1)->get('product')->result_array();
                                    foreach($products as $product): 
                                    ?>
                        <option value="<?php echo $product['product_id'];?>">
                            <?php echo $product['name']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <hr>
        </div>
        <hr>
        <div class="col-sm-12" style="margin-top:10px;">
            <a class="btn btn-danger " style="margin-left:10px;" href="javascript:void(0)" onclick="saveNote(this)">Agregar</a>
        </div>
    </div>
</div>
<script>
function saveNote(btn) {
    $(btn).html('Guardando.....')
    save_content({
        'table': 'medication_supplied',
        'stabilitation_id': '<?php echo $stabilitation_id; ?>',
        'product_id': $('#product_id').val(),
        'date': $('input[name="order_date"]').val(),
        'dosis': $('input[name="dosis"]').val(),
    });

    load_view('medication_supplied', 'medication_supplied', {
        'stabilitation_id': <?php echo $stabilitation_id?>
    });
}
</script>