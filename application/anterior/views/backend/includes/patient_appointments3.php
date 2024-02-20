<h5 class="panel-content-title">Citas del paciente <?php if($page_name != "patient_profile"):?><a href="javascript:void(0)" onclick="load_view('appointments','evol',{'patient_id':<?php echo $patient_id; ?>})" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Ver las citas.</a><?php endif; ?></h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="editor">
        <?php 
            $history = $this->db->get_where('patient',array('patient_id'=>$patient_id))->row()->history; 
            $apps_op = $this->db->order_by('appointment_id','asc')->get_where('appointment',array('observations !='=>'','patient_id'=>$patient_id))->result_array();
            foreach($apps_op as $obse)
            {
                $history .= $obse['observations'];
                
            }
            if($history != ""):
        ?>
        <?php 
            echo $history;
         else: ?>
        <div class="page" id="page_1" contenteditable="true" onkeydown="checkPage(this,event)"></div>
        <?php endif; ?>
    </div>  
</div>
