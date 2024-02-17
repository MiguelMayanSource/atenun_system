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
</head>
<body>
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
                    <a href="javascript:void(0);">
                        <center><img src="<?php echo base_url();?>public/assets/frontend/images/logos/logo.png" alt="" width="15%" class="d-none d-md-block"><br></center>
                        <center><img src="<?php echo base_url();?>public/assets/frontend/images/logos/logo.png" alt="" width="30%" class="d-block d-md-none"></center>
                    </a>
                </div>
            </div>
		</div>
	</header>
	<div class="container">
    <div id="form_container">
        <div class="row no-gutters">
            <div class="container" style="padding:105px;text-align:center;">
                
                <div class="icon icon--order-success svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                        <g fill="none" stroke="#8EC343" stroke-width="2">
                            <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                            <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                        </g>
                    </svg>
                </div><br>
                <h1>Hemos recibido tu respuesta, la analizaremos y haremos algunos cambios de ser necesario 👨‍⚕️ ¡Hasta pronto!</h1>
            </div>
        </div>
    </div>
    </div>
    <div class="container">
        <footer id="home" class="clearfix">
            <p>© <?php echo date('Y');?> Medicaby</p>
            <ul>
                <li><a href="<?php echo base_url();?>" target="_blank" class="animated_link" target="_parent">Ofrecido por Medicaby.</a></li>
            </ul>
        </footer>
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
</body>
</html>