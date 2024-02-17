    <div class="col-sm-12">
    <?php if ($this->crud_model->check_item('height') == 1): ?>
        <div class="form-group" id="heightM" style="margin-bottom:5px;display:<?php $sistema_m = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->sistema_m; echo $sistema_m == '1' ? 'none': '' ?>">
            <i class="picons-thin-icon-thin-0263_text_font_typography" style="font-size:25px;"></i> <span style="vertical-align: 4px;">Estatura:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style="font-size:10px;padding-left:5px;display: block;text-align: right;">m</span>
                <input name="height" id="height" type="number" style="margin-bottom:5px;width:55px; height:30px;outline-style: none;border:1px solid #d9e3eb;" <?php if ($details['status'] == 4): ?> value="<?php echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->height;?>" <?php endif;?>/>
            </div>            
        </div>
         <hr style="margin-top: 25px;width:100%">
    <?php endif;?>
    <?php if ($this->crud_model->check_item('weight') == 1): ?>
        <div class="form-group" id="weightM" style="display:<?php echo $sistema_m == '1' ? 'none': '' ?>">
            <i class="picons-thin-icon-thin-0827_body_weight_fitness_health_fat" style="font-size:25px"></i> <span style="vertical-align: 4px;">Peso:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style="font-size:10px; text-align:right;padding-left:5px;display: block;" ;> kg</span>
                <input name="weight1" onkeyup="multi()" id="weight" type="number" style="width:55px; height:30px;outline-style: none;border:1px solid #d9e3eb;" <?php if ($details['status'] == 4):?> value="<?php echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->weight;?>" <?php endif;?> />
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->crud_model->check_item('height') == 1): ?>
        <div class="form-group" id="heightI" style="display:<?php echo $sistema_m == '0' ? 'none': '' ?>">
            <i class="picons-thin-icon-thin-0263_text_font_typography" style="font-size:25px;"></i> <span style="vertical-align: 4px;">Estatura:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style="font-size:10px; text-align:right;padding-left:5px;display:block" ;>pies</span>
                <input name="feet"  type="number" style="width:55px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;" <?php if ($details['status'] == 4): ?> value="<?php echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->feet;?>" <?php endif;?> />
            </div>    
            <br><br>
        </div>
    <?php endif; ?>
    <?php if ($this->crud_model->check_item('height') == 1): ?>
        <div class="form-group" id="heightinchI" style="display:<?php echo $sistema_m == '0' ? 'none': '' ?>">
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block;padding-left:5px;" ;>pulgadas</span>
                <input name="inches"   type="number" style="width:55px; height:30px;outline-style: none;border:1px solid #d9e3eb;" <?php if ($details['status'] == 4): ?> value="<?php echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->inches;?>" <?php endif;?> />
            </div>
            <br><br>
        </div>
    <?php endif; ?>
    <?php if ($this->crud_model->check_item('weight') == 1): ?>
        <div class="form-group" id="weightI" style="display:<?php echo $sistema_m == '0' ? 'none': '' ?>">
            <i class="picons-thin-icon-thin-0827_body_weight_fitness_health_fat" style="font-size:25px"></i> <span style="vertical-align: 4px;">Peso:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block;padding-left:5px;" ;>lbs</span>
                <input name="pounds" onkeyup="imcIngles()"  type="number" style="width:55px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;" <?php if ($details['status'] == 4):?> value="<?php echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->pounds;?>" <?php endif;?> />
            </div>
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php endif; ?>
    <?php if ($this->crud_model->check_item('mass') == 1 && $this->crud_model->check_item('height') == 1 && $this->crud_model->check_item('weight') == 1): ?>
        <div class="form-group">
            <i class="picons-thin-icon-thin-0720_user_location_position" style="font-size:25px"></i> <span style="vertical-align: 4px;">Masa corporal:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block;padding-left:5px;" ;>IMC</span>
                <input disabled id="results" type="number" style="width:55px; height:30px;float:right;outline-style: none;" <?php if ($details['status'] == 4): ?> value="<?php echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->mass; ?>" <?php endif; ?> />
            </div>
            <input type="hidden" name="mass" id="mass" />
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php endif;?>
    <?php  if ($this->crud_model->check_item('temperature') == 1): ?>
        <div class="form-group">
            <i class="picons-thin-icon-thin-0824_fever_body_temperature_ill" style="font-size:25px"></i> <span style="vertical-align: 4px;">Temperatura:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block; padding-left:5px;" ;>°C</span>
                <input name="temperature" type="number" style="width:50px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;"  <?php   if ($details['status'] == 4):  ?> value="<?php  echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->temperature; ?>" <?php endif; ?> />
            </div>
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php endif;?>
    <?php if ($this->crud_model->check_item('frequency') == 1): ?>
        <div class="form-group">
            <i class="picons-thin-icon-thin-0810_heart_pulse_rate_health" style="font-size:25px"></i> <span style="vertical-align: 4px;">Frecuencia respiratoria:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block;padding-left:5px;" ;>R/M</span>
                <input name="frequency" type="number" style="width:50px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;"  <?php   if ($details['status'] == 4): ?> value="<?php  echo $this->db->get_where('vital_sign',array('appointment_id' => $appointment_id))->row()->frequency; ?>"  <?php  endif; ?> />
            </div>    
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php endif;?>
    <?php if ($this->crud_model->check_item('systolic') == 1): ?>
        <div class="form-group">
            <i class="picons-thin-icon-thin-0810_heart_pulse_rate_health" style="font-size:25px"></i> <span style="vertical-align: 4px;">Sistólica:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block;padding-left:5px;" ;>mm Hg</span>
                <input name="systolic" type="number" style="width:50px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;" 
                <?php   if ($details['status'] == 4): ?> value="<?php echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->systolic; ?>" <?php    endif; ?> />
            </div>
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php endif;?>
    <?php if ($this->crud_model->check_item('diastolic') == 1): ?>
        <div class="form-group">
            <i class="picons-thin-icon-thin-0810_heart_pulse_rate_health" style="font-size:25px"></i> <span style="vertical-align: 4px;">Diastólica:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block; padding-left:5px;" ;>mm Hg</span>
                <input name="diastolic" type="number" style="width:50px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;"  <?php  if ($details['status'] == 4): ?> value="<?php    echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->diastolic; ?>"  <?php  endif; ?> />
            </div>
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php endif;?>
    <?php if ($this->crud_model->check_item('heart') == 1): ?>
        <div class="form-group">
            <i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health" style="font-size:25px"></i> <span style="vertical-align: 4px;">Frecuencia cardiaca:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block; padding-left:5px;" ;>L/M</span>
                <input name="heart" type="number" style="width:50px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;"  <?php   if ($details['status'] == 4): ?> value="<?php     echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->heart;?>"  <?php   endif; ?> />
            </div>
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php endif;?>
    <?php if ($this->crud_model->check_item('percentage') == 1): ?>
        <div class="form-group">
            <i class="picons-thin-icon-thin-0720_user_location_position" style="font-size:25px"></i> <span style="vertical-align: 4px;">Porcentaje de Grasa Corporal:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block;" ;>BFP</span>
                <input name="percentage" type="number" style="width:50px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;"  <?php  if ($details['status'] == 4):?> value="<?php  echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->percentage;?>"  <?php  endif;  ?> />
            </div>
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php endif;?>
    <?php if ($this->crud_model->check_item('muscle') == 1):?>
        <div class="form-group">
            <i class="picons-thin-icon-thin-0847_fitness_running_calories_training" style="font-size:25px"></i> <span style="vertical-align: 4px;">Masa Muscular:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block; padding-left:5px;" ;>%</span>
                <input name="muscle1" type="number" style="width:50px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;"  <?php  if ($details['status'] == 4):?> value="<?php  echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->muscle;?>" <?php  endif; ?> />
            </div>
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php endif;?>
    <?php if ($this->crud_model->check_item('head') == 1):?>
        <div id="razon"></div>
        <div id="exploracion"></div>
        <div class="form-group">
            <i class="picons-thin-icon-thin-0712_user_profile_avatar_girl_woman_female" style="font-size:25px"></i> <span style="vertical-align: 4px;">Perímetro Cefálico:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block; padding-left:5px;" ;>cm</span>
                <input name="head" type="number" style="width:50px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;"  <?php  if ($details['status'] == 4):?> value="<?php  echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->head;?>"  <?php   endif; ?> />
            </div>
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php endif;?>
    <?php if ($this->crud_model->check_item('saturation') == 1):?>
        <div class="form-group">
            <i class="picons-thin-icon-thin-0815_lungs_breathing" style="font-size:25px"></i> <span style="vertical-align: 4px;">Saturación de Oxígeno:</span>
            <div style='float:right;margin-bottom:5px'>
                <span style=" text-align: right; font-size:10px; display:block; padding-left:5px;" ;>sO2</span>
                <input name="saturation" type="number" style="width:50px; height:30px;float:right;outline-style: none;border:1px solid #d9e3eb;"  <?php  if ($details['status'] == 4):?> value="<?php   echo $this->db->get_where('vital_sign', array('appointment_id' => $appointment_id))->row()->saturation;?>"  <?php   endif;?> />
            </div>
        </div>
        <hr style="margin-top: 25px;width:100%">
    <?php  endif;  ?>
    </div>