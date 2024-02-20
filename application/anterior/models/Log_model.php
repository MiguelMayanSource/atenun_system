<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
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

        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> envió un mensaje a <b>".$this->accounts_model->short_name($to_[0], $to_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function new_appointment($patient_id, $service_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        if($service_id > 0){
            $service = $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
        }else{
            $service = "Otros servicios";
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agendo la cita <b>".$service."</b> al paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_appointment($appointment_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $patient_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->patient_id;
        $service_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
        if($service_id > 0){
            $service = $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
        }else{
            $service = "Otros servicios";
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> elimino la cita <b>".$service."</b> del paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function confirm_appointment($appointment_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $patient_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->patient_id;
        $service_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
        if($service_id > 0){
            $service = $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
        }else{
            $service = "Otros servicios";
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> confirmó la cita <b>".$service."</b> del paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function reschedule_appointment($appointment_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $patient_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->patient_id;
        $service_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
        if($service_id > 0){
            $service = $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
        }else{
            $service = "Otros servicios";
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> reagendó la cita <b>".$service."</b> del paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function cancel_appointment($appointment_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $patient_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->patient_id;
        $service_id = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
        if($service_id > 0){
            $service = $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
        }else{
            $service = "Otros servicios";
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> canceló la cita <b>".$service."</b> del paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function file_uploaded($patient_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> subió un nuevo archivo al perfil del paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function new_patient($patient_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agregó al paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_patient($patient_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> elimino al paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function email_medical_prescription($patient_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> envió por correo una receta médica al paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function download_pdf($patient_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> descargó una receta médica del paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function print_prescription($prescription_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = $this->session->userdata('login_type');
        }
        $patient_id = $this->db->get_where('prescription', array('prescription_id' => $prescription_id))->row()->patient_id;
        if($this->session->userdata('login_type') == 'patient'){
            $msg = "<b> El paciente: ".$this->accounts_model->short_name('patient', $patient_id)."</b> imprimió su receta médica.";
        }
        else
        {
            $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> imprimió una receta médica del paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        }
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function download_file($patient_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> descargó un archivo del paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function new_service($service_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $service = $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agrego un nuevo servicio llamado <b>".$service."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_service($service_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $service = $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> eliminó el servicio <b>".$service."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    
    public function update_patient($patient_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> actualizó el perfil del paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function create_doctor($doctor_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agregó al médico/a <b>".$this->accounts_model->short_name('admin', $doctor_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function update_doctor($doctor_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> actualizó el perfil del médico/a <b>".$this->accounts_model->short_name('admin', $doctor_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_doctor($doctor_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> eliminó al médico/a <b>".$this->accounts_model->short_name('admin', $doctor_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function create_staff($staff_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agregó al miembro del equipo <b>".$this->accounts_model->short_name('staff', $staff_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function update_staff($staff_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> actualizó el perfil del miembro del equipo <b>".$this->accounts_model->short_name('staff', $staff_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_staff($staff_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> eliminó al miembro del equipo <b>".$this->accounts_model->short_name('staff', $staff_id)."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function new_product($product_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $product = $this->db->get_where('product', array('product_id' => $product_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agregó el producto <b>".$product."</b> al inventario.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function update_product($product_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $product = $this->db->get_where('product', array('product_id' => $product_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> actualizó el producto <b>".$product."</b> en el inventario.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_product($product_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $product = $this->db->get_where('product', array('product_id' => $product_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> eliminó el producto <b>".$product."</b> del inventario.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function update_clinic($clinic_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $clinic = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> actualizó la sucursal <b>".$clinic."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function create_clinic($clinic_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $clinic = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agregró la sucursal <b>".$clinic."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_clinic($clinic_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $clinic = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> eliminó la sucursal <b>".$clinic."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function create_laboratory($lab_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $lab = $this->db->get_where('laboratory', array('laboratory_id' => $lab_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agregró el laboratorio <b>".$lab."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_lab($lab_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $lab = $this->db->get_where('laboratory', array('laboratory_id' => $lab_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> eliminó el laboratorio <b>".$lab."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function create_special($special_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $special = $this->db->get_where('specialtie', array('specialtie_id' => $special_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agregró la especialidad <b>".$special."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_special($special_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $special = $this->db->get_where('specialtie', array('specialtie_id' => $special_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> eliminó la especialidad <b>".$special."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_session()
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $special = $this->db->get_where('specialtie', array('specialtie_id' => $special_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> cerró sesión en todos los dispositivos.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function new_survey($survey_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $survey = $this->db->get_where('survey', array('survey_id' => $survey_id))->row()->title;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agregró la encuesta <b>".$survey."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function update_survey($survey_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $survey = $this->db->get_where('survey', array('survey_id' => $survey_id))->row()->title;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> actualizó la encuesta <b>".$survey."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function new_sale($patient_id, $amount)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $survey = $this->db->get_where('survey', array('survey_id' => $survey_id))->row()->title;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agregó una nueva venta para el paciente <b>".$this->accounts_model->short_name('patient', $patient_id)."</b> por un monto de <b>".$currency.". ".number_format($amount,'2', '.', ',')."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function new_expense_category($expense_category_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $expense_category = $this->db->get_where('expense_category', array('expense_category_id' => $expense_category_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> agregró una nueva categoría de egresos llamada <b>".$expense_category."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function update_expense_category($expense_category_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $expense_category = $this->db->get_where('expense_category', array('expense_category_id' => $expense_category_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> actualizó la categoría de egresos <b>".$expense_category."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_expense_category($expense_category_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $expense_category = $this->db->get_where('expense_category', array('expense_category_id' => $expense_category_id))->row()->name;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> eliminó la categoría de egresos <b>".$expense_category."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function create_income($amount)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> registró un nuevo ingreso por <b>".$currency.'. '.number_format($amount,'2', '.', ',')."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_income($income_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $amount = $this->db->get_where('financial', array('financial_id' => $income_id))->row()->amount;
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> eliminó un ingreso con un monto de <b>".$currency.'. '.number_format($amount,'2', '.', ',')."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function update_income($income_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $title      = $this->db->get_where('financial', array('financial_id' => $income_id))->row()->description;
        $amount     = $this->db->get_where('financial', array('financial_id' => $income_id))->row()->amount;
        $currency   = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> actualizó el ingreso <b>".$title."</b> con un monto de <b>".$currency.'. '.number_format($amount,'2', '.', ',')."</b> a <b>".$currency.'. '.number_format($this->input->post('amount'),'2', '.', ',')."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function create_expense($amount)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> registró un nuevo egreso por un monto de <b>".$currency.'. '.number_format($amount,'2', '.', ',')."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function delete_expense($expense_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $amount = $this->db->get_where('expense', array('expense_id' => $expense_id))->row()->amount;
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> eliminó un egreso con un monto de <b>".$currency.'. '.number_format($amount,'2', '.', ',')."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function update_expense($expense_id)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $title = $this->db->get_where('expense', array('expense_id' => $expense_id))->row()->description;
        $amount = $this->db->get_where('expense', array('expense_id' => $expense_id))->row()->amount;
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency; 
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> actualizó el egreso <b>".$title."</b> con un monto de <b>".$currency.'. '.number_format($amount,'2', '.', ',')."</b> a <b>".$currency.'. '.number_format($this->input->post('amount'),'2', '.', ',')."</b>.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function financial_report()
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> generó un reporte financiero.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function appointment_report()
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> generó un reporte de citas.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function activity_report()
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> generó un reporte de actividad de usuario.";
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert);
    }
    
    public function add_payment_credit($pay_id, $cant)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> Agregó un nuevo abono en tratamiento dental con ID: ".$pay_id." por el monto de: ".$cant;
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert); 
    }
    
    
    public function delete_payment_credit($pay_id, $cant)
    {
        $current = '';
        $to_ = '';
        if($this->session->userdata('login_type') == 'doctor'){
            $current = 'admin';
        }else{
            $current = 'staff';
        }
        $msg = "<b>".$this->accounts_model->short_name($current,$this->session->userdata('login_user_id'))."</b> Eliminó un nuevo abono en tratamiento dental con ID: ".$pay_id." por el monto de: ".$cant;
        $insert['date']        = $this->crud_model->formatDate();    
        $insert['message']     = $msg;    
        $insert['clinic_id']   = $this->session->userdata('current_clinic');    
        $insert['user_id']     = $this->session->userdata('login_user_id');
        $insert['user_type']   = $current;
        $this->db->insert('bitacora', $insert); 
    }
    
    

}