
<div class="modal-dialog modal-dialog-centered modal-lg" id="mymodal">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url();?>admin/entity_category/create" method="POST">
                <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Agregar membrecía</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="container">
                        <div class="row">
                            <p> </p>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Seleccionar membrecía</label><br>
                                    <select class="js-example-basic-single col-12 form-control" name="membership_id" id="secondselect" onchange="getPlans(this.value,'<?php $_id = uniqid(); echo $_id;?>')" style="width: 100%;" >
                                        <option value="seleccionar">Seleccionar</option>
                                        <?php                                                
                                        $insurancess = $this->db->get("membership")->result_array();
                                        foreach($insurancess as $in): ?>
                                            <option value="<?php echo $in['membership_id'];?>"><?php echo $in['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 planes" style="display:none">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Seleccionar Plan</label><br>
                                    <select class="js-example-basic-single col-12 form-control" name="plans_id" id="prod_<?php echo $_id; ?>" onchange="getDetails(this.value,'<?php $_id = uniqid(); echo $_id;?>')" style="width: 100%;" >

                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 detalles" style="display:none">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Detalles del Plan</label><br>
                                    <div id="plansDetails" class="text-black"></label>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button-confirm">Agregar</button>
                </div>
            </form>
        </div>
    </div>

    

<script>

function getPlans(product_id, variant_id) {
        $('.detalles').hide(5);
    if(product_id == "seleccionar"){
        $('.planes').hide(5);
        $('.detalles').hide(5);
   }else
   {
    $('.planes').show(5);
   }

    $.ajax({
        url: '<?php echo base_url();?>admin/get_plans/' + product_id,
        success: function(response) {
            console.log(response);
            if (response != "")
                jQuery('#prod_' + variant_id).html(response);
            else
                jQuery('#prod_' + variant_id).html('');
        }
    });
}

function getDetails(product_id, variant_id) {
    console.log(product_id);
    if(product_id == ""){
        $('.detalles').hide(5);
   }else
   {
    $('.detalles').show(5);
   }

   $.ajax({
        url: '<?php echo base_url();?>admin/get_details/' + product_id,
        success: function(response) {
            console.log(response);
            if (response != "")
                jQuery('#plansDetails').html(response);
            else
                jQuery('#plansDetails').html('');
        }
    });
}

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>