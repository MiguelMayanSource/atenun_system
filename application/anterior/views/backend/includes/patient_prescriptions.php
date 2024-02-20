<h5 class="panel-content-title">Receta de medicamentos<?php if($page_name != "patient_profile"):?><a href="javascript:void(0)" onclick="load_view('new_prescription','recetas')" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Nueva receta</a><?php endif; ?></h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">

        <?php 
            $refresh_query  = $this->db->get_where('prescription_ref',array('patient_id' => $patient_id));
            if($refresh_query->num_rows() > 0):
                $cont= 1;
            ?>

        <table class="table">
            <tr style="background-color:#f9fbfc; color:#59636d">
                <th>#</th>
                <th>Especialista</th>
                <th>Fecha & Hora</th>
                <th>Acciones</th>
            </tr>
            <?php foreach($refresh_query->result_array() as $row): ?>
            <tr>
                <td>
                    <?php echo $cont++;?>
                </td>
                <td>
                    <img src="<?php echo $this->accounts_model->get_photo('admin', $row['user_id']);?>" width="35px" style="padding-right:6px">
                    <?php echo $this->accounts_model->gender($row['user_id']);?>
                    <?php echo $this->accounts_model->short_name('admin', $row['user_id']);?>
                </td>
                <td><?php echo $row['date']?></td>
                <td>
                    <i onclick="window.open('<?php echo base_url().$this->session->userdata('login_type');?>/prescriptions/prescription_details/<?php echo $row['code'];?>', '_blank');" class="picons-thin-icon-thin-0100_to_do_list_reminder_done" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Detalles"></i>
                    <?php if($page_name != "patient_profile"):?><i onClick="delete_function('prescriptions/delete/<?php echo $row['code']; ?>','recetas',{'patient_id':<?php echo $patient_id; ?>},'patient_prescriptions')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="font-size:22px;color:#fd4f57" data-toggle="tooltip" data-placement="top" title="Eliminar"></i><?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="col-sm-12"><br>
            <center>
                <h5 class="poppins">Aún no hay medicamentos preescritos</h5><br><img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="max-width:20%;">
            </center>
        </div>
        <?php endif; ?>
    </div>
</div>