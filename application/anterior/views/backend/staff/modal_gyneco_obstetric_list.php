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
    width: 100%;
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
            $dats = $this->db->get('gyneco_obstetrics')->result_array();
            if (count($dats) == 0){
            ?>
    <form id="formGO" action="<?php echo base_url();?>staff/patients/create_obstetric/<?php echo $param2;?>" method="post">
        <?php }
	         else {
            ?>
        <form id="formGO" action="<?php echo base_url();?>staff/patients/update_obstetric/<?php echo $param2;?>" method="post">
            <?php } ?>
            <div class="modal-header" style="background-color:#fff;border-top-right-radius:20px;border-top-left-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> Registrar antecedentes gineco-obstétricos</span></h4>
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
                                                Fecha de primera menstruación
                                            </div>
                                            <?php $fech = $this->crud_model->check_medical_value($param2,'first_menstruation','gyneco_obstetrics');?>
                                            <div class="input-group date datepicker" id="ckerExample">
                                                <input type="text" name="first_menstruation" class="form-control" <?php if($fech == !""): ?> value="<?php echo $this->crud_model->setFormat($fech);?>" <?php endif; ?>><span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </li>
                                        <li id="ember3062" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
                                                Fecha de última menstruación
                                            </div>

                                            <?php $fech2 = $this->crud_model->check_medical_value($param2,'last_menstruation','gyneco_obstetrics'); ?>
                                            <div class="input-group date datepicker" id="ckerExample2">
                                                <input type="text" name="last_menstruation" class="form-control" <?php if($fech2 == !""): ?> value="<?php echo $this->crud_model->setFormat($fech2);?>" <?php endif; ?>><span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </li>
                                        <li id="ember3062" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
                                                Características menstruación
                                            </div>
                                            <div class=" _deny-field-container_oxheyk">
                                                <input data-autoid="deny-field" name="menstruation_features" value="<?php echo $this->crud_model->check_medical_value($param2,'menstruation_features','gyneco_obstetrics');?>" type="text" id="ember3064" class="_deny-field_oxheyk ember-text-field ember-view">
                                            </div>
                                        </li>
                                        <li id="ember3068" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
                                                Embarazos
                                            </div>
                                            <div class="_radio-buttons_9k179t">
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="1" name="pregnancies" <?php if($this->crud_model->check_medical_history($param2, 'pregnancies','gyneco_obstetrics') == 1) echo "checked"?> class="ember-view">
                                                    Si
                                                </label>
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="0" name="pregnancies" <?php if($this->crud_model->check_medical_history($param2, 'pregnancies','gyneco_obstetrics') == 0) echo "checked"?> class="ember-view">
                                                    No
                                                </label>
                                            </div>
                                            <div id="hide_1" style="width: 100%; margin-top: 10px;">
                                                <textarea id="pregnancies_comment" name="pregnancies_comment" <?php if($this->crud_model->check_medical_history($param2,'pregnancies','gyneco_obstetrics') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2,'pregnancies','gyneco_obstetrics');?></textarea>
                                            </div>
                                        </li>
                                        <li id="ember3088" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
                                                Cáncer Cérvico
                                            </div>
                                            <div class="_radio-buttons_9k179t">
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="1" name="cervical_cancer" <?php if($this->crud_model->check_medical_history($param2, 'cervical_cancer','gyneco_obstetrics') == 1) echo "checked"?> class="ember-view">
                                                    Si
                                                </label>
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="0" name="cervical_cancer" <?php if($this->crud_model->check_medical_history($param2, 'cervical_cancer','gyneco_obstetrics') == 0) echo "checked"?> class="ember-view">
                                                    No
                                                </label>
                                            </div>
                                            <div id="hide_2" style="width: 100%; margin-top: 10px;">
                                                <textarea id="cervical_cancer_comment" name="cervical_cancer_comment" <?php if($this->crud_model->check_medical_history($param2,'cervical_cancer','gyneco_obstetrics') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2,'cervical_cancer','gyneco_obstetrics');?></textarea>
                                            </div>
                                        </li>
                                        <li id="ember3088" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
                                                Cáncer Uterino
                                            </div>
                                            <div class="_radio-buttons_9k179t">
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="1" name="uterine_cancer" <?php if($this->crud_model->check_medical_history($param2, 'uterine_cancer','gyneco_obstetrics') == 1) echo "checked"?> class="ember-view">
                                                    Si
                                                </label>
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="0" name="uterine_cancer" <?php if($this->crud_model->check_medical_history($param2, 'uterine_cancer','gyneco_obstetrics') == 0) echo "checked"?> class="ember-view">
                                                    No
                                                </label>
                                            </div>
                                            <div id="hide_3" style="width: 100%; margin-top: 10px;">
                                                <textarea id="uterine_cancer_comment" name="uterine_cancer_comment" <?php if($this->crud_model->check_medical_history($param2,'uterine_cancer','gyneco_obstetrics') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2,'uterine_cancer','gyneco_obstetrics');?></textarea>
                                            </div>
                                        </li>
                                        <li id="ember3088" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
                                                Cáncer de Mama
                                            </div>
                                            <div class="_radio-buttons_9k179t">
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="1" name="breast_cancer" <?php if($this->crud_model->check_medical_history($param2, 'breast_cancer','gyneco_obstetrics') == 1) echo "checked"?> class="ember-view">
                                                    Si
                                                </label>
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="0" name="breast_cancer" <?php if($this->crud_model->check_medical_history($param2, 'breast_cancer','gyneco_obstetrics') == 0) echo "checked"?> class="ember-view">
                                                    No
                                                </label>
                                            </div>
                                            <div id="hide_4" style="width: 100%; margin-top: 10px;">
                                                <textarea id="breast_cancer_comment" name="breast_cancer_comment" <?php if($this->crud_model->check_medical_history($param2,'breast_cancer','gyneco_obstetrics') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2,'breast_cancer','gyneco_obstetrics');?></textarea>
                                            </div>
                                        </li>
                                        <li id="ember3088" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
                                                Actividad sexual del paciente
                                            </div>
                                            <div class="_radio-buttons_9k179t">
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="1" name="sexual_activity" <?php if($this->crud_model->check_medical_history($param2, 'sexual_activity','gyneco_obstetrics') == 1) echo "checked"?> class="ember-view">
                                                    Si
                                                </label>
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="0" name="sexual_activity" <?php if($this->crud_model->check_medical_history($param2, 'sexual_activity','gyneco_obstetrics') == 0) echo "checked"?> class="ember-view">
                                                    No
                                                </label>
                                            </div>
                                            <div id="hide_5" style="width: 100%; margin-top: 10px;">
                                                <textarea id="sexual_activity_comment" name="sexual_activity_comment" <?php if($this->crud_model->check_medical_history($param2,'sexual_activity','gyneco_obstetrics') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2,'sexual_activity','gyneco_obstetrics');?></textarea>
                                            </div>
                                        </li>
                                        <li id="ember3108" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
                                                Método de Planificación Familiar
                                            </div>
                                            <div class=" _deny-field-container_oxheyk">
                                                <input data-autoid="deny-field" name="family_planning" value="<?php echo $this->crud_model->check_medical_value($param2,'family_planning','gyneco_obstetrics');?>" type="text" id="ember3110" class="_deny-field_oxheyk ember-text-field ember-view">
                                            </div>
                                        </li>
                                        <li id="ember3088" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
                                                Terapia de reemplazo hormonal
                                            </div>
                                            <div class="_radio-buttons_9k179t">
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="1" name="replacement_therapy" <?php if($this->crud_model->check_medical_history($param2, 'replacement_therapy','gyneco_obstetrics') == 1) echo "checked"?> class="ember-view">
                                                    Si
                                                </label>
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="0" name="replacement_therapy" <?php if($this->crud_model->check_medical_history($param2, 'replacement_therapy','gyneco_obstetrics') == 0) echo "checked"?> class="ember-view">
                                                    No
                                                </label>
                                            </div>
                                            <div id="hide_6" style="width: 100%; margin-top: 10px;">
                                                <textarea id="replacement_therapy_comment" name="replacement_therapy_comment" <?php if($this->crud_model->check_medical_history($param2,'replacement_therapy','gyneco_obstetrics') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2,'replacement_therapy','gyneco_obstetrics');?></textarea>
                                            </div>
                                        </li>
                                        <li id="ember3114" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
                                                Ultimo Papanicolau
                                            </div>
                                            <div class=" _deny-field-container_oxheyk">
                                                <input data-autoid="deny-field" name="last_pap" value="<?php echo $this->crud_model->check_medical_value($param2,'last_pap','gyneco_obstetrics');?>" type="text" id="ember3116" class="_deny-field_oxheyk ember-text-field ember-view">
                                            </div>
                                        </li>
                                        <li id="ember3120" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_oxheyk _record-name_e768m7">
                                                Ultima Mastografía
                                            </div>
                                            <div class=" _deny-field-container_oxheyk">
                                                <input data-autoid="deny-field" name="mammography" value="<?php echo $this->crud_model->check_medical_value($param2,'mammography','gyneco_obstetrics');?>" type="text" id="ember3122" class="_deny-field_oxheyk ember-text-field ember-view">
                                            </div>
                                        </li>
                                        <li id="ember3088" class="_medical-record_1d3apu ember-view">
                                            <div data-autoid="record-name" class="_record-name_9k179t _record-name_e768m7">
                                                Otros
                                            </div>
                                            <div class="_radio-buttons_9k179t">
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="1" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','gyneco_obstetrics') == 1) echo "checked"?> class="ember-view">
                                                    Si
                                                </label>
                                                <label class="ember-radio-button  ">
                                                    <input type="radio" value="0" name="others" <?php if($this->crud_model->check_medical_history($param2, 'others','gyneco_obstetrics') == 0) echo "checked"?> class="ember-view">
                                                    No
                                                </label>
                                            </div>
                                            <div id="hide_7" style="width: 100%; margin-top: 10px;">
                                                <textarea id="others_comment" name="others_comment" <?php if($this->crud_model->check_medical_history($param2,'others','gyneco_obstetrics') == 1) echo "required"?> class="form-control"><?php echo $this->crud_model->check_comment_medical_history($param2,'others','gyneco_obstetrics');?></textarea>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" style="width:100%;" type="submit">Registrar</button>
            </div>
        </form>
</div>

<script type="text/javascript">
$(function() {
    <?php if($this->crud_model->check_medical_history($param2, 'pregnancies','gyneco_obstetrics') == 0):?>
    $("#hide_1").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'cervical_cancer','gyneco_obstetrics') == 0):?>
    $("#hide_2").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'uterine_cancer','gyneco_obstetrics') == 0):?>
    $("#hide_3").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'breast_cancer','gyneco_obstetrics') == 0):?>
    $("#hide_4").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'sexual_activity','gyneco_obstetrics') == 0):?>
    $("#hide_5").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'replacement_therapy','gyneco_obstetrics') == 0):?>
    $("#hide_6").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_medical_history($param2, 'others','gyneco_obstetrics') == 0):?>
    $("#hide_7").hide();
    <?php endif;?>

    $("input[name=pregnancies]:radio").click(function() {
        if ($('input[name=pregnancies]:checked').val() == "0") {
            $('#hide_1').hide();
            $("#pregnancies_comment").attr("required", false);

        } else {
            $('#hide_1').show();
            $("#pregnancies_comment").attr("required", true);
        }
    });
    $("input[name=cervical_cancer]:radio").click(function() {
        if ($('input[name=cervical_cancer]:checked').val() == "0") {
            $('#hide_2').hide();
            $("#cervical_cancer_comment").attr("required", false);
        } else {
            $('#hide_2').show();
            $("#cervical_cancer_comment").attr("required", true);
        }
    });
    $("input[name=uterine_cancer]:radio").click(function() {
        if ($('input[name=uterine_cancer]:checked').val() == "0") {
            $('#hide_3').hide();
            $("#uterine_cancer_comment").attr("required", false);
        } else {
            $('#hide_3').show();
            $("#uterine_cancer_comment").attr("required", true);
        }
    });
    $("input[name=breast_cancer]:radio").click(function() {
        if ($('input[name=breast_cancer]:checked').val() == "0") {
            $('#hide_4').hide();
            $("#breast_cancer_comment").attr("required", false);
        } else {
            $('#hide_4').show();
            $("#breast_cancer_comment").attr("required", true);
        }
    });
    $("input[name=sexual_activity]:radio").click(function() {
        if ($('input[name=sexual_activity]:checked').val() == "0") {
            $('#hide_5').hide();
            $("#sexual_activity_comment").attr("required", false);
        } else {
            $('#hide_5').show();
            $("#sexual_activity_comment").attr("required", true);
        }
    });
    $("input[name=replacement_therapy]:radio").click(function() {
        if ($('input[name=replacement_therapy]:checked').val() == "0") {
            $('#hide_6').hide();
            $("#replacement_therapy_comment").attr("required", false);
        } else {
            $('#hide_6').show();
            $("#replacement_therapy_comment").attr("required", true);
        }
    });
    $("input[name=others]:radio").click(function() {
        if ($('input[name=others]:checked').val() == "0") {
            $('#hide_7').hide();
            $("#others_comment").attr("required", false);
        } else {
            $('#hide_7').show();
            $("#others_comment").attr("required", true);
        }
    });

});
</script>



<script>
$(function() {
    'use strict';
    if ($('#ckerExample').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#ckerExample').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});

$(function() {
    'use strict';
    if ($('#ckerExample2').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#ckerExample2').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});
</script>