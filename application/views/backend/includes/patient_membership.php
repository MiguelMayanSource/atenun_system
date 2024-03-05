<h5 class="panel-content-title">Membrecías <a class="btn btn-info pull-right" href="javascript:void(0)" onclick="modal_lg('<?php echo base_url();?>Modal/popup/modal_patient_membership');" style="margin-right:45px">Nuevo</a></h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">

        <?php 
            $refresh_query  = $this->db->order_by('sample_id','desc')->get_where('sample',array('patient_id' => $patient_id));
            if($refresh_query->num_rows() > 0):
                $cont= 1;
            ?>
        <table class="table">
            <tr style="background-color:#f9fbfc; color:#59636d">
                <th>#</th>
                <th>Código</th>
                <th>Especialista</th>
                <th>Fecha & Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            <?php foreach($refresh_query->result_array() as $row): ?>
            <tr>
                <td>
                    <?php echo $cont++;?>
                </td>
                <td>
                    <?php echo $row['code'];?>
                </td>
                <td>
                    <img src="<?php echo $this->accounts_model->get_photo( $row['user_type'], $row['user_id']);?>" width="35px" style="padding-right:6px">
                    <?php echo $this->accounts_model->gender($row['user_id']);?>
                    <?php echo $this->accounts_model->short_name( $row['user_type'], $row['user_id']);?>
                </td>
                <td><?php echo $row['date']?></td>
                <td>
                    <?php if($row['status'] == 0):?>
                        <span class="text-info"><b>Pendiente</b></span>
                    <?php endif; ?>
                    <?php if($row['status'] == 1):?>
                        <span class="text-success"><b>Completada</b></span>
                    <?php endif; ?>
                    <?php if($row['status'] == 4):?>
                        <span class="text-danger"><b>Anulada</b></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($row['status'] == 1):?>
                    <i onclick="window.open('<?php echo base_url().$this->session->userdata('login_type').'/laboratory_results/download/'.base64_encode($row['sample_id'])?>', '_blank');" class="picons-thin-icon-thin-0100_to_do_list_reminder_done" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Detalles"></i>
                    <?php endif; ?>
                   
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="col-sm-12"><br>
            <center>
                <h5 class="poppins">Aún no hay membrecías</h5><br><img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="max-width:20%;">
            </center>
        </div>
        <?php endif; ?>
    </div>
</div>