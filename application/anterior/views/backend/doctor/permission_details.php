<style>
    @media print {
        body {
            margin: 0;
        }
    }
</style>

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
                    <a class="nav-link <?php  if($page_name == "permission_request" || $page_name == "permission_details" ) echo 'current'; ?>" href="<?php echo base_url();?>doctor/permission_request/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0092_file_profile_user_personal"></i></div> <span>Permisos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <?php
        
        log_message('error',$permission_request_id);

    $info = $this->db->get_where('permission_request', array('permission_request_id' => $permission_request_id))->result_array();
	

   
        foreach($info as $permission_request):
           
            $admin_id = $permission_request['auth_id'];
            $user_id = $permission_request['user_id'];
            $user = $this->db->get_where($permission_request['user_type'], array($permission_request['user_type'].'_id' => $user_id))->row();
        ?>

    <div class="row">
        <div class="col-md-8">
            <div id="miDiv" style="width: 8.5in; height: 11in; background-image: url('<?php echo base_url().'public/uploads/referencia.png'?>'); background-size: cover; position: relative;font-family:none;font-size: 14px;">
                <!-- Aquí irá el botón para imprimir -->
                <!------ Inicio datos del paciente ------>
                <div style="position:absolute;top:280px;left:100px;">
                    <b><span><?php echo $this->accounts_model->get_full_name($permission_request['user_type'],$permission_request['user_id']);?></span></b>
                </div>
                <div style="position:absolute;top:280px;left:720px;width:50px">
                    <b><span>0<?php echo $permission_request_id;?></span></b>
                </div>
                <div style="position:absolute;top:320px;left:90px;">
                    <b><span><?php echo date('Y-m-d');?></span></b>
                </div>
                <div style="position:absolute;top:320px;left:300px;">
                    <b><span><?php echo $user->phone;;?></span></b>
                </div>
                <div style="position:absolute;top:320px;left:550px;">
                    <b><span><?php echo $user->code;;?></span></b>
                </div>
                <div style="position:absolute;top:330px;left:692px;">
                    <b><span ><?php echo $user->gender; ?></span></b>
                </div>
                <div style="position:absolute;top:330px;left:730px;">
                    <b><span>
                            <?php $originalDate = $user->date_of_birth; $newDate = date("d-m-Y", strtotime($originalDate)); ?>
                            <?php echo $this->accounts_model->get_age($originalDate);?>
                        </span></b>
                </div>
                <!------ Final datos del paciente ------>
                <!------ Inicio datos de la orden ------>

                <div style="position:absolute;top:460px;right:100px;">
                    <b><span>
                            <?php    setlocale(LC_ALL,"es_ES.UTF-8"); echo strftime("%A, %d de %B del %Y");
            ?>
                        </span>
                    </b>
                </div>
                <div style="position:absolute;top:510px; text-align:justify; padding:50px;font-weight: lighter;">
                    <b><span><?php echo $permission_request['details'];?></span></b>
                </div>



            </div>
        </div>

        <div class="col-md-4">
            <div class="ecommerce-customer-info">
                <h5 style="color:#43485c">Usuario</h5>
                <hr>
                <div class="ecommerce-customer-main-info">
                    <div class="ecc-avatar" style="background-image: url(<?php echo $this->accounts_model->get_photo($permission_request['user_type'],$permission_request['user_id']);?>)"></div>
                    <div class="ecc-name">
                        <?php echo  $this->accounts_model->get_full_name($permission_request['user_type'],$permission_request['user_id']);?>
                    </div>
                </div>
                <div class="ecommerce-customer-sub-info">
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Correo
                        </div>
                        <div class="sub-info-value">
                            <?php echo $user->email;?>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Celular
                        </div>
                        <div class="sub-info-value">
                            <?php echo  $user->phone;;?>
                        </div>
                    </div>


                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Fecha y hora de la solicitud
                        </div>
                        <div class="sub-info-value">
                            <span><?php echo $permission_request['date_solicite'];?></span>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Authorizado por
                        </div>
                        <div class="sub-info-value">
                            <span>
                                <?php echo $this->accounts_model->short_name('admin',$permission_request['admin_id']);?>
                            </span>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Fecha y hora
                        </div>
                        <div class="sub-info-value">
                            <span><?php echo $permission_request['auth_date'];?></span>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Estado
                        </div>
                        <div class="sub-info-value">
                            <?php if($permission_request['status']!=0):?>
                                <?php echo $permission_request['status'] == 1 ? 'Autorizado' : 'Rechazado';?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Acciones
                        </div>
                        <div class="sub-info-value">
                            <a href="javascript:void(0);" id="btnImprimir" class=""><i style="    vertical-align: -3px;color: #a7aabb;font-size: 18px;font-weight: bold;" class="picons-thin-icon-thin-0333_printer"></i></a>    
                            <?php if($permission_request['status']==0):?>
                                <a href="javascript:void(0);" onclick="aprove_permission_request('<?php echo $permission_request['permission_request_id'];?>')" class=""><i style="    vertical-align: -3px;color: #a7aabb;font-size: 18px;font-weight: bold;" class="picons-thin-icon-thin-0154_ok_successful_check"></i></a>
                                <a href="javascript:void(0);" onclick="reprove_permission_request('<?php echo $permission_request['permission_request_id'];?>')" class=""><i style="    vertical-align: -3px;color: #a7aabb;font-size: 18px;font-weight: bold;" class="picons-thin-icon-thin-0153_delete_exit_remove_close"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>


<script type="text/javascript">
function aprove_permission_request(id) {
    Swal.fire({
        title: 'Autorizar permiso',
        text: "Este permiso se marcara como autorizado. ¿Seguro deseas continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Si, autorizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/permission_request/aprove/" + id;
        }
    })
}

function reprove_permission_request(id) {
    Swal.fire({
        title: 'Denegar permiso',
        text: "Este permiso se marcara como denegado. ¿Seguro deseas continuar?",
        type: 'error',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Si, denegar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/permission_request/reprove/" + id ;
        }
    })
}

$(document).ready(function() {
    $('#btnImprimir').on('click', function(){
        imprimirDiv();
    });

    function imprimirDiv(){
        var contenido = $('#miDiv').html();

// Crear un elemento de impresión en una ventana nueva
var ventanaImpresion = window.open('', '', 'height=1000,width=1200');

// Escribir el contenido del div en la ventana de impresión
ventanaImpresion.document.write(`<div style="width: 8.5in; height: 11in; background-image: url('<?php echo base_url().'public/uploads/referencia.png'?>'); background-size: cover; position: relative;font-family:none;font-size: 14px;">${contenido}</div>`);

// Imprimir la ventana de impresión
ventanaImpresion.print();
ventanaImpresion.close();
    }
});
</script>

