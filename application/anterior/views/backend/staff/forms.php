    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link " href="<?php echo base_url();?>staff/settings/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>staff/forms/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/clinics/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0047_home_flat"></i></div> <span>Sucursales</span>
                        </a>
                    </li>

                    <?php  
                    
                    $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                    if($odonto != ''):
                
                        ?>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/thooth_procedures/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0826_teeth_tooth_dental"></i></div> <span>Procedimientos</span>
                        </a>
                    </li>
                    <?php endif;?>
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
                </ul>
            </div>
        </div>
    </div>
    <div id="main-content">



        <form action="<?php echo base_url();?>staff/forms/apply" method="POST">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-widget">

                        <h5 class="panel-content-title">Antecedentes</h5>
                        <span class="app-divider2"></span>

                        <div class="card-b">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" value="1" name="pathological" <?php if($this->crud_model->check_item('pathological') == 1) echo "checked";?> id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">Patológicos</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" value="1" name="non_pathological" <?php if($this->crud_model->check_item('non_pathological') == 1) echo "checked";?> id="non_pathological">
                                        <label class="custom-control-label" for="non_pathological">No Patológicos</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" value="1" name="hereditary" <?php if($this->crud_model->check_item('hereditary') == 1) echo "checked";?> id="hereditary">
                                        <label class="custom-control-label" for="hereditary">Heredofamiliares</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" value="1" name="psychiatric" <?php if($this->crud_model->check_item('psychiatric') == 1) echo "checked";?> id="psychiatric">
                                        <label class="custom-control-label" for="psychiatric">Psiquiátricos</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" value="1" name="vaccination" <?php if($this->crud_model->check_item('vaccination') == 1) echo "checked";?> id="vaccination">
                                        <label class="custom-control-label" for="vaccination">Esquema de Vacunación</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" value="1" name="diet" <?php if($this->crud_model->check_item('diet') == 1) echo "checked";?> id="diet">
                                        <label class="custom-control-label" for="diet">Dieta Nutriológica</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" value="1" name="obstetrics" <?php if($this->crud_model->check_item('obstetrics') == 1) echo "checked";?> id="obstetrics">
                                        <label class="custom-control-label" for="obstetrics">Gineco-Obstetricios</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" value="1" name="perinatal" <?php if($this->crud_model->check_item('perinatal') == 1) echo "checked";?> id="perinatal">
                                        <label class="custom-control-label" for="perinatal">Perinatales</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" value="1" name="postnatal" <?php if($this->crud_model->check_item('postnatal') == 1) echo "checked";?> id="postnatal">
                                        <label class="custom-control-label" for="postnatal">Postnatales</label>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card-widget">

                        <h5 class="panel-content-title">Signos Vitales</h5>
                        <span class="app-divider2"></span>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input signs" value="1" name="signs" <?php if($this->crud_model->check_item('signs') == 1) echo "checked";?> id="signs_check">
                            <label class="custom-control-label" for="signs_check"></label>
                        </div>

                        <div class="card-b" <?php if($this->crud_model->check_item('signs') != 1):?>style="display:none;" <?php endif;?> id="signs">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="radio" class="custom-control-input" name="sistema" value="1" id="sistema" <?php  $sistema_m = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->sistema_m; echo $sistema_m == 1 ? 'checked': '' ;?>>
                                        <label class="custom-control-label" for="sistema">Sistema Ingles</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="radio" class="custom-control-input" name="sistema" value="0" id="sistema2" <?php echo $sistema_m == 0 ? 'checked': '' ;?>>
                                        <label class="custom-control-label" for="sistema2">Sistema Métrico</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="height" value="1" <?php if($this->crud_model->check_item('height') == 1) echo "checked";?> id="height">
                                        <label class="custom-control-label" for="height">Estatura</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="weight" value="1" <?php if($this->crud_model->check_item('weight') == 1) echo "checked";?> id="weight">
                                        <label class="custom-control-label" for="weight">Peso</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="temperature" value="1" <?php if($this->crud_model->check_item('temperature') == 1) echo "checked";?> id="temperature">
                                        <label class="custom-control-label" for="temperature">Temperatura</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="frequency" value="1" <?php if($this->crud_model->check_item('frequency') == 1) echo "checked";?> id="frequency">
                                        <label class="custom-control-label" for="frequency">Frecuencia Respiratoria</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="systolic" value="1" <?php if($this->crud_model->check_item('systolic') == 1) echo "checked";?> id="systolic">
                                        <label class="custom-control-label" for="systolic">Sistólica</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="diastolic" value="1" <?php if($this->crud_model->check_item('diastolic') == 1) echo "checked";?> id="diastolic">
                                        <label class="custom-control-label" for="diastolic">Diastólica</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="heart" value="1" <?php if($this->crud_model->check_item('heart') == 1) echo "checked";?> id="heart">
                                        <label class="custom-control-label" for="heart">Frecuencia Cardiaca</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mass" value="1" <?php if($this->crud_model->check_item('mass') == 1) echo "checked";?> id="mass">
                                        <label class="custom-control-label" for="mass">Masa Corporal</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="percentage" <?php if($this->crud_model->check_item('percentage') == 1) echo "checked";?> value="1" id="percentage">
                                        <label class="custom-control-label" for="percentage">Porcentaje de Grasa Corporal</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="muscle" <?php if($this->crud_model->check_item('muscle') == 1) echo "checked";?> value="1" id="muscle">
                                        <label class="custom-control-label" for="muscle">Masa Muscular</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="head" <?php if($this->crud_model->check_item('head') == 1) echo "checked";?> value="1" id="head">
                                        <label class="custom-control-label" for="head">Perímetro Cefálico</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="saturation" <?php if($this->crud_model->check_item('saturation') == 1) echo "checked";?> value="1" id="saturation">
                                        <label class="custom-control-label" for="saturation">Saturación de Oxígeno</label>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card-widget">

                        <h5 class="panel-content-title">Resultados de Laboratorio</h5>
                        <span class="app-divider2"></span>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="labs" value="1" <?php if($this->crud_model->check_item('labs') == 1):?>checked<?php endif;?> id="results">
                            <label class="custom-control-label" for="results"></label>
                        </div>

                        <div class="card-b" <?php if($this->crud_model->check_item('labs') != 1):?>style="display:none;" <?php endif;?> id="labs">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label><b>Hemograma, contenio sangíneo completo</b></label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="erythrocytes" value="1" <?php if($this->crud_model->check_item('erythrocytes') == 1):?>checked<?php endif;?> id="erythrocytes">
                                        <label class="custom-control-label" for="erythrocytes">Eritrocitos</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="hematocrit" value="1" <?php if($this->crud_model->check_item('hematocrit') == 1):?>checked<?php endif;?> id="hematocrit">
                                        <label class="custom-control-label" for="hematocrit">Hematocrito</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="hemoglobin" value="1" <?php if($this->crud_model->check_item('hemoglobin') == 1):?>checked<?php endif;?> id="hemoglobin">
                                        <label class="custom-control-label" for="hemoglobin">Hemoglobina</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="blood_cells" value="1" <?php if($this->crud_model->check_item('blood_cells') == 1):?>checked<?php endif;?> id="blood_cells">
                                        <label class="custom-control-label" for="blood_cells">Leucocitos</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="platelets" value="1" <?php if($this->crud_model->check_item('platelets') == 1):?>checked<?php endif;?> id="platelets">
                                        <label class="custom-control-label" for="platelets">Plaquetas</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="reticulocytes" value="1" <?php if($this->crud_model->check_item('reticulocytes') == 1):?>checked<?php endif;?> id="reticulocytes">
                                        <label class="custom-control-label" for="reticulocytes">Reticulocitos</label>
                                    </div><br>
                                    <label><b>Panel metabólico básico</b></label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="nitrogen" value="1" <?php if($this->crud_model->check_item('nitrogen') == 1):?>checked<?php endif;?> id="nitrogen">
                                        <label class="custom-control-label" for="nitrogen">Nitrógeno ureico en la sangre</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="co2" value="1" <?php if($this->crud_model->check_item('co2') == 1):?>checked<?php endif;?> id="co2">
                                        <label class="custom-control-label" for="co2">CO2</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="chloride" value="1" <?php if($this->crud_model->check_item('chloride') == 1):?>checked<?php endif;?> id="chloride">
                                        <label class="custom-control-label" for="chloride">Cloruro Sérico</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="potassium" value="1" <?php if($this->crud_model->check_item('potassium') == 1):?>checked<?php endif;?> id="potassium">
                                        <label class="custom-control-label" for="potassium">Potasio Sérico</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="sodium" value="1" <?php if($this->crud_model->check_item('sodium') == 1):?>checked<?php endif;?> id="sodium">
                                        <label class="custom-control-label" for="sodium">Sodio Sérico</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="glucose" value="1" <?php if($this->crud_model->check_item('glucose') == 1):?>checked<?php endif;?> id="glucose">
                                        <label class="custom-control-label" for="glucose">Glucosa Sanguínea</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="creatinine" value="1" <?php if($this->crud_model->check_item('creatinine') == 1):?>checked<?php endif;?> id="creatinine">
                                        <label class="custom-control-label" for="creatinine">Creatinina</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="calcium" value="1" <?php if($this->crud_model->check_item('calcium') == 1):?>checked<?php endif;?> id="calcium">
                                        <label class="custom-control-label" for="calcium">Calcio</label>
                                    </div>
                                    <br>
                                    <label><b>Perfil lipídico / colesterol</b></label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="cholesterol" value="1" <?php if($this->crud_model->check_item('cholesterol') == 1):?>checked<?php endif;?> id="cholesterol">
                                        <label class="custom-control-label" for="cholesterol">Colesterol total</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="vldl" value="1" <?php if($this->crud_model->check_item('vldl') == 1):?>checked<?php endif;?> id="vldl">
                                        <label class="custom-control-label" for="vldl">Lipoproteína de muy baja densidad (colesterol VLDL)</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="ldl" value="1" <?php if($this->crud_model->check_item('ldl') == 1):?>checked<?php endif;?> id="ldl">
                                        <label class="custom-control-label" for="ldl">Lipoproteína de baja densidad (colesterol LDL)</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="hdl" value="1" <?php if($this->crud_model->check_item('hdl') == 1):?>checked<?php endif;?> id="hdl">
                                        <label class="custom-control-label" for="hdl">Lipoproteína de alta densidad (colesterol HDL)</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="triglycerides" <?php if($this->crud_model->check_item('triglycerides') == 1):?>checked<?php endif;?> value="1" id="triglycerides">
                                        <label class="custom-control-label" for="triglycerides">Triglicéridos</label>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card-widget">

                        <h5 class="panel-content-title">Seguimiento Nutriológico</h5>
                        <span class="app-divider2"></span>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="nutri" id="nutris" value="1" <?php if($this->crud_model->check_item('nutri') == 1):?>checked<?php endif;?>>
                            <label class="custom-control-label" for="nutris"></label>
                        </div>
                        <div class="card-b" <?php if($this->crud_model->check_item('nutri') != 1):?>style="display:none;" <?php endif;?> id="nutri">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="lost_weight" <?php if($this->crud_model->check_item('lost_weight') == 1):?>checked<?php endif;?> value="1" id="lost_weight">
                                        <label class="custom-control-label" for="lost_weight">Peso Perdido</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="water" <?php if($this->crud_model->check_item('water') == 1):?>checked<?php endif;?> value="1" id="water">
                                        <label class="custom-control-label" for="water">Agua</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="grease" <?php if($this->crud_model->check_item('grease') == 1):?>checked<?php endif;?> value="1" id="grease">
                                        <label class="custom-control-label" for="grease">Grasa</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="nutri_muscle" <?php if($this->crud_model->check_item('nutri_muscle') == 1):?>checked<?php endif;?> value="1" id="nutri_muscle">
                                        <label class="custom-control-label" for="nutri_muscle">Músculo</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="waist" <?php if($this->crud_model->check_item('waist') == 1):?>checked<?php endif;?> value="1" id="waist">
                                        <label class="custom-control-label" for="waist">Cintura</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="abdomen" <?php if($this->crud_model->check_item('abdomen') == 1):?>checked<?php endif;?> value="1" id="abdomen">
                                        <label class="custom-control-label" for="abdomen">Abdomen</label>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card-widget">

                        <h5 class="panel-content-title">Cetosis</h5>
                        <span class="app-divider2"></span>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="cetosis" value="1" id="cetosis_check" <?php if($this->crud_model->check_item('cetosis') == 1):?>checked<?php endif;?>>
                            <label class="custom-control-label" for="cetosis_check"></label>
                        </div>

                        <div class="card-b" <?php if($this->crud_model->check_item('cetosis') != 1):?>style="display:none;" <?php endif;?> id="cetosis">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="satiety" value="1" id="satiety" <?php if($this->crud_model->check_item('satiety') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="satiety">Saciedad</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="halitosis" value="1" id="halitosis" <?php if($this->crud_model->check_item('halitosis') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="halitosis">Halitosis</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="cramps" value="1" id="cramps" <?php if($this->crud_model->check_item('cramps') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="cramps">Calambres</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="hungry" value="1" id="hungry" <?php if($this->crud_model->check_item('hungry') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="hungry">Hambre</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="diarrhea" value="1" id="diarrhea" <?php if($this->crud_model->check_item('diarrhea') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="diarrhea">Diarrea</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="sleeping" value="1" id="sleeping" <?php if($this->crud_model->check_item('sleeping') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="sleeping">Problemas de sueño</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="depressed" value="1" id="depressed" <?php if($this->crud_model->check_item('depressed') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="depressed">Deprimido</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="impatient" value="1" id="impatient" <?php if($this->crud_model->check_item('impatient') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="impatient">Impaciente</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="tolerance" value="1" id="tolerance" <?php if($this->crud_model->check_item('tolerance') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="tolerance">Tolerancia</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="estimulantes" value="1" id="estimulantes" <?php if($this->crud_model->check_item('estimulantes') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="estimulantes">Necesidad de Estimulantes</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="constipation" value="1" id="constipation" <?php if($this->crud_model->check_item('constipation') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="constipation">Estreñimiento</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="migraine" value="1" id="migraine" <?php if($this->crud_model->check_item('migraine') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="migraine">Migraña o Cefalea</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="vertigo" value="1" id="vertigo" <?php if($this->crud_model->check_item('vertigo') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="vertigo">Vértigo</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="fatigue" value="1" id="fatigue" <?php if($this->crud_model->check_item('fatigue') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="fatigue">Cansancio</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="anxiety" value="1" id="anxiety" <?php if($this->crud_model->check_item('anxiety') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="anxiety">Ansiedad</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="concentration" value="1" id="concentration" <?php if($this->crud_model->check_item('concentration') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="concentration">Concentración</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="irritability" value="1" id="irritability" <?php if($this->crud_model->check_item('irritability') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="irritability">Irritabilidad</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="aggressiveness" value="1" id="aggressiveness" <?php if($this->crud_model->check_item('aggressiveness') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="aggressiveness">Agresividad</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="impulse" value="1" id="impulse" <?php if($this->crud_model->check_item('impulse') == 1):?>checked<?php endif;?>>
                                        <label class="custom-control-label" for="impulse">Control de Impulsos</label>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card-widget">
                        <h5 class="panel-content-title">Otros módulos</h5>
                        <span class="app-divider2"></span>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="teleconsulta" <?php if($this->crud_model->check_item('teleconsulta') == 1):?>checked<?php endif;?> value="1" id="teleconsulta">
                            <label class="custom-control-label" for="teleconsulta">Teleconsultas</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="odonto" <?php if($this->crud_model->check_item('odonto') == 1):?>checked<?php endif;?> value="1" id="odonto">
                            <label class="custom-control-label" for="odonto">Odontograma</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="trata" <?php if($this->crud_model->check_item('trata') == 1):?>checked<?php endif;?> value="1" id="trata">
                            <label class="custom-control-label" for="trata">Plan de tratamiento</label>
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-success" type="submit">Aplicar cambios</button>
                </div>
            </div>
        </form>

    </div>
    <script type="text/javascript">
$(function() {
    $('[name="signs"]').change(function() {
        if ($(this).is(':checked')) {
            $("#signs").show('500');
        } else {
            $("#signs").hide('500');
        };
    });
    $('[name="labs"]').change(function() {
        if ($(this).is(':checked')) {
            $("#labs").show('500');
        } else {
            $("#labs").hide('500');
        };
    });
    $('[name="nutri"]').change(function() {
        if ($(this).is(':checked')) {
            $("#nutri").show('500');
        } else {
            $("#nutri").hide('500');
        };
    });
    $('[name="cetosis"]').change(function() {
        if ($(this).is(':checked')) {
            $("#cetosis").show('500');
        } else {
            $("#cetosis").hide('500');
        };
    });
});
    </script>
    <script>
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-email-w').toggleClass('compact-side-menu');
});
    </script>