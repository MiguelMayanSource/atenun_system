<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accounts_model extends CI_Model 
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
    
    function get_profession($id_)
    {
        if($this->session->userdata('login_type') == 'doctor'){
            if($this->db->get_where('admin', array('admin_id' => $id_))->row()->owner == 1)
            {
           
                return 'Administrador';
            }else
            {
                return 'Doctor';

            }
        }else
        {
            //return $this->db->get_where('staff', array('staff_id' => $id_))->row()->charge;
            return '';
        }
    }

    function formatDate()
    {
        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('d')." de ".$meses[date('n')-1]." ".date('H:i A');
    }
    
    function get_full_name($type, $user_id)
    {
		if($type == 'doctor')
		$type = 'admin';

        $patient = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row();
        $first_name =$patient->first_name;
        $second_name = $patient->second_name;
        $third_name = $patient->third_name;
        $last_name  = $patient->last_name;
        $second_last_name =  $patient->second_last_name;
        $married_last_name =  $patient->married_last_name;

        if($third_name != "")
            return $first_name." ".$second_name." ".$third_name." ".$last_name." ".$second_last_name;
        else
            return $first_name." ".$second_name." ".$last_name." ".$second_last_name;

    }
    
    function delete_patient($patient_id)
    {
        
        /*
        $this->db->where('patient_id', $patient_id); 
        $photo = $this->db->get('patient')->row()->photo;
        
        unlink("public/uploads/patient_image/".$photo);
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('gyneco_obstetrics');
        
         $this->db->where('patient_id', $patient_id);
        $this->db->delete('cetosis_history');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('cart');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('appointment');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('allergie');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('nutritional_history');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('nutriological');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('no_pathological');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('laboratory_result');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('medication_history');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('vaccination');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('psychiatric');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('record_family');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('vital_sign');
        
       
        
        $this->db->where('patient_id', $patient_id);
        $info = $this->db->get('patient_file')->result_array();
        
        foreach ($info as $patients){
        
        unlink("public/uploads/patient_files/".$patients['name']);
        
        
            }
            


        $this->db->where('patient_id', $patient_id);
        $this->db->delete('patient_file');
        
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('patient');

        */
        
        $data['status']     =   0;
        $this->db->where('patient_id', $patient_id);
        $this->db->update('patient', $data);
        
    }
    
    function delete_staff($staff_id)
    {
        $this->log_model->delete_staff($staff_id);
        $data['status']     =   0;
        $this->db->where('staff_id',$staff_id);
        return $this->db->update('staff', $data);
    }
       
    function delete_doctor($admin_id)
    {
        
        $this->db->where('admin_id', $admin_id); 
        $photo = $this->db->get('admin')->row()->photo;
    
        
        $this->db->where('admin_id', $admin_id); 
        $signature = $this->db->get('admin')->row()->signature;
        
        $data['status']  =  0;
        $this->db->where('admin_id', $admin_id);
        $this->db->update('admin',$data);
    }
    
    function UR_exists($url)
    {
            $headers=get_headers($url);
            return stripos($headers[0],"200 OK")?true:false;
    }
    
    
     function create_patient()
    {
		include('public/apis/class.fileuploader.php');
		
		log_message('error','Responsable '.$this->input->post('responsable_id'));
        if($this->input->post('responsable_id') == 0 && $this->input->post('responsable_id') != "")
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            $FileUploader_photo = new FileUploader('photo_rep', array('uploadDir' => 'public/uploads/patient_image/'));
            $upload_photo = $FileUploader_photo->upload();
            if($upload_photo['isSuccess']) {
                $files = $upload_photo['files'];
            } else {
                $warningss = $upload_photo['warnings'];
            }
            
            if($_FILES['photo']['name'] != "")
            {
                $data['photo']        = $upload_photo['files'][0]['name'];
            }
            
			$password = $this->getPassword();
			$data['password']        = sha1($password);
			$data['username']        = $this->getUsername(strtolower($this->normalizeText($this->input->post('first_name_rep')." ".$this->input->post('last_name_rep'))));    
		    $data['client_status']          = $this->input->post('client_status');
            $data['first_name']             = $this->input->post('first_name_rep');
            $data['second_name']            = $this->input->post('second_name_rep'); 
            $data['third_name']             = $this->input->post('third_name_rep'); 
            $data['last_name']              = $this->input->post('last_name_rep');
            $data['second_last_name']       = $this->input->post('second_last_name_rep'); 
            $data['married_last_name']      = $this->input->post('married_last_name_rep'); 
           
            $data['phone']                  = $this->input->post('phone_rep');
            $data['phone_contact']          = $this->input->post('phone_contact_rep');
            $data['date_of_birth']          = $this->input->post('date_of_birth_rep'); 
            $data['dpi']                    = $this->input->post('dpi_rep'); 
            $data['nationality']            = $this->input->post('nationality_rep');
            $data['profession']             = $this->input->post('profession_rep');
            $data['workplace']              = $this->input->post('workplace_rep');
            $data['marital_status']         = $this->input->post('marital_status_rep');    
            $data['gender']                 = $this->input->post('gender_rep');  
           
            $data['address']                = trim($this->input->post('address_rep'));    
            $data['dpto']                   = $this->input->post("dpto_rep");
            $data['muni']                   = $this->input->post("muni_rep");
            $data['city']                   = $this->input->post("city_rep");
            $data['code_postal']            = $this->input->post("code_postal_rep");
            $data['n_nacional']             = $this->input->post("n_nacional_rep");
            $data['n_extranjero']           = $this->input->post("n_extranjero_rep");
            
            $data['name_nit_1']     = trim($this->input->post('name_nit_1_rep'));    
            $data['nit_1']          = $this->input->post("nit_1_rep");
            $data['address_nit_1']  = $this->input->post("address_nit_1_rep");
            $data['name_nit_2']     = trim($this->input->post('name_nit_2_rep'));    
            $data['nit_2']          = $this->input->post("nit_2_rep");
            $data['address_nit_2']  = $this->input->post("address_nit_2_rep");
            $data['name_nit_3']     = trim($this->input->post('name_nit_3_rep'));    
            $data['nit_3']          = $this->input->post("nit_3_rep");
            $data['address_nit_3']  = $this->input->post("address_nit_3_rep");
          
            $data['clinic_id']              = $this->session->userdata('current_clinic');
            $data['date']                   = $this->crud_model->formatDate();
            $data['category']               = $this->input->post('category');
            $this->db->insert('patient', $data);
            
            move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/patient_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
            $responsable_id = $this->db->insert_id();
            $this->log_model->new_patient($responsable_id);
			
        } else {
            $responsable_id = $this->input->post("responsable_id");
        }
        
        $md5 = md5(date('d-m-Y H:i:s'));
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/patient_image/'));
        $upload_photo = $FileUploader_photo->upload();
        if($upload_photo['isSuccess']) {
            $files = $upload_photo['files'];
        } else {
            $warningss = $upload_photo['warnings'];
        }
        
        if($_FILES['photo']['name'] != "")
        {
            $data['photo']        = $upload_photo['files'][0]['name'];
        }
        
		$password = $this->getPassword();
		$data['password']        = sha1($password);
		$data['username']        = $this->getUsername(strtolower($this->normalizeText($this->input->post('first_name')." ".$this->input->post('last_name'))));    
		   
        $data['first_name']             = $this->input->post('first_name');
        $data['second_name']            = $this->input->post('second_name'); 
        $data['third_name']             = $this->input->post('third_name'); 
        $data['last_name']              = $this->input->post('last_name');
        $data['second_last_name']       = $this->input->post('second_last_name'); 
        $data['married_last_name']      = $this->input->post('married_last_name'); 
       
        $data['phone']                  = $this->input->post('phone');
		$data['area_code']              = $this->input->post('area_code');
        $data['phone_contact']          = $this->input->post('phone_contact');
        $data['date_of_birth']          = $this->input->post('date_of_birth'); 
        $data['dpi']                    = $this->input->post('dpi'); 
        $data['nationality']            = $this->input->post('nationality');
        $data['profession']             = $this->input->post('profession');
        $data['workplace']              = $this->input->post('workplace');
        $data['marital_status']         = $this->input->post('marital_status');    
        $data['gender']                 = $this->input->post('gender');  
       
        $data['address']                = trim($this->input->post('address'));    
        $data['dpto']                   = $this->input->post("dpto");
        $data['muni']                   = $this->input->post("muni");
        $data['city']                   = $this->input->post("city");
        $data['code_postal']            = $this->input->post("code_postal");
        $data['n_nacional']             = $this->input->post("n_nacional");
        $data['n_extranjero']           = $this->input->post("n_extranjero");
        $data['email']           = $this->input->post("email");
        
        $data['name_nit_1']     = trim($this->input->post('name_nit_1'));    
        $data['nit_1']          = $this->input->post("nit_1");
        $data['address_nit_1']  = $this->input->post("address_nit_1");
        $data['name_nit_2']     = trim($this->input->post('name_nit_2'));    
        $data['nit_2']          = $this->input->post("nit_2");
        $data['address_nit_2']  = $this->input->post("address_nit_2");
        $data['name_nit_3']     = trim($this->input->post('name_nit_3'));    
        $data['nit_3']          = $this->input->post("nit_3");
        $data['address_nit_3']  = $this->input->post("address_nit_3");
        
        $data['responsable_id']  = $responsable_id;
      
        $data['clinic_id']              = $this->session->userdata('current_clinic');
        $data['date']                   = $this->crud_model->formatDate();
        $this->db->insert('patient', $data);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/patient_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
        $patient_id = $this->db->insert_id();

		$insurans = $this->input->post('insurances');
		for ($i=0; $i < sizeof($insurans) ; $i++) { 
			# code...
			$data = array(
				'insurance_id' =>$insurans[$i],
				'patient_id' =>$patient_id
			);
			$this->db->insert('insurance_patients',$data);
		}
		
		$entity = $this->input->post('entity_id');
		for ($i=0; $i < sizeof($entity) ; $i++) { 
			# code...
			$data = array(
				'entity_id' =>$entity[$i],
				'patient_id' =>$patient_id
			);
			$this->db->insert('entity_patients',$data);
		}


		
		if($this->input->post('email') != '')
		{
			//-- Enviando correo de bienvenida
			require("public/apis/class.phpmailer.php");
			$mail = new PHPMailer(); 
			$mail->IsHTML(true);
			$mail->IsMail();
			$mail->CharSet = 'UTF-8';
			$mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
			$mail->Subject = "Nueva cuenta registrada";
			$data_email = array(
				'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url()
			);
			$mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
			$mail->AddAddress($this->input->post('email'));
			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
		}
		

        $this->log_model->new_patient($patient_id);
        return base64_encode($patient_id);
    }
    
     function create_client()
    {
		include('public/apis/class.fileuploader.php');
		
    
        $md5 = md5(date('d-m-Y H:i:s'));
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/patient_image/'));
        $upload_photo = $FileUploader_photo->upload();
        if($upload_photo['isSuccess']) {
            $files = $upload_photo['files'];
        } else {
            $warningss = $upload_photo['warnings'];
        }
        
        if($_FILES['photo']['name'] != "")
        {
            $data['photo']        = $upload_photo['files'][0]['name'];
        }
        

		$password = $this->getPassword();
		$data['password']        = sha1($password);
		$data['username']        = $this->getUsername(strtolower($this->normalizeText($this->input->post('first_name')." ".$this->input->post('last_name'))));    
		   
        $data['first_name']             = $this->input->post('first_name');
        $data['second_name']            = $this->input->post('second_name'); 
        $data['third_name']             = $this->input->post('third_name'); 
        $data['last_name']              = $this->input->post('last_name');
        $data['second_last_name']       = $this->input->post('second_last_name'); 
        $data['married_last_name']      = $this->input->post('married_last_name'); 
       
        $data['phone']                  = $this->input->post('phone');
		$data['area_code']              = $this->input->post('area_code');
        $data['phone_contact']          = $this->input->post('phone_contact');
        $data['date_of_birth']          = $this->input->post('date_of_birth'); 
        $data['dpi']                    = $this->input->post('dpi'); 
        $data['nationality']            = $this->input->post('nationality');
        $data['profession']             = $this->input->post('profession');
        $data['workplace']              = $this->input->post('workplace');
        $data['marital_status']         = $this->input->post('marital_status');    
        $data['gender']                 = $this->input->post('gender');  
       
        $data['address']                = trim($this->input->post('address'));    
        $data['dpto']                   = $this->input->post("dpto");
        $data['muni']                   = $this->input->post("muni");
        $data['city']                   = $this->input->post("city");
        $data['code_postal']            = $this->input->post("code_postal");
        $data['n_nacional']             = $this->input->post("n_nacional");
        $data['n_extranjero']           = $this->input->post("n_extranjero");
        $data['email']           = $this->input->post("email");
        
        $data['name_nit_1']     = trim($this->input->post('first_name'));    
        $data['nit_1']          = $this->input->post("nit");
        $data['address_nit_1']  = $this->input->post("address_nit_1");
        $data['name_nit_2']     = trim($this->input->post('name_nit_2'));    
        $data['nit_2']          = $this->input->post("nit_2");
        $data['address_nit_2']  = $this->input->post("address_nit_2");
        $data['name_nit_3']     = trim($this->input->post('name_nit_3'));    
        $data['nit_3']          = $this->input->post("nit_3");
        $data['address_nit_3']  = $this->input->post("address_nit_3");
        
        $data['responsable_id']  = $responsable_id;
       $data['client_status']  = 1;
        
        $data['clinic_id']              = $this->session->userdata('current_clinic');
        $data['date']                   = $this->crud_model->formatDate();
        $this->db->insert('patient', $data);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/patient_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
        $patient_id = $this->db->insert_id();

		
        $this->log_model->new_patient($patient_id);
        return base64_encode($patient_id);
    }
    function update_patient($patient_id)
    {
		include('public/apis/class.fileuploader.php');
		if($this->input->post('responsable_id') != 0)
        {
            
            $md5 = md5(date('d-m-Y H:i:s'));
			$FileUploader_photo = new FileUploader('photo_rep', array('uploadDir' => 'public/uploads/patient_image/'));
			$upload_photo = $FileUploader_photo->upload();
			log_message('error','photo rep '.json_encode($upload_photo));
			if($upload_photo['isSuccess']) {
				$files = $upload_photo['files'];
			} else {
				$warningss = $upload_photo['warnings'];
			}
			
			if($upload_photo['files'][0]['name'] != "")
			{
				$dataRep['photo']        = $upload_photo['files'][0]['name'];
			}
            
            $dataRep['first_name']             = $this->input->post('first_name_rep');
            $dataRep['second_name']            = $this->input->post('second_name_rep'); 
            $dataRep['third_name']             = $this->input->post('third_name_rep'); 
            $dataRep['last_name']              = $this->input->post('last_name_rep');
            $dataRep['second_last_name']       = $this->input->post('second_last_name_rep'); 
            $dataRep['married_last_name']      = $this->input->post('married_last_name_rep'); 
           
            $dataRep['phone']                  = $this->input->post('phone_rep');
            $dataRep['phone_contact']          = $this->input->post('phone_contact_rep');
            $dataRep['date_of_birth']          = $this->input->post('date_of_birth_rep'); 
            $dataRep['dpi']                    = $this->input->post('dpi_rep'); 
            $dataRep['nationality']            = $this->input->post('nationality_rep');
            $dataRep['profession']             = $this->input->post('profession_rep');
            $dataRep['workplace']              = $this->input->post('workplace_rep');
            $dataRep['marital_status']         = $this->input->post('marital_status_rep');    
            $dataRep['gender']                 = $this->input->post('gender_rep');  
		

            $dataRep['address']                = trim($this->input->post('address_rep'));    
            $dataRep['dpto']                   = $this->input->post("dpto_rep");
            $dataRep['muni']                   = $this->input->post("muni_rep");
            $dataRep['city']                   = $this->input->post("city_rep");
            $dataRep['code_postal']            = $this->input->post("code_postal_rep");
            $dataRep['n_nacional']             = $this->input->post("n_nacional_rep");
            $dataRep['n_extranjero']           = $this->input->post("n_extranjero_rep");
            
            
            $dataRep['name_nit_1']     = trim($this->input->post('name_nit_1_rep'));    
            $dataRep['nit_1']          = $this->input->post("nit_1_rep");
            $dataRep['address_nit_1']  = $this->input->post("address_nit_1_rep");
            $dataRep['name_nit_2']     = trim($this->input->post('name_nit_2_rep'));    
            $dataRep['nit_2']          = $this->input->post("nit_2_rep");
            $dataRep['address_nit_2']  = $this->input->post("address_nit_2_rep");
            $dataRep['name_nit_3']     = trim($this->input->post('name_nit_3_rep'));    
            $dataRep['nit_3']          = $this->input->post("nit_3_rep");
            $dataRep['address_nit_3']  = $this->input->post("address_nit_3_rep"); 
            
            $dataRep['clinic_id']              = $this->session->userdata('current_clinic');
            $dataRep['date']                   = $this->crud_model->formatDate();
            $dataRep['category']               = $this->input->post('category');

            $this->db->where('patient_id',$this->input->post("responsable_id"));
			$this->db->update('patient',$dataRep);

			$this->db->where('patient_id',$this->input->post("responsable_id"));
			$this->db->delete('insurance_patients');
			$insurans = $this->input->post('insurances_rep');
			for ($i=0; $i < sizeof($insurans) ; $i++) { 
				# code...
				$dataI = array(
					'insurance_id' =>$insurans[$i],
					'patient_id' =>$this->input->post("responsable_id")
				);

				$this->db->insert('insurance_patients',$dataI);
			}
            
            move_uploaded_file($_FILES['photo_rep']['tmp_name'], 'public/uploads/patient_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
            $this->log_model->update_patient($this->input->post('responsable_id'));
			
			
        }
        if(count($this->input->post("entitys_id"))>0){
			$verify = $this->db->get_where("entity_patients",array("patient_id"=>$patient_id))->num_rows();
			$dataentity["entitys_id"] = json_encode($this->input->post("entitys_id"));
			if($verify> 0){
				$this->db->where("patient_id", $patient_id);
				$this->db->update("entity_patients",$dataentity);
			}
			else {
				$dataentity["patient_id"] = $patient_id;
				$this->db->insert("entity_patients",$dataentity);
			}
		}
        
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/patient_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']        = $upload_photo['files'][0]['name'];
        }
        
        $data['first_name']             = $this->input->post('first_name');
        $data['second_name']            = $this->input->post('second_name'); 
        $data['third_name']             = $this->input->post('third_name'); 
        $data['last_name']              = $this->input->post('last_name');
        $data['second_last_name']       = $this->input->post('second_last_name'); 
        $data['married_last_name']      = $this->input->post('married_last_name'); 
       
        $data['phone']                  = $this->input->post('phone');
        $data['phone_contact']          = $this->input->post('phone_contact');
        $data['date_of_birth']          = $this->input->post('date_of_birth'); 
        $data['dpi']                    = $this->input->post('dpi'); 
        $data['nationality']            = $this->input->post('nationality');
        $data['profession']             = $this->input->post('profession');
        $data['workplace']              = $this->input->post('workplace');
        $data['marital_status']         = $this->input->post('marital_status');    
        $data['gender']                 = $this->input->post('gender');  
       
        $data['address']                = trim($this->input->post('address'));    
        $data['dpto']                   = $this->input->post("dpto");
        $data['muni']                   = $this->input->post("muni");
        $data['city']                   = $this->input->post("city");
        $data['code_postal']            = $this->input->post("code_postal");
        $data['n_nacional']             = $this->input->post("n_nacional");
        $data['n_extranjero']           = $this->input->post("n_extranjero");
		$data['email']           = $this->input->post("email");
        
        $data['name_nit_1']     = trim($this->input->post('name_nit_1'));    
        $data['nit_1']          = $this->input->post("nit_1");
        $data['address_nit_1']  = $this->input->post("address_nit_1");
        $data['name_nit_2']     = trim($this->input->post('name_nit_2'));    
        $data['nit_2']          = $this->input->post("nit_2");
        $data['address_nit_2']  = $this->input->post("address_nit_2");
        $data['name_nit_3']     = trim($this->input->post('name_nit_3'));    
        $data['nit_3']          = $this->input->post("nit_3");
        $data['address_nit_3']  = $this->input->post("address_nit_3");
        
        $data['responsable_id']  = $this->input->post('responsable_id');
      
        
        $data['clinic_id']              = $this->session->userdata('current_clinic');
        $data['date']                   = $this->crud_model->formatDate();
		$this->db->where('patient_id',$patient_id);
		$this->db->update('patient',$data);
       
        $this->log_model->update_patient($patient_id);

		$this->db->where('patient_id',$patient_id);
		$this->db->delete('insurance_patients');
		$insurans = $this->input->post('insurances');
		for ($i=0; $i < sizeof($insurans) ; $i++) { 
			# code...
			$data = array(
				'insurance_id' =>$insurans[$i],
				'patient_id' =>$patient_id
			);

			$this->db->insert('insurance_patients',$data);
		}
		



		$this->db->where('patient_id',$patient_id);
		$this->db->delete('entity_patients');
		$entitys_ids = $this->input->post('entity_id');
		for ($i=0; $i < sizeof($entitys_ids) ; $i++) { 
			# code...
			$data = array(
				'entity_id' =>$entitys_ids[$i],
				'patient_id' =>$patient_id
			);

			$this->db->insert('entity_patients',$data);
		}
        
    }
        
    
    function normalizeText($string) 
    {
    	$table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
    	);
    	return strtr($string, $table);
	}
	
    function getPassword()
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars),0,8);
        return strtoupper($password);
    }
    
    function gender($id_)
    {
        if($this->db->get_where('admin', array('admin_id' => $id_))->row()->gender == 'F'){
            return 'Dra.';
        }else{
            return 'Dr.';
        }
    }
    

    function new_staff()
    {
        include('public/apis/class.fileuploader.php');
        
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/staff_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']        = $upload_photo['files'][0]['name'];
        }
        $password = $this->getPassword();
        
        $data['category']        = $this->input->post('category');
        $data['first_name']      = $this->input->post('first_name');
        $data['last_name']       = $this->input->post('last_name');
        $data['date_of_birth']   = $this->input->post('date_of_birth');   
        $data['email']           = $this->input->post('email');  
        $data['phone']           = $this->input->post('phone');    
        $data['dpi']             = $this->input->post('dpi'); 
        $data['gender']          = $this->input->post('gender');  
        $data['marital_status']  = $this->input->post('marital_status');
        $data['role_id']         = $this->input->post('role_id');
        $data['departamento_id'] = $this->input->post('departamento_id');   
        $data['municipio_id']    = $this->input->post('municipio_id');
        $data['address']         = $this->input->post('address');
        $data['country']         = $this->input->post('country');
        $data['city']            = $this->input->post('city');
        $data['postal_code']     = $this->input->post('postal_code');
        $data['outdoor_number']  = $this->input->post('outdoor_number');
        $data['interior_number'] = $this->input->post('interior_number');
        
        $data['address_company']         = $this->input->post('address_company');
        $data['state_company']           = $this->input->post('state_company');
        $data['country_company']         = $this->input->post('country_company');
        $data['city_company']            = $this->input->post('city_company');
        $data['postal_code_company']     = $this->input->post('postal_code_company');
        $data['outdoor_number_company']  = $this->input->post('outdoor_number_company');
        $data['interior_number_company'] = $this->input->post('interior_number_company');
        $data['date_work_start']         = $this->input->post('date_work_start');
        $data['salary']                  = $this->input->post('salary'); 
        $data['bonus']                   = $this->input->post('bonus');
        $data['charge']                  = $this->input->post('charge'); 
        $data['date_contract_start']     = $this->input->post('date_contract_start');
        $data['type_workday']            = $this->input->post('type_workday');
        $data['payment_type']            = $this->input->post('payment_type');
        $data['work_time']               = $this->input->post('work_time');
        $data['date_work_end']           = $this->input->post('date_work_end');
        
        $data['profession']        = $this->input->post('profession');
        $data['academic_title']    = $this->input->post('academic_title');
        $data['place_study']       = $this->input->post('place_study');
        $data['collegiate_number'] = $this->input->post('collegiate_number');
        $data['date_study_start']  = $this->input->post('date_study_start');
        $data['date_study_end']    = $this->input->post('date_study_end');
        $data['comments']          = $this->input->post('comments');
        
        $data['password']        = sha1($password);
        $data['username']        = $this->getUsername(strtolower($this->normalizeText($this->input->post('first_name')." ".$this->input->post('last_name'))));    
        $data['status']          = 1;   
        $data['account']         = 1;
        $data['since']           = $this->formatDate();   
        $data['clinic_id']       = $this->session->userdata('current_clinic');

        $this->db->insert('staff', $data);
        $staff_id = $this->db->insert_id();
        $this->log_model->create_staff($staff_id);
        
        //log_message("error", "-----------------------------------");
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	log_message("error", "Resultados: ".json_encode($upload));
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_contract', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "contract";
    	        $dataDocs['expiration'] = $this->input->post('expiration_contract');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_health', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "health";
    	        $dataDocs['expiration'] = $this->input->post('expiration_health');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_criminal', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "criminal";
    	        $dataDocs['expiration'] = $this->input->post('expiration_criminal');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_police', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "police";
    	        $dataDocs['expiration'] = $this->input->post('expiration_police');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_employment', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "employment";
    	        $dataDocs['expiration'] = $this->input->post('expiration_employment');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_recommend', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "recommend";
    	        $dataDocs['expiration'] = $this->input->post('expiration_recommend');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_renas', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "renas";
    	        $dataDocs['expiration'] = $this->input->post('expiration_renas');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_academic', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "academic";
    	        $dataDocs['expiration'] = $this->input->post('expiration_academic');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        
        //-- Enviando correo de bienvenida
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
        $mail->Subject = "Nueva cuenta registrada";
        $data_email = array(
            'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url()
        );
        $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
        $mail->AddAddress($this->input->post('email'));
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

       
        
    }
    
    function edit_staff($staff_id)
    {
        include('public/apis/class.fileuploader.php');
        
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/staff_image/'));
    	$upload_photo = $FileUploader_photo->upload();

    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']        = $upload_photo['files'][0]['name'];
        }
        
        $data['first_name']     = $this->input->post('first_name');
        $data['last_name']      = $this->input->post('last_name');
        $data['date_of_birth']  = $this->input->post('date_of_birth');   
        $data['email']          = $this->input->post('email');  
        $data['phone']          = $this->input->post('phone');    
        $data['dpi']            = $this->input->post('dpi'); 
        $data['gender']         = $this->input->post('gender');
        $data['marital_status'] = $this->input->post('marital_status');
        $data['role_id']        = $this->input->post('role_id');
      
        
        $data['address']         = $this->input->post('address');
        $data['country']         = $this->input->post('country');
        $data['departamento_id'] = $this->input->post('departamento_id');
        $data['municipio_id']    = $this->input->post('municipio_id');
        $data['city']            = $this->input->post('city');
        $data['postal_code']     = $this->input->post('postal_code');
        $data['outdoor_number']  = $this->input->post('outdoor_number');
        $data['interior_number'] = $this->input->post('interior_number');
        
        $data['address_company']         = $this->input->post('address_company');
        $data['state_company']           = $this->input->post('state_company');
        $data['country_company']         = $this->input->post('country_company');
        $data['city_company']            = $this->input->post('city_company');
        $data['postal_code_company']     = $this->input->post('postal_code_company');
        $data['outdoor_number_company']  = $this->input->post('outdoor_number_company');
        $data['interior_number_company'] = $this->input->post('interior_number_company');
        $data['date_work_start']         = $this->input->post('date_work_start');
        $data['salary']                  = $this->input->post('salary'); 
        $data['bonus']                   = $this->input->post('bonus');
        $data['charge']                  = $this->input->post('charge'); 
        $data['date_contract_start']     = $this->input->post('date_contract_start');
        $data['type_workday']            = $this->input->post('type_workday');
        $data['payment_type']            = $this->input->post('payment_type');
        $data['work_time']               = $this->input->post('work_time');
        $data['date_work_end']           = $this->input->post('date_work_end');
        
        $data['profession']        = $this->input->post('profession');
        $data['academic_title']    = $this->input->post('academic_title');
        $data['place_study']       = $this->input->post('place_study');
        $data['collegiate_number'] = $this->input->post('collegiate_number');
        $data['date_study_start']  = $this->input->post('date_study_start');
        $data['date_study_end']    = $this->input->post('date_study_end');
        $data['comments']          = $this->input->post('comments');

        $this->db->where('staff_id', $staff_id);
        $this->db->update('staff', $data);
        
        //log_message("error", "-----------------------------------");
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_contract', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "contract";
    	        $dataDocs['expiration'] = $this->input->post('expiration_contract');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_health', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "health";
    	        $dataDocs['expiration'] = $this->input->post('expiration_health');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_criminal', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "criminal";
    	        $dataDocs['expiration'] = $this->input->post('expiration_criminal');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_police', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "police";
    	        $dataDocs['expiration'] = $this->input->post('expiration_police');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_employment', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "employment";
    	        $dataDocs['expiration'] = $this->input->post('expiration_employment');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_recommend', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "recommend";
    	        $dataDocs['expiration'] = $this->input->post('expiration_recommend');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_renas', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "renas";
    	        $dataDocs['expiration'] = $this->input->post('expiration_renas');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_academic', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "academic";
    	        $dataDocs['expiration'] = $this->input->post('expiration_academic');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	
    	return $staff_id;
    }
    
    function new_provider_single()
    {
        include('public/apis/class.fileuploader.php');
		$FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/staff_image/'));
    	$upload_photo = $FileUploader_photo->upload();

    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']        = $upload_photo['files'][0]['name'];
        }


        $password = $this->getPassword();
        
        $data['category']        = 3;
        $data['first_name']      = $this->input->post('full_name');
        $data['last_name']       = $this->input->post('tradename');
        $data['email']           = $this->input->post('email');  
        $data['phone']           = $this->input->post('phone_1'); 
        $data['departamento_id'] = $this->input->post('departamento_id'); 
        $data['municipio_id']    = $this->input->post('municipio_id');  
        $data['address']         = $this->input->post('address');
        $data['country']         = $this->input->post('country');
        $data['city']            = $this->input->post('city');
        $data['postal_code']     = $this->input->post('postal_code');
        $data['outdoor_number']  = $this->input->post('outdoor_number');
        $data['interior_number'] = $this->input->post('interior_number');
        
        $data['password']        = sha1($password);
        $data['username']        = $this->getUsername(strtolower($this->normalizeText($data['first_name']." ".$data['last_name'])));    
        $data['status']          = 1;   
        $data['account']         = 1;
        $data['since']           = $this->formatDate();   
        $data['clinic_id']       = $this->session->userdata('current_clinic');

        $this->db->insert('staff', $data);
        $staff_id = $this->db->insert_id();
        $this->log_model->create_staff($staff_id);
        
        $dataProv['staff_id']             = $staff_id;
        $dataProv['type_provider']        = 1;
        $dataProv['application_date']     = $this->input->post('application_date');
        $dataProv['fiscal_address']       = $this->input->post('fiscal_address');
        $dataProv['commercial_address']   = $this->input->post('commercial_address');
        $dataProv['website']              = $this->input->post('website');
        $dataProv['nit']                  = $this->input->post('nit');
        $dataProv['area_code']            = $this->input->post('area_code');
        $dataProv['phone_2']              = $this->input->post('phone_2');
        $dataProv['phone_3']              = $this->input->post('phone_3');
        $dataProv['full_name_legal']      = $this->input->post('full_name_legal');
        $dataProv['dpi_legal']            = $this->input->post('dpi_legal');
        $dataProv['commercial_patent']    = $this->input->post('commercial_patent');
        $dataProv['full_name_represent']  = $this->input->post('full_name_represent');
        $dataProv['phone_represent']      = $this->input->post('phone_represent');
        $dataProv['email_represent']      = $this->input->post('email_represent');
        $dataProv['full_name_manager']    = $this->input->post('full_name_manager');
        $dataProv['phone_manager']        = $this->input->post('phone_manager');
        $dataProv['email_manager']        = $this->input->post('email_manager');
        $dataProv['full_name_accounts']   = $this->input->post('full_name_accounts');
        $dataProv['phone_accounts']       = $this->input->post('phone_accounts');
        $dataProv['email_accounts']       = $this->input->post('email_accounts');
        $dataProv['full_name_billing']    = $this->input->post('full_name_billing');
        $dataProv['phone_billing']        = $this->input->post('phone_billing');
        $dataProv['email_billing']        = $this->input->post('email_billing');
        $dataProv['full_name_finance']    = $this->input->post('full_name_finance');
        $dataProv['phone_finance']        = $this->input->post('phone_finance');
        $dataProv['email_finance']        = $this->input->post('email_finance');
        $dataProv['full_name_accounting'] = $this->input->post('full_name_accounting');
        $dataProv['phone_accounting']     = $this->input->post('phone_accounting');
        $dataProv['email_accounting']     = $this->input->post('email_accounting');
        $dataProv['provider_service_id']  = $this->input->post('provider_service_id');
        $dataProv['apply_fiscal']         = $this->input->post('apply_fiscal');
        $dataProv['fiscal_data']          = $this->input->post('fiscal_data');
        $this->db->insert('provider_data', $dataProv);
        
        for ($i=0; $i<count($this->input->post('first_name_reference')); $i++) {
            $first_name_reference = $this->input->post('first_name_reference')[$i];
            if ($first_name_reference != '') {
                $dataCom['first_name']     = $first_name_reference;
                $dataCom['last_name']      = $this->input->post('last_name_reference')[$i];
                $dataCom['phone']          = $this->input->post('first_name_reference')[$i];
                $dataCom['company_person'] = $this->input->post('company_person_reference')[$i];
                $dataCom['staff_id']       = $staff_id;
                $this->db->insert('commercial_reference', $dataCom);
            }
        }
        
        for ($i=0; $i<count($this->input->post('bank_id')); $i++) {
            $account_name = $this->input->post('account_name')[$i];
            $account_no = $this->input->post('account_no')[$i];
            if ($account_name != '' && $account_no != '') {
                $dataBank['bank_id']         = $this->input->post('bank_id')[$i];
                $dataBank['account_name']    = $account_name;
                $dataBank['currency_id']     = $this->input->post('currency_id')[$i];
                $dataBank['account_no']      = $account_no;
                $dataBank['account_type_id'] = $this->input->post('account_type_id')[$i];
                $dataBank['staff_id']        = $staff_id;
                $this->db->insert('bank_reference', $dataBank);
            }
        }
        
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        //-- Enviando correo de bienvenida
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
        $mail->Subject = "Nueva cuenta registrada";
        $data_email = array(
            'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url()
        );
        $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
        $mail->AddAddress($this->input->post('email'));
       
		/*if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
		*/
        
        
        return $staff_id;
    }
    
    
    function edit_provider_single($staff_id)
    {
        include('public/apis/class.fileuploader.php');
		$FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/staff_image/'));
    	$upload_photo = $FileUploader_photo->upload();

    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']        = $upload_photo['files'][0]['name'];
        }
        $password = $this->getPassword();
        
        $data['category']        = 3;
        $data['first_name']      = $this->input->post('full_name');
        $data['last_name']       = $this->input->post('tradename');
        $data['email']           = $this->input->post('email');  
        $data['phone']           = $this->input->post('phone_1'); 
        $data['departamento_id'] = $this->input->post('departamento_id');  
        $data['municipio_id']    = $this->input->post('municipio_id');  
        $data['address']         = $this->input->post('address');
        $data['country']         = $this->input->post('country');
        $data['city']            = $this->input->post('city');
        $data['postal_code']     = $this->input->post('postal_code');
        $data['outdoor_number']  = $this->input->post('outdoor_number');
        $data['interior_number'] = $this->input->post('interior_number');
        
        $data['password']        = sha1($password);
        $data['username']        = $this->getUsername(strtolower($this->normalizeText($data['first_name']." ".$data['last_name'])));    
        $data['status']          = 1;   
        $data['account']         = 1;
        $data['since']           = $this->formatDate();   
        $data['clinic_id']       = $this->session->userdata('current_clinic');

        $this->db->where('staff_id', $staff_id);
        $this->db->update('staff', $data);
        
        $dataProv['type_provider']        = 1;
        $dataProv['application_date']     = $this->input->post('application_date');
        $dataProv['fiscal_address']       = $this->input->post('fiscal_address');
        $dataProv['commercial_address']   = $this->input->post('commercial_address');
        $dataProv['website']              = $this->input->post('website');
        $dataProv['nit']                  = $this->input->post('nit');
        $dataProv['area_code']            = $this->input->post('area_code');
        $dataProv['phone_2']              = $this->input->post('phone_2');
        $dataProv['phone_3']              = $this->input->post('phone_3');
        $dataProv['full_name_legal']      = $this->input->post('full_name_legal');
        $dataProv['dpi_legal']            = $this->input->post('dpi_legal');
        $dataProv['commercial_patent']    = $this->input->post('commercial_patent');
        $dataProv['full_name_represent']  = $this->input->post('full_name_represent');
        $dataProv['phone_represent']      = $this->input->post('phone_represent');
        $dataProv['email_represent']      = $this->input->post('email_represent');
        $dataProv['full_name_manager']    = $this->input->post('full_name_manager');
        $dataProv['phone_manager']        = $this->input->post('phone_manager');
        $dataProv['email_manager']        = $this->input->post('email_manager');
        $dataProv['full_name_accounts']   = $this->input->post('full_name_accounts');
        $dataProv['phone_accounts']       = $this->input->post('phone_accounts');
        $dataProv['email_accounts']       = $this->input->post('email_accounts');
        $dataProv['full_name_billing']    = $this->input->post('full_name_billing');
        $dataProv['phone_billing']        = $this->input->post('phone_billing');
        $dataProv['email_billing']        = $this->input->post('email_billing');
        $dataProv['full_name_finance']    = $this->input->post('full_name_finance');
        $dataProv['phone_finance']        = $this->input->post('phone_finance');
        $dataProv['email_finance']        = $this->input->post('email_finance');
        $dataProv['full_name_accounting'] = $this->input->post('full_name_accounting');
        $dataProv['phone_accounting']     = $this->input->post('phone_accounting');
        $dataProv['email_accounting']     = $this->input->post('email_accounting');
        $dataProv['provider_service_id']  = $this->input->post('provider_service_id');
        $dataProv['apply_fiscal']         = $this->input->post('apply_fiscal');
        $dataProv['fiscal_data']          = $this->input->post('fiscal_data');
        $this->db->where('staff_id', $staff_id);
        $this->db->update('provider_data', $dataProv);
        
        for ($i=0; $i<count($this->input->post('commercial_reference_id')); $i++) {
            $first_name_reference = $this->input->post('first_name_reference')[$i];
            if ($first_name_reference != '') {
                $dataCom['first_name']     = $first_name_reference;
                $dataCom['last_name']      = $this->input->post('last_name_reference')[$i];
                $dataCom['phone']          = $this->input->post('first_name_reference')[$i];
                $dataCom['company_person'] = $this->input->post('company_person_reference')[$i];
                $dataCom['staff_id']       = $staff_id;
                $this->db->where('commercial_reference_id', $this->input->post('commercial_reference_id')[$i]);
                $this->db->update('commercial_reference', $dataCom);
            }
        }
        
        for ($i=0; $i<count($this->input->post('bank_id')); $i++) {
            $account_name = $this->input->post('account_name')[$i];
            $account_no = $this->input->post('account_no')[$i];
            if ($account_name != '' && $account_no != '') {
                $dataBank['bank_id']         = $this->input->post('bank_id')[$i];
                $dataBank['account_name']    = $account_name;
                $dataBank['currency_id']     = $this->input->post('currency_id')[$i];
                $dataBank['account_no']      = $account_no;
                $dataBank['account_type_id'] = $this->input->post('account_type_id')[$i];
                $dataBank['staff_id']        = $staff_id;
                $this->db->where('bank_reference_id', $this->input->post('bank_reference_id')[$i]);
                $this->db->update('bank_reference', $dataBank);
            }
        }
        
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        
        return $staff_id;
    }
    
	function resend_credentials($staff_id) {
		  //-- Enviando correo de bienvenida
		  $staff = $this->db->get_where('staff', array('staff_id' => $staff_id))->row();
		  $password = $this->getPassword();

		  $this->db->where('staff_id', $staff_id);
		  $this->db->update('staff', array('password' => sha1($password)));

		  require("public/apis/class.phpmailer.php");
		  $mail = new PHPMailer(); 
		  $mail->IsHTML(true);
		  $mail->IsMail();
		  $mail->CharSet = 'UTF-8';
		  $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
		  $mail->Subject = "Nueva cuenta registrada";
		  $data_email = array(
			  'email_msg' => "¡Hola ".str_replace(' ', '', $staff['first_name'])."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$staff['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url()
		  );
		  $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
		  $mail->AddAddress($staff['email']);
		  if(!$mail->Send()) {
			  echo "Mailer Error: " . $mail->ErrorInfo;
		  }

	}
	
    function new_provider_legal() {
        include('public/apis/class.fileuploader.php');
		$FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/staff_image/'));
    	$upload_photo = $FileUploader_photo->upload();

    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']        = $upload_photo['files'][0]['name'];
        }
        $password = $this->getPassword();
        
        $data['category']        = 3;
        $data['first_name']      = $this->input->post('full_name');
        $data['last_name']       = $this->input->post('tradename');
        $data['email']           = $this->input->post('email');  
        $data['phone']           = $this->input->post('phone_1'); 
        $data['departamento_id'] = $this->input->post('departamento_id');  
        $data['municipio_id']    = $this->input->post('municipio_id');  
        $data['address']         = $this->input->post('address');
        $data['country']         = $this->input->post('country');
        $data['city']            = $this->input->post('city');
        $data['postal_code']     = $this->input->post('postal_code');
        $data['outdoor_number']  = $this->input->post('outdoor_number');
        $data['interior_number'] = $this->input->post('interior_number');
        $data['charge']          = $this->input->post('charge');
        $data['password']        = sha1($password);
        $data['username']        = $this->getUsername(strtolower($this->normalizeText($data['first_name']." ".$data['last_name'])));    
        $data['status']          = 1;   
        $data['account']         = 1;
        $data['since']           = $this->formatDate();   
        $data['clinic_id']       = $this->session->userdata('current_clinic');

        $this->db->insert('staff', $data);
        $staff_id = $this->db->insert_id();
        $this->log_model->create_staff($staff_id);
        
        $dataProv['staff_id']             = $staff_id;
        $dataProv['type_provider']        = 2;
        $dataProv['application_date']     = $this->input->post('application_date');
        $dataProv['fiscal_address']       = $this->input->post('fiscal_address');
        $dataProv['commercial_address']   = $this->input->post('commercial_address');
        $dataProv['website']              = $this->input->post('website');
        $dataProv['nit']                  = $this->input->post('nit');
        $dataProv['area_code']            = $this->input->post('area_code');
        $dataProv['phone_2']              = $this->input->post('phone_2');
        $dataProv['phone_3']              = $this->input->post('phone_3');
        $dataProv['phone_contact']        = $this->input->post('phone_contact');
        $dataProv['full_name_legal']      = $this->input->post('full_name_legal');
        $dataProv['dpi_legal']            = $this->input->post('dpi_legal');
        $dataProv['commercial_patent']    = $this->input->post('commercial_patent');
        $dataProv['nit_legal']            = $this->input->post('nit_legal');
        $dataProv['full_name_represent']  = $this->input->post('full_name_represent');
        $dataProv['phone_represent']      = $this->input->post('phone_represent');
        $dataProv['email_represent']      = $this->input->post('email_represent');
        $dataProv['full_name_manager']    = $this->input->post('full_name_manager');
        $dataProv['phone_manager']        = $this->input->post('phone_manager');
        $dataProv['email_manager']        = $this->input->post('email_manager');
        $dataProv['full_name_accounts']   = $this->input->post('full_name_accounts');
        $dataProv['phone_accounts']       = $this->input->post('phone_accounts');
        $dataProv['email_accounts']       = $this->input->post('email_accounts');
        $dataProv['full_name_billing']    = $this->input->post('full_name_billing');
        $dataProv['phone_billing']        = $this->input->post('phone_billing');
        $dataProv['email_billing']        = $this->input->post('email_billing');
        $dataProv['full_name_finance']    = $this->input->post('full_name_finance');
        $dataProv['phone_finance']        = $this->input->post('phone_finance');
        $dataProv['email_finance']        = $this->input->post('email_finance');
        $dataProv['full_name_accounting'] = $this->input->post('full_name_accounting');
        $dataProv['phone_accounting']     = $this->input->post('phone_accounting');
        $dataProv['email_accounting']     = $this->input->post('email_accounting');
        $dataProv['provider_service_id']  = $this->input->post('provider_service_id');
        $dataProv['apply_fiscal']         = $this->input->post('apply_fiscal_legal');
        $dataProv['fiscal_data']          = $this->input->post('fiscal_data');
        $dataProv['credit_days']          = $this->input->post('credit_days');
        $this->db->insert('provider_data', $dataProv);
        
        for ($i=0; $i<count($this->input->post('first_name_reference')); $i++) {
            $first_name_reference = $this->input->post('first_name_reference')[$i];
            if ($first_name_reference != '') {
                $dataCom['first_name']     = $first_name_reference;
                $dataCom['last_name']      = $this->input->post('last_name_reference')[$i];
                $dataCom['phone']          = $this->input->post('first_name_reference')[$i];
                $dataCom['company_person'] = $this->input->post('company_person_reference')[$i];
                $dataCom['staff_id']       = $staff_id;
                $this->db->insert('commercial_reference', $dataCom);
            }
        }
        
        for ($i=0; $i<count($this->input->post('bank_id')); $i++) {
            $account_name = $this->input->post('account_name')[$i];
            $account_no = $this->input->post('account_no')[$i];
            if ($account_name != '' && $account_no != '') {
                $dataBank['bank_id']         = $this->input->post('bank_id')[$i];
                $dataBank['account_name']    = $account_name;
                $dataBank['currency_id']     = $currency_id;
                $dataBank['account_no']      = $this->input->post('account_no')[$i];
                $dataBank['account_type_id'] = $this->input->post('account_type_id')[$i];
                $dataBank['staff_id']        = $staff_id;
                $this->db->insert('bank_reference', $dataBank);
            }
        }
        
        //log_message("error", "-----------------------------------");
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi_rp', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	log_message("error", "Resultados: ".json_encode($upload));
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi_rp";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi_rp');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu_company', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu_company";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu_company');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu_rp', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu_rp";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu_rp');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_commercial_patent', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "commercial_patent";
    	        $dataDocs['expiration'] = $this->input->post('expiration_commercial_patent');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_partner_patent', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "partner_patent";
    	        $dataDocs['expiration'] = $this->input->post('expiration_partner_patent');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_bank_statement', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "bank_statement";
    	        $dataDocs['expiration'] = $this->input->post('expiration_bank_statement');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_fiscal_solvency', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "fiscal_solvency";
    	        $dataDocs['expiration'] = $this->input->post('expiration_fiscal_solvency');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        
		/*
        //-- Enviando correo de bienvenida
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
        $mail->Subject = "Nueva cuenta registrada";
        $data_email = array(
            'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url()
        );
        $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
        $mail->AddAddress($this->input->post('email'));
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

       
        */
        return $staff_id;
    }
    
    function edit_provider_legal($staff_id) {
        include('public/apis/class.fileuploader.php');
        
		$FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/staff_image/'));
    	$upload_photo = $FileUploader_photo->upload();

    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']        = $upload_photo['files'][0]['name'];
        }

        $data['first_name']      = $this->input->post('full_name');
        $data['last_name']       = $this->input->post('tradename');
        $data['email']           = $this->input->post('email');  
        $data['phone']           = $this->input->post('phone_1'); 
        $data['departamento_id'] = $this->input->post('departamento_id');  
        $data['municipio_id']    = $this->input->post('municipio_id');  
        $data['address']         = $this->input->post('address');
        $data['charge']          = $this->input->post('charge');
        $data['country']         = $this->input->post('country');
        $data['city']            = $this->input->post('city');
        $data['postal_code']     = $this->input->post('postal_code');
        $data['outdoor_number']  = $this->input->post('outdoor_number');
        $data['interior_number'] = $this->input->post('interior_number');
        
        $this->db->where('staff_id', $staff_id);
        $query = $this->db->update('staff', $data);
        
        $dataProv['application_date']     = $this->input->post('application_date');
        $dataProv['fiscal_address']       = $this->input->post('fiscal_address');
        $dataProv['commercial_address']   = $this->input->post('commercial_address');
        $dataProv['website']              = $this->input->post('website');
        $dataProv['nit']                  = $this->input->post('nit');
        $dataProv['area_code']            = $this->input->post('area_code');
        $dataProv['phone_2']              = $this->input->post('phone_2');
        $dataProv['phone_3']              = $this->input->post('phone_3');
        $dataProv['phone_contact']        = $this->input->post('phone_contact');
        $dataProv['full_name_legal']      = $this->input->post('full_name_legal');
        $dataProv['dpi_legal']            = $this->input->post('dpi_legal');
        $dataProv['commercial_patent']    = $this->input->post('commercial_patent');
        $dataProv['nit_legal']            = $this->input->post('nit_legal');
        $dataProv['full_name_represent']  = $this->input->post('full_name_represent');
        $dataProv['phone_represent']      = $this->input->post('phone_represent');
        $dataProv['email_represent']      = $this->input->post('email_represent');
        $dataProv['full_name_manager']    = $this->input->post('full_name_manager');
        $dataProv['phone_manager']        = $this->input->post('phone_manager');
        $dataProv['email_manager']        = $this->input->post('email_manager');
        $dataProv['full_name_accounts']   = $this->input->post('full_name_accounts');
        $dataProv['phone_accounts']       = $this->input->post('phone_accounts');
        $dataProv['email_accounts']       = $this->input->post('email_accounts');
        $dataProv['full_name_billing']    = $this->input->post('full_name_billing');
        $dataProv['phone_billing']        = $this->input->post('phone_billing');
        $dataProv['email_billing']        = $this->input->post('email_billing');
        $dataProv['full_name_finance']    = $this->input->post('full_name_finance');
        $dataProv['phone_finance']        = $this->input->post('phone_finance');
        $dataProv['email_finance']        = $this->input->post('email_finance');
        $dataProv['full_name_accounting'] = $this->input->post('full_name_accounting');
        $dataProv['phone_accounting']     = $this->input->post('phone_accounting');
        $dataProv['email_accounting']     = $this->input->post('email_accounting');
        $dataProv['provider_service_id']  = $this->input->post('provider_service_id');
        $dataProv['apply_fiscal']         = $this->input->post('apply_fiscal_legal');
        $dataProv['fiscal_data']          = $this->input->post('fiscal_data');
        $dataProv['credit_days']          = $this->input->post('credit_days');
        $this->db->where('staff_id', $staff_id);
        $this->db->update('provider_data', $dataProv);
        
        for ($i=0; $i<count($this->input->post('commercial_reference_id')); $i++) {
            $first_name_reference = $this->input->post('first_name_reference')[$i];
            if ($first_name_reference != '') {
                $dataCom['first_name']     = $first_name_reference;
                $dataCom['last_name']      = $this->input->post('last_name_reference')[$i];
                $dataCom['phone']          = $this->input->post('first_name_reference')[$i];
                $dataCom['company_person'] = $this->input->post('company_person_reference')[$i];
                $this->db->where('commercial_reference_id', $this->input->post('commercial_reference_id')[$i]);
                $this->db->update('commercial_reference', $dataCom);
            }
        }
        
        for ($i=0; $i<count($this->input->post('bank_reference_id')); $i++) {
            $account_name = $this->input->post('account_name')[$i];
            $account_no = $this->input->post('account_no')[$i];
            if ($account_name != '' && $account_no != '') {
                $dataBank['bank_id']         = $this->input->post('bank_id')[$i];
                $dataBank['account_name']    = $account_name;
                $dataBank['currency_id']     = $this->input->post('currency_id')[$i];
                $dataBank['account_no']      = $account_no;
                $dataBank['account_type_id'] = $this->input->post('account_type_id')[$i];
                $this->db->where('bank_reference_id', $this->input->post('bank_reference_id')[$i]);
                $this->db->update('bank_reference', $dataBank);
            }
        }
        
        //log_message("error", "-----------------------------------");
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi_rp', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	log_message("error", "Resultados: ".json_encode($upload));
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi_rp";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi_rp');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu_company', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu_company";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu_company');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu_rp', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu_rp";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu_rp');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_commercial_patent', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "commercial_patent";
    	        $dataDocs['expiration'] = $this->input->post('expiration_commercial_patent');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_partner_patent', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "partner_patent";
    	        $dataDocs['expiration'] = $this->input->post('expiration_partner_patent');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_bank_statement', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "bank_statement";
    	        $dataDocs['expiration'] = $this->input->post('expiration_bank_statement');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_fiscal_solvency', array('uploadDir' => 'public/uploads/staff_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "fiscal_solvency";
    	        $dataDocs['expiration'] = $this->input->post('expiration_fiscal_solvency');
    	        $dataDocs['user_id']    = $staff_id;
    	        $dataDocs['user_type']  = "staff";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        
        return $staff_id;
    }
    
    function deactivateDocument($id) {
        $data['status'] = 0;
        $this->db->where('document_id', $id);
        echo $this->db->update('document', $data);
    }
    
    function system_name()
    {
        return $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;
        
    }

    function system_email()
    {
        return $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email;
        
    }
    
    
    function update_staff($staff_id)
    {
        
        $this->log_model->update_staff($staff_id);
       include('public/apis/class.fileuploader.php');
        $FileUploader_photo = new FileUploader('photo', array(
        	'uploadDir' => 'public/uploads/staff_image/'));
        $upload_photo = $FileUploader_photo->upload();
        if($upload_photo['isSuccess']) {
            $files = $upload_photo['files'];
        } else {
            $warningss = $upload_photo['warnings'];
        }
        
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']         = $upload_photo['files'][0]['name'];
        }
            
        if($this->input->post('Facebook') == '1')
        {
            $data['facebook']      = $this->input->post('link_facebook');
        }else{
            $data['facebook']     = '';
        }
        
        $data['whatsapp']      = $this->input->post('Whatsapp');
        
        if($this->input->post('Instagram') == '1')
        {
            $data['instagram']     = $this->input->post('link_instagram');
        }else{
            $data['instagram']     = '';
        }
        $data['first_name']    = $this->input->post('first_name'); 
        $data['second_name']     = $this->input->post('second_name'); 
        $data['third_name']     = $this->input->post('third_name'); 
        $data['last_name']     = $this->input->post('last_name');
        $data['second_last_name']     = $this->input->post('second_last_name'); 
        $data['married_last_name']     = $this->input->post('married_last_name'); 
        $data['dpi']         = $this->input->post('dpi'); 
        $data['phone']         = $this->input->post('phone');    
        $data['email']         = $this->input->post('email');    
        $data['date_of_birth'] = $this->input->post('date_of_birth');    
        $data['account']       = 1;
        $data['gender']        = $this->input->post('gender');    
		$data['marital_status']      = $this->input->post('status');    
        $data['address']       = $this->input->post('address');
        $data['salary']        = $this->input->post('salary'); 
        $data['address']        = $this->input->post('address');
        $data['since']          = $this->formatDate();   
        $data['charge']        = $this->input->post('charge'); 
        $data['clinic_id']      = $this->session->userdata('current_clinic');
        $this->db->where('staff_id',$staff_id);
        $this->db->update('staff', $data);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/staff_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
    }
    
    
    function update_staff_modules($staff_id)
    {
        ///---------Permisos de la navbar---------- //
        $data['moduls']         = 0;
        $data['panel']          = 1;
        $data['chat']           = $this->input->post('chat');
        $data['cirug']          = $this->input->post('cirug');
        $data['patients']       = $this->input->post('patients');
        $data['doctors']        = $this->input->post('doctors');
        $data['staff']          = $this->input->post('staff');
        $data['inventory']      = $this->input->post('inventory');
        $data['sales']          = $this->input->post('sales');
        $data['financial']      = $this->input->post('financial');
        $data['reports']        = $this->input->post('reports');
        $data['settings']       = $this->input->post('settings');
        $data['hab']        = $this->input->post('hab');
        $data['hosp']       = $this->input->post('hosp');
        $data['clinic_id']      = $this->session->userdata('current_clinic');
        $this->db->where('staff_id',$staff_id);
        $this->db->update('staff', $data);
    }
    

    function create_admin()
    {
        include('public/apis/class.fileuploader.php');
        
        $FileUploader_signature = new FileUploader('signature', array('uploadDir' => 'public/uploads/doctor_signature/'));
        $upload_signature = $FileUploader_signature->upload();
        if($upload_signature['isSuccess']) {
            $files = $upload_signature['files'];
        } else {
            $warnings = $upload_signature['warnings'];
        }
        
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/doctor_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        
        if($upload_photo['files'][0]['name'] != "") {
            $data['photo']             = $upload_photo['files'][0]['name'];
        }
        if($upload_signature['files'][0]['name'] != "") {
            $data['signature']         = $upload_signature['files'][0]['name'];
        }
        $password                   = $this->getPassword();
        $data['first_name']         = $this->input->post('first_name');
        $data['second_name']        = $this->input->post('second_name');
        $data['third_name']         = $this->input->post('third_name');
        $data['last_name']          = $this->input->post('last_name');
        $data['second_last_name']   = $this->input->post('second_last_name');
        $data['married_last_name']  = $this->input->post('married_last_name');
        $data['date_of_birth']      = $this->input->post('date_of_birth');
        $data['dpi']                = $this->input->post('dpi');
        $data['phone']              = $this->input->post('phone');
        $data['gender']             = $this->input->post('gender');
        $data['marital_status']     = $this->input->post('marital_status');
        $data['email']              = $this->input->post('email');
        $data['salary']             = $this->input->post('salary');
        $data['role_id']            = $this->input->post('role_id');
        $data['password']           = sha1($password);
        $data['username']           = $this->getUsername(strtolower($this->normalizeText($this->input->post('first_name')." ".$this->input->post('last_name'))));
        $data['status']             = 1;
        
        $data['address']         = $this->input->post('address');
        $data['country']         = $this->input->post('country');
        $data['departamento_id'] = $this->input->post('departamento_id');
        $data['municipio_id']    = $this->input->post('municipio_id');
        $data['city']            = $this->input->post('city');
        $data['postal_code']     = $this->input->post('postal_code');
        $data['outdoor_number']  = $this->input->post('outdoor_number');
        $data['interior_number'] = $this->input->post('interior_number');
        
        $data['profession']         = $this->input->post('profession'); 
        $data['academic_title']     = $this->input->post('academic_title');
        $data['place_study']        = $this->input->post('place_study'); 
        $data['no_college']         = $this->input->post('no_college'); 
        $data['date_study_start']   = $this->input->post('date_study_start');
        $data['date_study_end']     = $this->input->post('date_study_end');
        $data['comments']           = $this->input->post('comments');
        
        $data['address_company']         = $this->input->post('address_company');   
        $data['country_company']         = $this->input->post('country_company');    
        $data['state_company']           = $this->input->post('state_company');
        $data['city_company']            = $this->input->post('city_company'); 
        $data['postal_code_company']     = $this->input->post('postal_code_company'); 
        $data['outdoor_number_company']  = $this->input->post('outdoor_number_company');
        $data['interior_number_company'] = $this->input->post('interior_number_company');
        $data['date_work_start']         = $this->input->post('date_work_start');
        $data['bonus']                   = $this->input->post('bonus');
        $data['charge']                  = $this->input->post('charge'); 
        $data['date_contract_start']     = $this->input->post('date_contract_start');
        $data['type_workday']            = $this->input->post('type_workday');
        $data['payment_type']            = $this->input->post('payment_type');
        $data['work_time']               = $this->input->post('work_time');
        $data['date_work_end']           = $this->input->post('date_work_end');

        ///---------Permisos de la navbar---------- //
        $data['appointments']       = 1;
        $data['owner']              = 1;
        $data['moduls']             = 1;
        $data['chat']               = 1;
        $data['patients']           = 1;
        $data['doctors']            = 1;
        $data['staff']              = 1;
        $data['inventory']          = 1;
        $data['financial']          = 1;
        $data['reports']            = 1;
        $data['accounting']         = 1;
        $data['banks']              = 1;
        $data['settings']           = 1;

        $data['clinic_id']     = $this->session->userdata('current_clinic');
        if($this->input->post('Facebook') == '1')
        {
            $data['facebook']      = $this->input->post('link_facebook');
        }
        
        $data['whatsapp']      = $this->input->post('Whatsapp');
        
        if($this->input->post('Instagram') == '1')
        {
            $data['instagram']     = $this->input->post('link_instagram');
        }
        $this->db->insert('admin', $data);
        $doctor_id = $this->db->insert_id();
        $this->log_model->create_doctor($doctor_id);
        
        $files = array();
    	$FileUploader = new FileUploader('doc_academic', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "academic";
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	log_message("error", "Resultados: ".json_encode($upload));
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_contract', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "contract";
    	        $dataDocs['expiration'] = $this->input->post('expiration_contract');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_health', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "health";
    	        $dataDocs['expiration'] = $this->input->post('expiration_health');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_criminal', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "criminal";
    	        $dataDocs['expiration'] = $this->input->post('expiration_criminal');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_police', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "police";
    	        $dataDocs['expiration'] = $this->input->post('expiration_police');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_employment', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "employment";
    	        $dataDocs['expiration'] = $this->input->post('expiration_employment');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_recommend', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "recommend";
    	        $dataDocs['expiration'] = $this->input->post('expiration_recommend');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_renas', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "renas";
    	        $dataDocs['expiration'] = $this->input->post('expiration_renas');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        
    	$files = array();
    	$FileUploader = new FileUploader('doc_academic', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "academic";
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_college', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "college";
    	        $dataDocs['expiration'] = $this->input->post('expiration_college');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	log_message("error", "Resultados: ".json_encode($upload));
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_contract', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "contract";
    	        $dataDocs['expiration'] = $this->input->post('expiration_contract');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_health', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "health";
    	        $dataDocs['expiration'] = $this->input->post('expiration_health');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_criminal', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "criminal";
    	        $dataDocs['expiration'] = $this->input->post('expiration_criminal');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_police', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "police";
    	        $dataDocs['expiration'] = $this->input->post('expiration_police');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_employment', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "employment";
    	        $dataDocs['expiration'] = $this->input->post('expiration_employment');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_recommend', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "recommend";
    	        $dataDocs['expiration'] = $this->input->post('expiration_recommend');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_renas', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "renas";
    	        $dataDocs['expiration'] = $this->input->post('expiration_renas');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
        $mail->Subject = "Nueva cuenta registrada";
        $data_email = array(
            'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url()
        );
        $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
        $mail->AddAddress($this->input->post('email'));
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
        
        return $doctor_id;
    }

    function edit_admin($doctor_id) {
        
        include('public/apis/class.fileuploader.php');
        
        $FileUploader_signature = new FileUploader('signature', array('uploadDir' => 'public/uploads/doctor_signature/'));
        $upload_signature = $FileUploader_signature->upload();
        if($upload_signature['isSuccess']) {
            $files = $upload_signature['files'];
        } else {
            $warnings = $upload_signature['warnings'];
        }
        
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/doctor_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        
        if($upload_photo['files'][0]['name'] != "") {
            $data['photo']          = $upload_photo['files'][0]['name'];
        }
        if($upload_signature['files'][0]['name'] != "") {
            $data['signature']      = $upload_signature['files'][0]['name'];
        }
        $data['first_name']         = $this->input->post('first_name');
        $data['second_name']        = $this->input->post('second_name');
        $data['third_name']         = $this->input->post('third_name');
        $data['last_name']          = $this->input->post('last_name');
        $data['second_last_name']   = $this->input->post('second_last_name');
        $data['married_last_name']  = $this->input->post('married_last_name');
        $data['date_of_birth']      = $this->input->post('date_of_birth');
        $data['dpi']                = $this->input->post('dpi');
        $data['phone']              = $this->input->post('phone');
        $data['gender']             = $this->input->post('gender');
        $data['marital_status']     = $this->input->post('marital_status');
        $data['email']              = $this->input->post('email');
        $data['salary']             = $this->input->post('salary');
        $data['role_id']            = $this->input->post('role_id');
        
        $data['address']         = $this->input->post('address');
        $data['country']         = $this->input->post('country');
        $data['departamento_id'] = $this->input->post('departamento_id');
        $data['municipio_id']    = $this->input->post('municipio_id');
        $data['city']            = $this->input->post('city');
        $data['postal_code']     = $this->input->post('postal_code');
        $data['outdoor_number']  = $this->input->post('outdoor_number');
        $data['interior_number'] = $this->input->post('interior_number');
        
        $data['profession']         = $this->input->post('profession'); 
        $data['academic_title']     = $this->input->post('academic_title');
        $data['place_study']        = $this->input->post('place_study'); 
        $data['no_college']         = $this->input->post('no_college'); 
        $data['date_study_start']   = $this->input->post('date_study_start');
        $data['date_study_end']     = $this->input->post('date_study_end');
        $data['comments']           = $this->input->post('comments');
        
        $data['address_company']         = $this->input->post('address_company');   
        $data['country_company']         = $this->input->post('country_company');    
        $data['state_company']           = $this->input->post('state_company');
        $data['city_company']            = $this->input->post('city_company'); 
        $data['postal_code_company']     = $this->input->post('postal_code_company'); 
        $data['outdoor_number_company']  = $this->input->post('outdoor_number_company');
        $data['interior_number_company'] = $this->input->post('interior_number_company');
        $data['date_work_start']         = $this->input->post('date_work_start');
        $data['bonus']                   = $this->input->post('bonus');
        $data['charge']                  = $this->input->post('charge'); 
        $data['date_contract_start']     = $this->input->post('date_contract_start');
        $data['type_workday']            = $this->input->post('type_workday');
        $data['payment_type']            = $this->input->post('payment_type');
        $data['work_time']               = $this->input->post('work_time');
        $data['date_work_end']           = $this->input->post('date_work_end');

        $this->db->where('admin_id', $doctor_id);
        $this->db->update('admin', $data);
        
        $files = array();
    	$FileUploader = new FileUploader('doc_academic', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "academic";
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	log_message("error", "Resultados: ".json_encode($upload));
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_contract', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "contract";
    	        $dataDocs['expiration'] = $this->input->post('expiration_contract');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_health', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "health";
    	        $dataDocs['expiration'] = $this->input->post('expiration_health');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_criminal', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "criminal";
    	        $dataDocs['expiration'] = $this->input->post('expiration_criminal');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_police', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "police";
    	        $dataDocs['expiration'] = $this->input->post('expiration_police');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_employment', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "employment";
    	        $dataDocs['expiration'] = $this->input->post('expiration_employment');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_recommend', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "recommend";
    	        $dataDocs['expiration'] = $this->input->post('expiration_recommend');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_renas', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "renas";
    	        $dataDocs['expiration'] = $this->input->post('expiration_renas');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        
    	$files = array();
    	$FileUploader = new FileUploader('doc_academic', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "academic";
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_college', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "college";
    	        $dataDocs['expiration'] = $this->input->post('expiration_college');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	log_message("error", "Resultados: ".json_encode($upload));
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_contract', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "contract";
    	        $dataDocs['expiration'] = $this->input->post('expiration_contract');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_health', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "health";
    	        $dataDocs['expiration'] = $this->input->post('expiration_health');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_criminal', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "criminal";
    	        $dataDocs['expiration'] = $this->input->post('expiration_criminal');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_police', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "police";
    	        $dataDocs['expiration'] = $this->input->post('expiration_police');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_employment', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "employment";
    	        $dataDocs['expiration'] = $this->input->post('expiration_employment');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_recommend', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "recommend";
    	        $dataDocs['expiration'] = $this->input->post('expiration_recommend');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_renas', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "renas";
    	        $dataDocs['expiration'] = $this->input->post('expiration_renas');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}

        return $doctor_id;
    }

    function create_doctor() {
        include('public/apis/class.fileuploader.php');
        
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/doctor_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        if($upload_photo['files'][0]['name'] != "") {   
            $data['photo']          = $upload_photo['files'][0]['name'];
        }
        
        $FileUploader_signature = new FileUploader('signature', array('uploadDir' => 'public/uploads/doctor_documents/'));
    	$upload_signature = $FileUploader_signature->upload();
    	if($upload_signature['isSuccess']) {
        	$files = $upload_signature['files'];
    	} else {
        	$warningss = $upload_signature['warnings'];
    	}
        if($upload_signature['files'][0]['name'] != "") {   
            $data['signature']      = $upload_signature['files'][0]['name'];
        }
        
        $password                   = $this->getPassword();
        $data['first_name']         = $this->input->post('first_name');    
        $data['second_name']        = $this->input->post('second_name');    
        $data['third_name']         = $this->input->post('third_name');    
        $data['last_name']          = $this->input->post('last_name');
        $data['second_last_name']   = $this->input->post('second_last_name');
        $data['married_last_name']  = $this->input->post('married_last_name');
        $data['dpi']                = $this->input->post('dpi'); 
        $data['dpi_expire']         = $this->input->post('dpi_expire'); 
        $data['phone']              = $this->input->post('phone');    
        $data['email']              = $this->input->post('email');    
        $data['password']           = sha1($password);
        $data['date_of_birth']      = $this->input->post('date_of_birth');    
        $data['username']           = $this->getUsername(strtolower($this->normalizeText($this->input->post('first_name')." ".$this->input->post('last_name'))));    
        $data['status']             = 1;
        $data['salary']             = $this->input->post('salary');
        $data['gender']             = $this->input->post('gender');
        $data['marital_status']     = $this->input->post('marital_status');     
        $data['specialty_1']        = $this->input->post('specialty_1');   
        $data['specialty_2']        = serialize($this->input->post('specialty_2'));
        $data['insurances']         = serialize($this->input->post('insurances'));
        $data['role_id']            = $this->input->post('role_id');
        
        $data['address']         = $this->input->post('address');
        $data['country']         = $this->input->post('country');
        $data['departamento_id'] = $this->input->post('departamento_id');
        $data['municipio_id']    = $this->input->post('municipio_id');
        $data['city']            = $this->input->post('city');
        $data['postal_code']     = $this->input->post('postal_code');
        $data['outdoor_number']  = $this->input->post('outdoor_number');
        $data['interior_number'] = $this->input->post('interior_number');
        
        $data['address_company']         = $this->input->post('address_company');   
        $data['country_company']         = $this->input->post('country_company');    
        $data['state_company']           = $this->input->post('state_company'); 
        $data['city_company']            = $this->input->post('city_company'); 
        $data['postal_code_company']     = $this->input->post('postal_code_company'); 
        $data['outdoor_number_company']  = $this->input->post('outdoor_number_company');
        $data['interior_number_company'] = $this->input->post('interior_number_company');
        $data['date_work_start']         = $this->input->post('date_work_start');
        $data['bonus']                   = $this->input->post('bonus');
        $data['date_contract_start']     = $this->input->post('date_contract_start');
        $data['type_workday']            = $this->input->post('type_workday');
        $data['payment_type']            = $this->input->post('payment_type');
        $data['work_time']               = $this->input->post('work_time');
        $data['date_work_end']           = $this->input->post('date_work_end');
        
        $data['profession']         = $this->input->post('profession'); 
        $data['charge']             = $this->input->post('charge'); 
        $data['academic_title']     = $this->input->post('academic_title');
        $data['place_study']        = $this->input->post('place_study'); 
        $data['no_college']         = $this->input->post('no_college'); 
        $data['date_study_start']   = $this->input->post('date_study_start');
        $data['date_study_end']     = $this->input->post('date_study_end');
        $data['comments']           = $this->input->post('comments');
        $data['date_last_confront'] = $this->input->post('date_last_confront');

        ///---------Permisos de la navbar---------- //
        $data['appointments']           = 1;
        $data['owner']              = 0;
        $data['moduls']             = 0;
        $data['chat']               = 1;
        $data['patients']           = 1;
        $data['doctors']            = 1;
        $data['staff']              = 1;
        $data['inventory']          = 0;
        $data['financial']          = 0;
        $data['reports']            = 0;
        $data['accounting']         = 0;
        $data['banks']              = 0;
        $data['settings']           = 0;

        $data['clinic_id']     = $this->session->userdata('current_clinic');
        
        if($this->input->post('Facebook') == '1')
        {
            $data['facebook']      = $this->input->post('link_facebook');
        }
        $data['whatsapp']      = $this->input->post('Whatsapp');
        if($this->input->post('Instagram') == '1')
        {
            $data['instagram']     = $this->input->post('link_instagram');
        }
        
        $this->db->insert('admin', $data);
        $doctor_id = $this->db->insert_id();
        $this->log_model->create_doctor($doctor_id);
        
        $files = array();
    	$FileUploader = new FileUploader('doc_academic', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "academic";
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_college', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "college";
    	        $dataDocs['expiration'] = $this->input->post('expiration_college');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	log_message("error", "Resultados: ".json_encode($upload));
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_contract', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "contract";
    	        $dataDocs['expiration'] = $this->input->post('expiration_contract');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_health', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "health";
    	        $dataDocs['expiration'] = $this->input->post('expiration_health');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_criminal', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "criminal";
    	        $dataDocs['expiration'] = $this->input->post('expiration_criminal');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_police', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "police";
    	        $dataDocs['expiration'] = $this->input->post('expiration_police');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_employment', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "employment";
    	        $dataDocs['expiration'] = $this->input->post('expiration_employment');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_recommend', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "recommend";
    	        $dataDocs['expiration'] = $this->input->post('expiration_recommend');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_renas', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "renas";
    	        $dataDocs['expiration'] = $this->input->post('expiration_renas');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        
    	$files = array();
    	$FileUploader = new FileUploader('doc_academic', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "academic";
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_college', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "college";
    	        $dataDocs['expiration'] = $this->input->post('expiration_college');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	log_message("error", "Resultados: ".json_encode($upload));
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_contract', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "contract";
    	        $dataDocs['expiration'] = $this->input->post('expiration_contract');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_health', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "health";
    	        $dataDocs['expiration'] = $this->input->post('expiration_health');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_criminal', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "criminal";
    	        $dataDocs['expiration'] = $this->input->post('expiration_criminal');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_police', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "police";
    	        $dataDocs['expiration'] = $this->input->post('expiration_police');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_employment', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "employment";
    	        $dataDocs['expiration'] = $this->input->post('expiration_employment');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_recommend', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "recommend";
    	        $dataDocs['expiration'] = $this->input->post('expiration_recommend');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_renas', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "renas";
    	        $dataDocs['expiration'] = $this->input->post('expiration_renas');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer(); 
        $mail->IsHTML(true);
        $mail->IsMail();
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
        $mail->Subject = "Nueva cuenta registrada";
        $data_email = array(
            'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url()
        );
        $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
        $mail->AddAddress($this->input->post('email'));
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

        
    }
    
    
    function edit_doctor($doctor_id) {
        include('public/apis/class.fileuploader.php');
        
        $FileUploader_photo = new FileUploader('photo', array('uploadDir' => 'public/uploads/doctor_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
        if($upload_photo['files'][0]['name'] != "") {   
            $data['photo'] = $upload_photo['files'][0]['name'];
        }
        
        $FileUploader_signature = new FileUploader('signature', array('uploadDir' => 'public/uploads/doctor_documents/'));
    	$upload_signature = $FileUploader_signature->upload();
    	if($upload_signature['isSuccess']) {
        	$files = $upload_signature['files'];
    	} else {
        	$warningss = $upload_signature['warnings'];
    	}
        if($upload_signature['files'][0]['name'] != "") {   
            $data['signature']      = $upload_signature['files'][0]['name'];
        }
        
        $data['first_name']         = $this->input->post('first_name');    
        $data['second_name']        = $this->input->post('second_name');    
        $data['third_name']         = $this->input->post('third_name');    
        $data['last_name']          = $this->input->post('last_name');
        $data['second_last_name']   = $this->input->post('second_last_name');
        $data['married_last_name']  = $this->input->post('married_last_name');
        $data['dpi']                = $this->input->post('dpi'); 
        $data['dpi_expire']         = $this->input->post('dpi_expire'); 
        $data['phone']              = $this->input->post('phone');    
        $data['email']              = $this->input->post('email');  
        $data['date_of_birth']      = $this->input->post('date_of_birth');
        $data['salary']             = $this->input->post('salary');
        $data['marital_status']     = $this->input->post('marital_status');
        $data['gender']             = $this->input->post('gender');     
        $data['specialty_1']        = $this->input->post('specialty_1');   
        $data['specialty_2']        = serialize($this->input->post('specialty_2'));
        $data['insurances']         = serialize($this->input->post('insurances'));
        $data['role_id']            = $this->input->post('role_id');
        
        $data['address']         = $this->input->post('address');    
        $data['country']         = $this->input->post('country'); 
        $data['departamento_id'] = $this->input->post('departamento_id');   
        $data['municipio_id']    = $this->input->post('municipio_id'); 
        $data['city']            = $this->input->post('city'); 
        $data['postal_code']     = $this->input->post('postal_code'); 
        $data['outdoor_number']  = $this->input->post('outdoor_number');
        $data['interior_number'] = $this->input->post('interior_number');
        
        $data['address_company']         = $this->input->post('address_company');   
        $data['country_company']         = $this->input->post('country_company');    
        $data['state_company']           = $this->input->post('state_company'); 
        $data['city_company']            = $this->input->post('city_company'); 
        $data['postal_code_company']     = $this->input->post('postal_code_company'); 
        $data['outdoor_number_company']  = $this->input->post('outdoor_number_company');
        $data['interior_number_company'] = $this->input->post('interior_number_company');
        $data['date_work_start']         = $this->input->post('date_work_start');
        $data['bonus']                   = $this->input->post('bonus');
        $data['date_contract_start']     = $this->input->post('date_contract_start');
        $data['type_workday']            = $this->input->post('type_workday');
        $data['payment_type']            = $this->input->post('payment_type');
        $data['work_time']               = $this->input->post('work_time');
        $data['date_work_end']           = $this->input->post('date_work_end');
        
        $data['profession']         = $this->input->post('profession');
        $data['charge']             = $this->input->post('charge');  
        $data['academic_title']     = $this->input->post('academic_title');
        $data['place_study']        = $this->input->post('place_study'); 
        $data['no_college']         = $this->input->post('no_college'); 
        $data['date_study_start']   = $this->input->post('date_study_start');
        $data['date_study_end']     = $this->input->post('date_study_end');
        $data['comments']           = $this->input->post('comments');
        $data['date_last_confront'] = $this->input->post('date_last_confront');

        $this->db->where('admin_id', $doctor_id);
        $this->db->update('admin', $data);
        
    	$files = array();
    	$FileUploader = new FileUploader('doc_academic', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "academic";
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_college', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "college";
    	        $dataDocs['expiration'] = $this->input->post('expiration_college');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_dpi', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	log_message("error", "Resultados: ".json_encode($upload));
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        // log_message("error", "Nombre: ".$files[$i]['name'].", Tipo: ".$files[$i]['type']);
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "dpi";
    	        $dataDocs['expiration'] = $this->input->post('expiration_dpi');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_contract', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "contract";
    	        $dataDocs['expiration'] = $this->input->post('expiration_contract');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	
    	$files = array();
    	$FileUploader = new FileUploader('doc_rtu', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "rtu";
    	        $dataDocs['expiration'] = $this->input->post('expiration_rtu');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_health', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "health";
    	        $dataDocs['expiration'] = $this->input->post('expiration_health');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_criminal', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "criminal";
    	        $dataDocs['expiration'] = $this->input->post('expiration_criminal');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_police', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "police";
    	        $dataDocs['expiration'] = $this->input->post('expiration_police');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_receipt', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "receipt";
    	        $dataDocs['expiration'] = $this->input->post('expiration_receipt');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_employment', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "employment";
    	        $dataDocs['expiration'] = $this->input->post('expiration_employment');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_recommend', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "recommend";
    	        $dataDocs['expiration'] = $this->input->post('expiration_recommend');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
    	$files = array();
    	$FileUploader = new FileUploader('doc_renas', array('uploadDir' => 'public/uploads/doctor_documents/' ));
    	$upload = $FileUploader->upload();
    	if($upload['isSuccess']) {
        	$files = $upload['files'];
    	} else {
        	$warnings = $upload['warnings'];
    	}
    	if (count($files) > 0) {
    	    for ($i=0; $i<count($files); $i++) {
    	        $dataDocs['name']       = $files[$i]['name'];
    	        $dataDocs['type']       = "renas";
    	        $dataDocs['expiration'] = $this->input->post('expiration_renas');
    	        $dataDocs['user_id']    = $doctor_id;
    	        $dataDocs['user_type']  = "admin";
    	        $this->db->insert('document', $dataDocs);
    	    }
    	}
        
        return $doctor_id;
    }
    
    function diary ()
    {
        require("public/apis/class.phpmailer.php");
        $mail = new PHPMailer();
        $this->db->where('date', date('d/m/Y'));
        $this->db->where('status', 0);
        $this->db->or_where('status', 1);
        $this->db->or_where('status', 2);
        
        
        $this->db->group_by('doctor_id');
        $appointments = $this->db->get('appointment')->result_array();
        
        foreach($appointments as $appointment){
            
          
            $doctors = $this->db->get_where('admin', array( 'admin_id' => $appointment['doctor_id']))->row()->email;
            $name = $this->db->get_where('admin', array( 'admin_id' => $appointment['doctor_id']))->row()->first_name;
      
                  
                    $mail->IsHTML(true);
                    $mail->IsMail();
                    $mail->CharSet = 'UTF-8';
                    $mail->SetFrom('notificaciones@mayansource.com', 'Notificaciones  sistema Atenun');
                    $mail->Subject = "Agenda de hoy";
                    $data_email = array(
                        'email_msg' => "¡Buenos dias ".$name."! Estas la agenda para el dia de hoy <b>".date('d/m/Y')."</b>",
                        'doctor_id' => $appointment['doctor_id']
                    );
                    $mail->Body = $this->load->view('backend/mails/diary.php',$data_email,TRUE);
                    $mail->AddAddress($doctors);
                    if(!$mail->Send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo." ".$doctors;
                    }
                    
                    $mail->ClearAllRecipients();
               
                
                 echo $doctors."<br>";
        }
        
    }
    
        
    function solicite_data()
    {
        require("public/apis/class.phpmailer.php");
        
       if($this->input->post('password') != ""){
                $data['password']     = sha1($this->input->post('password'));
            }
        
        $mail = new PHPMailer();
        $this->db->or_where('status', 1);
        $this->db->or_where('clinic_id',  $this->session->userdata('current_clinic'));
        $clinic = $this->db->get('clinic')->result_array();
        

            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones de  sistema Atenun');
            $mail->Subject = "Solicitud de información  sistema Atenun";
            $data_email = array(
                'email_msg' => "¡Buenos días! Solicitud de la información de".$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name.", solicitada el <b>".date('d/m/Y')."</b>",
                'mod_appointments' => $this->input->post('mod_appointments'),  
                'mod_patients' => $this->input->post('mod_patients'),
                'mod_doctors' => $this->input->post('mod_doctors'),
                'mod_staff' => $this->input->post('mod_staff'),
                'mod_ingresos' => $this->input->post('mod_ingresos'),
                'mod_egresos' => $this->input->post('mod_egresos'),
                            );
            $mail->Body = $this->load->view('backend/mails/info.php',$data_email,TRUE);
            $mail->AddAddress('atezo@mayansource.com');
            
            if($mail->Send()) {
                

                
                
            }else
            {
                echo "Mailer Error: " . $mail->ErrorInfo." ".$doctors;
            }
            
            $mail->ClearAllRecipients();
       
        
         echo "<br>";
        
        
    }
    
    function update_doctor($admin_id)
    {
       include('public/apis/class.fileuploader.php');
        $this->log_model->update_doctor($admin_id);
    	$FileUploader_signature = new FileUploader('signature', array(
    		'uploadDir' => 'public/uploads/doctor_signature/'));
    	$upload_signature = $FileUploader_signature->upload();
    	if($upload_signature['isSuccess']) {
        	$files = $upload_signature['files'];
    	} else {
        	$warnings = $upload_signature['warnings'];
    	}
    	
    	
    	$FileUploader_photo = new FileUploader('photo', array(
    		'uploadDir' => 'public/uploads/doctor_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
    
        if($upload_photo['files'][0]['name'] != "")
        {
            $data['photo']         = $upload_photo['files'][0]['name'];
        }
        
        if($upload_signature['files'][0]['name'] != "")
        {
            $data['signature']     = $upload_signature['files'][0]['name'];
        }
            
        $data['first_name']    = $this->input->post('first_name');    
        $data['second_name']     = $this->input->post('second_name'); 
        $data['third_name']     = $this->input->post('third_name'); 
        $data['last_name']     = $this->input->post('last_name'); 
        $data['second_last_name']     = $this->input->post('second_last_name'); 
        $data['married_last_name']     = $this->input->post('married_last_name'); 
        $data['dpi']         = $this->input->post('dpi'); 
        $data['phone']         = $this->input->post('phone');    
        $data['email']         = $this->input->post('email');    
        $data['date_of_birth'] = $this->input->post('date_of_birth');    
        $data['owner']         = $this->input->post('owner');
        $data['gender']        = $this->input->post('gender');    
        $data['specialty_1']   = $this->input->post('specialty_1');   
        $data['specialty_2']   = serialize($this->input->post('specialty_2'));
        $data['insurances']    = serialize($this->input->post('insurances'));
        $data['owner']         = 0;
        //$data['username']      = $this->input->post('username');    
        $data['address']       = $this->input->post('address');    
        $data['no_college']    = $this->input->post('no_college'); 
        $data['salary']        = $this->input->post('salary'); 
        
        if($this->input->post('Facebook') == '1')
        {
            $data['facebook']      = $this->input->post('link_facebook');
        }
        else
        {
            $data['facebook']      = '';
        }
        
        $data['whatsapp']      = $this->input->post('Whatsapp');
        
        if($this->input->post('Instagram') == '1')
        {
            $data['instagram']     = $this->input->post('link_instagram');
        }
        else
        {
            $data['instagram']      = '';
        }
        $this->db->where('admin_id',$admin_id);
        $this->db->update('admin', $data);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/doctor_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/doctor_signature/' . $md5.str_replace(' ', '', $_FILES['signature']['name']));

    }
    
    
    function update_doctor_profile($admin_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
       include('public/apis/class.fileuploader.php');
        $this->log_model->update_doctor($admin_id);
    	$FileUploader_signature = new FileUploader('signature', array(
    		'uploadDir' => 'public/uploads/doctor_signature/'));
    	$upload_signature = $FileUploader_signature->upload();
    	if($upload_signature['isSuccess']) {
        	$files = $upload_signature['files'];
    	} else {
        	$warnings = $upload_signature['warnings'];
    	}
    	
    	
    	$FileUploader_photo = new FileUploader('photo', array(
    		'uploadDir' => 'public/uploads/doctor_image/'));
    	$upload_photo = $FileUploader_photo->upload();
    	if($upload_photo['isSuccess']) {
        	$files = $upload_photo['files'];
    	} else {
        	$warningss = $upload_photo['warnings'];
    	}
    
        if(!empty($upload_photo['files']))
        {
            $data['photo']         = $upload_photo['files'][0]['name'];
        }
        
        if(!empty($upload_signature['files']))
        {
            $data['signature']     = $upload_signature['files'][0]['name'];
        }
            
        $data['first_name']    = $this->input->post('first_name');    
        $data['second_name']     = $this->input->post('second_name'); 
        $data['third_name']     = $this->input->post('third_name'); 
        $data['last_name']     = $this->input->post('last_name'); 
        $data['second_last_name']     = $this->input->post('second_last_name'); 
        $data['married_last_name']     = $this->input->post('married_last_name'); 
        $data['dpi']         = $this->input->post('dpi'); 
        $data['phone']         = $this->input->post('phone');    
        $data['email']         = $this->input->post('email');    
        $data['date_of_birth'] = $this->input->post('date_of_birth');    
        if($this->crud_model->account_owner() == 1){
            $data['owner']         = $this->input->post('owner');    
        }
        $data['gender']        = $this->input->post('gender');    
        $data['specialty_1']   = $this->input->post('specialty_1');   
        $data['specialty_2']   = $this->input->post('specialty_2');
        $data['address']       = $this->input->post('address');    
        $data['no_college']    = $this->input->post('no_college'); 
        if($this->input->post('Facebook') == '1')
        {
            $data['facebook']      = $this->input->post('link_facebook');
        }
        else
        {
            $data['facebook']      = '';
        }
        
        $data['whatsapp']      = $this->input->post('Whatsapp');
        
        if($this->input->post('Instagram') == '1')
        {
            $data['instagram']     = $this->input->post('link_instagram');
        }
        else
        {
            $data['instagram']      = '';
        }
        $this->db->where('admin_id',$admin_id);
        $this->db->update('admin', $data);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/doctor_image/' . $md5.str_replace(' ', '', $_FILES['photo']['name']));
        move_uploaded_file($_FILES['photo']['tmp_name'], 'public/uploads/doctor_signature/' . $md5.str_replace(' ', '', $_FILES['signature']['name']));

    }
    
    function update_doctor_modules($admin_id)
    {
         ///---------Permisos de la navbar---------- //
        $data['moduls']         = $this->input->post('moduls');
        $data['panel']          = $this->input->post('panel');
        $data['chat']           = $this->input->post('chat');
        $data['appointments']   = $this->input->post('appointments');
        $data['patients']       = $this->input->post('patients');
        $data['doctors']        = $this->input->post('doctors');
        $data['staff']          = $this->input->post('staff');
        $data['inventory']      = $this->input->post('inventory');
        $data['financial']      = $this->input->post('financial');
        $data['reports']        = $this->input->post('reports');
        $data['settings']       = $this->input->post('settings');
        $this->db->where('admin_id',$admin_id);
        $this->db->update('admin', $data);
    }
    
    function update_doctor_pass($admin_id)
    {
        
        if($this->input->post('new_pass') == $this->input->post('confirm_pass')){
            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('admin_id',$admin_id);
            $this->db->update('admin', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");
            redirect(base_url() . 'doctor/my_security/', 'refresh');   
        }else{
            $this->session->set_flashdata('flash_message' , "Hubo un error al actualizar la contraseña.");
            redirect(base_url() . 'doctor/my_security/', 'refresh');
        }
    }
    
    function update_doctor_pass_profile($admin_id)
    {
        if($this->input->post('new_pass') == $this->input->post('confirm_pass')){
            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('admin_id',$admin_id);
            $this->db->update('admin', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($admin_id), 'refresh');   
        }else{
            $this->session->set_flashdata('flash_message' , "Hubo un error al actualizar la contraseña.");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($admin_id), 'refresh');
        }
    }
    
    
    function update_staff_pass_profile($staff_id)
    {
        if($this->input->post('new_pass') == $this->input->post('confirm_pass')){
            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('staff_id',$staff_id);
            $this->db->update('staff', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");
            redirect(base_url() . $this->session->userdata('login_type').'/staff_security/'.base64_encode($staff_id), 'refresh');   
        }else{
            $this->session->set_flashdata('flash_message' , "Hubo un error al actualizar la contraseña.");
            redirect(base_url() . $this->session->userdata('login_type').'/staff_security/'.base64_encode($staff_id), 'refresh');
        }
    }

    function update_patient_pass($patient_id)
    {
        if($this->input->post('new_pass') == $this->input->post('confirm_pass')){
            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('patient_id',$patient_id);
            $this->db->update('patient', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");

            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->SetFrom('usuarios@mayansource.com', 'Notificaciones  sistema Atenun');
            $mail->Subject = "Cambio de clave";
            $data_email = array(
                'email_msg' => "¡Hola ".$this->input->post('first_name')."! Recibes esta notificación porque se ha cambiado tu clave de cuenta de usuario en <b>".$this->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$this->db->get_where('patient', array('patient_id' => $patient_id))->row()->username."<br><b>Nueva clave:</b> ".$this->input->post('new_pass')."<br> Para iniciar sesión haz click aquí: ".base_url().'/login'
            );
            $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
            $mail->AddAddress($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email);
            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
           
        }else{
            $this->session->set_flashdata('flash_message' , "Hubo un error al actualizar la contraseña.");
           
        }
           
        
    }
    
    
    function update_the_patient_pass($patient_id)
    {

            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('patient_id',$patient_id);
            $this->db->update('patient', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");

            redirect(base_url() . 'patient/patient_security/'.base64_encode($patient_id), 'refresh');   
        
    }
    
    function update_patient_pass_profile($admin_id)
    {
        if($this->input->post('new_pass') == $this->input->post('confirm_pass')){
            $data['password']     = sha1($this->input->post('new_pass'));
            $this->db->where('admin_id',$admin_id);
            $this->db->update('admin', $data);   
            $this->session->set_flashdata('flash_message' , "Contraseña actualizada correctamente.");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($admin_id), 'refresh');   
        }else{
            $this->session->set_flashdata('flash_message' , "Hubo un error al actualizar la contraseña.");
            redirect(base_url() . 'doctor/doctor_security/'.base64_encode($admin_id), 'refresh');
        }
    }


    
    function getUsername($string= '')
    {
		  $pattern = " ";
		  $firstPart = strstr(strtolower($string), $pattern, true);
		  $secondPart = substr(strstr(strtolower($string), $pattern, false), 0,3);
		  $nrRand = rand(0, 100);
		  $username = trim($firstPart).trim($secondPart).trim($nrRand);
		  return $username; 
    }
    
    function get_age($dob)
    {
        $localtime = getdate();
        $today = $localtime['mday']."/".$localtime['mon']."/".$localtime['year'];
        $dob_a = explode("/", $dob);
        $today_a = explode("/", $today);
        $dob_d = $dob_a[0];$dob_m = $dob_a[1];$dob_y = $dob_a[2];
        $today_d = $today_a[0];$today_m = $today_a[1];$today_y = $today_a[2];
        $years = $today_y - $dob_y;
        $months = $today_m - $dob_m;
        if ($today_m.$today_d < $dob_m.$dob_d) 
        {
            $years--;
            $months = 12 + $today_m - $dob_m;
        }
    
        if ($today_d < $dob_d) 
        {
            $months--;
        }
    
        $firstMonths=array(1,3,5,7,8,10,12);
        $secondMonths=array(4,6,9,11);
        $thirdMonths=array(2);
    
        if($today_m - $dob_m == 1) 
        {
            if(in_array($dob_m, $firstMonths)) 
            {
                array_push($firstMonths, 0);
            }
            elseif(in_array($dob_m, $secondMonths)) 
            {
                array_push($secondMonths, 0);
            }elseif(in_array($dob_m, $thirdMonths)) 
            {
                array_push($thirdMonths, 0);
            }
        }
        if($years > 1){
            echo $years." <b>años</b>";
        }elseif($years == 1){
            echo $years ." <b>año</b>";
        }elseif($years == 0){
            echo $months." <b>meses</b>";
        }
    }
    
	function get_age_card($dob)
    {

        $hoy =date('Y-m-d');
        $fecha = explode("/", $dob);
        $date1 = new DateTime($hoy);
        $date2 = new DateTime($fecha[2].'-'.$fecha[1].'-'.$fecha[0]);
        $diff = $date1->diff($date2);


        if($diff->y > 1)
        {
            if($diff->m > 1)
            {
                return $diff->y." años y ".$diff->m." meses";
                
    
            }elseif($diff->m == 1)
            {

                return $diff->y." años y ".$diff->m."  mes";
    
            }elseif($diff->m == 0)
            {
                
                return $diff->y." años y ".$diff->m."  meses";
    
            }

        }elseif($diff->y == 1)
        {
            if($diff->m > 1)
            {
                return $diff->y." año y ".$diff->m." meses";
                
    
            }elseif($diff->m == 1)
            {

                return $diff->y." año y ".$diff->m."  mes";
    
            }elseif($diff->m == 0)
            {
                
                return $diff->y." año y ".$diff->m."  meses";
    
            }

        }elseif($diff->m > 1)
        {
            return $diff->m." meses";

        }elseif($diff->m == 1)
        {
            return $diff->m."  mes";

        }elseif($diff->d > 1)
        {
            return $diff->d." dias";

        }elseif($diff->d <= 1)
        {
            return $diff->d." dia";
        }

       
    }
    
    
        function get_age_list($dob)
    {
        $localtime = getdate();
        $today = $localtime['mday']."-".$localtime['mon']."-".$localtime['year'];
        $dob_a = explode("-", $dob);
        $today_a = explode("-", $today);
        $dob_d = $dob_a[0];$dob_m = $dob_a[1];$dob_y = $dob_a[2];
        $today_d = $today_a[0];$today_m = $today_a[1];$today_y = $today_a[2];
        $years = $today_y - $dob_y;
        $months = $today_m - $dob_m;
        if ($today_m.$today_d < $dob_m.$dob_d) 
        {
            $years--;
            $months = 12 + $today_m - $dob_m;
        }
    
        if ($today_d < $dob_d) 
        {
            $months--;
        }
    
        $firstMonths=array(1,3,5,7,8,10,12);
        $secondMonths=array(4,6,9,11);
        $thirdMonths=array(2);
    
        if($today_m - $dob_m == 1) 
        {
            if(in_array($dob_m, $firstMonths)) 
            {
                array_push($firstMonths, 0);
            }
            elseif(in_array($dob_m, $secondMonths)) 
            {
                array_push($secondMonths, 0);
            }elseif(in_array($dob_m, $thirdMonths)) 
            {
                array_push($thirdMonths, 0);
            }
        }
        if($years > 1){
            echo $years."  años";
        }elseif($years == 1){
            echo $years ." año";
        }elseif($years == 0){
            echo $months." meses";
        }
    }
    
    function percentage($gender, $clinic_id)
    {
        $cont = $this->db->get_where('patient',array('gender'=>$gender,'clinic_id'=>$clinic_id))->num_rows();
        $total = $this->db->get_where('patient',array('clinic_id'=>$clinic_id,'status'=>1))->num_rows();
        
        $porcentaje = ($cont/$total)*100;
        
        return $porcentaje;
    }
    
    function short_name($type, $user_id)
    {   
		if($type == 'staff')
		{
			$cat = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->category;
			
			$first_name = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->first_name;
			$last_name  = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->last_name;
			if($cat == 3)
			{
				return $first_name;
			}else
			{
				return $first_name." ".$last_name;
			}
			

		}else if($type == 'doctor'){
			$type = 'admin';
			
			$first_name = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->first_name;
			$last_name  = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->last_name;
			return $first_name." ".$last_name;

		}else{


			$first_name = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->first_name;
			$last_name  = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->last_name;
			return $first_name." ".$last_name;
		}
		
    }
    
    function getirstname($type, $user_id)
    {
		if($type == 'doctor')
		$type = 'admin';

        $first_name = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->first_name;
        return $first_name;
    }
    
    function get_name($type, $user_id)
    {
		if($type == 'doctor')
		$type = 'admin';

        $first_name = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->first_name;
        $last_name  = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->last_name;
        return $first_name." ".$last_name;
    }
    
      function get_name_provider($type, $user_id)
    {
		if($type == 'doctor')
		$type = 'admin';
        $first_name = $this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->first_name;
        return $first_name;
    }
    
    function get_last_name($type, $user_id)
    {
		if($type == 'doctor')
		$type = 'admin';


        $last_name  = explode(" ",$this->db->get_where($type, array(''.$type.''.'_id' => $user_id))->row()->last_name);
        return $last_name[0];
    }
    
    function get_photo($type_, $user_id) 
    {
		if($type_ != 'CF')
		{
			if($type_ == 'admin'){
				$typ = 'doctor';
			}elseif($type_ == 'staff'){
				$typ = 'staff';
			}else{
				$typ = 'patient';
			}

			if($type_ == 'doctor')
			$type_ = 'admin';

			$initial = strtoupper($this->db->get_where($type_, array(''.$type_.''.'_id' => $user_id))->row()->first_name[0]);
			$status = 0;
			$this->db->where($type_.'_id',$user_id);
			$imgs = $this->db->get($type_)->row()->photo;
			if($this->UR_exists(base_url()."public/uploads/".$typ."_image/".$imgs) && $imgs != '')
			{
				$image = base_url() . 'public/uploads/'.$typ.'_image/'.$imgs;
			}else{
				$image = base_url() . 'public/uploads/avatars/'.$initial.'.svg';   
			}

		}else
		{
			$image = base_url() . 'public/uploads/avatars/C.svg';

		}
		
        return $image;
    }
    
        function get_photo_third( $user_id) 
    {
        
        $initial = strtoupper($this->db->get_where('third', array('terceros_id' => $user_id))->row()->name[0]);
        $status = 0;
        $image = base_url() . 'public/uploads/avatars/'.$initial.'.svg';   
        
        return $image;
    }
    
    
    function check_patient_nit()
    {
        $num = $this->db->get_where('patient', array('patient_id' =>$this->input->post('code')))->num_rows();
        $response = array("available"  => $num);
        return $response;  
    }

 
    function getRoles() {
        return $this->db->get_where('role', array('status !='=>0));
    }
    
    function getRole($role_id) {
        return $this->db->get_where('role', array('role_id'=>$role_id))->row_array();
    }
    
    function newRoleUser() {
        $data['name']        = $this->input->post('name');
        $data['description'] = trim($this->input->post('description'));
        $this->db->insert('role', $data);
    }
    
    function editRoleUser($id) {
        $role_id = base64_decode($id);
        $data['name']        = $this->input->post('name');
        $data['description'] = trim($this->input->post('description'));
        $this->db->where('role_id', $role_id);
        return $this->db->update('role', $data);
    }
    
    function deactivateRoleUser() {
        $role_id = base64_decode($this->input->post('id'));
        $data['status'] = 2;
        $this->db->where('role_id', $role_id);
        echo $this->db->update('role', $data);
    }
    
    function activateRoleUser() {
        $role_id = base64_decode($this->input->post('id'));
        $data['status'] = 1;
        $this->db->where('role_id', $role_id);
        echo $this->db->update('role', $data);
    }
    
    function deleteRoleUser() {
        $role_id = base64_decode($this->input->post('id'));
        $data['status'] = 0;
        $this->db->where('role_id', $role_id);
        echo $this->db->update('role', $data);
    }
    
    function savePermissions($id) {
        $role_id = base64_decode($id);
        $perm = array();
        $perm['view_chat']           = $this->input->post('view_chat');
        $perm['view_admins']         = $this->input->post('view_admins');
        if ($this->input->post('view_admins') != '') {
            $perm['create_admins']   = $this->input->post('create_admins');
            $perm['edit_admins']     = $this->input->post('edit_admins');
            $perm['delete_admins']   = $this->input->post('delete_admins');
        } else {
            $perm['create_admins']   = '';
            $perm['edit_admins']     = '';
            $perm['delete_admins']   = '';
        }
        $perm['view_appointments']   = $this->input->post('view_appointments');
		if ($this->input->post('view_appointments') != '') {
            $perm['shedule_appointments']   = $this->input->post('shedule_appointments');
            $perm['access_appointments']     = $this->input->post('access_appointments');
        } else {
            $perm['shedule_appointments']   = '';
            $perm['access_appointments']     = '';
        }


        $perm['view_patients']       = $this->input->post('view_patients');
        if ($this->input->post('view_patients') != '') {
            $perm['create_patients'] = $this->input->post('create_patients');
            $perm['edit_patients']   = $this->input->post('edit_patients');
            $perm['delete_patients'] = $this->input->post('delete_patients');
        } else {
            $perm['create_patients'] = '';
            $perm['edit_patients']   = '';
            $perm['delete_patients'] = '';
        }
        $perm['view_stabilitation']  = $this->input->post('view_stabilitation');
        
        $perm['view_inventory']      = $this->input->post('view_inventory');
        $perm['add_inventory']      = $this->input->post('add_inventory');
        $perm['edit_inventory']      = $this->input->post('edit_inventory');
        $perm['delete_inventory']      = $this->input->post('delete_inventory');
        $perm['export_inventory']      = $this->input->post('export_inventory');
        $perm['import_inventory']      = $this->input->post('import_inventory');
        $perm['masive_delete_inventory']      = $this->input->post('masive_delete_inventory');
        
        
        
        $perm['view_payment_appointments']          = $this->input->post('view_payment_appointments');
        $perm['view_sales']          = $this->input->post('view_sales');
        
        $perm['view_payments_appointments']          = $this->input->post('view_payments_appointments');
        $perm['views_insurances']          = $this->input->post('views_insurances');
        $perm['view_clients']          = $this->input->post('view_clients');
        $perm['view_cotizations']          = $this->input->post('view_cotizations');
        $perm['view_all_sales']          = $this->input->post('view_all_sales');
        
        $perm['view_laboratories']   = $this->input->post('view_laboratories');
        $perm['view_rayx']           = $this->input->post('view_rayx');
        $perm['view_ultras']         = $this->input->post('view_ultras');
        $perm['view_plans']          = $this->input->post('view_plans');
        $perm['view_financial']      = $this->input->post('view_financial');
        $perm['view_reports']        = $this->input->post('view_reports');
        $perm['view_accounting']     = $this->input->post('view_accounting');
        $perm['view_banks']          = $this->input->post('view_banks');
        $perm['view_settings']       = $this->input->post('view_settings');
		$perm['view_marketing']      = $this->input->post('view_marketing');
        
        $data['permissions'] = serialize($perm);
        $this->db->where('role_id', $role_id);
        return $this->db->update('role', $data);
    }
    
    function getPermissionsRole($role_id) {
        return $this->db->get_where('role', array('role_id'=>$role_id))->row()->permissions;
    }


	//funciones Miiguel

	function entity_category_add()
	{
		$data['name'] = $this->input->post('name');
		$data['status'] = 1;
		$this->db->insert('category_entity', $data);
		return $this->db->insert_id();
	}
	function entity_category_update($param1 = "")
	{
		$data['name'] = $this->input->post('name');
		$this->db->where('category_entity_id', $param1);
		$this->db->update('category_entity', $data);
	}
		function entity_category_delete($param1 = "")
	{
		$data['status'] = 0;
		$this->db->where('category_entity_id', $param1);
		$this->db->update('category_entity', $data);
	}
	function new_entity($category_entity_id) {

        $data['first_name']      	= $this->input->post('full_name');
        $data['category_entity_id'] = $category_entity_id;
        $data['last_name']       	= $this->input->post('tradename');
        $data['email']           	= $this->input->post('email');  
        $data['phone']           	= $this->input->post('phone_1'); 
        $data['departamento_id']	= $this->input->post('departamento_id');  
        $data['municipio_id']   	= $this->input->post('municipio_id');  
        $data['address']        	= $this->input->post('address');
        $data['country']        	= $this->input->post('country');
        $data['city']            	= $this->input->post('city');
        $data['postal_code']     	= $this->input->post('postal_code');
        $data['outdoor_number']  	= $this->input->post('outdoor_number');
        $data['interior_number'] 	= $this->input->post('interior_number');
        $data['charge']          	= $this->input->post('charge');
        $data['status']          	= 1;   
        $data['since']           	= $this->formatDate();

        $this->db->insert('entity', $data);
        $entity_id = $this->db->insert_id();
        
        $dataProv['entity_id']             = $entity_id;
        $dataProv['application_date']     = $this->input->post('application_date');
        $dataProv['fiscal_address']       = $this->input->post('fiscal_address');
        $dataProv['commercial_address']   = $this->input->post('commercial_address');
        $dataProv['website']              = $this->input->post('website');
        $dataProv['nit']                  = $this->input->post('nit');
        $dataProv['area_code']            = $this->input->post('area_code');
        $dataProv['phone_2']              = $this->input->post('phone_2');
        $dataProv['phone_3']              = $this->input->post('phone_3');
        $dataProv['phone_contact']        = $this->input->post('phone_contact');
        $dataProv['full_name_legal']      = $this->input->post('full_name_legal');
        $dataProv['dpi_legal']            = $this->input->post('dpi_legal');
        $dataProv['commercial_patent']    = $this->input->post('commercial_patent');
        $dataProv['nit_legal']            = $this->input->post('nit_legal');
        $dataProv['full_name_represent']  = $this->input->post('full_name_represent');
        $dataProv['phone_represent']      = $this->input->post('phone_represent');
        $dataProv['email_represent']      = $this->input->post('email_represent');
        $dataProv['full_name_manager']    = $this->input->post('full_name_manager');
        $dataProv['phone_manager']        = $this->input->post('phone_manager');
        $dataProv['email_manager']        = $this->input->post('email_manager');
        $dataProv['full_name_accounts']   = $this->input->post('full_name_accounts');
        $dataProv['phone_accounts']       = $this->input->post('phone_accounts');
        $dataProv['email_accounts']       = $this->input->post('email_accounts');
        $dataProv['full_name_billing']    = $this->input->post('full_name_billing');
        $dataProv['phone_billing']        = $this->input->post('phone_billing');
        $dataProv['email_billing']        = $this->input->post('email_billing');
        $dataProv['full_name_finance']    = $this->input->post('full_name_finance');
        $dataProv['phone_finance']        = $this->input->post('phone_finance');
        $dataProv['email_finance']        = $this->input->post('email_finance');
        $dataProv['full_name_accounting'] = $this->input->post('full_name_accounting');
        $dataProv['phone_accounting']     = $this->input->post('phone_accounting');
        $dataProv['email_accounting']     = $this->input->post('email_accounting');
        $dataProv['provider_service_id']  = $this->input->post('provider_service_id');
        $dataProv['apply_fiscal']         = $this->input->post('apply_fiscal_legal');
        $dataProv['fiscal_data']          = $this->input->post('fiscal_data');
        $dataProv['credit_days']          = $this->input->post('credit_days');
        $this->db->insert('entity_data', $dataProv);

		for ($i=0; $i<count($this->input->post('first_name_reference')); $i++) {
            $first_name_reference = $this->input->post('first_name_reference')[$i];
            if ($first_name_reference != '') {
                $dataCom['first_name']     = $first_name_reference;
                $dataCom['last_name']      = $this->input->post('last_name_reference')[$i];
                $dataCom['phone']          = $this->input->post('phone_reference')[$i];
                $dataCom['company_person'] = $this->input->post('company_person_reference')[$i];
                $dataCom['entity_id']       = $entity_id;
                $this->db->insert('commercial_reference_entity', $dataCom);
            }
        }
        
        return $entity_id;
    }
    function edit_entity($entity_id) {

        $data['first_name']      	= $this->input->post('full_name');
        $data['last_name']       	= $this->input->post('tradename');
        $data['email']           	= $this->input->post('email');  
        $data['phone']           	= $this->input->post('phone_1'); 
        $data['departamento_id']	= $this->input->post('departamento_id');  
        $data['municipio_id']   	= $this->input->post('municipio_id');  
        $data['address']        	= $this->input->post('address');
        $data['country']        	= $this->input->post('country');
        $data['city']            	= $this->input->post('city');
        $data['postal_code']     	= $this->input->post('postal_code');
        $data['outdoor_number']  	= $this->input->post('outdoor_number');
        $data['interior_number'] 	= $this->input->post('interior_number');
        $data['charge']          	= $this->input->post('charge');
        $data['since']           	= $this->formatDate();

		$this->db->where("entity_id",$entity_id);
        $this->db->update('entity', $data);
        
        $dataProv['application_date']     = $this->input->post('application_date');
        $dataProv['fiscal_address']       = $this->input->post('fiscal_address');
        $dataProv['commercial_address']   = $this->input->post('commercial_address');
        $dataProv['website']              = $this->input->post('website');
        $dataProv['nit']                  = $this->input->post('nit');
        $dataProv['area_code']            = $this->input->post('area_code');
        $dataProv['phone_2']              = $this->input->post('phone_2');
        $dataProv['phone_3']              = $this->input->post('phone_3');
        $dataProv['phone_contact']        = $this->input->post('phone_contact');
        $dataProv['full_name_legal']      = $this->input->post('full_name_legal');
        $dataProv['dpi_legal']            = $this->input->post('dpi_legal');
        $dataProv['commercial_patent']    = $this->input->post('commercial_patent');
        $dataProv['nit_legal']            = $this->input->post('nit_legal');
        $dataProv['full_name_represent']  = $this->input->post('full_name_represent');
        $dataProv['phone_represent']      = $this->input->post('phone_represent');
        $dataProv['email_represent']      = $this->input->post('email_represent');
        $dataProv['full_name_manager']    = $this->input->post('full_name_manager');
        $dataProv['phone_manager']        = $this->input->post('phone_manager');
        $dataProv['email_manager']        = $this->input->post('email_manager');
        $dataProv['full_name_accounts']   = $this->input->post('full_name_accounts');
        $dataProv['phone_accounts']       = $this->input->post('phone_accounts');
        $dataProv['email_accounts']       = $this->input->post('email_accounts');
        $dataProv['full_name_billing']    = $this->input->post('full_name_billing');
        $dataProv['phone_billing']        = $this->input->post('phone_billing');
        $dataProv['email_billing']        = $this->input->post('email_billing');
        $dataProv['full_name_finance']    = $this->input->post('full_name_finance');
        $dataProv['phone_finance']        = $this->input->post('phone_finance');
        $dataProv['email_finance']        = $this->input->post('email_finance');
        $dataProv['full_name_accounting'] = $this->input->post('full_name_accounting');
        $dataProv['phone_accounting']     = $this->input->post('phone_accounting');
        $dataProv['email_accounting']     = $this->input->post('email_accounting');
        $dataProv['provider_service_id']  = $this->input->post('provider_service_id');
        $dataProv['apply_fiscal']         = $this->input->post('apply_fiscal_legal');
        $dataProv['fiscal_data']          = $this->input->post('fiscal_data');
        $dataProv['credit_days']          = $this->input->post('credit_days');
		$this->db->where("entity_id",$entity_id);
        $this->db->update('entity_data', $dataProv);

		for ($i=0; $i<count($this->input->post('commercial_reference_id')); $i++) {
            $first_name_reference = $this->input->post('first_name_reference')[$i];
            if ($first_name_reference != '') {
                $dataCom['first_name']     = $first_name_reference;
                $dataCom['last_name']      = $this->input->post('last_name_reference')[$i];
                $dataCom['phone']          = $this->input->post('phone_reference')[$i];
                $dataCom['company_person'] = $this->input->post('company_person_reference')[$i];
                $this->db->where('commercial_reference_entity_id', $this->input->post('commercial_reference_id')[$i]);
                $this->db->update('commercial_reference_entity', $dataCom);
            }
        }
    }

	function delete_entity($entity_id)
	{
		$data['status'] = 0;
		$this->db->where('entity_id',$entity_id);
		$this->db->update("entity",$data);
		$this->db->where('entity_id',$entity_id);
		$this->db->update("entity_data",$data);
		$this->db->where('entity_id',$entity_id);
		$this->db->update("commercial_reference_entity",$data);
	}

	function membership_plans_add()
	{
		$data["name"] = $this->input->post("name");
		$data["description"] = $this->input->post("description");
		$data["days"] = $this->input->post("days");
		$data["status"] = 1;
		$this->db->insert(("plans"), $data);
	}
	
	function membership_plans_edit($membership_plans_id)
	{
		$data["name"] = $this->input->post("name");
		$data["description"] = $this->input->post("description");
		$data["days"] = $this->input->post("days");
		$this->db->where("plans_id",$membership_plans_id);
		$this->db->update(("plans"), $data);
	}

	function membership_plans_delete($membership_plans_id)
	{
		$data["status"] = 0;
		$this->db->where("plans_id",$membership_plans_id);
		$this->db->update(("plans"), $data);
	}

	function assign_plan_to_membership($membership_id)
	{
		$data["membership_id"] = $membership_id;
		$data["plans_id"] = $this->input->post("plans_id");
		$data["price"] = $this->input->post("price");
		$data["status"] = 1;
		$this->db->insert("membership_plans",$data);
	}
	function edit_plan_to_membership($membership_plans_id)
	{
		$data["price"] = $this->input->post("price");
		$this->db->where("membership_plans_id",$membership_plans_id);
		$this->db->update("membership_plans",$data);
	}
	function delete_plan_to_membership($membership_plans_id)
	{
		$data["status"] = 0;
		$this->db->where("membership_plans_id",$membership_plans_id);
		$this->db->update("membership_plans",$data);
	}

}