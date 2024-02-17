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
	<meta name="x-apple-disable-message-reformatting">
	<meta name="format-detection" content="address=no">
</head>
<body style="font-family: Helvetica, Arial, sans-serif; color: #000;">
	<div class="container" style="width: 100%; max-width: 536px; margin: 0 auto;">
		<div class="image-row" style="width: 100%; display: block; text-align: center;">
			<img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" class="glovo-logo-small" style="width: 30%; margin: 20px auto;" width="30%">
		</div>
		<div class="order" style="-webkit-font-smoothing: antialiased; font-size: 16px;">
			<h2 class="title" style="font-size: 42px; font-weight: 600; font-style: normal; font-stretch: normal; line-height: normal; letter-spacing: normal; text-align: center; color: #000000; margin: 25px 0;">Credenciales</h2>
			<div class="message" style="font-size: 16px; line-height: 1.5; text-align: center; color: #333333; margin-bottom: 20px;"><?php echo $email_msg;?>
			</div>
			<img src="<?php echo base_url();?>public/uploads/wave.png" alt="separator" class="separator" style="width: 100%; object-fit: cover;">
				 
				<hr class="separator--line" style="border: solid 0.5px rgba(0, 0,0, 0.1);">
				<table class="breakdown table" style="margin: 20px 0; width: 100%; color: #000000;" width="100%">
				<tr>
					<td style="padding: 10px 0;">Si crees que se trata de un error, envía un mensaje a: soporte@mayansource.com</td>
				</tr>
			</table>	
			<hr class="separator--line" style="border: solid 0.5px rgba(0, 0,0, 0.1);">
		</div>
	</div>
	<div class="footer" style="margin: 70px auto 0 auto; width: 100%; max-width: 944px; font-size: 16px;">
		<div class="footer__box" style="padding: 5px 41px 75px 36px;color: #fff; background-color: #6badff; text-align: center;border-radius: 13px;">
			<div class="footer__box__content">
				<div class="footer__box__title" style="font-size: 26px; margin: 20px 0;">¿Tienes preguntas?</div>
				<div class="footer__box__caption">Visita nuestra página de <a href="https://medicaby.com/faq/" style="color: #fff;">preguntas frecuentes</a><!-- o contacta con el servicio de asistencia en la aplicación iOS o Android de Medesk.-->
				</div>
			</div>
		</div>
	</div>
</body>
</html>