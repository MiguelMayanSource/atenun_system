    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/settings/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/forms/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/clinics/">
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
                        <a class="nav-link current" href="<?php echo base_url();?>admin/surveys/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/roles/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Roles de usuario</span>
                        </a>
                    </li>
                    

                    <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>admin/entity_maintenance/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0823_hospital_ill_medicine_doctor_ambulance"></i></div> <span>Categoría de entidad</span>
                    </a>
                </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="card-box padding0">
            <div class="card-h customPadding noborder">
                <h5 class="card-caption">Encuestas de servicio</h5><a class="btn btn-info pull-right" href="javascript:void(0)" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_surveys_add/');" style="margin-right:45px">Nuevo</a>
            </div>
            <div class="card-b">
                <div class="container-fluid">
                    <div class="alert alert-info">
                        <span class="alert-title"><i class="batch-icon-spam"></i> Crea y envía encuestas a tus pacientes.</span>
                        <span class="alert-content">Puedes crear encuestas de satisfacción para tus pacientes, al finalizar cada consulta tus pacientes recibirán una notificación para responderla, activa una en la sección de <span class="alert-lined"><a href="<?php echo base_url();?>admin/settings/" style="color:#0044e9">configuración</a>.</span></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12 m-b-30">
                        <div class="table-responsive">
                            <table class="table custom-table table-striped">
                                <thead style="color: #a2a5b9;">
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Fecha de creación</th>
                                        <th>Estado</th>
                                        <th>Link</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
			                        $this->db->order_by('survey_id', 'ASC');
			                        $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                                    $surveys = $this->db->get('survey')->result_array();
			                         foreach($surveys as $row):
			                     ?>
                                    <tr style="font-family:'Poppins';font-size:14px;font-weight:bold;color:#4b4a55" class="">
                                        <td><?php echo sprintf('%04d', $row['survey_id']);?></td>
                                        <td><?php echo strip_tags($row['title']);?></td>
                                        <td><span style="font-weight:normal"><?php echo $row['date'];?></span></td>
                                        <td>
                                            <?php if($row['status'] == 1):?>
                                            <span class="status-pill green" data-toggle="tooltip" data-placement="top" title="Activa"></span>
                                            <?php elseif($row['status'] == 0):?>
                                            <span class="status-pill red" data-toggle="tooltip" data-placement="top" title="Inactiva"></span>
                                            <?php endif;?>
                                        </td>
                                        <td>
                                          <span><?php echo base_url();?>survey/reply_survey/<?php echo base64_encode($row['survey_id']);?></span>
                                        </td>
                                        <td>
                                            <a style="text-decoration:none;" href="<?php echo base_url();?>admin/question_board/<?php echo $row['survey_id'];?>"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i></a>
                                            <a style="text-decoration:none;" href="javascript:void(0);" onclick="delete_survey('<?php echo $row['survey_id'];?>')"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
function delete_survey(survey_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no puede deshacerse. ¿Aún así, desea continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/surveys/delete/" + survey_id;
        }
    })
}
    </script>