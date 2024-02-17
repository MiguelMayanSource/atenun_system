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
        $dats = $this->db->get('record_family')->result_array();
        if (count($dats) == 0){
        ?>
	    <form id="formRF" action="<?php echo base_url();?>staff/patients/create_recordfamily/<?php echo $param2;?>" method="post">
	        <?php }
        
        else {
        ?>
	        <form id="formRF" action="<?php echo base_url();?>staff/patients/update_recordfamily/<?php echo $param2;?>" method="post">
	            <?php } ?>
	            <div class="modal-header" style="background-color:#fff;border-top-right-radius:20px;border-top-left-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
	                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> Registrar antecedentes heredofamiliares</span></h4>
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
	                                            <div class="_record-name_9k179t _record-name_e768m7">Diabetes</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button ">
	                                                    <input type="radio" value="1" name="diabetes" <?php if($this->crud_model->check_medical_history($param2, 'diabetes','record_family') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="diabetes" <?php if($this->crud_model->check_medical_history($param2, 'diabetes','record_family') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_1" style="width: 100%;margin-top:10px">
	                                                <textarea id="diabetes_comment" class="form-control" <?php if($this->crud_model->check_medical_history($param2, 'diabetes','record_family') == 1) echo "required"?> name="diabetes_comment"><?php echo $this->crud_model->check_comment_medical_history($param2, 'diabetes','record_family');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Cardiopatías</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="heart_disease" <?php if($this->crud_model->check_medical_history($param2, 'heart_disease','record_family') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="heart_disease" <?php if($this->crud_model->check_medical_history($param2, 'heart_disease','record_family') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_2" style="width: 100%;margin-top:10px">
	                                                <textarea id="heart_disease_comment" class="form-control" <?php if($this->crud_model->check_medical_history($param2, 'heart_disease','record_family') == 1) echo "required"?> name="heart_disease_comment"><?php echo $this->crud_model->check_comment_medical_history($param2, 'heart_disease','record_family');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Hipertensión Arterial</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="hypertension" <?php if($this->crud_model->check_medical_history($param2, 'hypertension','record_family') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="hypertension" <?php if($this->crud_model->check_medical_history($param2, 'hypertension','record_family') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_3" style="width: 100%;margin-top:10px">
	                                                <textarea id="hypertension_comment" class="form-control" <?php if($this->crud_model->check_medical_history($param2, 'hypertension','record_family') == 1) echo "required"?> name="hypertension_comment"><?php echo $this->crud_model->check_comment_medical_history($param2, 'hypertension','record_family');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Enfermedades Tiroideas</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="thyroid" <?php if($this->crud_model->check_medical_history($param2, 'thyroid','record_family') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="thyroid" <?php if($this->crud_model->check_medical_history($param2, 'thyroid','record_family') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_4" style="width: 100%;margin-top:10px">
	                                                <textarea id="thyroid_comment" class="form-control" <?php if($this->crud_model->check_medical_history($param2, 'thyroid','record_family') == 1) echo "required"?> name="thyroid_comment"><?php echo $this->crud_model->check_comment_medical_history($param2, 'thyroid','record_family');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Otros</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','record_family') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','record_family') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_5" style="width: 100%;margin-top:10px">
	                                                <textarea id="others_comment" class="form-control" <?php if($this->crud_model->check_medical_history($param2, 'others','record_family') == 1) echo "required"?> name="others_comment"><?php echo $this->crud_model->check_comment_medical_history($param2, 'others','record_family');?></textarea>
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
	                <button class="btn btn-warning" style="width:100%;" type="submit">Registrar</button>
	            </div>
	        </form>
	</div>

	<script type="text/javascript">
$(function() {
    <?php if($this->crud_model->check_medical_history($param2, 'diabetes','record_family') == 0):?>
    $("#hide_1").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'heart_disease','record_family') == 0):?>
    $("#hide_2").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'hypertension','record_family') == 0):?>
    $("#hide_3").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'thyroid','record_family') == 0):?>
    $("#hide_4").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'others','record_family') == 0):?>
    $("#hide_5").hide();
    <?php endif;?>

    $("input[name=diabetes]:radio").click(function() {
        if ($('input[name=diabetes]:checked').val() == "0") {
            $('#hide_1').hide();
            $("#diabetes_comment").attr("required", false);
        } else {
            $('#hide_1').show();
            $("#diabetes_comment").attr("required", true);
        }
    });
    $("input[name=heart_disease]:radio").click(function() {
        if ($('input[name=heart_disease]:checked').val() == "0") {
            $('#hide_2').hide();
            $("#heart_disease_comment").attr("required", false);
        } else {
            $('#hide_2').show();
            $("#heart_disease_comment").attr("required", true);
        }
    });
    $("input[name=hypertension]:radio").click(function() {
        if ($('input[name=hypertension]:checked').val() == "0") {
            $('#hide_3').hide();
            $("#hypertension_comment").attr("required", false);
        } else {
            $('#hide_3').show();
            $("#hypertension_comment").attr("required", true);
        }
    });
    $("input[name=thyroid]:radio").click(function() {
        if ($('input[name=thyroid]:checked').val() == "0") {
            $('#hide_4').hide();
            $("#thyroid_comment").attr("required", false);
        } else {
            $('#hide_4').show();
            $("#thyroid_comment").attr("required", true);
        }
    });
    $("input[name=others]:radio").click(function() {
        if ($('input[name=others]:checked').val() == "0") {
            $('#hide_5').hide();
            $("#others_comment").attr("required", false);
        } else {
            $('#hide_5').show();
            $("#others_comment").attr("required", true);
        }
    });
});
	</script>