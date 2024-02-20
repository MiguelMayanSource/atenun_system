<link rel="stylesheet" href="<?php echo base_url();?>public/assets/telinput/intlTelInput.css">

<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>staff/settings/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/insurance/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0823_hospital_ill_medicine_doctor_ambulance"></i></div> <span>Aseguradoras</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/clinics/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0047_home_flat"></i></div> <span>Sucursales</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/specialties/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/surveys/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                    </a>
                </li>
                 <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/forms/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                    </a>
                </li>
                 <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/roles/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Roles de usuario</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="card-h">
                    <h5 class="card-caption">Configura tu aplicación</h5>
                </div>
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php
                                    $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
                                    $clinics = $this->db->get('clinic')->result_array();
                                    foreach($clinics as $clinic):
                                ?>
                            <form action="<?php echo base_url();?>staff/settings/apply" method="POST" enctype="multipart/form-data">
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span>Sube tu logotipo:</span>
                                        <div class="avatar-upload ">

                                            <div class="avatar-edit">
                                                <input type='file' name="logo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <?php if($this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo != ''):?>
                                                <div id="imagePreview" style="background-image: url(<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>);">
                                                </div>
                                                <?php else:?>
                                                <div id="imagePreview" style="background-image: url(<?php echo base_url();?>public/uploads/user.png);">
                                                </div>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Elige un color para tu clínica</label>
                                        <div class="picker"></div>
                                        <input type="hidden" id="theme" name="theme">

                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group m-b-15">
                                                        <label for="simpleinput">Nombre</label>
                                                        <input type="text" name="name" required="" value="<?php echo $clinic['name'];?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group m-b-15">
                                                        <label for="simpleinput">Teléfono</label>
                                                        <input type="number" name="phone" required="" class="form-control" value="<?php echo $clinic['phone'];?>">
                                                        <small>* Ingresar código de área p.j: 502xxxxxxxx</small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group m-b-15">
                                                        <label for="simpleinput">Horario matutino <small>(Inicial)</small></label>
                                                        <div class="input-group clockpicker" data-align="bottom" data-autoclose="true">
                                                            <div class="input-group date timepicker" id="horainicio5" data-target-input="nearest">
                                                                <input type="text" name="morning" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio5" value="<?php echo $clinic['morning'];?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group m-b-15">
                                                        <label for="simpleinput">Horario matutino <small>(Final)</small></label>
                                                        <div class="input-group clockpicker" data-align="bottom" data-autoclose="true">
                                                            <div class="input-group date timepicker" id="horainicio6" data-target-input="nearest">
                                                                <input type="text" name="b_morning" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio6" value="<?php echo $clinic['b_morning'];?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group m-b-15">
                                                        <label for="simpleinput">Horario vespertino <small>(Inicial)</small></label>
                                                        <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                                            <div class="input-group date timepicker" id="horainicio7" data-target-input="nearest">
                                                                <input type="text" name="afternoon" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio7" value="<?php echo $clinic['afternoon'];?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group m-b-15">
                                                        <label for="simpleinput">Horario vespertino <small>(Final)</small></label>
                                                        <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                                            <div class="input-group date timepicker" id="horainicio8" data-target-input="nearest">
                                                                <input type="text" name="b_afternoon" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio8" value="<?php echo $clinic['b_afternoon'];?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group m-b-15">
                                                        <label for="simpleinput">Correo electrónico</label>
                                                        <input type="email" name="email" required="" class="form-control" value="<?php echo $clinic['email'];?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group m-b-15">
                                                        <label for="simpleinput">Intervalo entre citas</label>
                                                        <input type="number" name="interval" required="" class="form-control" value="<?php echo $clinic['time_interval'];?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group m-b-15">
                                                        <label for="simpleinput">Dirección</label>
                                                        <textarea type="text" name="address" required="" class="form-control"><?php echo $clinic['address'];?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success"><i class="picons-thin-icon-thin-0154_ok_successful_check"></i> Aplicar cambios</button>
                                    </div>
                                </div>
                            </form>
                            <?php endforeach;?>
                        </div>
                        <div class="col-lg-6">

                            <hr>
                            <div class="middless">
                                <label>
                                    <input type="radio" name="radio" onclick="dataModule()" />
                                    <div class="download box">
                                        <span>Descarga <p style="margin-top:-4px;font-size: 15px;font-weight:500;color:#707d94;">
                                                tu información.</p></span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="radio" onclick="close_sessions()" />
                                    <div class="session box">
                                        <span>Cierra todas <p style="margin-top:-4px;font-size: 15px;font-weight:500;color:#707d94;">
                                                tus sesiones.</p></span>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <div class="col-lg-12" id="modules" style="display:none;"><br>
                                    <p style="text-align:justify;font-size:13px;">
                                        Puedes descargar una copia de tu información de <b>Medicaby</b> cuando
                                        quieras. Tienes la opición de descargarla en su totalidad o seleccionar solo
                                        los tipos de datos que te interesen.
                                        Toda tu información será entregada en formato <b>.xlsx</b> y <b>.zip</b>
                                    </p>
                                    <p style="text-align:justify;font-size:13px;">
                                        Tu información se generará en los próximos 7 días hábiles.
                                    </p>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="mod_appointments" value="0" class="custom-control-input" id="mod_appointments">
                                        <label class="custom-control-label" for="mod_appointments">Descargar
                                            informacion de tus citas.</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="mod_patients" value="0" class="custom-control-input" id="mod_patients">
                                        <label class="custom-control-label" for="mod_patients">Descargar informacion
                                            de los pacientes.</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="mod_doctors" value="0" class="custom-control-input" id="mod_doctors">
                                        <label class="custom-control-label" for="mod_doctors">Descargar informacion
                                            de los doctores.</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="mod_staff" value="0" class="custom-control-input" id="mod_staff">
                                        <label class="custom-control-label" for="mod_staff">Descargar informacion
                                            del Staff.</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="mod_ingresos" value="0" class="custom-control-input" id="mod_ingresos">
                                        <label class="custom-control-label" for="mod_ingresos">Descargar informacion
                                            de los ingresos.</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="mod_egresos" value="0" class="custom-control-input" id="mod_egresos">
                                        <label class="custom-control-label" for="mod_egresos">Descargar informacion
                                            de los egresos.</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <hr>
                                        <a onclick="downloadData()" class="btn btn-primary"><i class="picons-thin-icon-thin-0315_email_mail_post_send"></i> Enviar
                                            solicitud</a>
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
<script src="<?php echo base_url();?>public/assets/back/js/colorPick.js"></script>
<script src="<?php echo base_url();?>public/assets/back/js/moment.min.js"></script>
<script src="<?php echo base_url();?>public/assets/back/js/tempusdominus-bootstrap-4.js"></script>
<script src="<?php echo base_url();?>public/assets/back/js/timepicker.js"></script>
<script src="<?php echo base_url();?>public/assets/back/js/settings.js"></script>
<script src="https://cdn.rawgit.com/leodido/i18n.phonenumbers.js/master/dist/i18n.phonenumbers.min.js"></script>
<script src="<?php echo base_url();?>public/assets/telinput/prism.js"></script>
<script src="<?php echo base_url();?>public/assets/telinput/intlTelInput.js"></script>
<script src="<?php echo base_url();?>public/assets/telinput/hiddenInput.js"></script>
<script src="<?php echo base_url();?>public/assets/telinput/utils.js"></script>
<script type="text/javascript">
/*              // update the hidden input on submi
    $( "#target" ).submit(function( event ) {
    
    var number = iti.getExtension();
        alert(number);
        event.preventDefault();
    
        return true;
        });
*/
const mensaje = document.getElementById('mensaje');
const contador = document.getElementById('contador');
mensaje.addEventListener('input', function(e) {
    const target = e.target;
    const longitudMax = target.getAttribute('maxlength');
    const longitudAct = target.value.length;
    contador.innerHTML = `${longitudAct}/${longitudMax}`;
});


$(function() {

    const longitudAct = mensaje.value.length;
    contador.innerHTML = `${longitudAct}/150`;
    <?php if($this->crud_model->check_item('send_survey') == 0):?>
    $("#send_survey").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_item('send_schedule') == 0):?>
    $("#send_schedule").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_item('send_reminder') == 0):?>
    $("#send_reminder").hide();
    <?php endif;?>
});
</script>