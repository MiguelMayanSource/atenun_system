<?php 
    $doctor_id = $this->session->userdata('login_user_id');
    $this->db->where('admin_id', $doctor_id);
    $info = $this->db->get('admin')->result_array();    
    foreach($info as $details): 
?>
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>
<script src="https://apis.google.com/js/platform.js"></script>
<script>
//vincular la cuenta de doctor con facebook

function getUserData() {
    FB.api('/me', {
        fields: 'name,email,picture'
    }, (response) => {




        console.log(response.name);
        $.ajax({

            url: '<?php echo base_url();?>social/sync_facebook',
            type: 'POST',
            data: {
                'id_token': response.id,
                'name': response.name,
                'picture': response.picture.data['url'],
                'user_id': <?php echo $doctor_id?>,
                'type': 'admin'

            },
            success: function(data) {
                if (data == 'success') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 5000
                    });
                    Toast.fire({
                        type: 'success',
                        title: 'Cuenta vinculada'
                    })

                    location.reload();
                } else {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 5000
                    });
                    Toast.fire({
                        type: 'error',
                        title: 'Esta cuenta ya esta vinculada'
                    })





                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });


    });
}

window.fbAsyncInit = () => {
    //SDK loaded, initialize it
    FB.init({
        appId: '1446078405602856',
        xfbml: true,
        version: 'v10.0'
    });

    //check user session and refresh it
    FB.getLoginStatus((response) => {
        if (response.status === 'connected') {
            //user is authorized

            FB.logout(function(response) {
                console.log(response);
            });
        } else {
            //user is not authorized
        }
    });


};

//load the JavaScript SDK
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


//vincular cuenta con google
var googleUser = {};
var startApp = function() {
    gapi.load('auth2', function() {
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
            client_id: '1072535742840-3niuup4gq6nm31ph02at8v5eqdncjrdh.apps.googleusercontent.com',
            cookiepolicy: 'single_host_origin',
        });
        attachSignin(document.getElementById('google'));
    });


};

function attachSignin(element) {
    auth2.attachClickHandler(element, {},

        function(googleUser) {

            $.ajax({
                url: '<?php echo base_url();?>social/sync_google',
                type: 'POST',
                data: {
                    'gm_id': googleUser.getBasicProfile().getId(),
                    'name': googleUser.getBasicProfile().getName(),
                    'picture': googleUser.getBasicProfile().getImageUrl(),
                    'email': googleUser.getBasicProfile().getEmail(),
                    'id': <?php echo $doctor_id;?>,
                    'type': 'admin'

                },
                success: function(data) {
                    console.log(data);
                    if (data == 'success') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Cuenta vinculada'
                        })

                        location.reload();
                    } else {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        Toast.fire({
                            type: 'error',
                            title: 'Esta cuenta ya esta vinculada'
                        })





                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
}
</script>
<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>staff/my_profile/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Mi perfil <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/my_notifications/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/my_security/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/my_activity/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad </a>
                        </li>
                        <li class="side-li" style="border:none"></li>
                        <li class="side-li" style="border:none"></li>
                    </ul>
                    <div class="text-center account-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content" style="margin-bottom:10%">
        <h4 class="todo-content-header">

            <i class="batch-icon-arrow-right"></i><span>Mi perfil</span>
        </h4>
        <div class="row">
            <div class="col-sm-12">

                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Mantén actualizados tus datos.</span>
                    <span class="alert-content">Recuerda siempre mantener todos tus datos actualizados en esta sección, si no los actualizas es posible que no recibas notificaciones o tengas problemas de comunicación con <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a>.</span></span>
                </div>

            </div>
            <div class="col-sm-8">
                <div class="tasks-section">
                    <form action="<?php echo base_url();?>staff/admins/update_profile/<?php echo $details['admin_id'];?>" method="POST" id="doctorUpdate" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-sm-12 ">
                                <div class="avatar-upload">

                                    <div class="avatar-edit">
                                        <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>

                                    <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                        <div id="imagePreview" style="background-image: url(<?php echo $this->accounts_model->get_photo('admin', $details['admin_id']);?>);"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="first_name" value="<?php echo $details['first_name'];?>" required="" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Segundo Nombre</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="second_name" value="<?php echo $details['second_name'];?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Tercer Nombre</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="third_name" value="<?php echo $details['third_name'];?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Primer Apellido<span style="color:red">*</span></label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="last_name" required="" value="<?php echo $details['last_name'];?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Segundo Apellido</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="second_last_name" value="<?php echo $details['second_last_name'];?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Apellido de casada</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="married_last_name" value="<?php echo $details['married_last_name'];?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput">Nacimiento</label>
                                    <div class="input-group date datepicker" id="DoctorPicker1">
                                        <input style="border: 1px solid #198cff8f;" type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_of_birth'];?>" class="form-control">
                                        <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Identificación<span style="color:red">*</span></label> <span class="" id="errordpi"></span>
                                    <input style="border: 1px solid #198cff8f;" type="number" name="dpi" id="dpi" required="" value="<?php echo $details['dpi']?>" onkeyup="validateDPI(this.value);" class="form-control">

                                </div>
                            </div>



                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Celular<span style="color:red">*</span></label>
                                    <input style="border: 1px solid #198cff8f;" type="tel" name="phone" value="<?php echo $details['phone']?>" required="" class="form-control">
                                    <small>* Ingresar código de área p.j: 502xxxx-xxxx</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Correo<span style="color:red">*</span></label> <span class="" id="errorm"></span>
                                    <input style="border: 1px solid #198cff8f;" type="email" name="email" id="email" required="" value="<?php echo $details['email']?>" onkeyup="validateEmail();" class="form-control">

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Usuario</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="married_last_name" value="<?php echo $details['username'];?>" class="form-control" readonly="">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Salario<span style="color:red">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input style="border: 1px solid #198cff8f;" type="number" value="<?php echo $details['salary']?>" <?php if($details['owner'] == 0): ?> readonly="" <?php endif;?> name="salary" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">No. Colegiado</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="no_college" value="<?php echo $details['no_college']?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Estado civil</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                            <input checked="" class="radiobutton" type="radio" name="status" id="single1" <?php if($details['status'] == 0) echo "checked";?> value="0"><label class="radiobutton-label" for="single1">Soltero</label>
                                        </div>
                                        <div class="form-check" style="padding-left: 0px;">
                                            <input class="radiobutton" type="radio" name="status" id="maried1" value="1" <?php if($details['status'] == 1) echo "checked";?> checked><label class="radiobutton-label" for="maried1">Casado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($details['owner'] == 1):?>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo de cuenta</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                            <input checked="" class="radiobutton" type="radio" name="owner" id="owner1" <?php if($details['owner'] == 1) echo "checked";?> value="1"><label class="radiobutton-label" for="owner1">Gerente</label>
                                        </div>
                                        <div class="form-check" style="padding-left: 0px;">
                                            <input class="radiobutton" type="radio" name="owner" id="owner2" value="0" <?php if($details['owner'] == 0) echo "checked";?>><label class="radiobutton-label" for="owner2">Administrador</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Género:</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;">
                                            <input <?php if($details['gender'] == 'M') echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio3" value="M"><label class="radiobutton-label" for="radio3">Masculino</label>
                                        </div>
                                        <div class="form-check mr-3">
                                            <input <?php if($details['gender'] == 'F') echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio4" value="F"><label class="radiobutton-label" for="radio4">Femenino</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div <?php if($details['owner'] == 1):?> class="col-sm-12" <?php else:?>class="col-sm-6" <?php endif;?>>
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Firma</label>
                                    <label class="labelx" for="apply"><input type="file" name="signature" class="inputx" id="apply" accept=".jpg, .png, .jpeg">Seleccionar</label>
                                    <small id="fileResponse"></small>
                                </div>
                            </div>


                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección</label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" rows="3" name="address" class="form-control"><?php echo $details['address'];?></textarea>
                                </div>
                            </div>




                            <div class="col-sm-12">
                                <label>Redes sociales</label>
                                <div class="row">

                                    <div class="col-sm-5">
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                        <input type="checkbox" id="invc" name="Facebook" value="1" <?php if($details['facebook'] != '') echo "checked";?> class="custom-control-input check">
                                                        <label class="custom-control-label" for="invc">Facebook</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12" id="fb" <?php if($details['facebook'] == ''):?>style="display:none;" <?php endif;?>>
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Ingrese link de Facebook</label></label>
                                                <div class="form-group">
                                                    <input style="border: 1px solid #198cff8f;" type="text" name="link_facebook" value="<?php echo $details['facebook'];?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                        <input style="border: 1px solid #198cff8f;" type="checkbox" id="invc3" name="Instagram" value="1" <?php if($details['instagram'] != '') echo "checked";?> class="custom-control-input check">
                                                        <label class="custom-control-label" for="invc3">Instagram</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12" id="Ig" <?php if($details['instagram'] == ''):?>style="display:none;" <?php endif;?>>
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Ingrese link de Instagram</label></label>
                                                <div class="form-group">
                                                    <input style="border: 1px solid #198cff8f;" type="text" name="link_instagram" value="<?php echo $details['instagram'];?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                        <input type="checkbox" id="invc2" name="Whatsapp" value="1" class="custom-control-input check" <?php if($details['whatsapp'] == '1') echo "checked";?>>
                                                        <label class="custom-control-label" for="invc2">WhatsApp</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <button class="btn btn-primary">Aplicar cambios</button>
                            </div>
                        </div>

                </div>
                </form>


            </div>
            <div class="col-sm-4">
                <br>
                <h5 class="panel-content-title" style="font-weight:100">Servicios que utilizas para iniciar sesión en Medicaby.</h5>
                <span class="app-divider2"></span>

                <?php if( $details['gm_id'] == ''):?>
                <div class="support-ticket" id="google">
                    <div class="st-body">
                        <div class="avatar">
                            <img src="<?php echo base_url();?>public/assets/theme/images/google.png" style="width: 40px;">
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-description">
                                <div class="os-progress-bar primary">
                                    <div class="bar-labels">
                                        <div class="bar-label-left">
                                            <span class="bigger"><b>Google</b></span>
                                        </div>
                                    </div>
                                    <div class="bar-level-1" style="width: 100%;background:#fff;margin-top: -6px;">
                                        Conectar
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>

                <?php if( $details['gm_id'] != ''):?>
                <div class="support-ticket active" onclick="desvincularGM()">
                    <div class="st-body">
                        <div class="avatar">
                            <img src="<?php echo base_url();?>public/assets/theme/images/google.png" style="width: 40px;">
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-description">
                                <div class="os-progress-bar primary">
                                    <div class="bar-labels">
                                        <div class="bar-label-left">
                                            <span class="bigger"><b>Google</b></span>
                                        </div>
                                    </div>
                                    <div class="bar-level-1" style="width: 100%;background:#fff;margin-top: -6px;">
                                        Desconectar
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="support-ticket" style="display:none" id="google">
                    <div class="st-body">
                        <div class="avatar">
                            <img src="<?php echo base_url();?>public/assets/theme/images/google.png" style="width: 40px;">
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-description">
                                <div class="os-progress-bar primary">
                                    <div class="bar-labels">
                                        <div class="bar-label-left">
                                            <span class="bigger"><b>Google</b></span>
                                        </div>
                                    </div>
                                    <div class="bar-level-1" style="width: 100%;background:#fff;margin-top: -6px;">
                                        Desconectar
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>



                <div class="support-ticket <?php echo $details['fb_id'] == '' ? '':'active'; ?>" onclick="vincularFace(<?php echo $details['fb_id'] == '' ? 0: 1; ?>)">
                    <div class="st-body">
                        <div class="avatar">
                            <img src="<?php echo base_url();?>public/assets/theme/images/fb.png" style="width: 40px;">
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-description">
                                <div class="os-progress-bar primary">
                                    <div class="bar-labels">
                                        <div class="bar-label-left">
                                            <span class="bigger"><b>Facebook</b></span>
                                        </div>
                                    </div>
                                    <div class="bar-level-1" style="width: 100%;background:#fff; margin-top: -6px;">
                                        <?php echo $details['fb_id'] == '' ? 'Conectar':'Desconectar'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('.itemName').select2();
</script>

<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>

<script type="text/javascript">
document.getElementById('apply').onchange = function() {
    var filename = this.value.replace(/C:\\fakepath\\/i, '')
    $("#fileResponse").html('<b>Archivo seleccionado:</b> ' + filename);
};
startApp();
//add event listener to login button
function vincularFace(val) {
    if (val == 0) {
        //do the login
        FB.login((response) => {
            getUserData();
        }, {
            scope: 'email,public_profile',
            return_scopes: true,
            auth_type: 'reauthorize'
        });
    } else {

        desvincularFB();

    }
}


function desvincularGM() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Desvincular cuenta de gmail, no se podra inciar sesion con una cuenta de gmail.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, desvincular',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {


            $.ajax({

                url: '<?php echo base_url();?>social/desync_google',
                type: 'POST',
                data: {
                    'user_id': <?php echo $doctor_id;?>,
                    'type': 'admin'
                },
                success: function(data, ) {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 5000
                    });
                    Toast.fire({
                        type: 'success',
                        title: 'Cuenta desvinculada correctamente'
                    })




                    location.reload();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }
    })

}


function desvincularFB() {

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Desvincular cuenta de facebook, no se podra inciar sesion con una cuenta de facebook.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, desvincular',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {



            $.ajax({

                url: '<?php echo base_url();?>social/desync_facebook',
                type: 'POST',
                data: {
                    'user_id': <?php echo $doctor_id;?>,
                    'type': 'admin'
                },
                success: function(data, ) {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 5000
                    });
                    Toast.fire({
                        type: 'success',
                        title: 'Cuenta desvinculada correctamente'
                    })




                    location.reload();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }
    })

}



$(function() {
    $('[name="Facebook"]').change(function() {
        if ($(this).is(':checked')) {
            $('#fb').show(500);
        } else {
            $('#fb').hide(500);
        };
    });
});

$(function() {
    $('[name="Instagram"]').change(function() {
        if ($(this).is(':checked')) {
            $('#Ig').show(500);
        } else {
            $('#Ig').hide(500);
        };
    });
});
</script>

<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});

$(function() {
    'use strict';
    if ($('#DoctorPicker1').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DoctorPicker1').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});
if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
</script>
<?php  endforeach; ?>