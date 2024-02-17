<!doctype html>
<html>
<head>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta name="x-apple-disable-message-reformatting">
	<meta name="format-detection" content="address=no">
	
</head>
<body>
	<div class="container" style="width: 100%; max-width: 800px; margin: 0 auto;">
		<div class="image-row" style="width: 100%; display: block; text-align: center;">
			
		</div>
		<div class="order" style="font-size: 16px;">
			<h2 class="title" style="font-size: 42px; font-weight: 600; font-style: normal; font-stretch: normal; line-height: normal; letter-spacing: normal; text-align: center; color: #000000; margin: 25px 0;">Agenda</h2>
			<div class="message" style="font-size: 16px; line-height: 1.5; text-align: center; color: #333333; margin-bottom: 20px;"><?php echo $email_msg;?>
			</div>
<div class="row">
                    <div class="col-md-12">
                        <h2 style="color: #333333"><?php echo $this->crud_model->formatear(date('d/m/Y'))." del ".date('Y'); ?></h2>
                         
                        <hr>
                        <table style="color: #333333" cellpadding="0" cellspacing="0"  style="width: 100%; ">
                                <thead>
                                    <th colspan="4" style="text-align:center; width: 100px;">Estado</th>
                                    <th colspan="4"  style="text-align:center; width: 100px;">Foto</th>
                                    <th colspan="4"  style="text-align:center; width: 100px;">Paciente</th>
                                    <th colspan="4"  style="text-align:center; width: 100px;">Especialista</th>
                                    <th colspan="4"  style="text-align:center; width: 100px;">Práctica</th>
                                    <th colspan="4"  style="text-align:center; width: 100px;">Fecha & Hora</th>
                                </thead>
                                <tbody>
                                    <?php
                                        $this->db->order_by('order_date', 'ASC');
                                        $this->db->where('status !=', '4');
                                        $this->db->where('status !=', '2');
                                        $this->db->where('status !=', '3');
                                        $this->db->where('date', date('d/m/Y'));
                                        $this->db->where('doctor_id',$doctor_id);
                                        $appointments = $this->db->get('appointment')->result_array();
                                        foreach($appointments as $appointment):
                                    ?>
                                    <tr style="font-family:'Poppins';font-size:14px;">
                                        <td style="text-align:center; width: 100px;" class="text-center" colspan="4">
                                            <?php if($appointment['status'] == 0):?>
                                                <span class="pending"  >Pendiente</span>
                                            <?php elseif($appointment['status'] == 1):?>
                                                <span class="confirmed">Confirmado</span>
                                            <?php endif;?>
                                        </td>
                                        <td style="text-align:center; width: 100px;" colspan="4">
                                            <a href="<?php echo base_url();?>doctor/appointment_details/<?php echo base64_encode($appointment['appointment_id']);?>">
                                                <img src="<?php echo base_url();?>public/uploads/doctor_image/QkUHgqIWSeVx.png" width="35px" style="padding-right:6px"> 
                                            
                                            </a>
                                        </td>
                                        <td style="text-align:center; width: 100px;" colspan="4">
                                            <a href="<?php echo base_url();?>doctor/appointment_details/<?php echo base64_encode($appointment['appointment_id']);?>">
                    
                                                <?php echo $this->accounts_model->short_name('patient', $appointment['patient_id']);?>
                                            </a>
                                        </td>
                                        <td style="text-align:center; width: 100px;" colspan="4"><?php echo $this->accounts_model->gender($appointment['doctor_id']).' '.$this->accounts_model->short_name('admin',$appointment['doctor_id']);?></td>
                                        <td style="text-align:center; width: 100px;" colspan="4">
                                            <?php if($appointment['practice'] > 0):?>
                                                <?php echo $this->db->get_where('service', array('service_id' => $appointment['practice']))->row()->name;?>
                                            <?php else:?>
                                                Otros servicios
                                            <?php endif;?>
                                        </td>
                                        <td style="text-align:center; width: 100px;" colspan="4" class="precio-ingreso"><?php echo $appointment['time'];?> <?php if($appointment['time'] < '12:00') echo 'AM'; else echo 'PM';?></td>

                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                    </div>
                </div>	
			<hr class="separator--line" style="border: solid 0.5px rgba(0, 0,0, 0.1);">
		</div>
	</div>
	<div class="footer" style="margin: 70px auto 0 auto; width: 100%; max-width: 944px; font-size: 16px;">
		<div class="footer__box" style="padding: 5px 41px 75px 36px;color: #fff; background-color: #6badff; text-align: center;border-radius: 13px;">
			<div class="footer__box__content">
				<div class="footer__box__title" style="font-size: 26px; margin: 20px 0;">¿Tienes preguntas?</div>
				<?php $sys_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>
				<div class="footer__box__caption">Visita nuestra página de <a href="#" style="color: #fff;">preguntas frecuentes</a> o contacta con el servicio de asistencia de <?php echo $sys_name;?>.
				</div>
			</div>
		</div>
	</div>
</body>
</html>