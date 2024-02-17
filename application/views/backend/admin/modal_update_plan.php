<link href="<?php echo base_url();?>public/assets/theme/css/select2.min.css" rel="stylesheet" />

<div class="modal-content animated fadeInDown" style="border-radius:20px;">
    <div class="modal-header" style="background-color:#fff;border-radius:20px;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Pieza seleccionada: <b> <?php echo $param2;?></b></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-dialog modal-dialog">
        <div class="modal-content animated fadeInDown" style="border-radius:5px; ">
            <div class="modal-body" style="background-color:#f1f3f7;">
                <div class="form-group">
                    <div class="container">
                        <div class="row">
                            <input name="tooth_id" id="tooth_id" type="hidden" value="<?php echo $param2;?>">
                            <input name="patient_id" id="patient_id" type="hidden" value="<?php echo $param3;?>">
                            <input name="appointment_id" id="appointment_id" type="hidden" value="<?php echo $param4;?>">
                            <input name="doctor_id" id="doctor_id" type="hidden" value="<?php echo $param5;?>">
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Procedimiento</label>
                                    <select class="form-control js-example-basic-single" name="process[]" multiple="process" id="process">
                                        <option value="">Seleccionar</option>
                                        <?php 
	                                            $db = $this->db->get('process')->result_array();
	                                            foreach($db as $info):
	                                        ?>
                                        <option value="<?php echo $info['process_id'];?>"><?php echo $info['name']?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="simpleinput">Descripcion </label><br>
                                    <textarea class="form-control" type="text" name="commentary" id="commentary"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit_button_tooth" data-dismiss="modal" class="button-confirm">Actualizar</button>
            </div>
        </div>
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

var patient_id = $("#patient_id").val();
<?php 
            if($this-> db-> get_where('treatment', array('patient_id' => $patient_id)) -> num_rows() > 0): ?>
update_tooth_table(patient_id);
<?php endif;?>

var appointment_id = $("#appointment_id").val();
<?php 
        if ($this -> db -> get_where('treatment', array('appointment_id' => $appointment_id)) -> num_rows() > 0): ?>
update_tooth_table(appointment_id);
<?php endif; ?>

$(document).ready(function() {

    $("#submit_button_tooth").click(function() {
        var tooth_id = $("#tooth_id").val();
        var patient_id = $("#patient_id").val();
        var appointment_id = $("#appointment_id").val();
        var doctor_id = $("#doctor_id").val();
        var face = "";
        var process = $("#process").val();
        var diagnosis = "";
        var commentary = $("#commentary").val();



        var d = {
            tooth_id: tooth_id,
            patient_id: patient_id,
            appointment_id: appointment_id,
            doctor_id: doctor_id,
            face: face,
            process: process,
            diagnosis: diagnosis,
            commentary: commentary
        }

        console.log(d);

        if (tooth_id != '' && patient_id != '' && appointment_id != '' && process != '') {
            $.ajax({
                url: "<?php echo base_url();?>admin/tooth/",
                type: 'POST',
                data: d,
                success: function(result) {

                    console.log(result.error);
                    update_tooth_table(appointment_id);
                }
            });

        } else {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000
            });
            Toast.fire({
                type: 'error',
                title: 'Todos los campos son necesarios'
            })
        }
        $("#costos").load(" #costos > *");
    });

});



function update_tooth_table(appointment_id) {
    $.ajax({
        url: '<?php echo base_url(); ?>admin/update_tooth_table/' + appointment_id,
        success: function(response) {
            jQuery('#table_results_tooth').html(response);
        }
    });
}
</script>