<?php 
    if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller 
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
        if ($this->session->userdata('doctor_login') == 1)
        {
            redirect(base_url() . 'doctor/panel/', 'refresh');
        }
        if ($this->session->userdata('staff_login') == 1)
        {
            redirect(base_url() . 'staff/appointments/', 'refresh');
        }
        if ($this->session->userdata('patient_login') == 1)
        {
            redirect(base_url() . 'patient/dashboard/'.base64_encode($this->session->userdata('login_user_id')), 'refresh');
        }

        

        $this->load->view('backend/login');
    }
    
//login con google
    function google()
    {
        $redirect = 'error';
        $username = $this->input->post('gm_id');;
        $password = $this->input->post('name');;
        $credential = array('gm_id' => $username, 'g_fname' => $password);


        $query = $this->db->get_where('admin', $credential);
        
        if ($query->num_rows() > 0) 
        {
            $row = $query->row();

            if($row->auth_secret != '')
            {
                $redirect = 'login/two_factor/'.base64_encode($row->admin_id).'/admin'; 
            }else{
                $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
                $this->session->set_userdata('doctor_login', '1');
                $this->session->set_userdata('current_clinic', $current_clinic);
                $this->session->set_userdata('doctor_id', $row->admin_id);
                $this->session->set_userdata('login_user_id', $row->admin_id);
                $this->session->set_userdata('name', $row->first_name);
                $this->session->set_userdata('tipo', $row->type);
                $this->session->set_userdata('login_type', 'doctor');
                
                $user_os        = $this->getOS();
                $user_browser   = $this->getBrowser();
                $PublicIP = $this->get_client_ip();
                $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                $json     = json_decode($json, true);
                $city     = $json['city'];
                
                $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
                if($row->last_info == ""){
                    $datas['last_info'] = $insert_info;
                }
                $datas['current_info'] = $insert_info;
                $this->db->where('admin_id', $row->admin_id);
                $this->db->update('admin', $datas);
                $datalog['current_info'] = $insert_info;
                $datalog['user_id'] = $row->admin_id;
                $datalog['clinic_id'] = $current_clinic;
                $this->db->insert('log_session', $datalog);
                $redirect = 'doctor/panel';
            }
            
        }
        
        
        
        $query = $this->db->get_where('staff', $credential);
        
        if ($query->num_rows() > 0) 
        {
            $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
            $row = $query->row();

            if($row->auth_secret != ''){
                $redirect = 'login/two_factor/'.base64_encode($row->staff_id).'/staff';
            }else{

            $this->db->order_by('first_name', 'ASC');
            $this->db->where('clinic_id',$current_clinic);
            $query = $this->db->get('admin')->first_row()->admin_id;
            $this->session->set_userdata('doctor_id', $queryss);
    


            $this->session->set_userdata('staff_login', '1');
            $this->session->set_userdata('current_clinic', $current_clinic);
            $this->session->set_userdata('staff_id', $row->staff_id);
            $this->session->set_userdata('login_user_id', $row->staff_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('tipo', $row->tipo);
            $this->session->set_userdata('login_type', 'staff');
            
            $user_os        = $this->getOS();
            $user_browser   = $this->getBrowser();
            $PublicIP = $this->get_client_ip();
            $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
            $json     = json_decode($json, true);
            $city     = $json['city'];
            
            $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
            
            
            $datalog['current_info'] = $insert_info;
            $datalog['user_id'] = $row->staff_id;
            $datalog['clinic_id'] = $current_clinic;
           
            $this->db->insert('log_session', $datalog);
            
            
            
            $redirect = 'staff/appointments';
            }
        }
        
        
        $query = $this->db->get_where('patient', $credential);
        
        if ($query->num_rows() > 0) 
        {

            

            $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
            $row = $query->row();
            if($row->auth_secret != ''){
                $redirect = 'login/two_factor/'.base64_encode($row->patient_id).'/patient'; 
            }else{

            
            $this->session->set_userdata('patient_login', '1');
            $this->session->set_userdata('current_clinic', $current_clinic);
            $this->session->set_userdata('patient_id', $row->patient_id);
            $this->session->set_userdata('login_user_id', $row->patient_id);
            $this->session->set_userdata('name', $row->name);
            $this->session->set_userdata('login_type', 'patient');
            
            $user_os        = $this->getOS();
            $user_browser   = $this->getBrowser();
            $PublicIP = $this->get_client_ip();
            $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
            $json     = json_decode($json, true);
            $city     = $json['city'];
            
            $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
            
            
            $datalog['current_info'] = $insert_info;
            $datalog['user_id'] = $row->patient_id;
            $datalog['clinic_id'] = $current_clinic;
           
            $this->db->insert('log_session', $datalog);
            
            $redirect = 'patient/dashboard/'.base64_encode($row->patient_id);
            }
        }
        
        echo $redirect;
        
        //$this->session->set_flashdata('error', '1');
        
    }
    
    //login con facebook
        function facebook()
    {
        //Recibimos el token desde la vista
             $redirect = 'error';
             $credential = array('fb_id' => $this->input->post('id_token'));
     
     
             $query = $this->db->get_where('admin', $credential);
             
             if ($query->num_rows() > 0) 
             {
                 $row = $query->row();
                 if($row->auth_secret != ''){
                    $redirect = base_url() . 'login/two_factor/'.base64_encode($row->admin_id).'/admin'; 
                 }else{
                     $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
                     $this->session->set_userdata('doctor_login', '1');
                     $this->session->set_userdata('current_clinic', $current_clinic);
                     $this->session->set_userdata('doctor_id', $row->admin_id);
                     $this->session->set_userdata('login_user_id', $row->admin_id);
                     $this->session->set_userdata('name', $row->first_name);
                     $this->session->set_userdata('tipo', $row->type);
                     $this->session->set_userdata('login_type', 'doctor');
                     
                     $user_os        = $this->getOS();
                     $user_browser   = $this->getBrowser();
                     $PublicIP = $this->get_client_ip();
                     $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                     $json     = json_decode($json, true);
                     $city     = $json['city'];
                     
                     $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
                     if($row->last_info == ""){
                         $datas['last_info'] = $insert_info;
                     }
                     $datas['current_info'] = $insert_info;
                     $this->db->where('admin_id', $row->admin_id);
                     $this->db->update('admin', $datas);
                     $datalog['current_info'] = $insert_info;
                     $datalog['user_id'] = $row->admin_id;
                     $datalog['clinic_id'] = $current_clinic;
                     $this->db->insert('log_session', $datalog);
                     $redirect = 'doctor/panel';
                 }
                 
             }
             
             
             
             $query = $this->db->get_where('staff', $credential);
             
             if ($query->num_rows() > 0) 
             {
                 $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
                 $row = $query->row();

                 if($row->auth_secret != ''){
                    $redirect = base_url() . 'login/two_factor/'.base64_encode($row->staff_id).'/staff';
                }else{

                
                $this->db->order_by('first_name', 'ASC');
                $this->db->where('clinic_id',$current_clinic);
                $query = $this->db->get('admin')->first_row()->admin_id;
                $this->session->set_userdata('doctor_id', $queryss);

                 $this->session->set_userdata('staff_login', '1');
                 $this->session->set_userdata('current_clinic', $current_clinic);
                 $this->session->set_userdata('staff_id', $row->staff_id);
                 $this->session->set_userdata('login_user_id', $row->staff_id);
                 $this->session->set_userdata('name', $row->name);
                 $this->session->set_userdata('tipo', $row->tipo);
                 $this->session->set_userdata('login_type', 'staff');
                 
                 $user_os        = $this->getOS();
                 $user_browser   = $this->getBrowser();
                 $PublicIP = $this->get_client_ip();
                 $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                 $json     = json_decode($json, true);
                 $city     = $json['city'];
                 
                 $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
                 
                 
                 $datalog['current_info'] = $insert_info;
                 $datalog['user_id'] = $row->staff_id;
                 $datalog['clinic_id'] = $current_clinic;
                
                 $this->db->insert('log_session', $datalog);
                 
                 
                 
                 $redirect = 'staff/appointments';
                }
             }
             
             
                     
             
             $query = $this->db->get_where('patient', $credential);
             
             if ($query->num_rows() > 0) 
             {
                 $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
                 $row = $query->row();

                 if($row->auth_secret != ''){
                    $redirect = 'login/two_factor/'.base64_encode($row->patient_id).'/patient'; 
                }else{
                 $this->session->set_userdata('patient_login', '1');
                 $this->session->set_userdata('current_clinic', $current_clinic);
                 $this->session->set_userdata('patient_id', $row->patient_id);
                 $this->session->set_userdata('login_user_id', $row->patient_id);
                 $this->session->set_userdata('name', $row->name);
                 $this->session->set_userdata('login_type', 'patient');
                 
                 $user_os        = $this->getOS();
                 $user_browser   = $this->getBrowser();
                 $PublicIP = $this->get_client_ip();
                 $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                 $json     = json_decode($json, true);
                 $city     = $json['city'];
                 
                 $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
                 
                 
                 $datalog['current_info'] = $insert_info;
                 $datalog['user_id'] = $row->patient_id;
                 $datalog['clinic_id'] = $current_clinic;
                
                 $this->db->insert('log_session', $datalog);
                 
                 $redirect = 'patient/dashboard/'.base64_encode($row->patient_id);
                }
             }
             
             echo $redirect;
             
             $this->session->set_flashdata('error', '1');
                    
    } 
             
        
    function error()
    {
        $this->session->set_flashdata('errorgm', '1');
        redirect(base_url().'login/', 'refresh');
    }


    function getBrowser() 
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser        = "Unknown Browser";
        $browser_array = array(
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        );
        foreach ($browser_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $browser = $value;
                return $browser;
    }
    
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }
    
    function getOS() 
    { 
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform  = "Unknown OS Platform";
        $os_array     = array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );
        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;
            return $os_platform;
    }
    
    function validate(){
        $val = $this->input->post('val');
        $pin = $this->input->post('pin');
        $type = $this->input->post('type');



        if($type == 'admin')
        {
                $credential = array('admin_id' => base64_decode($val));


                $query = $this->db->get_where('admin', $credential);
                if ($query->num_rows() > 0) 
                {
                    $row = $query->row();
                    
                    $secret = $row->auth_secret;
                    
                    require_once 'public/auth/GoogleAuthenticator.php';
                    $ga = new PHPGangsta_GoogleAuthenticator();
                
                    $result = $ga->verifyCode($secret, $pin, 3);
                    if($result == 1){
                        $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
                        $this->session->set_userdata('doctor_login', '1');
                        $this->session->set_userdata('current_clinic', $current_clinic);
                        $this->session->set_userdata('doctor_id', $row->admin_id);
                        $this->session->set_userdata('login_user_id', $row->admin_id);
                        $this->session->set_userdata('name', $row->first_name);
                        $this->session->set_userdata('tipo', $row->type);
                        $this->session->set_userdata('login_type', 'doctor');
                            
                        $user_os        = $this->getOS();
                        $user_browser   = $this->getBrowser();
                        $PublicIP = $this->get_client_ip();
                        $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                        $json     = json_decode($json, true);
                        $city     = $json['city'];
                            
                        $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
                        if($row->last_info == ""){
                            $datas['last_info'] = $insert_info;
                        }
                        $datas['current_info'] = $insert_info;
                        $this->db->where('admin_id', $row->admin_id);
                        $this->db->update('admin', $datas);
                        $datalog['current_info'] = $insert_info;
                        $datalog['user_id'] = $row->admin_id;
                        $datalog['clinic_id'] = $current_clinic;
                        $this->db->insert('log_session', $datalog);
                        redirect(base_url() . 'doctor/panel/', 'refresh');   
                    }else{
                        $this->session->set_flashdata('error', '1');
                        redirect(base_url() . 'login/two_factor/'.$val, 'refresh');   
                    }
                }
        }

            if($type == 'staff')
            {
                $credential = array('staff_id' => base64_decode($val));
                $query = $this->db->get_where('staff', $credential);
                if ($query->num_rows() > 0) 
                {
                    $row = $query->row();
                    
                    $secret = $row->auth_secret;
                    
                    require_once 'public/auth/GoogleAuthenticator.php';
                    $ga = new PHPGangsta_GoogleAuthenticator();
                
                    $result = $ga->verifyCode($secret, $pin, 3);
                    if($result == 1){

                        $this->db->order_by('first_name', 'ASC');
                        $this->db->where('clinic_id',$current_clinic);
                        $query = $this->db->get('admin')->first_row()->admin_id;
                        $this->session->set_userdata('doctor_id', $queryss);

                    $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
                    $this->session->set_userdata('staff_login', '1');
                    $this->session->set_userdata('current_clinic', $current_clinic);
                    $this->session->set_userdata('staff_id', $row->staff_id);
                    $this->session->set_userdata('login_user_id', $row->staff_id);
                    $this->session->set_userdata('name', $row->name);
                    $this->session->set_userdata('tipo', $row->tipo);
                    $this->session->set_userdata('login_type', 'staff');
                    
                    $user_os        = $this->getOS();
                    $user_browser   = $this->getBrowser();
                    $PublicIP = $this->get_client_ip();
                    $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                    $json     = json_decode($json, true);
                    $city     = $json['city'];
                    $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
                    $datalog['current_info'] = $insert_info;
                    $datalog['user_id'] = $row->staff_id;
                    $datalog['clinic_id'] = $current_clinic;
                    $this->db->insert('log_session', $datalog);
                    redirect(base_url() . 'staff/appointments/', 'refresh');


                    }else{
                        $this->session->set_flashdata('error', '1');
                        redirect(base_url() . 'login/two_factor/'.$val, 'refresh');   
                    }
                }
        }

        if($type == 'patient')
        {
            $credential = array('patient_id' => base64_decode($val));
            $query = $this->db->get_where('patient', $credential);
            if ($query->num_rows() > 0) 
            {
                $row = $query->row();
                
                $secret = $row->auth_secret;
                
                require_once 'public/auth/GoogleAuthenticator.php';
                $ga = new PHPGangsta_GoogleAuthenticator();
            
                $result = $ga->verifyCode($secret, $pin, 3);
                if($result == 1){
    
                    $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
                    $row = $query->row();
                    $this->session->set_userdata('patient_login', '1');
                    $this->session->set_userdata('current_clinic', $current_clinic);
                    $this->session->set_userdata('patient_id', $row->patient_id);
                    $this->session->set_userdata('login_user_id', $row->patient_id);
                    $this->session->set_userdata('name', $row->name);
                    $this->session->set_userdata('login_type', 'patient');
                    
                    $user_os        = $this->getOS();
                    $user_browser   = $this->getBrowser();
                    $PublicIP = $this->get_client_ip();
                    $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                    $json     = json_decode($json, true);
                    $city     = $json['city'];
                    
                    $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
                    
                    
                    $datalog['current_info'] = $insert_info;
                    $datalog['user_id'] = $row->patient_id;
                    $datalog['clinic_id'] = $current_clinic;
                   
                    $this->db->insert('log_session', $datalog);
                    
                    redirect(base_url() . 'patient/dashboard/'.base64_encode($row->patient_id), 'refresh');
    
                }else{
                    $this->session->set_flashdata('error', '1');
                    redirect(base_url() . 'login/two_factor/'.$val, 'refresh');   
                }
            }
        }

        
        
       
        	$this->session->set_flashdata('error', '1');
        	redirect(base_url() . 'login/two_factor/'.$val, 'refresh');   
        
    }

    function auth() 
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $credential = array('username' => $username, 'password' => sha1($password));
        $query = $this->db->get_where('admin', $credential);
        
        if($query->num_rows() > 0) 
        {
            $row = $query->row();
            if($row->status != 0){
                if($row->auth_secret != ''){
                    redirect(base_url() . 'login/two_factor/'.base64_encode($row->admin_id).'/admin', 'refresh');
                }
                else
                {
                    if( $row->owner == 0)
                    {
                        $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
                        $this->session->set_userdata('doctor_login', '1');
                        $this->session->set_userdata('current_clinic', $current_clinic);
                        $this->session->set_userdata('doctor_id', $row->admin_id);
                        $this->session->set_userdata('login_user_id', $row->admin_id);
                        $this->session->set_userdata('name', $row->first_name);
                        $this->session->set_userdata('tipo', $row->type);
                        $this->session->set_userdata('login_type', 'doctor');
                        
                        $user_os        = $this->getOS();
                        $user_browser   = $this->getBrowser();
                        $PublicIP       = $this->get_client_ip();
                        $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                        $json     = json_decode($json, true);
                        $city     = $json['city'];
                        
                        $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
                        if($row->last_info == ""){
                            $datas['last_info'] = $insert_info;
                        }
                        $datas['current_info'] = $insert_info;
                        $this->db->where('admin_id', $row->admin_id);
                        $this->db->update('admin', $datas);
                        $datalog['current_info'] = $insert_info;
                        $datalog['user_id'] = $row->admin_id;
                        $datalog['clinic_id'] = $current_clinic;
                        $this->db->insert('log_session', $datalog);
                        
                        log_message('error','Doctor '.$row->admin_id);
                        redirect(base_url() . 'doctor/panel/', 'refresh');

                    }else 
                    {
                        $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
                        $this->session->set_userdata('admin_login', '1');
                        $this->session->set_userdata('current_clinic', $current_clinic);
                        $this->session->set_userdata('admin_id', $row->admin_id);
                        $this->session->set_userdata('login_user_id', $row->admin_id);
                        $this->session->set_userdata('name', $row->first_name);
                        $this->session->set_userdata('tipo', $row->type);
                        $this->session->set_userdata('login_type', 'admin');
                        
                        $user_os        = $this->getOS();
                        $user_browser   = $this->getBrowser();
                        $PublicIP       = $this->get_client_ip();
                        $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                        $json     = json_decode($json, true);
                        $city     = $json['city'];
                        
                        $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
                        if($row->last_info == ""){
                            $datas['last_info'] = $insert_info;
                        }
                        $datas['current_info'] = $insert_info;
                        $this->db->where('admin_id', $row->admin_id);
                        $this->db->update('admin', $datas);
                        $datalog['current_info'] = $insert_info;
                        $datalog['user_id'] = $row->admin_id;
                        $datalog['clinic_id'] = $current_clinic;
                        $this->db->insert('log_session', $datalog);
                        
                        redirect(base_url() . 'admin/panel/', 'refresh');
                    }
                }
            }
            else
            {
                  redirect(base_url(), 'refresh');
            }
            
        }
        
        
        $credential = array('username' => $username, 'password' => sha1($password));
        $query = $this->db->get_where('staff', $credential);
        if ($query->num_rows() > 0) 
        {
            $current_clinic   = $this->db->get('clinic')->first_row()->clinic_id;
            $row = $query->row();
            
            if($row->status != 0)
            {
                if($row->auth_secret != ''){
                    redirect(base_url() . 'login/two_factor/'.base64_encode($row->staff_id).'/staff', 'refresh');
                }else{
    
                    
                    $this->db->order_by('first_name', 'ASC');
                    $this->db->where('clinic_id',$current_clinic);
                    $queryss = $this->db->get('admin')->first_row()->admin_id;
                    $this->session->set_userdata('doctor_id', $queryss);
    
                    $this->session->set_userdata('staff_login', '1');
                    $this->session->set_userdata('current_clinic', $current_clinic);
                    $this->session->set_userdata('staff_id', $row->staff_id);
                    $this->session->set_userdata('login_user_id', $row->staff_id);
                    $this->session->set_userdata('name', $row->first_name);
                    $this->session->set_userdata('tipo', 'staff');
                    $this->session->set_userdata('login_type', 'staff');
                    
                    $user_os        = $this->getOS();
                    $user_browser   = $this->getBrowser();
                    $PublicIP = $this->get_client_ip();
                    $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
                    $json     = json_decode($json, true);
                    $city     = $json['city'];
                    
                    $insert_info = $this->crud_model->formatDate2()." utilizando ".$user_browser." (".$user_os .") en ".$city;
                    
                    
                    $datalog['current_info'] = $insert_info;
                    $datalog['user_id'] = $row->staff_id;
                    $datalog['clinic_id'] = $current_clinic;
                    
                    $this->db->insert('log_session', $datalog);

                    $entry = $this->db->get_where('entry',array('staff_id'=> $row->staff_id, 'date' => date('Y-m-d') ))->num_rows();
                    if( $entry == 0){
                        $data['staff_id'] = $row->staff_id;
                        $data['date'] = date('Y-m-d');
                        $data['time'] = date('H:i:s A');
                        $this->db->insert('entry',$data);
                    }

                    if($row->category == 5){
                         redirect(base_url() . 'staff/accounting/', 'refresh');
                    }else
                    {
                        $rol_id = $row->role_id;
                        $details = unserialize($this->db->get_where('role',array('role_id'=>$rol_id))->row()->permissions);
                        
                        foreach ($details as $key => $value) {
                            if ($value == 1) {
                                $page = str_replace("view_", "", $key);
                                log_message('error',$page);
                                redirect(base_url() . 'staff/'.$page.'/', 'refresh');
                                exit();
                            }
                        }
                        
                    }
                   
                }
            }
            else
            {
                redirect(base_url(), 'refresh');
            }
        }
                
        $credential = array('username' => $username, 'password' => sha1($password));        
    
        redirect(base_url(), 'refresh');
            
        $this->session->set_flashdata('error', '1');
        redirect(base_url().'login/', 'refresh');
    }
    
    function two_factor($param = '', $param1 = ''){
        $data['val'] = $param;
        $data['type'] = $param1;
        $this->load->view('backend/two_factor',$data);
    }
}