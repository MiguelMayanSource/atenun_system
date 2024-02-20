<?php 
    $patient_id = $this->session->userdata('login_user_id');
    $this->db->where('patient_id', $patient_id);
    $info = $this->db->get('patient')->result_array();    
    foreach($info as $details):
?>
    <link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script>
        //vincular la cuenta de doctor con facebook
        function getUserData() {
        	FB.api('/me', {fields: 'name,email,picture'}, (response) => {
            console.log(response.name);
            $.ajax({
                url: '<?php echo base_url();?>social/sync_facebook',
                type: 'POST',
                data: {'id_token':response.id,
                    'name':response.name,
                    'picture':response.picture.data['url'],
                    'user_id':<?php echo $patient_id?>,
                    'type': 'patient'
                },
                success: function (data) {
                    if(data=='success')
                    {
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
                    }else{
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
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
    	});
    }
            
            window.fbAsyncInit = () => {
            	//SDK loaded, initialize it
            	FB.init({
            		appId      : '1446078405602856',
            		xfbml      : true,
            		version    : 'v10.0'
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
          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "https://connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
        
var googleUser = {};
  var startApp = function() 
  {
    gapi.load('auth2', function(){
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
                                      data: {'gm_id':googleUser.getBasicProfile().getId(),
                                              'name':googleUser.getBasicProfile().getName(),
                                              'picture':googleUser.getBasicProfile().getImageUrl(),
                                              'email':googleUser.getBasicProfile().getEmail(),
                                              'id':<?php echo $patient_id;?>,
                                               'type': 'patient'
                                              
                                      },
                                      success: function (data) {
                                          console.log(data);
                            if(data=='success')
                            {
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
                        }else
                        {
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
                    error: function (jqXHR, textStatus, errorThrown) {
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
                            <a class="side-items active" href="<?php echo base_url();?>patient/dashboard/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0703_users_profile_group_two"></i> Perfil <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/chat/"><i class="iconBox picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i> Chat </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/medical_history/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_security/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/medical_prescriptions/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i> Recetas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_files/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0119_folder_open_full_documents"></i> Archivos </a>
                        </li>
                        <?php  
                            $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                            if($odonto != ''):
                        ?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/treatment/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0826_teeth_tooth_dental"></i> Planes de tratamiento </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_appointments/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>patient/patient_financial/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0425_money_payment_dollar_cash"></i> Financiero </a>
                        </li>
                    </ul>
                    <div class="text-center account-container"></div>
                </div>
            </div>
            </div>
        </div>
        <div class="todo-content" style="margin-bottom:15%">
            <h4 class="todo-content-header">
                <i class="batch-icon-arrow-right"></i><span>Tu perfil</span>
            </h4>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info">
                        <span class="alert-title"><i class="batch-icon-spam"></i> Visualiza tus datos.</span>
                        <span class="alert-content">Recuerda de siempre mantener todos tus datos actualizados en <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a>.</span></span>
                    </div>  
                </div>
                <div class="col-sm-8">
                    <div class="tasks-section">
                                <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $details['patient_id']; ?>"/>
    		                    <input type="hidden" name="profile" value="1" required="" class="form-control">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="avatar-upload">
                                        <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                            <div id="imagePreview" style="background-image: url(<?php echo $this->accounts_model->get_photo('patient', $patient_id);?>);"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
    	                                <div class="form-group m-b-15">
           		                            <label for="simpleinput">Primer nombre:</label></label>
    	                                    <input type="text" style="border: 1px solid #198cff8f;" name="first_name" required="" value="<?php echo $details['first_name'] ?>" class="form-control" readonly="">
    	                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
    	                                <div class="form-group m-b-15">
           		                            <label for="simpleinput">Segundo nombre:</label>
    	                                    <input type="text" style="border: 1px solid #198cff8f;" name="second_name"  value="<?php echo $details['second_name'] ?>" class="form-control" readonly="">
    	                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
    	                                <div class="form-group m-b-15">
           		                            <label for="simpleinput">Tercer nombre:</label>
    	                                    <input type="text" style="border: 1px solid #198cff8f;" name="third_name"  value="<?php echo $details['third_name'] ?>" class="form-control" readonly="">
    	                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
    	                                <div class="form-group m-b-15">
           		                            <label for="simpleinput">Primer apellido:</label></label>
    	                                    <input type="text" style="border: 1px solid #198cff8f;" name="last_name" required="" value="<?php echo $details['last_name'] ?>" class="form-control" readonly="">
    	                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
    	                                <div class="form-group m-b-15">
           		                            <label for="simpleinput">Segundo apellido:</label>
    	                                    <input type="text" style="border: 1px solid #198cff8f;" name="second_last_name"  value="<?php echo $details['second_last_name'] ?>" class="form-control" readonly="">
    	                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
    	                                <div class="form-group m-b-15">
           		                            <label for="simpleinput">Apellido de casada:</label>
    	                                    <input type="text" style="border: 1px solid #198cff8f;" name="married_last_name"  value="<?php echo $details['married_last_name'] ?>" class="form-control" readonly="">
    	                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
                                    <div class="form-group date-time-picker m-b-15">
                                        <label for="simpleinvput">Nacimiento</label></label>
            			                <div class="input-group date datepicker" id="DoctorPicker1">
            	                           <input type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_of_birth'];?>" class="form-control" readonly="">
            	        		           <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
            			               </div>
            		                </div>
    	                        </div>
    	                         <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>¿Notificaciones por correo?</label>
                                        <div class="custom-control custom-radio">
                                        	<input type="radio" id="email1" name="email_status" value="1" <?php if($details['email_status'] == 1) echo "checked";?> class="custom-control-input" disabled="">
    	                                	<label class="custom-control-label" for="email1">Si</label>
                                    	</div>
                                		<div class="custom-control custom-radio"> 
                                        	<input type="radio" id="email2" name="email_status" value="0" <?php if($details['email_status'] == 0) echo "checked";?> class="custom-control-input" disabled="">
    	                                	<label class="custom-control-label" for="email2">No</label>
                                	</div>
                                    </div>
                                 </div>
    	                        <div class="col-sm-6">
    	                                <div class="form-group m-b-15"></label>
           		                            <label for="simpleinput">DPI:</label>
    	                                    <input type="text" style="border: 1px solid #198cff8f;" onkeyup="validateDPI(this.value);" name="dpi" maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required="" value="<?php echo $details['dpi'] ?>" class="form-control" readonly="">
    	                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
    	                                <div class="form-group m-b-15">
           		                            <label for="simpleinput">Profesión/Ocupación:</label>
    	                                    <input type="text" style="border: 1px solid #198cff8f;" name="profession" required="" value="<?php echo $details['profession'] ?>" class="form-control" readonly="">
    		                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
    	                                <div class="form-group m-b-15"></label>
           		                            <label for="simpleinput">Tipo sanguíneo:</label>
    	                                    <input type="text" style="border: 1px solid #198cff8f;" name="blood" required="" value="<?php echo $details['blood'] ?>" class="form-control" readonly="">
    		                                </div>
    	                            </div>
                                    <div class="col-sm-6">
    	                                <div class="form-group m-b-15"></label>
           		                            <label for="simpleinput">Correo:</label>
    	                                    <input type="email" style="border: 1px solid #198cff8f;" name="email" required="email" value="<?php echo $details['email'] ?>" class="form-control" onkeyup="validateEmail();" readonly="">
    	                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
    	                                <div class="form-group m-b-15"></label>
           		                            <label for="simpleinput">Teléfono de contacto:</label>
    	                                    <input type="number"  style="border: 1px solid #198cff8f;" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="phone_contact" required="" value="<?php echo $details['phone_contact'] ?>" class="form-control" readonly="">
    		                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
    	                                <div class="form-group m-b-15">
           		                            <label for="simpleinput">Celular de contacto:</label>
    	                                    <input type="number" style="border: 1px solid #198cff8f;" name="phone" required="" value="<?php echo $details['phone'] ?>" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  class="form-control" readonly="">
    		                                </div>
    	                            </div>
    	                            <div class="col-sm-6">
    		                            <div class="form-group">
    		                                <label>Notificaciones por WhatsApp:</label>
    		                                <div class="custom-control custom-radio">
    		                                    <input type="radio" id="wha2" name="whatsapp_status" value="1" <?php if($details['whatsapp_status'] == 1) echo "checked";?> class="custom-control-input" disabled="">
        		                                <label class="custom-control-label" for="wha2">Sí</label>
    		                                </div>
    		                            <div class="custom-control custom-radio">
    		                                <input type="radio" id="wha" name="whatsapp_status" value="0" <?php if($details['whatsapp_status'] == 0) echo "checked";?> class="custom-control-input" disabled="">
        		                            <label class="custom-control-label" for="wha">No</label>
    		                            </div>
    		                            </div>
    		                        </div>
    	                              <div class="col-sm-12">
    		                            <div class="form-group m-b-15">
            		                        <label for="simpleinput">Dirección:</label>
    		                                <textarea readonly="" rows="5" type="text" style="border: 1px solid #198cff8f;" name="address" class="form-control"><?php echo $details['address'];?></textarea>
    		                            </div>
    		                        </div>
    	                            <div class="col-sm-6">
    	                                <div class="form-group">
    	                                    <label>Género:</label>
    	                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;">
                                          <input <?php if($details['gender'] == "M") echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio3" value="M" disabled=""><label class="radiobutton-label" for="radio3">Masculino</label>
                                        </div>
                                        <div class="form-check mr-3">
                                          <input <?php if($details['gender'] == "F") echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio4" value="F" disabled=""><label class="radiobutton-label" for="radio4">Femenino</label>
                                        </div>
                                        </div>
    		                        </div>
    		                        </div>
    		                        
    		                        <div class="col-sm-6">
    		                            <div class="form-group">
    	                                    <label>Estado civil:</label>
    	                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;">
                                          <input <?php if($details['status'] == 0) echo "checked";?> class="radiobutton" type="radio" name="status" id="single1" value="0" disabled=""><label class="radiobutton-label" for="single1">Soltero</label>
                                        </div>
                                        <div class="form-check mr-3">
                                          <input <?php if($details['status'] == 1) echo "checked";?> class="radiobutton" type="radio" name="status" id="married1" value="1" disabled=""><label class="radiobutton-label" for="married1">Casado</label>
                                        </div>
                                        </div>
    		                        </div>
    		                        </div>
    		                        
                                </div>
                        </div>
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
                                        <div class="support-ticket active" onclick="desvincularGM()" >
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
        
    <script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
    <script>
        var sidebar = new StickySidebar('#sticky', {topSpacing: 10});
        function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
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
            if($('#DoctorPicker1').length) {
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                $('#DoctorPicker1').datepicker({
                    format: "dd/mm/yyyy",
                    todayHighlight: true,
                    autoclose: true
                });
            }
        });
        $('.ae-side-menu-toggler').on('click', function () {
            $('.app-side').toggleClass('compact-side-menu');
        });
        if ($('.app-side').length) {
            if (is_display_type('phone') || is_display_type('tablet')) {
                $('.app-side').addClass('compact-side-menu');
            }
        }
    </script>

    
    <script type="text/javascript">
            startApp(); 
            //add event listener to login button
 function vincularFace(val)
 {
     if(val == 0 )
     {
    	//do the login
    	FB.login((response) => 
        {
    		getUserData();
    	}, {scope: 'email,public_profile', return_scopes: true, auth_type: 'reauthorize'});
     }else
     {

        desvincularFB();

     }
 } 
    
    
      function desvincularGM()
  {
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
                if (result.value) 
                {
                                
      
                    $.ajax({
                       
                       url: '<?php echo base_url();?>social/desync_google',
                          type: 'POST',
                          data: {'user_id':<?php echo $patient_id;?>,
                                 'type':'patient'  },
                          success: function (data,) {
                            
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
                          error: function (jqXHR, textStatus, errorThrown) {
                              console.log(errorThrown);
                          }
                      });

                }
            })   
           
  }
  
  
        function desvincularFB()
  {

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
                if (result.value) 
                {
                                
      
      
                    $.ajax({
                       
                       url: '<?php echo base_url();?>social/desync_facebook',
                          type: 'POST',
                          data: {'user_id':<?php echo $patient_id;?>,
                                 'type':'patient' },
                          success: function (data,) {
                            
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
                          error: function (jqXHR, textStatus, errorThrown) {
                              console.log(errorThrown);
                          }
                      });

                }
            })   
  
  }
            
            
            
            $(function()
            {
              $('[name="Facebook"]').change(function()
              {
                if ($(this).is(':checked')) {
                    $('#fb').show(500);
                }
                else{
                    $('#fb').hide(500);
                };
              });
            });
            
            $(function()
            {
              $('[name="Instagram"]').change(function()
              {
                if ($(this).is(':checked')) {
                    $('#Ig').show(500);
                }
                else{
                    $('#Ig').hide(500);
                };
              });
            });
        </script>
	    
    <script>
     function readURL(input) 
     {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() 
    {
        readURL(this);
    });

    $(function() 
    {
            'use strict';
            if($('#DoctorPicker1').length) {
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                $('#DoctorPicker1').datepicker({
                    format: "dd/mm/yyyy",
                    todayHighlight: true,
                    autoclose: true
                });
            }
        });
        $('.ae-side-menu-toggler').on('click', function () {
            $('.app-side').toggleClass('compact-side-menu');
        });
        if ($('.app-side').length) {
            if (is_display_type('phone') || is_display_type('tablet')) {
                $('.app-side').addClass('compact-side-menu');
            }
        }
    </script>


<?php  endforeach; ?>