<div id="sales_order_entry_<?php echo $count;?>" style="margin-top: 10px;">

    <div class="row">
        <div class="col-md-3" style="width: 100%;">
            <input class="form-control" type="hidden" name="subt[]" id="subt" value="10" />
            <select id="<?php echo $count;?>" class="itemName form-control select2" onchange="show_response_for_append(this.value , <?php echo $count;?>)">
                <option value="">Seleccione</option>
                <?php 
                        $products = $this->db->get('product')->result_array();
                        foreach($products as $row):
                        $stock_quantity = $row['stock'];
                        $selected_variants_array = explode("." , $selected_variants);
                        if(in_array($row['product_id'], $selected_variants_array))
                        continue;
                    ?>
                <option value="<?php echo $row['product_id'];?>" <?php if($stock_quantity == 0) echo 'disabled';?>>
                    <?php echo $this->db->get_where('product' , array('product_id' => $row['product_id']))->row()->name; ?>
                    <?php if($stock_quantity == 0) echo '[' . "Sin existencias" . ']';?> </option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-md-2" style="width: 10%;">
            <input id="" type="text" class="form-control" disabled="disabled">
        </div>
        <div class="col-md-2" style="width: 5%;">
        </div>
        <div class="col-md-2" style="width: 9%;">
            <input id="" type="text" class="form-control" disabled="disabled">
        </div>
        <div class="col-md-2" style="width: 12%;">
            <input id="" type="text" class="form-control" disabled="disabled">
        </div>
        <div class="col-md-1" style="width: 1%;">
            <i class="batch-icon-bin-3" style="color: #676767; cursor: pointer;" onclick="deleteParentElement(this)"></i>
        </div>
    </div>
</div>

</div>
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
$('.itemName').select2();
$('.itemName1').select2();
</script>
<script type="text/javascript">
function show_response_for_append(variant_id, count) {
    $.ajax({
        url: '<?php echo base_url();?>doctor/sales_order_entry_response/' + variant_id + '/' + count,
        success: function(response) {
            jQuery('#sales_order_entry_' + '<?php echo $count;?>').html(response);
            $('#add_entry_button').prop('disabled', false);

        }
    });
}
</script>