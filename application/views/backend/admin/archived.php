<?php
    $clinic_id = $this->session->userdata('current_clinic');
    $inicial   = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->morning;
    $x         = round($this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->morning);
    $final     = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_morning;
    $inicial2  = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->afternoon;
    $final2    = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_afternoon;
    $fday = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_afternoon; 
    $y    = date('h:i', strtotime($fday));
    $xy   = round($fday);
    $intervalo = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->time_interval;
    if($filter){
        $apply = base64_decode($filter);
    }
    $doctor_id = $this->session->userdata('doctor_id');
?>
<div class="todo-app-w">
    <div class="todo-sidebar2">
        <div id="sticky_left">
            <div class="todo-sidebar-section">
                <h5 class="todo-sidebar-section-header">
                    <span>Seleccionar doctor</span><a class="todo-sidebar-section-toggle" href="#"><i class="batch-icon-user-2"></i></a>
                </h5>
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li>
                            <form method="POST" action="<?php echo base_url();?>admin/pending_payment">
                                <select class="itemName form-control select2" required="" name="doctor_id" onchange="submit()">
                                    <option value="0" <?php if($doctor_id == 0) echo "selected";?>>Todos</option>
                                    <?php 
										        $this->db->where('status','1');
                                                $this->db->where('owner','0');
    										    $this->db->order_by('first_name', 'ASC');
										        $query = $this->db->get('admin')->result_array();
                                                foreach($query as $pat):?>
                                    <option value="<?php echo $pat['admin_id'];?>" <?php if($pat['admin_id'] == $doctor_id) echo "selected";?>>
                                        <?php echo $this->accounts_model->get_name('admin', $pat['admin_id']);?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="todo-sidebar-section">
                <h5 class="todo-sidebar-section-header">
                    <span>Por estado</span><a class="todo-sidebar-section-toggle" href="#"><i class="batch-icon-revert"></i></a>
                </h5>
                <div class="todo-sidebar-section-contents">
                    <?php include 'appointment_state_list.php';?>
                </div>
            </div>
            <div class="todo-sidebar-section">
                <h5 class="todo-sidebar-section-header">
                    <span>Aplicar fecha</span><a class="todo-sidebar-section-toggle" href="#"><i class="batch-icon-calendar"></i></a>
                </h5>
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li>
                            <form id="filters" method="POST" action="<?php echo base_url();?>admin/archived">
                                <div class="form-group date-time-picker m-b-15">
                                    <div class="input-group date datepicker" id="DoctorPicker1" style="border:0px;">
                                        <input type="text" id="applyDate" name="date" autocomplete="off" style="font-weight: 500;padding: 20px;background: #dcdcdc;border-radius: 9px;" value="<?php if($filter) echo $apply; else echo date('d/m/Y');?>" class="form-control">
                                        <span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="todo-sidebar-section">
                <h5 class="todo-sidebar-section-header">
                    <span>Pacientes nuevos</span><a class="todo-sidebar-section-toggle" href="#"><i class="batch-icon-user-2"></i></a>
                </h5>
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li>
                            <style>
                            .table td,
                            .table th {
                                padding-left: 0px;
                            }
                            </style>

                            <table class="table">
                                <tbody>
                                    <?php $patients = $this->crud_model->new_patients();
				                
				                foreach($patients as $pt):
				                ?>
                                    <tr style="font-family:'Poppins';font-size:14px;" class="">
                                        <td>
                                            <a href="<?php echo base_url(); ?>admin/patient_profile/<?php echo base64_encode($pt['patient_id']); ?>">
                                                <img src="<?php echo $this->accounts_model->get_photo('patient', $pt['patient_id']);?>" width="35px" style="padding-right:6px">
                                                <?php echo $this->accounts_model->get_name('patient', $pt['patient_id']);?>
                                            </a>
                                        </td>
                                    </tr>

                                    <?php endforeach; ?>
                                </tbody>
                            </table>


                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Control y calendarización de citas</span>
            <a class="pull-right btn btn-info" style="font-size:13px;background:rgb(254, 173, 85);border:0px;border-radius: 20px;" href="<?php echo base_url();?>admin/calendar/"><i style="font-size:13px" class="picons-thin-icon-thin-0024_calendar_month_day_planner_events"></i>Ver en calendario</a>
        </h4>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Gestiona tus citas.</span>
                    <span class="alert-content">En esta sección podrás visualizar todas las citas que han sido programadas por tu equipo de trabajo, recuerda que puedes agendar una nueva haciendo clic <span class="alert-lined"><a href="<?php echo base_url();?>admin/appointment/" style="color:#0044e9">aquí</a>.</span></span>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="all-tasks-w">
                    <?php 
                    $horas = $this->crud_model->interval($inicial, $final, $intervalo);
                    for($i = $x; $i <= $xy; $i++): 
                ?>
                    <div class="tasks-section">
                        <div class="tasks-header-w">
                            <a class="tasks-header-toggler" href="#"><i class="batch-icon-alarm-clock"></i></a>
                            <h5 class="tasks-header"><?php if($i < 10) $print = '0'.$i.':00'; else $print = $i.':00'; echo date("g:i A", strtotime($print));?></h5>
                        </div>
                        <div class="tasks-list-w">
                            <ul class="tasks-list">
                                <?php
                                    $min = array("00");
                                    foreach($min as $v):
                                    if($i < 10) $querys = '0'.$i; else $querys = $i;
                                    if($filter){
                                        $appointments =  $this->crud_model->appointment_archived_doc($doctor_id,$apply,$clinic_id, $querys)->result_array();
                                    }else{
                                        $appointments =  $this->crud_model->appointment_archived_doc($doctor_id,date('d/m/Y'),$clinic_id, $querys)->result_array();
                                    }
                                    foreach($appointments as $appointment):
                                    if($appointment['status'] == 0){
                                        $className = 'pending';
                                    }elseif($appointment['status'] == 1 || $appointment['status'] == 4){
                                         $className = 'confirmed';
                                    }elseif($appointment['status'] == 3){
                                        $className = 'rep';
                                    }elseif($appointment['status'] == 2){
                                        $className = 'cancelled';
                                    }
                                ?>
                                <div class="alert alert-<?php echo $className;?>">
                                    <span style="display:block;font-weight:bold;font-size:12px"><?php echo $this->crud_model->formatear($appointment['date']);?> - <?php echo date("g:i A", strtotime($appointment['time']));?></span>
                                    <div class="pi-controls">
                                        <div class="pi-settings os-dropdown-trigger" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="batch-icon-ellipsis alert-<?php echo $className;?>-text"></i>
                                        </div>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <?php 
                                        if($appointment['status'] == 0)
                                        {
                                                   ?>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="confirm('<?php echo $appointment['appointment_id'];?>')">Confirmar</a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_reprogramar/<?php echo $appointment['appointment_id'];?>');">Reprogramar</a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="cancel_appointment('<?php echo  $appointment['appointment_id'];?>')">Cancelar</a>

                                            <?php          

                                        }elseif($appointment['status'] == 1){

                                            ?>

                                            <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_reprogramar/<?php echo $appointment['appointment_id'];?>');">Reprogramar</a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="cancel_appointment('<?php echo  $appointment['appointment_id'];?>')">Cancelar</a>

                                            <?php          

                                        }elseif($appointment['status'] == 3){

                                            ?>

                                            <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_reprogramar/<?php echo $appointment['appointment_id'];?>');">Reprogramar</a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="cancel_appointment('<?php echo  $appointment['appointment_id'];?>')">Cancelar</a>

                                            <?php          


                                        }elseif($appointment['status'] == 2){

                                            ?>

                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_appointment('<?php echo  $appointment['appointment_id'];?>')">Eliminar cita</a>

                                            <?php 

                                        }elseif($appointment['status'] == 4){

                                            ?>

                                            <a class="dropdown-item" href="<?php echo base_url(); ?>admin/pay_appointment/<?php echo base64_encode($appointment['appointment_id']); ?>">Recibo</a>

                                            <?php          
                                        }
                                            ?>


                                        </div>
                                    </div>
                                    <div class="pipeline-item">
                                        <div class="pi-body">
                                            <div class="avatar">
                                                <img alt="" src="<?php echo $this->accounts_model->get_photo('patient', $appointment['patient_id']);?>" width="45px" style="border-radius:25px">
                                            </div>
                                            <div class="pi-info">
                                                <div class="h6 pi-name alert-<?php echo $className;?>-text"><?php echo $this->accounts_model->get_name('patient', $appointment['patient_id']);?></div>
                                                <div class="pi-sub alert-<?php echo $className;?>-text">
                                                    <?php if($appointment['practice'] > 0):?>
                                                    <b>Práctica:</b> <?php echo $this->db->get_where('service', array('service_id' => $appointment['practice']))->row()->name;?>
                                                    <?php else:?>
                                                    <b>Práctica:</b> Otros servicios
                                                    <?php endif;?>
                                                    <span style="display:block"><b>Especialista:</b> <?php echo $this->accounts_model->gender($appointment['doctor_id']).' '.$this->accounts_model->short_name('admin',$appointment['doctor_id']);?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <style>

                                        </style>
                                        <div class="pi-foot">
                                            <div class="tags">
                                                <a class="tag" data-toggle="tooltip" data-placement="right" title="" data-original-title="Detalles" href="javascript:void(0);" onclick="appointment_details('<?php echo base64_encode($appointment['appointment_id']);?>');"><i class="picons-thin-icon-thin-0014_notebook_paper_todo alert-<?php echo $className;?>-text"></i></a>
                                                <a class="tag" href="<?php echo base_url();?>admin/messages/<?php echo $this->db->get_where('patient', array('patient_id'=> $appointment['patient_id']))->row()->username;?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="Enviar mensaje"><i class="picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite alert-<?php echo $className;?>-text"></i></a>
                                                <a class="tag" href="tel:+502<?php echo $this->db->get_where('patient', array('patient_id'=> $appointment['patient_id']))->row()->phone;?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="Llamar"><i class="picons-thin-icon-thin-0289_mobile_phone_call_ringing_nfc alert-<?php echo $className;?>-text"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <?php endfor;?>
                </div>
            </div>
            <div class="col-sm-5" id="appointment_details">
                <div id="sticky_rigth">
                    <center><img src="<?php echo base_url();?>public/assets/theme/images/details.png" style="max-width:80%;margin-top:50%; z-index: 1">
                        <span style="display:block;margin-top:10px;font-size:17px;font-family:'Poppins',sans-serif;">Selecciona una cita para ver los detalles.</span>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
<script>
$('#applyDate').change(function() {
    $("#filters").submit();
});
$(function() {
    'use strict';
    if ($('#DoctorPicker1').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DoctorPicker1').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});
//$('.app-side').toggleClass('compact-side-menu');
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});
if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
</script>
<script type="text/javascript">
function cancel(appointment_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La cita será marcada como cancelada, está acción no se puede deshacer.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/appointments/cancel/" + appointment_id;
        }
    })
}

function confirm(appointment_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La cita será marcada como confirmada, está acción no se puede deshacer.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/appointments/confirm/" + appointment_id;
        }
    })
}

function delete_appointment(appointment_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada a la cita.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/appointments/delete/" + appointment_id;
        }
    })
}


function appointment_details(appointment_id) {
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>admin/appointment_details_card/' + appointment_id,
        dataType: "html",
        error: function(xhr, ajaxOptions, thrownError) {
            alert("Ups! Algo salio mal.");
        },
        success: function(data) {
            $('#imga').css('display', 'none');
            $("#appointment_details").empty();
            $("#appointment_details").html(data);
            var sidebar = new StickySidebar('#sticky', {
                topSpacing: 20
            });
        }
    });
};
</script>