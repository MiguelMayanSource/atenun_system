<style>
.busy {
    color: #f00 !important;
    text-decoration: line-through !important;
    background: lightgray !important;
}

.busy span {
    color: white !important;
}
</style>

<?php
        $clinic_id = $this->session->userdata('current_clinic');
        $inicial   = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->morning;
        $final     = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_morning;
        $inicial2  = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->afternoon;
        $final2    = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_afternoon;
        $intervalo = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->time_interval;
    ?>
<div class="modal-content animated fadeInDown" style=" width:100%">
    <div class="modal-header" style="background-color:#fff;border-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
        <?php if($param3 > 0):?>
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px"> Agendar próxima cita para este plan</span>
        </h4>

        <?php else:?>
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px"> Iniciar plan</span>
        </h4>
        <?php endif;?>
        <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
    </div>
    <form action="<?php echo base_url();?>doctor/create_odonto_treatment" method="POST">
        <div class="modal-body" style="background-color:#f1f3f7;">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <?php if($param3 > 0):?>
                        <input type="hidden" name="treatment_id" value="<?php echo $param3;?>">
                        <?php else:?>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Nombre del plan</label>
                                <input type="text" name="name" class="form-control" required="">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Tipo de tratamiento:</label>
                                <div class="input-group">
                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                        <input class="radiobutton" type="radio" name="type" id="infantil" value="0" required="">
                                        <label class="radiobutton-label" for="infantil">Infantil</label>
                                    </div>
                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                        <input class="radiobutton" type="radio" name="type" id="adulto" value="1">
                                        <label class="radiobutton-label" for="adulto">Adulto</label>
                                    </div>
                                    <div class="form-check" style="padding-left: 0px;">
                                        <input class="radiobutton" type="radio" name="type" id="mixto" value="2">
                                        <label class="radiobutton-label" for="mixto">Mixto</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                        <div class="col-sm-12">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">Fecha</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="text" name="date" onchange="horario(this.value)" class="form-control"><span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="patient_id" value="<?php echo $param2;?>">

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
        </div>
        <div class="modal-footer">
            <button class="button-confirm" type="submit">Continuar</button>
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

    setTimeout(
        function() {
            $(".forward").click();
        }, 250);

    var picked = datee;

    var h = [];

    //console.log(picked);
    //console.log(datee);

    $.ajax({
        url: '<?php echo base_url();?>doctor/hour_busy',
        type: 'POST',
        data: {
            "date": picked,
            "doctor_id": <?php echo $this->session->userdata('login_user_id');?>
        },
        success: function(data, ) {



            console.log(data);

            $(".option").prop("disabled", false);
            $(".option").css("background-color", "#fff");

            var time = new Date();


            var h = time.getHours();
            var m = time.getMinutes();

            var res = picked.split("/");

            if (res[0] == time.getDate()) {
                horas.forEach(hr => {






                    if (h.toString().length == 1) {

                        th = "0" + h + ":" + m;
                    } else {
                        th = h + ":" + m;

                    }



                    if (th > hr) {
                        $("option[id='" + hr + "']").css("background-color", "#d4070787");
                        $("option[id='" + hr + "']").prop("disabled", true);

                    }

                });


                horas2.forEach(hr => {





                    if (h.toString().length == 1) {

                        th = "0" + h + ":" + m;
                    } else {
                        th = h + ":" + m;

                    }



                    if (th > hr) {


                        $("option[id='" + hr + "']").css("background-color", "#d4070787");
                        $("option[id='" + hr + "']").prop("disabled", true);

                    }

                });


            }


            data.forEach(c => {



                $("option[id='" + c.time + "']").css("background-color", "#d4070787");
                $("option[id='" + c.time + "']").prop("disabled", true);


            });




        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });



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