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
                        <a class="nav-link current" href="<?php echo base_url();?>admin/specialties/">
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
                <h5 class="card-caption">Tus especialidades</h5> <a class="btn btn-info pull-right" data-toggle="modal" data-target="#1specialtiesModal" href="javascript:void(0)" style="margin-right:45px">Nueva</a>
            </div>
            <div class="card-b">
                <div class="container-fluid">
                    <div class="alert alert-info">
                        <span class="alert-title"><i class="batch-icon-spam"></i> Centro de especialidades médicas.</span>
                        <span class="alert-content">Aquí podrás gestionar y asociar tus especialidades y las de tus <span class="alert-lined"><a href="<?php echo base_url();?>admin/doctors/" style="color:#0044e9">colegas</a>.</span></span>
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
                                                <th>Cantidad de médicos</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
			                                $this->db->order_by('specialtie_id', 'DESC');
			                                $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                                            $services = $this->db->get('specialtie')->result_array();
			                                foreach($services as $row):
			                             ?>
                                            <tr style="font-family:'Poppins';font-size:14px;font-weight:bold;color:#4b4a55" class="">
                                                <td><?php echo sprintf('%04d', $row['specialtie_id']);?></td>
                                                <td><span style="font-weight:normal"><?php echo $row['name'];?></span></td>
                                                <td>
                                                    <span class="badge badge-success">
                                                        <?php 
												        $this->db->where('specialty_1',$row['specialtie_id']);
												        $this->db->or_where('specialty_2',$row['specialtie_id']);
												        echo $this->db->count_all_results('admin');
												    ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a style="text-decoration:none;" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_specialtie/<?php echo $row['specialtie_id'];?>');"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i></a>
                                                    <a style="text-decoration:none;" href="javascript:void(0);" onclick="delete_specialtie('<?php echo $row['specialtie_id'];?>')"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
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

    <div class="modal" id="1specialtiesModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content animated fadeInDown">
                <form action="<?php echo base_url();?>admin/specialties/create" method="POST">
                    <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Agregar nueva especialidad.</span></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Nombre</label>
                                            <input type="text" name="name" required="" class="form-control">
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
    <script type="text/javascript">
function delete_specialtie(specialtie_id) {
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
            location.href = "<?php echo base_url();?>admin/specialties/delete/" + specialtie_id;
        }
    })
}
    </script>