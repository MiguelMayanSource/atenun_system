    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link " href="<?php echo base_url();?>admin/settings/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/forms/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>admin/clinics/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0047_home_flat"></i></div> <span>Sucursales</span>
                        </a>
                    </li>

                    <?php 
                    $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                    if($odonto != ''):
                
                        ?>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/thooth_procedures/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0826_teeth_tooth_dental"></i></div> <span>Procedimientos</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/specialties/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                        </a>
                    </li>

                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/surveys/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                        </a>
                    </li>
                     <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/roles/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Roles de usuario</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="main-content">

        <div class="card-box padding0">

            <div class="card-h customPadding noborder">
                <a class="btn btn-info pull-right" href="javascript:void(0)" data-toggle="modal" data-target="#123" style="margin-right:45px">Nuevo</a>
                <h5 class="card-caption">Sucursales</h5>
            </div>
            <div class="card-b">
                <div class="container-fluid">

                    <div class="alert alert-info">
                        <span class="alert-title"><i class="batch-icon-spam"></i> Con Medicaby puedes administrar todas
                            tus clínicas desde un solo lugar.</span>
                        <span class="alert-content">Recuerda que para poder agregar sucursales debes contar un plan que
                            lo permita, puedes consultar más información en la sección de <span class="alert-lined"><a target="_blank" href="https://medicaby.com/precios/" style="color:#0044e9">planes y
                                    precios</a>.</span></span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table custom-table table-striped">
                        <thead style="color: #a2a5b9;">
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>DIRECCIÓN</th>
                            <th>TELÉFONO</th>
                            <th>CORREO</th>
                            <th>HORARIOS</th>
                            <th>ACCIONES</th>
                        </thead>
                        <tbody>
                            <?php $this->db->order_by('clinic_id', 'ASC');$this->db->where('status', '1');$clinics = $this->db->get('clinic')->result_array();foreach($clinics as $row):?>
                            <tr style="font-family:'Poppins';font-size:14px;font-weight:bold;color:#4b4a55" class="">
                                <td><?php echo sprintf('%04d', $row['clinic_id']);?></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['address'];?></td>
                                <td><span class="badge badge-success"><?php echo $row['phone'];?></span></td>
                                <td><?php echo $row['email'];?></td>
                                <td><i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
                                    <?php echo date("g:i A", strtotime($row['morning'])). " - ".date("g:i A", strtotime($row['b_afternoon']));?>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_clinic/<?php echo $row['clinic_id'];?>');"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i></a>
                                    <?php if(count($clinics) > 1 &&  $this->session->userdata('current_clinic') != $row['clinic_id']): ?>
                                    <a href="javascript:void(0);" onclick="delete_clinic('<?php echo $row['clinic_id'];?>')"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal" id="123">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content animated fadeInDown">
                <form action="<?php echo base_url();?>admin/clinics/create" method="POST">
                    <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="iconBox batch-icon-home-2"></i> Agregar nueva
                                sucursal.</span></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group m-b-15">

                                            <input type="hidden" name="theme" value="<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme;   ?>">

                                            <label for="simpleinput">Nombre</label>
                                            <input type="text" name="name" required="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Teléfono</label>
                                            <input type="number" name="phone" required="" class="form-control">
                                            <small>* Ingresar código de área p.j: 502xxxxxxxx</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group m-b-15">
                                            <label for="">Horario matutino <small>(Inicial)</small></label>
                                            <div class="input-group clockpicker" data-align="bottom" data-autoclose="true">
                                                <div class="input-group date timepicker" id="horainicio" data-target-input="nearest">
                                                    <input type="text" name="morning" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio" value=" 07:00 AM">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Horario matutino <small>(Final)</small></label>
                                            <div class="input-group clockpicker" data-align="bottom" data-autoclose="true">
                                                <div class="input-group date timepicker" id="horainicio2" data-target-input="nearest">
                                                    <input type="text" name="b_morning" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio2" value=" 01:00 PM">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Horario vespertino <small>(Inicial)</small></label>
                                            <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                                <div class="input-group date timepicker" id="horainicio3" data-target-input="nearest">
                                                    <input type="text" name="afternoon" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio3" value=" 02:00 PM">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Horario vespertino <small>(Final)</small></label>
                                            <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                                <div class="input-group date timepicker" id="horainicio4" data-target-input="nearest">
                                                    <input type="text" name="b_afternoon" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio4" value=" 06:00 PM">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Correo electrónico</label>
                                            <input type="email" name="email" required="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Intervalo entre citas (minutos)</label>
                                            <input type="number" name="interval" required="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Dirección</label>
                                            <textarea type="text" name="address" required="" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="button-confirm">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/back/js/colorPick.js"></script>
    <script src="<?php echo base_url();?>public/assets/back/js/moment.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/back/js/tempusdominus-bootstrap-4.js"></script>
    <script src="<?php echo base_url();?>public/assets/back/js/timepicker.js"></script>
    <script src="<?php echo base_url();?>public/assets/back/js/settings.js"></script>

    <script type="text/javascript">
$('.app-email-w').toggleClass('compact-side-menu');
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-email-w').toggleClass('compact-side-menu');
});
    </script>
    <script type="text/javascript">
function delete_clinic(clinic_id) {
    Swal.fire({
        title: "¡Advertencia!",
        text: "Esta acción no puede deshacerse, perderá información de sus pacientes, citas. ¿Aún así, desea continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/clinics/delete/" + clinic_id;
        }
    })
}
    </script>