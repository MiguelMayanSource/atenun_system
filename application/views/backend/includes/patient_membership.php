<h5 class="panel-content-title">Membrecía <?php if($page_name != "patient_profile"):?><a href="javascript:void(0)" onclick="load_view('new_patient_vital_signs','vitals',{patient_id:<?php echo $patient_id; ?>})" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Registrar</a><?php endif; ?>    
     <a class="btn btn-info pull-right" href="javascript:void(0)" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_patient_membership/23');" style="margin-right:45px">Nueva</a> </h5>

    
    <span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">

        <?php 
            $refresh_query  = $this->db->order_by('patient_id','desc')->get_where('patient_membership',array('patient_id' => $patient_id));
            if($refresh_query->num_rows() > 0):
                $cont= 1;
            ?>
        <table class="table">
            <tr style="background-color:#f9fbfc; color:#59636d">
                <th>#</th>
                <th></th>
                <th>Fecha de Activación</th>
                <th>Fecha de Vencimiento</th>
                <th>Acciones</th>
            </tr>
            <?php foreach($refresh_query->result_array() as $row): ?>
            <tr>
                <td>
                    <?php echo $cont++;?>
                </td>
                <td>
                    <img src="<?php echo $this->accounts_model->get_photo($row['user_type'], $row['user_id']);?>" width="35px" style="padding-right:6px">
                    <?php echo $this->accounts_model->gender($row['user_id']);?>
                    <?php echo $this->accounts_model->short_name($row['user_type'], $row['user_id']);?>
                </td>
                <td><?php echo $row['date']?></td>
                <td>
                    <i onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_vital_sings/<?php echo $row['vital_sign_id'];?>')" class="picons-thin-icon-thin-0100_to_do_list_reminder_done" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Detalles"></i>
                    <?php if($page_name != "patient_profile"):?> <i onClick="delete_function('delete_content/patient_vital_signs/<?php echo base64_encode($row['vital_sign_id']); ?>','vitals',{'patient_id':<?php echo $patient_id; ?>},'patient_vital_signs')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="font-size:22px;color:#fd4f57" data-toggle="tooltip" data-placement="top" title="Eliminar"></i><?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="col-sm-12"><br>
            <center>
                <h5 class="poppins">Aún no cuenta con una membrecía</h5><br><img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="max-width:20%;">
            </center>
        </div>
        <?php endif; ?>
    </div>
</div>