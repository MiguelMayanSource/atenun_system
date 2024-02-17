	<style>
._medical-records_1d3apu {
    width: 100%;
}

._medical-record-list-item_1d3apu {
    margin: 0;
    padding: 0;
}

.uli {
    list-style-type: none;
    margin-top: 10px;
    padding-left: 0;
}

._medical-record_1d3apu {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 10px;
    align-items: center;
    transition: .2s;
    border-bottom: #edeeef 1px solid;
}

._medical-record_1d3apu>[data-autoid=record-name] {
    max-width: 40%;
}

._record-name_e768m7 {
    font-weight: 600;
    font-size: 14px;
    width: 58%;
}

._medical-record_1d3apu>[data-autoid=record-name]+div {
    width: 50%;
}

._radio-buttons_9k179t {
    vertical-align: middle;
    text-align: right;
}

._medical-record_1d3apu label {
    margin-bottom: 0;
}

.ember-radio-button {
    color: #59636d;
    font-weight: bolder;
}

.ember-radio-button input[type=radio] {
    border-radius: 25px !important;
}

._radio-buttons_9k179t input {
    margin-top: 0;
    vertical-align: bottom;
}

input[type=radio] {
    border: 1px solid #e1eef4;
    border-radius: 50%;
    background-color: #fff;
    width: 16px;
    height: 16px;
}

input[type=radio],
input[type=checkbox] {
    display: inline-block;
    margin-left: 10px;
    cursor: pointer;
    position: relative;
    -webkit-appearance: none;
}

input[type=checkbox],
input[type=radio] {
    margin: 4px 0 0;
    margin-top: 1px\9;
    line-height: normal;
}

input[type=checkbox],
input[type=radio] {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0;
}

.ember-radio-button input[type=radio] {
    border-radius: 25px !important;
}

input[type=radio]:checked {
    border: 1px solid #0176fe;
}

input[type=radio]:active,
input[type=radio]:checked,
input[type=radio]:focus {
    outline: 0;
}

._radio-buttons_9k179t input {
    margin-top: 0;
    vertical-align: bottom;
}

input[type=radio]:checked:after {
    display: block;
    position: relative;
    top: 2px;
    left: 2px;
    border-radius: 50%;
    background-color: #0176fe;
    width: 10px;
    height: 10px;
    content: '';
}
	</style>
	<div class="modal-content animated fadeInDown" style="border-radius:20px;">
	    <?php 
            $this->db->where('patient_id', $param2);
            $dats = $this->db->get('no_pathological')->result_array();
            if (count($dats) == 0){
            ?>
	    <form id="formNoPat" action="<?php echo base_url();?>doctor/patients/create_no_pathological/<?php echo $param2;?>" method="post">
	        <?php }
	         else {
            ?>
	        <form id="formNoPat" action="<?php echo base_url();?>doctor/patients/update_no_pathological/<?php echo $param2;?>" method="post">
	            <?php } ?>
	            <div class="modal-header" style="background-color:#fff;border-top-right-radius:20px;border-top-left-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
	                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> Registrar antecedentes no patológicos</span></h4>
	                <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
	            </div>
	            <div class="modal-body" style="background-color:#fff; max-height:700px; overflow-y:auto">
	                <div class="form-group">
	                    <div class="container">
	                        <div class="row">
	                            <input type="hidden" name="patient_id" value="<?php echo $param2;?>" />
	                            <div class="col-sm-12">
	                                <div class="_medical-records_1d3apu ember-view">
	                                    <ul class="uli _medical-record-list-item_1d3apu ember-view">
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Actividad física</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button ">
	                                                    <input type="radio" value="1" name="activity" <?php if($this->crud_model->check_medical_history($param2, 'activity','no_pathological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="activity" <?php if($this->crud_model->check_medical_history($param2, 'activity','no_pathological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_1" style="width: 100%;margin-top:10px">
	                                                <textarea id="activity_comment" name="activity_comment" <?php if($this->crud_model->check_medical_history($param2, 'activity','no_pathological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'activity','no_pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Tabaquismo</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="smoking" <?php if($this->crud_model->check_medical_history($param2, 'smoking','no_pathological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="smoking" <?php if($this->crud_model->check_medical_history($param2, 'smoking','no_pathological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_2" style="width: 100%;margin-top:10px">
	                                                <textarea id="smoking_comment" class="form-control" <?php if($this->crud_model->check_medical_history($param2, 'smoking','no_pathological') == 1) echo "required"?> name="smoking_comment"><?php echo $this->crud_model->check_comment_medical_history($param2, 'smoking','no_pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Alcoholismo</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="alcoholism" <?php if($this->crud_model->check_medical_history($param2, 'alcoholism','no_pathological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="alcoholism" <?php if($this->crud_model->check_medical_history($param2, 'alcoholism','no_pathological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_3" style="width: 100%;margin-top:10px">
	                                                <textarea id="alcoholism_comment" class="form-control" <?php if($this->crud_model->check_medical_history($param2, 'alcoholism','no_pathological') == 1) echo "required"?> name="alcoholism_comment"><?php echo $this->crud_model->check_comment_medical_history($param2, 'alcoholism','no_pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Uso de otras sustancias (Drogas)</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="drugs" <?php if($this->crud_model->check_medical_history($param2, 'drugs','no_pathological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="drugs" <?php if($this->crud_model->check_medical_history($param2, 'drugs','no_pathological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_4" style="width: 100%;margin-top:10px">
	                                                <textarea id="drugs_comment" class="form-control" <?php if($this->crud_model->check_medical_history($param2, 'drugs','no_pathological') == 1) echo "required"?> name="drugs_comment"><?php echo $this->crud_model->check_comment_medical_history($param2, 'drugs','no_pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Vacuna o Inmunización reciente</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="vaccine" <?php if($this->crud_model->check_medical_history($param2, 'vaccine','no_pathological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="vaccine" <?php if($this->crud_model->check_medical_history($param2, 'vaccine','no_pathological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_5" style="width: 100%;margin-top:10px">
	                                                <textarea id="vaccine_comment" class="form-control" <?php if($this->crud_model->check_medical_history($param2, 'vaccine','no_pathological') == 1) echo "required"?> name="vaccine_comment"><?php echo $this->crud_model->check_comment_medical_history($param2, 'vaccine','no_pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Otros</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','no_pathological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','no_pathological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_6" style="width: 100%;margin-top:10px">
	                                                <textarea id="others_comment" name="others_comment" <?php if($this->crud_model->check_medical_history($param2, 'others','no_pathological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'others','no_pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                    </ul>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="modal-footer" style="text-align:center;">
	                <button class="btn btn-warning" type="submit" style="width:100%;" id="btnEnviar">Registrar</button>
	            </div>
	        </form>
	</div>

	<script type="text/javascript">
$(function() {

    <?php if($this->crud_model->check_medical_history($param2, 'activity','no_pathological') == 0):?>
    $("#hide_1").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'smoking','no_pathological') == 0):?>
    $("#hide_2").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'alcoholism','no_pathological') == 0):?>
    $("#hide_3").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'drugs','no_pathological') == 0):?>
    $("#hide_4").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'vaccine','no_pathological') == 0):?>
    $("#hide_5").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'others','no_pathological') == 0):?>
    $("#hide_6").hide();
    <?php endif;?>

    $("input[name=activity]:radio").click(function() {
        if ($('input[name=activity]:checked').val() == "0") {
            $('#hide_1').hide();
            $("#activity_comment").attr("required", false);

        } else {
            $('#hide_1').show();
            $("#activity_comment").attr("required", true);
        }
    });
    $("input[name=smoking]:radio").click(function() {
        if ($('input[name=smoking]:checked').val() == "0") {
            $('#hide_2').hide();
            $("#smoking_comment").attr("required", false);
        } else {
            $('#hide_2').show();
            $("#smoking_comment").attr("required", true);
        }
    });
    $("input[name=alcoholism]:radio").click(function() {
        if ($('input[name=alcoholism]:checked').val() == "0") {
            $('#hide_3').hide();
            $("#alcoholism_comment").attr("required", false);
        } else {
            $('#hide_3').show();
            $("#alcoholism_comment").attr("required", true);
        }
    });
    $("input[name=drugs]:radio").click(function() {
        if ($('input[name=drugs]:checked').val() == "0") {
            $('#hide_4').hide();
            $("#drugs_comment").attr("required", false);
        } else {
            $('#hide_4').show();
            $("#drugs_comment").attr("required", true);
        }
    });
    $("input[name=vaccine]:radio").click(function() {
        if ($('input[name=vaccine]:checked').val() == "0") {
            $('#hide_5').hide();
            $("#vaccine_comment").attr("required", false);
        } else {
            $('#hide_5').show();
            $("#vaccine_comment").attr("required", true);
        }
    });
    $("input[name=others]:radio").click(function() {
        if ($('input[name=others]:checked').val() == "0") {
            $('#hide_6').hide();
            $("#others_comment").attr("required", false);
        } else {
            $('#hide_6').show();
            $("#others_comment").attr("required", true);
        }
    });

});
	</script>