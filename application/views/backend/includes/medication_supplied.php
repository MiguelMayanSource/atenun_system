<h5 class="panel-content-title">Control de medicamentos<a href="javascript:void(0)" onclick="load_view('new_medication_supplied','medication_supplied',{'stabilitation_id':<?php echo $stabilitation_id?>})" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Agregar</a></h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">

        <?php 
            $refresh_query  = $this->db->order_by('medication_supplied_id','desc')->get_where('medication_supplied',array('stabilitation_ref_id' => $stabilitation_id));	
            if($refresh_query->num_rows() > 0):
                $cont= 1;
            ?>

        <table class="table">
            <tr style="background-color:#f9fbfc; color:#59636d">
                <th>Responsable</th>
                <th>Fecha & Hora</th>
                <th>Dosis</th>
                <th>Medicamento</th>
                <th>Acciones</th>
            </tr>
            <?php foreach($refresh_query->result_array() as $row): ?>
            <tr>
                <td>
                    <img src="<?php echo $this->accounts_model->get_photo('admin', $row['user_id']);?>" width="35px" style="padding-right:6px">
                    <?php echo $this->accounts_model->gender($row['user_id']);?>
                    <?php echo $this->accounts_model->short_name('admin', $row['user_id']);?>
                </td>
                <td><?php echo $row['date']?></td>
                <td><?php echo $row['dosis']?></td>
                <td><?php echo $this->db->get_where('product', array('product_id'=>$row['product_id']))->row()->name;?></td>
                <td>
                    <i onClick="delete_function('delete_content/medication_supplied/<?php echo base64_encode($row['medication_supplied_id']); ?>','medication_supplied',{'stabilitation_id':<?php echo $stabilitation_id; ?>},'medication_supplied')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="font-size:22px;color:#fd4f57" data-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="col-sm-12"><br>
            <center>
                <h5 class="poppins">Aún no hay medicamentos</h5><br><img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="max-width:20%;">
            </center>
        </div>
        <?php endif; ?>
    </div>
</div>