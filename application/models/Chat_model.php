<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chat_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
    
    
    function delete_chat($message_thread_code)
    {
        $type = '';
        if($this->session->userdata('login_type') == 'doctor' || $this->session->userdata('login_type') == 'admin'){
            $type = 'admin';
        }
        else if($this->session->userdata('login_type') == 'patient'){
            $type = 'patient';
        }else{
            $type = 'staff';
        }
        $original = $type."-".$this->session->userdata('login_user_id');
        $this->db->where('token', $message_thread_code);
        $this->db->where('original', $original);
        $this->db->delete('message');
    }

    function delete_single_chat($id)
    {
        
  
    
        $this->db->where('message_id', $id);
        $this->db->delete('message');
    



    }

    function unread($token, $current_user)
    {
     
     return $this->db->get_where('message', array('original'=>$current_user, 'token'=>$token, 'read_status'=>0))->num_rows();

    }

    function read_chat($token, $current_user)
    {
     
     $data['read_status'] = 1;
    

     $this->db->where('token',$token);
     $this->db->where('reciever',$current_user);
     return $this->db->update('message',$data);

    }

    
    
    function getChatTime()
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('d')." de ".$meses[date('n')-1].". a las ".date('H:iA');
    }
    
    function check_text($text)
    {
        $reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
        if(preg_match($reg_exUrl, $text, $url)) {
            if(strpos( $url[0], ":" ) === false){
                $link = 'http://'.$url[0];
            }else{
                $link = $url[0];
            }
            echo preg_replace($reg_exUrl, '<a target="_blank" href="'.$link.'" title="'.$url[0].'">'.$url[0].'</a>', $text);
        }else {
            echo $text;
        }
    }
    
    public function getInfo($username = '') 
    {
      	$credential = array('username' => $username);
      	$query = $this->db->get_where('admin', $credential);
      	if ($query->num_rows() > 0) 
      	{
	        $row = $query->row();
        	$data['type']  = 'admin';
        	$data['user_id']  = $row->admin_id;
        	return $data;
      	}

      	$query = $this->db->get_where('staff', $credential);
      	if ($query->num_rows() > 0) 
      	{
          	$row = $query->row();
          	$data['type']  = 'staff';
          	$data['user_id']  = $row->staff_id;
          	return $data;
      	}

          $query = $this->db->get_where('patient', $credential);
      	if ($query->num_rows() > 0) 
      	{
          	$row = $query->row();
          	$data['type']  = 'patient';
          	$data['user_id']  = $row->patient_id;
          	return $data;
      	}
    }
    
    function send_chat_message($token) 
    {
        $envia = '';
        if($this->session->userdata('login_type') == 'doctor' || $this->session->userdata('login_type') == 'admin'){
            $envia = 'admin';
        }else if($this->session->userdata('login_type') == 'patient'){
            $envia = 'patient';
        }else
        {
            $envia = 'staff';
        }
        $sender     = $envia . '-' . $this->session->userdata('login_user_id');
        include('public/apis/class.fileuploader.php');


    	$FileUploader = new FileUploader('img', array('uploadDir' => 'public/uploads/messages_files/'));
    	$upload_img = $FileUploader->upload();

    	if($upload_img['isSuccess'])
         {
            if(!empty($upload_img['files']))
            {
                $data_message['file_name'] =              $upload_img['files'][0]['name'];
                $data_message['original_file_name']     =    $upload_img['files'][0]['old_name'];
                $data_message['file_size']              = $upload_img['files'][0]['size2'];
                $data_message['file_type']              = $upload_img['files'][0]['extension'];

                $data_message2['file_name']              = $upload_img['files'][0]['name'];
                $data_message2['original_file_name']     = $upload_img['files'][0]['old_name'];
                $data_message2['file_size']              = $upload_img['files'][0]['size2'];
                $data_message2['file_type']              = $upload_img['files'][0]['extension'];
            
            }

    	} else {
            echo  $upload['warnings'];
    	}


        $FileUploader = new FileUploader('docs', array('uploadDir' => 'public/uploads/messages_files/'));
    	$upload = $FileUploader->upload();

    	if($upload['isSuccess'])
         {

            if(!empty($upload['files']))
            {
                $data_message['file_name']              = $upload['files'][0]['name'];
                $data_message['original_file_name']     = $upload['files'][0]['old_name'];
                $data_message['file_size']              = $upload['files'][0]['size2'];
                $data_message['file_type']              = $upload['files'][0]['extension'];

                $data_message2['file_name']              = $upload['files'][0]['name'];
                $data_message2['original_file_name']     = $upload['files'][0]['old_name'];
                $data_message2['file_size']              = $upload['files'][0]['size2'];
                $data_message2['file_type']              = $upload['files'][0]['extension'];

            
            }

    	} else {
        	echo  $upload['warnings'];
    	}

        

        $user_to_show1 = explode('-', $sender);
        $user_to_show = explode('-', $this->input->post('reciever'));


        if($user_to_show1[0] == 'admin' && $user_to_show[0] == 'staff')
        {
            $token = base64_encode(md5($sender."*".$this->input->post('reciever')));   
        }
        else if($user_to_show1[0] == 'admin' && $user_to_show[0] = 'admin')
        {
            $this->db->where('(sender = "'.$sender.'" AND reciever = "'.$this->input->post('reciever').'")');
            $this->db->or_where('(sender = "'.$this->input->post('reciever').'" AND reciever = "'.$sender.'")');
            $qry = $this->db->get('message');
            
            if($qry->num_rows() > 0)
            {
                $token = $qry->row()->token;  
            }
            else
            {
                $token = base64_encode(md5($sender."*".$this->input->post('reciever')));    
            }
        }else if($user_to_show1[0] == 'patient' && $user_to_show[0] = 'admin')
        {
            $this->db->where('(sender = "'.$sender.'" AND reciever = "'.$this->input->post('reciever').'")');
            $this->db->or_where('(sender = "'.$this->input->post('reciever').'" AND reciever = "'.$sender.'")');
            $qry = $this->db->get('message');
            
            if($qry->num_rows() > 0)
            {
                $token = $qry->row()->token;  
            }
            else
            {
                $token = base64_encode(md5($sender."*".$this->input->post('reciever')));    
            }
        }
      

        
        if($user_to_show1[0] == 'staff' && $user_to_show[0] = 'staff')
        {
            $token = base64_encode(md5($this->input->post('reciever')."*".$sender));   
        }
        else if($user_to_show1[0] == 'staff' && $user_to_show[0] = 'admin')
        {
            $this->db->where('(sender = "'.$sender.'" AND reciever = "'.$this->input->post('reciever').'")');
            $this->db->or_where('(sender = "'.$this->input->post('reciever').'" AND reciever = "'.$sender.'")');
            $qry = $this->db->get('message');
            
            if($qry->num_rows() > 0)
            {
                $token = $qry->row()->token;  
            }
            else
            {
                $token = base64_encode(md5($sender."*".$this->input->post('reciever')));    
            }
        }else if($user_to_show1[0] == 'staff' && $user_to_show[0] = 'patient')
        {
            $this->db->where('(sender = "'.$sender.'" AND reciever = "'.$this->input->post('reciever').'")');
            $this->db->or_where('(sender = "'.$this->input->post('reciever').'" AND reciever = "'.$sender.'")');
            $qry = $this->db->get('message');
            
            if($qry->num_rows() > 0)
            {
                $token = $qry->row()->token;  
            }
            else
            {
                $token = base64_encode(md5($sender."*".$this->input->post('reciever')));    
            }
        }
        

        $message ="";
        if($this->input->post('message') != "")
            $message    = $this->input->post('message');
        $timestamp  = $this->getChatTime();


       

        $data_message['token']                  = $token;
        
        $data_message['stiker']                  = $this->input->post('stiker');
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $data_message['reciever']               = $this->input->post('reciever');
        $data_message['original']               = $sender;
        $this->db->insert('message', $data_message);
        

       
        $data_message2['token']                  = $token;
        $data_message2['stiker']                  = $this->input->post('stiker');
        $data_message2['message']                = $message;
        $data_message2['sender']                 = $data_message['sender'];
        $data_message2['timestamp']              = $timestamp;
        $data_message2['reciever']               = $data_message['reciever'];
        $data_message2['original']               = $data_message['reciever'];
        $data_message2['c_message_id']           = $this->db->insert_id();
        


        $this->db->insert('message', $data_message2);
        
        $this->notify_model->new_chat($this->input->post('reciever'),$user_to_show[1]);
        $this->log_model->new_chat($this->input->post('reciever'),$user_to_show[1]);
    }

}