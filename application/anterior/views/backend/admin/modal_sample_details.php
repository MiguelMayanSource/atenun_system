<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>admin/services/create" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-heart-full"></i> Agregar nuevo servicio.</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <?php 
            $login_type = $this->session->userdata('login_type');
            $data_edit = $this->db->get_where('sample',array('sample_id'=>$param2))->result_array();
            foreach($data_edit as $row):
            $code = $row['code'];
        ?>

            <form action="<?php echo base_url();?>admin/samples/delivery/<?php echo $param2; ?>" method="post" enctype="multipart/form-data" id='formGroup'>
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
                                        <p> <b>Doctor: </b><a href="mailto:'.$dev['email'].'"><?php echo $this->accounts_model->short_name('admin',$row['doctors_id']); ?><?php if($row['several_doctors']!=""):?><?php endif; ?></a> </p>
                                        <p> <b>Estudio: </b><?php echo $row['study'];?> </p>
                                        <p> <b>Entregado por: </b> <?php echo $row['delivered_by'];?> </p>
                                        <p> <b>Fecha de recibido: </b><?php echo date('d/m/Y',strtotime($row['received_date']));?> </p>
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
                                                $acciones.='<a style="color: black;font-size: 22px;padding: 12px;" title="Resultados"  href="'.base_url().$login_type.'/laboratory_results/'.base64_encode($row['sample_id']).'"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></a>';
                                            }
                                                            
                                            if($row['credit'] == 1 && $row['status_payment'] ==0)
                                            {
                                                $acciones .='<a style="color: black;font-size: 22px;padding: 12px;" title="Pagos"  href="'.base_url().$login_type.'/samples_pay/'.$row['code'].'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></a>';
                                            }
                                            if($row['status'] >0 )
                                            {
                                                $acciones.='<a  style="color: black;font-size: 22px;padding: 12px;" title="Informe" target="_blanck" href="'.base_url().'admin/laboratory_results/download/'.base64_encode($row['sample_id']).'" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></a>';
                                                $acciones.='<a  style="color: black;font-size: 22px;padding: 12px;" title="Informe" target="_blanck" href="'.base_url().'admin/laboratory_results/print/'.base64_encode($row['sample_id']).'" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></a>';
                                            }
                                           
                                            $acciones.='<a  style="color: black;font-size: 22px;padding: 12px;" title="Entregar"  href="javascript:;" onclick="showAjaxModal(\''.base_url().'modal/popup/modal_delivery/'.$row['sample_id'].'\')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></a>';
                                         
        
                                            if( $row['status_delivery'] == 1){
                                                $acciones.='<a  style="color: black;font-size: 22px;padding: 12px;" title="Recibo de entrega"  href="javascript:print_delivery(\''.$row['code'].'\')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                                </a>';
                                            }
                                        else{
                                            
                                            if($row['code_group'] == '0' )
                                            $acciones.='<a  style="color: black;font-size: 22px;padding: 12px;"  title="Recibo de muestra"  href="javascript:print(\''.$row['code'].'\')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg></a>';
                                            else
                                            $acciones.='<a  style="color: black;font-size: 22px;padding: 12px;"  title="Recibo de muestra"  href="javascript:print_group(\''.$row['code_group'].'\')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg></a>';


                                        }


                                        $acciones.='<a  style="color: black;font-size: 22px;padding: 12px;" title="Editar"  href="'.base_url().$login_type.'/samples_edit/'.base64_encode($row['sample_id']).'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                            <a  style="color: black;font-size: 22px;padding: 12px;" title="Eliminar"  href="javascript:void(0);" onclick="delete_user(\'samples\','.$row['sample_id'].')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                                            echo $acciones; ?>

                                        </div>
                                        <?php if($row['leaf'] != ""): ?>
                                        <hr>
                                        <p> <b>Hoja de datos:</b></p>
                                        <img src="<?php echo base_url(); ?>uploads/files/<?php echo $row['leaf']?>" onClick="window.open(this.src)" style="max-width:500px; " /><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php endforeach; ?>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Enviar</button>
        </div>
    </form>
</div>