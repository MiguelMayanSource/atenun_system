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
                        <a class="nav-link" href="<?php echo base_url();?>admin/surveys/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                        </a>
                    </li>
                     <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/roles/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Roles de usuario</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>admin/entity_maintenance/">
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
                <h5 class="card-caption">Categoría de Entidades</h5>
            </div>
            <div class="card-b">
                <div class="container-fluid">

                </div>
                <div class="table-responsive">
                    <table class="table custom-table table-striped">
                        <thead style="color: #a2a5b9;">
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>ACCIONES</th>
                        </thead>
                        <tbody>
                            <?php $this->db->order_by('category_entity_id', 'ASC');$this->db->where('status', '1');$category_entity = $this->db->get('category_entity')->result_array();foreach($category_entity as $row):?>
                            <tr style="font-family:'Poppins';font-size:14px;font-weight:bold;color:#4b4a55" class="">
                                <td><?php echo sprintf('%04d', $row['category_entity_id']);?></td>
                                <td><?php echo $row['name'];?></td>
                                
                                <td>
                                    <a href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_category_edit/<?php echo $row['category_entity_id'];?>');"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i></a>
                                    <a href="javascript:void(0);" onclick="delete_category('<?php echo $row['category_entity_id'];?>')"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
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
function delete_category(category_entity_id) {
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
            location.href = "<?php echo base_url();?>admin/entity_category/delete/" + category_entity_id;
        }
    })
}
    </script>