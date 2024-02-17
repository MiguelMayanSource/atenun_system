<?php 
    if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Password extends CI_Controller 
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    public function index() 
    {
        $this->load->view('backend/password');
    }
    
    public function new_request() 
    {
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET); 
        $page_data['page_name']   = 'new_password';
        $page_data['token']  = $_GET['auth'];
        $this->load->view('backend/new_password');
    }
    
    function apply()
    {
        if($this->input->post('password') != '')
        {
            $token = base64_decode($this->input->post('src_key'));
		    $new_token = base64_decode($token);
		    if (strpos($new_token, '*') !== false) 
		    {
		        $admin_id = $this->db->get_where('admin', array('auth_key' => $token))->row()->admin_id;
                $data['expire'] = '';
                $data['password'] = sha1($this->input->post('password'));
                $this->db->where('admin_id', $admin_id);
                $this->db->update('admin', $data);
                $this->session->set_flashdata('success_pass', '1');
                redirect(base_url(), 'refresh');
            }elseif (strpos($new_token, '#') !== false) 
            {
                $staff_id = $this->db->get_where('staff', array('auth_key' => $token))->row()->staff_id;
                $data['expire'] = '';
                $data['password'] = sha1($this->input->post('password'));
                $this->db->where('staff_id', $staff_id);
                $this->db->update('staff', $data);
                $this->session->set_flashdata('success_pass', '1');
                redirect(base_url(), 'refresh');
            }
            elseif (strpos($new_token, '&') !== false) 
            {
                $patient_id = $this->db->get_where('patient', array('auth_key' => $token))->row()->patient_id;
                $data['expire'] = '';
                $data['password'] = sha1($this->input->post('password'));
                $this->db->where('patient_id', $patient_id);
                $this->db->update('patient', $data);
                $this->session->set_flashdata('success_pass', '1');
                redirect(base_url(), 'refresh');
            }
            else{
                $this->session->set_flashdata('error', '1');
                redirect(base_url().'password/recovery', 'refresh');
            }
        }
    }
    
    function request()
    {
        if($this->input->post('username') != '')
        {
            $query1 = $this->db->get_where('admin', array('username' => $this->input->post('username')));
            $query2 = $this->db->get_where('staff', array('username' => $this->input->post('username')));
            $query3 = $this->db->get_where('patient', array('username' => $this->input->post('username')));
            $current_date = date('Y-m-d H:i:s'); 
            $new_date = strtotime ('+30 minute' , strtotime ($current_date)) ; 
            $new_date = date ( 'Y-m-d H:i:s' , $new_date); 
            
            if($query1->num_rows() > 0)
            {
                $info['expire'] = $new_date;
                $info['auth_key'] = base64_encode($query1->row()->admin_id.'*'.sha1(date('d-m-y H:i:s')));
                $this->send_password($query1->row()->email,$info['auth_key'],$query1->row()->first_name, $query1->row()->clinic_id);
                $this->db->where('admin_id',$query1->row()->admin_id);
                $this->db->update('admin', $info);
                $this->session->set_flashdata('success', '1');
                redirect(base_url().'password/recovery', 'refresh');
            }
            elseif($query2->num_rows() > 0)
            {
                $info['expire'] = $new_date;
                $info['auth_key'] = base64_encode($query2->row()->staff_id.'#'.sha1(date('d-m-y H:i:s')));
                $this->send_password($query2->row()->email,$info['auth_key'],$query2->row()->first_name, $query2->row()->clinic_id);
                $this->db->where('staff_id',$query2->row()->staff_id);
                $this->db->update('staff', $info);
                $this->session->set_flashdata('success', '1');
                redirect(base_url().'password/recovery', 'refresh');
            }
            elseif($query3->num_rows() > 0)
            {
                $info['expire']   = $new_date;
                $info['auth_key'] = base64_encode($query3->row()->patient_id.'&'.sha1(date('d-m-y H:i:s')));
                $this->send_password($query3->row()->email,$info['auth_key'],$query3->row()->first_name, $query3->row()->clinic_id);
                $this->db->where('patient_id',$query3->row()->patient_id);
                $this->db->update('patient', $info);
                $this->session->set_flashdata('success', '1');
                redirect(base_url().'password/recovery', 'refresh');
            }
            else{
                $this->session->set_flashdata('error', '1');
                redirect(base_url().'password/recovery', 'refresh');
            }
        }
    }
    
    function send_password($email,$key, $user, $clinic)
    {
        $uss = str_replace(' ', '',$user);
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('notificaciones@medicaby.com', 'Notificaciones Medicaby');
        $mail->Subject = '=?UTF-8?B?' . base64_encode("Recuperación de cuenta") . '?=';
        $data = array(
            'key' => base64_encode($key),
            'user' => $uss,
            'clinic_id' => $clinic
        );
        $mail->Body = $this->load->view('backend/mails/password.php',$data,TRUE);
        $mail->AddAddress($email);
        if($email != ''){
            if(!$mail->Send()) {
                log_message("error", "Mailer Error: " . $mail->ErrorInfo);
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                log_message("error", "Correo enviado: $email");
            }    
        }
    }
    
    function recovery($param1 = '', $param2 = '') 
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $credential = array('username' => $username, 'password' => sha1($password));
        $query = $this->db->get_where('admin', $credential);
        if ($query->num_rows() > 0) 
        {
            $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
            $row = $query->row();
            $this->session->set_userdata('doctor_login', '1');
            $this->session->set_userdata('current_clinic', $current_clinic);
            $this->session->set_userdata('doctor_id', $row->admin_id);
            $this->session->set_userdata('login_user_id', $row->admin_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('tipo', $row->tipo);
            $this->session->set_userdata('login_type', 'doctor');
            redirect(base_url() . 'doctor/panel/', 'refresh');
        }
        
        
        $credential = array('username' => $username, 'password' => sha1($password));
        $query = $this->db->get_where('staff', $credential);
        if ($query->num_rows() > 0) 
        {
            $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
            $row = $query->row();
            $this->session->set_userdata('staff_login', '1');
            $this->session->set_userdata('current_clinic', $current_clinic);
            $this->session->set_userdata('staff_id', $row->staff_id);
            $this->session->set_userdata('login_user_id', $row->staff_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('tipo', $row->tipo);
            $this->session->set_userdata('login_type', 'staff');
            redirect(base_url() . 'staff/panel/', 'refresh');
        }
        //$this->session->set_flashdata('error', '1');
        //redirect(base_url(), 'refresh');
        $this->load->view('backend/password');
    }
}