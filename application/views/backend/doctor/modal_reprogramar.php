    <?php
              $inicial   = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->morning;
              $final     = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->b_morning;
              $inicial2  = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->afternoon;
              $final2    = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->b_afternoon;
              $intervalo = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->time_interval;
    ?>
    <?php
        $this->db->where('appointment_id', $param2);
        $appointments = $this->db->get('appointment')->result_array();
        foreach($appointments as $appointment):
    ?>
    <div class="modal-content animated fadeInDown" style="width:100%">
        <div class="modal-header" style="background-color:#fff;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><img style="width:35px; border-radius:50%" src="<?php echo $this->accounts_model->get_photo('patient', $appointment['patient_id']);?>" alt="<?php echo $this->accounts_model->short_name('patient', $appointment['patient_id']);?>">
                <span style="vertical-align:-3px"><?php echo $this->accounts_model->short_name('patient', $appointment['patient_id']);?></span>
            </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="target" method="POST" action="<?php echo base_url();?>doctor/appointments/change/<?php echo $appointment['appointment_id'];?>">
            <div class="modal-body">
                <div class="card-widget">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">¿Actualizar fecha?</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="text" name="date" onchange="horario(this.value)" class="form-control" value="<?php echo $appointment['date'];?>"><span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Motivo:</label>
                                <textarea class="form-control" name="comments" placeholder="¿Por qué se reprograma la cita?" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card-h">
                                <i style="border-radius:8px; background-color: rgba(244, 164, 37, 0.3); color:#f4a425; padding:8px;  font-size: 20px; vertical-align: 5px; margin-right: 7px; display: inline-block;" class="batch-icon-brightness-high"></i>
                                <h5 class="card-capti on" style="font-size:20px;display:inline-block;">Mañana<br style="content: ''; margin: -1.8em; display: block; font-size: 24%;">
                                    <span style="font-weight:normal; font-size:12px;color:#565b6b;"><?php echo date("g:i A", strtotime($inicial));?> - <?php echo date("g:i A", strtotime($final));?></span>
                                </h5>
                            </div>
                            <select class="itemName form-control select2" style="width:100%" name="morning" onchange="clear_val(this.value)">
                                <option class="option" value="">Seleccionar</option>
                                <?php 
                                        $horas = $this->crud_model->interval($inicial, $final, $intervalo);
                                                 echo '<script>';
                                                 echo 'horas ='.json_encode($horas);
                                                echo '</script>';
                                        
                                        
                                        
                                        for($i = 0; $i < count($horas); $i++):
                                    ?>
                                <option class="option" id="<?php echo $horas[$i];?>" value="<?php echo date("g:i A", strtotime($horas[$i]));?>"><?php echo date("g:i A", strtotime($horas[$i]));?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <div class="card-h">
                                <i style="border-radius:8px; background-color:rgb(37 139 244 / 30%); color:#8fa0e4; padding:8px;  font-size: 20px; vertical-align: 5px; margin-right: 7px; display: inline-block;" class="fa fa-moon-o"></i>
                                <h5 class="card-capt ion" style="font-size:20px; display:inline-block;">Tarde<br style="content: ''; margin: -1.8em; display: block; font-size: 24%;">
                                    <span style="font-weight:normal; font-size:12px;color:#565b6b;"><?php echo date("g:i A", strtotime($inicial2));?> - <?php echo date("g:i A", strtotime($final2));?></span>
                                </h5>
                            </div>
                            <select class="itemName2 form-control select2" style="width:100%" name="afternoon" onchange="clear_val1(this.value)">
                                <option class="option" value="">Seleccionar</option>
                                <?php 
                                        $horas2 = $this->crud_model->interval($inicial2, $final2, $intervalo);
                                                echo '<script>';
                                                 echo 'horas2 ='.json_encode($horas2);
                                                echo '</script>';
                                        for($i = 0; $i < count($horas2); $i++):
                                    ?>
                                <option class="option" id="<?php echo $horas2[$i];?>" value="<?php echo date("g:i A", strtotime($horas2[$i]));?>"><?php echo date("g:i A", strtotime($horas2[$i]));?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="button-confirm">Confirmar</button>
            </div>
        </form>
    </div>

    <script type="text/javascript">
function clear_val() {
    $(".itemName2").val("");
}

function clear_val1() {
    $(".itemName").val("");
}
    </script>
    <script>
$("#target").submit(function(event) {

    if ($('select[name="morning"]').val() == "" && $('select[name="afternoon"]').val() == "") {
        event.preventDefault();
        return false;

    } else {
        return true;

    }
});



function horario(datee) {





}

$(function() {
    'use strict';
    if ($('#datePickerExample').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#datePickerExample').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});
$(document).ready(function() {
    horario('<?php echo date('d/m/Y')?>');
});
    </script>

    <?php endforeach;?>