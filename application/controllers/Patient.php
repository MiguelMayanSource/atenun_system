<?php
if (!defined('BASEPATH')) 
exit('No direct script access allowed');
include_once(dirname(__FILE__).'/Drive.php');
class Patient extends Drive
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('user_agent');
        $this->load->library('session'); 
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file')); 
    }
    
    
    public function index() 
    {       
        
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        
        redirect(base_url() . 'patient/dashboard/', 'refresh');
        
    }
    
    
    public function unsubscribe($param1 = '') 
    {       
        $page_data['_id']           = $param1;
        $this->load->view('backend/patient/unsuscribe.php', $page_data);
    }
    
    public function confirm_unsuscribe($param1 = '') 
    {       
        $data['email_status']       = 0;
        $this->db->where('patient_id',base64_decode($param1));
        $this->db->update('patient',$data);
    
        $page_data['_id']   = $param1;
        $page_data['page_name']   = 'unsuscribe';
        $page_data['page_title']  = "Desuscribir correo";
        $this->load->view('backend/patient/unsuscribe.php', $page_data);
    }
    
    
    function dashboard($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['id_']           = $param1;
        $page_data['page_name']     = 'dashboard';
        $page_data['page_title']    = "Tablero de paciente";
        $this->load->view('backend/index', $page_data);
    }
    
    function medical_history($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = $param1;
        $page_data['page_name']     = 'medical_history';
        $page_data['page_title']    = "Historial médico";
        $this->load->view('backend/index', $page_data);
    }
    
    function patient_security($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = $param1;
        $page_data['page_name']     = 'patient_security';
        $page_data['page_title']    = "Seguridad";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function patient_files($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
         if($param1 == 'download'){
            $patient_id = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->patient_id;
            $this->log_model->download_file($patient_id);
            $file_name  = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->name;
            $old_name  = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->old_name;
            $info = file_get_contents("public/uploads/patient_files/" . $file_name);
            force_download($old_name, $info);
        }

        $patient_folder = $this->db->get_where('patient',array('patient_id'=>base64_decode($param1)))->row()->folder;
        $have_folder = $this->db->get_where('settings',array('type'=>'folderId'))->row()->description;

        if ($patient_folder == 0 && $have_folder != '') 
        {
            log_message('error','Paciente carpeta');
            $this->createPatientFolder(base64_decode($param1));

        }
        
        $page_data['id_']           = $param1;
        $page_data['page_name']     = 'patient_files';
        $page_data['page_title']    = "Archivos";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function treatment($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = $param1;
        $page_data['page_name']     = 'treatment';
        $page_data['page_title']    = "Planes de tratamiento";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function patient_appointments($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = $param1;
        $page_data['page_name']     = 'patient_appointments';
        $page_data['page_title']    = 'Citas';
        $this->load->view('backend/index', $page_data);
    }
    
    function patient_financial($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'pdf')
        {
            $data = array(
                'appointment_id' => $param2
            );
            $hoy = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/generate_invoice.php',$data,TRUE); 
            $pdfFilePath = "recibo_Medicaby-".$hoy.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");
            
        }
        $page_data['id_']           = $param1;
        $page_data['page_name']     = 'patient_financial';
        $page_data['page_title']    = "Financiero";
        $this->load->view('backend/index', $page_data);
    }
    
    function update_medication_table($patient_id)
    {
        $refresh_query  = $this->db->order_by('medication_history_id', 'desc')->get_where('medication_history',array('patient_id' => $patient_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">';
                
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
    		            <td><i style="color:#00bb71;font-weight:bold;" class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></td>
        		        <td>'.$row['name'].'</td>
				        
		            </tr';   
		    }
		    $html_table .='</table>';
            echo $html_table;
        }else{
            echo '<br><center><img alt="Medicamentos" src="'.base_url().'public/uploads/medicamentos.svg" style="width:200px"></center><br><center>Sin historial de medicamentos.</center><br>';
        }
    }
    
    function refresh_patient_files($patient_id)
    {
        $refresh_query  = $this->db->get_where('patient_file',array('patient_id' => $patient_id));
        if($refresh_query->num_rows() > 0)
        {
		    foreach($refresh_query->result_array() as $row)
		    {

               
		        $html_table .= '
    		        <div class="col-sm-6">
    				    <a target="_blanck" href="'.base_url().'public/uploads/patient_files/'.$row['name'].'" class="v-project-files">
							<img src="'.$this->crud_model->get_format($row['format']).'" style="max-width:35px">
    					    <p class="v-project-files-name" data-toggle="tooltip" data-placement="top" title="'.$row['old_name'].'">'.substr($row['old_name'],0,30).' <span>'.$row['size'].' <object style="z-index:999"><a style="text-decoration:none;" href="javascript:void(0);" onclick="confirm_delete('.$row['patient_file_id'].')"><i style="font-size:16px;font-weight:bold;color:#fd4f57" class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a></object></span> </p>
						</a>
				    </div>';   
		    }
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay archivos subidos</h5><br><img src="'.base_url().'public/uploads/archivos_compartidos.svg" style="max-width:20%;"></center></div>';
        }
    }
    
    function update_password($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'change_pass')
        {
            $this->accounts_model->update_patient_pass($param2);
            redirect(base_url() . 'patient/patient_security/'.base64_encode($this->session->userdata('login_user_id')), 'refresh');
        }
    }
    
    
    function auth_two_factor($param1 = '', $param2 = '')
    {
        if($param1 == 'patient_auth_link')
        {
            $this->security_model->updateSecretPatient(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "Autenticación activada correctamente.");
            redirect(base_url() . 'patient/patient_security/'.base64_encode($this->session->userdata('login_user_id')), 'refresh');
        }
        
        if($param1 == 'remove_auth'){
            $this->security_model->remove_authPatient();
            $this->session->set_flashdata('flash_message' , "Autenticación desactivada correctamente.");
            redirect(base_url() . 'patient/patient_security/'.base64_encode($this->session->userdata('login_user_id')), 'refresh');
        }
        
        if($param1 == 'remove_sessions')
        {
            $this->security_model->remove_sessionsPatient();
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente, por favor inicie sesión nuevamente");
            redirect(base_url() . 'patient/patient_security/'.base64_encode($this->session->userdata('login_user_id')), 'refresh');
        }
    }
    
    
    function print_prescription($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
            $this->log_model->print_prescription($param1);
            
        $page_data['prescription_id']    = $param1;
        $this->load->view('backend/patient/print_prescription', $page_data);
    }
    
    
    function appointment_details($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = $param1;
        $page_data['page_name']     = 'appointment_details';
        $page_data['page_title']    = "Detalles de la Cita";
        $this->load->view('backend/index', $page_data);
    }
    
    function print_receipt($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['appointment_id']   = $param1;
        $this->load->view('backend/doctor/print_receipt', $page_data);
    }
    
    function treatment_details($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['id_']           = $param1;
        $page_data['page_name']     = 'treatment_details';
        $page_data['page_title']    = "Plan de tratamiento";
        $this->load->view('backend/index', $page_data);
    }
    
  
    
    
    function treatment_archive($param1 = '' ,$param2 = '' ,$param3 = '')
    {
         if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'email')
        {
            $patient_id         = $param3;
            $treatment_name     = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'treatment_id' => $param2,
                'patient_id' => $patient_id
            );
            $html = $this->load->view('backend/pdf_treatment.php',$data,TRUE); 
            $pdfFilePath = "Tratamiento_dental-".$treatment_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

            log_message('error', $email);
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Recibo electrónico") . '?=';
            $data2 = array(
                'patient_name' => $patient_name,
            );
            $mail->Body = $this->load->view('backend/mails/receipt.php',$data2,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");
            redirect(base_url() . 'doctor/treatment/'.base64_encode($patient_id), 'refresh');
        }
        
        
        if($param1 == 'pdf')
        {
            $patient_id         = $param3;
            $treatment_name     = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'treatment_id' => $param2,
                'patient_id' => $patient_id
            );
            $html = $this->load->view('backend/pdf_treatment.php',$data,TRUE); 
            $pdfFilePath = "Tratamiento_dental-".$treatment_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");  
        }
    }
    
    function get_contacts()
    {
        $html  ="";
        if($this->input->post('b'))
        {       
            $like = $this->input->post('b');
            $query = $this->db->query('SELECT admin_id, username, type, first_name, phone, status FROM admin WHERE status = "1" AND first_name LIKE "%'.$like.'%" OR last_name LIKE "%'.$like.'%"')->result_array();
            $query2 = $this->db->query('SELECT staff_id, username, type, first_name, phone, status FROM staff WHERE status = "1" AND first_name LIKE "%'.$like.'%" OR last_name LIKE "%'.$like.'%"')->result_array();
            $query3 = $this->db->query('SELECT patient_id, username, type, first_name, phone, status FROM patient WHERE status = "1" AND first_name LIKE "%'.$like.'%" OR last_name LIKE "%'.$like.'%"')->result_array();
  
                if(count($query) > 0)
                {
                    foreach ($query as $row) 
                    {
                        
                        $type = 'admin';
                      
                        $html  .= ' <li>
                        <div class="contact-box">
                        <div class="profile'; 
                        
                        if($this->crud_model->check_online_status($type, $row['admin_id']) > 0)
                        {
                            $html  .= ' online';
                        }else
                        {
                            $html  .= ' busy';
                        }
                        
                        $html  .= ' bg-size" style="background-image: url('.$this->accounts_model->get_photo($type, $row['admin_id']).'); background-size: cover; background-position: center center; display: block;">
                            </div>
                          <div class="details">
                            <h5>'.$this->accounts_model->short_name($type,$row['admin_id']).'</h5><h6>'.$row['phone'].'</h6>
                          </div>
                          <div class="contact-action">
                            <a class="icon-btn btn-outline-primary btn-sm button-effect" href='.base_url().'patient/messages/'.$row['username'].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></a>
                          </div>
                        </div>
                      </li>';


                       
                    }

                }

                if(count($query2) > 0)
                {
                    foreach ($query2 as $row2) 
                    {
                        
                        $type = 'staff';
                        $html  .= ' <li>
                        <div class="contact-box">
                        <div class="profile'; 
                        
                        if($this->crud_model->check_online_status($type, $row2['staff_id']) > 0)
                        {
                            $html  .= ' online';
                        }else
                        {
                            $html  .= ' busy';
                        }
                        
                        $html  .= ' bg-size" style="background-image: url('.$this->accounts_model->get_photo($type, $row2['staff_id']).'); background-size: cover; background-position: center center; display: block;">
                            </div>
                          <div class="details">
                            <h5>'.$this->accounts_model->short_name($type,$row2['staff_id']).'</h5><h6>'.$row2['phone'].'</h6>
                          </div>
                          <div class="contact-action">
                            <a class="icon-btn btn-outline-primary btn-sm button-effect" href='.base_url().'patient/messages/'.$row2['username'].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></a>
                          </div>
                        </div>
                      </li>';
                        
                    }

                }

          
                
                if(count($query) == 0 && count($query2) == 0 )
                {
                   $html .= '<div id="main-content">
                                <br><br>
                        	    <div class="row">
                        			<div class="main-table-card col-sm-12 m-b-30">
                        				<div class="card-box" style="border:0;"> 
                        					<div class="card-b" style="padding: 20px;">
                        					                                <h1 style="text-align:center;font-size:22px; font-weight:normal">Lo sentimos, no encontramos ninguna coincidencia para <b>'.$like.' </b> 😕 <br><br> <img src="https://miaula.com.gt/demo/uploads/no_results.png" style="width:50%"></h1>
                                                					</div>
                        				</div>
                        			</div>
                        		</div>
                        	</div>';
                }

                
            }

            echo $html;
    }



    function notifications($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->db->where('notification_id', $param2);
            $this->db->delete('notification');
            $this->session->set_flashdata('flash_message' , "Notificación eliminada correctamente.");
            redirect(base_url() . 'patient/notifications/'.$param3, 'refresh');
        }
        if($param1 == 'mark_read')
        {
            $data['read_status'] = 1;    
            $this->db->where('notification_id', $param2);
            $this->db->update('notification', $data);
            $this->session->set_flashdata('flash_message' , "Notificación actualizada correctamente.");
            redirect(base_url() . 'patient/notifications/'.$param3, 'refresh');
        }

        if($param1 == 'read')
        {
            $data['read_status'] = 1;    
            $this->db->where('to_user', $param2);
            $this->db->update('notification', $data);
        }

        
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']   = 'notifications';
        $page_data['page_title']  = "Mis notificaciones";
        $this->load->view('backend/index', $page_data);
    }

    function force_download_messages($file_name)
    {
        $this->load->helper('download');
        $data = file_get_contents("public/uploads/messages_files/" . $file_name);
        $name = $file_name;
        force_download($name, $data);
    }

    function print_prescription_details($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['appointment_id']    = $param1;
        $this->load->view('backend/doctor/print_prescription_details', $page_data);
    }


    function medical_prescriptions($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'pdf')
        {
            $patient_id = $this->db->get_where('appointment', array('appointment_id' => $param2))->row()->patient_id;
            $this->log_model->download_pdf($patient_id);
            $prescription_name = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            $data = array(
                'appointment_id' => $param2,
                'patient_id' => $patient_id, 
            );
            
            $hoy = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/generate_pdf.php',$data,TRUE); 
            $pdfFilePath = "prescripcion_medica-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");  
            
        }
        if($param1 == 'send')
        {
            $patient_id = $this->db->get_where('prescription', array('prescription_id' => $param2))->row()->patient_id;
            $prescription_name = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            $data = array(
                'prescription_id' => $param2
            );
            $hoy = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/generate_pdf.php',$data,TRUE); 
            $pdfFilePath = "prescripcion_medica-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "F");  
            
            $patient_id = $this->db->get_where('prescription', array('prescription_id' => $param2))->row()->patient_id;
            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;
            
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment($pdfFilePath,$pdfFilePath); 
            $mail->SetFrom($this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email, 'Confirmación de cita');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Receta médica electrónica") . '?=';
            $data = array(
                'patient_id' => $patient_id,
            );
        
            $mail->Body = $this->load->view('backend/mails/prescription.php',$data,TRUE);
            $mail->AddAddress($email);
            
            if($email != ''){
                if(!$mail->Send()) {
                    $this->session->set_flashdata('flash_message' , "La cita no se pudo confirmar");
                    redirect(base_url() . 'doctor/appointments/', 'refresh');
                }else
                {
                    $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
                    redirect(base_url() . 'doctor/appointments/', 'refresh');
                }
            }
            
            unlink($pdfFilePath);

        }
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'medical_prescriptions';
        $page_data['page_title']  = "Recetas";
        $this->load->view('backend/index', $page_data);
    }

    function sale_details_financial($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        
        if($param1 == 'email')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $this->db->get_where('cart', array('appointment_id' => $param2))->row()->cart_id;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'appointment_id' => $param2,
                'sale_id' => $sale_id
            );
            
            $html = $this->load->view('backend/pdf_recipe.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

            log_message('error', $email);
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Recibo electrónico") . '?=';
            $data2 = array(
                'patient_name' => $patient_name,
                'patient_id' => $patient_id,
            );
            $mail->Body = $this->load->view('backend/mails/receipt.php',$data2,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");
            redirect(base_url() . 'patient/patient_financial/'.base64_encode($patient_id), 'refresh');
        }
        
        
        if($param1 == 'pdf')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $this->db->get_where('cart', array('appointment_id' => $param2))->row()->cart_id;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'appointment_id' => $param2,
                'sale_id' => $sale_id
            );
            $html = $this->load->view('backend/pdf_recipe.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");     
        }


        if($param1 == 'email2')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $param2;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'sale_id' => $sale_id,
                'patient_id' => $patient_id
            );
            
            $html = $this->load->view('backend/pdf_recipe2.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

            log_message('error', $email);
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Recibo electrónico") . '?=';
            $data2 = array(
                'patient_name' => $patient_name,
                'patient_id' => $patient_id,
            );
            $mail->Body = $this->load->view('backend/mails/receipt.php',$data2,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");
            redirect(base_url() . 'staff/sale_details/'.base64_encode($param2), 'refresh');
        }
        

        if($param1 == 'pdf2')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $param2;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'sale_id' => $param2,
                'patient_id' => $patient_id
            );
            $html = $this->load->view('backend/pdf_recipe2.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");     
        }
    }


    function print_receipt2($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['cart_id']           = $param1;
        $page_data['patient_id']         = $param2;
        $this->load->view('backend/staff/print_receipt2', $page_data);
    }
    
    
    function update_prescription_table($appointment_id)
    {

        $status = $this->db->get_where('appointment', array('appointment_id'=>$appointment_id))->row()->status;

        $refresh_query  = $this->db->get_where('prescription',array('appointment_id' => $appointment_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Medicamento</th>
				        <th>Tomar</th>
				        <th>Frecuencia</th>
				        <th>Duración</th>';

                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$row['medicine'].'</td>
				        <td>'.$row['quantity'].'</td>
				        <td>'.$row['frequency'].'</td>
				        <td>'.$row['duration'].'</td>';

                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay medicamentos preescritos</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }

    function chat($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'send_message')
        {
            $this->session->set_flashdata('flash_message' , "Mensaje enviado correctamente.");
            $this->chat_model->send_chat_message($this->input->post('thread_code'));
            redirect(base_url() . 'patient/messages/' . $this->input->post('redirect'), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->chat_model->delete_chat($param2);
            $this->session->set_flashdata('flash_message' , "Mensaje eliminado correctamente.");
            redirect(base_url() . 'patient/chat/', 'refresh');
        }  
        if($param1 == 'delete_single')
        {
            $this->chat_model->delete_single_chat($param2);
            $this->session->set_flashdata('flash_message' , "Mensaje eliminado correctamente.");
            redirect(base_url() . 'patient/messages/'.$param3, 'refresh');
        }  
        $page_data['page_name']   = 'chat';
        $page_data['page_title']  = "Chat";
        $this->load->view('backend/patient/chat', $page_data);
    }
    
    function messages($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('patient_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        
        
        if(isset($_GET['notify'])){
            $update['read_status'] = 1;
            $this->db->where('message_id', $_GET['notify']);
            $this->db->update('message',$update);
        }
        $page_data['username'] = $param1;
        $page_data['page_name']   = 'messages';
        $page_data['page_title']  = "Mensajes";
        $this->load->view('backend/patient/messages', $page_data);
    }
    
}