<?php
// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require_once 'public/apis/Twilio/autoload.php'; 
 
use Twilio\Rest\Client; 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
      
    }
 
    function send_test_email($email, $subject, $message)
    {
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('avisos@atenun.com', 'Notificaciones  sistema Atenun');
        $mail->Subject =  $subject;
        $data_email = array(
            'email_msg' =>  $message,
        );
        $mail->Body = $this->load->view('backend/mails/template.php',$data_email,TRUE);
        $mail->AddAddress($email);
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }else
        {
            echo "Mailer: " . $mail;
        }

    }


    function send_email($email, $subject, $message,$attachment = '')
    {
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
        $mail->Subject =  $subject;
        $data_email = array(
            'email_msg' =>  $message,
        );
        $mail->Body = $this->load->view('backend/mails/template.php',$data_email,TRUE);

        if($attachment != '')
        {
            $mail->AddAttachment($attachment);
        }
        
        $mail->AddAddress($email);
        if(!$mail->Send()) {
            return 0;
        }else
        {
            return 1;
        }

    }


    
 

    function sendEmail()
{

    log_message('error','Enviando correo');


    require("public/apis/class.phpmailer.php");
    $mail = new PHPMailer(); 
    $mail->IsHTML(true);
    $mail->IsMail();
    $mail->CharSet = 'UTF-8';
    $mail->SetFrom('avisos@atenun.com', 'Notificaciones  sistema Atenun');
    $mail->Subject = "Notificaciones Atenun";
    $data_email = array(
        'email_msg' => $this->input->post('message'),
    );
    $mail->Body = $this->load->view('backend/mails/template.php',$data_email,TRUE);

      
        include('public/apis/class.fileuploader.php');
        $FileUploader_reference_file = new FileUploader('archivo', array('uploadDir' => 'public/uploads/emails/'));
        $upload_reference_file = $FileUploader_reference_file->upload();
        if($upload_reference_file['isSuccess']) {

             // Adjuntar archivo
             if($upload_reference_file['files'][0]['name'] != '')
            $mail->addAttachment('public/uploads/emails/'.$upload_reference_file['files'][0]['name']);
        } 

        if($this->input->post('user_type') == "0")
        {
            log_message('error','Correo para pacientes ');

            if($this->input->post('patient_id') != "0")
            {
                log_message('error','Correo para pacientes especifico ');
        
                $this->db->where('patient_id', $this->input->post('patient_id'));
                $patients = $this->db->get('patient')->result_array();  

                foreach ($patients as $row)
                {

                    if($this->esDireccionCorreoValida($row['email']))
                    {
                        $mail->AddAddress($row['email']);
                        if(!$mail->Send()) {
                            echo "Mailer Error: " . $mail->ErrorInfo;
                        }
                    }
                    
                }

            }else
            {

                    if($this->input->post('insurance_id')==0)
                    {
                        log_message('error','todos los seguro ');
                    
                        $this->db->order_by('first_name', 'ASC');
                        $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                        $this->db->where('status !=', 0);
                        $patients = $this->db->get('patient')->result_array();  
                    
                        foreach ($patients as $row)
                        {
                            if($this->esDireccionCorreoValida($row['email']))
                            {
                                $mail->clearAddresses(); // Limpiar direcciones anteriores
                            
                                $mail->AddAddress($row['email']);
                                if(!$mail->Send()) {
                                    echo "Mailer Error: " . $mail->ErrorInfo;
                                }
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
                            if($this->esDireccionCorreoValida($row['email']))
                            {
                                $mail->clearAddresses(); // Limpiar direcciones anteriores
                            
                                $mail->AddAddress($row['email']);
                                if(!$mail->Send()) {
                                    echo "Mailer Error: " . $mail->ErrorInfo;
                                }
                            }

                        }

                    }

                }
            }
        else
        {
            log_message('error','Correo para Usuarios ');
            
            ///////// email para usuarios
            if($this->input->post('staff_id') == "0")
            {
                log_message('error','todos usuarios '.$this->input->post('category_id'));
            

                if($this->input->post('category_id') == "0")
                {
                    $staff = $this->db->query('SELECT * FROM staff WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'"')->result_array();
                    $admins = $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'"')->result_array();
                    foreach ($staff as $row)
                    {
                        if($this->esDireccionCorreoValida($row['email']))
                        {
                            $mail->clearAddresses(); // Limpiar direcciones anteriores
                        
                            $mail->AddAddress($row['email']);
                            if(!$mail->Send()) {
                                echo "Mailer Error: " . $mail->ErrorInfo;
                            }
                        }
                        
                    }

                    foreach ($admins as $row)
                    {

                        if($this->esDireccionCorreoValida($row['email']))
                        {
                            $mail->clearAddresses(); // Limpiar direcciones anteriores
                        
                            $mail->AddAddress($row['email']);
                            if(!$mail->Send()) {
                                echo "Mailer Error: " . $mail->ErrorInfo;
                            }
                        }

                    }
        
                }else
                {
                    if($this->input->post('category_id') == 'admin')
                    {
                        $users = $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'" and owner = 1')->result_array();
                    } else if($this->input->post('category_id') == 'docs')
                    {
                        $users = $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'" and owner = 0')->result_array();
                    }else
                    {
                        $users = $this->db->query('SELECT * FROM staff WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'" and category ='.$this->input->post('category_id'))->result_array();
                    }
                    

                    foreach ($users as $row)
                    {
                        log_message('error','categoria de staff '.$_FILES['archivo']['name']);
                        
                        if($this->esDireccionCorreoValida($row['email']))
                        {
                            $mail->clearAddresses(); // Limpiar direcciones anteriores
                        
                            $mail->AddAddress($row['email']);
                            if(!$mail->Send()) {
                                echo "Mailer Error: " . $mail->ErrorInfo;
                            }
                        }

                    }
                }//

            }else
            {
                log_message('error','Usuario especifico '.$this->input->post('staff_id'));
                $user = explode('_',$this->input->post('staff_id'));
                $this->db->where($user[0].'_id', $user[1]);
                $users = $this->db->get($user[0])->result_array();  
            
                foreach ($users as $row)
                {

                    if($this->esDireccionCorreoValida($row['email']))
                    {
                        $mail->clearAddresses(); // Limpiar direcciones anteriores
                    
                        $mail->AddAddress($row['email']);
                        if(!$mail->Send()) {
                            echo "Mailer Error: " . $mail->ErrorInfo;
                        }
                    }
                }
              
            }
        }

        unlink('public/uploads/emails/'.$upload_reference_file['files'][0]['name']);
    }

    function esDireccionCorreoValida($correo) {
        return filter_var($correo, FILTER_VALIDATE_EMAIL);
    }
    
}