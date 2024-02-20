<h5 class="panel-content-title">Medicamentos</h5>
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
                <th>total</th>
            </tr>
            <?php $total_med=0; foreach($refresh_query->result_array() as $row): ?>
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
                    Q.<?php $total_med += $row['dosis']*$row['price']; echo number_format($row['dosis']*$row['price'],2,'.',','); ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><b>Total:</b></td>
                <td>
                   <b> Q.<?php echo number_format($total_med,2,'.',','); ?></b>
                </td>
            </tr>
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
<br>
<?php 
    $refresh_query  = $this->db->order_by('sample_id','desc')->get_where('sample',array('origin_id' => $stabilitation_id,'origin_type'=>$origin_type));
    if($refresh_query->num_rows() > 0):
        $cont= 1;
    ?>
<h5 class="panel-content-title">Ordenes de laboratorios </h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">

        
        <table class="table">
            <tr style="background-color:#f9fbfc; color:#59636d">
                <th>#</th>
                <th>Código</th>
                <th>Especialista</th>
                <th>Fecha & Hora</th>
                <th>Estado</th>
                <th>Total</th>
            </tr>
            <?php $total_labs=0; foreach($refresh_query->result_array() as $row): ?>
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
                    Q.<?php $total_labs +=$row['total']; echo $row['total'];?>
                   
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><b>Total:</b></td>
                <td>
                   <b> Q.<?php echo number_format($total_labs,2,'.',','); ?></b>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php endif; ?>
<br>
 <?php 
    $refresh_query  = $this->db->order_by('patient_service_id','desc')->get_where('patient_service',array('origin_id' => $stabilitation_id,'origin'=>'stabilitation'));
    if($refresh_query->num_rows() > 0):
        $cont= 1;
?>
<h5 class="panel-content-title">Ordenes de rayos X </h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">

       
        <table class="table">
            <tr style="background-color:#f9fbfc; color:#59636d">
                <th>#</th>
                <th>Código</th>
                <th>Especialista</th>
                <th>Fecha & Hora</th>
                <th>Estado</th>
                <th>Total</th>
            </tr>
            <?php $total_labs=0; foreach($refresh_query->result_array() as $row): ?>
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
                    Q.<?php $total_labs +=$row['total']; echo $row['total'];?>
                   
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><b>Total:</b></td>
                <td>
                   <b> Q.<?php echo number_format($total_labs,2,'.',','); ?></b>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php endif; ?>