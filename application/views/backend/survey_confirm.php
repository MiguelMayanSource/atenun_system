<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Formulario de encuesta para pacientes - Medicaby">
    <meta name="author" content="Medicaby">
    <title>Formulario de encuesta | Medicaby</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="<?php echo base_url();?>public/assets/survey/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/assets/survey/css/menu.css" rel="stylesheet">
    <link href="<?php echo base_url();?>public/assets/survey/css/style.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/assets/survey/css/vendors.css" rel="stylesheet">
	<script src="<?php echo base_url();?>public/assets/survey/js/modernizr.js"></script>
    <script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
</head>
<body>
    <?php
        
        $patient_id = base64_decode($_id);

    ?>
    <style>
        .center_div{
        float: none;
        margin: 0 auto;
    }
    </style>
	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div>
	<div id="loader_form">
		<div data-loader="circle-side-2"></div>
	</div>
	<header>
		<div class="container">
		    <div class="row">
                <div class="col-12 center_div">
                    <a href="<?php echo base_url();?>">
                        <center><img src="<?php echo base_url();?>public/assets/frontend/images/logos/logo.png" alt="" width="15%" class="d-none d-md-block"><br></center>
                        <center><img src="<?php echo base_url();?>public/assets/frontend/images/logos/logo.png" alt="" width="30%" class="d-block d-md-none"></center>
                    </a>
                </div>
            </div>
		</div>
	</header>
	<div class="container" style="padding-left: 350px;margin-bottom: 90px;">
    <div id="form_container" style="padding: 10px;  width: 400px;   text-align: center;   left: 350px;">
        <div class="row">
            <?php 
                $query = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email_status;
                if($query == 1):
            ?>
            <div class="col-lg-12">
                <div id="left_form">
                    <figure><img src="<?php echo base_url();?>/public/uploads/survey.png" alt="" width="90%"></figure>
                    <h2>¡Hola, <span><?php echo $this->accounts_model->short_name('patient', $patient_id);?>!</span></h2>
                    <p>Quieres desactivar las notificaciones por correo electrónico, eso implica no recibir correos cuando se reprograme o confirme una cita, asi como promociones o recordatorios.</p>
	                <a href="#wizard_container" class="btn_1 rounded mobile_btn yellow" style="background:#dd2979;color:#fff;">Comencemos</a>
	              
                        <div id="bottom-wizard">
                            <button type="submit" name="process" class="submit"><span class="badge-confirmed" title="Confirmar" data-toggle="tooltip" data-placement="top" onclick="unsuscribe('<?php echo $patient_id;?>')">!Si continuar!</span></button>
                        </div>
          
                </div>
            </div>
            <?php else:?>
            <div class="container" style="padding:105px;text-align:center;">
                
                <div class="icon icon--order-success svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                        <g fill="none" stroke="#8EC343" stroke-width="2">
                            <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                            <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                        </g>
                    </svg>
                </div><br>
                <p>Se han desactivado las notificaciones por correo, si quieres activarlas debes contactar a tu clinica y solicitarlo.</p>
            </div>
            <?php endif;?>
        </div>
    </div>
    </div>
    <div class="cd-overlay-nav">
        <span></span>
    </div>
    <div class="cd-overlay-content">
        <span></span>
    </div>
	<script src="<?php echo base_url();?>public/assets/survey/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/survey/js/common_scripts.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/survey/js/velocity.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/survey/js/common_functions.js"></script>
	<script src="<?php echo base_url();?>public/assets/survey/js/func_1.js"></script>
	<script>
	            function unsuscribe(appointment_id)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se van a desactivar las notificaciones.",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>patient/confirm_unsuscribe/<?php echo $_id?>";
                }
            })
        }
	</script>
</body>
</html>