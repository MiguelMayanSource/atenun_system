<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
    $owner = $this->crud_model->account_owner();
?>
<style>
.center-col {
    float: none;
    margin: 0 auto;
}

.carnet {
    border: 2px solid #152e4d;
    text-align: center !important;
    border-radius: 5px;
    background: white;
    width: 300px;
}

.image {
    border-radius: 50%;
    height: 100px;
    width: 100px;
    z-index: 9999;
    position: relative;
    object-fit: cover;
}

.celeste {
    color: white;
    margin-top: 25px;
    z-index: 9999999;
    font-weight: bold;
    width: 70%;
    border-bottom-right-radius: 25px;
    border-top-left-radius: 25px;
    padding: 9px;
    font-size: 15px;
    position: relative;
    background: #0da6df;
}

.azul {
    position: relative;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}

.cel {
    background: #0da6df;
    height: 4px;
    border-bottom-right-radius: 100px;
}

.cls {
    background: #0da6df;
    height: 107px;
    width: 100px;
    border-radius: 50%;

    margin-top: -90px;
    text-align: center;
}

.spe {
    background: #152e4d;
    color: white;
    margin-top: -15px;
    font-size: 25px;
    padding: 10px;
    border-radius: 18px;
    font-weight: bold;
}

.contacts {
    margin-top: 30px;
    padding-bottom: 50px;
}

.contact-img {
    padding: 10px;
    display: inline-block;
    border: 2px solid #152e4d;
    border-radius: 50%;
}

.imga {
    width: 25px;
    height: 25px;
}

.inside {
    padding: 20px;
}
</style>
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "admins") echo 'current'; ?>" href="<?php echo base_url();?>admin/admins/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0710_business_tie_user_profile_avatar_man_male"></i></div> <span>Administradores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "doctors") echo 'current'; ?>" href="<?php echo base_url();?>admin/doctors/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0726_doctor_surgery_hospital"></i></div> <span>Doctores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "staff") echo 'current'; ?>" href="<?php echo base_url();?>admin/staff/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0723_nurse_medicine_hospital_doctor"></i></div> <span>Enfermeros</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "receptionist") echo 'current'; ?>" href="<?php echo base_url();?>admin/receptionist/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0731_support_female_phone"></i></div><span>Recepcionistas</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "providers") echo 'current'; ?>" href="<?php echo base_url();?>admin/providers/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div><span>Proveedores</span>
                    </a>
                </li>
                 <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "sellers") echo 'current'; ?>" href="<?php echo base_url();?>admin/sellers/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Vendedores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "accountants") echo 'current'; ?>" href="<?php echo base_url();?>admin/accountants/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Contadores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "permission_request") echo 'current'; ?>" href="<?php echo base_url();?>admin/permission_request/">
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
                <h3 class="module-title">Doctores registrados</h3>
                <a class="add-buton pull-right" href="<?php echo base_url();?>admin/new_doctor">+ Agregar doctor</a>
            </div>
        </div>

        <?php foreach($doctors as $row):?>
        <div class="col-sm-3">
            <div class="carnet" >
                <div class="azul" style="cursor:pointer" onclick="window.location='<?php echo base_url();?>admin/doctor_profile/<?php echo base64_encode($row['admin_id']);?>';">
                    <img src="<?php echo base_url(); ?>public/assets/images/back.png" style="width:100%;height:120px">
                </div>
                <center>
                    <div class="cls" style="cursor:pointer" onclick="window.location='<?php echo base_url();?>admin/doctor_profile/<?php echo base64_encode($row['admin_id']);?>';">
                        <img src="<?php echo $this->accounts_model->get_photo('admin', $row['admin_id']);?>" class="image">
                    </div>
                </center>
                <div class="inside" style="cursor:pointer" onclick="window.location='<?php echo base_url();?>admin/doctor_profile/<?php echo base64_encode($row['admin_id']);?>';">
                    <center>
                        <div class="celeste">
                            Dr<?php if($row['gender'] == 'F') echo 'a';?>. <?php echo $this->accounts_model->short_name('admin', $row['admin_id']);?>
                        </div>
                    </center>
                    <div class="spe">
                        <?php echo  $this->crud_model->getSpecialty($row['specialty_1']);  ?>
                    </div>
                </div>
                <div class="contacts">
                    
                    <a class="contact-img" style="cursor:pointer" onclick="myFunction('<?php echo base_url().'admin/doctor_card/'.base64_encode($row['admin_id']);?>')" >
                        <img src="<?php echo base_url(); ?>public/assets/images/share.png" class="imga">
                    </a>
                    <div class="contact-img" style="cursor:pointer" onclick="window.open('https://www.atenun.com.gt', '_blank')">
                        <img src="<?php echo base_url(); ?>public/assets/images/globe.png" class="imga">
                    </div>
                    <div class="contact-img" style="cursor:pointer" onclick="window.open('https://goo.gl/maps/AF1KnugRfvpnJ6SLA', '_blank')">
                        <img src="<?php echo base_url(); ?>public/assets/images/location.png" class="imga">
                    </div>
                    <a class="contact-img" style="cursor:pointer" href="<?php if($this->crud_model->getInfo('phone') != ""):?> tel:<?php echo $this->crud_model->getInfo('phone');?> <?php else: ?># <?php endif; ?>">
                        <img src="<?php echo base_url(); ?>public/assets/images/call.png" class="imga">
                    </a>
                    <a class="contact-img" style="cursor:pointer"  href="<?php if($this->crud_model->getInfo('whatsapp') != ""):?> https://wa.me/502<?php echo $this->crud_model->getInfo('whatsapp');?> <?php else: ?># <?php endif; ?>">
                        <img src="<?php echo base_url(); ?>public/assets/images/whatsapp.png" class="imga">
                    </a>
                </div>
            </div>
        <br>
        </div>
        
        <?php endforeach;?>
    </div>
    <?php else:?>
    <div class="card-box">
        <center><br><br><br>
            <?php if($owner == 1):?>
            <!-- aquì va agregar dopctor  -->
            <?php endif;?>
            <a class="add-buton pull-right" href="<?php echo base_url();?>admin/new_doctor">+ Agregar doctor</a>
            <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Aún no se tienen médicos registrados</h4>
            <img src="<?php echo base_url();?>public/uploads/doctors.svg" style="width:18%" />
        </center>
    </div>

    <?php endif;?>

</div>


<script type="text/javascript">

function myFunction(text) {

   // Copy the text inside the text field
   // Obtener el texto que quieres copiar del atributo "data-clipboard-text"
   var textoCopiar = $(this).data('clipboard-text');

        // Crear un elemento de texto temporal (input) para copiar el contenido
        var inputTemp = $('<input>');
        $('body').append(inputTemp);
        inputTemp.val(text).select();

        try {
        // Intentar copiar el contenido seleccionado al portapapeles
        var copiadoExitoso = document.execCommand('copy');
        var mensaje = copiadoExitoso ? 'Enlace copiado!' : 'Error al copiar';
        alert(mensaje);
        } catch (err) {
        // Manejar cualquier error que pueda ocurrir
        alert('Error al intentar copiar al portapapeles');
        }

        // Eliminar el elemento temporal de texto
        inputTemp.remove();
  // Alert the copied text
 
}
    
    
    function getlink() {
      var aux = document.createElement('input');
      aux.setAttribute('value', window.location.href.split('?')[0].split('#')[0]);
      document.body.appendChild(aux);
      aux.select();
      document.execCommand('copy');

}
    
$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});

function delete_doctor(doctor_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada a este doctor.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/doctors/delete/" + doctor_id;
        }
    })
}
</script>