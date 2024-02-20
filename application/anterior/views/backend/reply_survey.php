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
    <?php
        $survey_data = base64_decode($_GET['id']);
        $exploded_data = explode('-',$survey_data);
        $survey_id = $exploded_data[1];
        $patient_id = $exploded_data[2];
        $appointment_id = $exploded_data[3];
        $practice_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
        if($practice_id > 0){
            $appointment_name = $this->db->get_where('service', array('service_id' => $practice_id))->row()->name;   
        }else{
            $appointment_name = 'Otros servicios';
        }
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
            <?php 
                $query = $this->db->get_where('survery_result', array('survey_id' => $survey_id, 'patient_id' => $patient_id))->num_rows();
                if($query == 0):
            ?>
            <div class="col-lg-4">
                <div id="left_form">
                    <figure><img src="<?php echo base_url();?>public/assets/survey.png" alt="" width="90%"></figure>
                    <h2>¡Gracias <span><?php echo $this->accounts_model->short_name('patient', $patient_id);?>!</span></h2>
                    <p>Por tomarte unos minutos para ayudarnos a mejorar la calidad de nuestros servicios. Por favor llena la siguiente encuesta.</p>
	                <a href="#wizard_container" class="btn_1 rounded mobile_btn yellow" style="background:#dd2979;color:#fff;">Comencemos</a>
                </div>
            </div>
            <div class="col-lg-8">
                <div id="wizard_container">
                    <div id="top-wizard">
                        <div id="progressbar"></div>
                        <span id="location"></span>
                    </div>
                    <form id="wrapped" method="post">
                        <input id="website" name="website" type="text" value="">
                        <div id="middle-wizard">
                            <?php 
                                $questions = $this->db->get_where('question', array('survey_id' => $survey_id))->result_array();
                                foreach($questions as $row):
                            ?>
                            <input type="hidden" name="survey_id" value="<?php echo $survey_id;?>"/>
                            <input type="hidden" name="src_key" value="<?php echo $patient_id;?>"/>
                            <?php if($row['type'] == 'satisfaction'):?>
                            <div class="step">
                                <h3 class="main_question"><i class="arrow_right"></i><?php echo $row['question'];?></b></h3>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="container_check version_2">1
                                                <input type="radio" name="<?php echo $row['question_id'];?>[]" value="1" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="container_check version_2">2
                                                <input type="radio" name="<?php echo $row['question_id'];?>[]" value="2" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="container_check version_2">3
                                                <input type="radio" name="<?php echo $row['question_id'];?>[]" value="3" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="container_check version_2">4
                                                <input type="radio" name="<?php echo $row['question_id'];?>[]" value="4" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="container_check version_2">5
                                                <input type="radio" name="<?php echo $row['question_id'];?>[]" value="5" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php elseif($row['type'] == 'multiple_choice'):?>
                                <div class="step">
                                    <h3 class="main_question"><i class="arrow_right"></i><?php echo $row['question'];?></h3>
                                    <div class="form-group">
                                        <?php
                                            if ($row['options'] != '' || $row['options'] != null){
                                                $options = json_decode($row['options']);   
                                            }
                                            else{
                                                $options = array();
                                            }
                                            for ($i = 0; $i < $row['number_of_options']; $i++):
                                        ?>
                                            <label class="container_radio version_2"> <?php echo $options[$i];?>
                                                <input type="radio" name="<?php echo $row['question_id'].'[]'; ?>" value="<?php echo $options[$i];?>" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        <?php endfor;?>
                                    </div>
                                </div>
                            <?php elseif($row['type'] == 'text'):?>
                                <div class="step">
                                    <h3 class="main_question"><i class="arrow_right"></i><?php echo $row['question'];?></h3>
                                    <div class="form-group">
                                        <label for="phone">Esciba su respuesta</label>
                                        <textarea class="form-control required" name="<?php echo $row['question_id']; ?>[]" rows="5"></textarea>
                                    </div>
                                </div>
                            <?php endif;?>
                            <?php endforeach;?>
                            <div class="submit step" id="end">
                                <div class="summary">
                                    <div class="wrapper">
                                        <h3>¡Gracias por tu tiempo<br><span><?php echo $this->accounts_model->short_name('patient', $patient_id);?></span>!</h3>
                                        <p>Estaremos encantados de poder leer tus comentarios y sugerencias. <br><br>Para finalizar y enviar la encuesta haz clic sobre el botón <strong>Enviar</strong>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bottom-wizard">
                            <button type="button" name="backward" class="backward">Anterior</button>
                            <button type="button" name="forward" class="forward">Siguiente</button>
                            <button type="submit" name="process" class="submit">Enviar</button>
                        </div>
                    </form>
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
                <h1>Ya has respondido a esta encuesta, muchas gracias.</h1>
            </div>
            <?php endif;?>
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