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
	<link rel="stylesheet" href="<?php echo base_url();?>public/assets/back/css/colorPick.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <style>
        .center_div{
        float: none;
        margin: 0 auto;
    }
    .picker {
        border-radius: 5px;
        width: 36px;
        height: 36px;
        cursor: pointer;
        -webkit-transition: all linear .2s;
        -moz-transition: all linear .2s;
        -ms-transition: all linear .2s;
        -o-transition: all linear .2s;
        transition: all linear .2s;
        border: thin solid #eee;
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
                <div class="col-12 center_div"></div>
            </div>
		</div>
	</header>
	<div class="container">
    <div id="form_container">
        <div class="row no-gutters">
            <div class="col-lg-4">
                <div id="left_form" style="background:#020630">
                    <figure><img src="https://medicaby.com/resources/app-logo/logo-white.svg" alt="" width="90%"></figure><br><br>
                    <h2>Asistente de instalación</h2>
                    <p>Gracias por utilizar Medicaby, para poder utilizar la aplicación por favor completa los siguientes pasos.</p>
                    <p>Toma en cuenta que la mayoría son campos obligatorios.</p>
	                <a href="#wizard_container" class="btn_1 rounded mobile_btn yellow" style="background:#dd2979;color:#fff;">Comencemos</a>
                </div>
            </div>
            <div class="col-lg-8">
                <div id="wizard_container">
                    <div id="top-wizard">
                        <div id="progressbar"></div>
                        <span id="location"></span>
                    </div>
                    <form action="<?php echo base_url();?>contract/createClinic" method="POST" enctype="multipart/form-data">
                        <input id="website" name="website" type="text" value="">
                        <div id="middle-wizard">
                            <div class="step">
                                <h3 class="main_question"><i class="arrow_right"></i>Datos de la clínica</b></h3>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Nombre:</label>
                                            <input class="form-control required" name="name" placeholder="¿Cuál es el nombre de tu clínica?" type="text"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Teléfono:</label>
                                            <input class="form-control required" name="phone" placeholder="¿Cuál es el teléfono de tu clínica?" type="number"/>
                                            <small>* Ingresar código de área p.j: 502xxxxxxxx</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Correo:</label>
                                            <input class="form-control required" name="email" placeholder="¿Cuál es el correo de tu clínica?" type="email"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Dirección:</label>
                                            <textarea class="form-control required" name="address" placeholder="Proporciona la dirección de tu clínica"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Moneda:</label>
                                            <select class="form-control" name="currency" required="">
                                                <option value="">Seleccionar</option>
                                                <option value="Q">Guatemala.</option>
						                        <option value="MXN$">México.</option>
						                        <option value="L">Honduras.</option>
						                        <option value="RD$">Republica Dominicana.</option>
                                                <option value="US$">USA.</option>
                                                <option value="€">España.</option>
                                                <option value="AR$">Argentina.</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="phone">Elige un color:</label>
		                                    <div class="picker"></div>
		                                    <input type="hidden" id="theme" name="theme">
		                                    <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step">
                                <h3 class="main_question"><i class="arrow_right"></i>Configuremos tus horarios de atención</h3>
                                <div class="row">
                                    <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="">Horario matutino <small>(Inicial)</small></label>
        		                            <div class="input-group clockpicker" data-align="bottom" data-autoclose="true">
                                                <div class="input-group date timepicker" id="horainicio" data-target-input="nearest">
								                    <input type="time" name="morning" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio" value=" 07:00">
								                </div>
                                            </div>
                                        </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Horario matutino <small>(Final)</small></label>
        		                            <div class="input-group clockpicker" data-align="bottom" data-autoclose="true">
                                                <div class="input-group date timepicker"  id="horainicio2" data-target-input="nearest">
								                    <input type="time" name="b_morning" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio2" value=" 01:00">
								                </div>
                                            </div>
                                        </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Horario vespertino <small>(Inicial)</small></label>
        		                            <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                                <div class="input-group date timepicker" id="horainicio3" data-target-input="nearest">
								                    <input type="time" name="afternoon" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio3" value=" 02:00">
								                </div>
                                            </div>
                                        </div>
		                            </div>
		                            <div class="col-sm-6">
		                                <div class="form-group m-b-15">
        		                            <label for="simpleinput">Horario vespertino <small>(Final)</small></label>
        		                            <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                                <div class="input-group date timepicker" id="horainicio4" data-target-input="nearest">
								                    <input type="time" name="b_afternoon" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio4" value=" 06:00">
								                </div>
                                            </div>
                                        </div>
		                            </div>
		                            <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Intervalo de tiempo entre citas:</label>
                                            <input class="form-control required" name="time_interval" placeholder="¿Cuál es la duración promedio de tus citas?" type="number"/>
                                            <small>Ingresar duración en minutos, por ejemplo: 30</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step">
                                <h3 class="main_question"><i class="arrow_right"></i>Ahora crearemos tu cuenta</h3>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Primer nombre:</label>
                                            <input class="form-control required" name="first_name" type="text"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Segundo nombre:</label>
                                            <input class="form-control" name="second_name" type="text"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tercer nombre:</label>
                                            <input class="form-control" name="third_name" type="text"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Primer Apellido:</label>
                                            <input class="form-control required" name="last_name" type="text"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Segundo Apellido:</label>
                                            <input class="form-control" name="second_last_name" type="text"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Apellido de casada:</label>
                                            <input class="form-control" name="married_last_name" type="text"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Correo:</label>
                                            <input class="form-control required" name="emailx" type="email"/>
                                            <small>Lo usaremos para enviar tus accesos</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Celular:</label>
                                            <input class="form-control required" name="phonex" type="phone"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Dirección:</label>
                                            <textarea class="form-control required" name="addressx"></textarea>
                                        </div>
                                    </div>
                                </div>
                            
                            </div> 
                            <div class="submit step" id="end">
                                <div class="summary">
                                    <div class="wrapper">
                                        <h3>¡Casi terminamos!</h3>
                                        <p>Hemos completado el formulario. <br><br>Para finalizar y completar la instalación haz clic sobre el botón <strong>Instalar</strong>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bottom-wizard">
                            <button type="button" name="backward" class="backward">Anterior</button>
                            <button type="button" name="forward" class="forward">Siguiente</button>
                            <button type="submit" name="process" class="submit">Instalar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container">
        <footer id="home" class="clearfix">
            <p>© <?php echo date('Y');?> Medicaby</p>
            <ul>
                <li><a href="<?php echo base_url();?>" target="_blank" class="animated_link" target="_parent">Medicaby un producto de Mayan Source.</a></li>
            </ul>
        </footer>
    </div>
    <div class="cd-overlay-nav">
        <span></span>
    </div>
    <div class="cd-overlay-content">
        <span></span>
    </div>
    <script src="<?php echo base_url();?>public/assets/back/js/colorPick.js"></script>
    <script>
        $(".picker").colorPick({
            'initialColor' : "#0044E9",
            'palette': ["#089bab", "#fead55", "#f36b7f", "#6b86f3", "#3734a9", "#0044e9", "#0d4290", "#fd4f57", "#a01a7a", "#23315e"],
            'onColorSelected': function() {
                $("#theme").val(this.color);
                this.element.css({'backgroundColor': this.color, 'color': this.color});
            }
        });
    </script>
	<script src="<?php echo base_url();?>public/assets/survey/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/survey/js/common_scripts.min.js?ver=1"></script>
	<script src="<?php echo base_url();?>public/assets/survey/js/velocity.min.js"></script>
	<script src="<?php echo base_url();?>public/assets/survey/js/common_functions.js"></script>
	<script src="<?php echo base_url();?>public/assets/survey/js/func_1.js"></script>
</body>
</html>