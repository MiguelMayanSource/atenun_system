<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "admins") echo 'current'; ?>" href="<?php echo base_url();?>staff/admins/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0710_business_tie_user_profile_avatar_man_male"></i></div> <span>Administradores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "doctors") echo 'current'; ?>" href="<?php echo base_url();?>staff/doctors/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0726_doctor_surgery_hospital"></i></div> <span>Doctores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "staff") echo 'current'; ?>" href="<?php echo base_url();?>staff/staff/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0723_nurse_medicine_hospital_doctor"></i></div> <span>Enfermeros</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "receptionist") echo 'current'; ?>" href="<?php echo base_url();?>staff/receptionist/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0731_support_female_phone"></i></div><span>Recepcionistas</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "providers") echo 'current'; ?>" href="<?php echo base_url();?>staff/providers/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div><span>Proveedores</span>
                    </a>
                </li>
                 <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "sellers") echo 'current'; ?>" href="<?php echo base_url();?>staff/sellers/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Vendedores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "accountants") echo 'current'; ?>" href="<?php echo base_url();?>staff/accountants/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Contadores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "permission_request") echo 'current'; ?>" href="<?php echo base_url();?>staff/permission_request/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0092_file_profile_user_personal"></i></div> <span>Permisos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <?php if(count($staff)> 0):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Vendedores registrados</h3>

                <!-- <a class="add-buton pull-right" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_new_staff/4');">+ Agregar vendedor</a>-->
                <a class="add-buton pull-right" href="<?php echo base_url().'staff/staff_new/4';?>">+ Agregar Personal</a>
            </div>
        </div>
        <?php foreach($staff as $row):?>
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
                                    <li><a href="<?php echo base_url();?>staff/staff_profile/<?php echo base64_encode($row['staff_id']);?>/"><i class="picons-thin-icon-thin-0699_user_profile_avatar_man_male"></i><span>Perfil</span></a>
                                    </li>
                                    <li><a href="javascript:void(0);" onclick="delete_staff('<?php echo $row['staff_id'];?>');"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i><span>Eliminar</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="pt-avatar-w"><img style="width: 60px;height: 60px;" src="<?php echo $this->accounts_model->get_photo('staff', $row['staff_id']);?>"></div>
                    <div class="pt-user-last">
                        <?php echo $this->accounts_model->short_name('staff', $row['staff_id']);?>.</div>
                    <span class="badge badge-info">@<?php echo $row['username'];?></span><br><br>
                    <div class="pt-user-social">
                        <a href="https://wa.me/502<?php echo $row['phone'];?>" target="_blank" class="no-decoration"><i class="icon-container picons-social-icon-whatsapp"></i></a>

                    </div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>staff/messages/<?php echo $row['username'];?>';">
                        Mensaje</div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <?php else:?>
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Vendedores registrados</h3>
                <!-- <a class="add-buton pull-right" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_new_staff/4');">+ Agregar vendedor</a>-->
                <a class="add-buton pull-right" href="<?php echo base_url().'staff/staff_new/4';?>">+ Agregar Personal</a>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card-box">
                <center><br>
                    <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Aún no se tiene Vendedores registrados</h4>
                    <br>
                    <img src="<?php echo base_url();?>public/uploads/personal.svg" style="width:15%" />
                </center>
            </div>
        </div>
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
</script>

<script type="text/javascript">
function delete_staff(staff_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada a este usuario.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>staff/staff/delete/" + staff_id;
        }
    })
}

/*     $(document).ready(function() {
	        $('input[name="photo"]').fileuploader({
	            theme: 'default',
		    });
		    $('input[name="signature"]').fileuploader({
	            theme: 'default',
		    });
        });
     */
</script>