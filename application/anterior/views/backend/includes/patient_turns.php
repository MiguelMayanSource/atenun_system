<h5 class="panel-content-title">Días de hospitalización <?php if($page_name != "patient_profile" ):?><a href="javascript:void(0)"  onclick="load_view('end_turn','turns',{'patient_id':<?php echo $patient_id; ?>,'stabilitation_id':'<?php echo $stabilitation_id;?>'})" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Cambiar de turno</a><?php endif; ?></h5>
<span class="app-divider2"></span>

<div class="row">
    <div class="col-sm-12">

        <?php 
            $refresh_query  = $this->db->order_by('stabilitation_id','desc')->get_where('stabilitation',array('stabilitation_ref_id' => $stabilitation_id));	
            if($refresh_query->num_rows() > 0):
                $cont= 1;
            ?>

        <table class="table">
            <tr style="background-color:#f9fbfc; color:#59636d">
                <th>#</th>
                <th>Fecha</th>
                <th>Doctor</th>
                <th>Enfermero</th>
                <th>Habitación</th>
                <th>Hora de ingreso</th>
                <th>Hora de egreso</th>
            </tr>
            <?php foreach($refresh_query->result_array() as $row): ?>
            <tr>
                <td>
                    <?php echo $cont++;?>
                </td>
                <td style="white-space: nowrap;">
                    <?php echo $row['date'];?>
                </td>
                <td style="text-align: center;">
                    <img src="<?php echo $this->accounts_model->get_photo( 'admin', $row['doctor_id']);?>" width="35px" style="padding-right:6px">
                    <br>
                    <span style="white-space: nowrap;">
                        <?php echo $this->accounts_model->gender($row['doctor_id']);?>
                        <?php echo $this->accounts_model->short_name('admin', $row['doctor_id']);?>
                    </span>
                </td>
                <td style="text-align: center;">
                    <img src="<?php echo $this->accounts_model->get_photo( 'staff', $row['staff_id']);?>" width="35px" style="padding-right:6px">
                    <br>
                    <span style="white-space: nowrap;">
                        <?php echo $this->accounts_model->short_name('staff', $row['staff_id']);?>
                    </span>
                </td>
                <td><?php echo $this->db->get_where('room', array('room_id' => $row['room_id']))->row()->name;?></td>
                <td><?php echo $row['hour_start']?></td>
                <td><?php echo $row['hour_end']?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="col-sm-12"><br>
            <center>
                <h5 class="poppins">Aún no hay dias de hospitalización agregados</h5><br><img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="max-width:20%;">
            </center>
        </div>
        <?php endif; ?>
    </div>
</div>