        <link href="<?php echo base_url();?>public/assets/theme/css/select2.min.css" rel="stylesheet" />


        <div class="modal-content animated fadeInDown" style="border-radius:20px;">
            <div class="modal-header" style="background-color:#fff;border-radius:20px;">
                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
                    <span style="vertical-align:-3px">Pieza seleccionada: <b> <?php echo $param2;?></b></span>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-dialog modal-dialog">
                <form action="<?php echo base_url();?>staff/add_tooth/" method="POST">
                    <div class="modal-content animated fadeInDown" style="border-radius:5px; ">
                        <div class="modal-body" style="background-color:#f1f3f7;">
                            <div class="form-group">
                                <div class="container">
                                    <div class="row">
                                        <input name="tooth_id" id="tooth_id" type="hidden" value="<?php echo $param2;?>">
                                        <input name="patient_id" id="patient_id" type="hidden" value="<?php echo $param3;?>">
                                        <input name="treatment_id" id="treatment_id" type="hidden" value="<?php echo $param4;?>">
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Procedimiento:</label>
                                                <select class="form-control js-example-basic-single" name="process[]" multiple="process" id="process">
                                                    <?php 
											 	$this->db->where('status',1);
	                                            $db = $this->db->get('process')->result_array();
	                                            foreach($db as $info):
	                                        ?>
                                                    <option value="<?php echo $info['process_id'];?>"><?php echo $info['name']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="simpleinput">Descripción: </label><br>
                                                <textarea class="form-control" type="text" name="commentary" id="commentary"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="text-align:center;">
                            <center>
                                <button type="submit" class="button-confirm">Agregar</button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>

        <script>
$(function() {
    'use strict'

    if ($(".js-example-basic-single").length) {
        $(".js-example-basic-single").select2();
    }
    if ($(".js-example-basic-multiple").length) {
        $(".js-example-basic-multiple").select2();
    }
});
        </script>