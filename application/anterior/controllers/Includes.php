<?php 

    if (!defined('BASEPATH')) 
    exit('No direct script access allowed');
   
class Includes extends CI_Controller
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
    
    public function index() 
    {
        redirect(base_url() .$this->session->userdata('login_type'). '/panel/', 'refresh');
    }

    //Cargar la lista de recetas de un paciente.
    function patient_prescriptions()
    {
        # code...
        $page_data['patient_id'] = $this->input->post('patient_id');
        $this->load->view('backend/includes/patient_prescriptions.php', $page_data);
    }


    function new_prescription()
    {
        # code...
        $this->load->view('backend/includes/new_prescription.php', $page_data);
    }

    //Fin de contabilidad
}