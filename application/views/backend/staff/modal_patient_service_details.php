<div class="modal-content animated fadeInDown">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-heart-full"></i> Agregar nuevo servicio.</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <?php 
            $login_type = $this->session->userdata('login_type');
            $data_edit = $this->db->get_where('patient_service',array('patient_service_id'=>$param2))->result_array(); 
            foreach($data_edit as $row):
            $code = $row['code']; 
        ?>

                <div class="widget widget-activity-one">

                    <div class="widget-heading">
                        <h5 class=""> <?php echo $row['code'];?></h5>
                    </div>

                    <div class="widget-content">
                        <div class="mt-container mx-auto ps ps--active-y">
                            <div class='container row'>
                                <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                                    <div class="form-group">
                                        <p><b> Paciente: </b><a href="mailto:'.$dev['email'].'"><?php echo $this->accounts_model->short_name('patient',$row['patient_id']);?></a></p>
                                        <p> <b>Doctor: </b><a href="mailto:'.$dev['email'].'"><?php echo $this->accounts_model->short_name('admin',$row['doctor_id']); ?><?php if($row['several_doctors']!=""):?><?php endif; ?></a> </p>
                                        <p> <b>Estudio: </b><?php echo $row['study'];?> </p>
                                        <p> <b>Entregado por: </b> <?php echo $row['delivered_by'];?> </p>
                                        <p> <b>Fecha de recibido: </b><?php echo date('d/m/Y',strtotime($row['date']));?> </p>
                                        <p> <b>Dirección de recepción: </b><?php echo $row['address_r'];?> <b>Dirección de entrega: </b><?php echo $row['address']; ?> </p>
                                        <p> <b>Prioridad: </b>
                                            <?php if($row['priority'] == 1) echo 'Normal';?>
                                            <?php if($row['priority'] == 2) echo 'Prioridad';?>
                                            <?php if($row['priority'] == 3) echo 'Urgencia';?>
                                            <?php if($row['priority'] == 4) echo 'Normal';?>

                                            <?php if($row['priority'] == 5) echo 'Normal';?>
                                            <?php if($row['priority'] == 6) echo 'Normal';?>
                                            <?php if($row['priority'] == 7) echo 'Urgencia 4 días';?>
                                        </p>
                                        <p> <b>CN/CR: </b><?php  if($row['credit'] == 1){ echo 'Credito';} else{ echo 'Contado';}?></p>
                                        <hr>

                                        <h5 class="">Acciones</h5>
                                        <div class='' style='display: inline-flex;'>
                                            <?php 
                                             if( $row['status_delivery'] == 0)
                                            {
                                                $acciones.='<a style="color: black;font-size: 22px;padding: 12px;" title="Resultados"  href="'.base_url().$login_type.'/service_details/'.base64_encode($row['patient_service_id']).'"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></a>';
                                            }
                                           
                                            $acciones.='<a  style="color: black;font-size: 22px;padding: 12px;" title="Entregar"  href="javascript:;" onclick="showAjaxModal(\''.base_url().'modal/popup/modal_delivery/'.$row['patient_service_id'].'\')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></a>';
                                         
        
                                            if( $row['status_delivery'] == 1)
                                            {
                                                $acciones.='<a  style="color: black;font-size: 22px;padding: 12px;" title="Recibo de entrega"  href="javascript:print_delivery(\''.$row['code'].'\')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                                </a>';
                                            }
                                          
                                     $acciones.='<a  style="color: black;font-size: 22px;padding: 12px;" title="Eliminar"  href="javascript:void(0);" onclick="delete_user(\'samples\','.$row['sample_id'].')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                                            
                                            echo $acciones; 
                                        ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            <?php endforeach; ?>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Enviar</button>
        </div>
</div>