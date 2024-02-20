<h5 class="panel-content-title">Consentimientos informados <?php if($page_name != "patient_profile" ):?><a href="javascript:void(0)" onclick="load_view('new_patient_consent','consent',{'patient_id':<?php echo $patient_id; ?>,'origin_id':'<?php echo $origin_id;?>','origin_type':'<?php echo $origin_type;?>'})" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Agregar</a><?php endif; ?></h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">

        <?php 
            $refresh_query  = $this->db->order_by('patient_consent_id','desc')->get_where('patient_consent',array('patient_id' => $patient_id));
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
                    <img src="<?php echo $this->accounts_model->get_photo( $row['user_type'], $row['user_id']);?>" width="35px" style="padding-right:6px">
                    <?php echo $this->accounts_model->short_name(  $row['user_type'], $row['user_id']);?>
                </td>
                <td><?php echo $row['date']?></td>
                <td>
                    <i onclick="window.open('<?php echo base_url().$this->session->userdata('login_type').'/';?>patient_consent/print_consent/<?php echo $row['patient_consent_id'];?>', '_blank');" class="picons-thin-icon-thin-0100_to_do_list_reminder_done" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Detalles"></i>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="col-sm-12"><br>
            <center>
                <h5 class="poppins">Aún no hay consentimientos agregados</h5><br><img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="max-width:20%;">
            </center>
        </div>
        <?php endif; ?>
    </div>
</div>