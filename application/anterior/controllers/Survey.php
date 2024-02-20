<?php 
    if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Survey extends CI_Controller 
{
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }
 
    public function index() 
    {
        echo 'xD';
    }
    
    function reply(){
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        $this->load->view('backend/reply_survey');
    }
    
    
     function reply_survey($survey_id = ''){
       
       log_message('error',$survey_id);
        if ($this->session->userdata('admin_login') != 1 && $this->session->userdata('staff_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
         if($survey_id != '')
         {
             $data['survey_id'] = $survey_id;
            $this->load->view('backend/reply_survey_user',$data); 
         }else
         {
             redirect(base_url(),'refresh');
         }
        
    }
    
    
    function confirm()
    {
        $answer_script = array();
        if($this->input->post('survey_id') != '')
        {
            $query = $this->db->get_where('survery_result', array('survey_id' => $this->input->post('survey_id'), 'patient_id' => $this->input->post('src_key')))->num_rows();
            if($query == 0)
            {
                $question_bank = $this->db->get_where('question', array('survey_id' => $this->input->post('survey_id')))->result_array();
                foreach ($question_bank as $question) 
                {
                    $container_2 = array();
                    if (isset($_POST[$question['question_id']]))
                    {
                        foreach ($this->input->post($question['question_id']) as $row) 
                        { 
                            $submitted_answer = "";  
                            array_push($container_2, strtolower($row));
                            $submitted_answer = json_encode($container_2);
                            $container = array(
                                "question_id" => $question['question_id'],
                                "submitted_answer" => $submitted_answer,
                            );
                        }
                    }else {
                        $container = array(
                            "question_id" => $question['question_id'],
                            "submitted_answer" => "",
                        );
                    }
                    array_push($answer_script, $container);
                }
                $insert_array = array(
                    'status' => 'success',
                    'survey_id' => $this->input->post('survey_id'),
                    'date' => $this->crud_model->formatDate(),
                    'year' => date('Y'),
                    'user_id' => $this->input->post('src_key'),
                    'user_type' => 'patient',
                    'answer_script' => json_encode($answer_script)
                );
                $this->db->insert('survery_result', $insert_array);
                $this->notify_model->survey($this->input->post('survey_id'),$this->input->post('src_key'));
                $this->load->view('backend/send_email');  
            }else{
                $this->load->view('backend/send_email');  
            }
        }else{
            $this->load->view('backend/send_email');  
        }
    }
    
    
     function confirm_user()
    {
        $answer_script = array();
        if($this->input->post('survey_id') != '')
        {
            $query = $this->db->get_where('survery_result', array('survey_id' => $this->input->post('survey_id'), 'user_id' => $this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type')))->num_rows();
            if($query == 0)
            {
                $question_bank = $this->db->get_where('question', array('survey_id' => $this->input->post('survey_id')))->result_array();
                foreach ($question_bank as $question) 
                {
                    $container_2 = array();
                    if (isset($_POST[$question['question_id']]))
                    {
                        foreach ($this->input->post($question['question_id']) as $row) 
                        { 
                            $submitted_answer = "";  
                            array_push($container_2, strtolower($row));
                            $submitted_answer = json_encode($container_2);
                            $container = array(
                                "question_id" => $question['question_id'],
                                "submitted_answer" => $submitted_answer,
                            );
                        }
                    }else {
                        $container = array(
                            "question_id" => $question['question_id'],
                            "submitted_answer" => "",
                        );
                    }
                    array_push($answer_script, $container);
                }
                $insert_array = array(
                    'status' => 'success',
                    'survey_id' => $this->input->post('survey_id'),
                    'date' => $this->crud_model->formatDate(),
                    'year' => date('Y'),
                    'user_id' => $this->session->userdata('login_user_id'),
                    'user_type' => $this->session->userdata('login_type'),
                    'answer_script' => json_encode($answer_script)
                );
                $this->db->insert('survery_result', $insert_array);
                $this->notify_model->survey($this->input->post('survey_id'),$this->input->post('login_user_id'));
                $this->load->view('backend/send_email');  
            }else{
                $this->load->view('backend/send_email');  
            }
        }else{
            $this->load->view('backend/send_email');  
        }
    }
    
}