<?php 
    $doctor_id = $this->session->userdata('login_user_id');
    $this->db->where('admin_id', $doctor_id);
    $info = $this->db->get('admin')->result_array();    
    foreach($info as $details): 
?>
<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/my_profile/"><i style="padding-right: 10px; font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i>Mi perfil</a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/my_notifications/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/my_security/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/my_activity/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>admin/my_calendar/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i> Calendario </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>admin/my_appointments/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas <span class="side-active"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content" style="margin-bottom:10%">
        <div class="row">
            <div class="col-sm-12" style="float: none; margin: 0 auto;">
                <h4 class="todo-content-header">
                    <i class="batch-icon-arrow-right"></i><span>Tus citas en Medicaby.</span>
                </h4>
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Registro de citas.</span>
                    <span class="alert-content">Aquí podrás visualizar todas las citas que tengas dentro de <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a></span>.</span>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                                    <div class="label">
                                        Todas las citas
                                    </div>
                                    <div class="value">
                                        <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'doctor_id'=>$doctor_id))->num_rows(); ?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                                    <div class="label">
                                        Reprogramadas
                                    </div>
                                    <div class="value">
                                        <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'doctor_id'=>$doctor_id,'status'=> 3))->num_rows(); ?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                                    <div class="label">
                                        Canceladas
                                    </div>
                                    <div class="value">
                                        <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'doctor_id'=>$doctor_id,'status'=> 2))->num_rows(); ?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                                    <div class="label">
                                        Confirmadas
                                    </div>
                                    <div class="value">
                                        <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'doctor_id'=>$doctor_id,'status'=> 1))->num_rows(); ?>
                                    </div>
                                </a>
                            </div>
                        </div><br>
                    </div>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-padded demo" id="user_data">
                                <thead>
                                    <th>Paciente</th>
                                    <th>Especialista</th>
                                    <th>Fecha & Hora</th>
                                    <th>Estado</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php  endforeach; ?>

<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/getTable/my_appointments'; ?>",
            type: "POST"
        },
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
    });
});
</script>