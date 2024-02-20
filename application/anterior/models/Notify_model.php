<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notify_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
    
    public function new_income()
    {
        $currency   = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $msg        = 'Se ha registrado un nuevo ingreso por un monto de <b>'.$currency.'. '. number_format($this->input->post('amount'),'2', '.', ',')."</b>";
        $url        = base_url().'doctor/financial/';
        $doctors    = $this->db->get_where('admin', array('clinic_id' => $this->session->userdata('current_clinic')))->result_array();
        foreach($doctors as $row)
        {
            $insert['date']        = $this->crud_model->formatDate();    
            $insert['read_status'] = 0;
            $insert['to_user']     = $row['admin_id'];
            $insert['to_type']     = 'doctor';
            $insert['from_user']   = 0;
            $insert['from_type']   = 0;
            $insert['message']     = $msg;
            $insert['url']         = $url;
            $this->db->insert('notification', $insert);   
        }
    }
    
    public function new_expense()
    {
        $currency   = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $msg        = 'Se ha registrado un nuevo egreso por un monto de <b>'.$currency.'. '. number_format($this->input->post('amount'),'2', '.', ',')."</b>";
        $url        = base_url().'doctor/expenses/';
        $doctors    = $this->db->get_where('admin', array('clinic_id' => $this->session->userdata('current_clinic')))->result_array();
        foreach($doctors as $row)
        {
            $insert['date']        = $this->crud_model->formatDate();    
            $insert['read_status'] = 0;
            $insert['to_user']     = $row['admin_id'];
            $insert['to_type']     = 'doctor';
            $insert['from_user']   = 0;
            $insert['from_type']   = 0;
            $insert['message']     = $msg;
            $insert['url']         = $url;
            $this->db->insert('notification', $insert);   
        }
    }
    
    public function confirm_appointment($appointment_id)
    {
        $patient_id     = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->patient_id;
        $practice_id    = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
        $doctor_id      = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->doctor_id;
        if($practice_id > 0){
            $service = $this->db->get_where('service', array('service_id' => $practice_id))->row()->name;   
        }else{
            $service = "Otros";
        }
        
        $msg                    = 'La cita <b>'. $service."</b> del paciente <b>".$this->accounts_model->short_name('patient',$patient_id)."</b> ha sido confirmada.";
        $url                    = base_url().'doctor/appointment_details/'.base64_encode($appointment_id);
        $insert['date']         = $this->crud_model->formatDate();    
        $insert['read_status']  = 0;
        $insert['to_user']      = $doctor_id;
        $insert['to_type']      = 'doctor';
        $insert['from_user']    = 0;
        $insert['from_type']    = 0;
        $insert['message']      = $msg;
        $insert['url']          = $url;
        $this->db->insert('notification', $insert);
    }
    
    public function cancel_appointment($appointment_id)
    {
        $patient_id     = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->patient_id;
        $practice_id    = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
        $doctor_id      = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->doctor_id;
        if($practice_id > 0){
            $service    = $this->db->get_where('service', array('service_id' => $practice_id))->row()->name;   
        }else{
            $service    = "Otros";
        }
        
        $msg = 'La cita <b>'. $service."</b> del paciente <b>".$this->accounts_model->short_name('patient',$patient_id)."</b> ha sido cancelada.";
        $url = base_url().'doctor/appointment_details/'.base64_encode($appointment_id);
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['read_status'] = 0;
        $insert['to_user']     = $doctor_id;
        $insert['to_type']     = 'doctor';
        $insert['from_user']   = 0;
        $insert['from_type']   = 0;
        $insert['message']     = $msg;
        $insert['url']         = $url;
        $this->db->insert('notification', $insert);
    }
    
    public function reschedule_appointment($appointment_id)
    {
        $patient_id     = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->patient_id;
        $practice_id    = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
        $doctor_id      = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->doctor_id;
        if($practice_id > 0){
            $service    = $this->db->get_where('service', array('service_id' => $practice_id))->row()->name;   
        }else{
            $service    = "Otros";
        }
        
        $msg                    = 'La cita <b>'. $service."</b> del paciente <b>".$this->accounts_model->short_name('patient',$patient_id)."</b> ha sido reprogramada.";
        $url                    = base_url().'doctor/appointment_details/'.base64_encode($appointment_id);
        $insert['date']         = $this->crud_model->formatDate();    
        $insert['read_status']  = 0;
        $insert['to_user']      = $doctor_id;
        $insert['to_type']      = 'doctor';
        $insert['from_user']    = 0;
        $insert['from_type']    = 0;
        $insert['message']      = $msg;
        $insert['url']          = $url;
        $this->db->insert('notification', $insert);
    }
    
    public function delete_appointment($appointment_id)
    {
        $patient_id     = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->patient_id;
        $practice_id    = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
        $doctor_id      = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->doctor_id;
        if($practice_id > 0){
            $service    = $this->db->get_where('service', array('service_id' => $practice_id))->row()->name;   
        }else{
            $service    = "Otros";
        }
        
        $msg = 'La cita <b>'. $service."</b> del paciente <b>".$this->accounts_model->short_name('patient',$patient_id)."</b> ha sido eliminada.";
        $url = base_url().'doctor/appointment_details/'.base64_encode($appointment_id);
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['read_status'] = 0;
        $insert['to_user']     = $doctor_id;
        $insert['to_type']     = 'doctor';
        $insert['from_user']   = 0;
        $insert['from_type']   = 0;
        $insert['message']     = $msg;
        $insert['url']         = $url;
        $this->db->insert('notification', $insert);
    }

    public function new_chat($to_type, $to_id)
    {
        $current = '';
        $to_ = explode('-',$to_type);

        if($this->session->userdata('login_type') == 'doctor')
        {
            $current = 'admin';
        }else if($this->session->userdata('login_type') == 'patient')
        {
            $current = 'patient';
        }else{
            $current = 'staff';
        }

        if($to_[0] == 'admin')
            $to_[0] = 'doctor';
            
        $msg = $this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))." te ha enviado un mensaje.";
        $url = base_url().$to_[0].'/chat_messages/'.$this->db->get_where($current, array($current.'_id' => $this->session->userdata('login_user_id')))->row()->username;

        

        $insert['date']        = $this->crud_model->formatDate();    
        $insert['read_status'] = 0;
        $insert['to_user']     = $to_id;
        $insert['to_type']     = $to_[0];
        $insert['from_user']   = $this->session->userdata('login_user_id');
        $insert['from_type']   = $this->session->userdata('login_type');
        $insert['message']     = $msg;
        $insert['url']         = $url;
        $this->db->insert('notification', $insert);
    }
    
    public function survey($survey_id, $patient_id)
    {
        $clinic_id      = $this->db->get_where('survey', array('survey_id' => $survey_id))->row()->clinic_id;
        $msg            = 'El paciente '.$this->accounts_model->short_name('patient', $patient_id).', respondió la encuesta '.$this->db->get_where('survey', array('survey_id' => $survey_id))->row()->title;
        $url            = base_url().$this->session->userdata('login_type').'/survey_results/'.$survey_id;
        $users          = $this->db->query('SELECT type, admin_id, clinic_id FROM admin UNION SELECT type ,staff_id,clinic_id FROM staff WHERE clinic_id = '.$clinic_id.'')->result_array();
        foreach($users as $row)
        {
            $insert['date']        = $this->crud_model->formatDate();    
            $insert['read_status'] = 0;
            $insert['to_user']     = $row['admin_id'];
            $insert['to_type']     = $row['type'];
            $insert['from_user']   = 0;
            $insert['from_type']   = 0;
            $insert['message']     = $msg;
            $insert['url']         = $url;
            $this->db->insert('notification', $insert);   
        }
        
    }
    

}