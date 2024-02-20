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
	<title>Autenticación de doble factor | <?php echo $system_title;?></title>
	<link href="<?php echo base_url();?>public/assets/theme/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link href="<?php echo base_url();?>public/assets/theme/css/dripicons.css" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/style.css?ver=1.1.1">
	<link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/batch-icons/style.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Pacifico&display=swap" rel="stylesheet">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>public/assets/theme/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>public/assets/theme/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>public/assets/theme/img/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url();?>public/assets/theme/img/site.webmanifest">
    <link rel="mask-icon" href="<?php echo base_url();?>public/assets/theme/img/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>



<body>
	<div class="wrapper" >
		<main class="container-fluid">
			<div class="login-wrapper row">
				<div class="login-l col-lg-4 col-sm-12 col-md-12 center_div">
				    <form method="post" role="form" class="login-form" action="<?php echo base_url();?>login/validate/" >				
					    <center><a href="<?php echo base_url();?>"><img src="https://medicaby.com/resources/app-logo/iso.svg" style="margin-bottom:15px;margin-top:15px;"></a></center><br>
					    <?php if($this->session->flashdata('error') == '1'):?>
						    <div class="alert alert-danger" >
    						    ¡Lo sentimos! Parece que el PIN ingresado no es válido.
						    </div>
						<?php endif;?> 
						<label style="color:#a7a5a5;font-family:'Poppins',sans-serif;font-size:14.5px">Tu cuenta tiene habilitada la autenticación de doble factor, deberás ingresar el PIN de tu App para poder continuar.</label>
						<input type="hidden" name="val" value="<?php echo $val;?>">
						<input type="hidden" name="type" value="<?php echo $type;?>">
						<div class="txtb">
							<input name="pin" type="text" maxlength="6" required="">
							<span data-placeholder="Ingresar PIN"></span>
						</div>
						<div>
						    <button class="btn btn-info btn-login btn-next" style="background-color: #5955a0!important;" type="submit"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> &nbsp; Continuar a mi cuenta</button>
						    <div style="width:100%;padding:15px;text-align:center;display:inline-block;margin-top:10px">
						        <hr>
								<p>
								<a href="<?php echo base_url();?>login/" style="font-family: 'Pacifico', sans-serif;color: #f18518;font-size: 19px; text-align: center; text-decoration:none;">Regresar</a></p>
							    
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


</script>
		</main>
	</div>
	<script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/popper.js"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/moment.min.js"></script>
  	<script src="<?php echo base_url();?>public/assets/theme/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/script.js"></script>

</body>
</html>