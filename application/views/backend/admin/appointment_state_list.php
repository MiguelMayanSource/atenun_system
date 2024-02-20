<ul class="tasks-list">
    <li>
        <div class="custom-control custom-radio">
            <input <?php if ($page_name=="appointments"){ echo 'checked'; } ?> name="type" type="radio" class="custom-control-input" id="today" onclick="window.location.href='<?php echo base_url();?>admin/appointments/';">
            <span class="badge badge-today pull-right">
                <?php 
                    if($filter){
                        echo $this->crud_model->count_appointment_today($doctor_id, $apply,$clinic_id);
                    }else{
                        echo $this->crud_model->count_appointment_today($doctor_id, date('d/m/Y'),$clinic_id);
                    }
                ?>
            </span>
            <label class="custom-control-label" for="today">Citas de hoy </label>
        </div>
    </li>
    <li>
        <div class="custom-control custom-radio">
            <input <?php if ($page_name=="cancelled"){ echo 'checked'; } ?> name="type" type="radio" class="custom-control-input" id="customCheck5" onclick="window.location.href='<?php echo base_url();?>admin/cancelled/';">
            <span class="badge badge-cancelled pull-right"><?php 
            
            if($filter){
                echo $this->crud_model->count_cancelled($doctor_id,$apply);
               
            }else{
                echo $this->crud_model->count_cancelled($doctor_id,date('d/m/Y'));
            }
           ?></span>
            <label class="custom-control-label" for="customCheck5">Canceladas</label>
        </div>
    </li>
    <li>
        <div class="custom-control custom-radio">
            <input <?php if ($page_name=="archived"){ echo 'checked'; } ?> name="type" type="radio" class="custom-control-input" id="customCheck6" onclick="window.location.href='<?php echo base_url();?>admin/archived/';">
            <span class="badge badge-archived pull-right"><?php 
            
            if($filter){
                echo $this->crud_model->count_archived($doctor_id,$apply);
               
            }else{
                echo $this->crud_model->count_archived($doctor_id,date('d/m/Y'));
            }
           ?></span>
            <label class="custom-control-label" for="customCheck6">Finalizadas</label>
        </div>
    </li>
</ul>