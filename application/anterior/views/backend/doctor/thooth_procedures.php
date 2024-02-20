    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link " href="<?php echo base_url();?>doctor/settings/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>doctor/forms/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>doctor/clinics/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0047_home_flat"></i></div> <span>Sucursales</span>
                        </a>
                    </li>

                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>doctor/thooth_procedures/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0826_teeth_tooth_dental"></i></div> <span>Procedimientos</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>doctor/specialties/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                        </a>
                    </li>

                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>doctor/surveys/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>doctor/roles/">
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
                <h5 class="card-caption">Gestionar servicios</h5> <a class="btn btn-info pull-right" href="javascript:void(0)" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_process_add/');" style="margin-right:45px">Nuevo</a>
            </div>
            <div class="card-b">
                <div class="container-fluid">
                    <div class="alert alert-info">
                        <span class="alert-title"><i class="batch-icon-spam"></i> Agrega, actualiza y elimina tus procedimientos dentales.</span>
                        <span class="alert-content">Todos los procedimientos que agregues en esta sección serán visualizados al momento de crear un nuevo tratamiento</a>.</span></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12 m-b-30">
                        <div class="support-tablist-content tab-content">
                            <div class="main-table-card">
                                <div class="table-responsive">
                                    <table class="table custom-table table-striped">
                                        <thead style="color: #a2a5b9;">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Costo</th>
                                                <th>Precio</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
										    $n = 1;
			                                $this->db->order_by('name', 'ASC');
			                                $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                                            $this->db->where('status',1);
                                            $services = $this->db->get('process')->result_array();
			                                foreach($services as $row):
			                            ?>
                                            <tr style="font-family:'Poppins';font-size:14px;font-weight:bold;color:#4b4a55" class="">
                                                <td><?php echo sprintf('%04d', $row['process_id']);?></td>
                                                <td><span style="font-weight:normal"><?php echo $row['name'];?></span></td>
                                                <td><span class="badge badge-info">&bull; <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?> <?php echo number_format($row['cost'],2,".",",");?></span></td>
                                                <td><span class="badge badge-info">&bull; <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?> <?php echo number_format($row['price'],2,".",",");?></span></td>
                                                <td>
                                                    <a href="javascript:void(0);" style="text-decoration:none;" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_process_update/<?php echo $row['process_id'];?>');"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i></a>
                                                    <?php if($row['process_id'] != 21 && $row['process_id'] != 23 ):?>
                                                    <a href="javascript:void(0);" style="text-decoration:none;" onclick="delete_process('<?php echo $row['process_id'];?>')"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                                    <?php endif;?>
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
        </div>
    </div>

    <script type="text/javascript">
function delete_process(process_id) {
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
            location.href = "<?php echo base_url();?>doctor/thooth_procedures/delete/" + process_id;
        }
    })
}
    </script>