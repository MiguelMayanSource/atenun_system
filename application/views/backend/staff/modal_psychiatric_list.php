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

._deny-field_oxheyk {
    max-width: 100%;
}

.ember-tooltip-base {
    display: none;
    height: 0;
    width: 0;
    position: absolute;
}

._deny-action_oxheyk:after {
    content: '\F05E';
    font-family: FontAwesome;
    font-size: 20px;
    transition: color .1s ease-in-out;
}

._deny-action_oxheyk {
    width: 30px;
    margin: 0;
    padding: 0;
    border: 0;
    background-color: transparent;
    outline: 0;
}

input {
    border-radius: 0 !important;
    border-bottom: 1px solid #d9e3eb !important;
}

._medical-record_1d3apu>[data-autoid=record-name] {
    max-width: 40%;
}

.input,
input[type=text],
input[type=email],
input[type=tel],
input[type=password],
input[type=number] {
    width: 100%;
    height: 42px;
    padding: 6px 12px;
    border: 1px solid #d9e3eb;
    border-radius: 4px;
    box-shadow: none;
    font: 400 14px/1.4 'Proxima Nova', Helvetica, Arial, sans-serif;
    transition: border-color 150ms ease-in-out, box-shadow 150ms ease-in-out;
}

._record-name_oxheyk {
    width: calc(100% - 35px);
    max-width: none !important;
}

._deny-field-container_oxheyk {
    position: relative;
    display: flex;
    justify-content: space-between;
    width: 100% !important;
    margin: 5px 0;
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
                $dats = $this->db->get('psychiatric')->result_array();
                if (count($dats) == 0){
                ?>
	    <form id="formPs" action="<?php echo base_url();?>staff/patients/create_psychiatric/<?php echo $param2;?>" method="post">
	        <?php }
                
                else {
                ?>
	        <form id="formPs" action="<?php echo base_url();?>staff/patients/update_psychiatric/<?php echo $param2;?>" method="post">
	            <?php } ?>
	            <div class="modal-header" style="background-color:#fff;border-top-right-radius:20px;border-top-left-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
	                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> Registrar antecedentes psiquiátricos</span></h4>
	                <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
	            </div>
	            <div class="modal-body" style="background-color:#fff; max-height:700px; overflow-y:auto">
	                <div class="form-group">
	                    <div class="container">
	                        <div class="row">
	                            <input type="hidden" name="patient_id" value="<?php echo $param2;?>" />
	                            <div class="col-sm-12">
	                                <div class="_medical-records_1d3apu ember-view">
	                                    <ul data-autoid="medical-records" id="ember3060" class="uli _medical-record-list-item_1d3apu ember-view">
	                                        <li id="ember3062" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
	                                                Historia Familiar
	                                            </div>
	                                            <div class=" _deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" name="family_record" value="<?php echo $this->crud_model->check_medical_value($param2,'family_record','psychiatric'); ?>" type="text" id="ember3064" class="_deny-field_oxheyk ember-text-field ember-view">
	                                            </div>
	                                        </li>
	                                        <li id="ember3068" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
	                                                Conciencia de enfermedad
	                                            </div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="disease_awareness" <?php if($this->crud_model->check_medical_history($param2, 'disease_awareness','psychiatric') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="disease_awareness" <?php if($this->crud_model->check_medical_history($param2, 'disease_awareness','psychiatric') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_1" style="width: 100%;margin-top:10px">
	                                                <textarea id="disease_awareness_comment" name="disease_awareness_comment" <?php if($this->crud_model->check_medical_history($param2, 'disease_awareness','psychiatric') == 1) echo "required";?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2,'disease_awareness','psychiatric'); ?></textarea>
	                                            </div>
	                                        </li>
	                                        <li id="ember3076" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
	                                                Áreas afectadas por la enfermedad
	                                            </div>
	                                            <div class=" _deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" name="affected_areas" value="<?php echo $this->crud_model->check_medical_value($param2,'affected_areas','psychiatric','psychiatric'); ?>" type="text" id="ember3078" class="_deny-field_oxheyk ember-text-field ember-view">
	                                            </div>
	                                        </li>
	                                        <li id="ember3082" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
	                                                Tratamientos pasados y actuales
	                                            </div>
	                                            <div class=" _deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" name="past_treatments" value="<?php echo $this->crud_model->check_medical_value($param2,'past_treatments','psychiatric'); ?>" type="text" id="ember3084" class="_deny-field_oxheyk ember-text-field ember-view">
	                                            </div>
	                                        </li>
	                                        <li id="ember3088" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
	                                                Apoyo del grupo familiar o social
	                                            </div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="family_group_social" <?php if($this->crud_model->check_medical_history($param2, 'family_group_social','psychiatric') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="family_group_social" <?php if($this->crud_model->check_medical_history($param2, 'family_group_social','psychiatric') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_2" style="width: 100%;margin-top:10px">
	                                                <textarea id="family_group_social_comment" name="family_group_social_comment" <?php if($this->crud_model->check_medical_history($param2, 'family_group_social','psychiatric') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2,'family_group_social','psychiatric'); ?></textarea>
	                                            </div>
	                                        </li>
	                                        <li id="ember3096" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
	                                                Grupo familiar del paciente
	                                            </div>
	                                            <div class=" _deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" name="family_group" value="<?php echo $this->crud_model->check_medical_value($param2,'family_group','psychiatric'); ?>" type="text" id="ember3098" class="_deny-field_oxheyk ember-text-field ember-view">
	                                            </div>
	                                        </li>
	                                        <li id="ember3102" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
	                                                Aspectos de la vida social
	                                            </div>
	                                            <div class=" _deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" name="aspects_social" value="<?php echo $this->crud_model->check_medical_value($param2,'aspects_social','psychiatric'); ?>" type="text" id="ember3104" class="_deny-field_oxheyk ember-text-field ember-view">
	                                            </div>
	                                        </li>
	                                        <li id="ember3108" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
	                                                Aspectos de la vida laboral
	                                            </div>
	                                            <div class=" _deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" name="aspects_work" value="<?php echo $this->crud_model->check_medical_value($param2,'aspects_work','psychiatric'); ?>" type="text" id="ember3110" class="_deny-field_oxheyk ember-text-field ember-view">
	                                            </div>
	                                        </li>
	                                        <li id="ember3114" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
	                                                Relación con la autoridad
	                                            </div>
	                                            <div class=" _deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" name="authority" value="<?php echo $this->crud_model->check_medical_value($param2,'authority','psychiatric'); ?>" type="text" id="ember3116" class="_deny-field_oxheyk ember-text-field ember-view">
	                                            </div>
	                                        </li>
	                                        <li id="ember3120" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
	                                                Control de Impulsos
	                                            </div>
	                                            <div class=" _deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" name="impulse_control" value="<?php echo $this->crud_model->check_medical_value($param2,'impulse_control','psychiatric'); ?>" type="text" id="ember3122" class="_deny-field_oxheyk ember-text-field ember-view">
	                                            </div>
	                                        </li>
	                                        <li id="ember3126" class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
	                                                Manejo de frustración en su vida
	                                            </div>
	                                            <div class=" _deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" name="frustration" value="<?php echo $this->crud_model->check_medical_value($param2,'frustration','psychiatric'); ?>" type="text" id="ember3128" class="_deny-field_oxheyk ember-text-field ember-view">
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
    <?php if($this->crud_model->check_medical_history($param2, 'disease_awareness','psychiatric') == 0):?>
    $("#hide_1").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'family_group_social','psychiatric') == 0):?>
    $("#hide_2").hide();
    <?php endif;?>


    $("input[name=disease_awareness]:radio").click(function() {
        if ($('input[name=disease_awareness]:checked').val() == "0") {
            $('#hide_1').hide();
            $("#disease_awareness_comment").attr("required", false);
        } else {
            $('#hide_1').show();
            $("#disease_awareness_comment").attr("required", true);
        }
    });
    $("input[name=family_group_social]:radio").click(function() {
        if ($('input[name=family_group_social]:checked').val() == "0") {
            $('#hide_2').hide();
            $("#family_group_social_comment").attr("required", false);
        } else {
            $('#hide_2').show();
            $("#family_group_social_comment").attr("required", true);
        }
    });
});
	</script>