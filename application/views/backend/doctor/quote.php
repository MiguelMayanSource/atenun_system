<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script>
var base_url = '<?php echo base_url();?>';
</script>
<?php
    $clinic_id = $this->session->userdata('current_clinic');
    $inicial   = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->morning;
    $final     = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_morning;
    $inicial2  = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->afternoon;
    $final2    = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_afternoon;
    $intervalo = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->time_interval;
?>
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/appointments/css/style.css?ver=1.4" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/appointments/css/responsive.css?ver=1.0.1" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/appointments/css/icon_fonts/css/all_icons_min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/vanillaCalendar.css">

<div id="main-content">
    <div id="form_container" style="background:#fff;">
        <div class="row">
            <div class="col-lg-4">
                <div id="left_form">
                    <figure style="margin: 4rem 0 1rem;"><img style="max-width:60%;" src="https://medicaby.com/resources/app-icons/schedule.png" alt=""></figure>
                    <h2>Agendar cita</h2>
                    <p>Para completar la cita asegurate de llenar todos los campos en el formulario.</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div id="wizard_container_staff">
                    <div id="top-wizard">
                        <div id="progressbar"></div>
                    </div>
                    <form action="<?php echo base_url();?>doctor/quote/create" method="POST" id="wrapped" name="wizard_container">
                        <div id="middle-wizard">
                            <?php if($this->session->userdata('login_type') != 'doctor'):?>
                            <div class="step">
                                <h3 class="main_question"><strong></strong>Seleccionar doctor</h3>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <select class="itemName form-control select2" required="" name="doctor_id" id="doctor_id" onchange="showServices(this)">
                                            <option value="">Seleccionar</option>
                                            <?php 
									        $this->db->where('status','1');
                                            $this->db->where('owner','0');
										    $this->db->order_by('first_name', 'ASC');
									        $query = $this->db->get('admin')->result_array();
                                            foreach($query as $pat):?>
                                            <option value="<?php echo $pat['admin_id'];?>" <?php if($pat['admin_id'] == $doctor_id) echo "selected";?>><?php echo $this->accounts_model->get_name('admin', $pat['admin_id']);?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php else:?>
                                <input type="hidden" name="doctor_id" value="<?php echo $this->session->userdata('doctor_id');?>">
                            <?php endif;?>
                            <div class="step">
                                <h3 class="main_question"><strong>1/4</strong>Seleccionar servicio</h3>
                                <div class="row">
                                    <div class="col-md-12 ">
                                    <select class="itemName form-control select2" required=""  name="practice_id" onchange="selectServices(0)" >
										  <option value="">Seleccionar</option>
										    <?php 
										        $this->db->where('status','1');
                                                $this->db->where('type','2');
										        $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
    										    $this->db->order_by('product_id', 'ASC');
										        $query = $this->db->get('product')->result_array();
                                                foreach($query as $pat):?>
										        <option value="<?php echo $pat['product_id'];?>" ><?php echo $pat['code'].' '.$pat['name'];?></option>
										    <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="step">
                                <h3 class="main_question"><strong>2/4</strong>Selecciona una fecha</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="v-cal">
                                            <div class="vcal-header">
                                                <button type="button" class="vcal-btn" data-calendar-toggle="previous">
                                                    <svg height="24" version="1.1" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
                                                    </svg>
                                                </button>
                                                <div class="vcal-header__label" data-calendar-label="month">
                                                    <?php echo date('F');?> <?php echo date('Y');?>
                                                </div>
                                                <button type="button" class="vcal-btn" data-calendar-toggle="next">
                                                    <svg height="24" version="1.1" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="vcal-week">
                                                <span>Lun</span>
                                                <span>Mar</span>
                                                <span>Mie</span>
                                                <span>Jue</span>
                                                <span>Vie</span>
                                                <span>Sab</span>
                                                <span>Dom</span>
                                            </div>
                                            <div class="vcal-body" data-calendar-area="month" onclick="horario()"></div>
                                            <input data-calendar-label="picked" class="appointment_date" name="date_picked" type="text" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step scroll" style="overflow-y: scroll; height:400px;">
                                <h3 class="main_question"><strong>3/4</strong> Elegir hora</h3>
                                <div class="card-h">
                                    <i style="border-radius:8px; background-color: rgba(244, 164, 37, 0.3); color:#f4a425; padding:8px;  font-size: 20px; vertical-align: 5px; margin-right: 7px; display: inline-block;" class="batch-icon-brightness-high"></i>
                                    <h5 class="card-capti on" style="font-size:20px;display:inline-block;">Mañana<br style="content: ''; margin: -1.8em; display: block; font-size: 24%;">
                                        <span style="font-weight:normal; font-size:12px;color:#565b6b;"><?php echo date("g:i A", strtotime($inicial));?> - <?php echo date("g:i A", strtotime($final));?></span>
                                    </h5>
                                </div>
                                <div class="middle">
                                    <script>
                                    var horas = [];
                                    </script>
                                    <?php 
                                    $horas = $this->crud_model->interval($inicial, $final, $intervalo);
                                  echo '<script>';
                                   echo 'horas ='.json_encode($horas);
                                echo '</script>';
                                    
                                    for($i = 0; $i < count($horas); $i++):
                                ?>
                                    <label>
                                        <input type="radio" name="radio" class="check" onclick="showValue(this)" value="<?php echo $horas[$i];?>" id="<?php echo $horas[$i];?>" required="" />
                                        <div onclick="showServices(this)" class="front-end box" id="<?php echo $horas[$i];?>">
                                            <span><?php echo date("g:i A", strtotime($horas[$i]));?></span>
                                        </div>
                                    </label>


                                    <?php 
                                    
                                
                                endfor;
                                
                                ?>
                                </div><br>
                                <div class="card-h">
                                    <i style="border-radius:8px; background-color:rgb(37 139 244 / 30%); color:#8fa0e4; padding:8px;  font-size: 20px; vertical-align: 5px; margin-right: 7px; display: inline-block;" class="fa fa-moon-o"></i>
                                    <h5 class="card-capt ion" style="font-size:20px; display:inline-block;">Tarde<br style="content: ''; margin: -1.8em; display: block; font-size: 24%;">
                                        <span style="font-weight:normal; font-size:12px;color:#565b6b;"><?php echo date("g:i A", strtotime($inicial2));?> - <?php echo date("g:i A", strtotime($final2));?></span>
                                    </h5>
                                </div>
                                <div class="middle">
                                    <?php 
                                    $horas2 = $this->crud_model->interval($inicial2, $final2, $intervalo);
                                    
                                  echo '<script>';
                                   echo 'horas2 ='.json_encode($horas2);
                                echo '</script>';
                                    for($i = 0; $i < count($horas2); $i++):
                                    ?>
                                    <label>
                                        <input type="radio" name="radio" class="check" id="<?php echo $horas2[$i];?>" onclick="showValue(this)" value="<?php echo $horas2[$i];?>" required="" />
                                        <div onclick="showServices(this)" class="front-end box" id="<?php echo $horas2[$i];?>">
                                            <span><?php echo date("g:i A", strtotime($horas2[$i]));?></span>
                                        </div>
                                    </label>
                                    <?php endfor;?>
                                    <input id="check" value='0' type="text" style="display: none;">
                                </div>
                            </div>
                            <div class=" submit step">
                                <h3 class="main_question"><strong>4/4</strong>Seleccionar un paciente</h3>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <hr>
                                        <div class="middles">
                                            <label>
                                                <input type="radio" id="exist" value="0" onclick="validate(0)" name="patient_type" checked required />
                                                <div class="front-end box">
                                                    <span>Existente</span>
                                                </div>
                                            </label>
                                            <label>
                                                <input type="radio" id="new" value="1" onclick="validate(1)" name="patient_type" />
                                                <div class="back-end box">
                                                    <span>Nuevo</span>
                                                </div>
                                            </label>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-md-12" id="is_exist">
                                        <div class="form-group">
                                            <label for="simpleinput">Pacientes</label><span class="error_show" id="errorpat"></span>
                                            <select onchange="patient_treatment(this.value)" class="itemName form-control select2" style="width:100%" name="patient_id">
                                                <option value="">Seleccionar</option>
                                                <?php 
									                $this->db->order_by('first_name', 'ASC');
									                $this->db->where('status !=', '0');
                                                    $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
									                $query = $this->db->get('patient')->result_array();
                                                    foreach($query as $pat):
                                                       
                                                        ?>
                                                <option value="<?php echo $pat['patient_id'];?>"><?php echo $this->accounts_model->get_full_name('patient', $pat['patient_id']); ?></option>

                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="display:none;" id="first_name">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Primer Nombre</label><span class="error_show" id="errorn"></span>
                                            <input type="text" class="form-control" name="first_name">
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="display:none;" id="second_name">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Segundo Nombre</label><span class="error_show" id="errorn"></span>
                                            <input type="text" class="form-control" name="second_name">
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="display:none;" id="last_name">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Primer Apellido</label><span class="error_show" id="errorl"></span>
                                            <input type="text" class="form-control" name="last_name">
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="display:none;" id="second_last_name">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Segundo Apellido</label><span class="error_show" id="errorl"></span>
                                            <input type="text" class="form-control" name="second_last_name">
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="display:none;" id="dpi">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">DPI</label><span class="error_show" id="errordpi"></span>
                                            <input type="number" class="form-control" name="dpi" id="">
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="display:none;" id="phone">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Celular</label><span class="error_show" id="errorp"></span>
                                            <input type="number" class="form-control" name="phone">
                                            <small>* Ingresar código de área p.j: 502xxxxxxxx</small>
                                        </div>
                                    </div>

                                    <div class="col-sm-3" style="display:none;" id="email">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Correo electronico:</label><span class="error_show" id="errorm"></span>
                                            <input type="text" class="form-control" name="email">
                                        </div>
                                    </div>

                                    <div class="col-sm-3" id="date_of_birth" style="display:none">
                                        <div class="form-group date-time-picker m-b-15">
                                            <label for="simpleinvput">Nacimiento</label><span class="error_show" id="errorb"></span>
                                            <div class="input-group date datepicker" id="DoctorPicker1">
                                                <input style="border: 1px solid #198cff8f;" type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo date('d/m/Y');?>" class="form-control">
                                                <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="display:none;" id="gender">
                                        <div class="form-group">
                                            <label>Género:</label>
                                            <div class="input-group">
                                                <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                    <input checked class="radiobutton" type="radio" name="gender" id="radio3" value="M">
                                                    <label class="radiobutton-label" for="radio3">Masculino</label>
                                                </div>
                                                <div class="form-check" style="padding-left: 0px;">
                                                    <input class="radiobutton" type="radio" name="gender" id="radio4" value="F">
                                                    <label class="radiobutton-label" for="radio4">Femenino</label>
                                                </div>
                                                <div class="form-check" style="padding-left: 0px;">
                                                    <input class="radiobutton" type="radio" name="gender" id="radio5" value="O">
                                                    <label class="radiobutton-label" for="radio5">Otros</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="display:none;" id="status">
                                        <div class="form-group">
                                            <label>Estado civil:</label>
                                            <div class="input-group">
                                                <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                                    <input checked class="radiobutton" type="radio" name="marital_status" id="single" value="0">
                                                    <label class="radiobutton-label" for="single">Casado</label>
                                                </div>
                                                <div class="form-check" style="padding-left: 0px;">
                                                    <input class="radiobutton" type="radio" name="marital_status" id="married" value="1">
                                                    <label class="radiobutton-label" for="married">Soltero</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bottom-wizard">
                            <button type="button" name="backward" class="backward">Anterior </button>
                            <button type="button" name="forward" class="forward">Síguiente</button>
                            <button type="submit" name="process" class="submit">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
<script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/vanillaCalendar.js"></script>
<script src="<?php echo base_url();?>public/assets/appointments/js/appointment_form.js"></script>