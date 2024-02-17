<?php 
    $patient_id = base64_decode($id_);
    $this->db->where('patient_id', $patient_id);
    $info = $this->db->get('patient')->result_array();    
    foreach($info as $details):
?>
<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_profile/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Editar perfil </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/medical_history/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_security/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/medical_prescriptions/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i> Recetas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_files/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0119_folder_open_full_documents"></i> Archivos </a>
                        </li>
                        <?php  
                            $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                            if($odonto != ''):
                        ?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/treatment/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0826_teeth_tooth_dental"></i> Planes de tratamiento </a>
                        </li>
                        <?php endif;?>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/patient_appointments/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>doctor/patient_financial/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0425_money_payment_dollar_cash"></i> Financiero <span class="side-active"></span> </a>
                        </li>
                        <li class="side-li" style="border:none"></li>
                        <li class="side-li" style="border:none"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content" style="margin-bottom:10%">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Historial financiero - <?php echo $this->accounts_model->get_name('patient',$details['patient_id']);?></span>
        </h4>

        <?php 
        $total = 0;
		$income_det = $this->db->get_where('financial', array('patient_id' => $patient_id, 'type' => 1))->result_array();
		if(count($income_det) > 0):
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Historial financiero.</span>
                    <span class="alert-content">Gestiona todos los recibos o comprobantes de pago de tus pacientes, además de visualizar el monto total de todas sus <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">citas</a>.</span></span>
                </div>
            </div>
            <div class="col-sm-12">
                <?php
				    foreach($income_det as $inc){
						$total += $inc['amount'];	    
					}
				?>
                <div class="tasks-section">
                    <div class="balance-widget">
                        <h4 class="balance-title">Total facturado</h4>
                        <span class="app-divider2"></span>
                        <h1 style="font-family: 'CircularStd', sans-serif; font-weight: 800; color: #ffca07;"><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>. <?php echo number_format($total,2,'.',',');?></h1>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-padded">
                            <thead>
                                <th width="40px">#</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Monto</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <?php
                            $n = 1;
							$income_details = $this->db->get_where('financial', array('patient_id' => $patient_id, 'type' => 1))->result_array();
							foreach($income_details as $income):    
						?>
                                <tr style="font-family:'Poppins';font-size:14px;">
                                    <td><?php echo $n++;?></td>
                                    <td><?php echo $income['date'];?></td>
                                    <td>
                                        <?php
                                    $service_id =0;
                                    if($income['appointment_id']!='')
                                    $service_id = $this->db->get_where('appointment', array('appointment_id' => $income['appointment_id']))->row()->practice;


    									if($service_id > 0) echo $this->db->get_where('service', array('service_id' => $service_id))->row()->name; 
    									elseif($income['treatment_id'] > 0) echo $income['description'];
    									
    									else
    									echo "Otros servicios";
									?>
                                    </td>
                                    <td class="precio-ingreso"><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>. <?php echo number_format($income['amount'],2,'.',',');?></td>
                                    <td>
                                        <?php if($this->crud_model->treatmentss($income['treatment_id']) > 0):?>

                                        <i onclick="window.open('<?php echo base_url();?>doctor/treatment_archive/email/<?php echo $income['treatment_id'];?>/<?php echo $patient_id;?>');" class="picons-thin-icon-thin-0315_email_mail_post_send" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Enviar recibo por correo"></i>
                                        <i onclick="window.location.href='<?php echo base_url();?>doctor/treatment_archive/pdf/<?php echo $income['treatment_id'];?>/<?php echo $patient_id;?>';" class="picons-thin-icon-thin-0123_download_cloud_file_sync" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Descargar PDF"></i>

                                        <?php else:?>
                                        <?php if($income['appointment_id'] != ""):?>
                                        <i onclick="window.open('<?php echo base_url();?>doctor/sale_details_financial/email/<?php echo $income['appointment_id'];?>/<?php echo $patient_id;?>');" class="picons-thin-icon-thin-0315_email_mail_post_send" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Enviar recibo por correo"></i>
                                        <i onclick="window.open('<?php echo base_url();?>doctor/print_receipt/<?php echo $income['appointment_id'];?>', '_blank');" class="picons-thin-icon-thin-0333_printer" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Imprimir"></i>
                                        <i onclick="window.location.href='<?php echo base_url();?>doctor/sale_details_financial/pdf/<?php echo $income['appointment_id'];?>';" class="picons-thin-icon-thin-0123_download_cloud_file_sync" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Descargar PDF"></i>
                                        <?php else: ?>


                                        <i onclick="window.open('<?php echo base_url();?>doctor/sale_details_financial/email2/<?php echo $income['cart_id'];?>/<?php echo $patient_id;?>');" class="picons-thin-icon-thin-0315_email_mail_post_send" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Enviar recibo por correo"></i>
                                        <i onclick="window.open('<?php echo base_url();?>doctor/print_receipt2/<?php echo $income['cart_id'];?>', '_blank');" class="picons-thin-icon-thin-0333_printer" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Imprimir"></i>
                                        <i onclick="window.location.href='<?php echo base_url();?>doctor/sale_details_financial/pdf2/<?php echo $income['cart_id'];?>';" class="picons-thin-icon-thin-0123_download_cloud_file_sync" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Descargar PDF"></i>
                                        <?php endif;?>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php else:?>
        <div class="card-box"><br>
            <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">El paciente aún no tiene registro financiero</h4>
            <br>
            <center><img src="<?php echo base_url();?>public/uploads/money.png" style="width:25%" /></center>
        </div>
        <?php endif;?>


    </div>
</div>
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>

<script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
<script>
var sidebar = new StickySidebar('#sticky', {
    topSpacing: 0
});
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});
if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
</script>
<?php  endforeach; ?>


<script src="<?php echo base_url();?>public/assets/theme/js/chart.js/Chart.bundle.min.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/chart.js/chartJs-config-chartsHTML.js"></script>