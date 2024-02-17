<?php
// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require_once 'public/apis/Twilio/autoload.php'; 
 
use Twilio\Rest\Client; 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Whatsapp extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
 

function sendWhatsapp()
{
    $md5 = md5(date('d-m-Y H:i:s'));
    include('public/apis/class.fileuploader.php');
    
    $FileUploader_reference_file = new FileUploader('archivo', array('uploadDir' => 'public/uploads/whatsapps/'));
    $upload_reference_file = $FileUploader_reference_file->upload();
    if($upload_reference_file['isSuccess']) {
        $files = $upload_reference_file['files'];
        $file =   $upload_reference_file['files'][0]['name'];
    } else {
        $warningss = $upload_reference_file['warnings'];
    }

    log_message('error','archivo '.json_encode($files));            
        
    if($this->input->post('user_type') == '0')
    {

        if($this->input->post('patient_id') != "0")
        {
       
            $this->db->where('patient_id', $this->input->post('patient_id'));
            $patients = $this->db->get('patient')->result_array();  

            foreach ($patients as $row)
            {
                if($row['phone'] != '')
                {
                    $message = $this->input->post('message');
                    $data = array(
                        'phone' => $row['area_code'].$row['phone'],
                        'message' => $message,
                        'file' => $file,
                        'response' => json_encode(''),
                        'status' =>0,
                        'user_type' => 'patient',
                        'user_id' => $row['patient_id']
                        );
                    
                    $this->db->insert('whatsapp_messages',$data);
                }
            }

        }else
        {

            if($this->input->post('insurance_id')=="0")
            {
                log_message('error','todos seguro '.$_FILES['archivo']['name']);
            
              
                $this->db->order_by('first_name', 'ASC');
                $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                $this->db->where('status !=', 0);
                $patients = $this->db->get('patient')->result_array();  


                foreach ($patients as $row)
                {
                    if($row['phone'] != '')
                    {
                        $message = $this->input->post('message');
                        $data = array(
                            'phone' => $row['area_code'].$row['phone'],
                            'message' => $message,
                            'file' => $file,
                            'response' => json_encode(''),
                            'status' =>0,
                            'user_type' => 'patient',
                            'user_id' => $row['patient_id']
                            );
                        
                        $this->db->insert('whatsapp_messages',$data);
                    }

                }
    
            }else
            {
    
                log_message('error','seguro ');
            
                $this->db->select("*");  
                $this->db->from('insurance_patients ip');
                $this->db->join('patient p', 'ip.patient_id = p.patient_id');
                $this->db->where('ip.insurance_id', $this->input->post('insurance_id'));
                $this->db->where('p.status', 1);
                $patients = $this->db->get()->result_array();  
                
                foreach ($patients as $row)
                {
                    if($row['phone'] != '')
                     {
                        $message = $this->input->post('message');
                        $data = array(
                            'phone' => $row['area_code'].$row['phone'],
                            'message' => $message,
                            'file' => $file,
                            'response' => json_encode(''),
                            'status' => 0,
                            'user_type' => 'patient',
                            'user_id' => $row['patient_id']
                            );
                        
                        $this->db->insert('whatsapp_messages',$data);
                     }

                }

            }

            }
        }
    else
    {
        ///////// whatsapp para usuarios
        if($this->input->post('staff_id') != "0")
        {
            log_message('error','whatsapp usuario especifico '.$_FILES['archivo']['name']);
        
            $user = explode('_',$this->input->post('staff_id'));

            $this->db->where($user[0].'_id', $user[1]);
            $users = $this->db->get($user[0])->result_array();  
          
            foreach ($users as $row)
            {
              if($row['phone'] != '')
                {
                    $message = $this->input->post('message');
                    $data = array(
                        'phone' => '502'.$row['phone'],
                        'message' => $message,
                        'file' => $file,
                        'response' => json_encode(''),
                        'status' => 0,
                        'user_type' => $user[0],
                        'user_id' => $user[1]
                        );
                    
                    $this->db->insert('whatsapp_messages',$data);
                }
            }

        }else
        {


            if($this->input->post('category_id')=="0")
            {
               
                log_message('error','whatsapp todos los usuarios ');
                
                $staff = $this->db->query('SELECT * FROM staff WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'"')->result_array();
                $admins = $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'"')->result_array();


                foreach ($staff as $row)
                {
                    if($row['phone'] != '')
                    {
                        $message = $this->input->post('message');
                        $data = array(
                            'phone' => '502'.$row['phone'],
                            'message' => $message,
                            'file' => $file,
                            'response' => json_encode(''),
                            'status' => 0,
                            'user_type' => 'staff',
                            'user_id' => $row['staff_id']
                            );
                        
                        $this->db->insert('whatsapp_messages',$data);
                    }

                }

                foreach ($admins as $row)
                {

                    if($row['phone'] != '')
                    {
                        
                        $message = $this->input->post('message');
                        $data = array(
                            'phone' => '502'.$row['phone'],
                            'message' => $message,
                            'file' => $file,
                            'response' => json_encode(''),
                            'status' => 0,
                            'user_type' => 'admin',
                            'user_id' => $row['admin_id']
                            );
                        
                        $this->db->insert('whatsapp_messages',$data);
                    }

                }
    
            }else
            {
                log_message('error','whatsapp  categoria especifica ');
                   

                if($this->input->post('category_id') == 'admin')
                {
                    $admin = $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'" and owner = 1')->result_array();
                } else if($this->input->post('category_id') == 'docs')
                {
                    $admin = $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'" and owner = 0')->result_array();
                }else
                {
                    $staff = $this->db->query('SELECT * FROM staff WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'" and category ='.$this->input->post('category_id'))->result_array();
                }
                
                
                foreach ($staff as $row)
                {
                   
                    if($row['phone'] != '')
                    {                  
                        $message = $this->input->post('message');
                        $data = array(
                            'phone' => '502'.$row['phone'],
                            'message' => $message,
                            'file' => $file,
                            'response' => json_encode(''),
                            'status' => 0,
                            'user_type' => 'staff',
                            'user_id' => $row['staff_id']
                            );
                        
                        $this->db->insert('whatsapp_messages',$data);
                    }

                }

                foreach ($admin as $row)
                {

                    if($row['phone'] != '')
                    {
                        
                        $message = $this->input->post('message');
                        $data = array(
                            'phone' => '502'.$row['phone'],
                            'message' => $message,
                            'file' => $file,
                            'response' => json_encode(''),
                            'status' => 0,
                            'user_type' => 'admin',
                            'user_id' => $row['admin_id']
                            );
                        
                        $this->db->insert('whatsapp_messages',$data);
                    }

                }

            }

        }
    }
}





function sendAllWhatsapp()
{
   
    $this->db->limit(10);
    $whatsapps =$this->db->get_where('whatsapp_messages',array('status' => 0))->result_array();
    log_message('error','Enviando mensajes a '.count($whatsapps));
    
    foreach ($whatsapps as $row) {
        # code...
       $phone = str_replace('-','',$row['phone']);
        
        if($row['file'] != '')
        {
            
            $this->curl_whatsapp_file($phone,$row['message'],'public/uploads/whatsapps/'.$row['file'],$row['id']);

        }else{
            $this->curl_whatsapp($row['phone'],$row['message'],$row['id']);
        }
    }

}

function curl_whatsapp($phone,$chat,$id)
{
    $key = $this->db->get_where('settings', array('type' => 'msalerts_key'))->row()->description;
    $token = $this->db->get_where('settings', array('type' => 'msalerts_token'))->row()->description;

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://chats.mayansource.com/sendMessage',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'api_key='.$key.'&messageType=1&token='.$token.'&phone='.$phone.'&chat='.urlencode($chat),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    
    $data = array(
        'status' => $data['status']
        );
    $this->db->where('id',$id);
    $this->db->update('whatsapp_messages',$data);
    return $response;
}


function curl_whatsapp_file($phone,$chat,$file,$id)
{ 
    $path = $file;

    if (file_exists($file)) {

        log_message('error',$phone.' '.$chat.' '.$file);


        // Obtener el tipo de contenido usando mime_content_type
        $tipoContenido = mime_content_type($file);
    
        // Verificar si el tipo de contenido es válido
        if ($tipoContenido !== false) {
          
           
            $key = $this->db->get_where('settings', array('type' => 'msalerts_key'))->row()->description;
            $token = $this->db->get_where('settings', array('type' => 'msalerts_token'))->row()->description;
            
         
            log_message('error',$tipoContenido);

            $files = new CurlFile($file,$tipoContenido);
            
            //Enviamos el archivo.
            $curl1 = curl_init();
            curl_setopt_array($curl1, array(
                CURLOPT_URL => 'http://chats.mayansource.com/sendMessage',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('api_key' => $key, 'messageType' => 2, 'token' => $token, 'phone'=> $phone, 'file_caption' => $chat, 'media_file' => $files),
            ));
            $response = curl_exec($curl1);
            curl_close($curl1);
            $data = json_decode($response, true);
            
            $data = array(
                'status' => $data['status'],
                'response' => $response
                );
            $this->db->where('id',$id);
            $this->db->update('whatsapp_messages',$data);

            log_message('error',$response) ;
        } else {
            log_message('error',"No se pudo determinar el tipo de contenido.");
        }
    } else {
        log_message('error',"El archivo no existe.");
    }

    
}


function whatsapp_notification( $type, $appointment_id = '')
{


    $key = $this->db->get_where('settings', array('type' => 'msalerts_key'))->row()->description;
    $token = $this->db->get_where('settings', array('type' => 'msalerts_token'))->row()->description;

    $chat = $this->db->get_where('whatsapp_notification',array('type'=> $type))->row()->message;
    log_message('error',$appointment_id);
    if($appointment_id != '')
    {
       
        $app = $this->db->get_where('appointment',array('appointment_id'=>$appointment_id))->row_array();
        log_message('error','Patient id '.$app['patient_id']);
        $patient = $this->accounts_model->get_name('patient',$app['patient_id']);
        $patient_info = $this->db->get_where('patient',array('patient_id'=>$app['patient_id']))->row_array();
        $phone = $patient_info['area_code'].$patient_info['phone'];
        setlocale(LC_TIME, "spanish");
        $fecha = str_replace("/", "-", $app['date']); 

        $phone = str_replace(array("/","-"," "), array("","",""), $phone);

        $clinic = $this->db->get_where('clinic',array('clinic_id'=>$app['clinic_id']))->row_array();
        $email = $this->crud_model->getInfo('email');

        $chat = str_replace('[PACIENTE]',$patient, $chat);
        $chat = str_replace('[FECHA]',strftime("%d de %B del %Y",  strtotime($fecha)), $chat);
        $chat = str_replace('[HORA]',$app['time'], $chat);
        $chat = str_replace('[CLINICA_NUMERO]',$clinic['phone'], $chat);
        $chat = str_replace('[CLINICA_CORREO]',$clinic['email'], $chat);
    }

    if($patient_info['phone'] != '')
    {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://chats.mayansource.com/sendMessage',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'api_key='.$key.'&messageType=1&token='.$token.'&phone='.$phone.'&chat='.urlencode($chat),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response, true);
            
    
            $data = array(
                'phone' =>$phone,
                'message' =>$chat,
                'file' =>'',
                'response' => $response,
                'status' => $data['status'],
                'user_type' => 'patient',
                'user_id' => $app['patient_id']
                );
            
            $this->db->insert('whatsapp_messages',$data);
            
            if($data['status'] == 500 )
            {
                require("public/apis/class.phpmailer.php");
                $mail = new PHPMailer(); 
                $mail->IsHTML(true);
                $mail->IsMail();
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
                $mail->Subject = "Error al enviar notificaciones Atenun";
                $data_email = array(
                    'email_msg' => "Error al enviar notificacion ".$phone." desde Atenun response:".$response,
                );
                $mail->Body = $this->load->view('backend/mails/template.php',$data_email,TRUE);
                $mail->AddAddress('angcorado4@gmail.com');
                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }
            }
            return $response;
    }

    
}



    function whatsapp_test( $type, $appointment_id = '')
    {
    
    
        $key = $this->db->get_where('settings', array('type' => 'msalerts_key'))->row()->description;
        $token = $this->db->get_where('settings', array('type' => 'msalerts_token'))->row()->description;
    
        $chat = $this->db->get_where('whatsapp_notification',array('type'=> $type))->row()->message;
        log_message('error',$appointment_id);
        if($appointment_id != '')
        {
           
            $app = $this->db->get_where('appointment',array('appointment_id'=>$appointment_id))->row_array();
            log_message('error','Patient id 22'.$app['patient_id']);
            $patient = $this->accounts_model->get_name('patient',22);
            $patient_info = $this->db->get_where('patient',array('patient_id'=>$app['patient_id']))->row_array();
            $phone = $patient_info['area_code'].$patient_info['phone'];
            
           
            
            
            $phone = str_replace(array("/","-"," "), array("","",""), $phone);
            
            
            setlocale(LC_TIME, "spanish");
            $fecha = str_replace("/", "-", $app['date']); 
    
            $clinic = $this->db->get_where('clinic',array('clinic_id'=>$app['clinic_id']))->row_array();
            $email = $this->crud_model->getInfo('email');
    
            $chat = str_replace('[PACIENTE]',$patient, $chat);
            $chat = str_replace('[FECHA]',strftime("%d de %B del %Y",  strtotime($fecha)), $chat);
            $chat = str_replace('[HORA]',$app['time'], $chat);
            $chat = str_replace('[CLINICA_NUMERO]',$clinic['phone'], $chat);
            $chat = str_replace('[CLINICA_CORREO]',$clinic['email'], $chat);
        }
    
        if($phone != '')
        {
    
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://chats.mayansource.com/sendMessage',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'api_key='.$key.'&messageType=1&token='.$token.'&phone='.$phone.'&chat='.urlencode($chat),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response, true);
            
            $data = array(
                'phone' =>$phone,
                'message' =>$chat,
                'file' =>'',
                'response' => $response,
                'status' => $data['status'],
                'user_type' => 'patient',
                'user_id' => $app['patient_id']
                );
            
            $this->db->insert('whatsapp_messages',$data);
                
            if($data['status'] == 500 )
            {
                log_message('error','Correo error notificaciones');
                require("public/apis/class.phpmailer.php");
                $mail = new PHPMailer(); 
                $mail->IsHTML(true);
                $mail->IsMail();
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
                $mail->Subject = "Error al enviar notificaciones Atenun";
                $data_email = array(
                    'email_msg' => "Error al enviar notificacion ".$phone." desde Atenun response:".$response,
                );
                $mail->Body = $this->load->view('backend/mails/template.php',$data_email,TRUE);
                $mail->AddAddress('angcorado4@gmail.com');
                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }
            }
            return $response;
        }
    
        
    }
 
 
 
 
    
}