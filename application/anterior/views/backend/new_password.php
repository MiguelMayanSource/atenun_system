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
	<link rel="shortcut icon" href="<?php echo base_url();?>public/assets/theme/img/favicon/favicon.png" type="image/x-icon" />
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
    <style>
    .btn-google {
        border: none;
        width: 105px;
        background-color: #fff;
        color: #000;
        padding: 5px;
        border-radius: 15px;
        -webkit-box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);
        box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);
        margin-right: 18px;
    }
    .btn-facebook {
        border: none;
        width: 105px;
        background-color: #fff;
        color: #000;
        padding: 5px;
        border-radius: 15px;
        -webkit-box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);
        box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);
    }
    .btn-facebook:hover{
    	-webkit-transform: translateY(-2px);
        transform: translateY(-2px);
        -webkit-box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);
        box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);
    }
    .btn-google:hover{
    	-webkit-transform: translateY(-2px);
        transform: translateY(-2px);
        -webkit-box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);
        box-shadow: 0px 5px 12px rgba(126, 142, 177, 0.2);
    }
    .btn-login:hover{
    	background-color:#a01a7a; 
    	color:#fff!important;
    	-webkit-box-shadow: 0px 2px 5px rgba(69, 101, 173, 0.1);
          box-shadow: 0px 2px 5px rgba(69, 101, 173, 0.1);
        -webkit-transform: translateY(-1px) scale(1.03);
          transform: translateY(-1px) scale(1.03);
          transition:.3s;
    }
    .center_div{
        float: none;
        margin: 0 auto;
    }

    </style>
  
	<div class="wrapper" >
		<main class="container-fluid">
				       <?php if($this->session->flashdata('success') == '1'):?>
					        <div class="alert alert-success">
    						    ¡Enhorabuena! Te hemos enviado un correo con las instrucciones.
						    </div>
						<?php elseif($this->session->flashdata('error') == '1'):?>
						    <div class="alert alert-danger">
    						    ¡Oops! No hemos encontrado ninguna conicidencia con el nombre de usuario. ¿Lo ingresaste bien?
						    </div>
						<?php endif;?>
						
				 	    <?php 
            		        $token = base64_decode($_GET['auth']);
            		        $new_token = base64_decode($token);
            		        if (strpos($new_token, '*') !== false) {
                                $expire = strtotime($this->db->get_where('admin', array('auth_key' => $token))->row()->expire);   
                            }elseif (strpos($new_token, '#') !== false) {
                                $expire = strtotime($this->db->get_where('staff', array('auth_key' => $token))->row()->expire);   
                            }elseif (strpos($new_token, '&') !== false) {
                                $expire = strtotime($this->db->get_where('patient', array('auth_key' => $token))->row()->expire);   
                            }
                            $current = strtotime(date('d-m-Y H:i:s'));
                            if($current <= $expire):
            		    ?>
            <div class="login-wrapper row">
		        <div class="login-l col-lg-4 col-sm-12 col-md-12 center_div">
					<form method="post" role="form" class="login-form" action="<?php echo base_url();?>password/apply">	
					<input type="hidden" value="<?php echo $_GET['auth'];?>" name="src_key"/>
					  <center><a href="<?php echo base_url();?>"><img src="https://medicaby.com/resources/app-logo/iso.svg" style="margin-bottom:15px;margin-top:15px;width:95px"></a></center><br>
						<h3 style="font-family:'poppins', sans-serif;font-weight:normal;font-size:30px;text-align:center;margin-bottom:55px;">Nueva contraseña</h3>
						<div class="txtb">
							<input type="password" name="password" required="">
							<span data-placeholder="Elige tu nueva contraseña"></span>
						</div>
						<div>
						    <button class="btn btn-info btn-login btn-next" style="background:#5955a0!important;-webkit-box-shadow: 0px 2px 14px rgb(89, 85, 60 / 40%); box-shadow:0px 2px 14px rgb(89, 85, 60 / 40%);" type="submit"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> &nbsp; Confirmar</button>
						    <div style="width:100%;padding:15px;text-align:center;display:inline-block;margin-top:10px">
								<p><span class="otherlg"><a href="<?php echo base_url();?>" style="font-weight:500">Iniciar sesión</a></span></p>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php else:?>
			
			<div class="login-wrapper row">
				<div class="login-l col-lg-4 center_div" >
				    <form method="post" role="form" class="login-form" action="<?php echo base_url();?>password/request" >				
					        <center><a href="<?php echo base_url();?>"><img src="https://medicaby.com/resources/app-logo/iso.svg" style="margin-bottom:15px;margin-top:15px;width:95px"></a></center><br>
						        <div class="alert alert-danger">
    						        ¡Oops! Parece que el enlace que estás utilizando ha expirado. Solicita uno nuevo <a href="<?php echo base_url();?>password/recovery/">aquí</a>
    						    </div>
						    <div>
						</div>
					</form>
				</div>
			</div>
			<?endif;?>
		</main>
	</div>
	
	<script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/popper.js"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/moment.min.js"></script>
  	<script src="<?php echo base_url();?>public/assets/theme/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/script.js"></script>	
	
</body>
</html>