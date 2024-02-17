<!DOCTYPE html>
<html>
    <body style="background-color: #222533; padding: 20px; font-family: font-size: 14px; line-height: 1.43; font-family: &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;">
        <div style="max-width: 600px; margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">
            <table style="width: 100%;">
                <tr>
                    <td style="background-color: #fff;"> 
                        <img alt="medicaby" src="https://medicaby.com/resources/app-logo/logo-x.png" style="width:50%; padding: 20px">
                    </td>
                    <td style="padding-left: 50px; text-align: right; padding-right: 20px;">
                        <a href="#" style="color: #261D1D; text-decoration: underline; font-size: 14px; letter-spacing: 1px;">Cambio de contraseña</a>
                    </td>
                </tr>
            </table>
            <div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
                <h1 style="margin-top: 0px;">Hola <?php echo $user;?>,</h1>
                <div style="color: #636363; font-size: 14px;">
                    <p>Hemos recibido una solicitud para cambiar tu contraseña el <b><?php echo date('d');?> de <?php echo date('M');?> a las <?php echo date('H:i A');?></b>, para continuar y cambiar tu contraseña haz click en el botón de abajo, el enlace expira en 30 minutos.</p>
                    <p>Si no has sido tú, ignora este mensaje, mantendremos segura tu cuenta.</p>
                </div>
                <a href="<?php echo base_url();?>password/new_request?auth=<?php echo $key;?>" style="padding: 8px 20px;     background: #5955a0!important; border-radius: 5px; color: #fff; font-weight: bolder; font-size: 16px; display: inline-block; margin: 20px 0px; margin-right: 20px; text-decoration: none; -webkit-box-shadow: 0px 2px 14px rgba(0, 68, 233, 0.40); box-shadow: 0px 2px 14px rgba(0, 68, 233, 0.40);">Recuperar contraseña</a>
                <h4 style="margin-bottom: 10px;">¿Necesitas ayuda?</h4>
                <div style="color: #A5A5A5; font-size: 12px;">
                    <p>Si tienes alguna pregunta o duda con respecto a este correo electrónico. Por favor escríbenos a <a href="mailto:soporte@medicaby.com" style="text-decoration: underline; color: #4B72FA;">soporte@medicaby.com</a></p>
                </div>
            </div>
            <div style="background-color: #F5F5F5; padding: 40px; text-align: center;">
                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.05);">
                    <div style="color: #A5A5A5; font-size: 10px; margin-bottom: 5px;">
                    <?php echo $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->address;?>
                    </div>
                    <div style="color: #A5A5A5; font-size: 10px;">
                        <?php $sys_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>
                        Copyright <?php echo date('Y').'  -  '.$sys_name;?>. Todos los derechos reservados.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>