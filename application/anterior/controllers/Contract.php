<?php 
    if (!defined('BASEPATH')) 
    exit('No direct script access allowed');

class Contract extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('user_agent');
        $this->load->library('session'); 
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');    
    }
    
    function createClinic(){
        $code= $this->crud_model->getCode();

        $data['domain']            = base_url();
        $data['name']              = $this->input->post('name');
        $data['phone']             = $this->input->post('phone');
        $data['email']             = $this->input->post('email');
        $data['address']           = $this->input->post('address');
        $data['currency']          = $this->input->post('currency');
        $data['theme']             = $this->input->post('theme');
        $data['morning']           = $this->input->post('morning');
        $data['b_morning']         = $this->input->post('b_morning');
        $data['afternoon']         = $this->input->post('afternoon');
        $data['b_afternoon']       = $this->input->post('b_afternoon');
        $data['time_interval']     = $this->input->post('time_interval');
        $data['first_name']        = $this->input->post('first_name');
        $data['second_name']       = $this->input->post('second_name');
        $data['third_name']        = $this->input->post('third_name');
        $data['last_name']         = $this->input->post('last_name');
        $data['second_last_name']  = $this->input->post('second_last_name');
        $data['married_last_name'] = $this->input->post('married_last_name');
        $data['emailx']            = $this->input->post('emailx');
        $data['phonex']            = $this->input->post('phonex');
        $data['addressx']          = $this->input->post('addressx');
        $data['code']              = $code;
        $result = $this->send_api($data);

        $clinic['name']          = $this->input->post('name');
        $clinic['phone']         = $this->input->post('phone');
        $clinic['email']         = $this->input->post('email');
        $clinic['address']       = $this->input->post('address');
        $clinic['currency']      = $this->input->post('currency');
        $clinic['morning']       = $this->input->post('morning');
        $clinic['b_morning']     = $this->input->post('b_morning');
        $clinic['afternoon']     = $this->input->post('afternoon');
        $clinic['b_afternoon']   = $this->input->post('b_afternoon');
        $clinic['time_interval'] = $this->input->post('time_interval');
        $clinic['theme']         = '#0044E9';
        $clinic['logo']          = "default_clinc.png";
        $clinic['status']        = 1;
        $clinic['domain']        = base_url();
        $clinic['code']          = $code;
        $this->db->insert('clinic', $clinic);
        $clinic_id= $this->db->insert_id();
        
        $admin['clinic_id']         = $clinic_id;
        $admin['first_name']        = $this->input->post('first_name');
        $admin['second_name']       = $this->input->post('second_name');
        $admin['third_name']        = $this->input->post('third_name');
        $admin['last_name']         = $this->input->post('last_name');
        $admin['second_last_name']  = $this->input->post('second_last_name');
        $admin['married_last_name'] = $this->input->post('married_last_name');
        $admin['email']             = $this->input->post('emailx');
        $admin['phone']             = $this->input->post('phonex');
        $admin['address']           = $this->input->post('addressx');
        $admin['status']            = 1;
        $admin['moduls']            = 1;
        $admin['panel']             = 1;
        $admin['chat']              = 1;
        $admin['patients']          = 1;
        $admin['doctors']           = 1;
        $admin['staff']             = 1;
        $admin['inventory']         = 1;
        $admin['financial']         = 1;
        $admin['reports']           = 1;
        $admin['settings']          = 1;

        $this->db->insert('admin', $admin);

        redirect(base_url(),'refresh');
    }

    function send_api($data_array){
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://medicaby.com/api/createContract",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_array,
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    return $response; 
    }



/*   function updateContract(){
        $updateclinic['name'] = $this->input->post('name');
        $updateclinic['email'] = $this->input->post('email');
        $updateclinic['phone'] = $this->input->post('phone');
        $updateclinic['address'] = $this->input->post('address');
        $updateclinic['currency'] = $this->input->post('currency');
        $updateclinic['theme']= $this->input->post('theme');

        $updateclinic['morning'] = $this->input->post('morning');
        $updateclinic['b_morning'] = $this->input->post('b_morning');
        $updateclinic['afternoon'] = $this->input->post('afternoon');
        $updateclinic['b_afternoon'] = $this->input->post('b_afternoon');
        $updateclinic['time_interval'] = $this->input->post('duration');


        $this->db->where('clinic_id', $this->input->post('clinic_id'));
        $this->db->update('clinic', $updateclinic);
        $response['result']='success';   
    
    echo '['.json_encode($response).']';

    } */
        
}


?>