<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
    $owner = $this->crud_model->account_owner();
?>
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "admins") echo 'current'; ?>" href="<?php echo base_url();?>doctor/admins/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0710_business_tie_user_profile_avatar_man_male"></i></div> <span>Administradores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "doctors") echo 'current'; ?>" href="<?php echo base_url();?>doctor/doctors/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0726_doctor_surgery_hospital"></i></div> <span>Doctores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "staff") echo 'current'; ?>" href="<?php echo base_url();?>doctor/staff/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0723_nurse_medicine_hospital_doctor"></i></div> <span>Enfermeros</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "receptionist") echo 'current'; ?>" href="<?php echo base_url();?>doctor/receptionist/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0731_support_female_phone"></i></div><span>Recepcionistas</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "providers") echo 'current'; ?>" href="<?php echo base_url();?>doctor/providers/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div><span>Proveedores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "sellers") echo 'current'; ?>" href="<?php echo base_url();?>doctor/sellers/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Vendedores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "accountants") echo 'current'; ?>" href="<?php echo base_url();?>doctor/accountants/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Contadores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "permission_request") echo 'current'; ?>" href="<?php echo base_url();?>doctor/permission_request/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0092_file_profile_user_personal"></i></div> <span>Permisos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">

    <?php if(count($doctors) > 0):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Administradores registrados</h3>
                <a class="add-buton pull-right" href="<?php echo base_url();?>doctor/new_admin">+ Agregar Administrador</a>
            </div>
        </div>

        <?php foreach($doctors as $row):?>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls">
                        <div class="tile-settings os-dropdown-trigger">
                            <i class="batch-icon-ellipsis"></i>
                            <div class="os-dropdown">
                                <div class="icon-w">
                                    <i class="picons-thin-icon-thin-0699_user_profile_avatar_man_male"></i>
                                </div>
                                <ul>
                                    <li><a href="<?php echo base_url();?>doctor/admin_profile/<?php echo base64_encode($row['admin_id']);?>/"><i class="picons-thin-icon-thin-0699_user_profile_avatar_man_male"></i><span>Perfil</span></a>
                                    </li>
                                    <li><a href="javascript:void(0);" onclick="delete_admin('<?php echo $row['admin_id'];?>');"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i><span>Eliminar</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="pt-avatar-w"><img alt="" src="<?php echo $this->accounts_model->get_photo('admin', $row['admin_id']);?>"></div>
                    <div class="pt-user-last"><?php echo $this->accounts_model->short_name('admin', $row['admin_id']);?>.</div>
                    <span class="badge badge-warning">@<?php echo $row['username'];?></span>
                    <div class="pt-user-med">
                        <?php 
    		                        if($row['specialty_1'] > 0)
									{
    		                            echo $this->crud_model->getSpecialty($row['specialty_1']);   
    		                        }
    		                        if($row['specialty_2'] > 0)
									{
    		                            echo ' <span><i data-toggle="tooltip" data-placement="top" title="'.$this->crud_model->getSpecialty($row['specialty_2']).'" class="special picons-thin-icon-thin-0151_plus_add_new"></i></span>';   
    		                        }
    		                    ?>
                    </div>
                    <div class="pt-user-social">

                        <a href="https://wa.me/502<?php echo $row['phone'];?>" target="_blank" class="no-decoration"><i class="icon-container picons-social-icon-whatsapp"></i></a>

                    </div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>doctor/messages/<?php echo $row['username'];?>';">
                        Mensaje</div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <?php else:?>
    <div class="card-box">
        <center><br><br><br>
            <?php if($owner == 1):?>
            <!-- aquì va agregar dopctor  -->
            <?php endif;?>
            <a class="add-buton pull-right" href="<?php echo base_url();?>doctor/new_admin">+ Agregar Administrador</a>
            <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Aún no se tienen administradores registrados</h4>
            <img src="<?php echo base_url();?>public/uploads/doctors.svg" style="width:18%" />
        </center>
    </div>

    <?php endif;?>

</div>


<script type="text/javascript">
$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});

function delete_admin(admin_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Este administrador no podra ejecutar ninguna actividad, tampoco iniciar sesión, sin embargo todo lo realizado sera visible para los admisitradores.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/admins/delete/" + admin_id;
        }
    })
}
</script>