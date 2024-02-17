<?php $system_title = $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description; ?>
<?php $system_name = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Medicaby">
    <meta name="description" content="Medicaby - El software más completo para el control clínico en la nube">
	<title><?php echo $system_name;?> | <?php echo $system_title;?></title>
	<link href="<?php echo base_url();?>public/assets/theme/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link href="<?php echo base_url();?>public/assets/theme/css/dripicons.css" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/style.css?ver=1.1.1">
	<link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/batch-icons/style.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Pacifico&display=swap" rel="stylesheet">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>public/assets/theme/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>public/assets/theme/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>public/assets/theme/img/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url();?>public/assets/theme/img/site.webmanifest">
    <link rel="mask-icon" href="<?php echo base_url();?>public/assets/theme/img/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body style="background-color: #222533; padding: 20px; font-family: font-size: 14px; line-height: 1.43; font-family: &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;">
        <div style="max-width: 600px; margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">
            <table style="width: 100%;">
                <tr>
                    <td style="background-color: #fff; display:flex"> 
                        <img alt="" src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" style="width: 25%; padding: 20px; right:10px">
                     <h2 style="margin-top:30px"><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?></h2>
                    </td>
                    <td style="padding-left: 50px; text-align: right; padding-right: 20px;">
                        <a href="#" style="color: #261D1D; text-decoration: underline; font-size: 14px; letter-spacing: 1px;">Sitio web</a>
                    </td>
                </tr>
            </table>
            
            <?php $this->db->where('appointment_id', $appointment_id);
                 $arrs = $this->db->get('appointment')->result_array();
                  
                   foreach($arrs as $appointment):
            
            ?>
            <div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
                <h1 style="margin-top: 0px; margin-bottom: 50px;">Hola <?php echo $this->db->get_where('patient', array('patient_id' => $appointment['patient_id']))->row()->first_name;?> </h1>
                <div style="color: #636363; font-size: 14px;">
                    <p>Tu cita a sido confirmada para el <b><?php echo $appointment['day'];?> de <?php setlocale(LC_TIME, 'es_ES');  $numero = $appointment['month'];  $fecha = DateTime::createFromFormat('!m', $numero); $mes = strftime("%B", $fecha->getTimestamp()); echo $mes?> a las <?php echo $appointment['time'];?> horas</b>,
                    para mas información puedes comunicarte al nuestro numero <b><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->phone;?></b> o al correo electronico <b><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email;?></b></p>
                </div>
                <h4 style="margin-bottom: 100px; margin-top: 100px;">!Te esperamos!</h4>
                <div style="color: #A5A5A5; font-size: 12px;">
                    <p>Si tienes alguna pregunta o duda con respecto a este correo electrónico. Por favor escríbenos a <a href="mailto:info@medesk.gt" style="text-decoration: underline; color: #4B72FA;"><?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email;?></a></p>
                </div>
            </div>
            
        </div>
        	<div class="footer" style="margin: 70px auto 0 auto; width: 100%; max-width: 944px; font-size: 16px;">
		<div class="footer__box" style="padding: 5px 41px 75px 36px;color: #fff; background-color: #6badff; text-align: center;border-radius: 13px;">
			<div class="footer__box__content">
				<div class="footer__box__title" style="font-size: 26px; margin: 20px 0;">¿Tienes preguntas?</div>
				<div class="footer__box__caption">Visita nuestra página de <a href="#" style="color: #fff;">preguntas frecuentes</a> de <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?>.
			    <div class="footer__box__caption">No quieres recibir mas correos, puedes cancelar nuestro servicio de notificaciones por correo en el siguiente enlace, <a href="<?php echo base_url();?>patient/unsubscribe/<?php echo base64_encode($appointment['patient_id']);?>" style="color: #fff;">Dar de baja.</a>
				</div>
			</div>
		</div>
	</div>
	</div>
	 <?php endforeach;?>
    </body>
</html>