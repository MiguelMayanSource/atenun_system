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
                $dats = $this->db->get('nutriological')->result_array();
                if (count($dats) == 0){
                ?>
	    <form id="formDiet" action="<?php echo base_url();?>admin/patients/create_nutriological/<?php echo $param2;?>" method="post">
	        <?php }
                
                else {
                ?>
	        <form id="formDiet" action="<?php echo base_url();?>admin/patients/update_nutriological/<?php echo $param2;?>" method="post">
	            <?php } ?>
	            <div class="modal-header" style="background-color:#fff;border-top-right-radius:20px;border-top-left-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
	                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> Dieta nutriológica</span></h4>
	                <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
	            </div>
	            <div class="modal-body" style="background-color:#fff; max-height:700px; overflow-y:auto">
	                <div class="form-group">
	                    <div class="container">
	                        <div class="row">
	                            <input type="hidden" name="patient_id" value="<?php echo $param2;?>" />
	                            <div class="col-sm-12">
	                                <div class="_medical-records_1d3apu ember-view">
	                                    <ul data-autoid="medical-records" id="ember3661" class="_medical-record-list-item_1d3apu ember-view">
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">Desayuno</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="breakfast" <?php if($this->crud_model->check_medical_history($param2, 'breakfast','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="breakfast" <?php if($this->crud_model->check_medical_history($param2, 'breakfast','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_1" style="width: 100%;margin-top:12px">
	                                                <textarea name="breakfast_comment" id="breakfast_comment" <?php if($this->crud_model->check_medical_history($param2, 'breakfast','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'breakfast','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">Colación en la mañana</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="snack" <?php if($this->crud_model->check_medical_history($param2, 'snack','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="snack" <?php if($this->crud_model->check_medical_history($param2, 'snack','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_2" style="width: 100%;margin-top:12px">
	                                                <textarea name="snack_comment" id="snack_comment" <?php if($this->crud_model->check_medical_history($param2, 'snack','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'snack','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">Comida</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="food" <?php if($this->crud_model->check_medical_history($param2, 'food','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="food" <?php if($this->crud_model->check_medical_history($param2, 'food','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_3" style="width: 100%;margin-top:12px">
	                                                <textarea name="food_comment" id="food_comment" <?php if($this->crud_model->check_medical_history($param2, 'food','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'food','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">Colación en la tarde</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="snack_afternoon" <?php if($this->crud_model->check_medical_history($param2, 'snack_afternoon','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="snack_afternoon" <?php if($this->crud_model->check_medical_history($param2, 'snack_afternoon','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_4" style="width: 100%;margin-top:12px">
	                                                <textarea name="snack_afternoon_comment" id="snack_afternoon_comment" <?php if($this->crud_model->check_medical_history($param2, 'snack_afternoon','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'snack_afternoon','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">Cena</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="dinner" <?php if($this->crud_model->check_medical_history($param2, 'dinner','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="dinner" <?php if($this->crud_model->check_medical_history($param2, 'dinner','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_5" style="width: 100%;margin-top:12px">
	                                                <textarea name="dinner_comment" id="dinner_comment" <?php if($this->crud_model->check_medical_history($param2, 'dinner','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'dinner','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
	                                                ¿Alimentos preparados en casa?
	                                            </div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="food_home" <?php if($this->crud_model->check_medical_history($param2, 'food_home','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="food_home" <?php if($this->crud_model->check_medical_history($param2, 'food_home','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_6" style="width: 100%;margin-top:12px">
	                                                <textarea name="food_home_comment" id="food_home_comment" <?php if($this->crud_model->check_medical_history($param2, 'food_home','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'food_home','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_glzqhu _record-name_e768m7">
	                                                Nivel de apetito
	                                            </div>
	                                            <div>
	                                                <input type="radio" value="4" name="appetite" <?php if($this->crud_model->check_medical_value($param2,'appetite','nutriological') == 4) echo "checked"?> class="ember-view">
	                                                <span class="radios--input--label">Excesivo</span>
	                                                <input type="radio" value="3" name="appetite" <?php if($this->crud_model->check_medical_value($param2,'appetite','nutriological') == 3) echo "checked"?> class="ember-view">
	                                                <span class="radios--input--label">Bueno</span>
	                                                <input type="radio" value="2" name="appetite" <?php if($this->crud_model->check_medical_value($param2,'appetite','nutriological') == 2) echo "checked"?> class="ember-view">
	                                                <span class="radios--input--label">Regular</span>
	                                                <input type="radio" value="1" name="appetite" <?php if($this->crud_model->check_medical_value($param2,'appetite','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                <span class="radios--input--label">Poco</span>
	                                                <input type="radio" value="5" name="appetite" <?php if($this->crud_model->check_medical_value($param2,'appetite','nutriological') == 5) echo "checked"?> class="ember-view">
	                                                <span class="radios--input--label">Nulo</span>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
	                                                Presencia de hambre-saciedad
	                                            </div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="hunger_satiety" <?php if($this->crud_model->check_medical_history($param2, 'hunger_satiety','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="hunger_satiety" <?php if($this->crud_model->check_medical_history($param2, 'hunger_satiety','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_7" style="width: 100%;margin-top:12px">
	                                                <textarea name="hunger_satiety_comment" id="hunger_satiety_comment" <?php if($this->crud_model->check_medical_history($param2, 'hunger_satiety','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'hunger_satiety','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_glzqhu _record-name_e768m7">Vasos de agua al dia</div>
	                                            <div>
	                                                <input type="radio" value="1" name="glasses" <?php if($this->crud_model->check_medical_value($param2,'glasses','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                <span class="radios--input--label">1 ó menos</span>
	                                                <input type="radio" value="2" name="glasses" <?php if($this->crud_model->check_medical_value($param2,'glasses','nutriological') == 2) echo "checked"?> class="ember-view">
	                                                <span class="radios--input--label">2 a 3</span>
	                                                <input type="radio" value="3" name="glasses" <?php if($this->crud_model->check_medical_value($param2,'glasses','nutriological') == 3) echo "checked"?> class="ember-view">
	                                                <span class="radios--input--label">4 ó mas</span>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
	                                                Preferencias de alimentos
	                                            </div>
	                                            <div class="_deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" name="food_preferences" type="text" <?php if($this->crud_model->check_medical_value($param2,'food_preferences','nutriological') != ""): ?> value="<?php echo $this->crud_model->check_medical_value($param2,'food_preferences','nutriological');?>" <?php endif; ?> class="_deny-field_oxheyk ember-text-field ember-view">
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">Malestares por alimentos</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="food_unrest" <?php if($this->crud_model->check_medical_history($param2, 'food_unrest','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="food_unrest" <?php if($this->crud_model->check_medical_history($param2, 'food_unrest','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_8" style="width: 100%;margin-top:12px">
	                                                <textarea name="food_unrest_comment" id="food_unrest_comment" <?php if($this->crud_model->check_medical_history($param2, 'food_unrest','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'food_unrest','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
	                                                Medicamentos, complementos o suplementos
	                                            </div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="supplements" <?php if($this->crud_model->check_medical_history($param2, 'supplements','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="supplements" <?php if($this->crud_model->check_medical_history($param2, 'supplements','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_9" style="width: 100%;margin-top:12px">
	                                                <textarea name="supplements_comment" id="supplements_comment" <?php if($this->crud_model->check_medical_history($param2, 'supplements','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'supplements','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">Otras dietas realizadas</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="carried_out" <?php if($this->crud_model->check_medical_history($param2, 'carried_out','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="carried_out" <?php if($this->crud_model->check_medical_history($param2, 'carried_out','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_10" style="width: 100%;margin-top:12px">
	                                                <textarea name="carried_out_comment" id="carried_out_comment" <?php if($this->crud_model->check_medical_history($param2, 'carried_out','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'carried_out','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" name="check11" class="_record-name_oxheyk _record-name_e768m7">
	                                                Peso ideal
	                                            </div>
	                                            <div class=" _deny-field-container_oxheyk">
	                                                <input data-autoid="deny-field" type="text" name="ideal_weight" <?php if($this->crud_model->check_medical_value($param2,'ideal_weight','nutriological') != ""): ?>value="<?php echo $this->crud_model->check_medical_value($param2,'ideal_weight','nutriological'); ?>" <?php endif; ?> <class="_deny-field_oxheyk ember-text-field ember-view">
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
	                                                Padecimiento Actual relacionado al peso
	                                            </div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="current_condition" <?php if($this->crud_model->check_medical_history($param2, 'current_condition','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="current_condition" <?php if($this->crud_model->check_medical_history($param2, 'current_condition','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_11" style="width: 100%;margin-top:12px">
	                                                <textarea name="current_condition_comment" id="current_condition_comment" <?php if($this->crud_model->check_medical_history($param2, 'current_condition','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'current_condition','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
	                                                Antecedentes personales relacionados al peso
	                                            </div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="personal_history" <?php if($this->crud_model->check_medical_history($param2, 'personal_history','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="personal_history" <?php if($this->crud_model->check_medical_history($param2, 'personal_history','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_12" style="width: 100%;margin-top:12px">
	                                                <textarea name="personal_history_comment" id="personal_history_comment" <?php if($this->crud_model->check_medical_history($param2, 'personal_history','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'personal_history','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">Consumo de líquidos</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="consumption" <?php if($this->crud_model->check_medical_history($param2, 'consumption','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="consumption" <?php if($this->crud_model->check_medical_history($param2, 'consumption','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_13" style="width: 100%;margin-top:12px">
	                                                <textarea name="consumption_comment" id="consumption_comment" <?php if($this->crud_model->check_medical_history($param2, 'consumption','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'consumption','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
	                                                Educación nutriológica
	                                            </div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="1" name="nutrition_education" <?php if($this->crud_model->check_medical_history($param2, 'nutrition_education','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button  ">
	                                                    <input type="radio" value="0" name="nutrition_education" <?php if($this->crud_model->check_medical_history($param2, 'nutrition_education','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_14" style="width: 100%;margin-top:12px">
	                                                <textarea name="nutrition_education_comment" id="nutrition_education_comment" <?php if($this->crud_model->check_medical_history($param2, 'nutrition_education','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'nutrition_education','nutriological');?></textarea>
	                                            </div>
	                                        </li>
	                                        <li class="_medical-record_1d3apu ember-view">
	                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">Otros</div>
	                                            <div class="_radio-buttons_9k179t">
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="1" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','nutriological') == 1) echo "checked"?> class="ember-view">
	                                                    Si
	                                                </label>
	                                                <label class="ember-radio-button">
	                                                    <input type="radio" value="0" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','nutriological') == 0) echo "checked"?> class="ember-view">
	                                                    No
	                                                </label>
	                                            </div>
	                                            <div id="hide_15" style="width: 100%;margin-top:12px">
	                                                <textarea name="others_comment" id="others_comment" <?php if($this->crud_model->check_medical_history($param2, 'others','nutriological') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2, 'others','nutriological');?></textarea>
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
    <?php if($this->crud_model->check_medical_history($param2, 'breakfast','nutriological') == 0):?>
    $("#hide_1").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'snack','nutriological') == 0):?>
    $("#hide_2").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'food','nutriological') == 0):?>
    $("#hide_3").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'snack_afternoon','nutriological') == 0):?>
    $("#hide_4").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'dinner','nutriological') == 0):?>
    $("#hide_5").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'food_home','nutriological') == 0):?>
    $("#hide_6").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'hunger_satiety','nutriological') == 0):?>
    $("#hide_7").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'food_unrest','nutriological') == 0):?>
    $("#hide_8").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'supplements','nutriological') == 0):?>
    $("#hide_9").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'carried_out','nutriological') == 0):?>
    $("#hide_10").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'current_condition','nutriological') == 0):?>
    $("#hide_11").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'personal_history','nutriological') == 0):?>
    $("#hide_12").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'consumption','nutriological') == 0):?>
    $("#hide_13").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'nutrition_education','nutriological') == 0):?>
    $("#hide_14").hide();
    <?php endif;?>

    <?php if($this->crud_model->check_medical_history($param2, 'others','nutriological') == 0):?>
    $("#hide_15").hide();
    <?php endif;?>


    $("input[name=breakfast]:radio").click(function() {
        if ($('input[name=breakfast]:checked').val() == "0") {
            $('#hide_1').hide();
            $("#breakfast_comment").attr("required", false);
        } else {
            $('#hide_1').show();
            $("#breakfast_comment").attr("required", true);
        }
    });

    $("input[name=snack]:radio").click(function() {
        if ($('input[name=snack]:checked').val() == "0") {
            $('#hide_2').hide();
            $("#snack_comment").attr("required", false);
        } else {
            $('#hide_2').show();
            $("#snack_comment").attr("required", true);
        }
    });


    $("input[name=food]:radio").click(function() {
        if ($('input[name=food]:checked').val() == "0") {
            $('#hide_3').hide();
            $("#food_comment").attr("required", false);
        } else {
            $('#hide_3').show();
            $("#food_comment").attr("required", true);
        }
    });

    $("input[name=snack_afternoon]:radio").click(function() {
        if ($('input[name=snack_afternoon]:checked').val() == "0") {
            $('#hide_4').hide();
            $("#snack_afternoon_comment").attr("required", false);
        } else {
            $('#hide_4').show();
            $("#snack_afternoon_comment").attr("required", true);
        }
    });

    $("input[name=dinner]:radio").click(function() {
        if ($('input[name=dinner]:checked').val() == "0") {
            $('#hide_5').hide();
            $("#dinner_comment").attr("required", false);
        } else {
            $('#hide_5').show();
            $("#dinner_comment").attr("required", true);
        }
    });

    $("input[name=food_home]:radio").click(function() {
        if ($('input[name=food_home]:checked').val() == "0") {
            $('#hide_6').hide();
            $("#food_home_comment").attr("required", false);
        } else {
            $('#hide_6').show();
            $("#food_home_comment").attr("required", true);
        }
    });

    $("input[name=hunger_satiety]:radio").click(function() {
        if ($('input[name=hunger_satiety]:checked').val() == "0") {
            $('#hide_7').hide();
            $("#hunger_satiety_comment").attr("required", false);
        } else {
            $('#hide_7').show();
            $("#hunger_satiety_comment").attr("required", true);
        }
    });

    $("input[name=food_unrest]:radio").click(function() {
        if ($('input[name=food_unrest]:checked').val() == "0") {
            $('#hide_8').hide();
            $("#food_unrest_comment").attr("required", false);
        } else {
            $('#hide_8').show();
            $("#food_unrest_comment").attr("required", true);
        }
    });

    $("input[name=supplements]:radio").click(function() {
        if ($('input[name=supplements]:checked').val() == "0") {
            $('#hide_9').hide();
            $("#supplements_comment").attr("required", false);
        } else {
            $('#hide_9').show();
            $("#supplements_comment").attr("required", true);
        }
    });

    $("input[name=carried_out]:radio").click(function() {
        if ($('input[name=carried_out]:checked').val() == "0") {
            $('#hide_10').hide();
            $("#carried_out_comment").attr("required", false);
        } else {
            $('#hide_10').show();
            $("#carried_out_comment").attr("required", true);
        }
    });

    $("input[name=current_condition]:radio").click(function() {
        if ($('input[name=current_condition]:checked').val() == "0") {
            $('#hide_11').hide();
            $("#current_condition_comment").attr("required", false);
        } else {
            $('#hide_11').show();
            $("#current_condition_comment").attr("required", true);
        }
    });

    $("input[name=personal_history]:radio").click(function() {
        if ($('input[name=personal_history]:checked').val() == "0") {
            $('#hide_12').hide();
            $("#personal_history_comment").attr("required", false);
        } else {
            $('#hide_12').show();
            $("#personal_history_comment").attr("required", true);
        }
    });

    $("input[name=consumption]:radio").click(function() {
        if ($('input[name=consumption]:checked').val() == "0") {
            $('#hide_13').hide();
            $("#consumption_comment").attr("required", false);
        } else {
            $('#hide_13').show();
            $("#consumption_comment").attr("required", true);
        }
    });

    $("input[name=nutrition_education]:radio").click(function() {
        if ($('input[name=nutrition_education]:checked').val() == "0") {
            $('#hide_14').hide();
            $("#nutrition_education_comment").attr("required", false);
        } else {
            $('#hide_14').show();
            $("#nutrition_education_comment").attr("required", true);
        }
    });

    $("input[name=others]:radio").click(function() {
        if ($('input[name=others]:checked').val() == "0") {
            $('#hide_15').hide();
            $("#others_comment").attr("required", false);
        } else {
            $('#hide_15').show();
            $("#others_comment").attr("required", true);
        }
    });

});
	</script>