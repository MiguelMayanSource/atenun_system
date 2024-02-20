<!doctype html>
<html>
<head>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style media="all" type="text/css">
		@media only screen and (max-width: 600px) {
  			.legal-attachments td {
	    		display: block !important;
  			}
		}
		@media only screen and (max-width: 600px) {
  			.order .title {
    			font-size: 34px !important;
  			}
		}
		@media only screen and (max-width: 600px) {
  			.order .store-image > span {
    			font-size: 30px !important;
  			}
		}
	</style>
</head>
<body style="font-family: Helvetica, Arial, sans-serif; color: #000;">
	<div class="container" style="width: 100%; max-width: 536px; margin: 0 auto;">
		<div class="image-row" style="width: 100%; display: block; text-align: center;">
			<img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" class="glovo-logo-small" style="width: 30%; margin: 20px auto;" width="30%">
		</div>
		<div class="order" style="-webkit-font-smoothing: antialiased; font-size: 16px;">
			<h2 class="title" style="font-size: 42px; font-weight: 600; font-style: normal; font-stretch: normal; line-height: normal; letter-spacing: normal; text-align: center; color: #000000; margin: 25px 0;">Encuesta de servicio</h2>
			<div class="message" style="font-size: 16px; line-height: 1.5; text-align: center; color: #333333; margin-bottom: 20px;">Hola, <b><?php echo $this->accounts_model->short_name('patient', $patient_id);?></b>. Recibes este correo porque tu cita <b><?php echo $service_name;?></b> ha finalizado, y con el fin de mejorar nuestros servicios médicos nos gustaría que te tomaras unos minutos en poder responder la siguiente encuenta:
			</div>
			<img src="<?php echo base_url();?>public/uploads/wave.png" alt="separator" class="separator" style="width: 100%; object-fit: cover;">
				<table class="breakdown table" style="margin: 20px 0; width: 100%; color: #000000;" width="100%">
				<tr>
					<td style="text-align:center;"><a href="<?php echo base_url();?>survey/reply?id=<?php echo base64_encode(date('d/m/Y H:i:s a')."-".$survey_id."-".$patient_id."-".$appointment_id."-".date('d/m/Y H:i:s a'));?>" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none;border-radius: 6px; padding: 12px 50px; display: inline-block;background:#dd2979;"><b>Responder encuesta</b></a></td>
				</tr>
			</table>	
		</div>
	</div>
	<div class="footer" style="margin: 70px auto 0 auto; width: 100%; max-width: 944px; font-size: 16px;">
		<div class="footer__box" style="padding: 5px 41px 75px 36px;color: #fff; background-color: #6badff; text-align: center;border-radius: 13px;">
			<div class="footer__box__content">
				<div class="footer__box__title" style="font-size: 26px; margin: 20px 0;">¿Tienes preguntas?</div>
				<div class="footer__box__caption">Visita nuestra página de <a href="#" style="color: #fff;">preguntas frecuentes</a> de <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?>.
			    <div class="footer__box__caption">No quieres recibir mas correos, puedes cancelar nuestro servicio de notificaciones por correo en el siguiente enlace, <a href="<?php echo base_url();?>patient/unsubscribe/<?php echo base64_encode($patient_id);?>" style="color: #fff;">Dar de baja.</a>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>
</html>