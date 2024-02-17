<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appointment_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
    
    function get_now($clinic_id)
    {
        $this->db->order_by('appointment_id','asc');
        $this->db->where('clinic_id',$clinic_id);
        $appointments = $this->db->get_where('appointment', array('status'=>1))->result_array();
        return $appointments;
    }
    
    function get_now_doctor($clinic_id, $doctor_id)
    {
        $this->db->order_by('appointment_id','asc');
        $this->db->where('doctor_id',$doctor_id);
        $this->db->where('clinic_id',$clinic_id);
        $this->db->where('status !=',4);
        $this->db->where('status !=',10);
        $appointments = $this->db->get('appointment')->result_array();
        return $appointments;
    }
    
    function get_aptms_doctor($clinic_id, $doctor_id)
    {
        $this->db->order_by('appointment_id','asc');
        $this->db->where('clinic_id',$clinic_id);
        $this->db->where('doctor_id',$doctor_id);
        $this->db->where('status !=',4);
        $this->db->where('status !=',10);
        $appointments = $this->db->get('appointment')->result_array();
        return $appointments;
    }
    
    function getTitle($appointment_id, $status){
        $title = '';
        
            $practice = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
            $title    = $practice;

        return $title;
    }
    
    function finish_appointment($ID)
    {

        $data['status']               = 10;
        $this->db->where('appointment_id', base64_decode($ID));
        $this->db->update('appointment', $data);

    }
    
    function calendar_start_date($date, $time)
    {
        $received = explode('/',$date);
        $received_day    = $received[0];
  
        $received_month  = $received[1];
   
        $received_year   = $received[2];
        $return_date = $received_year."-".$received_month."-".$received_day."T".$time.":00-06:00";
        return $return_date;
    }
    
    function calendar_end_date($date, $time)
    {
        $interval        = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->time_interval;
        $ex_time         = explode(':', $time);
        $hour            = $ex_time[0];
        $other = '';
        $new_hora        = '';
        
        $temp = 0;
        if($hour < 10){
            $new_hora = str_replace("0","", $hour);
        }else{
            $new_hora = $hour;
        }
        $minutes = 0;
        $mins         = $ex_time[1]+$interval;
        if($mins >= 60)
        {
            $other = $new_hora+1;
            $temp=$mins-60;
            
            if($temp == 0 )
            {
                
                 $minutes = $temp.'0';
                
            }else
            {
                
                 $minutes = $temp;
                
            }
           
        }else{
            $minutes = $mins;
            $other = $new_hora;
        }
        $received        = explode('/',$date);
        $received_day    = $received[0];
     
        $received_month  = $received[1];
    
        $received_year   = $received[2];
        if($other < 10){
            $return_date = $received_year."-".$received_month."-".$received_day."T0".$other.":".$minutes.":00-06:00";   
        }else{
            $return_date = $received_year."-".$received_month."-".$received_day."T".$other.":".$minutes.":00-06:00";
        }
        return $return_date;
    }
    
    
    
    function start_appointment($appointment_id)
    {
        $data['start_status'] = 1;
        $this->db->where('appointment_id', $appointment_id);
        $this->db->update('appointment', $data);
    }
    
    function get_status($status)
    {
        $return = '';
        if($status == 0)
        {
            $return = 'fc-event-warning fc-event-solid-pending';
        }
        else if($status == 1){
            $return = 'fc-event-warning fc-event-solid-pending';
        }
        else if($status == 2){
            $return = 'fc-event-warning fc-event-solid-cancelled';
        }
        else if($status == 3){
            $return = 'fc-event-warning fc-event-solid-repro';
        }else if($status == 5){
            $return = 'fc-event-danger fc-event-solid-warning';
        }else {
            $return = 'bg-pending';
        }
        return $return;
    }

    function create_stabilitation()
    {

        $treatment_id = '';

        $post_date   = explode('/',date('d/m/Y'));
        $order_day   = $post_date[0];
        $order_month = $post_date[1];
        $order_year  = $post_date[2];
        if($order_day <= 9){
            $order_day = "0".$order_day;
        }
        if($order_month <= 9){
            $order_month = "0".$order_month;
        }
        $order_date = $order_year."-".$order_month."-".$order_day." ".$this->input->post('radio').":00";
        $data['patient_id']    = $this->input->post('patient_id');      
        $data['order_date']    = $order_date;
        $data['user_id']       = $this->input->post('doctor_id');
        $data['user_type']     = "admin";
        //$data['doctor_id']     = $this->input->post('doctor_id');
        //$data['staff_id']      = $this->input->post('staff_id');
        $data['room_id']       = $this->input->post('room_id');
        $data['practice']      = 0;
        $data['date']          = $this->input->post('entry_date');
        $data['comment']       = $this->input->post('comment');
        $data['time']          = $this->input->post('entry_time');
        $data['clinic_id']     = $this->session->userdata('current_clinic');
        $data['treatment_id']  = $treatment_id;
        $data['system_date']   = $this->crud_model->formatDate();
        $date = explode('/',date('d/m/Y'));
        $day = $date[0];
        $month = $date[1];
        $year = $date[2];
        
        $data['day']         = $day;
        $data['month']       = $month;
        $data['year']        = $year;
        $data['status']        = 0;

        $this->db->insert('stabilitation_ref', $data);
        $stabilitaion_id = $this->db->insert_id(); 
        
        $data3['patient_id']  = $this->input->post('patient_id');
        $data3['doctor_id']    = $this->input->post('doctor_id');
        $data3['staff_id']    = $this->input->post('staff_id');
        $data3['date']   = $this->input->post('entry_date');
        $data3['hour_start']   = $this->input->post('entry_time');
        $data3['stabilitation_ref_id']  =  $stabilitaion_id;
        $data3['status']        = 1;
        $data3['room_id']       = $this->input->post('room_id');
        $this->db->insert('stabilitation', $data3);
        

    }

    function finish_stabilitation($stabilitaion_id)
    {
        
        $this->db->where('stabilitation_ref_id',$this->input->post('stabilitation_id'));
        $this->db->where('status',0);  
        $this->db->update('stabilitation',array('status'=>1,'hour_end'=>date('H:i')));
        
        
        $data3['patient_id']  = $this->input->post('patient_id');
        $data3['doctor_id']    = $this->input->post('doctor_id');
        $data3['staff_id']    = $this->input->post('staff_id');
        $data3['date']   = $this->input->post('entry_date');
        $data3['hour_start']   = $this->input->post('entry_time');
        $data3['room_id']   = $this->input->post('room_id');
        $data3['status']        = 0;
        $data3['stabilitation_ref_id']  =  $this->input->post('stabilitation_id');

        $this->db->insert('stabilitation', $data3);
        
        return $app_id;
    }

    function end_stabilitation($stabilitaion_id)
    {
        $patient = $this->db->get_where('stabilitation_ref', array('stabilitation_ref_id'=>$stabilitaion_id))->row()->patient_id;
      
        $data4['appointment_id']  = $stabilitaion_id;
        $data4['patient_id']   =   $patient;
        $data4['patient_name']   =    $this->accounts_model->get_name('patient',$patient);
        $data4['description'] = 'Finalizacion de encamamiento';
        $data4['amount']      =  $this->input->post('total_appointment');
        $data4['method']      =1;
        $data4['clinic_id']   = $this->session->userdata('current_clinic'); 
        $data4['date']        = date('d/m/Y');
        $data4['user_id']     = $this->session->userdata('login_user_id');
        $data4['user_type']   = $this->session->userdata('login_type');
        $data4['type']        = 1;
        $data4['de']        = 0;
        $this->db->insert('financial',$data4);
        
        $data['status'] = 10;
        $this->db->where('stabilitation_ref_id', $stabilitaion_id);
        $this->db->update('stabilitation_ref', $data);
    }

    function delete_stabilitation($stabilitaion_id)
    {

        $data2['status'] = 1; 
        $this->db->where('room_id',$this->db->get_where('stabilitation', array('stabilitation_ref_id'=>$stabilitaion_id))->row()->room_id);
        $this->db->update('room',$data2);

        $this->db->where('stabilitation_ref_id', $stabilitaion_id);
        $this->db->delete('stabilitation_ref');

        $this->db->where('stabilitation_ref_id', $stabilitaion_id);
        $this->db->delete('stabilitation');
    }


    function update_stabilitation_ref($stb_id)
    {

        $data['doctor_id']     = $this->input->post('doctor_id');
        $data['staff_id']      = $this->input->post('staff_id');
        $data['room_id']      = $this->input->post('room_id');
        $data['comment']      = $this->input->post('comment');
        $this->db->where('stabilitation_ref_id',$stb_id);
        $this->db->update('stabilitation_ref', $data);

    }

    function create_appointment_quote() {
        $treatment_id = '';
        if($this->input->post('practice_id') == 23) {
            if($this->input->post('name_treatment') != '') {
                $datat['name'] = $this->input->post('name_treatment');
                $datat['type'] = $this->input->post('type_treatment');
                $datat['date'] = $this->crud_model->formatDate();
                $datat['patient_id'] = $this->input->post('patient_id');
                $datat['doctor_id'] = $this->session->userdata('login_user_id');
                $this->db->insert('odonto_treatment', $datat);
                $treatment_id = $this->db->insert_id();
            } else {
                $treatment_id = $this->input->post('select_treatment');
            }
        }

        $post_date   = explode('/',$this->input->post('date_picked'));
        $order_day   = $post_date[0];
        $order_month = $post_date[1];
        $order_year  = $post_date[2];
        if($order_day <= 9){
            $order_day = "0".$order_day;
        }
        if($order_month <= 9){
            $order_month = "0".$order_month;
        }
        $order_date = $order_year."-".$order_month."-".$order_day." ".$this->input->post('radio').":00";
        if($this->input->post('patient_type') == '0') {
            $data['patient_id']   = $this->input->post('patient_id');   
        } else {
            $password                  = $this->accounts_model->getPassword();
            $data2['first_name']       = $this->input->post('first_name');
            $data2['second_name']      = $this->input->post('second_name');
            $data2['third_name']       = $this->input->post('third_name');
            $data2['last_name']        = $this->input->post('last_name');
            $data2['second_last_name'] = $this->input->post('second_last_name'); 
            $data2['password']         = sha1($password);
            $data2['username']         = $this->accounts_model->getUsername(strtolower($this->accounts_model->normalizeText($this->input->post('first_name')." ".$this->input->post('last_name'))));
            $data2['email']            = $this->input->post('email');
            $data2['dpi']              = $this->input->post('dpi');
            $data2['phone']            = $this->input->post('phone');
            $data2['gender']           = $this->input->post('gender');
            $data2['address']          = $this->input->post('address');
            $data2['marital_status']   = $this->input->post('marital_status');
            $data2['status']           = 1;
            $data2['date_of_birth']    = $this->input->post('date_of_birth');
            $data2['clinic_id']        =  $this->session->userdata('current_clinic');
            $data2['date']             = $this->crud_model->formatDate();

            $this->db->insert('patient', $data2);
            $patient_id = $this->db->insert_id();
            $data['patient_id']   = $patient_id;
        }
        $data['order_date']   = $order_date;
        if($this->session->userdata('login_type') == 'doctor' && $this->session->userdata('login_user_id') != 1){
            $data['doctor_id']     = $this->session->userdata('login_user_id');
        }else{
            $data['doctor_id']     = $this->input->post('doctor_id');   
        }

        $data['practice']     = $this->input->post('practice_id');
        $data['date']         = $this->input->post('date_picked');
        $data['comment']      = $this->input->post('comment');
        $data['time']         = $this->input->post('radio');
        $data['clinic_id']    = $this->session->userdata('current_clinic');
        $data['treatment_id'] = $treatment_id;
        $data['system_date']  = $this->crud_model->formatDate();
        $date = explode('/',$this->input->post('date_picked'));
        $day = $date[0];
        $month = $date[1];
        $year = $date[2];
        
        $data['day']         = $day;
        $data['month']       = $month;
        $data['year']        = $year;
        $data['type']        = 2;
        $this->db->insert('appointment', $data);
        $app_id = $this->db->insert_id();

        $this->whatsapp->whatsapp_notification('agendar',$app_id);

        $this->log_model->new_appointment($data['patient_id'],$this->input->post('practice_id'));

        if($this->input->post('email') != "") {
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->SetFrom('usuarios@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = "Cuenta creada";
            $data_email = array(
                'email_msg' => "¡Hola ".str_replace(' ', '',$this->input->post('first_name'))."! Recibes esta notificación porque se ha creado una nueva cuenta de usuario en <b>".$this->accounts_model->system_name()."</b>, tus datos son los siguientes: <br><br><b>Usuario: </b>".$data2['username']."<br><b>Contraseña:</b> ".$password."<br> Para iniciar sesión haz click aquí: ".base_url().'/login'
            );
            $mail->Body = $this->load->view('backend/mails/credentials.php',$data_email,TRUE);
            $mail->AddAddress($this->input->post('email'));
            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        }
    }
    
    function create_appointment() {
        $post_date   = explode('/',$this->input->post('date_picked'));
        $order_day   = $post_date[0];
        $order_month = $post_date[1];
        $order_year  = $post_date[2];
        if($order_day <= 9){
            $order_day = "0".$order_day;
        }
        if($order_month <= 9){
            $order_month = "0".$order_month;
        }
        $order_date = $order_year."-".$order_month."-".$order_day." ".$this->input->post('time');
        
        $data['order_date']      = $order_date;
        $data['doctor_id']       = $this->input->post('doctor_id');
        $data['surgery_room_id'] = $this->input->post('surgery');   
        $data['practice']        = $this->input->post('practice_id');
        $data['date']            = $this->input->post('date_picked');
        $data['comment']         = $this->input->post('comment');
        $data['time']            = $this->input->post('time');
        $data['hour']            = $this->input->post('time');
        $data['clinic_id']       = $this->session->userdata('current_clinic');
        $data['status']          = 1;
        $data['system_date']     = $this->crud_model->formatDate();
        $data['room_id']         = $this->input->post('room_id');
        $data['type_surgery']    = $this->input->post('type_surgery'); 
        
        $date  = explode('/',$this->input->post('date_picked'));
        $day   = $date[0];
        $month = $date[1];
        $year  = $date[2];
        
        $data['day']         = $day;
        $data['month']       = $month;
        $data['year']        = $year;

        $dat3['status'] = 3;
        $this->db->where('room_id',$this->input->post('room_id'));
        $this->db->update('room',$dat3);

        $dat2['status'] = 2;
        $this->db->where('surgery_room_id',$this->input->post('surgery'));
        $this->db->update('surgery_room',$dat2);

        $this->db->insert('appointment', $data);
        
        $app_id = $this->db->insert_id();
        $this->log_model->new_appointment($data['patient_id'],$this->input->post('practice_id'));
    }
    
    function create_act()
    {
        $time = "";
        if($this->input->post('morning') != ''){
            $time = $this->input->post('morning');
        }elseif($this->input->post('afternoon') != ''){
            $time = $this->input->post('afternoon');
        }

        $data['doctor_id']     = $this->input->post('doctor_id');   
        $data['comment']      = $this->input->post('comment');
        $data['Title']      = $this->input->post('titulo');
        $data['time']         = date("H:i", strtotime($time));
        $data['hour']         = date('G');
        $data['clinic_id']    = $this->session->userdata('current_clinic');
        $data['system_date']  = $this->crud_model->formatDate();
        $data['status'] = 5;
        $date = explode('/',$this->input->post('date'));
        $day = $date[0];
        $month = $date[1];
        $year = $date[2];
        $data['date']         = $this->input->post('date');
        $data['day']         = $day;
        $data['month']       = $month;
        $data['year']        = $year;
        $this->db->insert('appointment', $data);
        $this->log_model->new_appointment($this->input->post('patient_id'),$this->input->post('practice_id'));
    }
    

    function pay_appointment()
    {
                    $patient = $this->db->get_where('patient', array('patient_id'=>$this->input->post('patient_id')))->row()->first_name. ' '.$this->db->get_where('patient', array('patient_id'=>$this->input->post('patient_id')))->row()->last_name ;
                    $labs = $this->db->get_where('laboratory_app',array('appointment_id'=>$this->input->post('appointment_id')));
                            
                    if($labs->num_rows() > 0)
                    {
                        foreach($labs->result_array() as $lb)
                            {

                                $totappointment = $this->db->get_where('appointment', array('appointment_id'=>$this->input->post('appointment_id')))->row()->charges;
                                $patient = $this->db->get_where('patient', array('patient_id'=>$this->input->post('patient_id')))->row()->first_name. ' '.$this->db->get_where('patient', array('patient_id'=>$this->input->post('patient_id')))->row()->last_name ;
                                $laboratory = $this->db->get_where('laboratory', array('laboratory_id'=>$lb['laboratory_id']))->row()->name;
                                
                                $data4['appointment_id']  = $this->input->post('appointment_id');
                                $data4['patient_id']   =   $this->input->post('patient_id');
                                $data4['description'] = $laboratory;
                                $data4['amount']      =  $lb['price'];
                                $data4['method']      = $this->input->post('method');
                                $data4['clinic_id']   = $this->session->userdata('current_clinic'); 
                                $data4['date']        = date('d/m/Y');
                                $data4['user_id']     = $this->session->userdata('login_user_id');
                                $data4['user_type']   = $this->session->userdata('login_type');
                                $data4['type']        = 1;
                                $data4['de']        = 2; //laboratorios
                                $this->db->insert('financial',$data4);
                            }

                    }


                    $rayos_x = $this->db->get_where('rayos_x_app',array('appointment_id'=>$this->input->post('appointment_id')));
                            
                    if($rayos_x->num_rows() > 0)
                    {
                        foreach($rayos_x->result_array() as $rx)
                            {

                                $totappointment = $this->db->get_where('appointment', array('appointment_id'=>$this->input->post('appointment_id')))->row()->charges;
                                $patient = $this->db->get_where('patient', array('patient_id'=>$this->input->post('patient_id')))->row()->first_name. ' '.$this->db->get_where('patient', array('patient_id'=>$this->input->post('patient_id')))->row()->last_name ;
                                $rayos_name = $this->db->get_where('rayos_x', array('rayos_x_id'=>$rx['rayos_x_id']))->row()->name;
                                
                                $data4['appointment_id']  = $this->input->post('appointment_id');
                                $data4['patient_id']   =   $this->input->post('patient_id');
                                $data4['description'] = $rayos_name;
                                $data4['amount']      =  $rx['price'];
                                $data4['method']      = $this->input->post('method');
                                $data4['clinic_id']   = $this->session->userdata('current_clinic'); 
                                $data4['date']        = date('d/m/Y');
                                $data4['user_id']     = $this->session->userdata('login_user_id');
                                $data4['user_type']   = $this->session->userdata('login_type');
                                $data4['type']        = 1;
                                $data4['de']        = 3; //laboratorios
                                $this->db->insert('financial',$data4);
                            }

                    }

                    $data['month']        =   date('m');
                    $data['day']          =   date('d');
                    $data['year']         =   date('Y');
                    $data['date']         =   $this->crud_model->formatDate();
                    $data['user_id']      =  $this->session->userdata('login_user_id');
                    $data['user_type']    =  'admin';
                    $data['clinic_id']    =   $this->session->userdata('current_clinic');
                    $data['patient_id']   =   $this->input->post('patient_id');
                    $data['status']       =   1;
                    $data['payment_type'] =   $this->input->post('method');
                    $data['description']  =   $this->input->post('description');
                    $data['appointment_id']  =   $this->input->post('appointment_id');

                    $variant_ids        =   $this->input->post('variant_id');
                    $selling_prices     =   $this->input->post('selling_price');
                    $ordered_quantities =   $this->input->post('qty');
                    $discounts          =   0;

                    $number_of_entries   =   sizeof($variant_ids);
                    $sales_order_entries =   array();
                    $total_amount        =   0;
                    for($i = 0; $i < $number_of_entries; $i++) 
                    {
                        $stock = $this->db->get_where('product', array('product_id' => $variant_ids[$i]))->row()->stock;
                        
                        $dbs['stock'] = $stock-$ordered_quantities[$i];
                        $this->db->where('product_id',$variant_ids[$i]);
                        $this->db->update('product', $dbs);
                        $entry_amount    =   $selling_prices[$i] * $ordered_quantities[$i];
                        $amount_with_tax =   $entry_amount + ($entry_amount * ($tax_values[$i] / 100));
                        $sub_total       =   $amount_with_tax - ($amount_with_tax * ($discounts[$i] / 100));
                        $new_order_entry    =   array(
                            'variant_id' => $variant_ids[$i],
                            'selling_price' => $selling_prices[$i],
                            'ordered_quantity' => $ordered_quantities[$i],
                            'discount' => $discounts[$i],
                            'sub_total' => $sub_total
                        );
                        $total_amount += $sub_total;
                        array_push($sales_order_entries , $new_order_entry);
                    }


                    if($total_amount > 0) 
                    {


                        
                        $totappointment = $this->db->get_where('appointment', array('appointment_id'=>$this->input->post('appointment_id')))->row()->charges;
                        $data3['appointment_id']  = $this->input->post('appointment_id');
                        $data3['patient_id']   =   $this->input->post('patient_id');
                        $data3['description'] = 'Venta de medicamento';
                        $data3['amount']      =  round($total_amount , 2);
                        $data3['method']      = $this->input->post('method');
                        $data3['clinic_id']   = $this->session->userdata('current_clinic'); 
                        $data3['date']        = date('d/m/Y');
                        $data3['user_id']     = $this->session->userdata('login_user_id');
                        $data3['user_type']   = $this->session->userdata('login_type');
                        $data3['type']        = 1;
                        $data3['de']        = 1;
                        $this->db->insert('financial',$data3);



                        $data['total']   =   round($total_amount , 2);
                        $data['products']  =   serialize($sales_order_entries);
                        $this->db->insert('cart' , $data);


                    }

                

                
                    $totappointment = $this->db->get_where('appointment', array('appointment_id'=>$this->input->post('appointment_id')))->row()->charges;
                    $data3['appointment_id']  = $this->input->post('appointment_id');
                    $data3['patient_id']   =   $this->input->post('patient_id');
                    $data3['description'] = 'Cita de'.$patient;
                    $data3['amount']      = $totappointment;
                    $data3['method']      = $this->input->post('method');
                    $data3['clinic_id']   = $this->session->userdata('current_clinic'); 
                    $data3['date']        = date('d/m/Y');
                    $data3['user_id']     = $this->session->userdata('login_user_id');
                    $data3['user_type']   = $this->session->userdata('login_type');
                    $data3['type']        = 1;
                    $data3['de']        = 0;
                    $this->db->insert('financial',$data3);
                    
                    
                
                    $dat['status']=1;
                    $this->db->where('appointment_id',$this->input->post('appointment_id'));
                    $this->db->update('appointment',$dat);
                    
       
                     
        $patient_id = $this->db->get_where('appointment', array('appointment_id' => $this->input->post('appointment_id')))->row()->patient_id;
        
        
        $survey_status = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->send_survey;
        if($survey_status == 1)
        {
            $survey_id = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->survey_id;
            
            $email = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email;
            $service_id = $this->db->get_where('appointment', array('appointment_id' => $this->input->post('appointment_id')))->row()->practice;
            if($service_id > 0){
                $service_name = $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
            }else{
                $service_name = "Otros servicios";
            }
            require("public/apis/class.phpmailer.php");
            $mail = new PHPMailer(); 
            $mail->IsHTML(true);
            $mail->IsMail();
            $mail->CharSet = 'UTF-8';
            $mail->SetFrom('notificaciones@medicaby.com', 'Notificaciones Medicaby');
            $mail->Subject = 'Encuesta de servicio - Medicaby';
            $data = array(
                'survey_id' => $survey_id,
                'patient_id' => $patient_id,
                'appointment_id' => $this->input->post('appointment_id'),
                'service_name' => $service_name
            );
            $mail->Body = $this->load->view('backend/mails/survey.php',$data,TRUE);
            $mail->AddAddress($email);
            if($email != ''){
                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }       
            }
        }
                    $this->log_model->new_sale($this->input->post('patient_id'),round($total_amount , 2));
    }

    function reschedule_appointment($appointment_id)
    {
        
        log_message('error','Reprogramar cita');
        $time = "";
        if($this->input->post('morning') != ''){
            $time = date( "H:i", strtotime($this->input->post('morning')));
        }elseif($this->input->post('afternoon') != ''){
            $time = date( "H:i", strtotime($this->input->post('afternoon')));
        }

        $appointment = $this->db->get_where('appointment', array('appointment_id' => $appointment_id));
        //--------------------------------------------------------
        $data['doctor_id']   = $appointment->row()->doctor_id;   
        $data['treatment_id']   = $appointment->row()->treatment_id;   
        $data['order_date']   = date('Y-m-d H:i:s');
        $data['practice']     = $appointment->row()->practice;
        $data['patient_id']     = $appointment->row()->patient_id;
        $data['date']         = $this->input->post('date');
        $data['comment']      = $appointment->row()->comment;
        $date = explode('/',$this->input->post('date'));
        $data['time']         = $time;
        $data['hour']         = $time;
        $data['day']          = $date[1];
        $data['month']        = $date[0];
        $data['year']         = $date[2];
        $data['status']   = 0;
        $data['comments'] = $this->input->post('comments');
        $data['clinic_id']    = $this->session->userdata('current_clinic');
        $data['system_date']  = $this->crud_model->formatDate();

        $this->db->insert('appointment', $data);
        $app_id = $this->db->insert_id();

        $this->whatsapp->whatsapp_notification('reprogramar',$app_id);

        $data2['status']   = 3;
        $this->db->where('appointment_id', $appointment_id);
        $this->db->update('appointment', $data2);

    }
    
    function cancel_appointment($appointment_id)
    {

        $this->whatsapp->whatsapp_notification('cancelar',$appointment_id);
        $data['status'] = 2;
        $this->db->where('appointment_id', $appointment_id);
        $this->db->update('appointment', $data);
    }
    
    function confirm_appointment($appointment_id)
    {

        $this->whatsapp->whatsapp_notification('confirmar',$appointment_id);
        $data['status'] = 6;
        $this->db->where('appointment_id', $appointment_id);
        $this->db->update('appointment', $data);
    }
    
    
     function pay_1($appointment_id)
    {

            $data2['patient_id']  = $this->input->post('patient_id');
            $data2['description'] = $this->input->post('description');
            $data2['amount']      = round($this->input->post('total_charges') , 2);
            $data2['method']      = $this->input->post('method');
            $data2['clinic_id']   = $this->session->userdata('current_clinic'); 
            $data2['date']        = date('d/m/Y');
            $data2['user_id']     = $this->session->userdata('login_user_id');
            $data2['user_type']   = $this->session->userdata('login_type');
            $data2['origin']      = 'appointment';
            $data2['origin_id']   = $appointment_id;
            $data2['box_id']      =  $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1))->row()->box_id;
            $this->db->insert('income',$data2);
            
            $service = $this->db->get_Where('product',array('product_id'=>$this->input->post('service')))->row_array();
            $establecimiento = $this->db->get_Where('establecimiento',array('establecimiento_id'=>$this->input->post('establecimiento_id')))->row_array();
            
            $total      = 0;
            $sales_order_entries =   array();
            
            $new_order_entry    =   array(
                'cat_id' => $service['category_id'],
                'product_id' => $service['product_id'],
                'amount' => 1,
                'unity' => '',
                'subtotal' => 1 * $this->input->post('total_charges') ,
                'discount' => 0,
                'total' => 1 * $this->input->post('total_charges'),
            );
            
            $total = 1 * $this->input->post('total_charges');
    
            array_push($sales_order_entries , $new_order_entry);

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
                'regime' => $establecimiento['afiliacion'],
                'institution_id' => $this->input->post('establecimiento_id'),
                'type_invoice' => 'N',
                'type' => $this->input->post('type'),
                'days' => $this->input->post('days'),
                'details' => $this->input->post('description'),
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
            
            
            $emision_id = $this->fel->requestDocument($sale_id);
            
            log_message('error','emision '.$emision_id);
            
            $this->db->where('appointment_id',$appointment_id);
            $this->db->update('appointment',array('invoice_1'=> $emision_id['emision_id'],'status'=>1));
            
            
            $this->db->where('sale_id',$sale_id);
            $this->db->update('sale',array('invoice'=> $emision_id['emision_id']));

            $this->crud_model->createDepBySale($sale_id);
            
    }
    
    
         function pay_2($appointment_id)
    {

            $data4['status'] = 4;
            $this->db->where('appointment_id',$appointment_id);
            $this->db->update('appointment',$data4);
            
    }
    
    
    
    function delete_appointment($appointment_id)
    {
        $this->db->where('appointment_id', $appointment_id);
        $this->db->delete('appointment');
        
        $this->db->where('appointment_id', $appointment_id);
        $this->db->delete('prescription');
        
        $this->db->where('appointment_id', $appointment_id);
        $this->db->delete('financial');
        
    }
    
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
    
    
    function delete_treatment($treatment_id)
    {
        $appoints            = $this->db->get_where('appointment', array('treatment_id' => $treatment_id))->result_array();
        foreach($appoints as $rs)
        {
            $this->db->where('appointment_id', $rs['appointment_id']);
            $this->db->delete('prescription');
        }
        
        $this->db->where('treatment_id', $treatment_id);
        $this->db->delete('odonto_treatment');
        
        $this->db->where('odonto_treatment_id', $treatment_id);
        $this->db->delete('tooth_treatment');
        
        $this->db->where('tooth_treatment_id', $treatment_id);
        $this->db->delete('payment_credit');
        
        $this->db->where('treatment_id', $treatment_id);
        $this->db->delete('financial');
        
        $this->db->where('treatment_id', $treatment_id);
        $this->db->delete('appointment');
        
        return true;
    }
    
    
    
    function create_odonto_treatment($doctor_id, $login_type)
    {
        if($this->input->post('name') != '')
        {
            $data['name']           = $this->input->post('name');
            $data['type']           = $this->input->post('type');
            $data['date']           = $this->crud_model->formatDate();
            $data['patient_id']     = $this->input->post('patient_id');
            $data['doctor_id']      = $doctor_id;
            $this->db->insert('odonto_treatment', $data);
            $id = $this->db->insert_id();
                
                $post_date          = explode('/',$this->input->post('date'));
                $order_day          = $post_date[0];
                $order_month        = $post_date[1];
                $order_year         = $post_date[2];
                if($order_day <= 9){
                    $order_day      = "0".$order_day;
                }
                if($order_month <= 9){
                    $order_month    = "0".$order_month;
                }
                
                $time = "";
                if($this->input->post('morning') != '')
                {
                    $time           = date("H:i", strtotime($this->input->post('morning')));
                }elseif($this->input->post('afternoon') != ''){
                    $time           = date("H:i", strtotime($this->input->post('afternoon')));
                }

                $order_date             = $order_year."-".$order_month."-".$order_day." ".$time.":00";
                $datas['patient_id']    = $this->input->post('patient_id');
                $datas['doctor_id']     = $doctor_id;
                $datas['order_date']    = $order_date;
                $datas['practice']      = '23';
                $datas['date']          = $this->input->post('date');//
                $datas['comment']       = 'Cita desde tratamiento';
                
                $datas['time']          = $time;
                $datas['clinic_id']     = $this->session->userdata('current_clinic');
                $datas['treatment_id']  = $id;
                $datas['system_date']   = $this->crud_model->formatDate();
                
                $date                   = explode('/',$this->input->post('date'));//
                $day = $date[0];
                $month = $date[1];
                $year = $date[2];
                $datas['day']           = $day;
                $datas['month']         = $month;
                $datas['year']          = $year;
                $this->db->insert('appointment', $datas);
            
            $this->session->set_flashdata('flash_message' , "Tratamiento creado correctamente.");
            redirect(base_url().$login_type.'/treatment_details/'.base64_encode($id), 'refresh');
            
        }
        elseif($this->input->post('treatment_id') != '')
        {
            
                $post_date              = explode('/',$this->input->post('date'));
                $order_day              = $post_date[0];
                $order_month            = $post_date[1];
                $order_year             = $post_date[2];
                if($order_day <= 9){
                    $order_day          = "0".$order_day;
                }
                if($order_month <= 9){
                    $order_month        = "0".$order_month;
                }
                $time = "";
                if($this->input->post('morning') != ''){
                    $time               = date("H:i", strtotime($this->input->post('morning')));
                }elseif($this->input->post('afternoon') != ''){
                    $time               = date("H:i", strtotime($this->input->post('afternoon')));
                }
                $order_date             = $order_year."-".$order_month."-".$order_day." ".$time.":00";
                $datas['patient_id']    = $this->input->post('patient_id');
                $datas['doctor_id']     = $doctor_id;
                $datas['order_date']    = $order_date;
                $datas['practice']      = '23';
                $datas['date']          = $this->input->post('date');//
                $datas['comment']       = 'Cita desde tratamiento';
                $datas['time']          = $time;//
                $datas['clinic_id']     = $this->session->userdata('current_clinic');
                $datas['treatment_id']  = $this->input->post('treatment_id');
                $datas['system_date']   = $this->crud_model->formatDate();
                
                $date                   = explode('/',$this->input->post('date'));//
                $day                    = $date[0];
                $month                  = $date[1];
                $year                   = $date[2];
                $datas['day']           = $day;
                $datas['month']         = $month;
                $datas['year']          = $year;
                $this->db->insert('appointment', $datas);
                
                $this->session->set_flashdata('flash_message' , "Cita asignada correctamente al tratamiento.");
                redirect(base_url().$login_type.'/treatment_details/'.base64_encode($this->input->post('treatment_id')), 'refresh');
        }
        
        else
        {
             $this->session->set_flashdata('error_message' , "Por favor, inténtelo de nuevo");
             redirect(base_url() .$login_type.'/panel/', 'refresh');
        }
    }
}