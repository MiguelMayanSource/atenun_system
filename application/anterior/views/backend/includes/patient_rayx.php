<h5 class="panel-content-title">Ordenes de rayos X <?php if($page_name != "patient_profile" ):?><a href="javascript:void(0)" onclick="load_view('new_rayx','rayx',{'patient_id':<?php echo $patient_id; ?>,'origin_id':'<?php echo $origin_id;?>','origin_type':'<?php echo $origin_type;?>'})" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Nueva orden de Rayos X</a><?php endif; ?></h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">

        <?php 
            $refresh_query  = $this->db->order_by('patient_service_id','desc')->get_where('patient_service',array('patient_id' => $patient_id));
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
                    <img src="<?php echo $this->accounts_model->get_photo( 'admin', $row['doctor_id']);?>" width="35px" style="padding-right:6px">
                    <?php echo $this->accounts_model->gender($row['doctor_id']);?>
                    <?php echo $this->accounts_model->short_name( 'admin', $row['doctor_id']);?>
                </td>
                <td><?php echo $row['date']?></td>
                <td>
                    <?php 
                        if( $row['status'] == 0):
                            $td5 = '<span class="text-info"><b>Pendiente</b></span>';
                        endif; 
                        
                        if( $row['status'] == 1):
                            $td5 = '<span class="text-warning"><b>Pagada</b></span>';
                        endif; 
                        
                        if( $row['status'] == 2):
                            $td5 = '<span class="text-success"><b>Informe subido</b></span>';
                        endif; 
                        
                        if( $row['status'] == 4):
                           $td5 = '<span class="text-danger"><b>Anulada</b></span>';
                        endif; 
                        
                        
                        echo $td5;
                    ?>
                </td>
                <td>
                    <?php
                        if($row['status'] == 1 || $row['status'] == 2):
                            $td6 = '<a onclick="showAjaxModal(\''.base_url().'modal/popup/modal_patient_service_details/'.$row['patient_service_id'].'\')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg></a>';
                         endif;
                         
                         echo $td6;
                    ?>
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