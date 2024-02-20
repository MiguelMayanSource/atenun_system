<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Social extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function index()
    {   
    
        
        $data['googleSYNC']     =   $this->sync();
        $data['facebookSYNC']       =   $this->facebook();
        
        $this->load->view('backend/doctor/doctors/doctor_profile_list',$data);
        
        
    }

    function sync_google()
    {
        $query=0;

        $this->db->where('gm_id', $this->input->post('gm_id'));
        $query += $this->db->get('admin')->num_rows();

        $this->db->where('gm_id', $this->input->post('gm_id'));
        $query += $this->db->get('staff')->num_rows();

        $this->db->where('gm_id', $this->input->post('gm_id'));
        $query += $this->db->get('patient')->num_rows();
        

        
        
            if($query > 0 )
            {
                
                echo 'error';
                
            }
            else
            {
                
                   $this->db->where($this->input->post('type').'_id', $this->input->post('id'));
                   $data['gm_id']=$this->input->post('gm_id');
                   $data['g_fname']=$this->input->post('name');
                   $data['g_picture']=$this->input->post('picture');
                   $data['g_email']=$this->input->post('email');
                   
            
                   $this->db->update($this->input->post('type'),$data);
                    echo 'success';
                    exit();
                
            }

    }
           
    
    
    function sync_facebook()
    {
        $query = 0;

             $this->db->where('fb_id', $this->input->post('id_token'));
             $query += $this->db->get('admin')->num_rows();
             
            $this->db->where('fb_id', $this->input->post('id_token'));
             $query += $this->db->get('staff')->num_rows();

             $this->db->where('fb_id', $this->input->post('id_token'));
             $query  += $this->db->get('patient')->num_rows();
             
             
                 if($query > 0 )
                 {
                     
                     echo 'error';
                     
                 } 
                 else
                 {
                     
                        $this->db->where($this->input->post('type').'_id', $this->input->post('user_id'));
                        $data['fb_id']=$this->input->post('id_token');
                        $data['fb_photo']=$this->input->post('picture');
                        $data['fb_name']=$this->input->post('name');
                        
                 
                        $this->db->update($this->input->post('type'),$data);
                         echo 'success';
                         exit();
                     
                 }
    } 
    
    
        function desync_google()
    {
        
            
                     
            $this->db->where($this->input->post('type').'_id', $this->input->post('user_id'));
            $data['gm_id']="";
     
            $this->db->update($this->input->post('type'),$data);
             echo 'Cuenta desvinculada';
             exit();
                 
             
        
    
    }
    
            function desync_facebook()
    {
        
            
                     
            $this->db->where($this->input->post('type').'_id', $this->input->post('user_id'));
            $data['fb_id']="";
     
            $this->db->update($this->input->post('type'),$data);
             echo 'Cuenta desvinculada';
             exit();
                 
             
        
    
    }
    



    function sync_google_staff()
    {
        
            include_once '/home/medicaby/public_html/social/google/Google_Client.php';
            include_once '/home/medicaby/public_html/social/google/contrib/Google_Oauth2Service.php';
            
            $clientId = $this->db->get_where('settings', array('type' => 'google_sync'))->row()->description; //Google client ID
            $clientSecret = $this->db->get_where('settings', array('type' => 'google_login'))->row()->description; // Google client Secret
            $gClient = new Google_Client();
            
            $gClient->setClientId($clientId);
            
            
            $payload = $gClient->verifyIdToken($this->input->post('id_token'))->getAttributes();
            
            if ($payload) 
            {
             
             $this->db->where('gm_id',$payload['payload']['sub']);
             $query = $this->db->get('staff')->num_rows();
             
            $this->db->where('gm_id',$payload['payload']['sub']);
             $query2 = $this->db->get('admin')->num_rows();
             
                 if($query > 0 )
                 {
                     
                     echo 'error';
                     
                 }
                 else if($query2 > 0 )
                 {
                     
                     echo 'error';
                     
                 }else
                 {
                     
                        $this->db->where('staff_id', $this->input->post('staff_id'));
                        $data['gm_id']=$payload['payload']['sub'];
                        $data['g_picture']=$payload['payload']['picture'];
                        $data['g_fname']=$payload['payload']['name'];
                 
                        $this->db->update('staff',$data);
                         echo 'success';
                         exit();
                     
                 }
             
 
            } else {
                
                     echo 'Error al tratar de vincular esta cuenta';
                      exit();
            }
             
        
    
    }
    
        function sync_facebook_staff()
    {
        

             $this->db->where('fb_id', $this->input->post('id_token'));
             $query = $this->db->get('staff')->num_rows();
             
            $this->db->where('fb_id', $this->input->post('id_token'));
             $query2 = $this->db->get('admin')->num_rows();
             
                 if($query > 0 )
                 {
                     
                     echo 'error';
                     
                 }else if($query2 > 0 )
                 {
                      echo 'error';
                 }
                 else
                 {
                     
                        $this->db->where('staff_id', $this->input->post('staff_id'));
                        $data['fb_id']=$this->input->post('id_token');
                        $data['fb_photo']=$this->input->post('picture');
                        $data['fb_name']=$this->input->post('name');
                        
                 
                        $this->db->update('staff',$data);
                         echo 'success';
                         exit();
                     
                 }
             
 
            } 
             
        
    
    
    
    
    
        function desync_google_staff()
    {
        
            
                     
            $this->db->where('staff_id', $this->input->post('staff_id'));
            $data['gm_id']="";
     
            $this->db->update('staff',$data);
             echo 'Cuenta desvinculada';
             exit();
                 
             
        
    
    }
    
            function desync_facebook_staff()
    {
        
            
                     
            $this->db->where('staff_id', $this->input->post('staff_id'));
            $data['fb_id']="";
     
            $this->db->update('staff',$data);
             echo 'Cuenta desvinculada';
             exit();
                 
             
        
    
    }


}