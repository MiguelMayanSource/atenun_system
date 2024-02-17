<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Security_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }

    function clear_cache() 
    {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    
    function getGoogleAuthQR(){
        require_once 'public/auth/GoogleAuthenticator.php';
	    $ga = new PHPGangsta_GoogleAuthenticator();
	    $secret = $ga->createSecret();
	    $username = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->username;
	    $qr = $ga->getQRCodeGoogleUrl('Medicaby ('.$username.')',$secret);
	    $array = array(
            "qr" => $qr,
            "secret" => $secret,
        );
	    return $array;
    }

    function getGoogleStaffAuthQR(){
        require_once 'public/auth/GoogleAuthenticator.php';
	    $ga = new PHPGangsta_GoogleAuthenticator();
	    $secret = $ga->createSecret();
	    $username = $this->db->get_where('staff', array('staff_id' => $this->session->userdata('login_user_id')))->row()->username;
	    $qr = $ga->getQRCodeGoogleUrl('Medicaby ('.$username.')',$secret);
	    $array = array(
            "qr" => $qr,
            "secret" => $secret,
        );
	    return $array;
    }
    
    function getGooglePatientAuthQR(){
        require_once 'public/auth/GoogleAuthenticator.php';
	    $ga = new PHPGangsta_GoogleAuthenticator();
	    $secret = $ga->createSecret();
	    $username = $this->db->get_where('patient', array('patient_id' => $this->session->userdata('login_user_id')))->row()->username;
	    $qr = $ga->getQRCodeGoogleUrl('Medicaby ('.$username.')',$secret);
	    $array = array(
            "qr" => $qr,
            "secret" => $secret,
        );
	    return $array;
    }
    
    function updateSecret($secret){
        $data['auth_secret'] = $secret;
	    $this->db->where('admin_id', $this->session->userdata('login_user_id'));
	    return $this->db->update('admin', $data);
    }

    function updateSecretStaff($secret){
        $data['auth_secret'] = $secret;
	    $this->db->where('staff_id', $this->session->userdata('login_user_id'));
	    return $this->db->update('staff', $data);
    }
    
    function updateSecretPatient($secret){
        $data['auth_secret'] = $secret;
	    $this->db->where('patient_id', $this->session->userdata('login_user_id'));
	    return $this->db->update('patient', $data);
    }
    
    function authStatus(){
	    $status = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->auth_secret;
	    return $status;
    }

    function authStatusStaffProfile(){
	    $status = $this->db->get_where('staff', array('staff_id' => $this->session->userdata('login_user_id')))->row()->auth_secret;
	    return $status;
    }
    
    function authStatusPatient($patientId){
	    $status = $this->db->get_where('patient', array('patient_id' => $patientId))->row()->auth_secret;
	    return $status;
    }

    function removeAuthPatient($patientId){
        $data['auth_secret'] = '';
	    $this->db->where('patient_id', $patientId);
	    return $this->db->update('patient', $data);
    }
    
    function remove_auth(){
        $data['auth_secret'] = '';
	    $this->db->where('admin_id', $this->session->userdata('login_user_id'));
	    return $this->db->update('admin', $data);
    }
    
    
    function remove_authDoctor($doctor_id)
    {
        $data['auth_secret'] = '';
	    $this->db->where('admin_id', $doctor_id);
	    return $this->db->update('admin', $data);
    }
    
    function remove_authStaff($staff_id)
    {
        $data['auth_secret'] = '';
	    $this->db->where('staff_id', $staff_id);
	    return $this->db->update('staff', $data);
    }
    
    function remove_authPatient()
    {
        $data['auth_secret'] = '';
	    $this->db->where('patient_id', $this->session->userdata('login_user_id'));
	    return $this->db->update('patient', $data);
    }
    
    
    function authStatusProfile($admin_id)
    {
	    $status = $this->db->get_where('admin', array('admin_id' => $admin_id))->row()->auth_secret;
	    return $status;
    }
    
    function remove_authProfile($admin_id)
    {
        $data['auth_secret'] = '';
	    $this->db->where('admin_id', $admin_id);
	    return $this->db->update('admin', $data);
    }
    
    
    function authStatusStaff($staff_id)
    {
        $status = $this->db->get_where('staff', array('staff_id' => $staff_id))->row()->auth_secret;
	    return $status;
    }
    
    function authPatientStatus(){
	    $status = $this->db->get_where('patient', array('patient_id' => $this->session->userdata('login_user_id')))->row()->auth_secret;
	    return $status;
    }
    
    function remove_sessionsPatient(){
        $this->db->where('userType', 'patient');
        $this->db->where('userId', $this->session->userdata('login_user_id'));
        return $this->db->delete('ci_sessions');
    }
    
    function remove_sessionsPa($user_id){
        $this->db->where('userType', 'patient');
        $this->db->where('userId', $user_id);
        return $this->db->delete('ci_sessions');
    }
    
    function remove_sessionsStaff($staff_id){
        $this->db->where('userType', 'staff');
        $this->db->where('userId', $staff_id);
        return $this->db->delete('ci_sessions');
    }

    function remove_sessionsDoctor($doctor_id){
        $this->db->where('userType', 'doctor');
        $this->db->where('userId', $doctor_id);
        return $this->db->delete('ci_sessions');
    }
    
    
}