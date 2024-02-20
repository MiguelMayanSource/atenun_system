<?php $system_title = $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description; ?>
<?php $system_name = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Medicaby">
    <meta name="description" content="Medicaby - El software más completo para el control clínico en la nube">
	<title><?php echo $system_name;?> | <?php echo $system_title;?></title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link href="<?php echo base_url();?>public/assets/theme/css/dripicons.css" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/style.css?ver=1.1.2">
	<link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/batch-icons/style.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Pacifico&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="<?php echo base_url();?>public/assets/theme/img/favicon/favicon.png" type="image/x-icon" />
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
    
            function getUserData() {
            	FB.api('/me', {fields: 'name,email,picture'}, (response) => {
            	        console.log(response.id);
            	        $.ajax({
                                   
                                 url: '<?php echo base_url();?>login/facebook',
                                    type: 'POST',
                                    data: {'id_token':response.id},
                                    success: function (data,) {
                                      console.log(data);
                                        if(data!="error")
                                            window.location.href = '<?php echo base_url();?>'+data;
                                        else
                                            location.reload();
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
            		version    : 'v2.2'
            	});
            
            	//check user session and refresh it
            	FB.getLoginStatus((response) => {
            		if (response.status === 'connected') {
            			//user is authorized
            			console.log(response);
            			
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
              var startApp = function() {
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
                console.log(element.id);
                auth2.attachClickHandler(element, {},
                    function(googleUser) {
                     
	                    $.ajax({ 
														url: '<?php echo base_url();?>login/google',
															type: 'POST',
															data: {'gm_id':googleUser.getBasicProfile().getId(),
																	'name':googleUser.getBasicProfile().getName(),
																	'picture':googleUser.getBasicProfile().getImageUrl(),
																	'email':googleUser.getBasicProfile().getEmail(),
																	
															},
															success: function (data) {
																console.log(data);
																if(data!="error")
                                    window.location.href = '<?php echo base_url();?>'+data;
																else
                                    location.reload();
						
															},
															error: function (jqXHR, textStatus, errorThrown) {
																console.log(errorThrown);
															}
														});
                     
                    }, function(error) {
                      
                    });
              }
  </script>
</head>



<body>
	<div class="wrapper" >
		<main class="container-fluid">
			<div class="login-wrapper row">
				<div class="login-l col-lg-4 col-sm-12 col-md-12 center_div">
				    <form method="post" role="form" class="login-form" action="<?php echo base_url();?>login/auth/" >				
					    <center><a href="<?php echo base_url();?>"><img src="https://medicaby.com/resources/app-logo/iso.svg" style="margin-bottom:15px;margin-top:15px;width:95px"></a></center><br>
					    <?php if($this->session->flashdata('success_pass') == '1'):?>
					        <div class="alert alert-success">
    						    ¡Enhorabuena! Tu contraseña ha cambiado, ahora puedes iniciar sesión.
						    </div>
						<?php elseif($this->session->flashdata('error') == '1'):?>
						    <div class="alert alert-danger" >
    						    ¡Oops! No hemos encontrado ninguna conicidencia con el nombre de usuario. ¿Lo ingresaste bien?
						    </div>
						<?php endif;?> 
						<?php if($this->session->flashdata('errorgm') == '1'):?>
						    <div class="alert alert-danger" >
    						   ¡Disculpa! No hemos encontrado ninguna cuenta asociada a este correo.
						    </div>
						<?php endif;?> 
						<div class="txtb">
							<input type="text" name="username" id="user" required="">
							<span data-placeholder="Usuario"></span>
						</div>
						<div class="txtb">
							<input type="password" name="password" id="password" required="">
							<span data-placeholder="Contraseña"></span>
						</div>
						<div>
						    <button class="btn btn-info btn-login btn-next" style="background:#5955a0!important;-webkit-box-shadow: 0px 2px 14px rgb(89, 85, 60 / 40%); box-shadow:0px 2px 14px rgb(89, 85, 60 / 40%);" type="submit"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> &nbsp; Ir a mi cuenta</button>
						    <div style="width:100%;padding:15px;text-align:center;display:inline-block;margin-top:10px;">
						        <span class="otherlg">o accede utilizando:</span>
						        <hr>
								<div ></div>
								<button  type="button"  class="btn-google" id="google"> <img style="width:15px;" src="<?php echo base_url();?>public/assets/theme/img/google_login.svg"></button>
								<button  type="button" class="btn-facebook" id="loginBtn"><img style="width:18px;" src="<?php echo base_url();?>public/assets/theme/img/facebook_login.svg"></button>
								<p><a href="<?php echo base_url();?>password/recovery" style="font-weight:bold;font-family: 'Poppins', sans-serif; text-decoration:none;" >¿Olvidaste tu contraseña?</a></p>
							    
							</div>
						</div>
					</form>
				</div>
			</div>
		
	
		<script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
<script>

            //add event listener to login button
            document.getElementById('loginBtn').addEventListener('click', () => {
            	//do the login
            	FB.login((response) => {
            		if (response.authResponse) {
            			getUserData();
            		}
            	}, {scope: 'email,public_profile', return_scopes: true});
            }, false);


startApp();

  function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
        });
        auth2.disconnect();
  }
  
  
</script>
	</main>
	</div>
	<script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/popper.js"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/moment.min.js"></script>
  	<script src="<?php echo base_url();?>public/assets/theme/js/bootstrap.min.js?ver=1"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/script.js"></script>

</body>
</html>