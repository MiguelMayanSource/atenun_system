<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
    $roles = $this->accounts_model->getRoles(); $cont = 1;
?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/settings/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/insurance/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0823_hospital_ill_medicine_doctor_ambulance"></i></div> <span>Aseguradoras</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/clinics/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0047_home_flat"></i></div> <span>Sucursales</span>
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
                    <a class="nav-link" href="<?php echo base_url();?>doctor/forms/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                    </a>
                </li>
                 <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>doctor/roles/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Roles de usuario</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Tus pacientes</h3>
                <a class="add-buton pull-right" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url().'modal/popup/modal_new_role/';?>')">+ Agregar rol</a>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-padded" id="user_data">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Permisos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($roles->result_array() as $rl):?>
                        <tr>
                            <td><?php echo $cont++;?></td>
                            <td><?php echo $rl['name'];?></td>
                            <td><?php echo $rl['description'];?></td>
                            <td><a href="<?php echo base_url().'doctor/permissions/'.base64_encode($rl['role_id']);?>">Ver</a></td>
                            <td>
                                <a class="btn btn-primary" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url().'modal/popup/modal_edit_role/'.base64_encode($rl['role_id']);?>')">
                                    <i class="fas fa-edit"></i>
                                </a>
                                &nbsp;
                                &nbsp;
                                    <?php if($rl['status'] == 1):?>
                                <a class="btn btn-warning" href="javascript:void(0);" onclick="deactivateRole('<?php echo base64_encode($rl['role_id']);?>', '<?php echo $rl['name'];?>')">
                                    <i class="mdi mdi-block-helper"></i>
                                </a>
                                    <?php else:?>
                                <a class="btn btn-success" href="javascript:void(0);" onclick="activateRole('<?php echo base64_encode($rl['role_id']);?>', '<?php echo $rl['name'];?>')">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                                    <?php endif;?>
                                &nbsp;
                                &nbsp;
                                <a class="btn btn-danger" href="javascript:void(0)" onclick="deleteRole('<?php echo base64_encode($rl['role_id']);?>', '<?php echo $rl['name'];?>')">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});
</script>

<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable();
});
</script>
<script type="text/javascript">
    function deactivateRole(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de desactivar el rol de usuario?',
            text: "¡El rol "+nombre+", no aparecerá en todos los formularios que se necesite!, puedes reactivarlo después.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Desactivar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            console.log(result);
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/roles/deactivate/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se desactive el rol de usuario.",
                            padding: '2em',
                            allowOutsideClick: false,
                            onOpen: function () {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Hecho!',
                            text: "El rol de usuario "+nombre+" ha sido desactivado.",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        }).then(function(){
                            location.reload();
                        });
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        Swal.fire({
                            title: 'Vaya!',
                            text: "Ha ocurrido un error, intentalo más tarde.",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        });
                    }
                });
            }
        });
    }

    function activateRole(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de activar el rol de usuario?',
            text: "¡El rol "+nombre+", volverá a aparecer en todos los formularios que se necesite!",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Activar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/roles/activate/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se active el rol de usuario.",
                            padding: '2em',
                            allowOutsideClick: false,
                            onOpen: function () {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Hecho!',
                            text: "El rol de usuario "+nombre+" ha sido activado.",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        }).then(function(){
                            location.reload();
                        });
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        Swal.fire({
                            title: 'Vaya!',
                            text: "Ha ocurrido un error, intentalo más tarde.",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        });
                    }
                });
            }
        });
    }

    function deleteRole(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de eliminar el rol de usuario?',
            text: "¡El rol "+nombre+" se eliminará definitivamente, no podrás revertir esta acción!",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/roles/delete/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine el rol de usuario.",
                            padding: '2em',
                            allowOutsideClick: false,
                            onOpen: function () {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Hecho!',
                            text: "El rol de usuario "+nombre+" ha sido eliminado.",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        }).then(function(){
                            location.reload();
                        });
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        Swal.fire({
                            title: 'Vaya!',
                            text: "Ha ocurrido un error, intentalo más tarde.",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        });
                    }
                });
            }
        });
    }
</script>