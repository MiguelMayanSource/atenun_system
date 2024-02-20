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
        $dats = $this->db->get('pathological')->result_array();
        if (count($dats) == 0){
        ?>
	    <form id="formPatholgical" action="<?php echo base_url();?>admin/patients/create_pathological/<?php echo $param2;?>" method="post">
	        <?php }
        
        else {
        ?>
	        <form id="formPatholgical" action="<?php echo base_url();?>admin/patients/update_pathological/<?php echo $param2;?>" method="post">
	            <?php } ?>
	            <div class="modal-header" style="background-color:#fff;border-top-right-radius:20px;border-top-left-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
	                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> Registrar antecedentes patológicos</span></h4>
	                <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
	            </div>

	            <div class="modal-body" style="background-color:#fff; max-height:700px; overflow-y:auto">
	                <div class="form-group">
	                    <div class="container">
	                        <div class="row">
	                            <div class="col-sm-12">
	                                <div class="_medical-records_1d3apu ember-view">
	                                    <ul class="uli _medical-record-list-item_1d3apu ember-view">
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Hospitalización Previa</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <input type="hidden" value="<?php echo $param2;?>" name="patient_id" class="ember-view">
	                                                <label class="ember-radio-button ">
	                                                    <input type="radio" value="1" name="hospitalization" <?php if($this->crud_model->check_medical_history($param2, 'hospitalization','pathological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="hospitalization" <?php if($this->crud_model->check_medical_history($param2, 'hospitalization','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>

	                                            <div id="hide_1" style="width: 100%;margin-top:10px">
	                                                <textarea id="hospitalization_comment" <?php if($this->crud_model->check_medical_history($param2, 'hospitalization','pathological') == 1) echo "required";?> name="hospitalization_comment" class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'hospitalization','pathological');?></textarea>
	                                            </div>

	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Cirugías Previas</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="surgeries" <?php if($this->crud_model->check_medical_history($param2, 'surgeries','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="surgeries" <?php if($this->crud_model->check_medical_history($param2, 'surgeries','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_2" style="width: 100%;margin-top:10px">
	                                                <textarea id="surgeries_comment" name="surgeries_comment" <?php if($this->crud_model->check_medical_history($param2, 'surgeries','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'surgeries','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Diabetes</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="diabetes" <?php if($this->crud_model->check_medical_history($param2, 'diabetes','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="diabetes" <?php if($this->crud_model->check_medical_history($param2, 'diabetes','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_3" style="width: 100%;margin-top:10px">
	                                                <textarea id="diabetes_comment" name="diabetes_comment" <?php if($this->crud_model->check_medical_history($param2, 'diabetes','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'diabetes','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Enfermedades Tiroideas</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="thyroid" <?php if($this->crud_model->check_medical_history($param2, 'thyroid','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="thyroid" <?php if($this->crud_model->check_medical_history($param2, 'thyroid','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_4" style="width: 100%;margin-top:10px">
	                                                <textarea id="thyroid_comment" name="thyroid_comment" <?php if($this->crud_model->check_medical_history($param2, 'thyroid','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'thyroid','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Hipertensión Arterial</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="hypertension" <?php if($this->crud_model->check_medical_history($param2, 'hypertension','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="hypertension" <?php if($this->crud_model->check_medical_history($param2, 'hypertension','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_5" style="width: 100%;margin-top:10px">
	                                                <textarea id="hypertension_comment" <?php if($this->crud_model->check_medical_history($param2, 'hypertension','pathological') == 1) echo "required";?> name="hypertension_comment" class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'hypertension','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Cardiopatias</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="heart_disease" <?php if($this->crud_model->check_medical_history($param2, 'heart_disease','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="heart_disease" <?php if($this->crud_model->check_medical_history($param2, 'heart_disease','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_6" style="width: 100%;margin-top:10px">
	                                                <textarea id="heart_disease_comment" name="heart_disease_comment" <?php if($this->crud_model->check_medical_history($param2, 'heart_disease','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'heart_disease','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Traumatismos</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="trauma" <?php if($this->crud_model->check_medical_history($param2, 'trauma','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="trauma" <?php if($this->crud_model->check_medical_history($param2, 'trauma','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_7" style="width: 100%;margin-top:10px">
	                                                <textarea id="trauma_comment" name="trauma_comment" <?php if($this->crud_model->check_medical_history($param2, 'trauma','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'trauma','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Cáncer</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="cancer" <?php if($this->crud_model->check_medical_history($param2, 'cancer','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="cancer" <?php if($this->crud_model->check_medical_history($param2, 'cancer','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_8" style="width: 100%;margin-top:10px">
	                                                <textarea id="cancer_comment" name="cancer_comment" <?php if($this->crud_model->check_medical_history($param2, 'cancer','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'cancer','pathological'); ?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Tuberculosis</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="tuberculosis" <?php if($this->crud_model->check_medical_history($param2, 'tuberculosis','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="tuberculosis" <?php if($this->crud_model->check_medical_history($param2, 'tuberculosis','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_9" style="width: 100%;margin-top:10px">
	                                                <textarea id="tuberculosis_comment" name="tuberculosis_comment" <?php if($this->crud_model->check_medical_history($param2, 'tuberculosis','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'tuberculosis','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Transfusiones</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="transfusions" <?php if($this->crud_model->check_medical_history($param2, 'transfusions','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="transfusions" <?php if($this->crud_model->check_medical_history($param2, 'transfusions','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_10" style="width: 100%;margin-top:10px">
	                                                <textarea id="transfusions_comment" name="transfusions_comment" <?php if($this->crud_model->check_medical_history($param2, 'transfusions','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'transfusions','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Patologías Respiratorias</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="pathologies" <?php if($this->crud_model->check_medical_history($param2, 'pathologies','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="pathologies" <?php if($this->crud_model->check_medical_history($param2, 'pathologies','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_11" style="width: 100%;margin-top:10px">
	                                                <textarea id="pathologies_comment" name="pathologies_comment" <?php if($this->crud_model->check_medical_history($param2, 'pathologies','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'pathologies','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Patologías Gastrointestinales</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="gastrointestinal" <?php if($this->crud_model->check_medical_history($param2, 'gastrointestinal','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked">
	                                                    <input type="radio" value="0" name="gastrointestinal" <?php if($this->crud_model->check_medical_history($param2, 'gastrointestinal','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_12" style="width: 100%;margin-top:10px">
	                                                <textarea id="gastrointestinal_comment" name="gastrointestinal_comment" <?php if($this->crud_model->check_medical_history($param2, 'gastrointestinal','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'gastrointestinal','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Enfermedades de Transmisión Sexual</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="sexual" <?php if($this->crud_model->check_medical_history($param2, 'sexual','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="sexual" <?php if($this->crud_model->check_medical_history($param2, 'sexual','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_13" style="width: 100%;margin-top:10px">
	                                                <textarea id="sexual_comment" name="sexual_comment" <?php if($this->crud_model->check_medical_history($param2, 'sexual','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'sexual','pathological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div class="_record-name_9k179t _record-name_e768m7">Otros</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','pathological') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="0" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','pathological') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_14" style="width: 100%;margin-top:10px">
	                                                <textarea id="others_comment" name="others_comment" <?php if($this->crud_model->check_medical_history($param2, 'others','pathological') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'others','pathological');?></textarea>
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
	                <button class="btn btn-warning" style="width:100%;" id="btnEnviar" type="submit">Registrar</button>
	            </div>
	        </form>
	</div>

	<script type="text/javascript">
$(function() {
    <?php if($this->crud_model->check_medical_history($param2, 'hospitalization','pathological') == 0):?>
    $("#hide_1").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'surgeries','pathological') == 0):?>
    $("#hide_2").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'diabetes','pathological') == 0):?>
    $("#hide_3").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'thyroid','pathological') == 0):?>
    $("#hide_4").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'hypertension','pathological') == 0):?>
    $("#hide_5").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'heart_disease','pathological') == 0):?>
    $("#hide_6").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'trauma','pathological') == 0):?>
    $("#hide_7").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'cancer','pathological') == 0):?>
    $("#hide_8").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'tuberculosis','pathological') == 0):?>
    $("#hide_9").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'transfusions','pathological') == 0):?>
    $("#hide_10").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'pathologies','pathological') == 0):?>
    $("#hide_11").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'gastrointestinal','pathological') == 0):?>
    $("#hide_12").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'sexual','pathological') == 0):?>
    $("#hide_13").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'others','pathological') == 0):?>
    $("#hide_14").hide();
    <?php endif;?>




    $("input[name=hospitalization]:radio").click(function() {
        if ($('input[name=hospitalization]:checked').val() == "0") {
            $('#hide_1').hide();
            $("#hospitalization_comment").attr("required", false);
        } else {
            $('#hide_1').show();
            $("#hospitalization_comment").attr("required", true);

        }
    });


    $("input[name=surgeries]:radio").click(function() {
        if ($('input[name=surgeries]:checked').val() == "0") {
            $('#hide_2').hide();
            $("#surgeries_comment").attr("required", false);

        } else {
            $('#hide_2').show();
            $("#surgeries_comment").attr("required", true);

        }
    });
    $("input[name=diabetes]:radio").click(function() {
        if ($('input[name=diabetes]:checked').val() == "0") {
            $('#hide_3').hide();
            $("#diabetes_comment").attr("required", false);

        } else {
            $('#hide_3').show();
            $("#diabetes_comment").attr("required", true);

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
    $("input[name=hypertension]:radio").click(function() {
        if ($('input[name=hypertension]:checked').val() == "0") {
            $('#hide_5').hide();
            $("#hypertension_comment").attr("required", false);

        } else {
            $('#hide_5').show();
            $("#hypertension_comment").attr("required", true);

        }
    });
    $("input[name=heart_disease]:radio").click(function() {
        if ($('input[name=heart_disease]:checked').val() == "0") {
            $('#hide_6').hide();
            $("#heart_disease_comment").attr("required", false);

        } else {
            $('#hide_6').show();
            $("#heart_disease_comment").attr("required", true);

        }
    });
    $("input[name=trauma]:radio").click(function() {
        if ($('input[name=trauma]:checked').val() == "0") {
            $('#hide_7').hide();
            $("#trauma_comment").attr("required", false);

        } else {
            $('#hide_7').show();
            $("#trauma_comment").attr("required", true);
        }
    });
    $("input[name=cancer]:radio").click(function() {
        if ($('input[name=cancer]:checked').val() == "0") {
            $('#hide_8').hide();
            $("#cancer_comment").attr("required", false);
        } else {
            $('#hide_8').show();
            $("#cancer_comment").attr("required", true);
        }
    });
    $("input[name=tuberculosis]:radio").click(function() {
        if ($('input[name=tuberculosis]:checked').val() == "0") {
            $('#hide_9').hide();
            $("#tuberculosis_comment").attr("required", false);
        } else {
            $('#hide_9').show();
            $("#tuberculosis_comment").attr("required", true);
        }
    });
    $("input[name=transfusions]:radio").click(function() {
        if ($('input[name=transfusions]:checked').val() == "0") {
            $('#hide_10').hide();
            $("#transfusions_comment").attr("required", false);
        } else {
            $('#hide_10').show();
            $("#transfusions_comment").attr("required", true);
        }
    });
    $("input[name=pathologies]:radio").click(function() {
        if ($('input[name=pathologies]:checked').val() == "0") {
            $('#hide_11').hide();
            $("#pathologies_comment").attr("required", false);
        } else {
            $('#hide_11').show();
            $("#pathologies_comment").attr("required", true);
        }
    });
    $("input[name=gastrointestinal]:radio").click(function() {
        if ($('input[name=gastrointestinal]:checked').val() == "0") {
            $('#hide_12').hide();
            $("#gastrointestinal_comment").attr("required", false);
        } else {
            $('#hide_12').show();
            $("#gastrointestinal_comment").attr("required", true);
        }
    });
    $("input[name=sexual]:radio").click(function() {
        if ($('input[name=sexual]:checked').val() == "0") {
            $('#hide_13').hide();
            $("#sexual_comment").attr("required", false);
        } else {
            $('#hide_13').show();
            $("#sexual_comment").attr("required", true);
        }
    });
    $("input[name=others]:radio").click(function() {
        if ($('input[name=others]:checked').val() == "0") {
            $('#hide_14').hide();
            $("#others_comment").attr("required", false);
        } else {
            $('#hide_14').show();
            $("#others_comment").attr("required", true);
        }
    });

});
	</script>