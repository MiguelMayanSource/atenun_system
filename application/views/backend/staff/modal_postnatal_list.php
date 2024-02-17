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
            $dats = $this->db->get('postnatal')->result_array();
            if (count($dats) == 0){
            ?>
    <form id="formPost" action="<?php echo base_url();?>staff/patients/create_postnatal/<?php echo $param2;?>" method="post">
        <?php }
	         else {
            ?>
        <form id="formPost" action="<?php echo base_url();?>staff/patients/update_postnatal/<?php echo $param2;?>" method="post">
            <?php } ?>
            <div class="modal-header" style="background-color:#fff;border-top-right-radius:20px;border-top-left-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> Registrar antecedentes postnatales</span></h4>
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
                                                Detalles del parto
                                            </div>
                                            <div class=" _deny-field-container_oxheyk">
                                                <input data-autoid="deny-field" name="birth_details" value="<?php echo $this->crud_model->check_medical_value($param2,'birth_details','postnatal'); ?>" type="text" id="ember3064" class="_deny-field_oxheyk ember-text-field ember-view">
                                            </div>
                                        </li>
                                        <li id="ember3062" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
                                                Nombre del bebé
                                            </div>
                                            <div class=" _deny-field-container_oxheyk">
                                                <input data-autoid="deny-field" name="baby_name" value="<?php echo $this->crud_model->check_medical_value($param2,'baby_name','postnatal'); ?>" type="text" id="ember3064" class="_deny-field_oxheyk ember-text-field ember-view">
                                            </div>
                                        </li>
                                        <li id="ember3062" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
                                                Peso al nacer
                                            </div>
                                            <div class=" _deny-field-container_oxheyk">
                                                <input data-autoid="deny-field" name="birth_weight" value="<?php echo $this->crud_model->check_medical_value($param2,'birth_weight','postnatal'); ?>" type="text" id="ember3064" class="_deny-field_oxheyk ember-text-field ember-view">
                                            </div>
                                        </li>
                                        <li id="ember3108" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
                                                Salud del bebé
                                            </div>
                                            <div class=" _deny-field-container_oxheyk">
                                                <input data-autoid="deny-field" name="baby_health" value="<?php echo $this->crud_model->check_medical_value($param2,'baby_health','postnatal'); ?>" type="text" id="ember3110" class="_deny-field_oxheyk ember-text-field ember-view">
                                            </div>
                                        </li>
                                        <li class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_glzqhu _record-name_e768m7">Alimentación del bebé</div>
                                            <div>
                                                <input type="radio" value="1" name="baby_feeding" <?php if($this->crud_model->check_medical_value($param2,'baby_feeding','postnatal') == 1) echo "checked"?> class="ember-view">
                                                <span class="radios--input--label">Sólo pecho</span>
                                                <input type="radio" value="2" name="baby_feeding" <?php if($this->crud_model->check_medical_value($param2,'baby_feeding','postnatal') == 2) echo "checked"?> class="ember-view">
                                                <span class="radios--input--label">Sólo fórmula</span>
                                                <input type="radio" value="3" name="baby_feeding" <?php if($this->crud_model->check_medical_value($param2,'baby_feeding','postnatal') == 3) echo "checked"?> class="ember-view">
                                                <span class="radios--input--label">Pecho y fórmula</span>
                                            </div>
                                        </li>
                                        <li id="ember3108" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
                                                Estado emocional
                                            </div>
                                            <div class=" _deny-field-container_oxheyk">
                                                <input data-autoid="deny-field" name="emotional_state" value="<?php echo $this->crud_model->check_medical_value($param2,'emotional_state','postnatal'); ?>" type="text" id="ember3110" class="_deny-field_oxheyk ember-text-field ember-view">
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