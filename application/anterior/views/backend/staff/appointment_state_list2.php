<ul class="tasks-list">
    <li>
        <div class="custom-control custom-radio">
            <input <?php if ($page_name=="appointments_box"){ echo 'checked'; } ?> name="type" type="radio" class="custom-control-input" id="today" onclick="window.location.href='<?php echo base_url();?>staff/appointments/';">
            <span class="badge badge-today pull-right">
                <?php 
                    if($filter){
                        echo $this->crud_model->count_appointment_today($doctor_id, $apply,$clinic_id);
                    }else{
                        echo $this->crud_model->count_appointment_today($doctor_id, date('d/m/Y'),$clinic_id);
                    }
                ?>
            </span>
            <label class="custom-control-label" for="today">Citas pendientes de cobrar </label>
        </div>
    </li>
    <li>
        <div class="custom-control custom-radio">
            <input <?php if ($page_name=="pending_payment"){ echo 'checked'; } ?> name="type" type="radio" class="custom-control-input" id="customCheck2" onclick="window.location.href='<?php echo base_url();?>staff/pending_payment/';">
            <span class="badge badge-pending pull-right"><?php 
            if($filter){
                echo $this->crud_model->count_appointment_payment_pending($doctor_id,$apply);
               
            }else{
                echo $this->crud_model->count_appointment_payment_pending($doctor_id,date('d/m/Y'));
            }
            ?></span>
            <label class="custom-control-label" for="customCheck2">Pendientes de pago</label>
        </div>
    </li>
</ul>