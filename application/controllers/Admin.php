<?php 

    if (!defined('BASEPATH')) 
    exit('No direct script access allowed');
    //include_once(dirname(__FILE__).'/Drive.php');
class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('user_agent');
        $this->load->library('session'); 
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache'); 
        
        $this->check = unserialize($this->accounts_model->getPermissionsRole($this->db->get_where('admin',array('admin_id'=> $this->session->userdata('login_user_id')))->row()->role_id));
       
    }
    
    public function index() 
    { 
         $this->session_login();
        if ($this->session->userdata('admin_login') == 1)
        {
            redirect(base_url() . 'admin/panel/', 'refresh');
        }
    }

    function session_login()
    { 
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
    }
    
    function recibin()
    {
       print_r($this->fel->requestDocument('1'));
    }
    
    function password_change()
    {
        $data['password'] = sha1($this->input->post('pass'));
        $this->db->where('admin_id', $this->input->post('id'));
        $this->db->update('admin', $data);
    }
    
    
    function password_change_pass()
    {
        $data['password'] = sha1($this->input->post('pass'));
        $this->db->where('staff_id', $this->input->post('id'));
        $this->db->update('staff', $data);
    }
    
    function password_change_patient()
    {
        $data['password'] = sha1($this->input->post('pass'));
        $this->db->where('patient_id', $this->input->post('id'));
        $this->db->update('patient', $data);
    }
    
    
    
    function sales_order_entry_response($variant_id , $count=1)
    {
        $page_data['variant_id']    =   $variant_id;
        $page_data['count']         =   $count;
        $this->load->view('backend/admin/sales_order_entry' , $page_data);
    }
    
    function patients_list($param1 = '', $param2="")
    {
        $page_data['insurance_id']         = $param1;
        $page_data['page_name']   = 'patients_list';
        $page_data['page_title']  = "Pacientes";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function notifications($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'delete')
        {
            $this->db->where('notification_id', $param2);
            $this->db->delete('notification');
            $this->session->set_flashdata('flash_message' , "Notificación eliminada correctamente.");
            redirect(base_url() . 'admin/notifications/', 'refresh');
        }
        if($param1 == 'mark_read')
        {
            $data['read_status'] = 1;    
            $this->db->where('notification_id', $param2);
            $this->db->update('notification', $data);
            $this->session->set_flashdata('flash_message' , "Notificación actualizada correctamente.");
            redirect(base_url() . 'admin/notifications/', 'refresh');
        }
        
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']   = 'notifications';
        $page_data['page_title']  = "Mis notificaciones";
        $this->load->view('backend/index', $page_data);
    }
    
        function send_diary()
    {
        $this->accounts_model->diary();
    }
    
    
    function sales_order_append_entry_response($count , $selected_variants)
    {
        $page_data['count']                 =   $count;
        $page_data['selected_variants']     =   $selected_variants;
        $this->load->view('backend/admin/sales_order_append_entry' , $page_data);
    }

    
    function force_download_messages($file_name)
    {
        $this->load->helper('download');
        $data = file_get_contents("public/uploads/messages_files/" . $file_name);

        $name = $this->db->get_where('message',array('file_name'=>$file_name))->row()->original_file_name;

        if($name !="")
            force_download($name, $data);
        else
            force_download($file_name, $data);
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
                            <a class="icon-btn btn-outline-primary btn-sm button-effect" href='.base_url().'admin/messages/'.$row['username'].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></a>
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
                            <a class="icon-btn btn-outline-primary btn-sm button-effect" href='.base_url().'admin/chat_messages/'.$row2['username'].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></a>
                          </div>
                        </div>
                      </li>';
                        
                    }

                }

                if(count($query3) > 0)
                {
                    foreach ($query3 as $row3) 
                    {
                        
                        $type = 'patient';
                        $html  .= ' <li>
                        <div class="contact-box">
                        <div class="profile'; 
                        
                        if($this->crud_model->check_online_status($type, $row3['patient_id']) > 0)
                        {
                            $html  .= ' online';
                        }else
                        {
                            $html  .= ' busy';
                        }
                        
                        $html  .= ' bg-size" style="background-image: url('.$this->accounts_model->get_photo($type, $row3['patient_id']).'); background-size: cover; background-position: center center; display: block;">
                            </div>
                          <div class="details">
                            <h5>'.$this->accounts_model->short_name($type,$row3['patient_id']).'</h5><h6>'.$row3['phone'].'</h6>
                          </div>
                          <div class="contact-action">
                            <a class="icon-btn btn-outline-primary btn-sm button-effect" href='.base_url().'admin/chat_messages/'.$row3['username'].'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></a>
                          </div>
                        </div>
                      </li>';
                        
                    }

                }
                
                if(count($query) == 0 && count($query2) == 0 && count($query3) == 0  )
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
  
  
    function create_odonto_treatment()
    {   
        $this->appointment_model->create_odonto_treatment($this->session->userdata('login_user_id'),$this->session->userdata('login_type'));
    }
    
    

    /*
    function get_patients()
    {
        $json = [];
        $query = $this->db->get('patient')->result_array();
        foreach($query as $row)
        {
            $json[] = ['id'=>$row['patient_id'], 'text'=> $row['first_name']." ".$row['last_name']];
        }
        echo json_encode($json);
    }
    */
    
       function search($param1 = '', $param2 = '')
       {
        if($param1 == 'find'){
            redirect(base_url() . 'admin/search_results?key='.urlencode($this->input->post('search_key')), 'refresh');   
        }
        }
    
    function search_results($param1 = '', $param2 = '')
    {
         $this->session_login();
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        
        if($_GET['key'] != ''){
            $page_data['like'] = urldecode($_GET['key']);   
        }else
        {
             $page_data['like'] = "";   
        }
         
        $page_data['page_name']   = 'search_results';
        $page_data['page_title']  = "Resultados de la búsqueda";
        $this->load->view('backend/index', $page_data);
    }
    
    function print_prescription($param1 = '', $param2 = '')
    {
         $this->session_login();
        $this->log_model->print_prescription($param1);
        $page_data['prescription_id']   = base64_decode($param1);
        $this->load->view('backend/admin/print_prescription', $page_data);
    }
    
    
    function print_receipt($param1 = '', $param2 = '')
    {
        $this->session_login();
        
        $data = array(
            'emision_id' => $param1,
        );
        $this->pdf_model->pdf('Factura','print_receipt.php',$data);

    }
    
     
    function print_cotizacion($param1 = '', $param2 = '')
    {
        $this->session_login();
        
        $data = array(
            'sale_id' => $param1,
        );
        $this->pdf_model->pdf('Cotizacion','print_cotizacion.php',$data);

    }
    
    function print_solicitud($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['pedidos_id']           = $param1;
        $this->load->view('backend/admin/print_solicitud', $page_data);
    }

    function print_financial_report($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['fecha1']           = $param1;
        $page_data['fecha2']           = $param2;
        $this->load->view('backend/admin/print_finance_reports', $page_data);
    }


    function print_inventory_report($param1 = '', $param2 = '')
    {
         $this->session_login();

        if($param1 == 'all')
        {
            $data['result'] = $this->crud_model->count_cost()->result_array();
            $data['type'] = 'TODOS LOS PRODUCTOS';
        }
        if($param1 == 'alert')
        {
            $data['result'] = $this->crud_model->count_alert();
            $data['type'] = 'PRODUCTOS EN ALERTA';
        }
        if($param1 == 'per_expirate')
        {
            $data['result'] = $this->crud_model->product_per_expiration();
            $data['type'] = 'PRODUCTOS POR EXPIRAR';
        }
        if($param1 == 'expirate')
        {
            $data['result'] = $this->crud_model->product_expiration()->result_array();
            $data['type'] = 'PRODUCTOS EXPIRADOS';
        }
        if($param1 == 'out')
        {
            $data['result'] = $this->crud_model->product_outstock();
            $data['type'] = 'PRODUCTOS AGOTADOS';
        }
        $this->load->view('backend/admin/print_inventory_reports', $data);
    }
    
    
    function print_receipt2($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['cart_id']           = $param1;
        $page_data['patient_id']         = $param2;
        $this->load->view('backend/admin/print_receipt2', $page_data);
    }
    
    function survey_results($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['codigo'] =  $param1;
        $page_data['page_name']   = 'survey_results';
        $page_data['page_title']  = "Resultados de la encuesta";
        $this->load->view('backend/index', $page_data);
    }
    
   
    /*
    function subscription($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'create')
        {
            $data['clinic_id']      = $this->session->userdata('current_clinic');
            $data['code']           = strtoupper(substr(md5(rand()), 0, 8));
            $data['expiration']     = '';
            $data['method']         = $this->input->post('response');
            $data['purchase_date']  = date('d/m/Y');
            $data['confirmed_date'] = '';
            $data['comment']        = $this->input->post('comment');
            if($this->input->post('isAnual') == '1'){
                $data['total_amount']   = $this->input->post('totalPrice')*12;
            }else{
                $data['total_amount']   = $this->input->post('totalPrice');   
            }
            $data['status']         = 0;
            $this->db->insert('suscription', $data);
            $this->session->set_flashdata('flash_message' , "Acción completada correctamente.");
            redirect(base_url() . 'admin/confirmed/'.$data['code'], 'refresh');
        }
        if($param1 == 'cancel'){
            $this->db->where('code', $param2);
            $this->db->delete('suscription');
            $this->session->set_flashdata('flash_message' , "Factura cancelada correctamente.");
            redirect(base_url() . 'admin/subscription/', 'refresh');
        }
        $page_data['page_name']   = 'subscription';
        $page_data['page_title']  = "Tu suscripción";
        $this->load->view('backend/index', $page_data);
    }
    */
    
    function confirmed($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['type'] = $param2;
        $page_data['code'] = $param1;
        $page_data['page_name']   = 'confirmed';
        $page_data['page_title']  = "Tu suscripción ha sido confirmada";
        $this->load->view('backend/index', $page_data);
    }
    
    function get_reply($code = '', $patient_id = '')
    {
        $questions = $this->db->get_where('question', array('survey_id' => $code))->result_array();
        foreach($questions as $rows)
        {
            $html = '<div class="card-box m-b-30">
                <div class="card-h">
                	<h2 class="card-caption"> 
                		 <span>'. $rows['question'].'</span>
                	</h2>
                </div>
                <table class="table table-bordered">';
                    
                    $submitted_answer = $this->db->get_where('survery_result', array('survey_id' => $code,'patient_id' => $patient_id))->result_array();
                	foreach ($submitted_answer as $row_answer)
                	{
                		                
                		$html .= '
                		<tr>
                            <td>';
                                $reply = json_decode($row_answer['answer_script'], true);
                                foreach($reply as $repl)
                                {
                                    if ($rows['question_id']== $repl['question_id'])
                                    {
                                        $v1 = str_replace('["','',$repl['submitted_answer']);
                                        $v2 = str_replace('"]','',$v1);
                                        $type = $this->db->get_where('question', array('question_id' => $repl['question_id']))->row()->type;
                                        $html .= $v2;
                                    }
                                }
                        $html .= '</td>
                		 </tr>';
                	}
                $html .= '</table>
            </div>';
            echo $html;
	   }
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
        		        <td>'.$row['name'].'</td>
				        <td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_element('.$row['medication_history_id'].')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>
		            </tr';   
		    }
		    $html_table .='</table>';
            echo $html_table;
        }else{
            echo '<br><center><img alt="Medicamentos" src="'.base_url().'public/uploads/medicamentos.svg" style="width:200px"></center><br><center>Sin historial de medicamentos.</center><br>';
        }
    }
    
    
    function medication_history($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'delete')
        {
            $this->db->where('medication_history_id', $param2);
            $this->db->delete('medication_history');
            return true;
        }
        if($param1 == 'create')
        {
            $data['name']             = $this->input->post('medicament');
            $data['prescription_id']  = 0;
            $data['date']             = $this->crud_model->formatDate();
            $data['patient_id']       = $this->input->post('patient_id');
            $this->db->insert('medication_history', $data);
            return true;
        }
        $page_data['page_name']   = 'medication_history';
        $page_data['page_title']  = "Medicaciones";
        $this->load->view('backend/index', $page_data);
    }
    
    function update_allergie_table($patient_id)
    {
        $refresh_query  = $this->db->order_by('allergie_id', 'desc')->get_where('allergie',array('patient_id' => $patient_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$row['name'].'</td>
		            </tr';   
		    }
		    $html_table .='</table>';
            echo $html_table;
        }else{
            echo '';
        }
    }
    
    
    function update_prescription_table($code)
    {

        $status = $this->db->get_where('prescription_ref', array('code'=>$code))->row()->status;

        $refresh_query  = $this->db->get_where('prescription',array('code' => $code));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Medicamento</th>';

                    if($status == 1 || $status == 0)
				        $html_table .= '<th>-</th>';
                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
                    <td><pre>'.$row['medicine'].'</pre></td>';
                        if($status == 1 || $status == 0)
				        $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_element('.$row['prescription_id'].',\''.$code.'\')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                        
                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay medicamentos preescritos</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }
    

 function update_discount_table_est($stabilitation_id)
    {
        $status = $this->db->get_where('stabilitation_ref', array('stabilitation_ref_id'=>$stabilitation_id))->row()->status;
        $refresh_query  = $this->db->get_where('stabilitation_discount',array('stabilitation_ref_id' => $stabilitation_id));
        
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Cantidad</th>
				        <th>Descripción</th>';

                    if($status == 1 || $status == 0)
				        $html_table .= '<th>-</th>';
                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.number_format($row['amount'],2,'.',',').'</td>
				        <td>'.$row['description'].'</td>';

                        if($status == 1 || $status == 0)
				        $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_discount('.$row['stabilitation_discount_id'].','.$stabilitation_id.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay descuentos agregados.</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }
    
    function update_prescription_table_est($stabilitation_id)
    {
        $status = $this->db->get_where('stabilitation', array('stabilitation_id'=>$stabilitation_id))->row()->status;

        $refresh_query  = $this->db->get_where('prescription_estb',array('stabilitation_id' => $stabilitation_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Medicamento</th>
				        <th>Tomar</th>
				        <th>Frecuencia</th>
				        <th>Duración</th>';

                    if($status == 1 || $status == 0)
				        $html_table .= '<th>-</th>';
                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$row['medicine'].'</td>
				        <td>'.$row['quantity'].'</td>
				        <td>'.$row['frequency'].'</td>
				        <td>'.$row['duration'].'</td>';

                        if($status == 1 || $status == 0)
				        $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_treatment('.$row['prescription_estb_id'].','.$stabilitation.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                        
                        
                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay medicamentos preescritos</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }
    
    function update_laboratory_table_est($stabilitation)
    {

        $status = $this->db->get_where('stabilitation', array('stabilitation_id'=>$stabilitation_id))->row()->status;

        $refresh_query  = $this->db->get_where('laboratory_est',array('stabilitation_id' => $stabilitation));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Nombre</th>
				        <th>Precio</th>
				        ';

                    if($status == 1 || $status == 0)
				        $html_table .= '<th>-</th>';
                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$this->db->get_where('laboratory', array('laboratory_id'=>$row['laboratory_id']))->row()->name.'</td>
				        <td>'.$row['price'].'</td>';

                        if($status == 1 || $status == 0)
				        $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_laboratory('.$row['laboratory_est_id'].','.$stabilitation.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                        
                        
                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay laboratorios registrados</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }


    function update_rayos_x_table_est($stabilitation)
    {

        $status = $this->db->get_where('stabilitation', array('stabilitation_id'=>$stabilitation_id))->row()->status;

        $refresh_query  = $this->db->get_where('rayos_x_est',array('stabilitation_id' => $stabilitation));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Nombre</th>
				        <th>Precio</th>
				        ';

                    if($status == 1 || $status == 0)
				        $html_table .= '<th>-</th>';
                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$this->db->get_where('rayos_x', array('rayos_x_id'=>$row['rayos_x_id']))->row()->name.'</td>
				        <td>'.$row['price'].'</td>';

                        if($status == 1 || $status == 0)
				        $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_rayos_x('.$row['rayos_x_est_id'].','.$stabilitation.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                        
                        
                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay laboratorios registrados</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }


    function update_insumo_table($stabilitation)
    {

        $status = $this->db->get_where('stabilitation', array('stabilitation_id'=>$stabilitation_id))->row()->status;

        $refresh_query  = $this->db->get_where('stabilitation_insum',array('stabilitation_id' => $stabilitation));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Nombre</th>
				        <th>Precio</th>
				        <th>Cantidad</th>
                        <th>Descuento</th>
                        <th>Subtotal</th>';

                    if($status == 0)
				        $html_table .= '<th>-</th>';
                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$this->db->get_where('product', array('product_id'=>$row['product_estb_id']))->row()->name.'</td>
				        <td>'.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency.'. '.$row['price'].'</td>';
                        $html_table .= '<td> '.$row['cantidad'].' </td>';
                        $html_table .= '<td> '.$row['discount'].' </td>';
                        $html_table .= '<td> '.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency.'. '.$row['subtotal'].' </td>';
                        if($status == 0)
                        
				        $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_insumo('.$row['stabilitation_insum_id'].','.$stabilitation.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay laboratorios registrados</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }


    function update_service_table($stabilitation)
    {

        $status = $this->db->get_where('stabilitation', array('stabilitation_id'=>$stabilitation_id))->row()->status;

        $refresh_query  = $this->db->get_where('stabilitation_service',array('stabilitation_id' => $stabilitation));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Nombre</th>
				        <th>Precio</th>
				        <th>cantidad</th>
				        ';

                        if($status == 0)
				        $html_table .= '<th>-</th>';
                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$this->db->get_where('service', array('service_id'=>$row['service_id']))->row()->name.'</td>
				        <td>'.$row['price'].'</td>
                        <td> '.$row['cantidad'].' </td>';
                        if($status == 0)
                        
				        $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_service('.$row['stabilitation_service_id'].','.$stabilitation.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay laboratorios registrados</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }

    function update_laboratory_table($appointment_id)
    {

        $status = $this->db->get_where('appointment', array('appointment_id'=>$appointment_id))->row()->status;

        $refresh_query  = $this->db->get_where('laboratory_app',array('appointment_id' => $appointment_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Laboratorio</th>
				        <th>Precio</th>
				        ';

                    if($status == 1 || $status == 0)
				        $html_table .= '<th>-</th>';
                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$this->db->get_where('laboratory', array('laboratory_id'=>$row['laboratory_id']))->row()->name.'</td>
				        <td>'.$row['price'].'</td>';

                        if($status == 1 || $status == 0)
				        $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_laboratory('.$row['laboratory_app_id'].','.$appointment_id.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                        
                        
                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay laboratorios registrados</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }


    function update_rayos_x($appointment_id)
    {

        $status = $this->db->get_where('appointment', array('appointment_id'=>$appointment_id))->row()->status;

        $refresh_query  = $this->db->get_where('rayos_x_app',array('appointment_id' => $appointment_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Rayos X</th>
				        <th>Precio</th>
				        ';

                    if($status == 1 || $status == 0)
				        $html_table .= '<th>-</th>';
                        $html_table .= '</tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$this->db->get_where('rayos_x', array('rayos_x_id'=>$row['rayos_x_id']))->row()->name.'</td>
				        <td>'.$row['price'].'</td>';

                        if($status == 1 || $status == 0)
				        $html_table .= '<td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_rayos_x('.$row['rayos_x_app_id'].','.$appointment_id.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>';
                        
                        
                        $html_table .= '</tr>';   
		    }
		    $html_table .='</table>';
            
            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay laboratorios registrados</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
        }
    }
    
    
        function update_prescription_sale($appointment_id)
    {
        $refresh_query  = $this->db->get_where('prescription',array('appointment_id' => $appointment_id));
        if($refresh_query->num_rows() > 0)
        {
            $html_table = '
                <table class="table">
		            <tr style="background-color:#f9fbfc; color:#59636d">
        				<th>Medicamento</th>
				        <th>Tomar</th>
				        <th>Frecuencia</th>
				        <th>Duración</th>
				        <th>-</th>
		            </tr>';
		    foreach($refresh_query->result_array() as $row)
		    {
		        $html_table .= '
    		        <tr>
        		        <td>'.$row['medicine'].'</td>
				        <td>'.$row['quantity'].'</td>
				        <td>'.$row['frequency'].'</td>
				        <td>'.$row['duration'].'</td>
				        <td><i style="color:#fd4f57;font-weight:bold;" onClick="delete_element('.$row['prescription_id'].')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>
		            </tr>';   
		    }
		    $html_table .='</table>';
            echo $html_table;
        }else{
            echo '';
        }
    }
    
    
    ///////Dientes tabla ////////
    
    
    function tooth()
    {
        $this->session_login();
        


        $checked = $this->input->post('process');
        $total_checked_values = count($checked);
        $permissions = '';
        for ($i = 0; $i < $total_checked_values; $i++) 
        {


            $data['doctor_id']           = $this->input->post('doctor_id');
            $data['patient_id']          = $this->input->post('patient_id');
            $data['appointment_id']      = $this->input->post('appointment_id');
            $data['tooth_id']            = $this->input->post('tooth_id');
            $data['face']                = $this->input->post('face');
            $data['date']                = $this->crud_model->formatDate();
            $data['diagnosis']           = $this->input->post('diagnosis');
            $data['process']             = $checked[$i];
            $data['commentary']          = $this->input->post('commentary');
            $data['status']              = 0;
          
            $this->db->insert('treatment', $data);

        }
            return true; 
             
    }
    
    
    function delete_tooth_treatment($param1 = '' )
    {
        $this->session_login();
        
        $this->db->where('tooth_treatment_id', $param1);
        $this->db->delete('tooth_treatment');
        return true;
        
    }
    
    function set_status_treatment($param1 = '', $param2 = '')
    {
        $this->session_login();
        
        $data['status']     = 1;
        $this->db->where('tooth_treatment_id', $param1);
        $this->db->update('tooth_treatment', $data);
        
        $data22['status']     = 1;
        $this->db->where('treatment_id', $param2);
        $this->db->update('odonto_treatment', $data22);
        return true;
        
    }
    
    function prescriptions($param1 = '', $param2 = '')
    {
         $this->session_login();

        if($param1 == 'delete')
        {
            $this->db->where('code', $param2);
            $this->db->delete('prescription_ref');
            
            $this->db->where('code', $param2);
            $this->db->delete('prescription');
            
            return true;
        }

        if($param1 == 'delete_medicine')
        {
            
            $this->db->where('prescription_id', $param2);
            $this->db->delete('prescription');
            
            return true;
        }

        if($param1 == 'create')
        {
            
            $this->db->where('code', $this->input->post('code'));
            $prescription_ref = $this->db->get('prescription_ref')->num_rows();

            if($prescription_ref == 0)
            {
    
                $datar['code'] = $this->input->post('code');
                $datar['patient_id'] = $this->input->post('patient_id');
                $datar['observations'] = '';
                $datar['status'] = 1;
                $datar['user_id'] = $this->session->userdata('login_user_id');
                $datar['user_type'] = $this->session->userdata('login_type');

                $this->db->insert('prescription_ref',$datar);
            }

            $data['medicine']        = $this->input->post('medicine');
            $data['date']            = $this->crud_model->formatDate();
            $data['code']            = $this->input->post('code');
            $data['patient_id']      = $this->input->post('patient_id');
            $this->db->insert('prescription', $data);
            $prescription_id = $this->db->insert_id();
           
            $sugest = $this->input->post('sugest_id');
            if($sugest == 0){
                
                $dataSugest['name'] = $this->input->post('medicine');
                $this->db->insert('medicine_sugest', $dataSugest);
            }else
            {
                $this->db->where('medicine_sugest_id',$this->input->post('sugest_id'));
                $dataSugest['name'] = $this->input->post('medicine');
                $this->db->update('medicine_sugest', $dataSugest);

            }

            return true;
        }


        if($param1 == 'create_estb')
        {
            $patient_id = $this->db->get_where('stabilitation', array('stabilitation_id' => $this->input->post('stabilitation_id')))->row()->patient_id;
            $data['medicine']  = $this->input->post('medicine');
            $data['quantity']  = $this->input->post('quantity');
            $data['frequency'] = $this->input->post('frequency');
            $data['duration']  = $this->input->post('duration');
            $data['patient_id']= $this->input->post('patient_id');
            $data['date']      = $this->crud_model->formatDate();
            
            $data['stabilitation_id']  = $this->input->post('stabilitation_id');
            $this->db->insert('prescription_estb', $data);
            $prescription_id = $this->db->insert_id();
            
            return true;
        }

        if($param1 == 'delete_estb')
        {
            $this->db->where('prescription_id', $param2);
            $this->db->delete('prescription');
            
            return true;
        }

        if($param1 == 'prescription_details')
        {
            $data = array(
                'code' => $param2,
            );
            $this->pdf_model->pdf('Receta médica','prescription_details.php',$data);
        }

        if($param1 == 'addObservations')
        {
            $code = $this->input->post('code');
            $value = $this->input->post('value');
            $patient_id = $this->input->post('patient_id');
            
         
            
            $this->db->where('code', $code);
            $prescription_ref = $this->db->get('prescription_ref')->num_rows();

            if($prescription_ref > 0)
            {
    
                $data['observations'] = $value;
                $this->db->where('code',  $code);
                return $this->db->update('prescription_ref',$data);
               
            }else
            {
                $data['code'] = $code;
                $data['patient_id'] = $patient_id;
                $data['observations'] = $value;
                $data['status'] = 0;
                $data['user_id'] = $this->session->userdata('login_user_id');
                $data['user_type'] = $this->session->userdata('login_type');

                return $this->db->insert('prescription_ref',$data);
            }

            
            exit();
        }


        $page_data['page_name']   = 'prescriptions';
        $page_data['page_title']  = "Recetas";
        $this->load->view('backend/index', $page_data);
    }
    
  
    public function includes($param1 = '')
    {
      
        # code...
        //Cargar la lista de recetas de un paciente.
        if($param1 == 'patient_prescriptions')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $this->load->view('backend/includes/patient_prescriptions.php', $page_data);
        }

        if($param1 == 'new_prescription')
        {
            # code...
            $this->load->view('backend/includes/new_prescription.php', $page_data);
        }

        if($param1 == 'patient_order')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $this->load->view('backend/includes/patient_order.php', $page_data);
        }

        if($param1 == 'new_order')
        {
            # code...
            $this->load->view('backend/includes/new_order.php', $page_data);
        }
        if($param1 == 'edit_order')
        {
            # code...
            $page_data['medic_order_id'] = $this->input->post('medic_order_id');
            $this->load->view('backend/includes/edit_order.php', $page_data);
        }

        if($param1 == 'patient_labs')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['origin_type'] = $this->input->post('origin_type');
            $page_data['origin_id'] = $this->input->post('origin_id');
            $this->load->view('backend/includes/patient_labs.php', $page_data);
        }

        if($param1 == 'new_labs')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['origin_type'] = $this->input->post('origin_type');
            $page_data['origin_id'] = $this->input->post('origin_id');
            $this->load->view('backend/includes/new_labs.php', $page_data);
        }
        
          if($param1 == 'patient_rayx')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['origin_type'] = $this->input->post('origin_type');
            $page_data['origin_id'] = $this->input->post('origin_id');
            $this->load->view('backend/includes/patient_rayx.php', $page_data);
        }
        
        
         if($param1 == 'new_rayx')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['origin_type'] = $this->input->post('origin_type');
            $page_data['origin_id'] = $this->input->post('origin_id');
            $this->load->view('backend/includes/new_rayx.php', $page_data);
        }
        
           if($param1 == 'patient_ultras')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['origin_type'] = $this->input->post('origin_type');
            $page_data['origin_id'] = $this->input->post('origin_id');
            $this->load->view('backend/includes/patient_ultras.php', $page_data);
        }
        
        
         if($param1 == 'new_ultras')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['origin_type'] = $this->input->post('origin_type');
            $page_data['origin_id'] = $this->input->post('origin_id');
            $this->load->view('backend/includes/new_ultras.php', $page_data);
        }
        if($param1 == 'edit_labs')
        {
            # code...
            $page_data['medic_order_id'] = $this->input->post('medic_order_id');
            $this->load->view('backend/includes/edit_labs.php', $page_data);
        }

        
        if($param1 == 'nurse_notes')
        {
            # code...
            $page_data['stabilitation_id'] = $this->input->post('stabilitation_id');
            $this->load->view('backend/includes/nurse_notes.php', $page_data);
        }

        if($param1 == 'new_nurse_note')
        {
            # code...
            $page_data['stabilitation_id'] = $this->input->post('stabilitation_id');
            $this->load->view('backend/includes/new_nurse_note.php', $page_data);
        }

        if($param1 == 'medication_supplied')
        {
            # code...
            $page_data['stabilitation_id'] = $this->input->post('stabilitation_id');
            $this->load->view('backend/includes/medication_supplied.php', $page_data);
        }

        if($param1 == 'new_medication_supplied')
        {
            # code...
            $page_data['stabilitation_id'] = $this->input->post('stabilitation_id');
            $this->load->view('backend/includes/new_medication_supplied.php', $page_data);
        }


        if($param1 == 'patient_vital_signs')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $this->load->view('backend/includes/patient_vital_signs.php', $page_data);
        }

        if($param1 == 'new_patient_vital_signs')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $this->load->view('backend/includes/new_patient_vital_signs.php', $page_data);
        }

        if($param1 == 'patient_files')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            
            if($this->input->post('parent_id') != '')
                $page_data['parent_id'] = $this->input->post('parent_id');
            else
                $page_data['parent_id'] = 0;

            $this->load->view('backend/includes/patient_files.php', $page_data);
        }

        if($param1 == 'patient_turns')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['stabilitation_id'] = $this->input->post('stabilitation_id');
            $this->load->view('backend/includes/patient_turns.php', $page_data);
        }

        if($param1 == 'end_turn')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['stabilitation_id'] = $this->input->post('stabilitation_id');
            $this->load->view('backend/includes/patient_end_turn.php', $page_data);
        }
        
        if($param1 == 'patient_extras')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['origin_type'] = $this->input->post('origin_type');
            $page_data['origin_id'] = $this->input->post('origin_id');
            $this->load->view('backend/includes/patient_extras.php', $page_data);
        }
        
        if($param1 == 'new_patient_extras')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['origin_type'] = $this->input->post('origin_type');
            $page_data['origin_id'] = $this->input->post('origin_id');
            $this->load->view('backend/includes/new_patient_extras.php', $page_data);
        }
        
        if($param1 == 'complete_evol')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $this->load->view('backend/includes/patient_appointments3.php', $page_data);
        }
        
         if($param1 == 'appointments')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $this->load->view('backend/includes/patient_appointments2.php', $page_data);
        }


        if($param1 == 'patient_consent')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['origin_type'] = $this->input->post('origin_type');
            $page_data['origin_id'] = $this->input->post('origin_id');
            $this->load->view('backend/includes/patient_consent.php', $page_data);
        }
        
        if($param1 == 'new_patient_consent')
        {
            # code...
            $page_data['patient_id'] = $this->input->post('patient_id');
            $page_data['origin_type'] = $this->input->post('origin_type');
            $page_data['origin_id'] = $this->input->post('origin_id');
            $this->load->view('backend/includes/new_patient_consent.php', $page_data);
        }


    }
    

    function patient_consent($param1 = '', $param2 = '')
    {
          if($param1 == 'add_consent'){

            if($this->session->userdata('login_type') != "doctor")
            $user_type = $this->session->userdata('login_type');
            else
            $user_type = 'admin';
            

            $data = array(
                'patient_id' => $this->input->post('patient_id'),
                'date_solicite' => $this->input->post('date_solicite'),
                'motive' => $this->input->post('motive'),
                'details' => $this->input->post('details'),
                'user_id' => $this->session->userdata('login_user_id'),
                'user_type' => $user_type,
                'status' => 0
            );

            $this->db->insert('patient_consent',$data);

            exit();
        }

        if($param1 == 'print_consent')
        {
            $data = array(
                'patient_consent_id' => $param2,
            );
            $this->pdf_model->pdf('Consentimiento Informado','print_consent.php',$data);
        }

    }

    function forms($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'apply'){
            $this->crud_model->apply_forms();
            $this->session->set_flashdata('flash_message' , "Formularios aplicados correctamente.");
            redirect(base_url() . 'admin/forms/', 'refresh');
        }
        $page_data['page_name']   = 'forms';
        $page_data['page_title']  = "Formularios";
        $this->load->view('backend/index', $page_data);
    }
    
    function sale_details($param1 = '', $param2 = '', $param3 = '')
    {
         $this->session_login();
        
        if($param1 == 'email')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $this->db->get_where('cart', array('appointment_id' => $param2))->row()->cart_id;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'appointment_id' => $param2,
                'sale_id' => $sale_id,
                'patient_id' => $patient_id
            );
            
            $html = $this->load->view('backend/pdf_recipe.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

           
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
            redirect(base_url() . 'admin/sale_details/'.base64_encode($sale_id), 'refresh');
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
            redirect(base_url() . 'admin/sale_details/'.base64_encode($param2), 'refresh');
        }
        
        
        if($param1 == 'pdf')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $this->db->get_where('cart', array('appointment_id' => $param2))->row()->cart_id;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'appointment_id' => $param2,
                'sale_id' => $sale_id,
                'patient_id' => $patient_id
            );
            $html = $this->load->view('backend/pdf_recipe.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($pdfFilePath, "D");     
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

        if($param1 == 'anular')
        {
            $this->session->set_flashdata('flash_message' , "Factura anulada.");
            //redirect(base_url() . 'admin/sale_details/'.base64_encode($param2), 'refresh');
        }
        
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'sale_details';
        $page_data['page_title']  = "Detalles de la venta";
        $this->load->view('backend/index', $page_data);
    }
    
    
    
    function sale_details_financial($param1 = '', $param2 = '', $param3 = '')
    {
         $this->session_login();
        
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
            redirect(base_url() . 'admin/sale_details/'.base64_encode($param2), 'refresh');
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
    
    function inventory($param1 = '', $param2 = '')
    { 
         $this->session_login();

        if($param1 == 'delete_product'){
            $this->db->where('cart_item_id', $param2);
            $this->db->delete('cart_items');
        }
        if($param1 == 'add_product')
        {
            $product_id = $this->db->get_where('product', array('name' => $this->input->post('product')))->row()->product_id;
            
            $qry = $this->db->get_where('cart_items', array('cart_token' => $this->input->post('src_token'), 'product' => $product_id));
            if($qry->num_rows() > 0){
                $qty = $qry->row()->quantity;
                $data['quantity'] = $qty+$this->input->post('quantity');
                $this->db->where('product', $product_id);
                $this->db->update('cart_items',$data);
            }else{
                $data['product']  = $product_id;
                $data['cart_token'] = $this->input->post('src_token');
                $data['quantity'] = $this->input->post('quantity');
                $this->db->insert('cart_items',$data);
            }
        }
        if($param1 == 'sale'){
            $this->session->set_flashdata('flash_message' , "Producto agregado correctamente.");
            redirect(base_url() . 'admin/new_sale/'.base64_encode(json_encode($this->input->post('product'))), 'refresh');
        }
        

        if($param1 == 'update')
        {
            $this->crud_model->update_inventory($param2);
            $this->session->set_flashdata('flash_message' , "Producto actualizado correctamente.");
            redirect(base_url() . 'admin/inventory/', 'refresh');
        }
        
        //////////////////////////////////////////////////////////////////////////
        
        if($param1 == 'create_inventory')
        {
            $this->inventory_model->create_inventory();
            $this->session->set_flashdata('flash_message' , "Inventario agregado correctamente.");
            redirect(base_url() . 'admin/inventory/', 'refresh');
        }

        if($param1 == 'update_inventory')
        {
            $this->inventory_model->update_inventory(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "Inventario actualizado");
            redirect(base_url() . 'admin/inventory/', 'refresh');
        }

        if($param1 == 'delete_inventory')
        {
            $this->inventory_model->delete_inventory(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "Inventario eliminado");
            redirect(base_url() . 'admin/inventory/', 'refresh');
        }
        
        $page_data['page_name']   = 'inventory';
        $page_data['page_title']  = "Inventario";
        $this->load->view('backend/index', $page_data);
    }
    
    function inventory_products($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'create_product')
        {
            $this->inventory_model->create_product();
            $this->session->set_flashdata('flash_message' , "Producto agregado correctamente");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }
        
         if($param1 == 'update_product')
        {
            $inventory = $this->inventory_model->update_product($param2);
            $this->session->set_flashdata('flash_message' , "Producto actualizado correctamente");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $inventory = $this->inventory_model->delete_products($param2);
            $this->session->set_flashdata('flash_message' , "Producto eliminado");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
            
        }

        if($param1 == 'create_service')
        {
            $this->inventory_model->create_service();
            $this->session->set_flashdata('flash_message' , "Servicio agregado correctamente");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }
        
         if($param1 == 'update_service')
        {
            $this->inventory_model->update_service($param2);
            $this->session->set_flashdata('flash_message' , "Servicio actualizado correctamente");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }

        if($param1 == 'create_laboratory')
        {
            $this->inventory_model->create_laboratory();
            $this->session->set_flashdata('flash_message' , "Laboratorio agregado correctamente");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }
        
         if($param1 == 'update_laboratory')
        {
            $this->inventory_model->update_laboratory($param2);
            $this->session->set_flashdata('flash_message' , "Laboratorio actualizado correctamente");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }


        if($param1 == 'product_import')
        {
            $inventory = $this->inventory_model->product_import($param2);
            $this->session->set_flashdata('flash_message' , "Producto agregados correctamente");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }
        


        if($param1 == 'service_imp')
        {
            $inventory = $this->inventory_model->service_imp($param2);
            $this->session->set_flashdata('flash_message' , "Producto actualizado correctamente");
            redirect($this->agent->referrer(), 'refresh');
        }


        if($param1 == 'prices_imp')
        {
            $inventory = $this->inventory_model->prices_imp($param2);
            $this->session->set_flashdata('flash_message' , "Precios actualizado correctamente");
            redirect($this->agent->referrer(), 'refresh');
        }
        
        
        if($param1 == 'product_export')
        {
            $inventory = $this->inventory_model->product_export();
            $this->session->set_flashdata('flash_message' , "Producto agregados correctamente");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }
        


        if($param1 == 'service_export')
        {
            $inventory = $this->inventory_model->service_export();
            $this->session->set_flashdata('flash_message' , "Servicios exportados");
            redirect($this->agent->referrer(), 'refresh');
        }
        
        
         if($param1 == 'prices_export')
        {
            $inventory = $this->inventory_model->prices_export();
            $this->session->set_flashdata('flash_message' , "Precios exportados");
            redirect($this->agent->referrer(), 'refresh');
        }


        if($param1 == 'product_masive_delete')
        {
            $inventory = $this->inventory_model->product_masive_delete();
            $this->session->set_flashdata('flash_message' , "Producto eliminados correctamente");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }
        


        if($param1 == 'service_masive_delete')
        {
            $inventory = $this->inventory_model->service_masive_delete();
            $this->session->set_flashdata('flash_message' , "Servicios eliminados");
            redirect($this->agent->referrer(), 'refresh');
        }



        if($param1 == 'service_implementos')
        {
            $inventory = $this->inventory_model->service_implementos($param2);
            $this->session->set_flashdata('flash_message' , "Implementos actualizado correctamente");
            redirect($this->agent->referrer(), 'refresh');
        }
        
        
      
        $page_data['inventory_id']= base64_decode($param1);
        $page_data['page_name']   = 'inventory_products';
        $page_data['page_title']  = "Productos";
        $this->load->view('backend/index', $page_data);
    }

    function download_example($file){
            $file_name = $file.".xlsx";
            $this->load->helper('download');
            $info = file_get_contents("public/uploads/import/" . $file_name);
            $name = $file_name;
            force_download($name, $info);
    }

    function combos($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'create')
        {
            $this->crud_model->create_combo();
            $this->session->set_flashdata('flash_message' , "Combo agregado correctamente.");
            redirect(base_url() . 'admin/combos/', 'refresh');
        }
        
        if($param1 == 'set')
        {
            $this->crud_model->set_solicitud($param2);
            $this->session->set_flashdata('flash_message' , "Categoría actualizada correctamente.");
            redirect(base_url() . 'admin/solicitudes/', 'refresh');
        }

         if($param1 == 'update')
        {
            $this->crud_model->update_solicitud($param2);
            $this->session->set_flashdata('flash_message' , "Categoría actualizada correctamente.");
            redirect(base_url() . 'admin/solicitudes/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_solicitud($param2);
            $this->session->set_flashdata('flash_message' , "Categoría eliminada correctamente.");
            redirect(base_url() . 'admin/solicitudes/', 'refresh');
            
        }
        
        $page_data['page_name']   = 'combos';
        $page_data['page_title']  = "Combos de productos";
        $this->load->view('backend/index', $page_data);
    }


    function solicitudes($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'create')
        {
            $this->crud_model->create_solicitud();
            $this->session->set_flashdata('flash_message' , "Categoría agregada correctamente.");
            redirect(base_url() . 'admin/solicitudes/', 'refresh');
        }
        
        if($param1 == 'set')
        {
            $this->crud_model->set_solicitud($param2);
            $this->session->set_flashdata('flash_message' , "Categoría actualizada correctamente.");
            redirect(base_url() . 'admin/solicitudes/', 'refresh');
        }

         if($param1 == 'update')
        {
            $this->crud_model->update_solicitud($param2);
            $this->session->set_flashdata('flash_message' , "Categoría actualizada correctamente.");
            redirect(base_url() . 'admin/solicitudes/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_solicitud($param2);
            $this->session->set_flashdata('flash_message' , "Categoría eliminada correctamente.");
            redirect(base_url() . 'admin/solicitudes/', 'refresh');
            
        }
        
        $page_data['page_name']   = 'solicitudes';
        $page_data['page_title']  = "Solicitud de productos";
        $this->load->view('backend/index', $page_data);
    }


    function purchases($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'create_solicitud')
        {
            $this->inventory_model->create_solicitud();
            $this->session->set_flashdata('flash_message' , "Nueva orden creada correctamente.");
            redirect(base_url() . 'admin/purchases/', 'refresh');
        }
        if($param1 == 'update_solicitud')
        {
            $this->inventory_model->update_solicitud($param2);
            $this->session->set_flashdata('flash_message' , "Orden actualizado correctamente.");
            redirect(base_url() . 'admin/purchases/', 'refresh');
        }

        if($param1 == 'confirm_solicitud')
        {
            $this->inventory_model->confirm_solicitud($param2);
            $this->session->set_flashdata('flash_message' , "Orden guardada correctamente.");
            redirect(base_url() . 'admin/purchases/', 'refresh');
        }
        
        if($param1 == 'set')
        {
            $this->inventory_model->set_solicitud($param2);
            $this->session->set_flashdata('flash_message' , "Orden cargada al inventario correctamente.");
            redirect(base_url() . 'admin/purchases/', 'refresh');
        }

       
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_solicitud($param2);
            $this->session->set_flashdata('flash_message' , "Categoría eliminada correctamente.");
            redirect(base_url() . 'admin/purchases/', 'refresh');
            
        }
        
        $page_data['page_name']   = 'purchases';
        $page_data['page_title']  = "Ordenes de compras";
        $this->load->view('backend/index', $page_data);
    }


    function new_purchase($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        $page_data['page_name']   = 'new_purchase';
        $page_data['page_title']  = "Nueva ordenes de compra";
        $this->load->view('backend/index', $page_data);
    }

    function edit_purchase($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['pedido_id']   = base64_decode($param1);
        $page_data['page_name']   = 'edit_purchase';
        $page_data['page_title']  = "Editar ordenes de compra";
        $this->load->view('backend/index', $page_data);
    }

    function confirm_purchase($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['pedido_id']   = base64_decode($param1);
        $page_data['page_name']   = 'confirm_purchase';
        $page_data['page_title']  = "Confirmar ordenes de compra";
        $this->load->view('backend/index', $page_data);
    }

    function get_subcategories($category_id)
    {
      
        $subcategories = $this->db->get_where('subcategory',array('category_id'=>$category_id,'status'=>1))->result_array();
        
         if(count($subcategories) > 0)
         {
            
            foreach ($subcategories as $row) 
            {   
                $options .= '<option value="' . $row['id'] . '">' . $row['name']. '</option>';
             }

         }else
         {
            $options .= '<option value="">Sin subcategoria</option>';
         }
        
        echo $options;
    }

    
    function get_products_provider($provider_id)
    {
        $products = $this->db->query("SELECT product.product_id,product.name FROM product JOIN inventory_product ON product.product_id = inventory_product.product_id JOIN inventory ON inventory.inventory_id = inventory_product.inventory_id WHERE product.status = 1  AND product.provider = ".$provider_id."  AND  product.type = 1 AND inventory.clinic_id = ".$this->session->userdata('current_clinic'))->result_array();
        
         if(count($products) > 0)
         {$options .= '<option value="">Seleccionar</option>';
            foreach ($products as $row) 
            {   
                $options .= '<option value="' . $row['product_id'] . '">' . $row['name']. '</option>';
             }

         }else
         {
            $options .= '<option value="">Sin productos</option>';
         }
        
        echo $options;
    }

    function get_services_provider($provider_id)
    {
        $options="";
        $products = $this->db->query("SELECT product.product_id,product.name FROM product JOIN inventory_product ON product.product_id = inventory_product.product_id JOIN inventory ON inventory.inventory_id = inventory_product.inventory_id WHERE product.provider = ".$provider_id."  AND  product.type = 2 AND inventory.clinic_id = ".$this->session->userdata('current_clinic'))->result_array();
        
         if(count($products) > 0)
         {$options .= '<option value="">Seleccionar</option>';
            foreach ($products as $row) 
            {   
                $options .= '<option value="' . $row['product_id'] . '">' . $row['name']. '</option>';
             }

         }else
         {
            $options .= '<option value="">Sin productos</option>';
         }
        
        echo $options;
    }
    
    function get_products($category_id)
    {
        if($category_id != 0)
            $products = $this->db->query("SELECT product.product_id,product.name FROM product JOIN inventory_product ON product.product_id = inventory_product.product_id JOIN inventory ON inventory.inventory_id = inventory_product.inventory_id WHERE product.status = 1  AND inventory_product.status = 1  AND product.category_id = ".$category_id." AND inventory.clinic_id = ".$this->session->userdata('current_clinic'))->result_array();
        else
            $products = $this->db->query("SELECT product.product_id,product.name FROM product JOIN inventory_product ON product.product_id = inventory_product.product_id JOIN inventory ON inventory.inventory_id = inventory_product.inventory_id WHERE  product.status = 1  AND inventory_product.status = 1  AND inventory.clinic_id = ".$this->session->userdata('current_clinic'))->result_array();

        $options = '';
         if(count($products) > 0)
         {
            $options .= '<option value="">Seleccionar</option>';
            foreach ($products as $row) 
            {   
                $options .= '<option value="' . $row['product_id'] . '">' . $row['name']. '</option>';
             }

         }else
         {
            $options .= '<option value="">Sin productos</option>';
         }
        
        echo $options;
    }


    function get_product_pres($product_id)
    {
        $sections = $this->db->get_where('product' , array('product_id' => $product_id))->result_array();
        
         
        foreach ($sections as $row) 
        {
            if($row['type'] == 1)
            {
                $options = '<option value="">Seleccionar</option>';
            }
            
             if($row['principal_unity'] != '' )
            {
                $options .= '<option value="' . $row['principal_unity'] . '">' . $this->db->get_where('unity' , array('code' => $row['principal_unity']))->row()->name . '</option>';
            }

            /*
            if($row['packaging'] != '' && $row['pa_amount'] != '0')
            {
                $options .= '<option value="' . $row['packaging'] . '">' . $this->db->get_where('unity' , array('code' => $row['packaging']))->row()->name . '</option>';
            }

            if($row['presentation'] != '' && $row['p_amount'] != '0')
            {
                $options .= '<option value="' . $row['presentation'] . '">' . $this->db->get_where('unity' , array('code' => $row['presentation']))->row()->name . '</option>';
            }

            if($row['unity'] != '' && $row['u_amount'] != '0')
            {
                $options .= '<option value="' . $row['unity'] . '">' . $this->db->get_where('unity' , array('code' => $row['unity']))->row()->name . '</option>';
            }
            */
        }

        echo $options;
    }


    function get_product_price($product_id,$type_price)
    {
        log_message('error',$product_id);
        $price = $this->db->get_where('product_price' , array('product_id' => $product_id,'insurance_id'=>$type_price));
         
        if($price->num_rows() > 1)
            echo $price->row()->price;
        else
            echo $this->db->get_where('product_price' , array('product_id' => $product_id,'insurance_id'=>0))->row()->price;
           
    }


    function categories($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'create')
        {
            $this->crud_model->create_category();
            $this->session->set_flashdata('flash_message' , "Categoría agregada correctamente.");
            redirect(base_url() . 'admin/categories/', 'refresh');
        }
        
         if($param1 == 'update')
        {
            $this->crud_model->update_category($param2);
            $this->session->set_flashdata('flash_message' , "Categoría actualizada correctamente.");
            redirect(base_url() . 'admin/categories/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_category($param2);
            $this->session->set_flashdata('flash_message' , "Categoría eliminada correctamente.");
            redirect(base_url() . 'admin/categories/', 'refresh');
            
        }
        
        $page_data['page_name']   = 'categories';
        $page_data['page_title']  = "Categorías de productos";
        $this->load->view('backend/index', $page_data);
    }


    
    function subcategories($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'create')
        {
            $this->crud_model->create_subcategory();
            $this->session->set_flashdata('flash_message' , "Sub Categoría agregada correctamente.");
            redirect(base_url() . 'admin/subcategories/', 'refresh');
        }
        
         if($param1 == 'update')
        {
            $this->crud_model->update_subcategory($param2);
            $this->session->set_flashdata('flash_message' , "Sub Categoría actualizada correctamente.");
            redirect(base_url() . 'admin/subcategories/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_subcategory($param2);
            $this->session->set_flashdata('flash_message' , "Sub Categoría eliminada correctamente.");
            redirect(base_url() . 'admin/subcategories/', 'refresh');
            
        }
        
        $page_data['page_name']   = 'subcategories';
        $page_data['page_title']  = "Sub Categorías de productos";
        $this->load->view('backend/index', $page_data);
    }
    
    function sales($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'anulation')
        {
           
            
            $id=base64_decode($param2);
            $emision_id = $this->fel->anulacionFactura($id);
            if($emision_id == 1)
            {
                $this->db->where('sale_id',$id);
                $this->db->update('sale', array('status' => 2));       
                $this->session->set_flashdata('flash_message' , "Venta anulada correctamente.");
            }else
            {
                $this->session->set_flashdata('flash_message' , "Venta no se pudo anular.");
            }
                redirect(base_url() . 'admin/sales/', 'refresh');
        }

     
        if($param1 == 'create_sale')
        {
            $cats           =   $this->input->post('cat_id');
            $products       =   $this->input->post('product_id');
            $unity          =   $this->input->post('unity');
            $amount         =   $this->input->post('amount');
            $subtotal       =   $this->input->post('subtotal');
            $discounts       =   $this->input->post('discount');
            $tdiscounts     = $this->input->post('tdiscount');
            $total1          =   $this->input->post('total');
            
            $total      = 0;
            $sales_order_entries =   array();
            for($i = 0; $i < sizeof($products); $i++) 
            {
                $point_value = $this->db->get_where('settings',array('type'=>'point_value'))->row()->description;

                if($tdiscounts[$i] == 'P')
                {
                    $dess = $discounts[$i] * $point_value;
                   
                }else if($tdiscounts[$i] == '%')
                {
                    $dess = ( $amount[$i] *  $subtotal[$i]) * ($discounts[$i] /100);
                }else
                {
                    $dess = $discounts[$i];
                }

                if($products[$i] != "")
                {
                    
                    $new_order_entry    =   array(
                        'cat_id' => $cats[$i],
                        'product_id' => $products[$i],
                        'amount' => $amount[$i],
                        'unity' => $unity[$i],
                        'subtotal' => $subtotal[$i],
                        'discount' => $dess,
                        'total' => $total1[$i],
                    );
                    $total += $total1[$i];

                    array_push($sales_order_entries , $new_order_entry);

                }
            }


           

            $iva =    $total*0.12;
            $amount =    $total-$iva;
            
            $patient_id = $this->db->get_where('patient' , array('nit_1' => $this->input->post('nit')))->row()->patient_id;
            $data = array(
                'date' => $this->input->post('date'),
                'client_id' => $patient_id != '' ? $patient_id : 0,
                'type_id' => $this->input->post('type_id'),
                'nit' => $this->input->post('nit'),
                'cui' => $this->input->post('cui'),
                'name' => $this->input->post('full_name'),
                'address' => $this->input->post('address'),
                'type_client' => $this->input->post('type_client'),
                'total_product' => sizeof($products),
                'total' => $total,
                'currency_id' => 1,
                'isr' => 0,
                'exempt' => 0,
                'iva' => $iva,
                'amount' =>  $amount,
                'regime' => $this->input->post('regime'),
                'institution_id' => $this->input->post('institution_id'),
                'type_invoice' => $this->input->post('type_invoice'),
                'type' => $this->input->post('type'),
                'days' => $this->input->post('days'),
                'details' => $this->input->post('notes'),
                'user_id' => $this->session->userdata('login_user_id'),
                'user_type' => $this->session->userdata('login_type'),
                'original_id' => $this->input->post('original_id'),
                'commission' => $this->input->post('commission'),
                'products' => serialize($sales_order_entries),
                'status' => 1,
                'box_id' =>  $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1))->row()->box_id
            );

            $this->db->insert('sale', $data);
            $sale_id = $this->db->insert_id();

            if(sizeof($method) > 1)
            {
                $this->db->where('sale_id',$sale_id);
                $this->db->update('sale',array('status'=> 3,'method'=>5));
            }

            $method = $this->input->post('method');
            $nomenclature_id = $this->input->post('nomenclature_id');
            $method_amount = $this->input->post('method_amount');
           
            for($i = 0; $i < sizeof($method); $i++) 
            {
              

                if ($method[$i] == 1) 
                {
                    $datai = array(
                        'description' => 'Venta No. '.$sale_id,
                        'amount' =>   $method_amount[$i],
                        'method' =>   $method[$i],
                        'cash_id' =>  $this->input->post('cash_id')[$i],
                        'patient_id' =>  $patient_id,
                        'date' =>  date('Y-m-d'),
                        'time' =>  date('H:i:s'),
                        'sale_id' =>  $sale_id,
                        'box_id' =>  $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1))->row()->box_id
                    );

                    $this->db->insert('income', $datai);
                
                }
                elseif ($method[$i] == 2 || $method[$i] == 3) 
                {
                    $datai = array(
                        'description' => 'Venta No. '.$sale_id,
                        'amount' =>   $method_amount[$i],
                        'method' =>   $method[$i],
                        'bank_account_id' =>  $this->input->post('bank_account_id')[$i],
                        'type_transfer' =>  $this->input->post('type_transfer')[$i],
                        'reference_code' =>  $this->input->post('reference_code')[$i],
                        'reference_file' =>  $reference_file,
                        'patient_id' =>  $patient_id,
                        'date' =>  date('Y-m-d'),
                        'time' =>  date('H:i:s'),
                        'sale_id' =>  $sale_id,
                        'box_id' =>  $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1))->row()->box_id
                    );
                    
                    $this->db->insert('income', $datai);
                }else
                {

                    $this->db->where('sale_id',$sale_id);
                    $this->db->update('sale',array('status'=> 3,'method'=>4));
                }

               

            }

            $cats           =   $this->input->post('cat_id');
            $products       =   $this->input->post('product_id');
            $unity          =   $this->input->post('unity');
            $amount         =   $this->input->post('amount');
            $subtotal       =   $this->input->post('subtotal');
            $discounts      =   $this->input->post('discount');
            $tdiscounts     = $this->input->post('tdiscount');
            
            for($i = 0; $i < sizeof($products); $i++) 
            {

                if($products[$i] != "")
                {
                    $point_value = $this->db->get_where('settings',array('type'=>'point_value'))->row()->description;
                    $prod = $this->db->get_where('product',array('product_id'=>$products[$i]))->row_array();
                    if($tdiscounts[$i] == 'P')
                    {
                        $dess = $discounts[$i] * $point_value;
                        $point = array(
                            'description' => 'Descuento por el producto '.$prod['code'],
                            'patient_id' => $patient_id,
                            'type' =>0,
                            'points' =>$discounts[$i],
                            'value' =>  $point_value,
                            'amount' =>$discounts[$i] *  $point_value,
                            'ref' => $sale_id,
                            'product_id'=>$products[$i],
                        );

                        $this->db->insert('patient_points',$point);
                    }else if($tdiscounts[$i] == '%')
                    {
                        $dess = ( $amount[$i] *  $subtotal[$i]) * ($discounts[$i] /100);
                    }else
                    {
                        $dess = $discounts[$i];
                    }

                   
                    $new_order_entry    =   array(
                        'sale_id' => $sale_id,
                        'cat_id' => $cats[$i],
                        'product_id' => $products[$i],
                        'amount' => $amount[$i],
                        'unity' => $unity[$i],
                        'subtotal' => $subtotal[$i],
                        'discount' => $dess,
                        'total' => $total1[$i],
                    );
                    $this->db->insert('sale_detail',$new_order_entry);


                   
                    if( $patient_id != '' && $prod['points'] > 0)
                    {
                        $point = array(
                       
                            'description' => 'Puntos por el producto '.$prod['code'],
                            'patient_id' => $patient_id,
                            'type' =>1,
                            'points' =>$prod['points'],
                            'ref' => $sale_id,
                            'product_id'=>$products[$i],
                        );
                        $this->db->insert('patient_points',$point);

                    }
                     
                }

                if($products[$i] != "")
                {

                    $product_lotes = $this->db->order_by('product_lote_id', 'ASC')->get_where('product_lote' , array('product_id' => $products[$i],'amount >'=>0))->result_array();
                    $amountd = $amount[$i];

                    foreach($product_lotes as $lote)
                    {
                       
                        if($lote['amount'] >= $amountd)
                        {
                            $data = array(
                                'product_id' =>  $products[$i],
                                'lote' => $lote['product_lote_id'],
                                'date' =>  date('Y-m-d'),
                                'clinic_id' => trim($this->session->userdata('current_clinic')),
                                'amount' => $amountd,
                                'unity' => $unity[$i],
                                'ref' => $sale_id,
                                'cost' => '',
                                'price' => $subtotal[$i],
                                'obs' =>'',
                                'status_mov' => 2
                            );
                            
                            $this->db->insert('product_move',$data);

                            $this->db->where('product_lote_id',$lote['product_lote_id']);
                            $this->db->update('product_lote',array('amount'=>$lote['amount']-$amountd));
                            break;

                        }else
                        {
                            $amountd = $amount[$i] - $lote['amount'];
                            $data = array(
                                'product_id' =>  $products[$i],
                                'lote' => $lote['product_lote_id'],
                                'date' =>  date('Y-m-d'),
                                'clinic_id' => trim($this->session->userdata('current_clinic')),
                                'amount' => $lote['amount'],
                                'unity' => $unity[$i],
                                'ref' => $sale_id,
                                'cost' => '',
                                'price' => $subtotal[$i],
                                'obs' =>'',
                                'status_mov' => 2
                            );
                            
                            $this->db->insert('product_move',$data);
                            $this->db->where('product_lote_id',$lote['product_lote_id']);
                            $this->db->update('product_lote',array('amount'=>0));

                        }
                        

                    }


                }
            }

            $emision_id = $this->fel->requestDocument($sale_id);

            $this->db->where('sale_id',$sale_id);
            $this->db->update('sale',array('invoice'=> $emision_id['emision_id']));

            $this->crud_model->createDepBySale($sale_id);
            
            $this->session->set_flashdata('flash_message' , "Venta agregada correctamente.");
            redirect(base_url() . 'admin/sales/', 'refresh');
        }
        
        
        if($param1 == 'create_cot')
        {
            $cot_id = $this->inventory_model->create_cot();   
            $this->session->set_flashdata('flash_message' , "Cotizacion agregada correctamente.");
            redirect(base_url() . 'admin/sale_details/'.base64_encode($cot_id), 'refresh');
        }


        if($param1 == 'create_special_sale')
        {
            
            $sale = $this->db->get_where('sale',array('sale_id'=>$this->input->post('sale_id')))->row_array();
            $total1          =   $this->input->post('total');
            $total      = 0;
            $sales_order_entries =   array();
            $detalles = unserialize($sale['products']);  
            foreach($detalles as $prod)
            {

                    $data = array(
                        'product_id' =>  $prod['product_id'],
                        'lote' => '',
                        'date' =>  date('Y-m-d'),
                        'clinic_id' => trim($this->session->userdata('current_clinic')),
                        'amount' => $prod['amount'],
                        'ref' => $this->input->post('sale_id'),
                        'cost' => '',
                        'price' => $prod['subtotal'],
                        'obs' =>'',
                        'status_mov' => 2
                    );
                    
                    $this->db->insert('product_move',$data);

                    $total += $prod['total'];

            }


           

            $iva =    $total*0.12;
            $amount =    $total-$iva;
            
            $method = $this->input->post('method');
            $nomenclature_id = $this->input->post('nomenclature_id');
            if ($method == 1) $nomenclature_id = $this->input->post('cash_id');
            elseif ($method == 2 || $method == 3) $nomenclature_id = $this->input->post('bank_account_id');
            elseif ($method == 4) {
                $nom = $this->crud_model->getNomenByName("Clientes");
                $nomenclature_id = $nom['nomenclature_id'];
            }

            $data = array(
                
                'total' => $total,
                'currency_id' => 1,
                'isr' => 0,
                'exempt' => 0,
                'iva' => $iva,
                'amount' =>  $amount,
                'regime' => $this->input->post('regime'),
                'institution_id' => $this->input->post('institution_id'),
                'type_invoice' => $this->input->post('type_invoice'),
                'type' => $this->input->post('type'),
                'method' => $this->input->post('method'),
                'nomenclature_id' => $nomenclature_id,
                'type_transfer' => $this->input->post('type_transfer'),
                'days' => $this->input->post('days'),
                'details' => $this->input->post('notes'),
                'commission' => $this->input->post('commission'),
                'status' => 1,
                'box_id' =>  $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1))->row()->box_id
            );

            $this->db->where('sale_id', $this->input->post('sale_id'));
            $this->db->update('sale', $data);
       
            $this->crud_model->createDepBySale($sale_id);
            
            $this->session->set_flashdata('flash_message' , "Venta agregada correctamente.");
            redirect(base_url() . 'admin/sales/', 'refresh');
        }

        if($param1 == 'create_sale_insurance')
        {
            $cats           =   $this->input->post('cat_id');
            $products       =   $this->input->post('product_id');
            $unity          =   $this->input->post('unity');
            $amount         =   $this->input->post('amount');
            $subtotal       =   $this->input->post('subtotal');
            $discounts       =   $this->input->post('discount');
            $tdiscounts     = $this->input->post('tdiscount');
            $total1          =   $this->input->post('total');
            $total_disc      = 0;
            $total      = 0;
            $sales_order_entries =   array();
            $service_name = '';
            for($i = 0; $i < sizeof($products); $i++) 
            {
                $point_value = $this->db->get_where('settings',array('type'=>'point_value'))->row()->description;

                if($tdiscounts[$i] == 'P')
                {
                    $dess = $discounts[$i] * $point_value;
                   
                }else if($tdiscounts[$i] == '%')
                {
                    $dess = ( $amount[$i] *  $subtotal[$i]) * ($discounts[$i] /100);
                }else
                {
                    $dess = $discounts[$i];
                }
               
               
                if($products[$i] != "")
                {
                    if($i != 0)
                    {
                        $service_name .= ',';
                    }

                    $service_name .= $this->db->get_where('category',array('id'=>$cats[$i]))->row()->name;
                    $new_order_entry    =   array(
                        'cat_id' => $cats[$i],
                        'product_id' => $products[$i],
                        'amount' => $amount[$i],
                        'unity' => $unity[$i],
                        'subtotal' => $subtotal[$i],
                        'discount' => $dess,
                        'total' => $total1[$i],
                    );

                    $total += $total1[$i];
                    $total_disc += $dess;

                    array_push($sales_order_entries , $new_order_entry);

                }
            }


        

            $iva =    $total*0.12;
            $amount =    $total-$iva;
            
            $patient_id = $this->db->get_where('patient' , array('nit_1' => $this->input->post('nit')))->row()->patient_id;
            $data = array(
                'date' => $this->input->post('date'),
                'client_id' => $patient_id != '' ? $patient_id : 0,
                'type_id' => $this->input->post('type_id'),
                'nit' => $this->input->post('nit'),
                'cui' => $this->input->post('cui'),
                'name' => $this->input->post('full_name'),
                'address' => $this->input->post('address'),
                'type_client' => $this->input->post('type_client'),
                'total_product' => sizeof($products),
                'total' => $total,
                'currency_id' => 1,
                'isr' => 0,
                'exempt' => 0,
                'iva' => $iva,
                'amount' =>  $amount,
                'regime' => $this->input->post('regime'),
                'institution_id' => $this->input->post('institution_id'),
                'type_invoice' => $this->input->post('type_invoice'),
                'type' => $this->input->post('type'),
                'days' => $this->input->post('days'),
                'details' => $this->input->post('notes'),
                'user_id' => $this->session->userdata('login_user_id'),
                'user_type' => $this->session->userdata('login_type'),
                'original_id' => $this->input->post('original_id'),
                'commission' => $this->input->post('commission'),
                'products' => serialize($sales_order_entries),
                'insurance_id' => $this->input->post('insurance_id'),
                'authorization' => $this->input->post('authorization'),
                'titular' => $this->input->post('titular'),
                'dpi_titular' => $this->input->post('dpi_titular'),
                'move_economy' => $this->input->post('move_economy'),
                'record' => $this->input->post('record'),
                'total_insurance' => $total_disc,
                'total_client' =>$total,
                'service' =>$service_name,
                'status' => 1,
                'box_id' =>  $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1))->row()->box_id
            );

            $this->db->insert('sale', $data);
            $sale_id = $this->db->insert_id();

            $method = $this->input->post('method');
            $nomenclature_id = $this->input->post('nomenclature_id');
            $method_amount = $this->input->post('method_amount');
           
            for($i = 0; $i < sizeof($method); $i++) 
            {

                if ($method[$i] == 1) 
                {
                    $datai = array(
                        'description' => 'Venta No. '.$sale_id,
                        'amount' =>   $method_amount[$i],
                        'method' =>   $method[$i],
                        'cash_id' =>  $this->input->post('cash_id')[$i],
                        'patient_id' =>  $patient_id,
                        'date' =>  date('Y-m-d'),
                        'time' =>  date('H:i:s'),
                        'sale_id' =>  $sale_id,
                        'box_id' =>  $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1))->row()->box_id
                    );
                
                }
                elseif ($method[$i] == 2 || $method[$i] == 3) 
                {
                    $datai = array(
                        'description' => 'Venta No. '.$sale_id,
                        'amount' =>   $method_amount[$i],
                        'method' =>   $method[$i],
                        'bank_account_id' =>  $this->input->post('bank_account_id')[$i],
                        'type_transfer' =>  $this->input->post('type_transfer')[$i],
                        'reference_code' =>  $this->input->post('reference_code')[$i],
                        'reference_file' =>  $reference_file,
                        'patient_id' =>  $patient_id,
                        'date' =>  date('Y-m-d'),
                        'time' =>  date('H:i:s'),
                        'sale_id' =>  $sale_id,
                        'box_id' =>  $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1))->row()->box_id
                    );
                    
                }

                $this->db->insert('income', $datai);

            }

            $cats           =   $this->input->post('cat_id');
            $products       =   $this->input->post('product_id');
            $unity          =   $this->input->post('unity');
            $amount         =   $this->input->post('amount');
            $subtotal       =   $this->input->post('subtotal');
            $discounts      =   $this->input->post('discount');
            $tdiscounts     = $this->input->post('tdiscount');
            
            for($i = 0; $i < sizeof($products); $i++) 
            {


                if($products[$i] != "")
                {
                    $point_value = $this->db->get_where('settings',array('type'=>'point_value'))->row()->description;
                    $prod = $this->db->get_where('product',array('product_id'=>$products[$i]))->row_array();
                    if($tdiscounts[$i] == 'P')
                    {
                        $dess = $discounts[$i] * $point_value;
                        $point = array(
                            'description' => 'Descuento por el producto '.$prod['code'],
                            'patient_id' => $patient_id,
                            'type' =>0,
                            'points' =>$discounts[$i],
                            'value' =>  $point_value,
                            'amount' =>$discounts[$i] *  $point_value,
                            'ref' => $sale_id,
                            'product_id'=>$products[$i],
                        );

                        $this->db->insert('patient_points',$point);
                    }else if($tdiscounts[$i] == '%')
                    {
                        $dess = ( $amount[$i] *  $subtotal[$i]) * ($discounts[$i] /100);
                    }else
                    {
                        $dess = $discounts[$i];
                    }

                   
                    $new_order_entry    =   array(
                        'sale_id' => $sale_id,
                        'cat_id' => $cats[$i],
                        'product_id' => $products[$i],
                        'amount' => $amount[$i],
                        'unity' => $unity[$i],
                        'subtotal' => $subtotal[$i],
                        'discount' => $dess,
                        'total' => $total1[$i],
                    );
                    $this->db->insert('sale_detail',$new_order_entry);


                   
                   
                    if( $patient_id != '' && $prod['points'] > 0)
                    {
                        $point = array(
                       
                            'description' => 'Puntos por el producto '.$prod['code'],
                            'patient_id' => $patient_id,
                            'type' =>1,
                            'points' =>$prod['points'],
                            'ref' => $sale_id,
                            'product_id'=>$products[$i],
                        );
                        $this->db->insert('patient_points',$point);

                    }
                   
                  

                }


               



                if($products[$i] != "")
                {

                    $product_lotes = $this->db->order_by('product_lote_id', 'ASC')->get_where('product_lote' , array('product_id' => $products[$i],'amount >'=>0))->result_array();
                    $amountd = $amount[$i];

                    foreach($product_lotes as $lote)
                    {
                       
                        if($lote['amount'] >= $amountd)
                        {
                            $data = array(
                                'product_id' =>  $products[$i],
                                'lote' => $lote['product_lote_id'],
                                'date' =>  date('Y-m-d'),
                                'clinic_id' => trim($this->session->userdata('current_clinic')),
                                'amount' => $amountd,
                                'unity' => $unity[$i],
                                'ref' => $sale_id,
                                'cost' => '',
                                'price' => $subtotal[$i],
                                'obs' =>'',
                                'status_mov' => 2
                            );
                            
                            $this->db->insert('product_move',$data);

                            $this->db->where('product_lote_id',$lote['product_lote_id']);
                            $this->db->update('product_lote',array('amount'=>$lote['amount']-$amountd));
                            break;

                        }else
                        {
                            $amountd = $amount[$i] - $lote['amount'];
                            $data = array(
                                'product_id' =>  $products[$i],
                                'lote' => $lote['product_lote_id'],
                                'date' =>  date('Y-m-d'),
                                'clinic_id' => trim($this->session->userdata('current_clinic')),
                                'amount' => $lote['amount'],
                                'unity' => $unity[$i],
                                'ref' => $sale_id,
                                'cost' => '',
                                'price' => $subtotal[$i],
                                'obs' =>'',
                                'status_mov' => 2
                            );
                            
                            $this->db->insert('product_move',$data);
                            $this->db->where('product_lote_id',$lote['product_lote_id']);
                            $this->db->update('product_lote',array('amount'=>0));

                        }
                        

                    }


                }
            }

            if($total > 0)
            {
                $emision_id = $this->fel->requestDocument($sale_id);

                $this->db->where('sale_id',$sale_id);
                $this->db->update('sale',array('invoice'=> $emision_id['emision_id']));

            }
        

            $this->crud_model->createDepBySale($sale_id);
            
            $this->session->set_flashdata('flash_message' , "Venta agregada correctamente.");
            redirect(base_url() . 'admin/sales_insurance/', 'refresh');
              
        }

        if($param1 == 'emit_invoice')
        {
            $emision_id = $this->fel->requestDocument(base64_decode($param2));

            $this->db->where('sale_id',base64_decode($param2));
            $this->db->update('sale',array('invoice'=> $emision_id['emision_id']));

            if($emision_id['emision_id'] != '')
            $this->session->set_flashdata('flash_message' , "Factura emitida correctamente.");
            else
            $this->session->set_flashdata('error_message' , "La factura no se pudo emitir.");

            redirect(base_url() . 'admin/sale_details/'.$param2, 'refresh');
        }

        if($this->input->post('date_start') != '' && $this->input->post('date_end') != '')
        {
            $page_data['date_start']   = $this->input->post('date_start');
            $page_data['date_end']   = $this->input->post('date_end');
        }else {
            $page_data['date_start']   = date('01/m/Y');
            $page_data['date_end']   = date('d/m/Y');
        }

        $page_data['sales_status']   = base64_decode($param1);
        $page_data['page_name']   = 'sales';
        $page_data['page_title']  = "Administrar ventas";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function cotizaciones($param1 = '', $param2 = '')
    {
        
        $page_data['sales_status']   = base64_decode($param1);
        $page_data['page_name']   = 'cotizaciones';
        $page_data['page_title']  = "Cotizaciones";
        $this->load->view('backend/index', $page_data);
    
    
    }

    function sales_insurance($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        

        if($this->input->post('date_start') != '' && $this->input->post('date_end') != '')
        {
            $page_data['insurance_id']   = $this->input->post('insurance_id');
            $page_data['date_start']   = $this->input->post('date_start');
            $page_data['date_end']   = $this->input->post('date_end');
        }else {
            $page_data['insurance_id']   = $this->db->get_where('insurance',array('status'=>1))->first_row()->insurance_id;
            $page_data['date_start']   = date('01/m/Y');
            $page_data['date_end']   = date('d/m/Y');
        }

        $page_data['sales_status']   = base64_decode($param1);
        $page_data['page_name']   = 'sales_insurance';
        $page_data['page_title']  = "Ventas aseguradoras";
        $this->load->view('backend/index', $page_data);
    }


    function new_sale($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['sale_data']   = base64_decode($param1);
        $page_data['page_name']   = 'new_sale';
        $page_data['page_title']  = "Nueva venta";
        $this->load->view('backend/index', $page_data);
    }

    function notasdca($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['sale_id']   = base64_decode($param1);
        $page_data['page_name']   = 'notasdca';
        $page_data['page_title']  = "Nueva nota";
        $this->load->view('backend/index', $page_data);
    }

    function new_cotitation($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['sale_data']   = base64_decode($param1);
        $page_data['page_name']   = 'new_cotitation';
        $page_data['page_title']  = "Nueva cotización";
        $this->load->view('backend/index', $page_data);
    }

    
    function new_sale_insurance($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['sale_data']   = base64_decode($param1);
        $page_data['page_name']   = 'new_sale_insurance';
        $page_data['page_title']  = "Nueva venta aseguradora";
        $this->load->view('backend/index', $page_data);
    }

    function box($param1 = '', $param2 = '')
    {
         $this->session_login();

        if($param1 == 'new_box')
        {
            $data    =   array(
                'user_id' => $this->session->userdata('login_user_id'),
                'user_type' => $this->session->userdata('login_type'),
                'start_amount' => $this->input->post('start_amount'),
                'start_amount2' => $this->input->post('start_amount2'),
                'bank_account_id' => $this->input->post('bank_account_id'),
                'banck_amount' => $this->input->post('banck_amount'),
                'status' => 1,
            );
            $this->db->insert('box', $data);
            $this->session->set_flashdata('flash_message' , "Caja aperturada correctamente.");
            redirect(base_url() . 'admin/sales/', 'refresh');
        }

        if($param1 == 'close_box')
        {
            $data    =   array(
                'user_id' => $this->session->userdata('login_user_id'),
                'user_type' => $this->session->userdata('login_type'),
                'end_amount' => $this->input->post('start_amount'),
                'end_amount2' => $this->input->post('start_amount2'),
                'banck_amount' => $this->input->post('banck_amount'),
                'status' => 0,
            );
            $this->db->where('box_id',$param2);
            $this->db->update('box', $data);
            $this->session->set_flashdata('flash_message' , "Caja cerrada correctamente.");
            redirect(base_url() . 'admin/sales/', 'refresh');
        }

        $page_data['sale_data']   = base64_decode($param1);
        $page_data['page_name']   = 'box';
        $page_data['page_title']  = "Caja";
        $this->load->view('backend/index', $page_data);
    }
    
    function panel($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['page_name']   = 'panel';
        $page_data['page_title']  = "Tablero";
        $this->load->view('backend/index', $page_data);
    }
    
    function quote($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'finish')
        {
            $this->appointment_model->finish_appointment($param2);   
            $this->session->set_flashdata('flash_message' , "Cita finalizada y archivada correctamente.");
            redirect(base_url() . 'admin/appointments/', 'refresh');
        }
        if($param1 == 'create')
        {
            $this->appointment_model->create_appointment_quote();
            $this->session->set_flashdata('flash_message' , "Cita agendada correctamente.");
            redirect(base_url() . 'admin/appointments/', 'refresh');
        }
        $page_data['page_name']   = 'quote';
        $page_data['page_title']  = "Agendar cita";
        $this->load->view('backend/index', $page_data);
    }
    
    function appointment($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'finish_appointment')
        {
            $this->appointment_model->finish_appointment($param2);   
            $this->session->set_flashdata('flash_message' , "Cirugía finalizada y archivada correctamente.");
            redirect(base_url() . 'admin/appointments/', 'refresh');
        }
        if($param1 == 'create')
        {
            $this->appointment_model->create_appointment_quote();
            $this->session->set_flashdata('flash_message' , "Cirugía agendada correctamente.");
            redirect(base_url() . 'admin/appointments/', 'refresh');
        }
        $page_data['page_name']   = 'appointment';
        $page_data['page_title']  = "Agendar cirugías";
        $this->load->view('backend/index', $page_data);
    }
    
   function appointment_details_card($param1 = '', $param2 = '')
    {
        
        $app = $this->db->get_where('appointment',array('appointment_id'=>base64_decode($param1)))->result_array();
        foreach($app as $ap)
        {
        
                        $originalDate = $this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->date_of_birth;
                        $age = $this->accounts_model->get_age_card($originalDate);
                        
                        
                        if($this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->gender == "M"):
                        $gender = 'Masculino'; 
                        else:
                            $gender =  'Femenino'; 
                        endif;
                         $phone = $this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->phone;
                        if($this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->marital_status == 0):
                            $civil = 'Soltero'; 
                        else:
                            $civil =  'Casado'; 
                        endif;
                         $adress = $this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->address;
                         $date = $this->db->get_where('patient',array('patient_id'=>$ap['patient_id']))->row()->date;
                        
            $html = '<div  id="sticky"> 
            
            <div class="alert alert-white" style="margin-top: 42px;">
                    <span style="display:block;font-weight:bold;font-size:18px;font-family:"Poppins", sans-serif">Detalles de la cita:</span>
                        <div class="pi-controls">
                            <div class="pi-settings os-dropdown-trigger">
                                <i class="batch-icon-minus alert-rep-text"></i>
                            </div>
                        </div>
                        <div class="pipeline-item">
                            <div class="pi-body">
                                <div class="avatar" style="margin-right: 30px;">
                                    <img alt="" src="'.$this->accounts_model->get_photo('patient', $ap['patient_id']).'" width="65px" style="border-radius:25px;">
                                </div>
                                <div class="pi-info">
                                    <div class="h5 pi-name alert-rep-text">'.$this->accounts_model->get_full_name('patient', $ap['patient_id']).'</div>
                                    <div class="badge badge-success">Paciente nuevo.</div>
                                </div>
                            </div><hr>
                               <div class="">
                                <ul>
                                    <li><b>Fecha de registro:</b> '.$date.'</li>
                                    <li><b>Edad:</b> '.$age.'</li>
                                    <li><b>Género:</b> '.$gender.'</li>
                                    <li><b>Celular:</b> '.$phone.'</li>
                                    <li><b>Estado civil:</b> '.$civil.'</li>
                                    <li><b>Dirección:</b> '.$adress.'</li>
                                </ul>
                                <div class="alert alert-rep">
                                    <b>Motivo, molestias o síntomas del paciente:</b>
                                    <span style="display:block">'.$ap['comment'].'</span>
                                </div>';
                               if($this->check['access_appointments'] == 1)
                                $html .= ' <a class="btn btn-success" href="'.base_url().'admin/appointment_details/'.base64_encode($ap['appointment_id']).'"><i class="picons-thin-icon-thin-0133_arrow_right_next"></i> Ingresar a la cita</a>';
                              
                            $html .= '</div>
                        </div>
                    </div>
                    </div>';
        }
                echo $html;
        
     

    }


    function vital_signs_card($param1 = '', $param2 = '')
    {
        
        $patient_id = $this->db->get_where('appointment',array('appointment_id'=>base64_decode($param1)))->row()->patient_id;
        $vss = $this->db->order_by('vital_sign_id', 'desc')->limit(1)->get_where('vital_sign',array('patient_id'=>$patient_id))->result_array();

        if(count( $vss) > 0)
        {

        
            foreach($vss as $vs)
            {                        
                $html = '<div  id="sticky"> 
                
                <div class="alert alert-white" style="margin-top: 42px;">
                        <span style="display:block;font-weight:bold;font-size:18px;font-family:"Poppins", sans-serif">Detalles de la cita:</span>
                            <div class="pi-controls">
                                <div class="pi-settings os-dropdown-trigger">
                                    <i class="batch-icon-minus alert-rep-text"></i>
                                </div>
                            </div>
                            <div class="pipeline-item">
                                <div class="pi-body">
                                    <div class="avatar" style="margin-right: 30px;">
                                        <img alt="" src="'.$this->accounts_model->get_photo('patient', $patient_id).'" width="65px" style="border-radius:25px;">
                                    </div>
                                    <div class="pi-info">
                                        <div class="h5 pi-name alert-rep-text">'.$this->accounts_model->get_full_name('patient', $patient_id).'</div>
                                        <div class="badge badge-success">Paciente nuevo.</div>
                                    </div>
                                    
                                </div>
                                <hr>
                                <div class="">
                                    <a class="btn btn-sm btn-success pull-right" href="javascript:void(0)" onclick="appointment_new_vital_sign(\''.$param1.'\')"> Registrar signos vitales </a>
                                </div>
                                
                                <span style="display:block;font-weight:bold;font-size:18px;font-family:"Poppins", sans-serif">Signos vitales:</span>
                                <br>
                                <div class="">
                                <div class="col-sm-12 row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>Peso:(lbs)</b>
                                            <input class="form-control w" type="number" step="any" onchange="updateConsulta(\'w\','.$vs['vital_sign_id'].',this.value),updateIMC('.$vs['vital_sign_id'].',this.value)"  value="'. $vs['w'].'"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>Altura:(cm)</b>
                                            <input class="form-control t" type="number" step="any" onchange="updateConsulta(\'t\','.$vs['vital_sign_id'].',this.value),updateIMC('.$vs['vital_sign_id'].',this.value)" value="'. $vs['t'].'"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>IMC:</b>
                                            <input class="form-control imc" type="number" step="any" onchange="updateConsulta(\'imc\','.$vs['vital_sign_id'].',this.value)" value="'. $vs['imc'].'"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>Temp:</b>
                                            <input class="form-control" type="text" step="any" onchange="updateConsulta(\'temp\','.$vs['vital_sign_id'].',this.value)" value="'. $vs['temp'].'"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>FR:</b>
                                            <input class="form-control" type="text" step="any" onchange="updateConsulta(\'fr\','.$vs['vital_sign_id'].',this.value)" value="'. $vs['fr'].'"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b>Circunferencia abdominal:</b>
                                            <input class="form-control" type="text" step="any" onchange="updateConsulta(\'cb\','.$vs['vital_sign_id'].',this.value)" value="'. $vs['cb'].'"></input>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>FC:</b>
                                            <input class="form-control" type="text" step="any" onchange="updateConsulta(\'fc\','.$vs['vital_sign_id'].',this.value)" value="'. $vs['fc'].'"></input>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>PA:</b>
                                            <input class="form-control" type="text" step="any" onchange="updateConsulta(\'pa\','.$vs['vital_sign_id'].',this.value)" value="'. $vs['pa'].'"></input>
                                        </div>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>SO2:</b>
                                        <input class="form-control" type="text" step="any" onchange="updateConsulta(\'so2\','.$vs['vital_sign_id'].',this.value)" value="'. $vs['so2'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Glucometría:</b>
                                        <input class="form-control" type="text" step="any" onchange="updateConsulta(\'gl\','.$vs['vital_sign_id'].',this.value)" value="'. $vs['gl'].'"></input>
                                    </div>
                                </div>
                            </div>';

                          
                            if($this->check['access_appointments'] == 1)
                                $html .= ' <a class="btn btn-success" href="'.base_url().'admin/appointment_details/'.$param1.'"><i class="picons-thin-icon-thin-0133_arrow_right_next"></i> Ingresar a la cita</a>';
                                
                                $html .= '</div>
                            </div>
                        </div>
                        </div>';
            }
        }else
        {

            $vs = $this->db->select_max('vital_sign_id')->get('vital_sign')->row()->vital_sign_id+1;
                            
            $html = '<div  id="sticky"> 
            <input type="hidden" id="patient_id" value="'.$patient_id.'">
            <div class="alert alert-white" style="margin-top: 42px;">
                    <span style="display:block;font-weight:bold;font-size:18px;font-family:"Poppins", sans-serif">Detalles de la cita:</span>
                        <div class="pi-controls">
                            <div class="pi-settings os-dropdown-trigger">
                                <i class="batch-icon-minus alert-rep-text"></i>
                            </div>
                        </div>
                        <div class="pipeline-item">
                            <div class="pi-body">
                                <div class="avatar" style="margin-right: 30px;">
                                    <img alt="" src="'.$this->accounts_model->get_photo('patient', $patient_id).'" width="65px" style="border-radius:25px;">
                                </div>
                                <div class="pi-info">
                                    <div class="h5 pi-name alert-rep-text">'.$this->accounts_model->get_full_name('patient', $patient_id).'</div>
                                    <div class="badge badge-success">Paciente nuevo.</div>
                                </div>
                            </div><hr>
                            <span style="display:block;font-weight:bold;font-size:18px;font-family:"Poppins", sans-serif">Signos vitales:</span>
                            <br>
                               <div class="">
                               <div class="col-sm-12 row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Peso:(lbs)</b>
                                        <input class="form-control w" type="number" step="any" onchange="updateConsulta(\'w\','.$vs.',this.value),updateIMC('.$vs.',this.value)" value="'. $vs['w'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Altura:(cm)</b>
                                        <input class="form-control t" type="number" step="any" onchange="updateConsulta(\'t\','.$vs.',this.value),updateIMC('.$vs.',this.value)" value="'. $vs['t'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>IMC:</b>
                                        <input class="form-control imc" type="number" step="any" onchange="updateConsulta(\'imc\','.$vs.',this.value)" value="'. $vs['imc'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Temp:</b>
                                        <input class="form-control" type="number" step="any" onchange="updateConsulta(\'temp\','.$vs.',this.value)" value="'. $vs['temp'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>FR:</b>
                                        <input class="form-control" type="number" step="any" onchange="updateConsulta(\'fr\','.$vs.',this.value)" value="'. $vs['fr'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Circunferencia abdominal:</b>
                                        <input class="form-control" type="text" step="any" onchange="updateConsulta(\'cb\','.$vs.',this.value)" value="'. $vs['cb'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>FC:</b>
                                        <input class="form-control" type="number" step="any" onchange="updateConsulta(\'fc\','.$vs.',this.value)" value="'. $vs['fc'].'"></input>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>PA:</b>
                                        <input class="form-control" type="text" step="any" onchange="updateConsulta(\'pa\','.$vs.',this.value)" value="'. $vs['pa'].'"></input>
                                    </div>
                                </div>
                               <div class="col-sm-12">
                                   <div class="form-group">
                                       <b>SO2:</b>
                                       <input class="form-control" type="number" step="any" onchange="updateConsulta(\'so2\','.$vs.',this.value)" value="'. $vs['so2'].'"></input>
                                   </div>
                               </div>
                               <div class="col-sm-12">
                                   <div class="form-group">
                                       <b>Glucometría:</b>
                                       <input class="form-control" type="number" step="any" onchange="updateConsulta(\'gl\','.$vs.',this.value)" value="'. $vs['gl'].'"></input>
                                   </div>
                               </div>
                           </div>';
                           if($this->check['access_appointments'] == 1) 
                                    $html .= ' <a class="btn btn-success" href="'.base_url().'admin/appointment_details/'.$param1.'"><i class="picons-thin-icon-thin-0133_arrow_right_next"></i> Ingresar a la cita</a>';
                              
                            $html .= '</div>
                        </div>
                    </div>
                    </div>';
       

        }
            
        echo $html;
        
     

    }

    
    function new_vital_signs_card($param1 = '', $param2 = '')
    {
        $patient_id = $this->db->get_where('appointment',array('appointment_id'=>base64_decode($param1)))->row()->patient_id;
        $vs = $this->db->select_max('vital_sign_id')->get('vital_sign')->row()->vital_sign_id+1;
                            
            $html = '<div  id="sticky"> 
            <input type="hidden" id="patient_id" value="'.$patient_id.'">
            <div class="alert alert-white" style="margin-top: 42px;">
                    <span style="display:block;font-weight:bold;font-size:18px;font-family:"Poppins", sans-serif">Detalles de la cita:</span>
                        <div class="pi-controls">
                            <div class="pi-settings os-dropdown-trigger">
                                <i class="batch-icon-minus alert-rep-text"></i>
                            </div>
                        </div>
                        <div class="pipeline-item">
                            <div class="pi-body">
                                <div class="avatar" style="margin-right: 30px;">
                                    <img alt="" src="'.$this->accounts_model->get_photo('patient', $patient_id).'" width="65px" style="border-radius:25px;">
                                </div>
                                <div class="pi-info">
                                    <div class="h5 pi-name alert-rep-text">'.$this->accounts_model->get_full_name('patient', $patient_id).'</div>
                                    <div class="badge badge-success">Paciente nuevo.</div>
                                </div>
                            </div><hr>
                            <span style="display:block;font-weight:bold;font-size:18px;font-family:"Poppins", sans-serif">Signos vitales:</span>
                            <br>
                               <div class="">
                               <div class="col-sm-12 row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Peso:(lbs)</b>
                                        <input class="form-control w" type="number" step="any" onchange="updateConsulta(\'w\','.$vs.',this.value),updateIMC('.$vs.',this.value)" value="'. $vs['w'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Altura:(cm)</b>
                                        <input class="form-control t" type="number" step="any" onchange="updateConsulta(\'t\','.$vs.',this.value),updateIMC('.$vs.',this.value)" value="'. $vs['t'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>IMC:</b>
                                        <input class="form-control imc" type="number" step="any" onchange="updateConsulta(\'imc\','.$vs.',this.value)" value="'. $vs['imc'].'" ></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Temp:</b>
                                        <input class="form-control" type="number" step="any" onchange="updateConsulta(\'temp\','.$vs.',this.value)" value="'. $vs['temp'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>FR:</b>
                                        <input class="form-control" type="number" step="any" onchange="updateConsulta(\'fr\','.$vs.',this.value)" value="'. $vs['fr'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <b>Circunferencia abdominal:</b>
                                        <input class="form-control" type="text" step="any" onchange="updateConsulta(\'cb\','.$vs.',this.value)" value="'. $vs['cb'].'"></input>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>FC:</b>
                                        <input class="form-control" type="number" step="any" onchange="updateConsulta(\'fc\','.$vs.',this.value)" value="'. $vs['fc'].'"></input>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>PA:</b>
                                        <input class="form-control" type="text" step="any" onchange="updateConsulta(\'pa\','.$vs.',this.value)" value="'. $vs['pa'].'"></input>
                                    </div>
                                </div>
                               <div class="col-sm-12">
                                   <div class="form-group">
                                       <b>SO2:</b>
                                       <input class="form-control" type="number" step="any" onchange="updateConsulta(\'so2\','.$vs.',this.value)" value="'. $vs['so2'].'"></input>
                                   </div>
                               </div>
                               <div class="col-sm-12">
                                   <div class="form-group">
                                       <b>Glucometría:</b>
                                       <input class="form-control" type="number" step="any" onchange="updateConsulta(\'gl\','.$vs.',this.value)" value="'. $vs['gl'].'"></input>
                                   </div>
                               </div>
                           </div>';
                           if($this->check['access_appointments'] == 1)  
                                $html .= ' <a class="btn btn-success" href="'.base_url().'admin/appointment_details/'.base64_encode($param1).'"><i class="picons-thin-icon-thin-0133_arrow_right_next"></i> Ingresar a la cita</a>';
                              
                            $html .= '</div>
                        </div>
                    </div>
                    </div>';
       
                echo $html;
        
    }



    
    function patient_treatment($param1 = '', $param2 = '')
    {
        
        $treatment = $this->db->get_where('odonto_treatment',array('patient_id'=>$param1,'status'=>1));

        if($treatment->num_rows()> 0 )
        {
            $html = '<div id="select_treatment"> <h3 class="main_question">Seleccione un tratamiento</h3>
                <div class = "row">
                <div class="col-md-12">
                <div class="form-group">
                        <select class="itemName2 form-control select2"  style="width:100%" name="select_treatment" required="" onchange="new_treatment(this.value)">
                            <option value="">Seleccionar</option>';

                            foreach($treatment->result_array() as $tr){
                          
                                $html .= ' <option value="'.$tr['treatment_id'].'">'.$tr['name'].'</option>';
                                        
                               
                                           }
           
                        $html .= ' <option value="0" >Nuevo tratamiento</option>
                        
                        </select>
                    </div>
                    </div>
                </div>
                </div>
                
                <div id="new_treatment" style="display:none"><h3 class="main_question"><strong>5/5</strong>Nuevo tratamiento</h3>
            <div class="form-group">
                <label>Nombre del plan</label>
                <input type="text" name="name_treatment" class="form-control" id="name_treatment" >
            </div>
            <br>
            <div class="form-group">
                <label>Tipo de tratamiento:</label>
                <div class="input-group">
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="infantil" value="0"  >
                        <label class="radiobutton-label" for="infantil">Infantil</label>
                    </div> 
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="adulto" value="1" >
                        <label class="radiobutton-label" for="adulto">Adulto</label>
                    </div>
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="mixto" value="2">
                        <label class="radiobutton-label" for="mixto">Mixto</label>
                    </div>
                </div>
            </div>
            <input type="hidden" name="patient_id" value="'.$param1.'">
            </div>
            ';

        }else
        {
            
                        
            $html = '<h3 class="main_question"><strong>5/5</strong>Nuevo tratamiento</h3>
            <div class="form-group">
                <label>Nombre del plan</label>
                <input type="text" name="name_treatment" class="form-control" required="" >
            </div>
            <br>
            <div class="form-group">
                <label>Tipo de tratamiento:</label>
                <div class="input-group">
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="infantil" value="0"  required="">
                        <label class="radiobutton-label" for="infantil">Infantil</label>
                    </div>
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="adulto" value="1" required="">
                        <label class="radiobutton-label" for="adulto">Adulto</label>
                    </div>
                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                        <input class="radiobutton" type="radio" name="type_treatment" id="mixto" value="2" required="">
                        <label class="radiobutton-label" for="mixto">Mixto</label>
                    </div>
                </div>
            </div>
            <input type="hidden" name="patient_id" value="'.$param1.'">';
        }
                echo $html;

    }
    
    
   
        function appointment_patients($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'finish')
        {
            $this->appointment_model->finish_appointment();   
            $this->session->set_flashdata('flash_message' , "Cita finalizada y archivada correctamente.");
            redirect(base_url() . 'admin/archived/', 'refresh');
        }
        if($param1 == 'create')
        {
            $this->appointment_model->create_appointment();
            $this->session->set_flashdata('flash_message' , "Cita agendada correctamente.");
            redirect(base_url() . 'admin/patients/profile/'.$param2, 'refresh');
        }
        $page_data['id_']   = $param1;
        $page_data['page_name']   = 'appointment_patients';
        $page_data['page_title']  = "Agendar cita";
        $this->load->view('backend/index', $page_data);
    }
    
    function appointment_details($param1 = '', $param2 = '')
    {
        $this->session_login();
        
        if($this->check['access_appointments'] != 1)
        {
            redirect(base_url().'/admin/panel', 'refresh');
        }

        if($param1 == 'order_details')
        {

            $data = array(
                'code' => $param2,
            );
            $this->pdf_model->pdf('Orden médica','order_details.php',$data);

        }

        if($param1 == 'lab_details')
        {

            $data = array(
                'code' => $param2,
            );
            $this->pdf_model->pdf('Orden de laboratorios','lab_details.php',$data);

        }

        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'appointment_details';
        $page_data['page_title']  = "Detalles de la Cita";
        $this->load->view('backend/index', $page_data);
    }
    
    function chat($param1 = '', $param2 = '', $param3 = '')
    {
         $this->session_login();
        if($param1 == 'send_message')
        {
            $this->session->set_flashdata('flash_message' , "Mensaje enviado correctamente.");
            $this->chat_model->send_chat_message($this->input->post('thread_code'));
            redirect(base_url() . 'admin/messages/' . $this->input->post('redirect'), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->chat_model->delete_chat($param2);
            $this->session->set_flashdata('flash_message' , "Mensaje eliminado correctamente.");
            redirect(base_url() . 'admin/chat/', 'refresh');
        }  
        if($param1 == 'delete_single')
        {
            $this->chat_model->delete_single_chat($param2);
            $this->session->set_flashdata('flash_message' , "Mensaje eliminado correctamente.");
            redirect(base_url() . 'admin/messages/'.$param3, 'refresh');
        }  
        $page_data['page_name']   = 'chat';
        $page_data['page_title']  = "Chat";
        $this->load->view('backend/admin/chat', $page_data);
    }
    

    
    function messages($param1 = '', $param2 = '')
    {
         $this->session_login();
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        
        
        if(isset($_GET['notify'])){
            $update['read_status'] = 1;
            $this->db->where('message_id', $_GET['notify']);
            $this->db->update('message',$update);
        }
        $page_data['username'] = $param1;
        $page_data['page_name']   = 'messages';
        $page_data['page_title']  = "Mensajes";
        $this->load->view('backend/admin/messages', $page_data);
    }
    
    function soon($param1 = '', $param2 = '')
    {
         $this->session_login();

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        $page_data['page_name']   = 'soon';
        $page_data['page_title']  = "Próximas citas";
        $this->load->view('backend/index', $page_data);
    }
    
     function rescheduled($param1 = '', $param2 = '')
    {
         $this->session_login();

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        $page_data['page_name']   = 'rescheduled';
        $page_data['page_title']  = "Citas Reprogramadas";
        $this->load->view('backend/index', $page_data);
    }
    
    function cancelled($param1 = '', $param2 = '')
    {
         $this->session_login();

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }
        
         if($this->input->post('doctor_id') != '')
        {
            $this->session->set_userdata('doctor_id', $this->input->post('doctor_id'));
        }else
        {
              $this->session->set_userdata('doctor_id', 0);
        }
        $page_data['page_name']   = 'cancelled';
        $page_data['page_title']  = "Citas Canceladas";
        $this->load->view('backend/index', $page_data);
    }
    
    function archived($param1 = '', $param2 = '')
    {
         $this->session_login();

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }
        $page_data['page_name']   = 'archived';
        $page_data['page_title']  = "Citas Archivadas";
        $this->load->view('backend/index', $page_data);
    }
    
        function mail_view($param1 = ''){
            
         $this->session_login();
        $data = array(
                'appointment_id' => $param1,
            );
        $this->load->view('backend/mails/mail_view.php',$data);
        
        }
        
        
        
    function appointments($param1 = '', $param2 = '') 
    {
         $this->session_login();
        if($param1 == 'start')
        {
            $this->appointment_model->start_appointment(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "La cita ha comenzado.");
            redirect(base_url() . 'admin/appointment_details/'.$param2, 'refresh');
        }
        
        if($param1 == 'confirm')
        {
           
            $patient_id = $this->db->get_where('appointment', array('appointment_id' => $param2))->row()->patient_id;
            
            $email_status = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email_status;
            
            $this->log_model->confirm_appointment($param2);
            $this->appointment_model->confirm_appointment($param2);
            $this->notify_model->confirm_appointment($param2);

            $w_status = $this->db->get_where('patient', array('patient_id'=>$patient_id ))->row()->whatsapp_status;
           
            if($w_status == 1)
            {
              
            }
            if($email_status==1)
            {          
                $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;
                require("public/apis/class.phpmailer.php");
                $mail = new PHPMailer(); 
                $mail->IsHTML(true);
                $mail->IsMail();
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom($this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email, 'Confirmación de cita');
                $mail->Subject = 'Confirmacion de cita - '.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;
                $data = array(
                    'appointment_id' => $param2,
                );
            
                $mail->Body = $this->load->view('backend/mails/confirm_appointment.php',$data,true);
                $mail->AddAddress($email);
                if($email != ''){
                    if(!$mail->Send()) {
                        $this->session->set_flashdata('flash_message' , "La cita no se pudo confirmar");
                        redirect(base_url() . 'admin/appointments/', 'refresh');
                    }else
                    {
                        $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
                        redirect(base_url() . 'admin/appointments/', 'refresh');
                    }
                }
            }else
            {
                $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
                redirect(base_url() . 'admin/appointments/', 'refresh');
            }
            
        }
        
        if($param1 == "pay_1")
        {
            $this->appointment_model->pay_1($param2);
            $this->session->set_flashdata('flash_message' , "La cita se pago correctamente");
            redirect(base_url() . 'admin/appointments/', 'refresh');
        }
        if($param1 == 'remainder')
        {
            $patient_id = $this->db->get_where('appointment', array('appointment_id' => $param2))->row()->patient_id;
            
           
            redirect(base_url() . 'admin/archived/', 'refresh');
        }
        
        if($param1 == 'confirm_appointment_det')
        {
            $this->log_model->confirm_appointment($param2);
            $this->appointment_model->confirm_appointment($param2);
            $this->notify_model->confirm_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
            redirect(base_url() . 'admin/appointment_details/'.base64_encode($param2), 'refresh');
        }
        if($param1 == 'cancel')
        {
            $this->log_model->cancel_appointment($param2);
            $this->appointment_model->cancel_appointment($param2);
            $this->notify_model->cancel_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Cita cancelada correctamente.");
            redirect(base_url() . 'admin/appointments/', 'refresh');
        }
        if($param1 == 'change')
        {
            $this->log_model->reschedule_appointment($param2);
            $this->appointment_model->reschedule_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Cita reprogramada correctamente.");
            redirect(base_url() . 'admin/appointments/', 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->log_model->delete_appointment($param2);
            $this->notify_model->delete_appointment($param2);
            $this->appointment_model->delete_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Cita eliminada correctamente.");
            redirect(base_url() . 'admin/cancelled/', 'refresh');
        }
        if($param1 == 'delete_calendar')
        {
            $this->log_model->delete_appointment($param2);
            $this->notify_model->delete_appointment($param2);
            $this->appointment_model->delete_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Eliminado correctamente.");
            redirect(base_url() . 'admin/calendar/', 'refresh');
        }

        if($this->input->post('date') != '')
        {
            $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        if($this->input->post('doctor_id') != '')
        {
            $this->session->set_userdata('doctor_id', $this->input->post('doctor_id'));
        }else
        {
              $this->session->set_userdata('doctor_id', 0);
        }

        $page_data['page_name']         = 'appointments';
        $page_data['page_title']        = "Citas programadas";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function appointments_box($param1 = '', $param2 = '') 
    {
         $this->session_login();
        if($param1 == 'start')
        {
            $this->appointment_model->start_appointment(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "La cita ha comenzado.");
            redirect(base_url() . 'staff/appointment_details/'.$param2, 'refresh');
        }
        
        if($param1 == 'confirm')
        {
           
            $patient_id = $this->db->get_where('appointment', array('appointment_id' => $param2))->row()->patient_id;
            
            $email_status = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email_status;
            
            $this->log_model->confirm_appointment($param2);
            $this->appointment_model->confirm_appointment($param2);
            $this->notify_model->confirm_appointment($param2);

            $w_status = $this->db->get_where('patient', array('patient_id'=>$patient_id ))->row()->whatsapp_status;
           
            if($w_status == 1)
            {
              
            }
            if($email_status==1)
            {          
                $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;
                require("public/apis/class.phpmailer.php");
                $mail = new PHPMailer(); 
                $mail->IsHTML(true);
                $mail->IsMail();
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom($this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->email, 'Confirmación de cita');
                $mail->Subject = 'Confirmacion de cita - '.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;
                $data = array(
                    'appointment_id' => $param2,
                );
            
                $mail->Body = $this->load->view('backend/mails/confirm_appointment.php',$data,true);
                $mail->AddAddress($email);
                if($email != ''){
                    if(!$mail->Send()) {
                        $this->session->set_flashdata('flash_message' , "La cita no se pudo confirmar");
                        redirect(base_url() . 'staff/appointments_box/', 'refresh');
                    }else
                    {
                        $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
                        redirect(base_url() . 'staff/appointments_box/', 'refresh');
                    }
                }
            }else
            {
                $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
                redirect(base_url() . 'staff/appointments_box/', 'refresh');
            }
            
        }
        
        if($param1 == "pay_1")
        {
            $this->appointment_model->pay_1($param2);
            $this->session->set_flashdata('flash_message' , "La cita se pago correctamente");
            redirect(base_url() . 'staff/appointments_box/', 'refresh');
        }
        if($param1 == 'remainder')
        {
            $patient_id = $this->db->get_where('appointment', array('appointment_id' => $param2))->row()->patient_id;
            
           
            redirect(base_url() . 'staff/archived/', 'refresh');
        }
        
        if($param1 == 'confirm_appointment_det')
        {
            $this->log_model->confirm_appointment($param2);
            $this->appointment_model->confirm_appointment($param2);
            $this->notify_model->confirm_appointment($param2);
            $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
            redirect(base_url() . 'staff/appointments_box/'.base64_encode($param2), 'refresh');
        }
    

        if($this->input->post('date') != '')
        {
            $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        if($this->input->post('doctor_id') != '')
        {
            $this->session->set_userdata('doctor_id', $this->input->post('doctor_id'));
        }else
        {
              $this->session->set_userdata('doctor_id', 0);
        }

        $page_data['page_name']         = 'appointments_box';
        $page_data['page_title']        = "Citas programadas";
        $this->load->view('backend/index', $page_data);
    }
    
    
 public function stabilitation($param1 = '', $param2 = '')
    {
        $this->session_login();
        
        if ($param1 == 'new') {
            $this->appointment_model->create_stabilitation();
            $this->session->set_flashdata('flash_message', "Hospitalización agendada correctamente.");
            redirect(base_url() . 'admin/stabilitation/', 'refresh');
        }

        if ($param1 == 'finish') {
            $this->appointment_model->finish_stabilitation($param2);
            $this->session->set_flashdata('flash_message', "Turno terminado");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }

        if ($param1 == 'end') {
            $this->appointment_model->end_stabilitation($param2);
            $this->session->set_flashdata('flash_message', "Paciente dado de alta");
            redirect(base_url() . 'admin/stabilitation/', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->appointment_model->delete_stabilitation($param2);
            $this->session->set_flashdata('flash_message', "Hospitalizacion eliminada ");
            redirect(base_url() . 'admin/stabilitation/', 'refresh');
        }

        if ($this->input->post('date') != '') {
            $page_data['filter']         = base64_encode($this->input->post('date'));
        } else {
            $page_data['filter']            = false;
        }


        $page_data['page_name']         = 'stabilitation';
        
        $page_data['page_title']        = "Estabilización";
        $this->load->view('backend/index', $page_data);
    }
    
    function financial_stabilitation($param1 = '', $param2 = '') 
    {
        $this->session_login();
        $page_data['page_name']         = 'financial_stabilitation';
        $page_data['page_title']        = "Balance de hospitalizaciones";
        $this->load->view('backend/index', $page_data);
    }
    
    function stabilitation_financial($param1 = '', $param2 = '') 
    {
         $this->session_login();
        $page_data['id_'] = $param1;
        $page_data['page_name']         = 'stabilitation_financial';
        $page_data['page_title']        = "Balance de hospitalizaciones";
        $this->load->view('backend/index', $page_data);
    }
    
    function stabilitation_details($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'stabilitation_details';
        $page_data['page_title']  = "Detalles de la Estabilización";
        $this->load->view('backend/index', $page_data);
    }

    function pending_payment(){
         $this->session_login();

        if($this->input->post('date') != '')
        {
             $page_data['filter']         = base64_encode($this->input->post('date'));
        }else
        {
            $page_data['filter']            = false;
        }

        if($this->input->post('doctor_id') != '')
        {
            $this->session->set_userdata('doctor_id', $this->input->post('doctor_id'));
        }

        $page_data['page_name']     ='pending_payment';
        $page_data['page_title']    ='Citas pendientes de pago';
        $this->load->view('backend/index', $page_data);
        }
    
    
    
    function clinics($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'update')
        {
            $this->log_model->update_clinic($param2);
            $this->crud_model->update_clinic($param2);
            $this->session->set_flashdata('flash_message' , "Clínica actualizada correctamente.");
            redirect(base_url() . 'admin/clinics/', 'refresh');
        }
        if($param1 == 'create')
        {
            $this->crud_model->create_clinic();
            $this->session->set_flashdata('flash_message' , "Clínica agregada correctamente.");
            redirect(base_url() . 'admin/clinics/', 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->crud_model->delete_clinic($param2);
            $this->session->set_flashdata('flash_message' , "Clínica eliminada correctamente.");
            redirect(base_url() . 'admin/clinics/', 'refresh');
        }
        $page_data['page_name']  = 'clinics';
        $page_data['page_title'] = "Clínicas";
        $this->load->view('backend/index', $page_data); 
    }

    function samples_new_rec($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['category_id']  = $param1;
        $page_data['page_name']  = 'samples_new_rec';
        $page_data['page_title'] = "Recepción de muestras";
        $this->load->view('backend/index', $page_data);
    }
    
    function patients($param1 = '', $param2 = '')
    {
         $this->session_login();

        if($param1 == 'change_pass')
        {
            $this->accounts_model->update_patient_pass($param2);
            redirect(base_url() . 'admin/patient_security/'.base64_encode($param2), 'refresh');   
        }

        if($param1 == 'allergies')
        {
            $data['patient_id'] = $this->input->post('patient_id');
            $data['name'] = $this->input->post('name');
            $data['date'] = $this->crud_model->formatDate();
            return $this->db->insert('allergie', $data);
        }
        
        if($param1 == 'delete_allergie')
        {
            $patient_id = base64_encode($this->db->get_where('allergie', array('allergie_id'=>$param2))->row()->patient_id);
            $this->crud_model->delete_allergie($param2);
            $this->session->set_flashdata('flash_message' , "Alergia eliminada correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$patient_id.'/', 'refresh');
        }
        
        if($param1 == 'create')
        {
            $patient_id = $this->accounts_model->create_patient();
            $this->session->set_flashdata('flash_message' , "Paciente agregado correctamente.");
            redirect(base_url() . 'admin/patient_profile/'.$patient_id, 'refresh');
        }
        if($param1 == 'update')
        {

            $this->accounts_model->update_patient($param2);
            $this->session->set_flashdata('flash_message' , "Paciente actualizado correctamente.");
           
            redirect(base_url() . 'admin/patient_profile/'.base64_encode($param2), 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->log_model->delete_patient($param2);
            $this->accounts_model->delete_patient($param2,true);
            $this->session->set_flashdata('flash_message' , "Paciente eliminado correctamente.");
            redirect(base_url().'admin/patients', 'refresh');
        }

        if($param1 == 'save_history')
        {
            
           $data['observations'] = $this->input->post('history');
            
            $this->db->where('appointment_id',$param2);
            $this->db->update('appointment',$data);
            /*
            $data['history'] = $this->input->post('history');
            
            $this->db->where('patient_id',$param2);
            $this->db->update('patient',$data);

            
            */
            
            exit();
        }

        
        if($param1 == 'save_dieta')
        {
            
           
            
            $data['dieta'] = $this->input->post('dieta');
            
            $this->db->where('patient_id',$param2);
            $this->db->update('patient',$data);

            exit();
        }
       
        
         if($param1 == 'profile')
        {
            $page_data['id_']   = $param2;
        }
        
        
        $page_data['page_name']   = 'patients';
        $page_data['page_title']  = "Pacientes";
        $this->load->view('backend/index', $page_data);
    }
    
    function plans($param1 = '') {
        $this->session_login();
        $page_data['page_name']   = 'plans';
        $page_data['page_title']  = "Puntos y suscripciones";
        $this->load->view('backend/index', $page_data);
    }

    function memberships($param1 = '', $param2 = '') {
        $this->session_login();

        if($param1 == 'create_membership')
        {

            $this->crud_model->create_membership();
            $this->session->set_flashdata('flash_message' , "Membresía creada correctamente.");
            redirect(base_url().'admin/memberships', 'refresh');
        }
        
        if($param1 == 'update_membership')
        {

            $this->crud_model->update_membership($param2);
            $this->session->set_flashdata('flash_message' , "Membresía actualizada correctamente.");
            redirect(base_url().'admin/memberships', 'refresh');
        }
        
        if($param1 == 'delete_membership')
        {

            $this->crud_model->delete_membership($param2);
            $this->session->set_flashdata('flash_message' , "Membresía eliminada correctamente.");
            redirect(base_url().'admin/memberships', 'refresh');
        }
        
        
        $page_data['page_name']   = 'memberships';
        $page_data['page_title']  = "Membresias";
        $this->load->view('backend/index', $page_data);
    }

    function membership_details($param1 = '',$param2 = '') {
        $this->session_login();

        if($param1 == 'new_benefit')
        {

            $this->crud_model->create_membership_benefit();
            $this->session->set_flashdata('flash_message' , "Beneficio agregado correctamente.");
             redirect($this->agent->referrer(),'refresh' );
             
        }
        
        if($param1 == 'edit_benefit')
        {

            $this->crud_model->edit_membership_benefit(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "Beneficio actualizado correctamente.");
             redirect($this->agent->referrer(),'refresh' );
             
        }
        
        if($param1 == 'delete')
        {

            $this->crud_model->delete_membership_benefit(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "Beneficio eliminado correctamente.");
             redirect($this->agent->referrer(),'refresh' );
             
        }
        $page_data['membership_id']   = base64_decode($param1);
        $page_data['page_name']   = 'membership_details';
        $page_data['page_title']  = "Detalles de la membresias";
        $this->load->view('backend/index', $page_data);
    }
    
    function points($param1 = '') {
        
       

        if($param1 == 'set')
        {
            $this->db->where('type','point_value');
            $this->db->update('settings',array('description'=>$this->input->post('value')));	
            $this->session->set_flashdata('flash_message' , "Valor de puntos actualizado correctamente.");
            redirect(base_url().'admin/points', 'refresh');
        }

        $this->session_login();
        $page_data['page_name']   = 'points';
        $page_data['page_title']  = "Puntos";
        $this->load->view('backend/index', $page_data);
    }

    function accounting($param1 = '') {
        $this->session_login();
        $page_data['page_name']   = 'accounting';
        $page_data['page_title']  = "Contabilidad";
        $this->load->view('backend/index', $page_data);
    }

    function save_content($param1 = "")
    {
        
          $this->session_login();
          
        if($this->input->post('table') == 'medic_order')
        {
            $code = base64_decode($this->input->post('code'));	
            $medic_order = $this->db->get_where('medic_order',array('medic_order_id'=>$code))->num_rows();
           
            if($medic_order > 0)
            {
                $data['patient_id'] = $param1;
                $data['date']  = $this->input->post('date');
                $data['user_id'] =  $this->session->userdata('login_user_id');
                $data['user_type'] =  $this->session->userdata('login_type');;
                $data['order'] = $this->input->post('content');
                $data['type']  = $this->input->post('type');
                $this->db->where('medic_order_id',$code);
                $this->db->update('medic_order',$data);
            }else
            {
                $data['patient_id'] = $param1;
                $data['date']  = $this->input->post('date');
                $data['user_id'] =  $this->session->userdata('login_user_id');
                $data['user_type'] =  $this->session->userdata('login_type');;
                $data['order'] = $this->input->post('content');
                $data['type']  = $this->input->post('type');
                $this->db->insert('medic_order',$data);
            }
           
            exit();
        }

        if($this->input->post('table') == 'nurse_note')
        {
                $data['patient_id'] = $param1;
                $data['stabilitation_ref_id'] =  $this->input->post('stabilitation_id');
                $data['date']  = $this->input->post('date');
                $data['diet']  = $this->input->post('diet');
                $data['observations'] = $this->input->post('observations');
                $data['user_id'] =  $this->session->userdata('login_user_id');
                $data['user_type'] =  $this->session->userdata('login_type');;
                $this->db->insert('nurse_note',$data);
          
              exit();
        } 

        if($this->input->post('table') == 'medication_supplied')
        {
            
                $product = $this->db->get_where('product',array('product_id'=>$this->input->post('product_id')))->row_array();
                $data['patient_id'] = $param1;
                $data['stabilitation_ref_id'] =  $this->input->post('stabilitation_id');
                $data['date']  = $this->input->post('date');
                $data['dosis']  = $this->input->post('dosis');
                $data['product_id'] = $this->input->post('product_id');
                $data['user_id'] =  $this->session->userdata('login_user_id');
                $data['user_type'] =  $this->session->userdata('login_type');
                $data['price'] =  $product['price_1'];
                $this->db->insert('medication_supplied',$data);
          
              exit();
        } 

    }

    function delete_content($param1 = "",$param2 = "")
    {
        
          $this->session_login();
          
          
        if($param1== 'medic_order')
        {
            $id = base64_decode($param2);	
           
            $this->db->where('medic_order_id',$id);
            $this->db->delete('medic_order');
           
            exit();
        }

        if($param1== 'nurse_note')
        {
            $id = base64_decode($param2);	
           
            $this->db->where('nurse_note_id',$id);
            $this->db->delete('nurse_note');
           
            exit();
        }

        if($param1== 'medication_supplied')
        {
            $id = base64_decode($param2);	
           
            $this->db->where('medication_supplied_id',$id);
            $this->db->delete('medication_supplied');
           
            exit();
        }

        if($param1== 'patient_vital_signs')
        {
            $id = base64_decode($param2);	
           
            $this->db->where('vital_sign_id',$id);
            $this->db->delete('vital_sign');
           
            exit();
        }

        if($param1== 'patient_vital_signs')
        {
            $id = base64_decode($param2);	
           
            $this->db->where('vital_sign_id',$id);
            $this->db->delete('vital_sign');
           
            exit();
        }

        if($param1== 'patient_labs')
        {
            $id = base64_decode($param2);	
           
            $this->db->where('sample_id',$id);
            $this->db->update('sample',array('status'=>4));
           
            exit();
        }

        if($param1== 'patient_extras')
        {
            $id = base64_decode($param2);	
           
            $this->db->where('product_move_id',$id);
            $this->db->update('product_move',array('status'=>0));
           
            exit();
        }



    }
    
      function patients_insurance($param1 = '', $param2 = '')
    {
         $this->session_login();

        if($param1 == 'change_pass')
        {
            $this->accounts_model->update_patient_pass($param2);
            redirect(base_url() . 'admin/patient_security/'.base64_encode($param2), 'refresh');   
        }

        if($param1 == 'allergies')
        {
            $data['patient_id'] = $this->input->post('patient_id');
            $data['name'] = $this->input->post('name');
            $data['date'] = $this->crud_model->formatDate();
            return $this->db->insert('allergie', $data);
        }
        
        if($param1 == 'delete_allergie')
        {
            $patient_id = base64_encode($this->db->get_where('allergie', array('allergie_id'=>$param2))->row()->patient_id);
            $this->crud_model->delete_allergie($param2);
            $this->session->set_flashdata('flash_message' , "Alergia eliminada correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$patient_id.'/', 'refresh');
        }
        
        if($param1 == 'create_pathological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_pathological();
            $this->session->set_flashdata('flash_message' , "Antecedentes patológicos agregados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_pathological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_pathological($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes patológicos actualizados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_no_pathological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_no_pathological();
            $this->session->set_flashdata('flash_message' , "Antecedentes no patológicos agregados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_no_pathological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_no_pathological($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes no patológicos actualizados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_recordfamily')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_recordfamily();
            $this->session->set_flashdata('flash_message' , "Antecedentes heredofamiliares agregados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_recordfamily')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_recordfamily($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes heredofamiliares actualizados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
      
        if($param1 == 'create_psychiatric')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_psychiatric();
            $this->session->set_flashdata('flash_message' , "Antecedentes psiquiátricos agregados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_psychiatric')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_psychiatric($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes psiquiátricos actualizados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_vaccination')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_vaccination();
            $this->session->set_flashdata('flash_message' , "Esquema de vacunación agregado correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_vaccination')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_vaccination($param2);
            $this->session->set_flashdata('flash_message' , "Esquema de vacunación actualizado correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_nutriological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_nutriological();
            $this->session->set_flashdata('flash_message' , "Antecedentes nutriológicos agregados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_nutriological')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_nutriological($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes nutriológicos actualizados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_obstetric')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_obstetric();
            $this->session->set_flashdata('flash_message' , "Antecedentes gineco-obstétricos agregados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_obstetric')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_obstetric($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes gineco-obstétricos actualizados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_perinatal')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_perinatal();
            $this->session->set_flashdata('flash_message' , "Antecedentes perinatales agregados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_perinatal')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_perinatal($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes perinatales actualizados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create_postnatal')
        {
            $pat = base64_encode($param2);
            $this->crud_model->create_postnatal();
            $this->session->set_flashdata('flash_message' , "Antecedentes postnatales agregados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'update_postnatal')
        {
            $pat = base64_encode($param2);
            $this->crud_model->update_postnatal($param2);
            $this->session->set_flashdata('flash_message' , "Antecedentes postnatales actualizados correctamente.");
            redirect(base_url() . 'admin/medical_history/'.$pat.'/', 'refresh');
        }
        
        if($param1 == 'create')
        {
            $this->accounts_model->create_patient();
            $this->session->set_flashdata('flash_message' , "Paciente agregado correctamente.");
            redirect(base_url() . 'admin/patients/', 'refresh');
        }
        if($param1 == 'update')
        {
            $this->log_model->update_patient($param2);
            $this->accounts_model->update_patient($param2);
            $this->session->set_flashdata('flash_message' , "Paciente actualizado correctamente.");
           
            redirect(base_url() . 'admin/patient_profile/'.base64_encode($param2), 'refresh');
           
        }
        if($param1 == 'delete')
        {
            $this->log_model->delete_patient($param2);
            $this->accounts_model->delete_patient($param2,true);
            $this->session->set_flashdata('flash_message' , "Paciente eliminado correctamente.");
            redirect(base_url() . 'admin/patients/', 'refresh');
        }
        
         if($param1 == 'profile')
        {
            $page_data['id_']   = $param2;
        }
        
        
        $page_data['page_name']   = 'patients_insurance';
        $page_data['page_title']  = "Pacientes de aseguradoras";
        $this->load->view('backend/index', $page_data);
    }

    function patients_add($param1 ='' , $param2 ='' ){
         $this->session_login();
        $page_data['category']   = base64_decode($param1);
        $page_data['page_name']   = 'patients_add';
        $page_data['page_title']  = "Pacientes";
        $this->load->view('backend/index', $page_data);
    }

    function patients_edit($param1 ='' , $param2 ='' ){
         $this->session_login();

        $page_data['patient_id']   = $param1;
        $page_data['page_name']   = 'patients_edit';
        $page_data['page_title']  = "Editar información del pacientes";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function check_m()
    {
        
        
         $this->session_login();
        
        $response = $this->accounts_model->check_mail();
        
         header('Content-type: application/json; charset=utf-8');
         echo json_encode($response);
         exit();
    }

    function check_patient_exp()
    {
         $this->session_login();
        $response = $this->accounts_model->check_patient_nit();
         header('Content-type: application/json; charset=utf-8');
         echo json_encode($response);
         exit();
    }
    
    
    
    
    function doctors($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'doctor_auth_link'){
            $this->security_model->updateSecret(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "Autenticación activada correctamente.");
            redirect(base_url() . 'admin/doctor_security/'.base64_encode($param2), 'refresh');
        }
        if($param1 == 'remove_auth'){
            $this->security_model->remove_auth();
            $this->session->set_flashdata('flash_message' , "Autenticación desactivada correctamente.");
            redirect(base_url() . 'admin/my_security/', 'refresh');
        }
        
        if($param1 == 'remove_auth_doctor'){
            $this->security_model->remove_authDoctor($param2);
            $this->session->set_flashdata('flash_message' , "Autenticación desactivada correctamente.");
            redirect(base_url() . 'admin/doctor_security/'.base64_encode($param2), 'refresh');
        }
        
        if($param1 == 'create')
        {
            $this->accounts_model->create_doctor();
            $this->session->set_flashdata('flash_message' , "Doctor agregado correctamente.");
            redirect(base_url() . 'admin/doctors/', 'refresh');
        }
        if($param1 == 'new')
        {
            return $this->accounts_model->create_doctor();
        }
        if($param1 == 'update')
        {
            $this->accounts_model->update_doctor($param2);
            $this->session->set_flashdata('flash_message' , "Doctor actualizado correctamente.");
            redirect(base_url() . 'admin/doctors/', 'refresh');
        }
        if($param1 == 'edit')
        {
            return $this->accounts_model->edit_doctor($param2);
        }
        if($param1 == 'update_profile')
        {
            $this->accounts_model->update_doctor_profile($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'admin/my_profile/', 'refresh');
        }
        
        if($param1 == 'update_doctor_modules')
        {
            $this->accounts_model->update_doctor_modules($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'admin/doctor_permissions/'.base64_encode($param2).'/', 'refresh');
        }
        
        if($param1 == 'update_profile_modules')
        {
            $this->accounts_model->update_doctor_modules($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'admin/my_permissions/', 'refresh');
        }
        
        if($param1 == 'update_password')
        {
            $this->accounts_model->update_doctor_pass($param2);
        }
        
        if($param1 == 'update_password_profile')
        {
            $this->accounts_model->update_doctor_pass_profile($param2);  
        }
        
        if($param1 == 'delete')
        {
            $this->log_model->delete_doctor($param2);
            $this->accounts_model->delete_doctor($param2);
            $this->session->set_flashdata('flash_message' , "Doctor eliminado correctamente.");
            redirect(base_url() . 'admin/doctors/', 'refresh');
        }
        
        if($param1 == 'remove_sessions')
        {
            $this->security_model->remove_sessionsDoctor($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente, por favor inicie sesión nuevamente");
            redirect(base_url() . 'admin/my_security/', 'refresh');
        }
        
        if($param1 == 'remove_sessions_patient')
        {
            $this->security_model->remove_sessionsPa($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente");
            redirect(base_url() . 'admin/patient_security/'.base64_encode($param2), 'refresh');
        }
        
        
        if($param1 == 'remove_sessions_staff')
        {
            $this->security_model->remove_sessionsStaff($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente");
            redirect(base_url() . 'admin/staff_security/'.base64_encode($param2), 'refresh');
        }
        
        if($param1 == 'remove_sessions_doc')
        {
            $this->security_model->remove_sessionsDoctor($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente");
            redirect(base_url() . 'admin/doctor_security/'.base64_encode($param2).'/', 'refresh');
        }
        $page_data['doctors']     = $this->crud_model->getDoctors();
        $page_data['page_name']   = 'doctors';
        $page_data['page_title']  = "Doctores";
        $this->load->view('backend/index', $page_data);
    }


    function admins($param1 = '', $param2 = '')
    {
         $this->session_login();

        if($param1 == 'doctor_auth_link'){
            $this->security_model->updateSecret(base64_decode($param2));
            $this->session->set_flashdata('flash_message' , "Autenticación activada correctamente.");
            redirect(base_url() . 'admin/admin_security/'.base64_encode($param2), 'refresh');
        }

        if($param1 == 'remove_auth'){
            $this->security_model->remove_auth();
            $this->session->set_flashdata('flash_message' , "Autenticación desactivada correctamente.");
            redirect(base_url() . 'admin/my_security/', 'refresh');
        }
        
        if($param1 == 'remove_auth_doctor'){
            $this->security_model->remove_authDoctor($param2);
            $this->session->set_flashdata('flash_message' , "Autenticación desactivada correctamente.");
            redirect(base_url() . 'admin/admin_security/'.base64_encode($param2), 'refresh');
        }
        
        if($param1 == 'create')
        {
            $this->accounts_model->create_admin();
            $this->session->set_flashdata('flash_message' , "Doctor agregado correctamente.");
            redirect(base_url() . 'admin/doctors/', 'refresh');
        }
        if($param1 == 'new')
        {

            $this->session->set_flashdata('flash_message' , "Administrador agregado correctamente.");
            return $this->accounts_model->create_admin();
           
        }
        if($param1 == 'update')
        {
            $this->accounts_model->update_doctor($param2);
            $this->session->set_flashdata('flash_message' , "Doctor actualizado correctamente.");
            redirect(base_url() . 'admin/doctors/', 'refresh');
        }
        if ($param1 == 'edit') {
            return $this->accounts_model->edit_admin($param2);
        }
        if($param1 == 'update_profile')
        {
            $this->accounts_model->update_doctor_profile($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'admin/my_profile/', 'refresh');
        }
        
        if($param1 == 'update_doctor_modules')
        {
            $this->accounts_model->update_doctor_modules($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'admin/admin_permissions/'.base64_encode($param2).'/', 'refresh');
        }
        
        if($param1 == 'update_profile_modules')
        {
            $this->accounts_model->update_doctor_modules($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'admin/my_permissions/', 'refresh');
        }
        
        if($param1 == 'update_password')
        {
            $this->accounts_model->update_doctor_pass($param2);
        }
        
        if($param1 == 'update_password_profile')
        {
            $this->accounts_model->update_doctor_pass_profile($param2);  
        }
        
        if($param1 == 'delete')
        {
            $this->log_model->delete_doctor($param2);
            $this->accounts_model->delete_doctor($param2);
            $this->session->set_flashdata('flash_message' , "Administrador eliminado correctamente.");
            redirect(base_url() . 'admin/admins/', 'refresh');
        }

        if($param1 == 'delete_doctor')
        {
            $this->log_model->delete_doctor($param2);
            $this->accounts_model->delete_doctor($param2);
            $this->session->set_flashdata('flash_message' , "Doctor eliminado correctamente.");
            redirect(base_url() . 'admin/doctors/', 'refresh');
        }
        
        if($param1 == 'remove_sessions')
        {
            $this->security_model->remove_sessionsDoctor($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente, por favor inicie sesión nuevamente");
            redirect(base_url() . 'admin/my_security/', 'refresh');
        }
        
        if($param1 == 'remove_sessions_patient')
        {
            $this->security_model->remove_sessionsPa($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente");
            redirect(base_url() . 'admin/patient_security/'.base64_encode($param2), 'refresh');
        }
        
        
        if($param1 == 'remove_sessions_staff')
        {
            $this->security_model->remove_sessionsStaff($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente");
            redirect(base_url() . 'admin/staff_security/'.base64_encode($param2), 'refresh');
        }
        
        if($param1 == 'remove_sessions_doc')
        {
            $this->security_model->remove_sessionsDoctor($param2);
            $this->session->set_flashdata('flash_message' , "Sessiones eliminadas correctamente");
            redirect(base_url() . 'admin/doctor_security/'.base64_encode($param2).'/', 'refresh');
        }
        $page_data['doctors']      = $this->crud_model->getAdmins();
        $page_data['page_name']   = 'admins';
        $page_data['page_title']  = "Administradores";
        $this->load->view('backend/index', $page_data);
    }

    function new_admin($param1 = '',$param2 = '')
    {
         $this->session_login();
        
        $page_data['page_name']     = 'new_admin';
        $page_data['page_title']    = 'Nuevo administrador';
        $this->load->view('backend/index', $page_data);
    }

    function permission_request($param1 = '',$param2 = '')
    {
         $this->session_login();
        if($param1 == 'create'){

            if($this->session->userdata('login_type') != "doctor")
            $user_type = $this->session->userdata('login_type');
            else
            $user_type = 'admin';
            

            $data = array(
                'date_solicite' => $this->input->post('date'),
                'motive' => $this->input->post('motive'),
                'details' => $this->input->post('details'),
                'user_id' => $this->session->userdata('login_user_id'),
                'user_type' => $user_type,
                'status' => 0
            );

            $this->db->insert('permission_request',$data);
            $this->session->set_flashdata('flash_message' , "Solicitud de permiso agregada correctamente.");
            redirect(base_url() . 'admin/permission_request/', 'refresh');

        }

        if($param1 == 'aprove'){

            $data = array(
                'auth_date' => date('Y-m-d H:i:s'),
                'admin_id' => $this->session->userdata('login_user_id'),
                'status' => 1
            );

            $this->db->where('permission_request_id',$param2);
            $this->db->update('permission_request',$data);
            $this->session->set_flashdata('flash_message' , "Solicitud de permiso aprovada.");
            redirect(base_url() . 'admin/permission_request/', 'refresh');

        }

        if($param1 == 'reprove'){

            $data = array(
                'auth_date' => date('Y-m-d H:i:s'),
                'admin_id' => $this->session->userdata('login_user_id'),
                'status' => 2
            );

            $this->db->where('permission_request_id',$param2);
            $this->db->update('permission_request',$data);
            $this->session->set_flashdata('flash_message' , "Solicitud de permiso denegada.");
            redirect(base_url() . 'admin/permission_request/', 'refresh');

        }

        if($param1 == 'download')
        {
            $data = array(
                'permission_request_id' => $param2,
            );
            $this->pdf_model->pdf('Solicitud de permiso','permission_request.php',$data);
        }
        $page_data['page_name']     = 'permission_request';
        $page_data['page_title']    = 'Permisos';
        $this->load->view('backend/index', $page_data);
    }
    function permission_details($param1 = '',$param2 = '')
    {
         $this->session_login();
        
        $page_data['permission_request_id']     = $param1;
        $page_data['page_name']     = 'permission_details';
        $page_data['page_title']    = 'Solicitud de permiso';
        $this->load->view('backend/index', $page_data);
    }
    function new_permission_request($param1 = '',$param2 = '')
    {
         $this->session_login();
        
        $page_data['page_name']     = 'new_permission_request';
        $page_data['page_title']    = 'Nueva solicitud de permiso';
        $this->load->view('backend/index', $page_data);
    }
    

    function admin_profile($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'admin_profile';
        $page_data['page_title']    = "Perfil de Doctor";
        $this->load->view('backend/index', $page_data);
    }
    
    function doctor_profile($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_profile';
        $page_data['page_title']    = "Perfil de Doctor";
        $this->load->view('backend/index', $page_data);
    }
    
    function change($clinic_id = '')
    {
         $this->session_login();
        $set_id = base64_decode($clinic_id);
        $this->session->set_userdata('current_clinic', $set_id);
        redirect($this->agent->referrer(),'refresh' );
    }
    
    function filter($date = '')
    {
         $this->session_login();
        redirect(base_url() . 'admin/appointments/'.base64_encode($this->input->post('date')), 'refresh');
    }
    
    function staff($param1 = '', $param2 = '')
    {
         $this->session_login();
      
        if($param1 == 'new')
        {
            $this->accounts_model->new_staff();
            $this->session->set_flashdata('flash_message' , "Usuario agregado correctamente.");
            
            if($this->input->post('category') == 1)
            redirect(base_url() . 'admin/staff/', 'refresh');
            
            if($this->input->post('category') == 2)
            redirect(base_url() . 'admin/receptionist/', 'refresh');
            
            if($this->input->post('category') == 3)
            redirect(base_url() . 'admin/providers/', 'refresh');
            
            if($this->input->post('category') == 4)
            redirect(base_url() . 'admin/sellers/', 'refresh');
            
            if($this->input->post('category') == 5)
            redirect(base_url() . 'admin/accountants/', 'refresh');
            
        }
        if($param1 == 'update')
        {
            $this->accounts_model->update_staff($param2);
            $this->session->set_flashdata('flash_message' , "Datos de usuario actualizados correctamente.");
            redirect(base_url() . 'admin/staff_profile/'.base64_encode($param2), 'refresh');
        }
        if($param1 == 'edit')
        {
            return $this->accounts_model->edit_staff($param2);
        }
        if($param1 == 'update_staff_modules')
        {
            $this->accounts_model->update_staff_modules($param2);
            $this->session->set_flashdata('flash_message' , "Datos de usuario actualizados correctamente.");
            redirect(base_url() . 'admin/staff_permissions/'.base64_encode($param2).'/', 'refresh');
        }
        
        if($param1 == 'remove_auth_staff'){
            $this->security_model->remove_authStaff($param2);
            $this->session->set_flashdata('flash_message' , "Autenticación desactivada correctamente.");
            redirect(base_url() . 'admin/staff_security/'.base64_encode($param2), 'refresh');
        }
        if($param1 == 'update_password_staff')
        {
            $this->accounts_model->update_staff_pass_profile($param2);  
        }
        
        if($param1 == 'delete')
        {
           
            $this->accounts_model->delete_staff($param2);
            $this->session->set_flashdata('flash_message' , "Eliminado correctamente.");
    
            redirect($this->agent->referrer(), 'refresh');
        }
        $page_data['staff']       = $this->crud_model->getStaffList(1);
        $page_data['page_name']   = 'staff';
        $page_data['page_title']  = "Enfermeros";
        $this->load->view('backend/index', $page_data);
    }
    
    function deactivate_document($param1 = '') {
         $this->session_login();
        return $this->accounts_model->deactivateDocument($param1);
    }
    
    function receptionist($param1 = '', $param2 = '')
    {
         $this->session_login();
      
        $page_data['staff']       = $this->crud_model->getStaffList(2);
        $page_data['page_name']   = 'receptionist';
        $page_data['page_title']  = "Recepcionistas";
        $this->load->view('backend/index', $page_data);
    }
    
    function provider_new($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['type']        = $param1;
        $page_data['page_name']   = 'provider_new';
        $page_data['page_title']  = "Nuevo proveedor";
        $this->load->view('backend/index', $page_data);
    }
    
    function providers($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if ($param1 == 'new_single') {
            return $this->accounts_model->new_provider_single();
        }
        if ($param1 == 'new_legal') {
            return $this->accounts_model->new_provider_legal();
        }
        if ($param1 == 'edit_single') {
            return $this->accounts_model->edit_provider_single($param2);
        }
        if ($param1 == 'edit_legal') {
            return $this->accounts_model->edit_provider_legal($param2);
        }
        $page_data['staff']       = $this->crud_model->getStaffList(3);
        $page_data['page_name']   = 'providers';
        $page_data['page_title']  = "Proveedores";
        $this->load->view('backend/index', $page_data);
    }
    
    function sellers($param1 = '', $param2 = '')
    {
         $this->session_login();
      
        $page_data['staff']       = $this->crud_model->getStaffList(4);
        $page_data['page_name']   = 'sellers';
        $page_data['page_title']  = "Vendedores";
        $this->load->view('backend/index', $page_data);
    }
    
    function accountants($param1 = '', $param2 = '')
    {
         $this->session_login();
      
        $page_data['staff']       = $this->crud_model->getStaffList(5);
        $page_data['page_name']   = 'accountants';
        $page_data['page_title']  = "Contadores";
        $this->load->view('backend/index', $page_data);
    }
    
    function financial($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'invoice')
        {
            $file_name  = $this->db->get_where('financial', array('financial_id' => $param2))->row()->invoice_file;
            $info = file_get_contents("public/uploads/income_image/" . $file_name);
            force_download($file_name, $info);
        }
        if($param1 == 'reference')
        {
            $file_name  = $this->db->get_where('financial', array('financial_id' => $param2))->row()->reference_file;
            $info = file_get_contents("public/uploads/income_image/" . $file_name);
            force_download($file_name, $info);
        }
        if($param1 == 'create')
        {
            $this->crud_model->create_financial();
            
            $this->session->set_flashdata('flash_message' , "Datos agregados correctamente.");
            redirect(base_url() . 'admin/financial/', 'refresh');
        }
       if($param1 == 'update')
        {
            $this->crud_model->update_income($param2);
            $this->session->set_flashdata('flash_message' , "Datos actualizados correctamente.");
            redirect(base_url() . 'admin/financial/', 'refresh');
        }
        if($param1 == 'delete')
        {
            $this->crud_model->delete_income($param2);
            $this->session->set_flashdata('flash_message' , "Datos eliminados correctamente.");
            redirect(base_url() . 'admin/financial/', 'refresh');
        }
        
        if($this->input->post('filtro') == 1)
        {
            $ingreso_hoy = 1;
        }
        if($this->input->post('filtro') == 2)
        {
            $semana = 1;
        }
        if($this->input->post('filtro') == 3)
        {
            $dias = 1;
        }

        $page_data['page_name']   = 'financial';
        $page_data['page_title']  = "Financiero";
        $this->load->view('backend/index', $page_data);
    } 
    

    function reports($param1 = '', $param2 = '')
    {
         $this->session_login();
        if(!empty($this->input->post('user_type')))
        {
            $tipo = explode(",",$this->input->post('user_type'));
            $page_data['_id']         = $tipo[0];
            $page_data['type']        = $tipo[1];    
            $this->log_model->activity_report();
        }
        
        else{
            $page_data['_id'] = 0;
        }
        
        $page_data['page_name']   = 'reports';
        $page_data['page_title']  = "Reportes";
        $this->load->view('backend/index', $page_data);
    } 
    
    function appointment_reports($param1 = '', $param2 = '')
    {
        $this->session_login();
        if($this->input->post('doctor_id') != '')
        {
            $this->log_model->appointment_report();
        }

        if($this->input->post('doctor_id'))
            $page_data['doctor_id']    = $this->input->post('doctor_id');
        else
            $page_data['doctor_id']    = $this->session->userdata('login_user_id');

        
        $page_data['fecha1']    = $this->input->post('fecha1');
        $page_data['fecha2']    = $this->input->post('fecha2');
        
        
        $page_data['page_name']   = 'appointment_reports';
        $page_data['page_title']  = "Reporte de citas";
        $this->load->view('backend/index', $page_data);
    }
    
    function inventory_reports($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['fecha1']    = $this->input->post('fecha1');
        $page_data['fecha2']    = $this->input->post('fecha2');
        
        $page_data['page_name']   = 'inventory_reports';
        $page_data['page_title']  = "Reporte de inventario";
        $this->load->view('backend/index', $page_data);
    }
    
    function financial_reports($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($this->input->post('fecha1') != '')
        {
            $this->log_model->financial_report();
        }
        
        
        if($this->input->post('fecha1') == '' && $this->input->post('fecha2') == '' )
        {
            $anioActual = date("Y");
            $mesActual = date("m");
            $cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
            $fecha = $cantidadDias.'/'.$mesActual.'/'.$anioActual;
            $hoy = '01/'.$mesActual.'/'.$anioActual;
            
            $page_data['fecha1']      =  $hoy;
            $page_data['fecha2']      =  $fecha;
            
        }else
        {
            
        $page_data['fecha1']      = $this->input->post('fecha1');
        $page_data['fecha2']      = $this->input->post('fecha2');
        }
        
        

        $page_data['page_name']   = 'financial_reports';
        $page_data['page_title']  = "Reporte de finanzas";
        $this->load->view('backend/index', $page_data);
    }
    
    function settings($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'sessions')
        {
            $this->log_model->delete_session();
            $this->db->truncate('ci_sessions');    
            $this->session->set_flashdata('flash_message' , "Cambios aplicados correctamente.");
            redirect(base_url(), 'refresh');
        }
        if($param1 == 'apply')
        {
            $this->crud_model->update_settings();
            $this->session->set_flashdata('flash_message' , "Cambios aplicados correctamente.");
            redirect(base_url() . 'admin/settings/', 'refresh');
        }
        $page_data['page_name']   = 'settings';
        $page_data['page_title']  = "Configuración";
        $this->load->view('backend/index', $page_data);
    }
    

    function rooms($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'create')
        {
            $this->crud_model->create_room();
            $this->session->set_flashdata('flash_message' , "Habitación agregado correctamente.");
            redirect(base_url() . 'admin/rooms/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $this->crud_model->update_room($param2);
            $this->session->set_flashdata('flash_message' , "Habitación  actualizados correctamente.");
            redirect(base_url() . 'admin/rooms/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
        
            $this->crud_model->delete_room($param2);
            $this->session->set_flashdata('flash_message' , "Habitación  eliminados correctamente.");
            redirect(base_url() . 'admin/rooms/', 'refresh');
        }
        
        $page_data['page_name']   = 'rooms';
        $page_data['page_title']  = "Habitaciones";
        $this->load->view('backend/index', $page_data);
    }

    function surgery_room($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'create')
        {
            $this->crud_model->create_surgery_room();
            $this->session->set_flashdata('flash_message' , "Sala de cirigías agregado correctamente.");
            redirect(base_url() . 'admin/surgery_room/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $this->crud_model->update_surgery_room($param2);
            $this->session->set_flashdata('flash_message' , "Sala de cirigías actualizados correctamente.");
            redirect(base_url() . 'admin/surgery_room/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_surgery_room($param2);
            $this->session->set_flashdata('flash_message' , "Sala de cirigías eliminados correctamente.");
            redirect(base_url() . 'admin/surgery_room/', 'refresh');
        }
        
        $page_data['page_name']   = 'surgery_room';
        $page_data['page_title']  = "Sala de cirugías";
        $this->load->view('backend/index', $page_data);
    }


    function services($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'create')
        {
            $this->crud_model->create_service();
            $this->session->set_flashdata('flash_message' , "Servicio agregado correctamente.");
            redirect(base_url() . 'admin/services/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $this->crud_model->update_service($param2);
            $this->session->set_flashdata('flash_message' , "Servicios actualizados correctamente.");
            redirect(base_url() . 'admin/services/', 'refresh');
        }
        
          if($param1 == 'delete')
        {
            $this->log_model->delete_service($param2);
            $this->crud_model->delete_service($param2);
            $this->session->set_flashdata('flash_message' , "Servicios eliminados correctamente.");
            redirect(base_url() . 'admin/services/', 'refresh');
        }
        
        $page_data['page_name']   = 'services';
        $page_data['page_title']  = "Servicios";
        $this->load->view('backend/index', $page_data);
    }
    
    function profile($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['page_name']   = 'profile';
        $page_data['page_title']  = "Perfil";
        $this->load->view('backend/index', $page_data);
    }
    
    function calendar($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['page_name']   = 'calendar';
        $page_data['page_title']  = "Calendario de citas";
        $this->load->view('backend/index', $page_data);
    }
    

    function patient_profile($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_profile';
        $page_data['page_title']  = "Perfil del Paciente ";
        $this->load->view('backend/index', $page_data);
    }
    
    function treatment($param1 = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        
        $this->session_login();
        if ( $odonto == "")
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'treatment';
        $page_data['page_title']  = "Planes de tratamiento";
        $this->load->view('backend/index', $page_data);
    }
    
    function treatment_details($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'treatment_details';
        $page_data['page_title']  = "Plan de tratamiento";
        $this->load->view('backend/index', $page_data);
    }
    
    function add_tooth()
    {
        $this->session_login();
        $checked = $this->input->post('process');
        $total_checked_values = count($checked);
        $permissions = '';
        for ($i = 0; $i < $total_checked_values; $i++) 
        {
            $data['odonto_treatment_id']  = $this->input->post('treatment_id');
            $data['tooth_id']             = $this->input->post('tooth_id');
            $data['date']                 = $this->crud_model->formatDate();
            $data['comment']              = $this->input->post('commentary');
            $data['process']              = $checked[$i];
            $data['status']               = 0;
            $this->db->insert('tooth_treatment', $data);
        }
        $this->session->set_flashdata('flash_message' , "Servicio agregado correctamente.");
        redirect(base_url() . 'admin/treatment_details/'.base64_encode($this->input->post('treatment_id')), 'refresh');
    }
    
    
    
    function update_treatment($param1 = '', $param2 = '', $param3 = '')
    {
         $this->session_login();
        
        if($param1 == 'add_pay_credit')
        {
            $this->crud_model->insert_pay_credit();
            $this->session->set_flashdata('flash_message' , "Abono agregado correctamente.");
            redirect(base_url() . 'admin/treatment_details/'.base64_encode($this->input->post('treatment_id')), 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_pay_credit($param2);
            return true;
        }
        
        if($param1 == 'close_treatment')
        {
            $data['status']             = 2;
            $this->db->where('treatment_id', $param2);
            $this->db->update('odonto_treatment', $data);
            
            $data22['status']             = 4;
            $this->db->where('treatment_id', $param2);
            $this->db->update('appointment', $data22);
            
            $this->session->set_flashdata('flash_message' , "Se ha finalizado el tratamiento correctamente.");
            redirect(base_url() . 'admin/treatment/'.base64_encode($param3), 'refresh');
        }
        
        if($param1 == 'end_appointment')
        {
            $data22['status']             = 4;
            $this->db->where('treatment_id', $param2);
            $this->db->update('appointment', $data22);
            $this->session->set_flashdata('flash_message' , "Se ha marcado como finalizada la cita.");
            redirect(base_url() . 'admin/treatment/'.base64_encode($param3), 'refresh');
            
        }
        
        if($param1 == 'not_consult')
        {
            $data33['practice']             = '';
            $this->db->where('appointment_id', $param2);
            $this->db->update('appointment', $data33);
            redirect(base_url() . 'admin/treatment_details/'.base64_encode($param3), 'refresh');
        }
        
        if($param1 == 'add_consult')
        {
            $data33['practice']             = 23;
            $this->db->where('appointment_id', $param2);
            $this->db->update('appointment', $data33);
            redirect(base_url() . 'admin/treatment_details/'.base64_encode($param3), 'refresh');
        }
        
        else
        {
            if($this->input->post('discount') <= $this->input->post('saldo_final'))
            {
                $data['discount']                   = $this->input->post('discount');
                $data['commentary_priv']            = $this->input->post('commentary2');
                $this->db->where('treatment_id', $this->input->post('treatment_id'));
                $this->db->update('odonto_treatment', $data);
                
                $data22['doctor_comment']           = $this->input->post('commentary');
                $this->db->where('appointment_id', $this->input->post('appointment_id'));
                $this->db->update('appointment', $data22);
                
                $this->session->set_flashdata('flash_message' , "Cambios agregados correctamente.");
                redirect(base_url() . 'admin/treatment_details/'.base64_encode($this->input->post('treatment_id')), 'refresh');
            }
            else
            {
                $this->session->set_flashdata('error_message' , "El descuento no puede ser mayor al saldo restante");
                redirect(base_url() . 'admin/treatment_details/'.base64_encode($this->input->post('treatment_id')), 'refresh');
            }
        }
        
    }
    
    
    function staff_profile($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'staff_profile';
        $page_data['page_title']  = "Perfil del Usuario ";
        $this->load->view('backend/index', $page_data);
    }
    
    function provider_profile($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'provider_profile';
        $page_data['page_title']  = "Perfil del Provider";
        $this->load->view('backend/index', $page_data);
    }
    
    function staff_new($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['type']        = $param1;
        $page_data['page_name']   = 'staff_new';
        $page_data['page_title']  = "Nuevo usuario";
        $this->load->view('backend/index', $page_data);
    }
    
    function medical_history($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'medical_history';
        $page_data['page_title']  = "Historial médico";
        $this->load->view('backend/index', $page_data);
    }

        function patient_history($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_history';
        $page_data['page_title']  = "Historial del paciente";
        $this->load->view('backend/index', $page_data);
    }
    
    
    /*
    function get_weight()
    {
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        $patient_id = $_GET['id'];
        
        $result = '{
            "labels": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            "data": {
                "quantity": ['.$this->results($patient_id,'01',date('Y')).','.$this->results($patient_id,'02',date('Y')).', '.$this->results($patient_id,'03',date('Y')).', '.$this->results($patient_id,'04',date('Y')).', '.$this->results($patient_id,'05',date('Y')).', '.$this->results($patient_id,'06',date('Y')).', '.$this->results($patient_id,'07',date('Y')).', '.$this->results($patient_id,'08',date('Y')).', '.$this->results($patient_id,'09',date('Y')).', '.$this->results($patient_id,'10',date('Y')).', '.$this->results($patient_id,'11',date('Y')).', '.$this->results($patient_id,'12',date('Y')).']
            }
        }';
        echo $result;
    }
    */
    

        function setFormat($fecha)
    {
        $date = explode("/", $fecha);
        $dia  = $date[1];
        $mes  = $date[0];
        $anio = $date[2];
        $string_month = "";
        $string_day   = "";
        
        if($mes <= 9){
            $string_month = str_replace("0","",$mes);
        }else{
            $string_month = $mes;
        }
        if($dia <= 9){
            $string_day = $dia;
        }else{
            $string_day = $dia;
        }
        
        return $string_day."/".$string_month.'/'.$anio;
    }
    
    function medical_prescriptions($param1 = '', $param2 = '')
    {
         $this->session_login();
       
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
                    redirect(base_url() . 'admin/appointments/', 'refresh');
                }else
                {
                    $this->session->set_flashdata('flash_message' , "Cita confirmada correctamente.");
                    redirect(base_url() . 'admin/appointments/', 'refresh');
                }
            }
            
            unlink($pdfFilePath);

        }

       

        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'medical_prescriptions';
        $page_data['page_title']  = "Recetas";
        $this->load->view('backend/index', $page_data);
    }
    
    function getSugest()
    {
      
        $name = $this->input->post('name');
        if($name == "")
        {
            $this->db->limit(1);
        }
        $this->db->limit(10);
       
        $sugest = $this->db->like('name', $name)->get('medicine_sugest')->result_array();
        
            foreach ($sugest as $row) {
                $html .='<tr class="resultado ">
                    <td>
                        <a href="javascript:;"  onclick="selectMedicine('.$row['medicine_sugest_id'].',\''.base64_encode($row['name']).'\')" > '.$row['name'].' </a>
                    </td>
                    <td><i style="color:#fd4f57;font-weight:bold;" onClick="deleteSugest('.$row['medicine_sugest_id'].','.$app.')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>
                </tr>';
            }
         
       
        
        echo $html;
        exit();
    }
    
    function patient_security($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_security';
        $page_data['page_title']  = "Seguridad";
        $this->load->view('backend/index', $page_data);
    }
    
    function refresh_patient_files($patient_id)
    {
        $refresh_query  = $this->db->get_where('patient_file',array('patient_id' => $patient_id));
        if($refresh_query->num_rows() > 0)
        {
		    foreach($refresh_query->result_array() as $row)
		    {

               /*
		        $html_table .= '
    		        <div class="col-sm-6">
    				    <a target="_blanck" href="'.base_url().'public/uploads/patient_files/'.$row['name'].'" class="v-project-files">
							<img src="'.$this->crud_model->get_format($row['format']).'" style="max-width:35px">
    					    <p class="v-project-files-name" data-toggle="tooltip" data-placement="top" title="'.$row['old_name'].'">'.substr($row['old_name'],0,30).' <span>'.$row['size'].' <object style="z-index:999"><a style="text-decoration:none;" href="javascript:void(0);" onclick="confirm_delete('."'".$row['name']."'"."".')"><i style="font-size:16px;font-weight:bold;color:#fd4f57" class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a></object></span> </p>
						</a>
				    </div>';  */ 



                   $html_table = '
                   <div class="col-sm-6">
                   <div class="support-ticket">
                       <a href="javascript:void(0);" style="text-decoration:none;color:#556180" onclick="showSharedFiles(1)">
                           <div class="st-body">
                               <div class="avatar">
                                   <img src="https://guateapps.app/rocket/public/uploads/98864e6d123df51d90cd3d560b44ce32folder.svg" style="max-width:30px">
                               </div>
                               <div class="ticket-content">
                                   <div class="ticket-description">
                                       <div class="os-progress-bar primary">
                                           <div class="bar-labels">
                                               <div class="bar-label-left">
                                                   <span class="bigger">Shared with me</span>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </a>
                   </div>
             
              '; 
		    }





            echo $html_table;
        }else{
            echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay archivos subidos</h5><br><img src="'.base_url().'public/uploads/archivos_compartidos.svg" style="max-width:20%;"></center></div>';
        }
    }
    
    function patient_files($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'download'){
            $patient_id = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->patient_id;
            $this->log_model->download_file($patient_id);
            $file_name  = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->name;
            $old_name  = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->old_name;
            $info = file_get_contents("public/uploads/patient_files/" . $file_name);
            force_download($old_name, $info);
        }
        if($param1 == 'delete')
        {
            $patient_id = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->patient_id;   
            $file_name  = $this->db->get_where('patient_file', array('patient_file_id' => $param2))->row()->name; 
            $this->db->where('patient_file_id', $param2);
            $this->db->delete('patient_file');
            unlink("public/uploads/patient_files/" . $file_name);
            $this->session->set_flashdata('flash_message' , "Archivo eliminado correctamente.");
            redirect(base_url() . 'admin/patient_files/'.base64_encode($patient_id), 'refresh');
        }
        if($param1 == 'ajax_upload'){

            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            
            $this->log_model->file_uploaded($_GET['patient_id']);
            
            include('public/apis/class.fileuploader.php');
            $FileUploader = new FileUploader('files', array(
                'uploadDir' => './public/uploads/patient_files/',
                'replace' => true,
            ));
            $data = $FileUploader->upload();
            
            $insert_data['patient_id']      = $_GET['patient_id']; 
            $insert_data['name']            = $data['files'][0]['name'];
            $insert_data['format']          = $data['files'][0]['extension'];
            $insert_data['size']            = $data['files'][0]['size2'];
            $insert_data['old_name']        = $data['files'][0]['old_name'];
            $insert_data['date']            = $this->crud_model->formatDate();
            $this->db->insert('patient_file', $insert_data);



	        echo json_encode($data);
	        exit;
        }

        $patient_folder = $this->db->get_where('patient',array('patient_id'=>base64_decode($param1)))->row()->folder;
        $have_folder = $this->db->get_where('settings',array('type'=>'folderId'))->row()->description;


        if($param1 == 'create_folder')
        {

            $data['name'] = $this->input->post('name');
            $data['patient_id'] =  $this->input->post('patient_id');
            $data['parent_id'] =  $this->input->post('parent_id');
            $data['date'] = $this->crud_model->formatDate();
            $data['type'] = 0;
            $data['status'] = 1;
            
            $this->db->insert('patient_file',$data);
             exit();
        }

        if($param1 == 'upload_files')
        {


            $uploads_dir = 'public/uploads/patient_files/';
            $files_array = $_FILES['files'];
       
            
            foreach ($files_array['name'] as $index => $filename) {
             
            $name = $files_array['name'][$index];
            $tmp_name = $files_array['tmp_name'][$index];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $size = filesize($tmp_name);
            $new_name = uniqid().'.'.$ext;
            move_uploaded_file($tmp_name, $uploads_dir.$new_name);

            $data['old_name'] = $name;
            $data['patient_id'] =  $this->input->post('patient_id');
            $data['parent_id'] =  $this->input->post('parent_id');
            $data['date'] = $this->crud_model->formatDate();
            $data['type'] = 1;
            $data['status'] = 1;
            $data['name'] = $new_name;
            $data['size'] = $size;
            $data['format'] = $ext;
            
            $this->db->insert('patient_file',$data);
              
            }

            exit();
        
        }


        if($param1 == 'edit_folder')
        {

            $data['name'] = $this->input->post('name');
            $this->db->where('patient_file_id', $this->input->post('patient_file_id'));
            $this->db->update('patient_file',$data);
        
        }

        if($param1 == 'delete_files')
        {
            $data['status'] = 0;
            $this->db->where('patient_file_id',base64_decode($param2));
            $this->db->update('patient_file',$data);
            
            $data['status'] = 0;
            $this->db->where('parent_id',base64_decode($param2));
            $this->db->update('patient_file',$data);
        }


        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_files';
        $page_data['page_title']  = "Archivos del Paciente";
        $this->load->view('backend/index', $page_data);
    }
    
    function patient_appointments($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_appointments';
        $page_data['page_title']  = "Citas del Paciente";
        $this->load->view('backend/index', $page_data);
    }
    
    function patient_app()
    {
        $id= $this->input->post('id'); 
        $cl= $this->input->post('cl'); 
       
        $app = $this->db->get_where('vital_sign',array('vital_sign_id'=>$id))->num_rows();

      
        if($app > 0)
        {
            $data[$cl] = $this->input->post('value');
            $data['user_id'] = $this->session->userdata('login_user_id');
            $data['user_type'] = $this->session->userdata('login_type');
            $data['user_id'] = $this->session->userdata('login_user_id');
            $data['date'] = date('Y-m-d H:i');
            $this->db->where("vital_sign_id",$id);
            $this->db->update("vital_sign",$data);
        }else
        {

            $data[$cl] = $this->input->post('value');
            $data['user_id'] = $this->session->userdata('login_user_id');
            $data['user_type'] = $this->session->userdata('login_type');
            $data['patient_id'] = $this->input->post('patient_id');;
            $this->db->insert("vital_sign",$data);

        }
       
    }

    
    function patient_financial($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'email')
        {
            $data = array(
                'income_id' => $param2
            );
            $hoy = date('d-m-Y_h:i:s');
            $html = $this->load->view('backend/generate_invoice.php',$data,TRUE); 
            $pdfFilePath = "recibo_Medicaby-".$hoy.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $patient_id = $this->db->get_where('financial', array('financial_id' => $param2))->row()->patient_id;
            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;
            $patient_name = $this->accounts_model->short_name('patient',$patient_id);
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->AddAttachment('public/uploads/'.$pdfFilePath,$pdfFilePath);   
            $mail->SetFrom('no-reply@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = 'Recibo electrónico - Medicaby';
            $data = array(
                'patient_name' => $patient_name,
                'patient_id' => $patient_id,
            );
            $mail->Body = $this->load->view('backend/mails/invoice.php',$data,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");

        }
        if($param1 == 'pdf')
        {
            $data = array(
                'income_id' => $param2
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
        $page_data['id_'] = $param1;
        $page_data['page_name']   = 'patient_financial';
        $page_data['page_title']  = "Financiero";
        $this->load->view('backend/index', $page_data);
    }
    
    function specialties($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'create')
        {
            $this->crud_model->create_specialtie();
            $this->session->set_flashdata('flash_message' , "Especialidad agregada correctamente.");
            redirect(base_url() . 'admin/specialties/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $this->crud_model->update_specialtie($param2);
            $this->session->set_flashdata('flash_message' , "Especialidad actualizada correctamente.");
            redirect(base_url() . 'admin/specialties/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_specialtie($param2);
            $this->session->set_flashdata('flash_message' , "Especialidad eliminada correctamente.");
            redirect(base_url() . 'admin/specialties/', 'refresh');
        }
        $page_data['page_name']   = 'specialties';
        $page_data['page_title']  = "Especialidades";
        $this->load->view('backend/index', $page_data);
    }


    function insurance($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'create')
        {
            $this->crud_model->create_insurance();
            $this->session->set_flashdata('flash_message' , "Aseguradora agregada correctamente.");

           redirect($this->agent->referrer(), 'refresh');
        }
        
        if($param1 == 'update')
        {
            $this->crud_model->update_insurance($param2);
            $this->session->set_flashdata('flash_message' , "Aseguradora actualizada correctamente.");
            redirect($this->agent->referrer(), 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_insurance($param2);
            $this->session->set_flashdata('flash_message' , "Aseguradora eliminada correctamente.");
            redirect($this->agent->referrer(), 'refresh');
        }
        $page_data['page_name']   = 'insurance';
        $page_data['page_title']  = "Aseguradoras";
        $this->load->view('backend/index', $page_data);
    }
    
      /* Funcion de laboratorios */
   function laboratory($param1 = '', $param2 = '')
   {
    $this->session_login();

       if($param1 == "create")
       {
           $response = $this->crud_model->create_laboratory();
           
           if($response == 1)
           {
               redirect(base_url().'admin/laboratory/', 'refresh'); 
           }
       }
       if($param1 == "update")
       {
       
           $response =  $this->crud_model->update_laboratory($param2);
           
           if($response == 1)
           {
               redirect(base_url().'admin/laboratory/', 'refresh'); 
           }
           
       }
       if($param1 == "delete")
       {
       
           $response =  $this->crud_model->delete_laboratory($param2);
           
           if($response == 1)
           {
               redirect(base_url().'admin/laboratory/', 'refresh'); 
           }
       }

       if($param1 == 'read'){
           $this->crud_model->read_notificacion($param2);
       }

       $page_data['page_name']  = 'laboratory';
       $page_data['page_title'] = "Laboratorios";
       $this->load->view('backend/index', $page_data);
   }

         
    public function laboratory_template($param1 = '', $param2 = '')
    {
        $this->session_login();

        if ($param1 == 'create') {
            $this->crud_model->create_laboratory_field();
            $this->session->set_flashdata('flash_message', get_phrase('information_added_successfully'));
            redirect(base_url() . 'super/laboratories/', 'refresh');
        }
        if ($param1 == 'update') {
            $template = $this->db->get_where('laboratory_template', array('laboratory_id'=>$param2))->num_rows();

            $fields = $this->input->post('fields');
            $results = array();
            $total = 0;
            foreach ($fields as $field) {
                $total +=  $this->input->post('price_'.$input);
                $replace = array(".", " ");
                $input = str_replace($replace, "_", $field);
                $result = array('name'=> $field,'value'=>$this->input->post($input),'label'=>$this->input->post('name_'.$input),'unity'=>$this->input->post('unity_'.$input),'size'=>$this->input->post('size_'.$input),'price'=>$this->input->post('price_'.$input),'type'=>$this->input->post('type_'.$input));
                array_push($results, $result);
            }

           

            if ($template == 0) {
                $data['laboratory_id'] = $param2;
                $data['form'] = json_encode($results);

                $this->db->insert('laboratory_template', $data);

                $this->session->set_flashdata('flash_message', get_phrase('information_updated_successfully'));
                $refer =  $this->agent->referrer();
                redirect($refer, 'refresh');
            } else {
                $data['form'] = json_encode($results);

                $this->db->where('laboratory_id', $param2);
                $this->db->update('laboratory_template', $data);


                $this->session->set_flashdata('flash_message', get_phrase('information_updated_successfully'));
                $refer =  $this->agent->referrer();
                redirect($refer, 'refresh');
            }
        }
        $page_data['laboratory_id']   = $param1;
        $page_data['page_name']   = 'laboratory_template';
        $page_data['page_title']  = get_phrase('laboratory_template');
        $this->load->view('backend/index', $page_data);
    }

    
    public function laboratory_fields($param1 = "")
    {

        if($param1 == "add")
        {
            $data['laboratory_id'] = $this->input->post('laboratory_id');
            $data['laboratory_fields_id'] = $this->input->post('laboratory_fields_id');
            
            $this->db->insert('laboratory_template',$data);
            
            exit();
            
        }


        if($param1 == "new_field")
        {
            $data['laboratory_id'] = $this->input->post('laboratory_id');
            $data['name'] = $this->input->post('name');
            $data['unity'] = $this->input->post('unity');
            $data['reference'] = $this->input->post('reference');
            $data['price'] = $this->input->post('price');
            $data['price_esp'] = $this->input->post('price_esp');
            
            $this->db->insert('laboratory_fields',$data);

            $datae['laboratory_id'] = $this->input->post('laboratory_id');
            $datae['laboratory_fields_id'] = $this->db->insert_id();
            
            $this->db->insert('laboratory_template',$datae);
            
            exit();
            
        }
        
        if($param1 == "edit")
        {
            $data['name'] = $this->input->post('name');
            $data['unity'] = $this->input->post('unity');
            $data['reference'] = $this->input->post('reference');
            $data['price'] = $this->input->post('price');
            $data['price_esp'] = $this->input->post('price_esp');
            $this->db->where('laboratory_fields_id',$this->input->post('field_id'));
            $this->db->update('laboratory_fields',$data);
            
            exit();
            
        }
        
        if($param1 == "delete")
        {
            $data['status'] = 0;
           
            $this->db->where('laboratory_fields_id',$this->input->post('field_id'));
            $this->db->update('laboratory_fields',$data);
            
            $data['status'] = 0;
           
            $this->db->where('laboratory_fields_id',$this->input->post('field_id'));
            $this->db->update('laboratory_template',$data);
            
            exit();
            
        }

        if($param1 == "delete_field")
        {
            $data['status'] = 0;
           
            $this->db->where('laboratory_template_id',$this->input->post('laboratory_template_id'));
            $this->db->update('laboratory_template',$data);
            
            exit();
            
        }
       
        
    }
    
  
  function laboratory_results($param1 = '', $param2 = '')
  {
     
      if($param1 == "save")
      {
       
            $cont = 0;
           
            $laboratories = $this->db->group_by('laboratory_id')->get_where('sample_piece',array('sample_id'=>base64_decode($this->input->post('sample_id'))))->result_array(); 
                        
            foreach($laboratories as $exm)
            {
                $exmans = $this->db->get_where('sample_piece',array('sample_id'=>base64_decode($this->input->post('sample_id')),'laboratory_id'=>$exm['laboratory_id']))->result_array(); 
              
                foreach($exmans as $laboratory)
                {
                    $result = array();
                    $fields = $this->db->query("SELECT * FROM `laboratory_template` WHERE laboratory_id = ".$laboratory['exams']." AND status = 1")->result_array();
                    foreach($fields as $field_detail)
                    {
                        array_push($result,array($field_detail['laboratory_fields_id']=>$this->input->post($field_detail['laboratory_fields_id'].'_'.$cont++)));
                    }
                    
                    $data['results'] = json_encode($result);
                    $this->db->where('sample_piece_id',$laboratory['sample_piece_id']);
                    $this->db->update('sample_piece',$data);
                    
                    $sample_id = $laboratory['sample_id'];

                }
            }
            
            $dataS['status'] = 1;
            $this->db->where('sample_id',$sample_id);
            $this->db->update('sample',$dataS);
        
            $this->session->set_flashdata('success_message' , "Resultados Guardados");  
            redirect(base_url().'admin/samples/' , 'refresh');
            
      }
      
       if($param1 == 'download') 
       {
            $page_data['sample_id'] = $param2;
            $html = $this->load->view('backend/pdf/laboratory_result.php', $page_data, true);
            // Get output html

            $sample= $this->db->get_where('sample',array('sample_id'=>base64_decode($param2)))->row();
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'letter');
            $mpdf->WriteHTML($html, 0);
            $mpdf->Output('laboratorios-'.$sample->patient_name.'-'.$sample->study.'.pdf', "I");
        }

        
       if($param1 == 'print') 
       {
            $page_data['sample_id'] = $param2;
            $html = $this->load->view('backend/pdf/laboratory_result_print.php', $page_data, true);
            // Get output html

            $sample= $this->db->get_where('sample',array('sample_id'=>base64_decode($param2)))->row();
            $this->load->library('M_pdf');
            $mpdf = new mPDF('utf-8', 'letter');
            $mpdf->WriteHTML($html, 0);
            $mpdf->Output('laboratorios-'.$sample->patient_name.'-'.$sample->study.'.pdf', "I");
        }
      
      $page_data['ID'] = $param1;
      $page_data['page_name']  = 'laboratory_results';
      $page_data['page_title'] = "Resultados";
      $this->load->view('backend/index', $page_data);
  }
  ///////////////////////////////
    function rayx($param1 = '', $param2 = '', $param3 = '')
        {
            $this->session_login();

            if($param1 == "create")
            {
                $response =  $this->crud_services->create_service();
                
                echo $response;
                exit();
            
            }

            if($param1 == "edit")
            {
                $response =  $this->crud_services->create_rayx($param2);
                
                if($response == 1)
                {
                    redirect(base_url().'admin/samples/'.base64_encode($this->input->post('category_id')), 'refresh');
                }
            
            }


            if($param1 == "delete")
            {
            
                $response =  $this->crud_samples->delete_samples($param2);
                
                if($response == 1)
                {
                    exit();
                }
                
            }
            
             if($param1 == 'get'){
                echo $this->crud_samples->getSamples();
                exit();
            }

            if($param1 == 'get_service'){
                echo $this->crud_services->get_services_appointment($param2,1);
                exit();
            }
            
            
             if($param1 == "pay_exam")
            {
                
                $this->db->where('patient_service_id',$param2);
                $this->db->update('patient_service',array('status'=>1));
                exit();
                
            }
            
            if($param1 == 'getPrintDelivery'){
                echo $this->crud_samples->getSamplesDelivery();
                exit();
            }
                 
             
            if($param1 == 'upload_report'){
                $this->crud_samples->upload_report($param2);
                echo 'success';
           }
            $page_data['category_id']  = $param1;
            $page_data['page_name']  = 'rayx';
            $page_data['page_title'] = "Recepción de ordenes de Rayos X";
            $this->load->view('backend/index', $page_data);
        }
        
        
        
            function ultras($param1 = '', $param2 = '', $param3 = '')
        {
            $this->session_login();

            if($param1 == "create")
            {
                $response =  $this->crud_services->create_service();
                
                echo $response;
                exit();
            
            }

            if($param1 == "edit")
            {
                $response =  $this->crud_services->create_rayx($param2);
                
                if($response == 1)
                {
                    redirect(base_url().'admin/samples/'.base64_encode($this->input->post('category_id')), 'refresh');
                }
            
            }


            if($param1 == "delete")
            {
            
                $response =  $this->crud_samples->delete_samples($param2);
                
                if($response == 1)
                {
                    exit();
                }
                
            }
            
             if($param1 == 'get'){
                echo $this->crud_samples->getSamples();
                exit();
            }

            if($param1 == 'get_service'){
                echo $this->crud_services->get_services_appointment($param2,1);
                exit();
            }
            
            
             if($param1 == "pay_exam")
            {
                
                $this->db->where('patient_service_id',$param2);
                $this->db->update('patient_service',array('status'=>1));
                exit();
                
            }
            
            if($param1 == 'getPrintDelivery'){
                echo $this->crud_samples->getSamplesDelivery();
                exit();
            }
                 
             
            if($param1 == 'upload_report'){
                $this->crud_samples->upload_report($param2);
                echo 'success';
           }
            $page_data['category_id']  = $param1;
            $page_data['page_name']  = 'ultras';
            $page_data['page_title'] = "Recepción de ordenes de Ultrasonidos";
            $this->load->view('backend/index', $page_data);
        }
        
        
  ////////////////////////////////

        function samples($param1 = '', $param2 = '', $param3 = '')
        {
            $this->session_login();

            if($param1 == "create")
            {
                $response =  $this->crud_samples->create_samples();
                
                echo $response;
                exit();
            
            }

            if($param1 == "edit")
            {
                $response =  $this->crud_samples->update_samples($param2);
                
                if($response == 1)
                {
                    redirect(base_url().'admin/samples/'.base64_encode($this->input->post('category_id')), 'refresh');
                }
            
            }
            
            if($param1 == "pay")
            {
            
                $response =  $this->crud_samples->pay_samples($param2);
                
                if($response == 1)
                {
                    redirect(base_url().'admin/samples/'.base64_encode($this->input->post('category_id')), 'refresh');
                }
                
            }

            if($param1 == "pay_exam")
            {
                
                $this->db->where('sample_piece_id',$param2);
                $this->db->update('sample_piece',array('status'=>1));
                exit();
                
            }

            if($param1 == "pay_credit_group")
            {
            
                $response =  $this->crud_samples->pay_credit_group();
                
                $refer =  $this->agent->referrer();
                redirect($refer, 'refresh');
                
            }



            if($param1 == "delete")
            {
            
                $response =  $this->crud_samples->delete_samples($param2);
                
                if($response == 1)
                {
                    exit();
                }
                
            }

            if($param1 == 'get'){
                echo $this->crud_samples->getSamples();
                exit();
            }
            
            if($param2 == 'read'){
                $this->crud_model->read_notificacion($param3);
            }

            if($param1 == "group")
            {
                $this->crud_samples->create_samples_group(); 
                exit();
            }
            
            if($param1 == ''){
                $param1 = base64_encode(1);
            }

            if($param1 == "delivery")
            {
                $response = $this->crud_samples->delivery($param2); 
                if($response == 1)
                {
                    redirect(base_url().'admin/samples/'.base64_encode(1), 'refresh');
                }
            }

       
            
            
            if($param1 == 'getPrintDelivery'){
                echo $this->crud_samples->getSamplesDelivery();
                exit();
            }
                 
             
            if($param1 == 'upload_report'){
                $this->crud_samples->upload_report($param2);
                echo 'success';
           }
            $page_data['category_id']  = $param1;
            $page_data['page_name']  = 'samples';
            $page_data['page_title'] = "Recepción de muestras";
            $this->load->view('backend/index', $page_data);
        }

        function samples_edit($param1 = '', $param2 = '')
        {
            $this->session_login();
            $page_data['ID'] = $param1;
            $page_data['page_name']   = 'samples_edit';
            $page_data['page_title']  = "Edicion de muestra";
            $this->load->view('backend/index', $page_data);
        }

        function samples_new($param1 = '', $param2 = '')
        {
            $this->session_login();
            $page_data['category_id']  = $param1;
            $page_data['page_name']  = 'samples_new';
            $page_data['page_title'] = "Recepción de muestras";
            $this->load->view('backend/index', $page_data);
        }

        function labStatus($appointment_id)
        {
             $labs = $this->db->get_where('sample',array('appointment_id'=>$appointment_id))->result_array(); $cont =1;
             $html = '';          
             if(count($labs) > 0 ){
         $html = '<hr>
            <h4>Laboratorios</h4>
            <div class="row">
                <table class="table">
                    <tr style="background-color:#f9fbfc; color:#59636d">
                        <th>#</th>
                        <th>Especialista</th>
                        <th>Código</th>
                        <th>Exámen</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                     ';
                        foreach($labs as $sm): 
                           $exams = $this->db->get_where('sample_piece',array('sample_id'=> $sm['sample_id']))->result_array();
                           foreach($exams as $row): 
                    
              $html .='<tr>
                        <td>
                             '. $cont++.'
                        </td>
                        <td>
                            <img src=" '. $this->accounts_model->get_photo('admin', $sm['user_id']).'" width="35px" style="padding-right:6px">
                             '. $this->accounts_model->gender($sm['user_id']).'
                             '. $this->accounts_model->short_name('admin', $sm['user_id']).'
                        </td>
                        <td>
                             '. $row['code'].'
                        </td>
                        <td>
                             '. $this->db->get_where('product',array('product_id'=>$row['laboratory_id']))->row()->name.'
                        </td>
                        <td> Q.'. $row['price'].'</td>
                        <td>';
                            if($row['status'] == 0)
                            {
                                $html .='<span class="text-info"><b>Pendiente</b></span>';
                            }else if($row['status'] == 1)
                            {
                                $html .='<span class="text-success"><b>Confirmada</b></span>';
                            }
                            if($row['status'] == 2)
                            {
                                $html .='<span class="text-danger"><b>Denegada</b></span>';
                            }

                        $html .='</td>
                        <td>';
                            
                             if($row['status'] == 0){
                        $html .='<i onclick="labStatus(\''.$row['sample_piece_id'].'\')" class="text-info picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash" style="font-size:22px;cursor:pointer" data-toggle="tooltip" data-placement="top" title="Pagar"></i>';
                              }elseif($row['status'] == 1){
                         $html .='<input type="hidden" class="total_labs" value="'.$row['price'].'">';
                           
                               }
                               
                       $html .='</td>
                    </tr>
                    
                    ';
                     endforeach; endforeach; 
                     $html .='</table>
                        </div>';
                    }

                    echo $html;
                    exit();

        }

        function  getPatients($param1= ''){
                
                $response =  $this->crud_model->getPatients();    
                echo $response;
                exit();
                
            }

            function getDiagnostico(){
                $patient = $this->input->post('patient');
                $doctors_id = $this->input->post('doctor_id');
                
                $paciente = $this->db->get_where('patient', array( 'patient_id'=>$patient));
                
                $sample = $this->db->limit(1)->order_by('sample_id', 'DESC')->get_where('sample', array('patient_id'=>$paciente->row()->patient_id));
                
                $samples = $this->db->order_by('sample_id', 'DESC')->get_where('sample', array('patient_id'=>$paciente->row()->patient_id));
                $n = 1;
                
                foreach($samples->result_array() as $sa){
                    $html .= '<tr>
                                <td>'.$n++.'</td>
                                <td style="white-space: nowrap;">'.$sa["date"].'</td>
                                <td>'.$sa["code"].'</td>
                                <td>'.$sa["study"].'</td>';
    
                    if($sa['report'] != ""){
                    $html.='     <td>
                                <a href="'.base_url().'admin/sample_diagnostic/'.base64_encode($sa['sample_id']).'" target="_blank">
                                    <div class="icon-container" style="cursor:pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg><span class="icon-name"> </span>
                                    </div>
                                    </a>
                                </td>';
                            }else
                            {
                                $html.='     <td>
                              
                                </td>';
                            }
                                
                    $html.='</td>
                            </tr>';
                    }
                    
                if($paciente->row()->patient_id == ''){
                    
                    $result = 0;
                    
                }else{
                      log_message('error',$paciente->row()->patient_id);
                    $res = array($paciente->result_array() ,$sample->result_array(),$html);    
                    $result = json_encode($res);
                }
                
                echo $result;
                exit();
            }

            function getPieza(){
                $category = $this->input->post('category');
                $id =  rand(1,1000);
                $html.='<tr>
                
                <td>
                    <div class="" style="width:230px;">
                      <input type="hidden" name="piece[]" value="0" />
                                                        <input type="hidden" name="cat[]" value="'.$id.'" />
                                                        <select onchange="laboratoriesExamns(this.value,'.$id.')" class="form-control basic labs" name="laboratories[]" id="laboratories_'.$id.'">
                                                            <option value="">Seleccionar</option>';
                                                     
                                                            $db = $this->db->query('SELECT * FROM `subcategory` where category_id = 15')->result_array();
                                                                foreach($db as $info):
                                                         
                                                            $html.="<option value='".$info['id']."'>".$info['name']."</option>";
                                                         endforeach;
                          $html.='  </select>
                                                    </div>
                </td>
                <td>
                     <div class="" style="width:230px;" >
                        <div class="form-group m-b-15">
                            <select class="form-control basic "  name="exmans[]" id="examns_'.$id.'" onchange="getPrice(this.value,'.$id.')">
    
                            </select>
                            <input class="form-control total" type="hidden" min="0" onchange="sum_total()" onkeyup="sum_total()" name="price[]" id="ttl-'.$id.'" step="any" readonly="true">
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap">
                    <div class="" style="width:200px;">
                        <select name="estudio[]" class="form-control">
                            <option value="SANGRE COMPLETA">SANGRE COMPLETA</option>
                            <option value="SUERO">SUERO</option>
                            <option value="PLASMA">PLASMA</option>
                            <option value="HECES">HECES</option>
                            <option value="ORINA">ORINA</option>
                            <option value="OTRO">OTRO</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group" style="width:200px;">
                        <input class="form-control " type="text" name="details[]">
                    </div>
                </td>
                <td>
                <a href="javascript:void(0)" class="btn btn-danger " onclick="deletePieza(this)">-</a>
                </td>
            </tr>';
                echo $html;
            }

            function getPieza3(){
                $category = $this->input->post('category');
                $id =  rand(1,1000);
                $html.='<tr>
                <td>
                    <div class="" style="width:230px;">
                      <input type="hidden" name="piece[]" value="0" />
                                                        <input type="hidden" name="cat[]" value="'.$id.'" />
                                                        <select onchange="laboratoriesExamns(this.value,'.$id.')" class="form-control basic labs" name="laboratories[]" id="laboratories_'.$id.'">
                                                            <option value="">Seleccionar</option>';
                                                     
                                                            $db = $this->db->query('SELECT * FROM `subcategory` where category_id = 15')->result_array();
                                                                foreach($db as $info):
                                                         
                                                            $html.="<option value='".$info['id']."'>".$info['name']."</option>";
                                                         endforeach;
                          $html.='  </select>
                                                    </div>
                </td>
                <td>
                     <div class="" >
                        <div class="form-group m-b-15">
                            <select class="form-control basic "  name="'.$id.'_fields[]" id="examns_'.$id.'" onchange="getPrice(this.value,'.$id.')">
    
                            </select>
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap">
                    <div class="" style="width:200px;">
                        <select name="estudio[]" class="form-control">
                            <option value="SANGRE COMPLETA">SANGRE COMPLETA</option>
                            <option value="SUERO">SUERO</option>
                            <option value="PLASMA">PLASMA</option>
                            <option value="HECES">HECES</option>
                            <option value="ORINA">ORINA</option>
                            <option value="OTRO">OTRO</option>
                        </select>
                    </div>
                </td>
                <td style="white-space: nowrap">
                    <div class="form-group" style="width:120px;">
                        <input class="form-control total" type="number" min="0" onchange="sum_total()" onkeyup="sum_total()" name="price[]" id="ttl-'.$id.'" step="any" readonly="true">
                    </div>
                </td>
                <td>
                    <div class="form-group" style="width:200px;">
                        <input class="form-control " type="text" name="details[]">
                    </div>
                </td>
                <td>
                <a href="javascript:void(0)" class="btn btn-danger " onclick="deletePieza(this)">-</a>
                </td>
            </tr>';
                echo $html;
            }
    
    
            function getPieza2(){
                $category = $this->input->post('category');
                $id =  rand(1,1000);
                $html.='<tr>
                
                <td>
                    <div class="" style="width:230px;">
                      <input type="hidden" name="piece[]" value="0" />
                                                        <input type="hidden" name="cat[]" value="'.$id.'" />
                                                        <select onchange="laboratoriesExamns(this.value,'.$id.')" class="form-control basic labs" name="laboratories[]" id="laboratories_'.$id.'">
                                                            <option value="">Seleccionar</option>';
                                                     
                                                            $db = $this->db->query('SELECT * FROM `subcategory` where category_id = 15')->result_array();
                                                                foreach($db as $info):
                                                         
                                                            $html.="<option value='".$info['id']."'>".$info['name']."</option>";
                                                         endforeach;
                          $html.='  </select>
                                                    </div>
                </td>
                <td>
                     <div class="" style="width:230px;" >
                        <div class="form-group m-b-15">
                            <select class="form-control basic "  name="exmans[]" id="examns_'.$id.'" onchange="getPrice(this.value,'.$id.')">
    
                            </select>
                            <input class="form-control total" type="hidden" min="0" onchange="sum_total()" onkeyup="sum_total()" name="price[]" id="ttl-'.$id.'" step="any" readonly="true">
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap">
                    <div class="" style="width:200px;">
                        <select name="estudio[]" class="form-control">
                            <option value="SANGRE COMPLETA">SANGRE COMPLETA</option>
                            <option value="SUERO">SUERO</option>
                            <option value="PLASMA">PLASMA</option>
                            <option value="HECES">HECES</option>
                            <option value="ORINA">ORINA</option>
                            <option value="OTRO">OTRO</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group" style="width:200px;">
                        <input class="form-control " type="text" name="details[]">
                    </div>
                </td>
                <td>
                <a href="javascript:void(0)" class="btn btn-danger " onclick="deletePieza(this)">-</a>
                </td>
            </tr>';
                echo $html;
            }


            
         function getExamns(){
              
                $laboratories = $this->input->post('laboratories');
             
                $fields = $this->db->get_where('product', array('subcategory_id'=>$laboratories,'status'=>1))->result_array();
                if(count($fields) > 0)
                {
                    foreach ($fields as $filed) {
                        echo '<option value="'.$filed['product_id'].'" >'.$filed['name'].'</option>';
                    }

                }else
                {
                    echo '<option value="">No hay laboratorios disponibles</option>';
                }
                   
    
                exit();
         
            }
            
             function getRayX(){
              
                $laboratories = $this->input->post('laboratories');
             
                $inventorys = $this->db->query('SELECT * FROM inventory where status = 1 and clinic_id ='.$this->session->userdata('current_clinic'))->result_array();
                foreach($inventorys as $inventory)
                {
                    $products = $this->db->query('SELECT ip.inventory_id,ip.product_id, p.code, p.name FROM `inventory_product` ip INNER JOIN product p ON ip.product_id = p.product_id WHERE p.subcategory_id = '.$laboratories.' and ip.status = 1 and ip.inventory_id = '.$inventory['inventory_id'])->result_array();
                    log_message('error',count($products));
                    if(count($products)>0)
                    {
                        foreach($products as $product)
                        {
                            $fields = $this->db->get_where('product', array('product_id'=>$product['product_id'],'status'=>1))->result_array();
                             
                                foreach ($fields as $filed) 
                                {
                                    echo '<option value="'.$filed['product_id'].'" >'.$filed['name'].'</option>';
                                }
                        }
                                
                    
                    }
                    
                }
                        
                        
              
                   exit();
             }
    
    
            function getPrice(){
    
                $laboratory_id = $this->input->post('laboratory_id');
                $fields = $this->input->post('fields');
                $payment_type = $this->input->post('payment_type');
    
              
                $total = 0;
    
                if( $payment_type == 0){
                         
                    $total = $this->db->get_where('product', array('product_id'=>$fields))->row()->price_1;
                }

                if( $payment_type == 1){
                    $total = $this->db->get_where('product', array('product_id'=>$fields))->row()->price_2;

                }

                if( $payment_type == 2){
                    $total = $this->db->get_where('product', array('product_id'=>$fields))->row()->price_3;

                }

                echo $total!=""?$total: '0.00';
                
                exit();
    
            }
    
    
            function getPriceProduct(){
                $ID = $this->input->post('ID');
                $query = $this->db->get_where("product", array("product_id" =>$ID))->row()->price;
                echo $query;
            }
  //////////////////////////////////////////
    function rayos_x($param1 = '', $param2 = '')
    {
        
        if($param1 == 'create')
        {
            $this->crud_model->create_rayos_x();
            $this->session->set_flashdata('flash_message' , "Laboratorio agregado correctamente.");
            redirect(base_url() . 'admin/rayos_x/', 'refresh');
        }
        
         if($param1 == 'update')
        {
            $this->crud_model->update_rayos_x($param2);
            $this->session->set_flashdata('flash_message' , "Laboratorio actualizado correctamente.");
            redirect(base_url() . 'admin/rayos_x/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_rayos_x($param2);
            $this->session->set_flashdata('flash_message' , "Laboratorio eliminado correctamente.");
            redirect(base_url() . 'admin/rayos_x/', 'refresh');
        }

        if($param1 == 'add_app')
        {
            
            if(date('G') < 17)
                $price = $this->db->get_where('rayos_x', array('rayos_x_id'=>$this->input->post('rayos_x_id')))->row()->price_day;
            else
                $price = $this->db->get_where('rayos_x', array('rayos_x_id'=>$this->input->post('rayos_x_id')))->row()->price_night;


            $data['rayos_x_id']  = $this->input->post('rayos_x_id');
            $data['appointment_id']  = $this->input->post('appointment_id');
            $data['price']  = $price;
            
            $this->db->insert('rayos_x_app', $data);
            
            return true;
        }
        if($param1 == 'delete_app')
        {
            $this->db->where('rayos_x_app_id', $param2);
            $this->db->delete('rayos_x_app');
            
            return true;
        }


        if($param1 == 'add_est')
        {
            
            if(date('G') < 17)
                $price = $this->db->get_where('rayos_x', array('rayos_x_id'=>$this->input->post('rayos_x')))->row()->price_day;
            else
                $price = $this->db->get_where('rayos_x', array('rayos_x_id'=>$this->input->post('rayos_x')))->row()->price_night;


            $data['rayos_x_id']  = $this->input->post('rayos_x');
            $data['stabilitation_id']  = $this->input->post('stabilitation_id');
            $data['price']  = $price;
            
            $this->db->insert('rayos_x_est', $data);
            
            return true;
        }
        if($param1 == 'delete_est')
        {
            $this->db->where('rayos_x_est_id', $param2);
            $this->db->delete('rayos_x_est');
            
            return true;
        }
        
        $page_data['page_name']   = 'rayos_x';
        $page_data['page_title']  = "Rayos X";
        $this->load->view('backend/index', $page_data);
    }

    function product_estb($param1 = '', $param2 = '')
    {
        
        if($param1 == 'create')
        {
            $this->crud_model->create_product_estb();
            $this->session->set_flashdata('flash_message' , "Laboratorio agregado correctamente.");
            redirect(base_url() . 'admin/product_estb/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $this->crud_model->update_product_estb($param2);
            $this->session->set_flashdata('flash_message' , "Laboratorio actualizado correctamente.");
            redirect(base_url() . 'admin/product_estb/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_product_estb($param2);
            $this->session->set_flashdata('flash_message' , "Laboratorio eliminado correctamente.");
            redirect(base_url() . 'admin/product_estb/', 'refresh');
        }

        if($param1 == 'add_estb')
        {
            $price = $this->db->get_where('product', array('product_id'=>$this->input->post('product_estb_id')))->row()->price;
            $cantidad = $this->db->order_by('product_lote_id','ASD')->limit(1)->get_where('product_lote',array('product_id'=>$this->input->post('product_estb_id'), 'status'=>1 ))->row()->cantidad;

            if($this->input->post('product_cantidad_id') <= $cantidad){
                
                $data['product_estb_id']   = $this->input->post('product_estb_id');
                $data['stabilitation_id']  = $this->input->post('stabilitation_id');
                $data['cantidad']          = $this->input->post('product_cantidad_id');
                $data['discount']          = $this->input->post('product_descuento_id');
                $data['price']             = $price;
                $data['subtotal']           = $price*($data['cantidad'] - $data['discount'] );
                
                $this->db->insert('stabilitation_insum', $data);
                
                return true;
            }

            
        }
        if($param1 == 'add_discount')
        {
           
            $data['discount'] = $this->input->post('descuento');
            $data['sub_total'] = $this->input->post('total');
            $this->db->where('stabilitation_ref_id',$this->input->post('stabilitation_ref_id'));
            $this->db->update('stabilitation_ref',$data);
            
            
            return true;
        }

        if($param1 == 'delete_estb')
        {
            $this->db->where('stabilitation_insum_id', $param2);
            $this->db->delete('stabilitation_insum');
            return true;
        }
        
        $page_data['page_name']   = 'product_estb';
        $page_data['page_title']  = "Productos de estabilización";
        $this->load->view('backend/index', $page_data);
    }
    

    function discount_estb($param1 = '', $param2 = '')
    {

        if($param1 == 'add_estb')
        {
            
            $data['stabilitation_ref_id']   = $this->input->post('stabilitation_ref_id');
            $data['date']                   = date('Y-m-d');
            $data['amount']                 = $this->input->post('amount');
            $data['description']            = $this->input->post('description');
            
            $this->db->insert('stabilitation_discount', $data);
            
            return true;
        }

        if($param1 == 'delete_estb')
        {
            
            $this->db->where('stabilitation_discount_id', $param2);
            $this->db->delete('stabilitation_discount');

            return true;
        }
        
        $page_data['page_name']   = 'product_estb';
        $page_data['page_title']  = "Productos de estabilización";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function service_estb($param1 = '', $param2 = '')
    {
        
  

        if($param1 == 'add_estb')
        {
                $price = $this->db->get_where('service', array('service_id'=>$this->input->post('service_estb_id')))->row()->price;
                $data['service_id']   = $this->input->post('service_estb_id');
                $data['stabilitation_id']  = $this->input->post('stabilitation_id');
                $data['cantidad']          = $this->input->post('service_cantidad_id');
                $data['price']             = $price*$data['cantidad'];
               
                $this->db->insert('stabilitation_service', $data);
                return true;
         
            
        }
        if($param1 == 'add_discount')
        {
           
            $data['discount'] = $this->input->post('descuento');
            $data['sub_total'] = $this->input->post('total');
            $this->db->where('stabilitation_ref_id',$this->input->post('stabilitation_ref_id'));
            $this->db->update('stabilitation_ref',$data);
            
            
            return true;
        }

        if($param1 == 'delete_est')
        {
            
            $this->db->where('stabilitation_service_id', $param2);
            $this->db->delete('stabilitation_service');

            return true;
        }
        
        $page_data['page_name']   = 'product_estb';
        $page_data['page_title']  = "Productos de estabilización";
        $this->load->view('backend/index', $page_data);
    }

    function surveys($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'create')
        {
            
            $survey_id = $this->crud_model->create_survey();
            $this->session->set_flashdata('flash_message' , "Encuesta creada correctamente.");
            redirect(base_url() . 'admin/question_board/'.$survey_id.'/', 'refresh');
        }
        
         if($param1 == 'update')
        {
            $this->log_model->update_survey($param2);
            $this->crud_model->update_survey($param2);
            $this->session->set_flashdata('flash_message' , "Encuesta actualizada correctamente.");
            redirect(base_url() . 'admin/question_board/'.$param2.'/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_survey($param2);
            $this->crud_model->delete_questions($param2);
            $this->session->set_flashdata('flash_message' , "Encuesta eliminada correctamente.");
            redirect(base_url() . 'admin/surveys/', 'refresh');
        }
        
        $page_data['page_name']   = 'surveys';
        $page_data['page_title']  = "Encuestas";
        $this->load->view('backend/index', $page_data);
    }
    
      
    function question_board($codigo = '')
    {
         $this->session_login();
        
        $page_data['page_name']  = 'question_board';
        $page_data['page_title'] =  "Tablero";
        $page_data['codigo'] =  $codigo;
        $this->load->view('backend/index', $page_data);
    }
    
    
    
    function multiple_choice($param1 = '',$param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'create')
        {
            $this->crud_model->create_multiple_choice($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta creada correctamente.");
            redirect(base_url() . 'admin/questions/'.$param2.'/', 'refresh');
        }
        
        $page_data['page_name']  = 'multiple_choice';
        $page_data['page_title'] =  "Preguntas multiples";
        $page_data['codigo'] =  $param1;
        $this->load->view('backend/index', $page_data);
    }
    
    function questions($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'text')
        {
            $this->crud_model->create_text($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta creada correctamente.");
            redirect(base_url() . 'admin/questions/'.$param2.'/', 'refresh');
        }
        
        if($param1 == 'satisfaction')
        {
            $this->crud_model->create_satisfaction($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta creada correctamente.");
            redirect(base_url() . 'admin/questions/'.$param2.'/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $id_survey = $this->db->get_where('question', array('question_id' => $param2))->row()->survey_id;
            $this->crud_model->update_question($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta actualizada correctamente.");
            redirect(base_url() . 'admin/questions/'.$id_survey.'/', 'refresh');
        }
        
        if($param1 == 'delete')
        {
            $id_survey = $this->db->get_where('question', array('question_id' => $param2))->row()->survey_id;
            $this->crud_model->delete_question($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta eliminada correctamente.");
            redirect(base_url() . 'admin/questions/'.$id_survey.'/', 'refresh');
        }
        
        $page_data['page_name']  = 'questions';
        $page_data['page_title'] =  "Preguntas";
        $page_data['codigo'] =  $param1;
        $this->load->view('backend/index', $page_data);
    }
    
    
    function update_multiple($param1 = '',$param2 = ''){
    
        $this->session_login(); 
        
        if($param1 == 'update')
        {
            $id_survey = $this->db->get_where('question', array('question_id' => $param2))->row()->survey_id;
            $page_data['codigo'] =  $param2;
            $this->crud_model->update_multiple_choice($param2);
            $this->session->set_flashdata('flash_message' , "Pregunta actualizada correctamente.");
            redirect(base_url() . 'admin/questions/'.$id_survey.'/', 'refresh');
        }
        $page_data['codigo'] = $param1;
        $page_data['page_name'] = 'update_multiple';
        $page_data['page_title'] = "Actualizar pregunta";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function hour_busy($param1 = '', $param2 = '')
    {

        $this->db->where('date',$this->input->post('date'));
        $this->db->where('status !=',2);
        $this->db->where('status !=',3);
        $this->db->where('status !=',4);
        $this->db->where('doctor_id',$this->input->post('doctor_id'));
        
        $query =  $this->db->get('appointment')->result_array();
        
        
        header('Content-type: application/json; charset=utf-8');
         echo json_encode($query);
         exit();
         
       
    }
    
    
   /*
    
    
   function solicite_data()
    {
        
          $this->accounts_model->solicite_data();
        
    }

    */
    

    
    
    function total_inventario()
    {
        $query = $this->db->get_where('product', array('clinic_id' => $this->session->userdata('current_clinic'),'status'=>1));
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        if($query->num_rows()>0){
            $html_table = '
                    <table class="table table-padded demo" id="mainTable">
                    <thead style="background-color:#f9fbfc; color:#59636d;">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Fecha Expiración</th>
                        <th>Existencias</th>
                    </thead>
                    <tbody>';
        
        foreach($query->result_array() as $row)
        {
            
            $expiration = explode("-",$this->crud_model->get_inventory_expired($row['product_id']));
            
            $html_table .= '
                <tr style="font-size:14px;" class="">
                    <td>'.$row['product_id'].' </td>
                    <td> <a href="'.base_url().'admin/history/'.$row['product_id'].'" style="color:black;">'.$row['name'].' </a></td>
                    <td>'.$row['code'].'</td>
                    <td style="width: 70px;">'.$currency.'. '.number_format($row['price'],'2','.',',').'</td>
                    <td>'.$expiration[2].'/'.$expiration[1].'/'.$expiration[0].'</td>
                    <td>'. $this->crud_model->get_inventory($row['product_id']).'</td>
                </tr>';
        }
        
        $html_table .='<tbody></table>';
        echo $html_table;
        }else{
            $html_table = '

            table class="table table-padded demo" id="mainTable">
            <thead>
            <th>Paciente</th>
            <th>Especialista</th>
            <th>Fecha & Hora</th>
            <th>Estado</th>
            </thead>
            <tbody>';
            
        $html_table .='</tbody></table>';
        echo $html_table;
        }
        
    }
    
    function alert_table()
    {
        $query =  $this->crud_model->count_alert();
        
        
            $html_table = '
            <table class="table table-padded demo" id="mainTable">
            <thead style="background-color:#f9fbfc; color:#59636d;">
                <th>#</th>
                <th>Nombre</th>
                <th>Codigo</th>
                <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th>Fecha Expiración</th>
                <th>Existencias</th>
            </thead>
            <tbody>';
      if(count($query)>0){
        foreach($query as $row)
        {
            $expiration = explode("-",$this->crud_model->get_inventory_expired($row['product_id']));
            
            $html_table .= '
            <tr style="font-size:14px;" class="">
                <td>'.$row['product_id'].'</td>
                <td>'. $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->name.'</td>
                <td>'. $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->code.'</td>
                <td style="width: 70px;">Q.'.number_format($this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->price,'2','.',',').'</td>
                <td>'.$expiration[2].'/'.$expiration[1].'/'.$expiration[0].'</td>
                <td>'. $this->crud_model->get_inventory($row['product_id']).'</td>
            </tr>';
        }
    }
        $html_table .='</tbody></table>';
        echo $html_table;
       
        
    }

    function vencido_inventario()
    {
        $query =  $this->crud_model->product_expiration()->result_array();
        
        
            $html_table = '
            <table class="table table-padded demo" id="mainTable">
            <thead style="background-color:#f9fbfc; color:#59636d;">
                <th>#</th>
                <th>Nombre</th>
                <th>Codigo</th>
                <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th>Fecha Expiración</th>
                <th>Existencias</th>
            </thead>
            <tbody>';
      if(count($query)>0){

        foreach($query as $row)
        {
            $expiration = explode("-",$this->crud_model->get_inventory_expired($row['product_id']));
            
            $html_table .= '
            <tr style="font-size:14px;" class="">
                <td>'.$row['product_id'].'</td>
                <td>'. $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->name.'</td>
                <td>'. $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->code.'</td>
                <td style="width: 70px;">Q.'.number_format($this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->price,'2','.',',').'</td>
                <td>'.$expiration[2].'/'.$expiration[1].'/'.$expiration[0].'</td>
                <td>'.$row['cantidad'].'</td>
            </tr>';
        }
    }
        $html_table .='</tbody></table>';
        echo $html_table;
       
        
    }
    
    function vencer_inventario(){
        
        
        $query = $this->crud_model->product_per_expiration();
        
            $html_table = '
                    <table class="table table-padded demo" id="mainTable">
                    <thead style="background-color:#f9fbfc; color:#59636d;">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Fecha Expiración</th>
                        <th>Existencias</th>
                    </thead>
                    <tbody>';
        
        foreach($query as $row)
        {
            $expiration = explode("-",$this->crud_model->get_inventory_expired($row['product_id']));
            $html_table .= '
            <tr style="font-size:14px;" class="">
                <td>'.$row['product_id'].'</td>
                <td>'. $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->name.'</td>
                <td>'. $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->code.'</td>
                <td style="width: 70px;">Q.'.number_format($this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->price,'2','.',',').'</td>
                <td>'.$expiration[2].'/'.$expiration[1].'/'.$expiration[0].'</td>
                <td>'.$row['cantidad'].'</td>
            </tr>';
        }
        
        $html_table .='</tbody></table>';
        echo $html_table;
    }
    
    function agotado_inventario()
    {
    $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;  
    $query = $this->crud_model->product_outstock();
    
            $html_table = '
            <table class="table table-padded demo" id="mainTable">
            <thead style="background-color:#f9fbfc; color:#59636d;">
                <th>#</th>
                <th>Nombre</th>
                <th>Codigo</th>
                <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th>Fecha Expiración</th>
                <th>Existencias</th>
            </thead>
            <tbody>';
        
        foreach($query as $row)
        {
            $html_table .= '
            <tr style="font-size:14px;" class="">
                <td>'.$row['product_id'].'</td>
                <td>'. $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->name.'</td>
                <td>'. $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->code.'</td>
                <td style="width: 70px;">Q.'.number_format($this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->price,'2','.',',').'</td>
                <td>'.$row['expiration'].'</td>
                <td>'.$this->crud_model->get_inventory($row['product_id']).'</td>
            </tr>';
        }
        
        $html_table .='</tbody></table>';
        echo $html_table;
    }
    
    
    function pay_appointment($param1 = '',$param2 = '',$param3 = '')
    {
         $this->session_login();

        if($param1 == 'email')
        {
            $patient_id         = $param3;//$this->db->get_where('cart', array('appointment_id' => $param2))->row()->patient_id;
            $sale_id            = $this->db->get_where('cart', array('appointment_id' => $param2))->row()->cart_id;
            $prescription_name  = str_replace(' ','_', $this->accounts_model->get_name('patient', $patient_id));
            
            $data = array(
                'appointment_id' => $param2,
                'sale_id' => $sale_id,
                'patient_id' => $patient_id
            );
            
            $html = $this->load->view('backend/pdf_recipe.php',$data,TRUE); 
            $pdfFilePath = "recibo_de_venta-".$prescription_name.".pdf";
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'A4'); 
            $mpdf->packTableData = true;
            $mpdf->WriteHTML($html,2);
            $mpdf->Output('public/uploads/'.$pdfFilePath, "F");

            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;

          
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
            redirect(base_url() . 'admin/pay_appointment/'.base64_encode($param2), 'refresh');
        }

        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'pay_appointment';
        $page_data['page_title']  = "Detalles de la venta";
        $this->load->view('backend/index', $page_data);
        
    }
    

    
    function new_doctor($param1 = '',$param2 = '')
    {
         $this->session_login();
        
        $page_data['page_name']     = 'new_doctor';
        $page_data['page_title']    = 'Nueva cuenta de doctor';
        $this->load->view('backend/index', $page_data);
    }
    
    
    function doctor_security($param1 = '',$param2 = '')
    {
         $this->session_login();
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_security';
        $page_data['page_title']    = 'Seguridad';
        $this->load->view('backend/index', $page_data);
    }
    
    function doctor_calendar($param1 = '',$param2 = '')
    {
         $this->session_login();
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_calendar';
        $page_data['page_title']    = 'Agenda';
        $this->load->view('backend/index', $page_data);
    }
    
    function doctor_appointments($param1 = '',$param2 = '')
    {
         $this->session_login();
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_appointments';
        $page_data['page_title']    = 'Citas';
        $this->load->view('backend/index', $page_data);
    }
    
    
    function doctor_permissions($param1 = '',$param2 = '')
    {
         $this->session_login();
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_permissions';
        $page_data['page_title']    = 'Permisos';
        $this->load->view('backend/index', $page_data);
    }
    
    
    function doctor_activity($param1 = '',$param2 = '')
    {
         $this->session_login();
        $page_data['id_']           = base64_decode($param1);
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'doctor_activity';
        $page_data['page_title']    = 'Actividades';
        $this->load->view('backend/index', $page_data);
    }

    function activity($param1 = '',$param2 = '')
    {
         $this->session_login();

        if($param1 == 'create')
        {
            $this->appointment_model->create_act();
            redirect(base_url() . 'admin/panel/', 'refresh');
        }
       
    }
    
    
    function my_profile($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']     = 'my_profile';
        $page_data['page_title']    = "Mi Perfil";
        $this->load->view('backend/index', $page_data);
    }
    
    function staff_notifications($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'staff_notifications';
        $page_data['page_title']  = "Notificaciones del Usuario ";
        $this->load->view('backend/index', $page_data);
    }
    
    function staff_security($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_']         = $param1;
        $page_data['owner']       = $this->crud_model->account_owner();
        $page_data['page_name']   = 'staff_security';
        $page_data['page_title']  = "Contraseña y seguridad del Usuario ";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function staff_activity($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'staff_activity';
        $page_data['page_title']  = "Actividades del Usuario ";
        $this->load->view('backend/index', $page_data);
    }
    
    
    function my_notifications($param1 = '', $param2 = '')
    {
         $this->session_login();
        if($param1 == 'delete')
        {
            $this->db->where('notification_id', $param2);
            $this->db->delete('notification');
            $this->session->set_flashdata('flash_message' , "Notificación eliminada correctamente.");
            redirect(base_url() . 'admin/my_notifications/', 'refresh');
        }
        if($param1 == 'mark_read')
        {
            $data['read_status'] = 1;    
            $this->db->where('notification_id', $param2);
            $this->db->update('notification', $data);
            $this->session->set_flashdata('flash_message' , "Notificación actualizada correctamente.");
            redirect(base_url() . 'admin/my_notifications/', 'refresh');
        }

        if($param1 == 'read')
        {
            $data['read_status'] = 1;    
            $this->db->where('to_user', $param2);
            $this->db->update('notification', $data);
        }


        $page_data['owner']         = $this->crud_model->account_owner();
        $page_data['page_name']   = 'my_notifications';
        $page_data['page_title']  = "Mis notificaciones";
        $this->load->view('backend/index', $page_data);
    }
    
    
     
    function my_security($param1 = '',$param2 = '')
     {
         $this->session_login();
        $page_data['page_name']     = 'my_security';
        $page_data['page_title']    = 'Seguridad';
        $this->load->view('backend/index', $page_data);
    }
    
        
    function my_activity($param1 = '',$param2 = '')
    {
         $this->session_login();
        $page_data['page_name']     = 'my_activity';
        $page_data['page_title']    = 'Mis actividades';
        $this->load->view('backend/index', $page_data);
    }
    
    
    function my_calendar($param1 = '',$param2 = '')
    {
         $this->session_login();
        $page_data['page_name']     = 'my_calendar';
        $page_data['page_title']    = 'Agenda';
        $this->load->view('backend/index', $page_data);
    }
    
    function my_appointments($param1 = '',$param2 = '')
    {
         $this->session_login();
        $page_data['page_name']     = 'my_appointments';
        $page_data['page_title']    = 'Citas';
        $this->load->view('backend/index', $page_data);
    }
    
    function my_permissions($param1 = '',$param2 = '')
    {
         $this->session_login();
        $page_data['page_name']     = 'my_permissions';
        $page_data['page_title']    = 'Permisos';
        $this->load->view('backend/index', $page_data);
    }
    
    function getTable($table = '' ,$param1 = '' ,$param2 = '' ,$param3 = '')
    {
        return $this->tables_model->getTables($table,$param1,$param2,$param3);   
    }
    
    
    function staff_permissions($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['id_']         = $param1;
        $page_data['page_name']   = 'staff_permissions';
        $page_data['page_title']  = "Permisos del Usuario ";
        $this->load->view('backend/index', $page_data);
    }
    
     function treatments_status($treatment_id)
    {
        $this->db->order_by('tooth_treatment_id', 'DESC');
        $this->db->where('odonto_treatment_id', $treatment_id);
        $treat = $this->db->get('tooth_treatment')->result_array();
        $stt = '';
        
        foreach($treat as $rs)
        {
            if($rs['status'] == 1)
            {
                $stt = 0;
            }
            else
            {
                $stt = 1;
            }
        }
        
        return $stt;
    }
    
    
    function treatmentss($treatment_id)
    {
        $this->db->where('odonto_treatment_id', $treatment_id);
        $detalles = $this->db->get('tooth_treatment')->num_rows();
        return $detalles;
    }
    
    
    function treatment_archive($param1 = '' ,$param2 = '' ,$param3 = '')
    {
          $this->session_login();
        
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
            $mail->Body = $this->load->view('backend/mails/receipt2.php',$data2,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
            unlink("public/uploads/" . $pdfFilePath);
            
            $this->session->set_flashdata('flash_message' , "Correo enviado correctamente.");
            redirect(base_url() . 'admin/treatment/'.base64_encode($patient_id), 'refresh');
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
        
       
        if($param1 == 'delete')
        {
            return $this->appointment_model->delete_treatment($param2); 
        }
        
    }


    function thooth_procedures($param1 = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        
        $this->session_login();
        if ( $odonto == "")
        {
            redirect(base_url(), 'refresh');
        }


        if($param1 == 'create')
        {
            $this->crud_model->create_process();
            $this->session->set_flashdata('flash_message' , "Procedimiento agregado correctamente.");
            redirect(base_url() . 'admin/thooth_procedures/', 'refresh');
        }
        
        if($param1 == 'update')
        {
            $this->crud_model->update_process($param2);
            $this->session->set_flashdata('flash_message' , "Procedimiento actualizado correctamente.");
            redirect(base_url() . 'admin/thooth_procedures/', 'refresh');
        }
        
          if($param1 == 'delete')
        {
            
            $this->crud_model->delete_process($param2);
            $this->session->set_flashdata('flash_message' , "Procedimiento eliminado correctamente.");
            redirect(base_url() . 'admin/thooth_procedures/', 'refresh');
        }
        
        $page_data['page_name']   = 'thooth_procedures';
        $page_data['page_title']  = "Procedimientos dentales";
        $this->load->view('backend/index', $page_data);
    }


    function kardex($param1 = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        
        $this->session_login();
        if ( $odonto == "")
        {
            redirect(base_url(), 'refresh');
        }


        if($param1 == 'add_medicamento')
        {
            $this->crud_model->add_medicamento($param2);
            $this->session->set_flashdata('flash_message' , "Medicamento agregado correctamente.");
            redirect(base_url() . 'admin/history/'.$param2, 'refresh');
        }
        if($param1 == 'remove_medicamento')
        {
            $this->crud_model->remove_medicamento($param2);
            $this->session->set_flashdata('flash_message' , "Medicamento descargado correctamente.");
            redirect(base_url() . 'admin/history/'.$param2, 'refresh');
        }
        $page_data['ID']          = $param1;
        $page_data['page_name']   = 'kardex';
        $page_data['page_title']  = "Historial de medicamentos";
        $this->load->view('backend/index', $page_data);
    }


    function history_resumen($param1 = '', $param2 = '')
    {
        echo $this->db->query(" SELECT sum(cantidad) as total FROM `product_lote` WHERE product_id = '$param1' AND status = '1' ")->row()->total;
    }

  

    function equipment($param1 = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        
        $this->session_login();
        if ( $odonto == "")
        {
            redirect(base_url(), 'refresh');
        }


        if($param1 == 'create')
        {
            $this->crud_model->create_equipment();
            $this->session->set_flashdata('flash_message' , "Equipo agregado correctamente.");
            redirect(base_url() . 'admin/equipment/', 'refresh');
        }

        if($param1 == 'update')
        {
            $this->crud_model->update_equipment($param2);
            $this->session->set_flashdata('flash_message' , "Equipo eliminado correctamente.");
            redirect(base_url() . 'admin/equipment/', 'refresh');
        }

        if($param1 == 'delete')
        {
            $this->crud_model->delete_equipment($param2);
            $this->session->set_flashdata('flash_message' , "Equipo eliminado correctamente.");
            redirect(base_url() . 'admin/equipment/', 'refresh');
        }

        $page_data['page_name']   = 'equipment';
        $page_data['page_title']  = "Equipamiento medico";
        $this->load->view('backend/index', $page_data);
    }

    function supplies($param1 = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        
        $this->session_login();
        if ( $odonto == "")
        {
            redirect(base_url(), 'refresh');
        }


        if($param1 == 'create')
        {
            $this->crud_model->create_supplies();
            $this->session->set_flashdata('flash_message' , "Equipo agregado correctamente.");
            redirect(base_url() . 'admin/supplies/', 'refresh');
        }

        if($param1 == 'update')
        {
            $this->crud_model->update_supplies($param2);
            $this->session->set_flashdata('flash_message' , "Equipo eliminado correctamente.");
            redirect(base_url() . 'admin/supplies/', 'refresh');
        }

        if($param1 == 'delete')
        {
            $this->crud_model->delete_supplies($param2);
            $this->session->set_flashdata('flash_message' , "Equipo eliminado correctamente.");
            redirect(base_url() . 'admin/supplies/', 'refresh');
        }

        $page_data['page_name']   = 'supplies';
        $page_data['page_title']  = "Equipamiento medico";
        $this->load->view('backend/index', $page_data);
    }

    function entry($param1 = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        
        $this->session_login();
        if ( $odonto == "")
        {
            redirect(base_url(), 'refresh');
        }

        
        $page_data['date']          = $this->input->post('date');
        $page_data['page_name']   = 'entry';
        $page_data['page_title']  = "Ingresos de colaboradores";
        $this->load->view('backend/index', $page_data); 
    }

    function entry_staff($param1 = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        
        $this->session_login();
        if ( $odonto == "")
        {
            redirect(base_url(), 'refresh');
        }


        $timestamp = $this->crud_model->teacherAttendance();
        redirect(base_url().'admin/entry_view/'. $timestamp,'refresh');  

    }

    function entry_staff_update($timestamp = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        $this->session_login();
        if ( $odonto == "")
        {
            redirect(base_url(), 'refresh');
        }

        $this->crud_model->updateAttendance($timestamp);
        redirect(base_url().'admin/entry_view/'. $timestamp,'refresh');  

    }


    function entry_view($timestamp = '', $param2 = '')
    {
        $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
        $this->session_login();
        if ($odonto == "")
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['timestamp']  = $timestamp;
        $page_data['page_name']   = 'entry_view';
        $page_data['page_title']  = "Ingresos de colaboradores";
        $this->load->view('backend/index', $page_data); 
    }

    function excel($param1 = '', $param2 = '')
    {
        $this->crud_model->excel_export($param1,$param2);
    }

    function excel_inventory_report($param1 = '', $param2 = '')
    {
        $this->crud_model->excel_export_inventory($param1);
    }

    function print_kardex($param1 = '', $param2 = '')
    {
         $this->session_login();
        $page_data['ID']           = base64_decode($param1);
        $this->load->view('backend/print_history', $page_data);
    }

    function excel_export_kardex($param1 = '', $param2 = '')
    {
        $this->inventory_model->excel_export_kardex($param1);
    }
    
    function copy_inventory()
    {
        
        
        $products = $this->db->get_where('product',array('status'=>0))->result_array();
        $n = 1;
        foreach($products as $product)
        {
           
    
            $data['name']               = $product['name'];
            $data['presentation']       =$product['presentation'];
            $data['provider']           =$product['provider'];
            $data['clinic_id']          = $product['clinic_id'];
            $data['code']               =$product['code'];
            $data['cost']               = $product['cost'];
            $data['price']              = $product['price'];
            $data['initial_inventory']  = 0;
            $data['stock']              = 0;
            $data['amount_alert']       = $product['amount_alert'];
            $data['componente']         = $product['componente'];
            $data['concentracion']      = $product['concentracion'];
    
            $data['amount_maxima']       = $product['amount_maxima'];
            $data['ubication']           = $product['ubication'];
            $data['amount_presentation'] = $product['amount_presentation'];
            $data['storage']             = $product['storage'];
            $data['margin']              = $product['margin'];
            $data['expiration']         = $product['expiration'];
            $data['image']              = $product['image'];
            $data['category']           = $product['category'];
    
            $this->db->insert('product', $data);
            echo $n++.'-'.$product['name'].'<br>';
        }
    }

    function roles($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if ($param1 == 'new') {
            $this->accounts_model->newRoleUser();
            $this->session->set_flashdata('flash_message' , "Rol creado correctamente.");
            redirect(base_url().'admin/roles/', 'refresh');
        }
        if ($param1 == 'edit') {
            $this->accounts_model->editRoleUser($param2);
            $this->session->set_flashdata('flash_message' , "Rol editado correctamente.");
            redirect(base_url().'admin/roles/', 'refresh');
        }
        if ($param1 == 'deactivate') {
            return $this->accounts_model->deactivateRoleUser();
        }
        if ($param1 == 'activate') {
            return $this->accounts_model->activateRoleUser();
        }
        if ($param1 == 'delete') {
            return $this->accounts_model->deleteRoleUser();
        }
        
        $page_data['page_name']  = 'roles';
        $page_data['page_title'] = "Roles de usuario";
        $this->load->view('backend/index', $page_data);
    }
    
    function permissions($param1 = '', $param2 = '')
    {
         $this->session_login();
        
        if($param1 == 'apply') {
            log_message('error','test permisos');
            $this->accounts_model->savePermissions($param2);
            $this->session->set_flashdata('flash_message' , "Permisos aplicados correctamente.");
            redirect($this->agent->referrer(), 'refresh');
        }
        
        $page_data['role_id']    = base64_decode($param1);
        $page_data['page_name']  = 'permissions';
        $page_data['page_title'] = "Permisos de roles de usuario";
        $this->load->view('backend/index', $page_data);
    }
    
    //Inicio de contabilidad
    function nomenclature($param1 = '', $param2 = '', $param3 = '')
    {
         $this->session_login();

        if ($param1 == 'save') {
            $response = $this->crud_model->newAccount();
            $this->session->set_flashdata('flash_message' , "Cuenta agregada correctamente");
            redirect(base_url().'admin/nomenclature/', 'refresh');
        }
        if ($param1 == 'edit_nomen') {
            $response = $this->crud_model->editNomen();
            $this->session->set_flashdata('flash_message' , "Cuenta editada correctamente");
            redirect(base_url().'admin/nomenclature/', 'refresh');
        }
        if ($param1 == 'deactivate_nomen') {
            return $this->crud_model->deactivateNomen($param2);
        }
        if ($param1 == 'activate_nomen') {
            return $this->crud_model->activateNomen($param2);
        }
        if ($param1 == 'delete_nomen') {
            return $this->crud_model->deleteNomen($param2);
        }
        $page_data['page_name']  = 'nomenclature';
        $page_data['page_title'] = 'Nomenclatura';
        $this->load->view('backend/index', $page_data);
    }

    function searchNomenNew()
    {
         $this->session_login();

        return $this->crud_model->searchNomenNew();
    }
    
    function searchNomenEdit()
    {
         $this->session_login();

        return $this->crud_model->searchNomenEdit();
    }
    
    function departures($param1 = '', $param2 = '')
    {
         $this->session_login();

        if ($param1 == 'deactivate') {
            $response = $this->crud_model->deactivateDeparture();
            return $response;
        }
        if ($param1 == 'activate') {
            $response = $this->crud_model->activateDeparture();
            return $response;
        }
        if ($param1 == 'delete') {
            $response = $this->crud_model->deleteDeparture();
            return $response;
        }

        $hoy = date("Y-m-d");
        $nomenclature_id = $this->input->post('nomenclature_id');
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-m-01");
        if ($final == '') $final = date("Y-m-t");
        $page_data['nomenclature_id'] = $nomenclature_id;
        $page_data['initial']         = $initial;
        $page_data['final']           = $final;
        $page_data['page_name']       = 'departures';
        $page_data['page_title']      = 'Partidas';
        $this->load->view('backend/index', $page_data);
    }

    function departure($param1 = '', $param2 = '')
    {
         $this->session_login();

        if ($param1 == 'create') {
            $response = $this->crud_model->newDeparture();
            $this->session->set_flashdata('flash_message' , "Partida agregada exitosamente");
            redirect(base_url().'admin/departure_edit/'.base64_encode($response), 'refresh');
        }
        if ($param1 == 'edit') {
            $response = $this->crud_model->editDeparture();
            $this->session->set_flashdata('flash_message' , "Partida editada exitosamente");
            redirect(base_url().'admin/departures/', 'refresh');
        }
        $page_data['page_name']  = 'departure';
        $page_data['page_title'] = 'Nueva partida';
        $this->load->view('backend/index', $page_data);
    }
    
    function departure_edit($param1 = '', $param2 = '')
    {
         $this->session_login();

        if ($param1 == 'deactivate_detail') {
            return $this->crud_model->deactivateDeparDetail();
        }
        if ($param1 == 'deactivate_purchase') {
            return $this->crud_model->deactivatePurchase();
        }
        $page_data['departure_id'] = base64_decode($param1);
        $page_data['page_name']    = 'departure_edit';
        $page_data['page_title']   = 'Editar partida';
        $this->load->view('backend/index', $page_data);
    }
    
    function nomenByIDJson()
    {
         $this->session_login();

        return $this->crud_model->nomenByIDJson();
    }
    
    function inputsPurchase()
    {
         $this->session_login();

        return $this->crud_model->inputsPurchase();
    }
    
    function addFieldSelect()
    {
         $this->session_login();

        return $this->crud_model->addFieldSelect();
    }
    
    function getProviderAjax($new = '')
    {
         $this->session_login();

        return $this->crud_model->getProviderAjax($new);
    }

    function addIVASelect()
    {
         $this->session_login();

        return $this->crud_model->addIVASelect();
    }

    function addISRSelect()
    {
         $this->session_login();

        return $this->crud_model->addISRSelect();
    }

    function addRetenSelect()
    {
         $this->session_login();

        return $this->crud_model->addRetenSelect();
    }

    function addExenSelect()
    {
         $this->session_login();

        return $this->crud_model->addExenSelect();
    }

    function getProviderJson()
    {
         $this->session_login();

        return $this->crud_model->getProviderJson();
    }

    function countExistPurchase()
    {
         $this->session_login();

        return $this->crud_model->countExistPurchase();
    }

    function countOtherExistPurchase()
    {
         $this->session_login();

        return $this->crud_model->countOtherExistPurchase();
    }

    function verifyPeriod()
    {
         $this->session_login();

        return $this->crud_model->verifyPeriod();
    }
    
    function verifyPeriodClose()
    {
         $this->session_login();

        return $this->crud_model->verifyPeriodClose();
    }
    
    function verifyPeriodOpen()
    {
         $this->session_login();

        return $this->crud_model->verifyPeriodOpen();
    }
    
    function verifyPeriodAdjust()
    {
         $this->session_login();

        return $this->crud_model->verifyPeriodAdjust();
    }
        
    function journal($param1 = '', $param2 = '')
    {
         $this->session_login();

        $nomen_id = $this->input->post('nomenclature_id');
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-m-01");
        if ($final == '') $final = date("Y-m-t");

        $page_data['initial']    = $initial;
        $page_data['final']      = $final;
        $page_data['nom_id']     = $nomen_id;
        $page_data['page_name']  = 'journal';
        $page_data['page_title'] = 'Libro diario';
        $this->load->view('backend/index', $page_data);
    }
    
    function ledger($param1 = '', $param2 = '')
    {
         $this->session_login();

        $nomenclature_id = $this->input->post('nomenclature_id');
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-m-01");
        if ($final == '') $final = date("Y-m-t");

        $page_data['nomenclature_id'] = $nomenclature_id;
        $page_data['initial']         = $initial;
        $page_data['final']           = $final;
        $page_data['page_name']       = 'ledger';
        $page_data['page_title']      = 'Libro mayor';
        $this->load->view('backend/index', $page_data);
    }

    function general($param1 = '', $param2 = '')
    {
         $this->session_login();

        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-01-01");
        if ($final == '') $final = date("Y-12-31");

        $page_data['initial']    = $initial;
        $page_data['final']      = $final;
        $page_data['page_name']  = 'general';
        $page_data['page_title'] = 'Balance General';
        $this->load->view('backend/index', $page_data);
    }

    function statement($param1 = '', $param2 = '')
    {
         $this->session_login();

        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-01-01");
        if ($final == '') $final = date("Y-12-31");

        $page_data['initial']    = $initial;
        $page_data['final']      = $final;
        $page_data['page_name']  = 'statement';
        $page_data['page_title'] = 'Estado de resultados';
        $this->load->view('backend/index', $page_data);
    }

    function bank_book($param1 = '', $param2 = '')
    {
         $this->session_login();

        $account_id = $this->input->post('account_id');
        $no_policy = $this->input->post('no_policy');
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-m-01");
        if ($final == '') $final = date("Y-m-t");

        $page_data['account_id'] = $account_id;
        $page_data['no_policy']  = $no_policy;
        $page_data['initial']    = $initial;
        $page_data['final']      = $final;
        $page_data['page_name']  = 'bank_book';
        $page_data['page_title'] = 'Libro de bancos';
        $this->load->view('backend/index', $page_data);
    }
       
    function policy_departure($param1 = '', $param2 = '')
    {
         $this->session_login();

        $departure_id = base64_decode($param1);
        $page_data['departure_id'] = $departure_id;
        $page_data['page_name']    = 'policy_departure';
        $page_data['page_title']   = 'Pólizas';
        $this->load->view('backend/index', $page_data);
    }
   
    function balances($param1 = '', $param2 = '')
    {
         $this->session_login();

        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-m-01");
        if ($final == '') $final = date("Y-m-t");

        $page_data['initial']    = $initial;
        $page_data['final']      = $final;
        $page_data['page_name']  = 'balances';
        $page_data['page_title'] = 'Balance de saldos';
        $this->load->view('backend/index', $page_data);
    }
        
    function bank_conciliation($param1 = '', $param2 = '') 
    {
         $this->session_login();

        $bank_account_id = $this->input->post('bank_account_id');
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-m-01");
        if ($final == '') $final = date("Y-m-t");

        if ($param1 == 'save') {
            $id = $this->crud_model->insertBankConciliation();
            $this->session->set_flashdata('flash_message', "Conciliación agregada exitosamente");
            redirect(base_url().'admin/bank_conciliation_detail/'.base64_encode($id), 'refresh');
        }

        $page_data['bank_account_id'] = $bank_account_id;
        $page_data['initial']         = $initial;
        $page_data['final']           = $final;
        $page_data['page_name']       = 'bank_conciliation';
        $page_data['page_title']      = 'Conciliación bancaria';
        $this->load->view('backend/index', $page_data);
    }
        
    function bank_conciliations($param1 = '', $param2 = '', $param3 = ''){
         $this->session_login();

        if ($param1 == 'delete') {
            $response = $this->crud_model->deleteBankConciliation();
            return $response;
        }
        $page_data['page_name']  = 'bank_conciliations';
        $page_data['page_title'] = 'Conciliaciones bancarias';
        $this->load->view('backend/index', $page_data);
    }

    function bank_conciliation_detail($param1 = '', $param2 = '', $param3 = ''){
         $this->session_login();

        $page_data['bank_conciliation_id'] = base64_decode($param1);
        $page_data['page_name']            = 'bank_conciliation_detail';
        $page_data['page_title']           = 'Conciliación bancaria';
        $this->load->view('backend/index', $page_data);
    }

    function cash_flow($param1 = '', $param2 = '') 
    {
         $this->session_login();
        
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-01-01");
        if ($final == '') $final = date("Y-12-t");

        if ($param1 == 'save') {
            $id = $this->crud_model->insertCashFlow();
            $this->session->set_flashdata('flash_message', "Flujo de efectivo agregada exitosamente");
            redirect(base_url().'admin/cash_flow_detail/'.base64_encode($id), 'refresh');
        }

        $page_data['initial']    = $initial;
        $page_data['final']      = $final;
        $page_data['page_name']  = 'cash_flow';
        $page_data['page_title'] = 'Flujo de Efectivo';
        $this->load->view('backend/index', $page_data);
    }
        
    function cash_flows($param1 = '', $param2 = '', $param3 = ''){
         $this->session_login();

        if ($param1 == 'delete') {
            $response = $this->crud_model->deleteCashFlow();
            return $response;
        }
        $page_data['page_name']  = 'cash_flows';
        $page_data['page_title'] = 'Flujo de efectivo';
        $this->load->view('backend/index', $page_data);
    }

    function cash_flow_detail($param1 = '', $param2 = '', $param3 = ''){
         $this->session_login();

        $page_data['cash_flow_id'] = base64_decode($param1);
        $page_data['page_name']            = 'cash_flow_detail';
        $page_data['page_title']           = 'Flujo de efectivo';
        $this->load->view('backend/index', $page_data);
    }

    function sales_management($param1 = '', $param2 = '', $param3 = ''){
        $this->session_login();
      
       $page_data['page_name']            = 'sales_management';
       $page_data['page_title']           = 'Punto de ventas';
       $this->load->view('backend/index', $page_data);
   }

    function sales_book($param1 = '', $param2 = '')
    {
         $this->session_login();

        $institution_id = $this->input->post('institution_id');
        $camp = $this->input->post('camp');
        $text = $this->input->post('text');
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-m-01");
        if ($final == '') $final = date("Y-m-t");

        $page_data['institution_id'] = $institution_id;
        $page_data['camp']           = $camp;
        $page_data['text']           = $text;
        $page_data['initial']        = $initial;
        $page_data['final']          = $final;
        $page_data['page_name']      = 'sales_book';
        $page_data['page_title']     = 'Libro de ventas';
        $this->load->view('backend/index', $page_data);
    }
    
    function clients_book()
    {
         $this->session_login();
        
        $visitor_id = $this->input->post('visitor_id');
        $client_id = $this->input->post('client_id');
        $commission = $this->input->post('commission');
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        $ventas = $this->crud_model->getClientsBook();
        $page_data['visitor_id'] = $visitor_id;
        $page_data['client_id']  = $client_id;
        $page_data['commission'] = $commission;
        $page_data['initial']    = $initial;
        $page_data['final']      = $final;
        $page_data['ventas']     = $ventas;
        $page_data['page_name']  = 'clients_book';
        $page_data['page_title'] = 'Libro de Clientes';
        $this->load->view('backend/index', $page_data);
    }
    
    function closing($param1 = '', $param2 = '')
    {
         $this->session_login();

        if ($param1 == 'delete') {
            return $this->crud_model->deleteClosing();
        }

        $type = "year";
        if ($param1 != '') $type = $param1;

        $page_data['type']       = $type;
        $page_data['page_name']  = 'closing';
        $page_data['page_title'] = 'Cierres';
        $this->load->view('backend/index', $page_data);
    }
        
    function closing_departure($param1 = '', $param2 = '')
    {
         $this->session_login();

        if ($param1 == 'create') {
            $this->crud_model->createClosing();
            $this->session->set_flashdata('flash_message', "Partida de cierre creada correctamente");
            redirect(base_url().'admin/closing/', 'refresh');
        }

        $page_data['page_name']  = 'closing_departure';
        $page_data['page_title'] = 'Generar partidas';
        $this->load->view('backend/index', $page_data);
    }
        
    function closing_detail($param1 = '', $param2 = '')
    {
         $this->session_login();

        $page_data['closing_id'] = base64_decode($param1);
        $page_data['page_name']  = 'closing_detail';
        $page_data['page_title'] = 'Detalle de partida';
        $this->load->view('backend/index', $page_data);
    }
        
    function chargeCloseDeparture()
    {
         $this->session_login();

        $category = $this->input->post('category');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $type = $this->input->post('type');
        $initial = ''; $final = '';
        if ($type == 'month') {
            $initial = $year.'-'.$month.'-01';
            $final = $year.'-'.$month.'-'.date('t', strtotime($initial));
        } elseif ($type == 'year') {
            $initial = $year."-01-01";
            $final = $year."-12-31";
        }
        $page_data['initial'] = $initial;
        $page_data['final']   = $final;
        return $this->load->view("backend/departures/closing/$category", $page_data);
    }

    function opening($param1 = '', $param2 = '')
    {
         $this->session_login();

        if ($param1 == 'delete') {
            return $this->crud_model->deleteReopening();
        }

        $page_data['page_name']  = 'opening';
        $page_data['page_title'] = 'Reaperturas';
        $this->load->view('backend/index', $page_data);
    }
        
    function opening_departure($param1 = '', $param2 = '')
    {
         $this->session_login();

        if ($param1 == 'create') {
            $this->crud_model->createReopening();
            $this->session->set_flashdata('flash_message', "Partida de reapertura creada correctamente");
            redirect(base_url().'admin/opening/', 'refresh');
        }

        $page_data['page_name']  = 'opening_departure';
        $page_data['page_title'] = 'Generar partida';
        $this->load->view('backend/index', $page_data);
    }
        
    function chargeOpenDeparture()
    {
         $this->session_login();

        $year = $this->input->post('year');
        $ant = $year - 1;
        $initial = $ant."-01-01";
        $final = $ant."-12-31";
        $page_data['initial'] = $initial;
        $page_data['final']   = $final;
     
        return $this->load->view("backend/departures/opening/departure", $page_data);
    }

    function opening_detail($param1 = '', $param2 = '')
    {
         $this->session_login();

        $page_data['reopening_id'] = base64_decode($param1);
        $page_data['page_name']    = 'opening_detail';
        $page_data['page_title']   = 'Detalle de partida';
        $this->load->view('backend/index', $page_data);
    }
        
    function adjust($param1 = '', $param2 = '')
    {
         $this->session_login();

        if ($param1 == 'delete') {
            return $this->crud_model->deleteAdjust();
        }

        $type = "year";
        if ($param1 != '') $type = $param1;

        $page_data['type']       = $type;
        $page_data['page_name']  = 'adjust';
        $page_data['page_title'] = 'Ajustes';
        $this->load->view('backend/index', $page_data);
    }
        
    function adjust_departure($param1 = '', $param2 = '')
    {
         $this->session_login();

        if ($param1 == 'create') {
            $this->crud_model->createAdjust();
            $this->session->set_flashdata('flash_message', "Partida de cierre creada correctamente");
            redirect(base_url().'admin/adjust/', 'refresh');
        }

        $page_data['page_name']  = 'adjust_departure';
        $page_data['page_title'] = 'Generar partidas';
        $this->load->view('backend/index', $page_data);
    }
        
    function adjust_detail($param1 = '', $param2 = '')
    {
         $this->session_login();

        $page_data['adjust_id'] = base64_decode($param1);
        $page_data['page_name']  = 'adjust_detail';
        $page_data['page_title'] = 'Detalle de partida';
        $this->load->view('backend/index', $page_data);
    }
        
    function chargeAdjustDeparture()
    {
         $this->session_login();

        $category = $this->input->post('category');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $type = $this->input->post('type');
        $initial = ''; $final = '';
        if ($type == 'month') {
            $initial = $year.'-'.$month.'-01';
            $final = $year.'-'.$month.'-'.date('t', strtotime($initial));
        } elseif ($type == 'year') {
            $initial = $year."-01-01";
            $final = $year."-12-31";
        }
        $page_data['initial'] = $initial;
        $page_data['final']   = $final;
        return $this->load->view("backend/departures/adjust/$category", $page_data);
    }
    
    function purchasing($param1 = '', $param2 = '')
    {
         $this->session_login();

        $institution_id = $this->input->post('institution_id');
        $camp = $this->input->post('camp');
        $text = $this->input->post('text');
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-m-01");
        if ($final == '') $final = date("Y-m-t");

        $page_data['institution_id'] = $institution_id;
        $page_data['camp']           = $camp;
        $page_data['text']           = $text;
        $page_data['initial']        = $initial;
        $page_data['final']          = $final;
        $page_data['page_name']      = 'purchasing';
        $page_data['page_title']     = 'Libro de compras';
        $this->load->view('backend/index', $page_data);
    }
        
    function getClientSearchAjax()
    {
         $this->session_login();

        return $this->crud_model->getClientSearchAjax();
    }
    
    function banks($param1 = '', $param2 = '', $param3 = '') {
         $this->session_login();

        if ($param1 == 'new') {
            $this->crud_model->newBank();
            $this->session->set_flashdata('flash_message', "Banco agregado exitosamente");
            redirect(base_url().'admin/banks/', 'refresh');
        }
        if ($param1 == 'edit') {
            $response = $this->crud_model->editBank();
            $this->session->set_flashdata('flash_message', "Banco editado exitosamente");
            redirect(base_url().'admin/banks/', 'refresh');
        }
        if ($param1 == 'deactivate') {
            $response = $this->crud_model->deactivateBank();
            return $response;
        }
        if ($param1 == 'activate') {
            $response = $this->crud_model->activateBank();
            return $response;
        }
        if ($param1 == 'delete') {
            $response = $this->crud_model->deleteBank();
            return $response;
        }
        $page_data['page_name']  = 'banks';
        $page_data['page_title'] = 'Bancos';
        $this->load->view('backend/index', $page_data);
    }

    function bank_accounts($param1 = '', $param2 = '', $param3 = ''){
         $this->session_login();

        if ($param1 == 'new') {
            $this->crud_model->newBankAccount();
            $this->session->set_flashdata('flash_message', "Cuenta bancaria agregada exitosamente");
            redirect(base_url().'admin/bank_accounts/'.$param2, 'refresh');
        }
        if ($param1 == 'edit') {
            $response = $this->crud_model->editBankAccount();
            $this->session->set_flashdata('flash_message', "Cuenta bancaria editada exitosamente");
            redirect(base_url().'admin/bank_accounts/'.$param2, 'refresh');
        }
        if ($param1 == 'deactivate') {
            $response = $this->crud_model->deactivateBankAccount();
            return $response;
        }
        if ($param1 == 'activate') {
            $response = $this->crud_model->activateBankAccount();
            return $response;
        }
        if ($param1 == 'delete') {
            $response = $this->crud_model->deleteBankAccount();
            return $response;
        }

        $property = $param1;
        if ($param1 == '') $property = 1;
        $page_data['property']   = $property;
        $page_data['page_name']  = 'bank_accounts';
        $page_data['page_title'] = 'Cuentas bancarias';
        $this->load->view('backend/index', $page_data);
    }

    function currencies($param1 = '', $param2 = '', $param3 = ''){
         $this->session_login();

        if ($param1 == 'new') {
            $this->crud_model->newCurrency();
            $this->session->set_flashdata('flash_message', "Moneda agregada exitosamente");
            redirect(base_url().'admin/currencies/', 'refresh');
        }
        if ($param1 == 'edit') {
            $this->crud_model->editCurrency();
            $this->session->set_flashdata('flash_message', "Moneda editada exitosamente");
            redirect(base_url().'admin/currencies/', 'refresh');
        }
        if ($param1 == 'deactivate') {
            $response = $this->crud_model->deactivateCurrency();
            return $response;
        }
        if ($param1 == 'activate') {
            $response = $this->crud_model->activateCurrency();
            return $response;
        }
        if ($param1 == 'delete') {
            $response = $this->crud_model->deleteCurrency();
            return $response;
        }
        $page_data['page_name']  = 'currencies';
        $page_data['page_title'] = 'Monedas';
        $this->load->view('backend/index', $page_data);
    }

    function bank_checks($param1 = '', $param2 = '', $param3 = ''){
         $this->session_login();

        if ($param1 == 'new') {
            $this->crud_model->newBankCheck();
            $this->session->set_flashdata('flash_message', "Cheque bancario agregado exitosamente");
            redirect(base_url().'admin/bank_checks/', 'refresh');
        }
        if ($param1 == 'edit') {
            $this->crud_model->editBankCheck();
            $this->session->set_flashdata('flash_message', "Cheque bancario editado exitosamente");
            redirect(base_url().'admin/bank_checks/', 'refresh');
        }
        if ($param1 == 'deactivate') {
            $response = $this->crud_model->deactivateBankCheck();
            return $response;
        }
        if ($param1 == 'activate') {
            $response = $this->crud_model->activateBankCheck();
            return $response;
        }
        if ($param1 == 'delete') {
            $response = $this->crud_model->deleteBankCheck();
            return $response;
        }
        if ($param1 == 'cancel') {
            $response = $this->crud_model->anulateBankCheck();
            return $response;
        }

        $account_id = $this->input->post('account_id');
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if($initial == '') $initial = date("Y-m-01");
        if($final == '') $final = date("Y-m-t");

        $page_data['account_id'] = $account_id;
        $page_data['initial']    = $initial;
        $page_data['final']      = $final;
        $page_data['page_name']  = 'bank_checks';
        $page_data['page_title'] = 'Cheques Bancarios';
        $this->load->view('backend/index', $page_data);
    }
    
    function bank_transfers($param1 = '', $param2 = '', $param3 = '')
    {
         $this->session_login();

        if ($param1 == 'new') {
            $this->crud_model->newTransfer();
            $this->session->set_flashdata('flash_message', "Transferencia realizada exitosamente");
            redirect(base_url().'admin/bank_transfers/', 'refresh');
        }

        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($initial == '') $initial = date("Y-m-01");
        if ($final == '') $final = date("Y-m-t");
        $account_id = $this->input->post('account_id');

        $page_data['account_id'] = $account_id;
        $page_data['initial']    = $initial;
        $page_data['final']      = $final;
        $page_data['page_name']  = 'bank_transfers';
        $page_data['page_title'] = 'Transferencias entre cuentas';
        $this->load->view('backend/index', $page_data);
    }
     
    function account_types($param1 = '', $param2 = '', $param3 = ''){
         $this->session_login();

        if ($param1 == 'new') {
            $this->crud_model->newAccountType();
            $this->session->set_flashdata('flash_message', "Tipo de cuenta agregado exitosamente");
            redirect(base_url().'admin/account_types/', 'refresh');
        }
        if ($param1 == 'edit') {
            $this->crud_model->editAccountType();
            $this->session->set_flashdata('flash_message', "Tipo de cuenta editada exitosamente");
            redirect(base_url().'admin/account_types/', 'refresh');
        }
        if ($param1 == 'deactivate') {
            $response = $this->crud_model->deactivateAccountType();
            return $response;
        }
        if ($param1 == 'activate') {
            $response = $this->crud_model->activateAccountType();
            return $response;
        }
        if ($param1 == 'delete') {
            $response = $this->crud_model->deleteAccountType();
            return $response;
        }
        $page_data['page_name']  = 'account_types';
        $page_data['page_title'] = 'Tipos de Cuentas';
        $this->load->view('backend/index', $page_data);
    }
   
    function searchAccounByNomen()
    {
        $id = $this->input->post('id');
        $count = $this->crud_model->countAccountByNomen($id);
        echo $count;
    }

    function searchAccounByNomenExist()
    {
        $id = $this->input->post('id');
        $nom_id = $this->input->post('nom_id');
        $count = $this->crud_model->countAccountByNomenExist($nom_id, $id);
        echo $count;
    }

    function setChecksBankBook() {
        $this->session_login();

        return $this->crud_model->setChecksBankBook();
    }
        
    function setChecksPurchase() {
        $this->session_login();

        return $this->crud_model->setChecksPurchase();
    }

    function setChecksSales() {
        $this->session_login();

        return $this->crud_model->setChecksSales();
    }

    function setChecksClients() {
        $this->session_login();

        return $this->crud_model->setChecksClients();
    }

    function setChecksGeneral() {
        $this->session_login();

        return $this->crud_model->setChecksGeneral();
    }

    function setChecksStatement() {
        $this->session_login();

        return $this->crud_model->setChecksStatement();
    }

    function verifyNoCheck()
    {
         $this->session_login();

        return $this->crud_model->verifyNoCheck();
    }
    
    function verifyNoCheckEdit()
    {
         $this->session_login();

        return $this->crud_model->verifyNoCheckEdit();
    }

    function searchNomenclatureSelect()
    {
         $this->session_login();

        return $this->crud_model->searchNomenclatureSelect();
    }
    
    function printPDF($param1 = '', $param2 = '')
    {
         $this->session_login();

        if ($param1 == 'import') {
            return $this->crud_model->printImportPDF($param2);
        }
        if ($param1 == 'policy') {
            return $this->crud_model->printPolicyPDF();
        }
        if ($param1 == 'check') {
            return $this->crud_model->printBankCheckPDF($param2);
        }
        if ($param1 == 'issue') {
            return $this->crud_model->printIssuePDF($param2);
        }
        if ($param1 == 'issue_note') {
            return $this->crud_model->printIssueNotePDF($param2);
        }
    }
    
    function printFormType($param1 = '', $param2 = '')
    {
         $this->session_login();

        $type = $this->input->post('type');
        if ($param1 == 'general') {
            if ($type == 'PDF') {
                return $this->crud_model->printGeneralPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printGeneralExcel();
            }
        }
        if ($param1 == 'statement') {
            if ($type == 'PDF') {
                return $this->crud_model->printStatementPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printStatementExcel();
            }
        }
        if ($param1 == 'cash_flow') {
            if ($type == 'PDF') {
                return $this->crud_model->printCashFlowPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printCashFlowExcel();
            }
        }
        if ($param1 == 'conciliation') {
            if ($type == 'PDF') {
                return $this->crud_model->printConciliationPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printConciliationExcel();
            }
        }
        if ($param1 == 'purchasing') {
            if ($type == 'PDF') {
                return $this->crud_model->printPurchasingPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printPurchasingExcel();
            }
        }
        if ($param1 == 'sales_book') {
            if ($type == 'PDF') {
                return $this->crud_model->printSalesBookPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printSalesBookExcel();
            }
        }
        if ($param1 == 'report_sales') {
            if ($type == 'PDF') {
                return $this->crud_model->printReportSalesPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printReportSalesExcel();
            }
        }
        if ($param1 == 'report_kardex') {
            if ($type == 'PDF') {
                return $this->crud_model->printReportKardexPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printReportKardexExcel();
            }
        }
        if ($param1 == 'report_charges') {
            if ($type == 'PDF') {
                return $this->crud_model->printReportChargesPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printReportChargesExcel();
            }
        }
        if ($param1 == 'report_stock') {
            if ($type == 'PDF') {
                return $this->crud_model->printReportStockPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printReportStockExcel();
            }
        }
        if ($param1 == 'report_expense') {
            if ($type == 'PDF') {
                return $this->crud_model->printReportExpensePDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printReportExpenseExcel();
            }
        }
        if ($param1 == 'clients_book') {
            if ($type == 'PDF') {
                return $this->crud_model->printClientsBookPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printClientsBookExcel();
            }
        }
        if ($param1 == 'journal') {
            if ($type == 'PDF') {
                return $this->crud_model->printJournalPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printJournalExcel();
            } elseif ($type == 'PDFC') {
                return $this->crud_model->printJournalPDFC();
            } elseif ($type == 'EXCELC') {
                return $this->crud_model->printJournalExcelGroup();
            }
        }
        if ($param1 == 'ledger') {
            if ($type == 'PDF') {
                return $this->crud_model->printLedgerPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printLedgerExcel();
            } elseif ($type == 'PDFC') {
                return $this->crud_model->printLedgerPDFC();
            } elseif ($type == 'EXCELC') {
                return $this->crud_model->printLedgerExcelC();
            }
        }
        if ($param1 == 'bank_book') {
            if ($type == 'PDF') {
                return $this->crud_model->printBankBookPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printBankBookExcel();
            }
        }
        if ($param1 == 'balances') {
            if ($type == 'PDF') {
                return $this->crud_model->printBalancesPDF();
            } elseif ($type == 'EXCEL') {
                return $this->crud_model->printBalancesExcel();
            }
        }
    }
    
    function getOtherBankAccounts()
    {
         $this->session_login();

        return $this->crud_model->getOtherBankAccounts();
    }

    function checkBalanceBankAccount()
    {
         $this->session_login();

        return $this->crud_model->checkBalanceBankAccount();
    }
    
    function get_municipio($departamento_id)
    {
        $sections = $this->db->get_where('municipio' , array('departamento_id' => $departamento_id))->result_array();
        echo '<option value="">Seleccionar</option>';
        foreach ($sections as $row) 
        {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }

    
    //Fin de contabilidad

    /////////////////////////////////// typehead //////////////////////////////////



public function openSelect()
{
    
    $table = $this->input->post('table');
    $field = $this->input->post('field');

        $html .=' <tr class="newOption "   >
                        <td style="border:1px solid #dee2e6;">
                            <input  onFocus="getValues(\''.$table.'\',this.value,\''.$field.'\')" onKeyUp="getValues(\''.$table.'\',this.value,\''.$field.'\')"  type="text" id="'.$field.'_new" class="form-control type" placeholder="Buscar/Agregar nuevo elemento"/>
                        </td>
                        <td style="border:1px solid #dee2e6;"><a style="cursor:pointer" onclick="addValue(\''.$table.'\',\''.$field.'\')" herf="javascript:void(0)"><i class="icon"><i class="picons-thin-icon-thin-0151_plus_add_new"></i></i></a></td>
                    </tr> ';
    
    echo $html;
    exit();

}


public function getValues()
{
    
        $name = $this->input->post('name');
        $table = $this->input->post('table');
        $field = $this->input->post('field');
        
        if($this->db->table_exists( $table))
        {
            if($name == "" )
            {
                $this->db->limit(5);
            }
            $values = $this->db->like('name', $name,'BOTH')->get_where($table, array('status'=>1));
            if($values->num_rows() > 0){
    
                
                foreach ($values->result_array() as $row) {
                    $html .='<tr class="option " >
                                <td    style="border:1px solid #dee2e6;cursor:pointer" onclick="selectValue(\''.$table.'\',\''.$row['id'].'\',\''.$row['name'].'\',\''.$field.'\')">
                                    <b> '.$row['name'].' </b> 
                                </td>
                                <td style="border:1px solid #dee2e6;cursor:pointer" onclick="deleteValue(\''.$table.'\',this)" herf="javascript:void(0)" data-id="'.$row['id'].'" ><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></td>
                            </tr>';
                }
             
                
            }else
            {
                $html ='<tr class="option " >
                        <td    style="cursor:pointer" >
                            <b> No hay datos registrados </b> 
                        </td>
                    </tr>';
    
            }
    
           
        }else
        {
            $html ='<tr class="option " >
                    <td    style="cursor:pointer" >
                        <b> No existe la tabla '.$table.' </b> 
                    </td>
                </tr>';

        }
        
        echo $html;
        exit();

}

public function addValue()
{

    $name = $this->input->post('name');
    $table = $this->input->post('table');

    $data['name']=$name;
    $this->db->insert($table,$data);

    echo $this->db->insert_id();
    exit();
}

public function deleteValue()
{

    $id = $this->input->post('id');
    $table = $this->input->post('table');
   
    $data['status']=0;
    $this->db->where('id',$id);
    $this->db->update($table,$data);
    exit();
}

function getClientJson()
{
    $this->session_login();

    if ($this->session->userdata('login_user_type') == 2)
    {
        redirect(base_url(), 'refresh');
    }
    return $this->crud_model->getClientJson();
}

function whatsapp_test($param1 = "")
{
       echo $this->whatsapp->whatsapp_test('agendar',1);
      
}


function email_test($param1 = "")
{
       echo $this->email_model->send_test_email('angcorado4@gmail.com','prueba de emails','Prueba de envio de correos electrónicos');
      
}

function whatsapp($param1 = "")
{
    $this->session_login();

    if($param1 == 'send')
    {
        print_r($this->input->post());
        exit();
        $this->whatsapp->sendWhatsapp();
        $this->whatsapp->sendAllWhatsapp();
        $this->session->set_flashdata('flash_message' , "Mensaje enviado correctamente.");
        $refer =  $this->agent->referrer();
        redirect($refer, 'refresh');

    }
    $page_data['page_name']  = 'whatsapp';
    $page_data['page_title'] = "Whatsapp";
    $this->load->view('backend/index', $page_data);

}

function send_email($param1 = "")
{
    $this->session_login();

    if($param1 == 'send')
    {
        $this->email_model->sendEmail();
        $this->session->set_flashdata('flash_message' , "Mensaje enviado correctamente.");
        $refer =  $this->agent->referrer();
        redirect($refer, 'refresh');

    }
    $page_data['page_name']  = 'send_email';
    $page_data['page_title'] = "Enviar email";
    $this->load->view('backend/index', $page_data);

}

function whatsapp_notifications($param1 = "",$param2 = "")
{
    $this->session_login();
    
    if($param1 == 'update')
    {
       $data = array(
            'message'=>$this->input->post('message'),
       );

       $this->db->where('type',$param2);
       $this->db->update('whatsapp_notification',$data);

        $this->session->set_flashdata('flash_message' , "Mensaje enviado correctamente.");
        $refer =  $this->agent->referrer();
        redirect($refer, 'refresh');

    }


    $page_data['page_name']  = 'whatsapp_notifications';
    $page_data['page_title'] = "Whatsapp";
    $this->load->view('backend/index', $page_data);

}


function getPatientsWhatsapp()
{
    $options='';
    if($this->input->post('insurance_id') == 0){
        $this->db->select("*");  
        $this->db->order_by('first_name', 'ASC');
        $this->db->from("patient");
        $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        $this->db->where('status !=', 0);
        $patients = $this->db->get()->result_array();  
    }else
    {
        $this->db->select("*");  
        $this->db->from('insurance_patients ip');
        $this->db->join('patient p', 'ip.patient_id = p.patient_id');
        $this->db->where('ip.insurance_id', $this->input->post('insurance_id'));
        $this->db->where('p.status', 1);
        $patients = $this->db->get()->result_array();  
    }
        
    if(count($patients) > 0)
    {$options .= '<option value="0">Todos</option>';
       foreach ($patients as $row) 
       {   
           $options .= '<option value="' . $row['patient_id'] . '">' .$this->accounts_model->get_full_name('patient', $row['patient_id']). '</option>';
        }

    }else
    {
       $options .= '<option value="">Sin pacientes</option>';
    }
   
   echo $options;
    exit();

}

function getPatientsWhatsappEntity()
{
    $options='';
    if($this->input->post('entity_id') == 0){
        $this->db->select("*");  
        $this->db->order_by('first_name', 'ASC');
        $this->db->group_by("first_name");
        $this->db->from("patient p");
        $this->db->join("entity_patients ep", "ep.patient_id = p.patient_id");
        $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        $this->db->where('status !=', 0);
        $patients = $this->db->get()->result_array();  
    }else
    {
        $this->db->select("*");  
        $this->db->from('entity_patients ip');
        $this->db->join('patient p', 'ip.patient_id = p.patient_id');
        $this->db->where('ip.entity_id', $this->input->post('entity_id'));
        $this->db->where('p.status', 1);
        $patients = $this->db->get()->result_array();  
    }
        
    if(count($patients) > 0)
    {$options .= '<option value="0">Todos</option>';
       foreach ($patients as $row) 
       {   
           $options .= '<option value="' . $row['patient_id'] . '">' .$this->accounts_model->get_full_name('patient', $row['patient_id']). '</option>';
        }

    }else
    {
       $options .= '<option value="">Sin pacientes</option>';
    }
   
   echo $options;
    exit();

}


function getStaffWhatsapp()
{
    $options='';
   
    if($this->input->post('category_id') == '0'){

        $admin = $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'"')->result_array();
        $staff = $this->db->query('SELECT * FROM staff WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'"')->result_array();
        if(count($staff) > 0 && count($admin) > 0)
        {
            $options .= '<option value="0">Todos</option>';
           foreach ($staff as $row) 
           {   
               $options .= '<option value="staff_' . $row['staff_id'] . '">' .$this->accounts_model->get_full_name('staff', $row['staff_id']). '</option>';
            }
            foreach ($admin as $row) 
            {   
               $options .= '<option value="admin_' . $row['admin_id'] . '">' .$this->accounts_model->get_full_name('admin', $row['admin_id']). '</option>';
            }
        }else
        {
           $options .= '<option value="">Sin usuarios</option>';
        }

    }else
    {
       
        if($this->input->post('category_id') == 'admin'){
          
            $admin = $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'" and owner = 1')->result_array();
        
            if( count($admin) > 0)
            {
                $options .= '<option value="0">Todos</option>';
               
                foreach ($admin as $row) 
                {   
                    $options .= '<option value="admin_' . $row['admin_id'] . '">' .$this->accounts_model->get_full_name('admin', $row['admin_id']). '</option>';
                }

            }else
            {
            $options .= '<option value="">Sin usuarios</option>';
            }


        }else  if($this->input->post('category_id') == 'docs'){
    
            $admin = $this->db->query('SELECT * FROM admin WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'" and owner = 0')->result_array();
            if( count($admin) > 0)
            {
                $options .= '<option value="0">Todos</option>';
               
                foreach ($admin as $row) 
                {   
                    $options .= '<option value="admin_' . $row['admin_id'] . '">' .$this->accounts_model->get_full_name('admin', $row['admin_id']). '</option>';
                }

            }else
            {
            $options .= '<option value="">Sin usuarios</option>';
            }

        }else 
        {
            $staff = $this->db->query('SELECT * FROM staff WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'" and category ='.$this->input->post('category_id'))->result_array();
            if( count($staff) > 0)
            {
                $options .= '<option value="0">Todos</option>';
               
                foreach ($staff as $row) 
                {   
                    $options .= '<option value="staff_' . $row['staff_id'] . '">' .$this->accounts_model->get_full_name('staff', $row['staff_id']). '</option>';
                }

            }else
            {
                    $options .= '<option value="">Sin usuarios</option>';
            }
        }

    }
   
   echo $options;
    exit();

}

function test()
{
   
    header("Content-disposition: attachment; filename=http://5.161.43.192/apiserver/apiservice.php");
    header("Content-type: application/octet-stream");
    readfile("http://5.161.43.192/apiserver/apiservice.php");
    exit;

}


function factura()
{
    $this->pdf_model->pdf('Facturas Mayan source','fac_mayan.php',$data);
}

function service_details($param1 = '', $param2 = '')
  {
     $this->session_login();
      if($param1 == "save")
      {
          
        $patient_service_id =   $this->input->post('patient_service_id');
        $md5 = md5(date('d-m-y H:i:s'));
           log_message('error',json_encode($this->input->post())); 
           $uploadPath = 'public/uploads/patient_files/';
           log_message( 'error',json_encode($_FILES['attachments']));
             log_message( 'error',json_encode($_FILES['inform']));
           $files_array = $_FILES['attachments'];
             foreach ($files_array['name'] as $index => $filename) {
                 
               // Permitimos solo unas extensiones
                $fileName = basename($files_array['name'][$index]); 
                $imageUploadPath = $uploadPath . $md5.str_replace(' ', '', $files_array['name'][$index]); 
                $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION); 
               
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType, $allowTypes)){ 
                    // Image temp source 
                    $imageTemp = $files_array['tmp_name'][$index]; 
                     
                    // Comprimos el fichero
                    $compressedImage = $this->crud_model->compressImage($imageTemp, $imageUploadPath, 75); 
                     
                    if($compressedImage){ 
                          
                          log_message('error','compress '.$compressedImage);
                        $data['patient_service_id'] = $patient_service_id;
                        $data['name'] = $files_array['name'][$index];
                        $data['file'] = $md5.str_replace(' ', '', $files_array['name'][$index]);
                        
                        $this->db->insert('patient_service_file',$data);
                          
                    }else{ 
                        
                       log_message('error','Error al subir la imagen');
                    } 
                }else{ 
                    
                    log_message('error','Lo sentimos, solo se permiten imagenes con estas extensiones: JPG, JPEG, PNG, & GIF.');
                } 
            }
            
            
            if($_FILES['inform']['name'] != ''){
                
                $dataService['report'] = $md5.str_replace(' ', '', $_FILES['inform']['name']);
                $dataService['status'] = 2;
                move_uploaded_file($_FILES['inform']['tmp_name'], 'public/uploads/patient_files/' .  $md5.str_replace(' ', '', $_FILES['inform']['name']));
                
                $this->db->where('patient_service_id',$patient_service_id);
                $this->db->update('patient_service',$dataService);
            }
            
        
            
            
           
              
                
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
      }
      
      
      $page_data['ID'] = $param1;
      $page_data['page_name']  = 'service_details';
      $page_data['page_title'] = "Resultados";
      $this->load->view('backend/index', $page_data);
  }
  
  function price_atenun()
  {
      $products = $this->db->get_where('product',array('status'=>1))->result_array();
      $cont = 0;
      foreach($products as $pr)
      {
          $exist = $this->db->get_where('product_price',array('product_id'=>$pr['product_id'],'insurance_id'=>0))->num_rows();
          if($exist > 0)
          {
              $data['price'] = $pr['price_1'];
              
              $this->db->where('product_id',$pr['product_id']);
              $this->db->where('insurance_id',0);
              
              $this->db->update('product_price',$data);
              
              echo 'No. '.$cont++.' Product_id: '.$pr['product_id'].' Price atenun: '.$pr['price_1'].'<br>';
          }else
          {
             if($pr['price_1'] == '')
             $price = 0;
             else
             $price = $pr['price_1'];
             
            $data['price'] = $price; 
            $data['product_id'] = $pr['product_id'];
            $data['insurance_id'] = 0;
            $data['clinic_id'] = 1;
              
            $this->db->insert('product_price',$data);
              
            echo 'No. '.$cont++.' Product_id: '.$pr['product_id'].' Price atenun: '.$price.'<br>';
              
          }
      }
  }
  
    function import_nomenclature()
    {
        $this->load->library('PHPExcel'); 
        $path = 'nomenclatura atenun.xlsx' ;
        $object = PHPExcel_IOFactory::load($path);
        foreach($object->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
           
            for($row=7; $row <= 881; $row++)
            {
                $data = array(
                    'code'  => trim($worksheet->getCellByColumnAndRow(0, $row)->getValue()),
                    'name'  => trim($worksheet->getCellByColumnAndRow(1, $row)->getValue()),
                    'da'    => trim($worksheet->getCellByColumnAndRow(6, $row)->getValue()),
                    'pd'    => trim($worksheet->getCellByColumnAndRow(7, $row)->getValue()),
                    'caja'  => trim($worksheet->getCellByColumnAndRow(8, $row)->getValue()),
                    'level' => trim($worksheet->getCellByColumnAndRow(9, $row)->getValue()),
                );
                $this->db->insert('nomenclature',$data);
            }
        }
        redirect(base_url().'admin/panel', 'refresh');
    }
    
    
    function nomenclature_balance()
    {
        $this->load->library('PHPExcel'); 
        $path = 'Nomenclatura de Balance General.xlsx' ;
        $object = PHPExcel_IOFactory::load($path);
        foreach($object->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
           
            for($row=1; $row <= 131; $row++)
            {
                $code = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
                $data['balance'] = 1;
                $this->db->where('code', $code);
                $this->db->where('status', 1);
                $this->db->update('nomenclature',$data);
            }
        }
        redirect(base_url().'admin/panel', 'refresh');
    }
    
    
    function nomenclature_statement()
    {
        $this->load->library('PHPExcel'); 
        $path = 'Nomenclatura de Estado de Resultados.xlsx' ;
        $object = PHPExcel_IOFactory::load($path);
        foreach($object->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
           
            for($row=1; $row <= 94; $row++)
            {
                $code = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
                $data['statement'] = 1;
                $this->db->where('code', $code);
                $this->db->where('status', 1);
                $this->db->update('nomenclature',$data);
            }
        }
        redirect(base_url().'admin/panel', 'refresh');
    }
    
    function patient_service_add($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['category_id']  = $param1;
        $page_data['page_name']  = 'patient_service_add';
        $page_data['page_title'] = "Recepción de estudios";
        $this->load->view('backend/index', $page_data);
    }
    
    
    
      function product_extra($param1 = '', $param2 = '')
    {
        $this->session_login();
        
        if($param1 == 'add_product_extra')
        {
            $this->inventory_model->add_product_extra();
            exit();
        }

        
        if($param1 == 'delete')
        {
            $this->crud_model->delete_solicitud($param2);
            exit();
            
        }
        
    }
    
    
        function clients($param1 = '', $param2="")
    {
         if($param1 == 'create')
        {
            $patient_id = $this->accounts_model->create_client();
            $this->session->set_flashdata('flash_message' , "Cliente agregado correctamente.");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }
        if($param1 == 'update')
        {
            $this->accounts_model->update_patient($param2);
            $this->session->set_flashdata('flash_message' , "Paciente actualizado correctamente.");
           
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
           
        }
        
        if($param1 == 'delete')
        {
            $this->log_model->delete_patient($param2);
            $this->accounts_model->delete_patient($param2,true);
            $this->session->set_flashdata('flash_message' , "Cliente eliminado correctamente.");
            $refer =  $this->agent->referrer();
            redirect($refer, 'refresh');
        }

        
        
        $page_data['insurance_id']= 0;
        $page_data['page_name']   = 'clients';
        $page_data['page_title']  = "Clientes";
        $this->load->view('backend/index', $page_data);
    }

    //Datos de Miguel
    function entity($param1 = '', $param2 = '', $param3 = '') 
    {
         $this->session_login();
        
        if ($param1 == 'new') {
            $this->accounts_model->new_entity($param2);
            $this->session->set_flashdata('flash_message' , "Entidad Registrada correctamente.");
            redirect(base_url().'admin/patients', 'refresh');
        }

        if ($param1 == 'edit') {
            
            $this->accounts_model->edit_entity($param2);
            $this->session->set_flashdata('flash_message' , "Entidad actualizada correctamente.");
            redirect(base_url().'admin/entity/'.base64_encode($param3), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->accounts_model->delete_entity($param2);
            $this->session->set_flashdata('flash_message' , "Entidad Eliminada correctamente.");
            redirect(base_url().'admin/entity/'.base64_encode($param3), 'refresh');
        }
        if($param1 != "")
        {
            $page_data['id_category'] = base64_decode($param1);
            $page_data['page_name']   = 'entity';
            $page_data['page_title']  = "Entidad";
            $this->load->view('backend/index', $page_data);
        }
        else 
        redirect(base_url().'admin/patients', 'refresh');
    }

    function entity_new ($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['type']        = base64_decode($param1);
        $page_data['page_name']   = 'entity_new';
        $page_data['page_title']  = "Nueva Entidad";
        $this->load->view('backend/index', $page_data);
    }
    function entity_edit ($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['type']        = base64_decode($param1);
        $page_data['category']        = base64_decode($param2);
        $page_data['page_name']   = 'entity_edit';
        $page_data['page_title']  = "Editar Entidad";
        $this->load->view('backend/index', $page_data);
    }

    function entity_category($param1 = "", $param2 = ""){
        $this->session_login();
        if($param1 == "create")
        {
            $new_id =  $this->accounts_model->entity_category_add();
            $this->session->set_flashdata('flash_message' , "Categoría agregada correctamente.");
            redirect(base_url().'admin/entity_maintenance/', 'refresh');
        }
        if($param1 == "delete")
        {
            $this->accounts_model->entity_category_delete($param2);
            $this->session->set_flashdata('flash_message' , "Categoría eliminada correctamente.");
            redirect(base_url().'admin/entity_maintenance/', 'refresh');
        }
        if($param1 == "update")
        {
            $this->accounts_model->entity_category_update($param2);
            $this->session->set_flashdata('flash_message' , "Categoría actualizada correctamente.");
            redirect(base_url().'admin/entity_maintenance/', 'refresh');
        }

        $page_data['type']        = $param1;
        $page_data['page_name']   = 'entity_new';
        $page_data['page_title']  = "Nueva Entidad";
        $this->load->view('backend/index', $page_data);
    }

    function entity_maintenance($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['type']        = $param1;
        $page_data['page_name']   = 'entity_maintenance';
        $page_data['page_title']  = "Entidades";
        $this->load->view('backend/index', $page_data);
    }

    function entity_list($param1 = '', $param2 = '')
    {
        $this->session_login();
        $page_data['entity_id']        = $param1;
        $page_data['page_name']   = 'entity_list';
        $page_data['page_title']  = "Listado";
        $this->load->view('backend/index', $page_data);
    }

    function update_patient_copies() {
    
    
        $tables = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME != 'patient' AND COLUMN_NAME LIKE '%patient_id%' AND TABLE_SCHEMA = 'atenun_system'")->result_array();
        foreach($tables as $tb)
        {
            echo $tb['TABLE_NAME'].'<br>';
          
            $data= array('patient_id'=>1380);
            $this->db->where('patient_id',620);
            $this->db->update($tb['TABLE_NAME'],$data);
          
            $data= array('patient_id'=>644);
            $this->db->where('patient_id',643);
            $this->db->update($tb['TABLE_NAME'],$data);
  
            $data= array('patient_id'=>644);
            $this->db->where('patient_id',642);
            $this->db->update($tb['TABLE_NAME'],$data);
            $data= array('patient_id'=>644);
            $this->db->where('patient_id',641);
            $this->db->update($tb['TABLE_NAME'],$data);
            $data= array('patient_id'=>644);
            $this->db->where('patient_id',642);
            $this->db->update($tb['TABLE_NAME'],$data);
            $data= array('patient_id'=>644);
            $this->db->where('patient_id',640);
            $this->db->update($tb['TABLE_NAME'],$data);
            $data= array('patient_id'=>644);
            $this->db->where('patient_id',639);
            $this->db->update($tb['TABLE_NAME'],$data);
            $this->db->where('patient_id',453);
            $this->db->update($tb['TABLE_NAME'],$data);
  
          }
          
  
          $this->db->where('patient_id',620);
          $this->db->delete('patient');    
          $this->db->where('patient_id',643);
          $this->db->delete('patient');    
          $this->db->where('patient_id',642);
          $this->db->delete('patient');    
          $this->db->where('patient_id',641);
          $this->db->delete('patient');    
          $this->db->where('patient_id',640);
          $this->db->delete('patient');   
          $this->db->where('patient_id',639);
          $this->db->delete('patient'); 
          $this->db->where('patient_id',453);
          $this->db->delete('patient'); 
          
      }


    
////////////////////////////////////////////////////////////////
}