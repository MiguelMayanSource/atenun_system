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

input[type=checkbox] {
    border: 1px solid #e1eef4;
    background-color: #fff;
    width: 16px;
    height: 16px;
    vertical-align: -3px;
}

input[type=radio],
input[type=checkbox] {
    display: inline-block;
    margin-left: 10px;
    cursor: pointer;
    position: relative;
    -webkit-appearance: none;
}

input[type=checkbox]:checked:after {
    display: block;
    position: relative;
    top: 2px;
    left: 2px;
    background-color: #0176fe;
    width: 10px;
    height: 10px;
    content: '';
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
        $dats = $this->db->get('vaccination')->result_array();
        if (count($dats) == 0){
        ?>
	    <form id="formVac" action="<?php echo base_url();?>admin/patients/create_vaccination/<?php echo $param2;?>" method="post">
	        <?php }
        
        else {
        ?>
	        <form id="formVac" action="<?php echo base_url();?>admin/patients/update_vaccination/<?php echo $param2;?>" method="post">
	            <?php } ?>

	            <div class="modal-header" style="background-color:#fff;border-top-right-radius:20px;border-top-left-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
	                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> Esquema de vacunación</span></h4>
	                <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
	            </div>
	            <div class="modal-body" style="background-color:#fff; max-height:700px; overflow-y:auto">
	                <div class="form-group">
	                    <div class="container">
	                        <div class="row">
	                            <input type="hidden" name="patient_id" value="<?php echo $param2;?>" />
	                            <div class="col-sm-12">
	                                <div class="_medical-records_1d3apu ember-view">
	                                    <ul data-autoid="medical-records" class="uli _medical-record-list-item_1d3apu ember-view">
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">Nacimiento</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="bcg" <?php if($this->crud_model->check_medical_history($param2, 'bcg','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">BCG</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="hepatitis_b_1" <?php if($this->crud_model->check_medical_history($param2, 'hepatitis_b_1','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">1a Hepatitis B</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">2 meses</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="pentavalente_acelular_1" <?php if($this->crud_model->check_medical_history($param2, 'pentavalente_acelular_1','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">1a Pentavalente Acelular</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="hepatitis_b_2" <?php if($this->crud_model->check_medical_history($param2, 'hepatitis_b_2','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">2a Hepatitis B</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="rotavirus_1" <?php if($this->crud_model->check_medical_history($param2, 'rotavirus_1','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">1a Rotavirus</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="neumococo_1" <?php if($this->crud_model->check_medical_history($param2, 'neumococo_1','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">1a Neumococo</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">4 meses</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="pentavalente_acelular_2" <?php if($this->crud_model->check_medical_history($param2, 'pentavalente_acelular_2','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">2a Pentavalente Acelular</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="rotavirus_2" <?php if($this->crud_model->check_medical_history($param2, 'rotavirus_2','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">2a Rotavirus</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="neumococo_2" <?php if($this->crud_model->check_medical_history($param2, 'neumococo_2','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">2a Neumococo</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">6 meses</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="pentavalente_acelular_3" <?php if($this->crud_model->check_medical_history($param2, 'pentavalente_acelular_3','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">3a Pentavalente Acelular</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="hepatitis_b_3" <?php if($this->crud_model->check_medical_history($param2, 'hepatitis_b_3','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">3a Hepatitis B</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="rotavirus_3" <?php if($this->crud_model->check_medical_history($param2, 'rotavirus_3','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">3a Rotavirus</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="anti_influenza_1" <?php if($this->crud_model->check_medical_history($param2, 'anti_influenza_1','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">1a Anti Influenza (en temporada de frio)</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">7 meses</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="anti_influenza_2" <?php if($this->crud_model->check_medical_history($param2, 'anti_influenza_2','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">2a Anti Influenza (en temporada de frio)</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">12 meses</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="srp_1" <?php if($this->crud_model->check_medical_history($param2, 'srp_1','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">1a SRP</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="neumococo_3" <?php if($this->crud_model->check_medical_history($param2, 'neumococo_3','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">3a Neumococo</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">18 meses</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="pentavalente_acelular_4" <?php if($this->crud_model->check_medical_history($param2, 'pentavalente_acelular_4','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">4a Pentavalente Acelular</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">2 años</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="influenza_refuerzo_anual_2a" <?php if($this->crud_model->check_medical_history($param2, 'influenza_refuerzo_anual_2a','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">Influenza Refuerzo Anual (oct-ene)</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">3 años</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="influenza_refuerzo_anual_3a" <?php if($this->crud_model->check_medical_history($param2, 'influenza_refuerzo_anual_3a','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">Influenza Refuerzo Anual (oct-ene)</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">4 años</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="dpt" <?php if($this->crud_model->check_medical_history($param2, 'dpt','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">DPT</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="influenza_refuerzo_anual_4a" <?php if($this->crud_model->check_medical_history($param2, 'influenza_refuerzo_anual_4a','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">Influenza Refuerzo Anual (oct-ene)</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">5 años</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="influenza_refuerzo_anual_5a" <?php if($this->crud_model->check_medical_history($param2, 'influenza_refuerzo_anual_5a','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">Influenza Refuerzo Anual (oct-ene)</span>
	                                                <br>
	                                                <input type="checkbox" value="1" name="vop" <?php if($this->crud_model->check_medical_history($param2, 'vop','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">VOP/OPV (Sabin, pollo oral) en 1a y 2a Semana Nal. de Salud (después de 2 previas de Pentavalente Acelular)</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">6 años</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="srp_2" <?php if($this->crud_model->check_medical_history($param2, 'srp_2','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">2a SRP</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_106hhk _record-name_e768m7">11 años / 5to primaria</div>
	                                            <div>
	                                                <input type="checkbox" value="1" name="vph" <?php if($this->crud_model->check_medical_history($param2, 'vph','vaccination') == 1) echo "checked";?>>
	                                                <span class="checkboxes--input--label">VPH</span>
	                                                <br>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">Otras Vacunas</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button checked ">
	                                                    <input type="radio" value="1" id="ember3355" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','vaccination') == 1) echo "checked";?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" id="ember3357" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','vaccination') == 0) echo "checked";?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_1" style="width: 100%;margin-top:12px">
	                                                <textarea name="others_comment" <?php if($this->crud_model->check_medical_history($param2, 'others','vaccination') == 1) echo "required";?> id="others_comment" class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'others','vaccination');?></textarea>
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
    <?php if($this->crud_model->check_medical_history($param2, 'others','vaccination') == 0):?>
    $("#hide_1").hide();
    <?php endif;?>


    $("input[name=others]:radio").click(function() {
        if ($('input[name=others]:checked').val() == "0") {
            $('#hide_1').hide();
            $("#others_comment").attr("required", false);
        } else {
            $('#hide_1').show();
            $("#others_comment").attr("required", true);
        }
    });

});
	</script>