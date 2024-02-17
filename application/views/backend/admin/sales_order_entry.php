<?php 
    $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
    $variant_info = $this->db->get_where('product' , array('product_id' => $variant_id))->result_array();
    foreach($variant_info as $info):
        
?> 
    <div class="row">
        <div class="col-sm-3" style="width: 100%;">
            <strong><?php echo $this->db->get_where('product' , array('product_id' => $info['product_id']))->row()->name;?></strong>
            <input id="" class="variant" type="hidden" name="variant_id[]" value="<?php echo $info['product_id'];?>">
        </div>
        <div class="col-sm-2" style="width: 10%;">
            <input id="selling_price_<?php echo $count;?>" type="text" class="form-control" name="selling_price[]"
            value="<?php echo $info['price'];?>" onkeyup="calculate_subtotal(<?php echo $count;?>)">
        </div>
        <div class="col-sm-2" style="width: 5%; text-align: center;">
            <strong><?php echo $info['stock'];?></strong>
        </div>
        <div class="col-sm-2" style="width: 9%;">
            <input id="ordered_quantity_<?php echo $count;?>" type="number" class="form-control" name="qty[]" value="1" min="1"
            onchange="calculate_subtotal(<?php echo $count;?>)" onkeyup="calculate_subtotal(<?php echo $count;?>)">
        </div>
        <input id="discount_<?php echo $count;?>" type="hidden" class="form-control" name="discount[]" value="0">
	    <input class="form-control" type="hidden" name="tax_value[]" id="tax_value_<?php echo $count;?>" value="0"/>
        <div class="col-sm-2" style="width: 10%; text-align: center;">
            <strong><?php echo $currency;?>.</strong><strong id="subtotal_<?php echo $count;?>"></strong>
        </div>
        <div class="col-sm-1" style="width: 1%;">
            <i class="batch-icon-bin-3" style="color: #676767; cursor: pointer;" onclick="deleteParentElement(this)"></i>
        </div>
    </div>
 
<?php endforeach;?>

<script type="text/javascript">

        var subtotal = 0;
    function calculate_subtotal(count) {
        selling_price = Number($('#selling_price_' + count).val());
        ordered_quantity = Number($('#ordered_quantity_' + count).val());
        discount_value = Number($('#discount_' + count).val() / 100);
        tax_value = Number($('#tax_value_' + count).val() / 100);
        total = (selling_price * ordered_quantity);
        total_with_discount = total - (total * discount_value);
        subtotal = total_with_discount + (total_with_discount * tax_value);
        subtotal = subtotal.toFixed(2);
        $('#subtotal_' + count).html(subtotal);
         $('#subt_' + count).html(subtotal);
        calculate_grand_total();
    }

    function calculate_grand_total() 
    {
        
        count = '<?php echo $count;?>';
        grand_total = Number( $('#sb_total').html() );
        for(i = 1; i <= count; i++) 
        {
            if ($('#subtotal_'+ i).length) {
                grand_total += Number( $('#subtotal_'+ i).html() );
                
            }
        }
        
        grand_total = grand_total.toFixed(2);
        $('#grand_total').html('<?php echo $currency;?>. '+grand_total);

        
        
    }

    $(document).ready(function() {
        calculate_subtotal(count);
        
        if($.isFunction($.fn.selectBoxIt))
        {
            $("select.itemName").each(function(i, el)
            {
                var $this = $(el),
                    opts = {
                        showFirstOption: attrDefault($this, 'first-option', true),
                        'native': attrDefault($this, 'native', false),
                        defaultText: attrDefault($this, 'text', ''),
                    };
                $this.addClass('visible');
                $this.selectBoxIt(opts);
            });
        }
        
                 $(".as-total").before(function(n){
          return '<div class="order-summary-row">'+
                    '<div class="order-summary-label">'+
                        '<span><?php echo $this->db->get_where('product' , array('product_id' => $info['product_id']))->row()->name;?></span>'+
                   ' </div>'+
                     '<div  id="sb_total" class="order-summary-value" style="display:none"><?php echo '120' ;?></div>'+
                    '<div  class="order-summary-value" id="subt_<?php echo $count;?>"> <?php echo $currency;?>. '+subtotal+'</div>'+
               ' </div>';
        });
    });
</script>