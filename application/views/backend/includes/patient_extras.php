<h5 class="panel-content-title">Servios o Productos extras <?php if($page_name != "patient_profile" ):?><a href="javascript:void(0)" onclick="load_view('new_patient_extras','extras',{'patient_id':<?php echo $patient_id; ?>,'origin_id':'<?php echo $origin_id;?>','origin_type':'<?php echo $origin_type;?>'})" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Agregar</a><?php endif; ?></h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">

        <?php 
            $refresh_query  = $this->db->order_by('product_move_id','desc')->get_where('product_move',array('origin_id' => $origin_id,'origin_type' => $origin_type, 'status'=>1));
            if($refresh_query->num_rows() > 0):
                $cont= 1;
            ?>
        <table class="table">
            <tr style="background-color:#f9fbfc; color:#59636d">
                <th>#</th> 
                <th>Especialista</th>
                <th>Fecha & Hora</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>-</th>
            </tr>
            <?php foreach($refresh_query->result_array() as $row): ?>
            <tr>
                <td>
                    <?php echo $cont++;?> 
                </td> 
                <td>
                    <img src="<?php echo $this->accounts_model->get_photo( 'admin', $row['doctor_id']);?>" width="35px" style="padding-right:6px">
                    <?php echo $this->accounts_model->gender($row['doctor_id']);?>
                    <?php echo $this->accounts_model->short_name( 'admin', $row['doctor_id']);?>
                </td>
                <td><?php echo $row['date']?></td>
                <td><?php echo $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->name; ?></td>
                <td><?php echo $row['amount'].' '.$this->db->get_where('unity',array('code'=>$row['unity']))->row()->name; ?></td>
                <td>
                    <i onClick="delete_function('delete_content/patient_extras/<?php echo base64_encode($row['product_move_id']); ?>','extras',{'patient_id':<?php echo $patient_id; ?>,'origin_id':'<?php echo $origin_id;?>','origin_type':'<?php echo $origin_type;?>'},'patient_extras')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="font-size:22px;color:#fd4f57" data-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="col-sm-12"><br>
            <center>
                <h5 class="poppins">Aún no hay ordenes médicas</h5><br><img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="max-width:20%;">
            </center>
        </div>
        <?php endif; ?>
    </div>
</div>