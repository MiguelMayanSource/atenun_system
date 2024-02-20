<?php $system_title = $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description; ?>
<?php $system_name = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="zarko-m">
    <meta name="description" content="Admin Dashboard">
	<title><?php echo $system_name;?> | <?php echo $system_title;?></title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link href="<?php echo base_url();?>public/assets/theme/css/dripicons.css" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
	<link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/batch-icons/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="<?php echo base_url();?>public/assets/theme/img/favicon/favicon.png" type="image/x-icon" />
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Pacifico&display=swap" rel="stylesheet">
	<div class="wrapper">
		<main class="container-fluid">
			<div class="login-wrapper row">
				<div class="login-l col-lg-4 center_div" >
				    <form method="post" role="form" class="login-form" action="<?php echo base_url();?>password/request" >				
					      <center><a href="<?php echo base_url();?>"><img src="https://medicaby.com/resources/app-logo/iso.svg" style="margin-bottom:15px;margin-top:15px;width:90px"></a></center><br>
					    <?php if($this->session->flashdata('success') == '1'):?>
					        <div class="alert alert-success">
    						    ¡Enhorabuena! Te hemos enviado un correo con las instrucciones.
						    </div>
						<?php elseif($this->session->flashdata('error') == '1'):?>
						    <div class="alert alert-danger">
    						    ¡Oops! No hemos encontrado ninguna conicidencia con el nombre de usuario. ¿Lo ingresaste bien?
						    </div>
						<?php endif;?>
						<h3 style="font-weight:normal;font-size:30px;text-align:center;margin-bottom:55px;" class="otherlg">Recupera tu contraseña</h3>
						<div class="txtb">
							<input type="text" name="username" required="">
							<span data-placeholder="¿Cuál es tu usuario?"></span>
						</div>
						<div>
						  <button class="btn btn-info btn-login btn-next" style="background:#5955a0!important" type="submit">Continuar</button>
						    <div style="width:100%;padding:15px;text-align:center;display:inline-block;margin-top:10px">
								<p><a href="<?php echo base_url();?>login" style="font-weight:500">Regresar</a></p>
							</div>
						</div>
					</form>
				</div>
			</div>
		</main>
	</div>
	<script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/popper.js"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/moment.min.js"></script>
  	<script src="<?php echo base_url();?>public/assets/theme/js/bootstrap.min.js?ver=1"></script>
	<script src="<?php echo base_url();?>public/assets/theme/js/script.js"></script>
</body>
</html>