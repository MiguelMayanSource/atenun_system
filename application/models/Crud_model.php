<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
      $this->load->library('excel');
    }
    
    function getInfo($type)
    {
        return $this->db->get_where('settings',array('type'=>$type))->row()->description;
    }
    
    function getPercentage($total, $cant)
    {
        if($total>0)
        {
            $total = (100 * $cant)/$total;
            if($total>0)
            {
                return round($total, 0, PHP_ROUND_HALF_EVEN);
            }
            else
            {
                return 0;
            }
        }else
        {
            return 0;
        }
    }

    function checkMobile(){
        require_once "public/apis/detect/Mobile_Detect.php";
        $detect = new Mobile_Detect();
        if ($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS()) {
            return true;
        }else{
            return false;
        }
    }

    function getSpecialty($specialtie){
        return $this->db->get_where('specialtie', array('specialtie_id' => $specialtie))->row()->name;
    }
    
    function getAdmins(){
        return $this->db->query('SELECT * FROM admin WHERE owner = 1 AND status = "1"  AND admin_id NOT IN ("35")')->result_array();
    }
    

    function getDoctors(){
        return $this->db->query('SELECT * FROM admin WHERE owner = 0 AND status != "0"  AND admin_id NOT IN (  "35")')->result_array();
    }
    
    function getStaffDoctors(){
        return $this->db->query('SELECT * FROM admin WHERE owner = 0 AND status != "0" ')->result_array();
    }
    
    function formatDate2()
    {
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        return date('d')." de ".$meses[date('n')-1].". a las ".date('H:i A');
    }
    
    function getStaffList($category){
        $query = $this->db->query('SELECT * FROM staff WHERE status != "0" AND clinic_id ="'.$this->session->userdata('current_clinic').'" and category ='.$category)->result_array();
        return $query;
    }
    
    function getProviderServices () {
        return $this->db->get_where("provider_service", array("status"=>1));
    }

    function getStaffListStaff(){
        $query = $this->db->query('SELECT * FROM staff WHERE status != "0" AND staff_id != "'.$this->session->userdata('login_user_id').'" AND clinic_id ="'.$this->session->userdata('current_clinic').'"')->result_array();
        return $query;
    }
    
    function checkSubscription(){
        $query = $this->db->get_where('suscription', array('clinic_id' => $this->session->userdata('current_clinic'), 'status' => 0));        
        return $query;
    }
    
    function getAccountInfo($column, $method)
    {
        return $this->db->get_where('payment_method', array('slug' => $method))->row()->$column;
    }
    
    function date_week($u_date) 
    {
        $date_obj = new DateTime($u_date); // Crear un objeto de fecha
        $num_day = intval($date_obj->format('w')); // 0-dom, 1-lun, ... 6-sab
        $date_obj->modify("-$num_day day"); // Posicionar el objeto en domingo
        $wdays = array();
        for($i=0; $i<14; $i++) {
            $wdays[] = $date_obj->format('Y-m-d');
            $date_obj->modify('+1 day'); // Incrementar el objeto 1 dia
        }
        return $wdays;
    }
    
    function set_online_status($user_type, $user_id)
    {
        $session    = session_id();
        $time       = time();
        $time_check = $time-300;
        $this->db->where('session', $session);
        $count = $this->db->get('online_users')->num_rows();
        if($count == 0)
        { 
            $data['time'] = $time;
            $data['type'] = $user_type;
            $data['id_usuario'] = $user_id;
            $data['gp'] = $user_id."-".$user_type;
            $data['session'] = $session;
            $this->db->insert('online_users',$data);
        }
        else 
        {
            $data['session'] = $session;
            $data['time'] = $time;
            $data['gp'] = $user_id."-".$user_type;
            $data['id_usuario'] = $user_id;
            $data['type'] = $user_type;
            $this->db->where('session', $session);
            $this->db->update('online_users', $data);
        }  
        $this->db->where('time <', $time_check);
        $this->db->delete('online_users');
    }
    
    
    function get_questions($survey_id)
    {
        $questions = $this->db->get_where('question', array('survey_id' => $survey_id))->result_array();
        $string = "";foreach($questions as $row){ $string .= "'".$row['question']."'".",";}
        return $string;
    }

    function get_total_appointments()
    {
            $clinic_id = $this->session->userdata('current_clinic');
            $inicial   = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->morning;
            $final     = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_morning;
            $inicial2  = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->afternoon;
            $final2    = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_afternoon;
            $intervalo = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->time_interval;
            
            
            $horas = $this->interval($inicial, $final, $intervalo);
            $cont = 0;
            for($i = 0; $i < count($horas); $i++)
            {
                $cont++;
            }
            $horas2 =  $this->interval($inicial2, $final2, $intervalo);
            
            for($i = 0; $i < count($horas2); $i++)
            {
                $cont++;
                
                
            }
            
            return $cont;

    }
    
    function intervalo($hora_inicio, $hora_fin, $intervalo) 
    {
        $hora_inicio = new DateTime($hora_inicio );
        $hora_fin    = new DateTime($hora_fin );
        $hora_fin->modify('+1 second'); // Añadimos 1 segundo para que nos muestre $hora_fin
        // Si la hora de inicio es superior a la hora fin
        // añadimos un día más a la hora fin
        if ($hora_inicio > $hora_fin) 
        {        
            $hora_fin->modify('+1 day');
        }
        // Establecemos el intervalo en minutos        
        $intervalo = new DateInterval('PT'.$intervalo.'M');
        // Sacamos los periodos entre las horas
        $periodo   = new DatePeriod($hora_inicio, $intervalo, $hora_fin);        
        foreach( $periodo as $hora ) 
        {
            // Guardamos las horas intervalos 
            $horas[] =  $hora->format('H:i');
        }
        return $horas;
    }
    
        function get_total_appointments_today()
    {
            $clinic_id = $this->session->userdata('current_clinic');
            $inicial   = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->morning;
            $final     = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_morning;
            $inicial2  = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->afternoon;
            $final2    = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_afternoon;
            $intervalo = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->time_interval;
            
            
            $horas = $this->interval($inicial, $final, $intervalo);
            $cont = 0;
            $var = date('H:i');
            $past=0;
            for($i = 0; $i < count($horas); $i++)
            {
                
                if($horas[$i]<$var)
                {
                    $past++;
                }
                $cont++;
                
                
            }
            
            
            $horas2 =  $this->interval($inicial2, $final2, $intervalo);
            
            for($i = 0; $i < count($horas2); $i++)
            {
                if($horas2[$i]<$var)
                {
                    $past++;
                }
                $cont++;
            }
            
            return $past;
    }

    function fill_week($date){
        $explode_date = explode('-', $date);
        $this->db->where('day',$explode_date[2]);
        $this->db->where('month',$explode_date[1]);
        $this->db->where('year',$explode_date[0]);
        
        $this->db->where('status !=', 4);
        $this->db->where('status !=', 5);
        $this->db->where('status !=', 6);
        $this->db->where('doctor_id', $this->session->userdata('login_user_id'));
        $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
        $nums = $this->db->get('appointment')->num_rows();
        return $nums;
        
    }
    
    
    function fill_week_doc_past($date,$doctor_id){
         $this->db->where('doctor_id',$doctor_id);
        $explode_date = explode('-', $date);
        $this->db->where('day',$explode_date[2]);
        $this->db->where('month',$explode_date[1]);
        $this->db->where('year',$explode_date[0]);
        $this->db->where('status', 4);
        $nums = $this->db->get('appointment')->num_rows();
        return $nums;
    }
    
    function fill_week_doc($date,$doctor_id){
       
        $this->db->where('doctor_id',$doctor_id);
        $explode_date = explode('-', $date);
        $this->db->where('day',$explode_date[2]);
        $this->db->where('month',$explode_date[1]);
        $this->db->where('year',$explode_date[0]);
        $this->db->where('status !=', 2);
        $this->db->where('status !=', 4);
        $this->db->where('status !=', 5);
        $this->db->where('status !=', 6);
       
        $appoint = $this->db->get('appointment')->result_array();
        
        $cont = 0;
        $var = date('H:i');
        
        foreach($appoint as $row)
        {
            if($row['time'] > $var){
                  $cont++;
            }else
            {
                
                $data['past_status'] = 1;
                $data['status'] = 4;
                $this->db->where('appointment_id',$row['appointment_id']);
                $this->db->update('appointment', $data);
            }
          
        }
       
        $stotal = ($this->get_total_appointments_today()+ $cont);
        
        $total =$this->get_total_appointments() -$stotal;
        
        return $total;
    }
    
    function past_appointment($appointent_id){
       

       
        $appoint = $this->db->get_where('appointment', array('appointment_id'=>$appointment_id))->row()->time;
        
        $cont = 0;
        $var = date('H:i');

            if($row['time'] > $var){

                $data['past_status'] = 1;
                $this->db->where('appointment_id',$row['appointment_id']);
                $this->db->update('appointment', $data);
            }
          
        
       
        $stotal = ($this->get_total_appointments_today()+ $cont);
        
        $total =$this->get_total_appointments() -$stotal;
        
        return $total;
    }
    
    function fill_week_doc_future($date,$doctor_id){
       
        $this->db->where('doctor_id',$doctor_id);
        $explode_date = explode('-', $date);
        $this->db->where('day',$explode_date[2]);
        $this->db->where('month',$explode_date[1]);
        $this->db->where('year',$explode_date[0]);
        $this->db->where('status !=', 2);
        $this->db->where('status !=', 4);
        $this->db->where('status !=', 5);
        $this->db->where('status !=', 6);
       
        $appoint = $this->db->get('appointment')->num_rows();
        
        $total =  $this->get_total_appointments();
        return $total - $appoint;
    }

    function get_month()
    {

        $anioActual = date("Y");
        $mesActual = date("n");
        $cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
       
       for($i=1;$i<=$cantidadDias;$i++)
       echo $i.',';

    }


    function get_month_income()
    {

        $anioActual = date("Y");
        $mesActual = date("m");
        $cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
       
       for($i=1;$i<=$cantidadDias;$i++)
       {

        if($i<10)
            $d='0'.$i;
        else
            $d=$i;
            
            $date = $d.'/'.$mesActual.'/'.$anioActual;

            $sql = 'SELECT SUM(amount) as Total, type FROM `financial` where date ="'.$date.'" and type = 1 and clinic_id = '.$this->session->userdata('current_clinic');
        
            $res = $this->db->query($sql)->row()->Total;

            if($res)
            {
                echo $res.',';
            }else
            {
                echo '0,';

            }

       }
      

    }


    function get_month_expense()
    {

        $anioActual = date("Y");
        $mesActual = date("m");
        $cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
       
       for($i=1;$i<=$cantidadDias;$i++)
       {

        if($i<10)
            $d='0'.$i;
        else
            $d=$i;
            
            $date = $d.'/'.$mesActual.'/'.$anioActual;

            $sql = 'SELECT SUM(amount) as Total, type FROM `financial` where date ="'.$date.'" and type = 0 and clinic_id = '.$this->session->userdata('current_clinic');
        
            $res = $this->db->query($sql)->row()->Total;


            if($res)
            {
                echo '-'.$res.',';
            }else
            {
                echo '0,';

            }
       }
      

    }

    function get_financial()
    {
        
        $this->db->order_by('date', 'desc');
        $res = $this->db->get('financial')->result_array();
        return $res;
    }


    function get_balance()
    {

        $sql = 'SELECT SUM(amount) as total FROM `financial` where type = 1 and clinic_id = '.$this->session->userdata('current_clinic');
        $income_total = $this->db->query($sql)->row()->total;

        $sql = 'SELECT SUM(amount) as total FROM `financial` where type = 0 and clinic_id = '.$this->session->userdata('current_clinic');
        $expense_total = $this->db->query($sql)->row()->total;
     
        $total = $income_total - $expense_total;
        return number_format ( $total , 2,'.',',' );

    }


    function get_financial_report($fecha1, $fecha2)
    {
        
        $sql = "SELECT * FROM `financial` where str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY financial_id DESC";
        $res = $this->db->query($sql, array($fecha1,$fecha2))->result_array();
        return $res;

    }




    function get_month_report($date1, $date2)
    {

        $explode = explode('/',$date1);
        $fecha1 = $explode[2].'-'.$explode[1].'-'.$explode[0];


        $explode2 = explode('/',$date2);
        $fecha2 = $explode2[2].'-'.$explode2[1].'-'.$explode2[0];
        
        for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days")))
        {
            echo substr($i, -2).','; 
         //aca puedes comparar $i a una fecha en la bd y guardar el resultado en un arreglo
        
        }

    }

    function get_month_expense_report($date1, $date2)
    {

        $explode = explode('/',$date1);
        $fecha1 = $explode[2].'-'.$explode[1].'-'.$explode[0];


        $explode2 = explode('/',$date2);
        $fecha2 = $explode2[2].'-'.$explode2[1].'-'.$explode2[0];
        
        for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days")))
        {
            $d = date("d/m/Y", strtotime($i)); 

            $sql = 'SELECT SUM(amount) as Total, type FROM `financial` where date ="'.$d.'" and type = 0 and clinic_id = '.$this->session->userdata('current_clinic');
        
            $res = $this->db->query($sql)->row()->Total;


            if($res)
            {
                echo '-'.$res.',';
            }else
            {
                echo '0,';

            }
        
        }
      

    }

    
    function get_month_income_report($date1, $date2)
    {

        $explode = explode('/',$date1);
        $fecha1 = $explode[2].'-'.$explode[1].'-'.$explode[0];


        $explode2 = explode('/',$date2);
        $fecha2 = $explode2[2].'-'.$explode2[1].'-'.$explode2[0];
        
        for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days")))
        {
            $d = date("d/m/Y", strtotime($i)); 

            $sql = 'SELECT SUM(amount) as Total, type FROM `financial` where date ="'.$d.'" and type = 1 and clinic_id = '.$this->session->userdata('current_clinic');
        
            $res = $this->db->query($sql)->row()->Total;


            if($res)
            {
                echo $res.',';
            }else
            {
                echo '0,';

            }
        
        }
      

    }

    function get_expense_report($date1, $date2)
    {

        $sql = "SELECT SUM(amount) as Total FROM `financial` where clinic_id = ".$this->session->userdata('current_clinic')." AND type = 0 AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY financial_id DESC";
        $res = $this->db->query($sql, array($date1,$date2))->row()->Total;
       
        if($res>0)
            return number_format( $res,2,'.',',');
        else
            return number_format(0,2,'.',',');
      

    }

    function get_income_report($date1, $date2)
    {
        
        $sql = "SELECT SUM(amount) as Total FROM `financial` where clinic_id = ".$this->session->userdata('current_clinic')." AND  type = 1 AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY financial_id DESC";
        $res = $this->db->query($sql, array($date1,$date2))->row()->Total;
       
        if($res>0)
            return number_format( $res,2,'.',',');
        else
            return number_format(0,2,'.',',');

    }

    function get_month_appoitments_report($doctor_id ,$date1, $date2)
    {

        $explode = explode('/',$date1);
        $fecha1 = $explode[2].'-'.$explode[1].'-'.$explode[0];


        $explode2 = explode('/',$date2);
        $fecha2 = $explode2[2].'-'.$explode2[1].'-'.$explode2[0];
        
        for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days")))
        {
            $d = date("d/m/Y", strtotime($i)); 

            $sql = 'SELECT * FROM `appointment` where clinic_id ="'.$this->session->userdata('current_clinic').'" and date ="'.$d.'" and doctor_id ="'.$doctor_id.'";';
        
            $res = $this->db->query($sql)->num_rows();


            if($res)
            {
                echo $res.',';
            }else
            {
                echo '0,';

            }
        
        }
    }

    function get_month_appoitments_genderMale_report($doctor_id ,$date1, $date2)
    {
        $total = 0;
        $sql = "SELECT * FROM `appointment` where clinic_id = ? And doctor_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y')";
        $res = $this->db->query($sql, array($this->session->userdata('current_clinic'), $doctor_id,$date1,$date2))->result_array();
       
            foreach($res as $r)
            {
                if($r['patient_id'])
                {
                    $gender = $this->db->get_where('patient',array('patient_id'=>$r['patient_id']))->row()->gender;
                     if(  $gender == 'M' )
                     {
                         $total++;

                     }
                    
                }
            }

            echo $total;

    }


    function get_month_appoitments_genderFamale_report($doctor_id ,$date1, $date2)
    {
        $total = 0;
        $sql = "SELECT * FROM `appointment` where clinic_id = ? And doctor_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y')";
        $res = $this->db->query($sql, array($this->session->userdata('current_clinic'), $doctor_id,$date1,$date2))->result_array();
       
            foreach($res as $r)
            {
                if($r['patient_id'])
                {
                    $gender = $this->db->get_where('patient',array('patient_id'=>$r['patient_id']))->row()->gender;
                     if(  $gender == 'F' )
                     {
                         $total++;

                     }
                    
                }
            }

            echo $total;

    }



    
    function get_week()
    {
        if(date('D')!='Sun'){    
            $staticstart = date('d/m/Y',strtotime('last Sunday'));    
        }else{
            $staticstart = date('d/m/Y');   
        }
        if(date('D') != 'Sat') {
            $staticfinish = date('d/m/Y',strtotime('next Saturday'));
        }else{
            $staticfinish = date('d/m/Y');
        }
        $explode = explode('/',$staticstart);
        $explode2 = explode('/',$staticfinish);
        $start_day = $explode[0];
        $end_day = $explode2[0];
        $mes = date('m');
        if($mes == '01'){
            $month = 'enero';
        }elseif($mes == '02'){
            $month = 'febrero';
        }elseif($mes == '03'){
            $month = 'marzo';
        }elseif($mes == '04'){
            $month = 'abril';
        }elseif($mes == '05'){
            $month = 'mayo';
        }elseif($mes == '06'){
            $month = 'junio';
        }elseif($mes == '07'){
            $month = 'julio';
        }elseif($mes == '08'){
            $month = 'agosto';
        }elseif($mes == '09'){
            $month = 'septiembre';
        }elseif($mes == '10'){
            $month = 'octubre';
        }elseif($mes == '11'){
            $month = 'noviembre';
        }elseif($mes == '12'){
            $month = 'diciembre';
        }
        return 'del '.$start_day.' al '.$end_day." de ".$month;
    }


 function get_date()
    {
        if(date('D')!='Sun'){    
            $staticstart = date('d/m/Y',strtotime('last Sunday'));    
        }else{
            $staticstart = date('d/m/Y');   
        }
        if(date('D') != 'Sat') {
            $staticfinish = date('d/m/Y',strtotime('next Saturday'));
        }else{
            $staticfinish = date('d/m/Y');
        }
        $explode = explode('/',$staticstart);
        $explode2 = explode('/',$staticfinish);
        $start_day = $explode[0];
        $end_day = $explode2[0];
        $mes = date('m');
        if($mes == '01'){
            $month = 'enero';
        }elseif($mes == '02'){
            $month = 'febrero';
        }elseif($mes == '03'){
            $month = 'marzo';
        }elseif($mes == '04'){
            $month = 'abril';
        }elseif($mes == '05'){
            $month = 'mayo';
        }elseif($mes == '06'){
            $month = 'junio';
        }elseif($mes == '07'){
            $month = 'julio';
        }elseif($mes == '08'){
            $month = 'agosto';
        }elseif($mes == '09'){
            $month = 'septiembre';
        }elseif($mes == '10'){
            $month = 'octubre';
        }elseif($mes == '11'){
            $month = 'noviembre';
        }elseif($mes == '12'){
            $month = 'diciembre';
        }
        return $end_day." de ".$month;
    }


    function clear_cache() 
    {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    
   
    
    function get_gender($patient_id)
    {
        if($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->gender == 'M'){
            return 'Masculino';
        }else{
            return 'Femenino';
        }
    }
    
    function get_format($extension)
    {
        if($extension == 'xlsx' || $extension == 'xlsm' || $extension == 'xltx' || $extension == 'xltm'){
            return base_url().'public/uploads/icons/excel.svg';
        }
        elseif($extension == 'docm' || $extension == 'docx' || $extension == 'dotx' || $extension == 'dotm'){
            return base_url().'public/uploads/icons/word.svg';
        }
        elseif($extension == 'pdf'){
            return base_url().'public/uploads/icons/pdf.svg';
        }
        elseif($extension == 'xlsx' || $extension == 'xlsm' || $extension == 'xltx' || $extension == 'xltm'){
            return base_url().'public/uploads/icons/excel.svg';
        }
        elseif($extension == 'txt'){
            return base_url().'public/uploads/icons/txt.svg';
        }
        elseif($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPEG' || $extension == 'gif'){
            return base_url().'public/uploads/icons/img.svg';   
        }
        elseif($extension == 'pptx' || $extension == 'pptm' || $extension == 'potx' || $extension == 'potm' || $extension == 'ppam' || $extension == 'ppsx' || $extension == 'ppsm' || $extension == 'sldx' || $extension == 'sldm'){
            return base_url().'public/uploads/icons/power.svg';   
        }else{
            return base_url().'public/uploads/icons/all.svg';   
        }
    }
    function getCode() 
    {
        return strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10)); 
    }

    function update_settings()
    { 
        $morning        = $this->set_24hrs($this->input->post('morning'));
        $b_morning      = $this->set_24hrs($this->input->post('b_morning'));
        $afternoon      = $this->set_24hrs($this->input->post('afternoon'));
        $b_afternoon    = $this->set_24hrs($this->input->post('b_afternoon'));
        $code= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->code;

        $dataUpdate['name']          = $this->input->post('name');
        $dataUpdate['address']       = $this->input->post('address');
        $dataUpdate['email']         = $this->input->post('email');
        $dataUpdate['phone']         = $this->input->post('phone');
        $dataUpdate['morning']       = $morning;
        $dataUpdate['b_morning']     = $b_morning;
        $dataUpdate['afternoon']     = $afternoon;
        $dataUpdate['b_afternoon']   = $b_afternoon;
        $dataUpdate['time_interval'] = $this->input->post('interval');
        $dataUpdate['code']=$code;
        $result = $this->send_api_hrs($dataUpdate);

        $data['name']          = $this->input->post('name');
        $data['address']       = $this->input->post('address');
        $data['email']         = $this->input->post('email');
        $data['phone']         = $this->input->post('phone');
        $data['morning']       = $morning;
        $data['b_morning']     = $b_morning;
        $data['afternoon']     = $afternoon;
        $data['b_afternoon']   = $b_afternoon;
        $data['time_interval'] = $this->input->post('interval');

        $code= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->code;
        $dataUpdate['currency'] = $this->input->post('currency');
        $dataUpdate['code']=$code;
        $result = $this->send_api_update($dataUpdate);

        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['logo']['name']);
        log_message('error',  $md5);
        if($_FILES['logo']['name'] != ''){
            $data['logo']              = $name;
            move_uploaded_file($_FILES['logo']['tmp_name'], 'public/uploads/' . $name);
        }
        $data['theme']              = $this->input->post('theme');
        $data['currency']           = 'Q';
        $data['send_survey']        = $this->input->post('send_survey');
        $data['survey_id']          = $this->input->post('survey_id');
        $data['send_schedule']      = $this->input->post('send_schedule');
        $data['hour']               = $this->input->post('hour');
        $data['product_module']     = 1;
        $data['send_reminder']      = $this->input->post('send_reminder');
        $data['reminder']           = $this->input->post('reminder');
        $data['template']           = $this->input->post('template');

        $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
        $this->db->update('clinic', $data);
    }

    function send_api_update($data_array){
        /* $domain= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->domain;

        log_message('error', $domain); */
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://medicaby.com/api/updateContract",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_array,
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    return $response; 
    }
    
    function theme(){
        $current = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme;
        return $current;
    }
    
    function check_item($item)
    {
        return $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->$item;    
    }
    
    function apply_forms()
    {
        $data['pathological']     = $this->input->post('pathological');
        $data['non_pathological'] = $this->input->post('non_pathological');
        $data['hereditary']       = $this->input->post('hereditary');
        $data['obstetrics']       = $this->input->post('obstetrics');
        $data['psychiatric']      = $this->input->post('psychiatric');
        $data['diet']             = $this->input->post('diet');
        $data['vaccination']      = $this->input->post('vaccination');
        $data['perinatal']        = $this->input->post('perinatal');
        $data['postnatal']        = $this->input->post('postnatal');
        $data['sistema_m']        = $this->input->post('sistema');
        log_message('error',  $this->input->post('sistema'));
        
        if($this->input->post('signs') == 1)
        {
            if($this->input->post('height') == 0 && $this->input->post('weight') == 0 && $this->input->post('temperature') == 0 && $this->input->post('frequency') == 0 && $this->input->post('systolic') == 0 && $this->input->post('diastolic') == 0 && $this->input->post('heart') == 0 && $this->input->post('mass') == 0 && $this->input->post('percentage') == 0 && $this->input->post('muscle') == 0 && $this->input->post('head') == 0 && $this->input->post('saturation') == 0){
                $data['signs']            = 0;
               
                $data['height']           = $this->input->post('height');
                $data['weight']           = $this->input->post('weight');
                $data['temperature']      = $this->input->post('temperature');
                $data['frequency']        = $this->input->post('frequency');
                $data['systolic']         = $this->input->post('systolic');
                $data['diastolic']        = $this->input->post('diastolic');
                $data['heart']            = $this->input->post('heart');
                $data['mass']             = $this->input->post('mass');
                $data['percentage']       = $this->input->post('percentage');
                $data['muscle']           = $this->input->post('muscle');
                $data['head']             = $this->input->post('head');
                $data['saturation']       = $this->input->post('saturation');}
            else{
                $data['signs']            = $this->input->post('signs');
                $data['height']           = $this->input->post('height');
                $data['weight']           = $this->input->post('weight');
                $data['temperature']      = $this->input->post('temperature');
                $data['frequency']        = $this->input->post('frequency');
                $data['systolic']         = $this->input->post('systolic');
                $data['diastolic']        = $this->input->post('diastolic');
                $data['heart']            = $this->input->post('heart');
                $data['mass']             = $this->input->post('mass');
                $data['percentage']       = $this->input->post('percentage');
                $data['muscle']           = $this->input->post('muscle');
                $data['head']             = $this->input->post('head');
                $data['saturation']       = $this->input->post('saturation');}
            
            }
        if($this->input->post('signs') == 0){
            $data['signs']            = $this->input->post('signs');
            $data['height']           = 0;
            $data['weight']           = 0;
            $data['temperature']      = 0;
            $data['frequency']        = 0;
            $data['systolic']         = 0;
            $data['diastolic']        = 0;
            $data['heart']            = 0;
            $data['mass']             = 0;
            $data['percentage']       = 0;
            $data['muscle']           = 0;
            $data['head']             = 0;
            $data['saturation']       = 0;}
            
            
        if($this->input->post('labs') == 1){
            if( $this->input->post('erythrocytes') == 0 && $this->input->post('hematocrit') == 0 && $this->input->post('hemoglobin') == 0 && $this->input->post('blood_cells') == 0 && $this->input->post('platelets') == 0 && $this->input->post('reticulocytes') == 0 && $this->input->post('nitrogen') == 0 && $this->input->post('co2') == 0 && $this->input->post('chloride') == 0 && $this->input->post('potassium') == 0 && $this->input->post('sodium') == 0 && $this->input->post('glucose') == 0 && $this->input->post('creatinine') == 0 && $this->input->post('calcium') == 0 && $this->input->post('cholesterol') == 0 && $this->input->post('vldl') == 0 && $this->input->post('ldl') == 0 && $this->input->post('hdl') == 0 && $this->input->post('triglycerides') == 0){
                $data['labs']             = 0;
                $data['erythrocytes']     = $this->input->post('erythrocytes');
                $data['hematocrit']       = $this->input->post('hematocrit');
                $data['hemoglobin']       = $this->input->post('hemoglobin');
                $data['blood_cells']      = $this->input->post('blood_cells');
                $data['platelets']        = $this->input->post('platelets');
                $data['reticulocytes']    = $this->input->post('reticulocytes');
                $data['nitrogen']         = $this->input->post('nitrogen');
                $data['co2']              = $this->input->post('co2');
                $data['chloride']         = $this->input->post('chloride');
                $data['potassium']        = $this->input->post('potassium');
                $data['sodium']           = $this->input->post('sodium');
                $data['glucose']          = $this->input->post('glucose');
                $data['creatinine']       = $this->input->post('creatinine');
                $data['calcium']          = $this->input->post('calcium');
                $data['cholesterol']      = $this->input->post('cholesterol');
                $data['vldl']             = $this->input->post('vldl');
                $data['ldl']              = $this->input->post('ldl');
                $data['hdl']              = $this->input->post('hdl');
                $data['triglycerides']    = $this->input->post('triglycerides');}
            else{
                $data['labs']             = $this->input->post('labs');
                $data['erythrocytes']     = $this->input->post('erythrocytes');
                $data['hematocrit']       = $this->input->post('hematocrit');
                $data['hemoglobin']       = $this->input->post('hemoglobin');
                $data['blood_cells']      = $this->input->post('blood_cells');
                $data['platelets']        = $this->input->post('platelets');
                $data['reticulocytes']    = $this->input->post('reticulocytes');
                $data['nitrogen']         = $this->input->post('nitrogen');
                $data['co2']              = $this->input->post('co2');
                $data['chloride']         = $this->input->post('chloride');
                $data['potassium']        = $this->input->post('potassium');
                $data['sodium']           = $this->input->post('sodium');
                $data['glucose']          = $this->input->post('glucose');
                $data['creatinine']       = $this->input->post('creatinine');
                $data['calcium']          = $this->input->post('calcium');
                $data['cholesterol']      = $this->input->post('cholesterol');
                $data['vldl']             = $this->input->post('vldl');
                $data['ldl']              = $this->input->post('ldl');
                $data['hdl']              = $this->input->post('hdl');
                $data['triglycerides']    = $this->input->post('triglycerides');}}
            if($this->input->post('labs') == 0){
                $data['labs']             = $this->input->post('labs');
                $data['erythrocytes']     = 0;
                $data['hematocrit']       = 0;
                $data['hemoglobin']       = 0;
                $data['blood_cells']      = 0;
                $data['platelets']        = 0;
                $data['reticulocytes']    = 0;
                $data['nitrogen']         = 0;
                $data['co2']              = 0;
                $data['chloride']         = 0;
                $data['potassium']        = 0;
                $data['sodium']           = 0;
                $data['glucose']          = 0;
                $data['creatinine']       = 0;
                $data['calcium']          = 0;
                $data['cholesterol']      = 0;
                $data['vldl']             = 0;
                $data['ldl']              = 0;
                $data['hdl']              = 0;
                $data['triglycerides']    = 0;}

        if($this->input->post('nutri') == 1){
            if($this->input->post('lost_weight') == 0 && $this->input->post('water') == 0 && $this->input->post('grease') == 0 && $this->input->post('nutri_muscle') == 0 && $this->input->post('waist') == 0 && $this->input->post('abdomen') == 0){
                $data['nutri']            = 0;    
                $data['lost_weight']      = $this->input->post('lost_weight');    
                $data['water']            = $this->input->post('water');    
                $data['grease']           = $this->input->post('grease');    
                $data['nutri_muscle']     = $this->input->post('nutri_muscle');    
                $data['waist']            = $this->input->post('waist');    
                $data['abdomen']          = $this->input->post('abdomen');}
             else{
                $data['nutri']            = $this->input->post('nutri');    
                $data['lost_weight']      = $this->input->post('lost_weight');    
                $data['water']            = $this->input->post('water');    
                $data['grease']           = $this->input->post('grease');    
                $data['nutri_muscle']     = $this->input->post('nutri_muscle');    
                $data['waist']            = $this->input->post('waist');    
                $data['abdomen']          = $this->input->post('abdomen');}}
            if($this->input->post('nutri') == 0){
                $data['nutri']            = $this->input->post('nutri');
                $data['lost_weight']      = 0;    
                $data['water']            = 0;    
                $data['grease']           = 0;    
                $data['nutri_muscle']     = 0;    
                $data['waist']            = 0;    
                $data['abdomen']          = 0;}
        
        if($this->input->post('cetosis') == 1){
            if($this->input->post('satiety') == 0 && $this->input->post('halitosis') == 0 && $this->input->post('cramps') == 0 && $this->input->post('hungry') == 0 && $this->input->post('diarrhea') == 0 && $this->input->post('sleeping') == 0 && $this->input->post('depressed') == 0 && $this->input->post('impatient') == 0 && $this->input->post('tolerance') == 0 && $this->input->post('estimulantes') == 0 && $this->input->post('constipation') == 0 && $this->input->post('migraine') == 0 && $this->input->post('vertigo') == 0 && $this->input->post('fatigue') == 0 && $this->input->post('anxiety') == 0 && $this->input->post('concentration') == 0 && $this->input->post('irritability') == 0 && $this->input->post('aggressiveness') == 0 && $this->input->post('impulse') == 0){
            $data['cetosis']          = 0;    
            $data['satiety']          = $this->input->post('satiety');    
            $data['halitosis']        = $this->input->post('halitosis');    
            $data['cramps']           = $this->input->post('cramps');    
            $data['hungry']           = $this->input->post('hungry');    
            $data['diarrhea']         = $this->input->post('diarrhea');    
            $data['sleeping']         = $this->input->post('sleeping');    
            $data['depressed']        = $this->input->post('depressed');    
            $data['impatient']        = $this->input->post('impatient');    
            $data['tolerance']        = $this->input->post('tolerance');    
            $data['estimulantes']     = $this->input->post('estimulantes');    
            $data['constipation']     = $this->input->post('constipation');    
            $data['migraine']         = $this->input->post('migraine');    
            $data['vertigo']          = $this->input->post('vertigo');    
            $data['fatigue']          = $this->input->post('fatigue');    
            $data['anxiety']          = $this->input->post('anxiety');    
            $data['concentration']    = $this->input->post('concentration');    
            $data['irritability']     = $this->input->post('irritability');    
            $data['aggressiveness']   = $this->input->post('aggressiveness');    
            $data['impulse']          = $this->input->post('impulse');}    
        else{
            $data['cetosis']          = $this->input->post('cetosis');    
            $data['satiety']          = $this->input->post('satiety');    
            $data['halitosis']        = $this->input->post('halitosis');    
            $data['cramps']           = $this->input->post('cramps');    
            $data['hungry']           = $this->input->post('hungry');    
            $data['diarrhea']         = $this->input->post('diarrhea');    
            $data['sleeping']         = $this->input->post('sleeping');    
            $data['depressed']        = $this->input->post('depressed');    
            $data['impatient']        = $this->input->post('impatient');    
            $data['tolerance']        = $this->input->post('tolerance');    
            $data['estimulantes']     = $this->input->post('estimulantes');    
            $data['constipation']     = $this->input->post('constipation');    
            $data['migraine']         = $this->input->post('migraine');    
            $data['vertigo']          = $this->input->post('vertigo');    
            $data['fatigue']          = $this->input->post('fatigue');    
            $data['anxiety']          = $this->input->post('anxiety');    
            $data['concentration']    = $this->input->post('concentration');    
            $data['irritability']     = $this->input->post('irritability');    
            $data['aggressiveness']   = $this->input->post('aggressiveness');    
            $data['impulse']          = $this->input->post('impulse');}}
        if($this->input->post('cetosis') == 0){
            $data['cetosis']          = 0;
            $data['satiety']          = 0;    
            $data['halitosis']        = 0;    
            $data['cramps']           = 0;    
            $data['hungry']           = 0;    
            $data['diarrhea']         = 0;    
            $data['sleeping']         = 0;    
            $data['depressed']        = 0;    
            $data['impatient']        = 0;    
            $data['tolerance']        = 0;    
            $data['estimulantes']     = 0;    
            $data['constipation']     = 0;    
            $data['migraine']         = 0;    
            $data['vertigo']          = 0;    
            $data['fatigue']          = 0;    
            $data['anxiety']          = 0;    
            $data['concentration']    = 0;    
            $data['irritability']     = 0;
            $data['aggressiveness']   = 0;
            $data['impulse']          = 0;}
        
        $data['odonto']           = $this->input->post('odonto');    
        $data['trata']            = $this->input->post('trata'); 
        $data['teleconsulta']     = $this->input->post('teleconsulta');    
        
        $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
        $this->db->update('clinic', $data);
    }
    
    function getMin()
    {
        $time = explode(':',$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->morning);
        $ex_time = $time[0];
        if($ex_time < 10){
            $return = str_replace('0','', $ex_time);
        }else{
            $return = $ex_time;
        }
        echo $return;
    }
    
    function getMax()
    {
        $time = explode(':',$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->b_afternoon);
        $ex_time = $time[0];
        if($ex_time < 10){
            $return = str_replace('0','', $ex_time);
        }else{
            $return = $ex_time;
        }
        echo $return;
    }
    
    function get_service($service_id)
    {
        return $this->db->get_where('service', array('service_id' => $service_id))->row()->name;
    }
    
    function check_online_status($user_type, $user_id)
    {
        $this->db->group_by('gp');
        $this->db->where('gp', $user_id."-".$user_type);
        return $usuarios = $this->db->get('online_users')->num_rows();
    }
    
    function create_clinic()
    {
        $morning            = $this->set_24hrs($this->input->post('morning'));
        $b_morning          = $this->set_24hrs($this->input->post('b_morning'));
        $afternoon          = $this->set_24hrs($this->input->post('afternoon'));
        $b_afternoon        = $this->set_24hrs($this->input->post('b_afternoon'));
        $code               = $this->crud_model->getCode();
        $first_name         = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->first_name;
        $second_name        = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->second_name;
        $third_name         = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->third_name;
        $last_name          = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->last_name;
        $second_last_name   = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->second_last_name;
        $married_last_name  = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->married_last_name;
        $phone              = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->phone;
        $email              = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->email;
        $address            = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')))->row()->address;



        $code= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->code;


        $dataUpdate['name']              = $this->input->post('name');
        $dataUpdate['address']           = $this->input->post('address');
        $dataUpdate['email']             = $this->input->post('email');
        $dataUpdate['phone']             = $this->input->post('phone');
        $dataUpdate['morning']           = $morning;
        $dataUpdate['b_morning']         = $b_morning;
        $dataUpdate['afternoon']         = $afternoon;
        $dataUpdate['b_afternoon']       = $b_afternoon;
        $dataUpdate['time_interval']     = $this->input->post('interval');
        $dataUpdate['theme']             = '#0044E9';
        $dataUpdate['currency']          = 'Q';
        $dataUpdate['first_name']        = $first_name;
        $dataUpdate['second_name']       = $second_name;
        $dataUpdate['third_name']        = $third_name;
        $dataUpdate['last_name']         = $last_name;
        $dataUpdate['second_last_name']  = $second_last_name;
        $dataUpdate['married_last_name'] = $married_last_name;
        $dataUpdate['phonex']            = $phone;
        $dataUpdate['emailx']            = $email;
        $dataUpdate['addressx']          = $address;
        $dataUpdate['code']              = $code;

        $result = $this->send_api_create($dataUpdate);
        
        $data['name']          = $this->input->post('name');
        $data['address']       = $this->input->post('address');
        $data['email']         = $this->input->post('email');
        $data['phone']         = $this->input->post('phone');
        $data['morning']       = $morning;
        $data['b_morning']     = $b_morning;
        $data['afternoon']     = $afternoon;
        $data['b_afternoon']   = $b_afternoon;
        $data['time_interval'] = $this->input->post('interval');
        $data['theme']         = '#0044E9';
        $data['logo']         = "default_clinc.png";
        $data['status']        = 1;
        $data['code']          = $code;
        $this->db->insert('clinic', $data);
        $clinic_id = $this->db->insert_id();
        $this->log_model->create_clinic($clinic_id); 
    }
    
    function send_api_create($data_array){
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL =>"https://medicaby.com/api/createClinic",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_array,
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    return $response; 
    }
    
    function delete_clinic($clinic_id)
    {
        $this->log_model->delete_clinic($clinic_id);
        
        //Agregar que se elimen todas las cosas relacionadas a esta clinica.
        $data['status'] = 0;
        $this->db->where('clinic_id',$clinic_id);
        $this->db->update('clinic', $data);
    }
    
    function update_clinic($clinic_id)
    {
        $morning        = $this->set_24hrs($this->input->post('morning'));
        $b_morning      = $this->set_24hrs($this->input->post('b_morning'));
        $afternoon      = $this->set_24hrs($this->input->post('afternoon'));
        $b_afternoon    = $this->set_24hrs($this->input->post('b_afternoon'));
        $code= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->code;

        $dataUpdate['name']          = $this->input->post('name');
        $dataUpdate['address']       = $this->input->post('address');
        $dataUpdate['email']         = $this->input->post('email');
        $dataUpdate['phone']         = $this->input->post('phone');
        $dataUpdate['morning']       = $morning;
        $dataUpdate['b_morning']     = $b_morning;
        $dataUpdate['afternoon']     = $afternoon;
        $dataUpdate['b_afternoon']   = $b_afternoon;
        $dataUpdate['time_interval'] = $this->input->post('interval');
        $dataUpdate['code']=$code;
        $result = $this->send_api_hrs($dataUpdate);

        $data['name']          = $this->input->post('name');
        $data['address']       = $this->input->post('address');
        $data['email']         = $this->input->post('email');
        $data['phone']         = $this->input->post('phone');
        $data['morning']       = $morning;
        $data['b_morning']     = $b_morning;
        $data['afternoon']     = $afternoon;
        $data['b_afternoon']   = $b_afternoon;
        $data['time_interval'] = $this->input->post('interval');

        
        $this->db->where('clinic_id',$clinic_id);
        $this->db->update('clinic', $data);
    }
    function send_api_hrs($data_array){
        /* $domain= $this->db->get_where('clinic',array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->domain;
        log_message('error', $domain); */

        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL =>"https://medicaby.com/api/updateHrsContract",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_array,
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    return $response; 
    }

    function set_24hrs($hour)
    {
        $New_hr    = date('H:i', strtotime($hour));
        return $New_hr;
    }

    function interval($start, $end, $interval) 
    {
        $start  = new DateTime($start);
        $end    = new DateTime($end);
        $end->modify('+1 second'); // Añadimos 1 segundo para que nos muestre hora fin.
        // Si la hora de inicio es superior a la hora fin
        // añadimos un día más a la hora fin
        if ($start > $end) 
        {        
            $end->modify('+1 day');
        }
        // Establecemos el intervalo en minutos        
        $interval = new DateInterval('PT'.$interval.'M');
        // Sacamos los periodos entre las horas
        $periodo   = new DatePeriod($start, $interval, $end);        
        foreach( $periodo as $hora ) 
        {
            // Guardamos las horas intervalos 
            $hours[] =  $hora->format('H:i');
        }
        return $hours;
    }
    
    function formatear($fecha)
    {
        $date = explode("/", $fecha);
        $dia  = $date[0];
        $mes  = $date[1];
        $anio = $date[2];
        $string_month = "";
        
        if($mes == '01'){
            $string_month = "Enero";
        }elseif($mes == '02'){
            $string_month = "Febrero";
        }
        elseif($mes == '03'){
            $string_month = "Marzo";
        }
        elseif($mes == '04'){
            $string_month = "Abril";
        }
        elseif($mes == '05'){
            $string_month = "Mayo";
        }
        elseif($mes == '06'){
            $string_month = "Junio";
        }
        elseif($mes == '07'){
            $string_month = "Julio";
        }
        elseif($mes == '08'){
            $string_month = "Agosto";
        }
        elseif($mes == '09'){
            $string_month = "Septiembre";
        }
        elseif($mes == '10'){
            $string_month = "Octubre";
        }
        elseif($mes == '11'){
            $string_month = "Noviembre";
        }
        elseif($mes == '12'){
            $string_month = "Diciembre";
        }
        
        return $dia. " ".$string_month;
    }
    
    function formatear2($fecha)
    {
        if($fecha != '')
            {
                    $date = explode("/", $fecha);

                    $dia  = $date[0];
                    $mes  = $date[1];
                    $anio = $date[2];
                    $string_month = "";
                    
                    if($mes == '01'){
                        $string_month = "Enero";
                    }elseif($mes == '02'){
                        $string_month = "Febrero";
                    }
                    elseif($mes == '03'){
                        $string_month = "Marzo";
                    }
                    elseif($mes == '04'){
                        $string_month = "Abril";
                    }
                    elseif($mes == '05'){
                        $string_month = "Mayo";
                    }
                    elseif($mes == '06'){
                        $string_month = "Junio";
                    }
                    elseif($mes == '07'){
                        $string_month = "Julio";
                    }
                    elseif($mes == '08'){
                        $string_month = "Agosto";
                    }
                    elseif($mes == '09'){
                        $string_month = "Septiembre";
                    }
                    elseif($mes == '10'){
                        $string_month = "Octubre";
                    }
                    elseif($mes == '11'){
                        $string_month = "Noviembre";
                    }
                    elseif($mes == '12'){
                        $string_month = "Diciembre";
                    }
                    
                    if($dia > 0 && $string_month != '' && $anio > 0)
                    {
                        return $dia. " de ".$string_month." del ".$anio;
                    }
            
                    else
                    {
                        return 'Sin registros';    
                    }
    }else
    {

        return 'Sin registros';    

    }
        
    }
    
    
    
    
    function setFormat($fecha)
    {
        $date = explode("/", $fecha);
        $dia  = $date[0];
        $mes  = $date[1];
        $anio = $date[2];
        $string_month = "";
        $string_day   = "";
        $string_month = $mes;
        $string_day = $dia;
        return $string_month."/".$string_day.'/'.$anio;
    }


    
    function panelDate()
    {
        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
        return $dias;
    }
    
    function formatDate()
    {
        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('d')." de ".$meses[date('n')-1]." ".date('H:iA');
    }
    
    function formatDates()
    {
        $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('d')." de ".$meses[date('n')-1];
    }


    function create_room()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $this->db->insert('room',$data);
    }
    
    function update_room($room_id)
    {
        $data['name']            = $this->input->post('name');
        $data['description']     = $this->input->post('description');
        $data['status']         = $this->input->post('status');
        $this->db->where('room_id',$room_id);
        $this->db->update('room', $data);
    }
    
    function delete_room($room_id)
    {
        $this->db->where('room_id', $room_id);
        $this->db->delete('room');
    }

    function create_surgery_room()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $this->db->insert('surgery_room',$data);
    }
    
    function update_surgery_room($room_id)
    {
        $data['name']            = $this->input->post('name');
        $data['description']     = $this->input->post('description');
        $data['status']          =   $this->input->post('status');

        $this->db->where('surgery_room_id',$room_id);
        $this->db->update('surgery_room', $data);
    }
    
    function delete_surgery_room($room_id)
    {
        $this->db->where('surgery_room_id', $room_id);
        $this->db->delete('surgery_room');
    }

    
    
    function create_service()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['cost']        = $this->input->post('cost');
        $data['price'] = $this->input->post('price');
        $this->db->insert('service',$data);
        $service_id = $this->db->insert_id();
        $this->log_model->new_service($service_id);
    }
    
    function update_service($service_id)
    {
        $data['name']            = $this->input->post('name');
        $data['cost']            = $this->input->post('cost');
        $data['price'] = $this->input->post('price');
        $this->db->where('service_id',$service_id);
        $this->db->update('service', $data);
    }
    
    function delete_service($service_id)
    {
        $this->db->where('service_id', $service_id);
        $this->db->delete('service');
    }

    function create_process()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['cost']        = $this->input->post('cost');
        $data['price']        = $this->input->post('price');
        $this->db->insert('process',$data);
      
    }
    
    function update_process($process_id)
    {
        $data['name']            = $this->input->post('name');
        $data['cost']            = $this->input->post('cost');
        $data['price']           = $this->input->post('price');
        $this->db->where('process_id',$process_id);
        $this->db->update('process', $data);
    }
    
    function delete_process($process_id)
    {
        $data['status'] = 0;
        $this->db->where('process_id',$process_id);
        $this->db->update('process', $data);
    }
 
 
   function create_insurance()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['nit']         = $this->input->post('nit');
        $data['date']     = $this->input->post('date');
        $data['address']     = $this->input->post('address');
        $this->db->insert('insurance', $data);
    }
    
    function update_insurance($insurance_id)
    {
        $data['name']  = $this->input->post('name');
        $data['nit']         = $this->input->post('nit');
        $data['date']     = $this->input->post('date');
        $data['address']     = $this->input->post('address');
        $this->db->where('insurance_id',$insurance_id);
        $this->db->update('insurance', $data);
    }
    
       
    function delete_insurance($insurance_id)
    { 
        $data['status'] = 0;
        $this->db->where('insurance_id',$insurance_id);
        $this->db->update('insurance', $data);
    }
    
    
    
    function create_specialtie()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $this->db->insert('specialtie', $data);
        $special_id = $this->db->insert_id();
        $this->log_model->create_special($special_id);
    }
    
    function update_specialtie($specialtie_id)
    {
        $data['name']  = $this->input->post('name');
        $this->db->where('specialtie_id',$specialtie_id);
        $this->db->update('specialtie', $data);
    }
    
       
    function delete_specialtie($specialtie_id)
    {
        $this->log_model->delete_special($specialtie_id);
        
        $this->db->where('specialtie_id', $specialtie_id);
        $this->db->delete('specialtie');
    }
     //Funciones para los laboratorios
    
     function create_laboratory()
     {
         $data['name']     = $this->input->post('name');
         $data['description'] = trim($this->input->post('description'));
         $data['clinic_id'] = $this->session->userdata('current_clinic');
 
         $response = $this->db->insert('laboratory', $data);
 
         $type = $this->session->userdata('login_type');
         $mensaje = "Ha creado una nuevo laboratorio: ".$data['name'];
         
             
         return $response;
     }
     
     function update_laboratory($ID)
     {
         $data['name']     = $this->input->post('name');
         $data['description'] = trim($this->input->post('description'));
         
         $response = $this->db->where('laboratory_id', $ID)->update('laboratory', $data);
         
         $type = $this->session->userdata('login_type');
         $mensaje = "Ha Actualizado el laboratorio llamado: ".$this->input->post('name');
       
             
         return $response;
     }
     
     function delete_laboratory($ID)
     {
         $data['status'] = 0;
         $response = $this->db->where('laboratory_id', $ID)->update('laboratory', $data);
         
         $response = $this->db->where('laboratory_id', $ID)->update('laboratory_fields', $data);
 
 
         $type = $this->session->userdata('login_type');
         $mensaje = "Ha eliminado un laboratorio con ID: ".$ID;
       
             
         return $response;
     }

     function getPatients(){
        $branch_id = $this->session->userdata('current_clinic');
        $name = $this->input->post('name');

        if($name == "")
        {
            $this->db->limit(1);
        }
        $this->db->limit(10);
        $this->db->where("first_name like '%". $name."%' and status = 1");
        $this->db->or_where("second_name like '%". $name."%' and status = 1");
        $this->db->or_where("concat(first_name,' ',second_name) like '%". $name."%' and status = 1");
        $this->db->or_where("concat(first_name,' ',second_name,' ',third_name) like '%". $name."%' and status = 1");
        $this->db->or_where("concat(first_name,' ',second_name,' ',third_name,' ',last_name) like '%". $name."%' and status = 1");
        $this->db->or_where("concat(first_name,' ',second_name,' ',third_name,' ',last_name,' ',second_last_name) like '%". $name."%' and status = 1");
        $pattiens = $this->db->get_where('patient', array('status'=>1));
        $html =' ';
        if($pattiens->num_rows() > 0){
        
            
            foreach ($pattiens->result_array() as $row) {
                $html .='<tr class="resultado ">
                    <td>
                        <a href="javascript:;" id="btnPatient-'.$row['patient_id'].'"  onclick="paciente('.$row['patient_id'].',0)" > <b> '.$row['first_name'].' '.$row['second_name'].' '.$row['last_name'].' '.$row['second_last_name'].'</b> </a>
                    </td>
                </tr>';
            }
         
            
        }else{
            $html .='<tr class="resultado">
                        <td class="textd-danger">
                            Paciente no encontrado
                        </td>
                    </tr>
               ';
        }
        
        return $html;

    } 
     
    function create_rayos_x()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['price_day']       = $this->input->post('price_day');
        $data['price_night']     = $this->input->post('price_night');
        $this->db->insert('rayos_x', $data);
        $lab_id = $this->db->insert_id();
        //$this->log_model->create_laboratory($lab_id);
    }
    
    function update_rayos_x($rayos_x_id)
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['price_day']   = $this->input->post('price_day');
        $data['price_night'] = $this->input->post('price_night');
        $this->db->where('rayos_x_id',$rayos_x_id);
        $this->db->update('rayos_x', $data);
    }
    
    function delete_rayos_x($rayos_x_id)
    {
        $this->log_model->delete_lab($rayos_x_id);
        $this->db->where('rayos_x_id', $rayos_x_id);
        $this->db->delete('rayos_x');
    }


    function create_product_estb()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['price_day']       = $this->input->post('price_day');
        $data['price_night']     = $this->input->post('price_night');
        $this->db->insert('product_estb', $data);
        $lab_id = $this->db->insert_id();
        //$this->log_model->create_laboratory($lab_id);
    }
    
    function update_product_estb($product_estb_id)
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['price_day']   = $this->input->post('price_day');
        $data['price_night'] = $this->input->post('price_night');
        $this->db->where('product_estb_id',$product_estb_id);
        $this->db->update('product_estb', $data);
    }
    
    function delete_product_estb($product_estb_id)
    {
        //$this->log_model->delete_lab($product_estb_id);
        $this->db->where('product_estb_id', $product_estb_id);
        $this->db->delete('product_estb');
    }
    
    function create_third()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['name']        = $this->input->post('name');
        $data['phone']       = $this->input->post('phone');
        $data['address']     = $this->input->post('address');
        $data['type']        = $this->input->post('type');
        $data['email']       = $this->input->post('email');
        $this->db->insert('third', $data);
        $lab_id = $this->db->insert_id();
        $this->log_model->create_laboratory($lab_id);
    }
    
    function update_third($laboratory_id)
    {
        $data['clinic_id']      = $this->session->userdata('current_clinic');
        $data['name']           = $this->input->post('name');
        $data['phone']          = $this->input->post('phone');
        $data['address']     = $this->input->post('address');
        $data['type']     = $this->input->post('type');
        $data['email']     = $this->input->post('email');
        $this->db->where('terceros_id',$laboratory_id);
        $this->db->update('third', $data);
    }
    
    function delete_third($laboratory_id)
    {
        $this->log_model->delete_lab($laboratory_id);
        $this->db->where('terceros_id', $laboratory_id);
        $this->db->delete('terceros');
    }
    
    function update_inventory($product_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['image']['name']);

        if($_FILES['image']['name'] != ''){
            $data['image']              = $name;
            $archivo    = $this->db->get_where('product', array('product_id' => $product_id))->row()->img;
            unlink('public/uploads/inventory/'.$archivo);
            move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
        }

        $data['name']               = $this->input->post('name');
        $data['presentation']       = $this->input->post('presentation');
        $data['provider']           = $this->input->post('provider');
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['code']               = $this->input->post('code');
        $data['cost']               = $this->input->post('cost');
        $data['price']              = $this->input->post('price');
        $data['initial_inventory']  = $this->input->post('initial_inventory');
        $data['stock']              = $data['initial_inventory'];
        $data['amount_alert']       = $this->input->post('amount_alert');
        $data['componente']         = $this->input->post('componente');
        $data['concentracion']      = $this->input->post('concentracion');

        $data['amount_maxima']       = $this->input->post('amount_maxima');
        $data['ubication']           = $this->input->post('ubication');
        $data['amount_presentation'] = $this->input->post('amount_presentation');
        $data['storage']             = $this->input->post('storage');
        $data['margin']              = $this->input->post('margin');

        $data['category']           = $this->input->post('categories');
        $data['expiration']         = $this->input->post('expiration');
        
        $this->db->where('product_id',$product_id);
        $this->db->update('product', $data);
        $this->log_model->update_product($product_id);
    }
    
    function delete_inventory($product_id)
    {
        $img    = $this->db->get_where('product', array('product_id' => $product_id))->row()->image;
        if($img != '')
        {
            unlink('public/uploads/inventory/'.$img);    
        }

        $data['status'] = 0;
        $this->log_model->delete_product($product_id);
        $this->db->where('product_id', $product_id);
        $this->db->update('product',$data);

        $this->db->where('product_id', $product_id);
        $this->db->update('product_lote',$data);


    }


    function create_combo()
    {
        $products        =   $this->input->post('products');
        $description     =   $this->input->post('description');
        $amount =   $this->input->post('amount');
     

        $number_of_entries   =   sizeof($products);
        $sales_order_entries =   array();
        for($i = 0; $i < $number_of_entries; $i++) 
        {
            if($products[$i] != "")
            {
                
                $new_order_entry    =   array(
                    'product' => $products[$i],
                    'description' => $description[$i],
                    'amount' => $amount[$i],
                   
                );
                array_push($sales_order_entries , $new_order_entry);
            }
        }
        $data['code']      =   $this->input->post('code');
        $data['name']      =   $this->input->post('name');
        $data['date']      =  $this->formatDate();
        $data['user_id']   =  $this->session->userdata('login_user_id');
        $data['user_type'] =  $this->session->userdata('login_type');
        $data['products']  =  serialize($sales_order_entries);
        $data['status']    =  1;
        $data['price_1']      =   $this->input->post('price_1');
        $data['price_2']      =   $this->input->post('price_2');
        $data['price_3']      =   $this->input->post('price_3');
        $this->db->insert('combo', $data);
        
    }

    function update_combo($pedidos_id)
    {
        $products        =   $this->input->post('products');
        $description     =   $this->input->post('description');
        $amount =   $this->input->post('amount');
     

        $number_of_entries   =   sizeof($products);
        $sales_order_entries =   array();
        for($i = 0; $i < $number_of_entries; $i++) 
        {
            if($products[$i] != "")
            {
                
                $new_order_entry    =   array(
                    'product' => $products[$i],
                    'description' => $description[$i],
                    'amount' => $amount[$i],
                   
                );
                array_push($sales_order_entries , $new_order_entry);
            }
        }
        
        $data['products']  =  serialize($sales_order_entries);
        $this->db->where('pedidos_id', $pedidos_id);
        $this->db->update('pedidos', $data);
        
    }

    function delete_combo($pedidos_id)
    {
        

        $data['status']    =  0;
        $this->db->where('pedidos_id', $pedidos_id);
        $this->db->update('pedidos', $data);
        
    }


    
    
    function set_solicitud($pedidos_id)
    {
        

        $data['status']    =  2;
        $this->db->where('pedidos_id', $pedidos_id);
        $this->db->update('pedidos', $data);
        
    }

    function create_inventory_iv()
    {
        
        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['image']['name']);
        $data['name']               = $this->input->post('name');
        $data['code']               = $this->input->post('code');
        $data['category_id']        = $this->input->post('category_id');
        $data['cost']               = $this->input->post('cost');
        $data['price']              = $this->input->post('price');
        $data['expiration_date']    = $this->input->post('expiration_date');
        $data['stock']              = $this->input->post('stock');
        $data['amount_alert']       = $this->input->post('amount_alert');
        $data['compuesto']    = $this->input->post('compuesto');
        $data['casa_farm']              = $this->input->post('casa_farm');
        $data['unidad']       = $this->input->post('unidad');
        $data['image']              = $name;
        $data['description']        = $this->input->post('description');
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $this->db->insert('product_iv', $data);
        $product_id = $this->db->insert_id();
        move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
        $this->log_model->new_product($product_id);
    }
    
    function update_inventory_iv($product_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['image']['name']);
        if($_FILES['image']['name'] != ''){
            $data['image']              = $name;
        }
        $data['name']               = $this->input->post('name');
        $data['code']               = $this->input->post('code');
        $data['category_id']        = $this->input->post('category_id');
        $data['cost']               = $this->input->post('cost');
        $data['price']              = $this->input->post('price');
        $data['expiration_date']    = $this->input->post('expiration_date');
        $data['compuesto']    = $this->input->post('compuesto');
        $data['casa_farm']              = $this->input->post('casa_farm');
        $data['unidad']       = $this->input->post('unidad');
        $data['stock']              = $this->input->post('stock');
        $data['amount_alert']       = $this->input->post('amount_alert');
        $data['description']        = $this->input->post('description');
        move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
        $this->db->where('product_id',$product_id);
        $this->db->update('product_iv', $data);
        $this->log_model->update_product($product_id);
    }
    
    function delete_inventory_iv($product_id)
    {
        $this->log_model->delete_product($product_id);
        $this->db->where('product_id', $product_id);
        $this->db->delete('product_iv');
    }

    
    function create_category()
    {
        $data['name']        = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        return $this->db->insert('category',$data);
    }
    
    function update_category($category_id)
    {
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['name']               = $this->input->post('name');
        $data['description']        = $this->input->post('description');
        $this->db->where('id',$category_id);
        $this->db->update('category', $data);
    }
    
    function delete_category($category_id)
    {

        $this->db->where('id', $category_id);
        $this->db->update('category',array('status'=>0));
    }
    


    function create_subcategory()
    {
        $data['category_id']        = $this->input->post('category_id');
        $data['name']        = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        return $this->db->insert('subcategory',$data);
    }
    
    function update_subcategory($category_id)
    {
        $data['category_id']        = $this->input->post('category_id');
        $data['name']               = $this->input->post('name');
        $data['description']        = $this->input->post('description');
        $this->db->where('id',$category_id);
        $this->db->update('subcategory', $data);
    }
    
    function delete_subcategory($category_id)
    {
       
        $this->db->where('id', $category_id);
        $this->db->update('subcategory',array('status'=>0));
    }


    function create_survey()
    {
        $data['clinic_id']   = $this->session->userdata('current_clinic');
        $data['title']       = $this->input->post('title');
        $data['admin_id']    = $doctor_id;
        $data['status']      = 1;
        $data['date']        = date('d/m/Y'); 
        $data['description'] = $this->input->post('description');
        $this->db->insert('survey',$data);
        $survey_id = $this->db->insert_id();
        $this->log_model->new_survey($survey_id);
        return $survey_id;
    }
    
    function update_survey($survey_id)
    {
        $data['title']            = $this->input->post('title');
        $data['description']      = $this->input->post('survey');
        $this->db->where('survey_id',$survey_id);
        $this->db->update('survey', $data);
    }
    
    function delete_survey($survey_id)
    {
        $this->db->where('survey_id', $survey_id);
        $this->db->delete('survey');
        $this->db->where('survey_id', $survey_id);
        $this->db->delete('question');
        $this->db->where('survey_id', $survey_id);
        $this->db->delete('survery_result');
    }
    
    
    function create_multiple_choice($survey_id)
    {
        $data['question']             = $this->input->post('question');
        $data['number_of_options']    = count($this->input->post('options'));
        $data['options']              = json_encode($this->input->post('options'));
        $data['type']                 = 'multiple_choice'; 
        $data['survey_id']            = $survey_id;
        $this->db->insert('question',$data);
        
    }
    
    
    function delete_question($question_id)
    {
        $this->db->where('question_id', $question_id);
        $this->db->delete('question');
    }
    
    function delete_questions($survey_id)
    {
        $this->db->where('survey_id', $survey_id);
        $this->db->delete('question');
    }
    
    function update_multiple_choice($question_id)
    {
        $data['question']             = $this->input->post('question');
        $data['number_of_options']    = count($this->input->post('options'));
        $data['options']              = json_encode($this->input->post('options'));
        $this->db->where('question_id',$question_id);
        $this->db->update('question', $data);
    }
    
     function create_text($survey_id)
    {
        $data['question']             = $this->input->post('question');
        $data['type']                 = 'text'; 
        $data['survey_id']            = $survey_id;
        $this->db->insert('question',$data);
        
    }
     function create_satisfaction($survey_id)
    {
        $data['question']             = $this->input->post('question');
        $data['type']                 = 'satisfaction'; 
        $data['survey_id']            = $survey_id;
        $this->db->insert('question',$data);
        
    }
    function update_question($question_id)
    {
        $data['question']    = $this->input->post('question');
        $this->db->where('question_id',$question_id);
        $this->db->update('question', $data);
    }
    
    
    function create_income()
    {


        include('public/apis/class.fileuploader.php');
        
        $FileUploader_reference_file = new FileUploader('reference_file', array('uploadDir' => 'public/uploads/income_image/'));
        $upload_reference_file = $FileUploader_reference_file->upload();
        if($upload_reference_file['isSuccess']) {
            $files = $upload_reference_file['files'];
        } else {
            $warningss = $upload_reference_file['warnings'];
        }
        
        $FileUploader_invoice_file = new FileUploader('invoice_file', array('uploadDir' => 'public/uploads/income_image/'));
        $upload_invoice_file = $FileUploader_invoice_file->upload();
        if($upload_invoice_file['isSuccess']) {
            $files = $upload_invoice_file['files'];
        } else {
            $warningss = $upload_invoice_file['warnings'];
        }
        
        if($_FILES['reference_file']['name'] != "")
        {$data['reference_file']    = $upload_reference_file['files'][0]['name'];}
        if($_FILES['invoice_file']['name'] != "")
        {$data['invoice_file']      = $upload_invoice_file['files'][0]['name'];}
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['user_id']            = $doctor_id;
        $data['user_type']          = $this->session->userdata('login_type');
        $data['description']        = $this->input->post('description');
        $data['amount']             = $this->input->post('amount');
        $data['method']             = $this->input->post('method');
        $data['reference']          = $this->input->post('reference');
        $data['invoice']            = $this->input->post('invoice');
        $data['invoice_code']       = $this->input->post('invoice_code');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['appointment_id']     = $this->input->post('appointment_id');
        $data['date']               = date('d/m/Y');
        $data['time']               = date('H:m');
        
        
        $this->db->insert('financial',$data);



        move_uploaded_file($_FILES['reference_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));
        move_uploaded_file($_FILES['invoice_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['invoice_file']['name']));
        $this->log_model->create_income($this->input->post('amount'));
        $this->notify_model->new_income();






    }


    function create_financial()
    {
        if($this->input->post('type') == 1)
        {

            $md5 = md5(date('d-m-Y H:i:s'));
            include('public/apis/class.fileuploader.php');
            
            $FileUploader_reference_file = new FileUploader('reference_file', array('uploadDir' => 'public/uploads/income_image/'));
            $upload_reference_file = $FileUploader_reference_file->upload();
            if($upload_reference_file['isSuccess']) {
                $files = $upload_reference_file['files'];
            } else {
                $warningss = $upload_reference_file['warnings'];
            }
            
            $FileUploader_invoice_file = new FileUploader('invoice_file', array('uploadDir' => 'public/uploads/income_image/'));
            $upload_invoice_file = $FileUploader_invoice_file->upload();
            if($upload_invoice_file['isSuccess']) {
                $files = $upload_invoice_file['files'];
            } else {
                $warningss = $upload_invoice_file['warnings'];
            }
            
            if(!empty($upload_reference_file['files']))
            {
                $data['reference_file']    = $upload_reference_file['files'][0]['name'];
                move_uploaded_file($_FILES['reference_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));
            }
            if(!empty($upload_invoice_file['files']))
            {
                $data['invoice_file']      = $upload_invoice_file['files'][0]['name'];
                move_uploaded_file($_FILES['invoice_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['invoice_file']['name']));
            }
            $data['clinic_id']          = $this->session->userdata('current_clinic');
            $data['user_id']            = $this->session->userdata('login_user_id');
            $data['user_type']          = $this->session->userdata('login_type');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['method']             = $this->input->post('method');
            $data['reference']          = $this->input->post('reference');
            $data['invoice']            = $this->input->post('invoice');
            $data['invoice_code']       = $this->input->post('invoice_code');
            $data['date']               = date('d/m/Y');
            $data['time']               = date('H:m');
            
            
            $this->db->insert('financial',$data);
            $this->log_model->create_income($this->input->post('amount'));
            $this->notify_model->new_income();


        }

        if($this->input->post('type') == 0)
        {
            $md5 = md5(date('d-m-Y H:i:s'));
            include('public/apis/class.fileuploader.php');
            
            $FileUploader_reference_file = new FileUploader('reference_file', array('uploadDir' => 'public/uploads/income_image/'));
            $upload_reference_file = $FileUploader_reference_file->upload();
            if($upload_reference_file['isSuccess']) {
                $files = $upload_reference_file['files'];
            } else {
                $warningss = $upload_reference_file['warnings'];
            }
            
            $FileUploader_invoice_file = new FileUploader('invoice_file', array('uploadDir' => 'public/uploads/income_image/'));
            $upload_invoice_file = $FileUploader_invoice_file->upload();
            if($upload_invoice_file['isSuccess']) {
                $files = $upload_invoice_file['files'];
            } else {
                $warningss = $upload_invoice_file['warnings'];
            }
            
            if(!empty($upload_reference_file['files']))
            {
                $data['reference_file']    = $upload_reference_file['files'][0]['name'];
                move_uploaded_file($_FILES['reference_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));
            }
            if(!empty($upload_invoice_file['files']))
            {
                $data['invoice_file']      = $upload_invoice_file['files'][0]['name'];
                move_uploaded_file($_FILES['invoice_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['invoice_file']['name']));
            }
            $data['clinic_id']          = $this->session->userdata('current_clinic');
            $data['user_id']            = $this->session->userdata('login_user_id');
            $data['user_type']          = $this->session->userdata('login_type');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['method']             = $this->input->post('method');
            $data['reference']          = $this->input->post('reference');
            $data['invoice']            = $this->input->post('invoice');
            $data['invoice_code']       = $this->input->post('invoice_code');
            $data['date']               = date('d/m/Y');
            $data['time']               = date('H:m');
            $data['type']               = 0;
            $data['de']               = 3;
            
            
            
            $this->db->insert('financial',$data);
            $this->log_model->create_income($this->input->post('amount'));
            $this->notify_model->new_income();


        }
      


    }

    
    
    
    function delete_income($income_id)
    {
        $this->log_model->delete_income($income_id);
        $this->db->where('financial_id', $income_id);
        $this->db->delete('financial');
    }
    
    function update_income($income_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
         include('public/apis/class.fileuploader.php');
        $this->log_model->update_income($income_id);
        $FileUploader_invoice_file = new FileUploader('invoice_file', array(
            'uploadDir' => 'public/uploads/income_image/'));
        $upload_invoice_file = $FileUploader_invoice_file->upload();
        if($upload_invoice_file['isSuccess']) {
            $files = $upload_invoice_file['files'];
        } else {
            $warningss = $upload_invoice_file['warnings'];
        }
        
        $FileUploader_reference_file = new FileUploader('reference_file', array(
            'uploadDir' => 'public/uploads/income_image/'));
        $upload_reference_file = $FileUploader_reference_file->upload();
        if($upload_reference_file['isSuccess']) {
            $files = $upload_reference_file['files'];
        } else {
            $warningss = $upload_reference_file['warnings'];
        }
        
        
        if($upload_reference_file['files'][0]['name'] != "")
        {
            $data['reference_file']         = $upload_reference_file['files'][0]['name'];
        }
        
        if($upload_invoice_file['files'][0]['name'] != "")
        {
            $data['invoice_file']         = $upload_invoice_file['files'][0]['name'];
        }
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['user_id']            = $doctor_id;
        $data['user_type']          = $this->session->userdata('login_type');
        $data['description']        = $this->input->post('description');
        $data['amount']             = $this->input->post('amount');
        $data['type']             = $this->input->post('type');
        $data['method']             = $this->input->post('method');
        $data['reference']          = $this->input->post('reference');
        $data['invoice']            = $this->input->post('invoice2');
        $data['invoice_code']       = $this->input->post('invoice_code');
        $this->db->where('financial_id',$income_id);
        $this->db->update('financial',$data);
        
        move_uploaded_file($_FILES['reference_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));
        move_uploaded_file($_FILES['invoice_file']['tmp_name'], 'public/uploads/income_image/' . $md5.str_replace(' ', '', $_FILES['invoice_file']['name']));
    }
    
    
     function create_expense()
    {
        $md5 = md5(date('d-m-Y H:i:s'));
         include('public/apis/class.fileuploader.php');
        
        $FileUploader_reference_file = new FileUploader('reference_file', array('uploadDir' => 'uploads/expense_image/'));
        $upload_reference_file = $FileUploader_reference_file->upload();
        if($upload_reference_file['isSuccess']) {
            $files = $upload_reference_file['files'];
        } else {
            $warningss = $upload_reference_file['warnings'];
        }
         if($_FILES['reference_file']['name'] != "")
        {$data['reference_file']    = $upload_reference_file['files'][0]['name'];}
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['user_id']            = $doctor_id;
        $data['user_type']          = $this->session->userdata('login_type');
        $data['description']        = $this->input->post('description');
        $data['amount']             = $this->input->post('amount');
        $data['provider']           = $this->input->post('provider');
        $data['reference']          = $this->input->post('reference');
        $data['date']               = date('d/m/Y');
        $data['time']               = date('H:m');
        $data['expense_category_id']= $this->input->post('expense_category_id');
        $this->db->insert('expense',$data);
        $this->log_model->create_expense($this->input->post('amount'));
        move_uploaded_file($_FILES['reference_file']['tmp_name'], 'public/uploads/expense_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));

    }
    
    
    
    function delete_expense($expense_id)
    {
        $this->log_model->delete_expense($expense_id);
        $this->db->where('expense_id', $expense_id);
        $this->db->delete('expense');
    }
    
    function update_expense($expense_id)
    {
         include('public/apis/class.fileuploader.php');
        $this->log_model->update_expense($expense_id);
        $FileUploader_reference_file = new FileUploader('reference_file', array(
            'uploadDir' => 'public/uploads/expense_image/'));
        $upload_reference_file = $FileUploader_reference_file->upload();
        if($upload_reference_file['isSuccess']) {
            $files = $upload_reference_file['files'];
        } else {
            $warningss = $upload_reference_file['warnings'];
        }
        
        if($upload_reference_file['files'][0]['name'] != "")
        {
            $data['reference_file'] = $upload_reference_file['files'][0]['name'];
        }
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['user_id']            = $doctor_id;
        $data['user_type']          = $this->session->userdata('login_type');
        $data['description']        = $this->input->post('description');
        $data['amount']             = $this->input->post('amount');
        $data['provider']           = $this->input->post('provider');
        $data['reference']          = $this->input->post('reference');
        $data['expense_category_id']= $this->input->post('expense_category_id');
        $this->db->where('expense_id',$expense_id);
        $this->db->update('expense',$data);
        move_uploaded_file($_FILES['reference_file']['tmp_name'], 'uploads/expense_image/' . $md5.str_replace(' ', '', $_FILES['reference_file']['name']));
    }
    
     function create_expense_category()
    {
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['name']               = $this->input->post('name');
        $data['description']        = $this->input->post('description');
        $this->db->insert('expense_category',$data);
        $expense_id = $this->db->insert_id();
        $this->log_model->new_expense_category($expense_id);
    }
   
    
    function delete_expense_category($expense_category_id)
    {
        $this->db->where('expense_category_id', $expense_category_id);
        $this->db->delete('expense_category');
    }
    
    function update_expense_category($expense_category_id)
    {
        $data['clinic_id']          = $this->session->userdata('current_clinic');
        $data['name']               = $this->input->post('name');
        $data['description']        = $this->input->post('description');
        $this->db->where('expense_category_id',$expense_category_id);
        $this->db->update('expense_category',$data);
    }
    
    
    function delete_allergie($allergie_id)
    {
        $this->db->where('allergie_id', $allergie_id);
        $this->db->delete('allergie');
    }
    
    function create_pathological()
    {
        $data['hospitalization']                = $this->input->post('hospitalization');
        $data['hospitalization_comment']        = $this->input->post('hospitalization_comment');
        $data['surgeries']                      = $this->input->post('surgeries');
        $data['surgeries_comment']              = $this->input->post('surgeries_comment');
        $data['diabetes']                       = $this->input->post('diabetes');
        $data['diabetes_comment']               = $this->input->post('diabetes_comment');
        $data['thyroid']                        = $this->input->post('thyroid');
        $data['thyroid_comment']                = $this->input->post('thyroid_comment');
        $data['hypertension']                   = $this->input->post('hypertension');
        $data['hypertension_comment']           = $this->input->post('hypertension_comment');
        $data['heart_disease']                  = $this->input->post('heart_disease');
        $data['heart_disease_comment']          = $this->input->post('heart_disease_comment');
        $data['trauma']                         = $this->input->post('trauma');
        $data['trauma_comment']                 = $this->input->post('trauma_comment');
        $data['cancer']                         = $this->input->post('cancer');
        $data['cancer_comment']                 = $this->input->post('cancer_comment');
        $data['tuberculosis']                   = $this->input->post('tuberculosis');
        $data['tuberculosis_comment']           = $this->input->post('tuberculosis_comment');
        $data['transfusions']                   = $this->input->post('transfusions');
        $data['transfusions_comment']            = $this->input->post('transfusions_comment');
        $data['pathologies']                    = $this->input->post('pathologies');
        $data['pathologies_comment']            = $this->input->post('pathologies_comment');
        $data['gastrointestinal']               = $this->input->post('gastrointestinal');
        $data['gastrointestinal_comment']       = $this->input->post('gastrointestinal_comment');
        $data['sexual']                         = $this->input->post('sexual');
        $data['sexual_comment']                 = $this->input->post('sexual_comment');
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $data['patient_id']                     = $this->input->post('patient_id');
        $data['date']                           = $this->crud_model->formatDate();
        $this->db->insert('pathological',$data);
    }
    
    
    function update_pathological($patient_id)
    {
        $data['hospitalization']                = $this->input->post('hospitalization');
        $data['hospitalization_comment']        = $this->input->post('hospitalization_comment');
        $data['surgeries']                      = $this->input->post('surgeries');
        $data['surgeries_comment']              = $this->input->post('surgeries_comment');
        $data['diabetes']                       = $this->input->post('diabetes');
        $data['diabetes_comment']               = $this->input->post('diabetes_comment');
        $data['thyroid']                        = $this->input->post('thyroid');
        $data['thyroid_comment']                = $this->input->post('thyroid_comment');
        $data['hypertension']                   = $this->input->post('hypertension');
        $data['hypertension_comment']           = $this->input->post('hypertension_comment');
        $data['heart_disease']                  = $this->input->post('heart_disease');
        $data['heart_disease_comment']          = $this->input->post('heart_disease_comment');
        $data['trauma']                         = $this->input->post('trauma');
        $data['trauma_comment']                 = $this->input->post('trauma_comment');
        $data['cancer']                         = $this->input->post('cancer');
        $data['cancer_comment']                 = $this->input->post('cancer_comment');
        $data['tuberculosis']                   = $this->input->post('tuberculosis');
        $data['tuberculosis_comment']           = $this->input->post('tuberculosis_comment');
        $data['transfusions']                   = $this->input->post('transfusions');
        $data['transfusions_comment']           = $this->input->post('transfusions_comment');
        $data['pathologies']                    = $this->input->post('pathologies');
        $data['pathologies_comment']            = $this->input->post('pathologies_comment');
        $data['gastrointestinal']               = $this->input->post('gastrointestinal');
        $data['gastrointestinal_comment']       = $this->input->post('gastrointestinal_comment');
        $data['sexual']                         = $this->input->post('sexual');
        $data['sexual_comment']                 = $this->input->post('sexual_comment');
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('pathological',$data);
    }
    
    
    
    function delete_pathological($pathological_id)
    {
        $this->db->where('pathological_id', $pathological_id);
        $this->db->delete('pathological');
    }
    
    function create_no_pathological()
    {
        $data['activity']                = $this->input->post('activity');
        $data['activity_comment']        = $this->input->post('activity_comment');
        $data['smoking  ']               = $this->input->post('smoking');
        $data['smoking_comment']         = $this->input->post('smoking_comment');
        $data['alcoholism']              = $this->input->post('alcoholism');
        $data['alcoholism_comment']      = $this->input->post('alcoholism_comment');
        $data['drugs']                   = $this->input->post('drugs');
        $data['drugs_comment']           = $this->input->post('drugs_comment');
        $data['vaccine']                 = $this->input->post('vaccine');
        $data['vaccine_comment']         = $this->input->post('vaccine_comment');
        $data['others']                  = $this->input->post('others');
        $data['others_comment']          = $this->input->post('others_comment');
        $data['patient_id']              = $this->input->post('patient_id');
        $data['date']                    = $this->crud_model->formatDate();
        $this->db->insert('no_pathological',$data);
    }
    
    function update_no_pathological($patient_id)
    {
        $data['activity']                = $this->input->post('activity');
        $data['activity_comment']        = $this->input->post('activity_comment');
        $data['smoking  ']               = $this->input->post('smoking');
        $data['smoking_comment']         = $this->input->post('smoking_comment');
        $data['alcoholism']              = $this->input->post('alcoholism');
        $data['alcoholism_comment']      = $this->input->post('alcoholism_comment');
        $data['drugs']                   = $this->input->post('drugs');
        $data['drugs_comment']           = $this->input->post('drugs_comment');
        $data['vaccine']                 = $this->input->post('vaccine');
        $data['vaccine_comment']         = $this->input->post('vaccine_comment');
        $data['others']                  = $this->input->post('others');
        $data['others_comment']          = $this->input->post('others_comment');
        $data['patient_id']              = $this->input->post('patient_id');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('no_pathological',$data);
    }
    
    function delete_no_pathological($no_pathological_id)
    {
        $this->db->where('no_pathological_id', $no_pathological_id);
        $this->db->delete('no_pathological');
    }
    
    
    function create_recordfamily()
    {
        $data['diabetes']                       = $this->input->post('diabetes');
        $data['diabetes_comment']               = $this->input->post('diabetes_comment');
        $data['heart_disease']                  = $this->input->post('heart_disease');
        $data['heart_disease_comment']          = $this->input->post('heart_disease_comment');
        $data['hypertension']                   = $this->input->post('hypertension');
        $data['hypertension_comment']           = $this->input->post('hypertension_comment');
        $data['thyroid']                        = $this->input->post('thyroid');
        $data['thyroid_comment']                = $this->input->post('thyroid_comment');
        $data['others_comment']                 = $this->input->post('others_comment');
        $data['others']                         = $this->input->post('others');
        $data['patient_id']                     = $this->input->post('patient_id');
        $data['date']                           = $this->crud_model->formatDate();
        $this->db->insert('record_family',$data);
    }
    
    
    function update_recordfamily($patient_id)
    {
        $data['diabetes']                       = $this->input->post('diabetes');
        $data['diabetes_comment']               = $this->input->post('diabetes_comment');
        $data['heart_disease']                  = $this->input->post('heart_disease');
        $data['heart_disease_comment']          = $this->input->post('heart_disease_comment');
        $data['hypertension']                   = $this->input->post('hypertension');
        $data['hypertension_comment']           = $this->input->post('hypertension_comment');
        $data['thyroid']                        = $this->input->post('thyroid');
        $data['thyroid_comment']                = $this->input->post('thyroid_comment');
        $data['others_comment']                 = $this->input->post('others_comment');
        $data['others']                         = $this->input->post('others');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('record_family',$data);
    }
   
    function create_psychiatric()
    {
        $data['family_record']                 = $this->input->post('family_record');
        $data['disease_awareness']             = $this->input->post('disease_awareness');
        $data['disease_awareness_comment']     = $this->input->post('disease_awareness_comment');
        $data['affected_areas']                = $this->input->post('affected_areas');
        $data['past_treatments']               = $this->input->post('past_treatments');
        $data['family_group_social']           = $this->input->post('family_group_social');
        $data['family_group_social_comment']          = $this->input->post('family_group_social_comment');
        $data['family_group']                  = $this->input->post('family_group');
        $data['aspects_social']                = $this->input->post('aspects_social');
        $data['aspects_work']                  = $this->input->post('aspects_work');
        $data['authority']                     = $this->input->post('authority');
        $data['impulse_control']               = $this->input->post('impulse_control');
        $data['frustration']                   = $this->input->post('frustration');
        $data['patient_id']                    = $this->input->post('patient_id');
        $data['date']                          = $this->crud_model->formatDate();
        $this->db->insert('psychiatric',$data);
    }
    
    function update_psychiatric($patient_id)
    {
        $data['family_record']                 = $this->input->post('family_record');
        $data['disease_awareness']             = $this->input->post('disease_awareness');
        $data['disease_awareness_comment']     = $this->input->post('disease_awareness_comment');
        $data['affected_areas']                = $this->input->post('affected_areas');
        $data['past_treatments']               = $this->input->post('past_treatments');
        $data['family_group_social']           = $this->input->post('family_group_social');
        $data['family_group_social_comment']   = $this->input->post('family_group_social_comment');
        $data['family_group']                  = $this->input->post('family_group');
        $data['aspects_social']                = $this->input->post('aspects_social');
        $data['aspects_work']                  = $this->input->post('aspects_work');
        $data['authority']                     = $this->input->post('authority');
        $data['impulse_control']               = $this->input->post('impulse_control');
        $data['frustration']                   = $this->input->post('frustration');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('psychiatric',$data);
    }
    
    function create_vaccination()
    {
        $data['bcg']                            = $this->vaccination($this->input->post('bcg'));
        $data['hepatitis_b_1']                  = $this->vaccination($this->input->post('hepatitis_b_1'));
        $data['pentavalente_acelular_1']        = $this->vaccination($this->input->post('pentavalente_acelular_1'));
        $data['hepatitis_b_2']                  = $this->vaccination($this->input->post('hepatitis_b_2'));
        $data['rotavirus_1']                    = $this->vaccination($this->input->post('rotavirus_1'));
        $data['neumococo_1']                    = $this->vaccination($this->input->post('neumococo_1'));
        $data['pentavalente_acelular_2']        = $this->vaccination($this->input->post('pentavalente_acelular_2'));
        $data['rotavirus_2']                    = $this->vaccination($this->input->post('rotavirus_2'));
        $data['neumococo_2']                    = $this->vaccination($this->input->post('neumococo_2'));
        $data['pentavalente_acelular_3']        = $this->vaccination($this->input->post('pentavalente_acelular_3'));
        $data['hepatitis_b_3']                  = $this->vaccination($this->input->post('hepatitis_b_3'));
        $data['rotavirus_3']                    = $this->vaccination($this->input->post('rotavirus_3'));
        $data['anti_influenza_1']               = $this->vaccination($this->input->post('anti_influenza_1'));
        $data['anti_influenza_2']               = $this->vaccination($this->input->post('anti_influenza_2'));
        $data['srp_1']                          = $this->vaccination($this->input->post('srp_1'));
        $data['neumococo_3']                    = $this->vaccination($this->input->post('neumococo_3'));
        $data['pentavalente_acelular_4']        = $this->vaccination($this->input->post('pentavalente_acelular_4'));
        $data['influenza_refuerzo_anual_2a']    = $this->vaccination($this->input->post('influenza_refuerzo_anual_2a'));
        $data['influenza_refuerzo_anual_3a']    = $this->vaccination($this->input->post('influenza_refuerzo_anual_3a'));
        $data['dpt']                            = $this->vaccination($this->input->post('dpt'));
        $data['influenza_refuerzo_anual_4a']    = $this->vaccination($this->input->post('influenza_refuerzo_anual_4a'));
        $data['influenza_refuerzo_anual_5a']    = $this->vaccination($this->input->post('influenza_refuerzo_anual_5a'));
        $data['vop']                            = $this->vaccination($this->input->post('vop'));
        $data['srp_2']                          = $this->vaccination($this->input->post('srp_2'));
        $data['vph']                            = $this->vaccination($this->input->post('vph'));
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $data['patient_id']                     = $this->input->post('patient_id');
        $data['date']                           = $this->crud_model->formatDate();
        $this->db->insert('vaccination',$data);
    }
    
    function update_vaccination($patient_id)
    {
        $data['bcg']                            = $this->input->post('bcg');
        $data['hepatitis_b_1']                  = $this->input->post('hepatitis_b_1');
        $data['pentavalente_acelular_1']        = $this->input->post('pentavalente_acelular_1');
        $data['hepatitis_b_2']                  = $this->input->post('hepatitis_b_2');
        $data['rotavirus_1']                    = $this->input->post('rotavirus_1');
        $data['neumococo_1']                    = $this->input->post('neumococo_1');
        $data['pentavalente_acelular_2']        = $this->input->post('pentavalente_acelular_2');
        $data['rotavirus_2']                    = $this->input->post('rotavirus_2');
        $data['neumococo_2']                    = $this->input->post('neumococo_2');
        $data['pentavalente_acelular_3']        = $this->input->post('pentavalente_acelular_3');
        $data['hepatitis_b_3']                  = $this->input->post('hepatitis_b_3');
        $data['rotavirus_3']                    = $this->input->post('rotavirus_3');
        $data['anti_influenza_1']               = $this->input->post('anti_influenza_1');
        $data['anti_influenza_2']               = $this->input->post('anti_influenza_2');
        $data['srp_1']                          = $this->input->post('srp_1');
        $data['neumococo_3']                    = $this->input->post('neumococo_3');
        $data['pentavalente_acelular_4']        = $this->input->post('pentavalente_acelular_4');
        $data['influenza_refuerzo_anual_2a']    = $this->input->post('influenza_refuerzo_anual_2a');
        $data['influenza_refuerzo_anual_3a']    = $this->input->post('influenza_refuerzo_anual_3a');
        $data['dpt']                            = $this->input->post('dpt');
        $data['influenza_refuerzo_anual_4a']    = $this->input->post('influenza_refuerzo_anual_4a');
        $data['influenza_refuerzo_anual_5a']    = $this->input->post('influenza_refuerzo_anual_5a');
        $data['vop']                            = $this->input->post('vop');
        $data['srp_2']                          = $this->input->post('srp_2');
        $data['vph']                            = $this->input->post('vph');
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('vaccination',$data);
    }
    
    function create_nutriological()
    {
        $data['breakfast']                      = $this->input->post('breakfast');
        $data['breakfast_comment']              = $this->input->post('breakfast_comment');
        $data['snack']                          = $this->input->post('snack');
        $data['snack_comment']                  = $this->input->post('snack_comment');
        $data['food']                           = $this->input->post('food');
        $data['food_comment']                   = $this->input->post('food_comment');
        $data['snack_afternoon']                = $this->input->post('snack_afternoon');
        $data['snack_afternoon_comment']        = $this->input->post('snack_afternoon_comment');
        $data['dinner']                         = $this->input->post('dinner');
        $data['dinner_comment']                 = $this->input->post('dinner_comment');
        $data['food_home']                      = $this->input->post('food_home');
        $data['food_home_comment']              = $this->input->post('food_home_comment');
        $data['appetite']                       = $this->input->post('appetite');
        $data['hunger_satiety']                 = $this->input->post('hunger_satiety');
        $data['hunger_satiety_comment']         = $this->input->post('hunger_satiety_comment');
        $data['glasses']                        = $this->input->post('glasses');
        $data['food_preferences']               = $this->input->post('food_preferences');
        $data['food_unrest']                    = $this->input->post('food_unrest');
        $data['food_unrest_comment']            = $this->input->post('food_unrest_comment');
        $data['supplements']                    = $this->input->post('supplements');
        $data['supplements_comment']            = $this->input->post('supplements_comment');
        $data['carried_out']                    = $this->input->post('carried_out');
        $data['carried_out_comment']            = $this->input->post('carried_out_comment');
        $data['ideal_weight']                   = $this->input->post('ideal_weight');
        $data['current_condition']              = $this->input->post('current_condition');
        $data['current_condition_comment']      = $this->input->post('current_condition_comment');
        $data['personal_history']               = $this->input->post('personal_history');
        $data['personal_history_comment']       = $this->input->post('personal_history_comment');
        $data['consumption']                    = $this->input->post('consumption');
        $data['consumption_comment']            = $this->input->post('consumption_comment');
        $data['nutrition_education']            = $this->input->post('nutrition_education');
        $data['nutrition_education_comment']    = $this->input->post('nutrition_education_comment');
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $data['patient_id']                     = $this->input->post('patient_id');
        $data['date']                           = $this->crud_model->formatDate();
        $this->db->insert('nutriological',$data);
    }
    
    
    function update_nutriological($patient_id)
    {
        $data['breakfast']                      = $this->input->post('breakfast');
        $data['breakfast_comment']              = $this->input->post('breakfast_comment');
        $data['snack']                          = $this->input->post('snack');
        $data['snack_comment']                  = $this->input->post('snack_comment');
        $data['food']                           = $this->input->post('food');
        $data['food_comment']                   = $this->input->post('food_comment');
        $data['snack_afternoon']                = $this->input->post('snack_afternoon');
        $data['snack_afternoon_comment']        = $this->input->post('snack_afternoon_comment');
        $data['dinner']                         = $this->input->post('dinner');
        $data['dinner_comment']                 = $this->input->post('dinner_comment');
        $data['food_home']                      = $this->input->post('food_home');
        $data['food_home_comment']              = $this->input->post('food_home_comment');
        $data['appetite']                       = $this->input->post('appetite');
        $data['hunger_satiety']                 = $this->input->post('hunger_satiety');
        $data['hunger_satiety_comment']         = $this->input->post('hunger_satiety_comment');
        $data['glasses']                        = $this->input->post('glasses');
        $data['food_preferences']               = $this->input->post('food_preferences');
        $data['food_unrest']                    = $this->input->post('food_unrest');
        $data['food_unrest_comment']            = $this->input->post('food_unrest_comment');
        $data['supplements']                    = $this->input->post('supplements');
        $data['supplements_comment']            = $this->input->post('supplements_comment');
        $data['carried_out']                    = $this->input->post('carried_out');
        $data['carried_out_comment']            = $this->input->post('carried_out_comment');
        $data['ideal_weight']                   = $this->input->post('ideal_weight');
        $data['current_condition']              = $this->input->post('current_condition');
        $data['current_condition_comment']      = $this->input->post('current_condition_comment');
        $data['personal_history']               = $this->input->post('personal_history');
        $data['personal_history_comment']       = $this->input->post('personal_history_comment');
        $data['consumption']                    = $this->input->post('consumption');
        $data['consumption_comment']            = $this->input->post('consumption_comment');
        $data['nutrition_education']            = $this->input->post('nutrition_education');
        $data['nutrition_education_comment']    = $this->input->post('nutrition_education_comment');
        $data['others']                         = $this->input->post('others');
        $data['others_comment']                 = $this->input->post('others_comment');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('nutriological',$data);
    }
    
    function create_obstetric()
    {
        $data['first_menstruation']           = $this->input->post('first_menstruation');
        $data['last_menstruation']            = $this->input->post('last_menstruation');
        $data['menstruation_features']        = $this->input->post('menstruation_features');
        $data['pregnancies']                  = $this->input->post('pregnancies');
        $data['pregnancies_comment']          = $this->input->post('pregnancies_comment');
        $data['cervical_cancer']              = $this->input->post('cervical_cancer');
        $data['cervical_cancer_comment']      = $this->input->post('cervical_cancer_comment');
        $data['uterine_cancer']               = $this->input->post('uterine_cancer');
        $data['uterine_cancer_comment']       = $this->input->post('uterine_cancer_comment');
        $data['breast_cancer']                = $this->input->post('breast_cancer');
        $data['breast_cancer_comment']        = $this->input->post('breast_cancer_comment');
        $data['sexual_activity']              = $this->input->post('sexual_activity');
        $data['sexual_activity_comment']      = $this->input->post('sexual_activity_comment');
        $data['family_planning']              = $this->input->post('family_planning');
        $data['replacement_therapy']          = $this->input->post('replacement_therapy');
        $data['replacement_therapy_comment']  = $this->input->post('replacement_therapy_comment');
        $data['last_pap']                     = $this->input->post('last_pap');
        $data['mammography']                  = $this->input->post('mammography');
        $data['others']                       = $this->input->post('others');
        $data['others_comment']               = $this->input->post('others_comment');
        $data['patient_id']                   = $this->input->post('patient_id');
        $data['date']                         = $this->crud_model->formatDate();
        $this->db->insert('gyneco_obstetrics',$data);
    }
    
    function update_obstetric($patient_id)
    {
        $data['first_menstruation']           = $this->input->post('first_menstruation');
        $data['last_menstruation']            = $this->input->post('last_menstruation');
        $data['menstruation_features']        = $this->input->post('menstruation_features');
        $data['pregnancies']                  = $this->input->post('pregnancies');
        $data['pregnancies_comment']          = $this->input->post('pregnancies_comment');
        $data['cervical_cancer']              = $this->input->post('cervical_cancer');
        $data['cervical_cancer_comment']      = $this->input->post('cervical_cancer_comment');
        $data['uterine_cancer']               = $this->input->post('uterine_cancer');
        $data['uterine_cancer_comment']       = $this->input->post('uterine_cancer_comment');
        $data['breast_cancer']                = $this->input->post('breast_cancer');
        $data['breast_cancer_comment']        = $this->input->post('breast_cancer_comment');
        $data['sexual_activity']              = $this->input->post('sexual_activity');
        $data['sexual_activity_comment']      = $this->input->post('sexual_activity_comment');
        $data['family_planning']              = $this->input->post('family_planning');
        $data['replacement_therapy']          = $this->input->post('replacement_therapy');
        $data['replacement_therapy_comment']  = $this->input->post('replacement_therapy_comment');
        $data['last_pap']                     = $this->input->post('last_pap');
        $data['mammography']                  = $this->input->post('mammography');
        $data['others']                       = $this->input->post('others');
        $data['others_comment']               = $this->input->post('others_comment');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('gyneco_obstetrics',$data);    
        
    }
    
    function create_perinatal()
    {
        $data['last_menstrual']              = $this->input->post('last_menstrual');
        $data['cycle_duration']              = $this->input->post('cycle_duration');
        $data['last_method']                 = $this->input->post('last_method');
        $data['assisted_conception']         = $this->input->post('assisted_conception');
        $data['assisted_conception_comment'] = $this->input->post('assisted_conception_comment');
        $data['ucm_date']                    = $this->input->post('ucm_date');
        $data['fpp_final']                   = $this->input->post('fpp_final');
        $data['notes']                       = $this->input->post('notes');
        $data['patient_id']                  = $this->input->post('patient_id');
        $data['date']                        = $this->crud_model->formatDate();
        $this->db->insert('perinatal',$data);
    }
    
    function update_perinatal($patient_id)
    {
        $data['last_menstrual']              = $this->input->post('last_menstrual');
        $data['cycle_duration']              = $this->input->post('cycle_duration');
        $data['last_method']                 = $this->input->post('last_method');
        $data['assisted_conception']         = $this->input->post('assisted_conception');
        $data['assisted_conception_comment'] = $this->input->post('assisted_conception_comment');
        $data['ucm_date']                    = $this->input->post('ucm_date');
        $data['fpp_final']                   = $this->input->post('fpp_final');
        $data['notes']                       = $this->input->post('notes');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('perinatal',$data);    
    }
    
    function create_postnatal()
    {
        $data['baby_name']              = $this->input->post('baby_name');
        $data['birth_details']          = $this->input->post('birth_details');
        $data['birth_weight']           = $this->input->post('birth_weight');
        $data['baby_health']            = $this->input->post('baby_health');
        $data['baby_feeding']           = $this->input->post('baby_feeding');
        $data['emotional_state']        = $this->input->post('emotional_state');
        $data['patient_id']             = $this->input->post('patient_id');
        $data['date']                   = $this->crud_model->formatDate();
        $this->db->insert('postnatal',$data);
    }
    
    function update_postnatal($patient_id)
    {
        $data['baby_name']              = $this->input->post('baby_name');
        $data['birth_details']          = $this->input->post('birth_details');
        $data['birth_weight']           = $this->input->post('birth_weight');
        $data['baby_health']            = $this->input->post('baby_health');
        $data['baby_feeding']           = $this->input->post('baby_feeding');
        $data['emotional_state']        = $this->input->post('emotional_state');
        $this->db->where('patient_id',$patient_id);
        $this->db->update('postnatal',$data);    
    }
    
   
    
    function vaccination($var1)//función para mandar un 0 para insertar en la tabla vaccination
    {
        if($var1 == 1)
        {
            return 1;    
        }
                    
        else
        {
           return 0;    
        }
    }
    
    function check_medical_history($var1, $var2,$var3)
    {
      if($this->db->get_where($var3, array('patient_id' => $var1))->row()->$var2 == 1)
      {
         return 1;
      }
      
      else
      {
          return 0;
      }
    }
    
    function check_comment_medical_history($var1,$var2,$var3)
    {
        $col = $var2.'_comment';
        $vv = $this->db->get_where($var3, array('patient_id' => $var1,$var2 => 1))->row()->$col;
        
        if($vv!="")
        {
            return $vv;
        }
    }
    
    function check_medical_value($var1,$var2,$var3)
    {
      $vv = $this->db->get_where($var3, array('patient_id'=> $var1))->row()->$var2;
  
      if($vv!="")
      {
         return $vv;
      }
     
    }
    
    function prox_appointments($clinic_id,$hoy,$fecha)
    {
        $sql = "SELECT * FROM appointment WHERE status<>4 AND status<>2 AND status<>5  AND clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC limit 5";
        
        $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
        
        return $res;
    }
    
        function prox_appointments_doc($clinic_id,$hoy,$fecha)
    {   
        
        $doctor_id=$doctor_id;
        $sql = "SELECT * FROM appointment WHERE status IN (0, 1, 3) and past_status=0  AND doctor_id = '".$doctor_id."'  AND clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC limit 5";
        
        
        $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
        
        return $res;
    }
    
    
    function prev_appointments($clinic_id,$user,$hoy,$fecha)
    {
        if($user > 0){ //status = 4 AND
            
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND patient_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
            
            $res = $this->db->query($sql, array($clinic_id,$user,$hoy,$fecha))->result_array();
            
            return $res;
        }
        
        else 
        {//status = 4 AND
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
            
            $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
            
            return $res;
        }
    }
    
    function appoints($clinic_id,$user,$hoy,$fecha)
    {
        if($user > 0)
        {
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND  status = 4 AND doctor_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
                
            $res = $this->db->query($sql, array($clinic_id,$user,$hoy,$fecha))->result_array();
                
            return $res;
        }
        
        else 
        {
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND status = 4 AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
                
            $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
                
            return $res;
        }
    }
    
        function appoints_doct($clinic_id,$hoy,$fecha)
    {
        $user = $doctor_id;
        if($user > 0)
        {
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND  status = 4 AND doctor_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
                
            $res = $this->db->query($sql, array($clinic_id,$user,$hoy,$fecha))->result_array();
                
            return $res;
        }
        
        else 
        {
            $sql = "SELECT * FROM appointment WHERE clinic_id = ? AND status = 4 AND doctor_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) ASC";
                
            $res = $this->db->query($sql, array($clinic_id,$user,$hoy,$fecha))->result_array();
                
            return $res;
        }
    }
    
    
    
    function count_appointments($doctor_id, $date1,$date2, $status)
    {
        if($status == "total")
        {
            $sql = "SELECT * FROM `appointment` where clinic_id = ? And doctor_id = ? AND status != 5 AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y')";
            $res = $this->db->query($sql, array($this->session->userdata('current_clinic'), $doctor_id, $date1,$date2));
        }else
        {
            $sql = "SELECT * FROM `appointment` where clinic_id = ? And status = ? AND doctor_id = ? AND status != 5 AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y')";
            $res = $this->db->query($sql, array($this->session->userdata('current_clinic'), $status, $doctor_id, $date1,$date2));

        }
        
            return  $res;
       
    }
    
    
    function practiceCount()
    {
       $res = $this->db->query("SELECT practice, COUNT(practice) total FROM appointment WHERE clinic_id = ".$this->session->userdata('current_clinic')."  and  status = 4 GROUP BY practice ORDER BY total DESC LIMIT 6")->result_array();
            
       return $res;
       
    }
    
    function range_financial_date($clinic_id,$hoy,$fecha)
    {
        $sql = "SELECT description, date, time, amount, income_id, patient_id, appointment_id FROM financial WHERE clinic_id = ? AND str_to_date(income.date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ";
            
        $res = $this->db->query($sql, array($clinic_id,$hoy,$fecha))->result_array();
            
        return $res;
    }
    

    
    function incomes_today($clinic_id,$hoy){
        $sql = "SELECT * FROM income WHERE clinic_id = ? AND  str_to_date(?, '%d/%m/%Y') = str_to_date(date, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
            
        $res = $this->db->query($sql, array($clinic_id,$hoy))->result_array();
                
        return $res;
    }
    
    function incomes_week($clinic_id,$Last7days,$hoy){
        $sql = "SELECT * FROM income WHERE clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
        $res = $this->db->query($sql, array($clinic_id,$Last7days,$hoy))->result_array();
        return $res;
    }
    
    function incomes_last_days($clinic_id,$Last30days,$hoy){
        $sql = "SELECT * FROM income WHERE clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
        $res = $this->db->query($sql, array($clinic_id,$Last30days,$hoy))->result_array();
        return $res;
    }
    
    function expenses_today($clinic_id,$hoy){
        $sql = "SELECT * FROM expense WHERE clinic_id = ? AND  str_to_date(?, '%d/%m/%Y') = str_to_date(date, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
            
        $res = $this->db->query($sql, array($clinic_id,$hoy))->result_array();
                
        return $res;
    }
    
    function expenses_week($clinic_id,$Last7days,$hoy){
        $sql = "SELECT * FROM expense WHERE clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
        $res = $this->db->query($sql, array($clinic_id,$Last7days,$hoy))->result_array();
        return $res;
    }
    
    function expenses_last_days($clinic_id,$Last30days,$hoy){
        $sql = "SELECT * FROM expense WHERE clinic_id = ? AND str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date(?, '%d/%m/%Y') AND str_to_date(?, '%d/%m/%Y') ORDER BY DATE(str_to_date(date, '%d/%m/%Y')) DESC";
        $res = $this->db->query($sql, array($clinic_id,$Last30days,$hoy))->result_array();
        return $res;
    }
    
    function users_activity($clinic_id){
        
        $res = $this->db->query("SELECT admin.type, admin.admin_id as _id, admin.status FROM admin WHERE admin.clinic_id = '".$clinic_id."' UNION SELECT staff.type, staff.staff_id, staff.status FROM staff WHERE staff.clinic_id = '".$clinic_id."' AND status != 0")->result_array();
        return $res;
    }
    
    function medical_history($patient_id)
    {
        $this->db->limit(1);
        $this->db->where('patient_id', $patient_id);
        $this->db->order_by('vital_sign_id','desc');
        $signs = $this->db->get('vital_sign')->result_array();
        return $signs;
    }
    
    
    
    function patient_busy($patient_id){
        
        $res = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1, 3) and patient_id = ".$patient_id);
        return $res;
    }
    
    function count_patient_archived($patient_id){
        
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1) and patient_id = '".$patient_id."'")->num_rows();
        
        
        return $appointments;
    }

    function appointment_today($date, $clinic_id){
        
        $res = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1, 3) and clinic_id = ".$clinic_id." and date ='".$date."'");
        return $res;
    }
    

    function appointment_today_doc($doctor_id, $date, $clinic_id, $time){
      
        if($doctor_id != 0 )
        {
            
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE doctor_id  = ".$doctor_id." and status IN (0, 1,6) and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."'");
        }else
        {
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE  status IN (0, 1,6) and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."'");

        }
        return $appointments;
    }

  


    function list_today_doc($doctor_id, $date, $clinic_id, $time){
  
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1, 5) and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."' and doctor_id = '".$doctor_id."'");
        return $appointments;
    }

    
  
    function appointment_pendding_doc($doctor_id, $date, $clinic_id, $time){

        if($doctor_id != 0)
	        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status=10 and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."' and doctor_id = '".$doctor_id."'");
        else
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status=10 and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."'");

        log_message('error',$this->db->last_query());


            return $appointments;
    }

    function appointment_canceled_doc($doctor_id, $date, $clinic_id, $time){
        if($doctor_id != 0)
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status=2 and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."' and doctor_id = '".$doctor_id."'");
        else    
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status=2 and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."'");
    
            return $appointments;
    }


    function appointment_archived_doc($doctor_id, $date, $clinic_id, $time){
        if($doctor_id != 0)
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status= 4 and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."' and doctor_id = '".$doctor_id."'");
        else
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status= 4 and clinic_id = ".$clinic_id." and time like '".$time."%' and date ='".$date."'");

        return $appointments;
    }


    function count_appointment_today($doctor_id, $date, $clinic_id){
        if($doctor_id != 0)
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1) and clinic_id = ".$clinic_id." and date ='".$date."' and doctor_id = '".$doctor_id."'")->num_rows();
        else
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status IN (0, 1) and clinic_id = ".$clinic_id." and date ='".$date."'")->num_rows();

        return $appointments;
    }
    
    function count_appointment_payment_pending($doctor_id, $date){

        
        if($doctor_id != 0)
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 10 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."' and doctor_id = '".$doctor_id."'")->num_rows();
        else
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 10 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."'")->num_rows();

        return $appointments;
    }
    
    function count_cancelled($doctor_id, $date){
        if($doctor_id != 0)
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 2 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."' and doctor_id = '".$doctor_id."'")->num_rows();
        else
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 2 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."'")->num_rows();

            return $appointments;
    }
    
    function count_archived($doctor_id, $date)
    {
        if($doctor_id != 0)
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 4 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."' and doctor_id = '".$doctor_id."'")->num_rows();
        else
            $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 4 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".$date."'")->num_rows();
            
        
            return $appointments;
    }

    function count_archived_dashboard()
    {
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 4 and clinic_id = ".$this->session->userdata('current_clinic')." and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        $appointments_today = $this->db->query("SELECT * FROM `appointment` WHERE status = 4 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".date('d/m/Y')."' and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        
        if($appointments > 1)
            $total = (100 * $appointments_today)/$appointments;
        else
            $total = (100 * $appointments_today)/1;
        
        
        return round($total);
    }

    function count_pendientes_dashboard()
    {
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 0 and clinic_id = ".$this->session->userdata('current_clinic')." and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        $appointments_today = $this->db->query("SELECT * FROM `appointment` WHERE status = 0 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".date('d/m/Y')."' and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        
        if($appointments > 1)
            $total = (100 * $appointments_today)/$appointments;
        else
            $total = (100 * $appointments_today)/1;
        
        
        return round($total);
    }

    function count_cancelled_dashboard()
    {
        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 2 and clinic_id = ".$this->session->userdata('current_clinic')." and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        $appointments_today = $this->db->query("SELECT * FROM `appointment` WHERE status = 2 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".date('d/m/Y')."' and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        
        if($appointments > 1)
            $total = (100 * $appointments_today)/$appointments;
        else
            $total = (100 * $appointments_today)/1;
        
        
        return round($total);
    }

    function count_rescheduled_dashboard()
    {

        $appointments = $this->db->query("SELECT * FROM `appointment` WHERE status = 3 and clinic_id = ".$this->session->userdata('current_clinic')." and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        $appointments_today = $this->db->query("SELECT * FROM `appointment` WHERE status = 3 and clinic_id = ".$this->session->userdata('current_clinic')." and date ='".date('d/m/Y')."' and doctor_id = '".$this->session->userdata('doctor_id')."'")->num_rows();
        if($appointments > 1)
            $total = (100 * $appointments_today)/$appointments;
        else
            $total = (100 * $appointments_today)/1;
        
        
        return round($total);
    }
    
    function new_patients()
    { 
        $this->db->limit('5');
        $this->db->order_by('patient_id', 'DESC');
        $this->db->where('status !=', 0);
        $patients = $this->db->get('patient')->result_array();
        $news = array();
         foreach($patients as $pt)
         {
            $this->db->where('patient_id', $pt['patient_id']);
            $appointments = $this->db->get('appointment')->num_rows();
            
            if($appointments < 2)
            {
                array_push($news, $pt);
            }
        }
        return $news;
    }
    
    function account_owner()
    {
    $owner = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->owner;
    
    if($owner > 0)
    {
        return $owner;
    }
    else
    {
        return 0;
    }
    }
    
    
    
    function total_pay_credits($patient_id, $treatment_id)
    {
        $query = $this->db->query('select sum(amount) as total from payment_credit where patient_id = "'.$patient_id.'"AND tooth_treatment_id = "'.$treatment_id.'";')->row()->total;
        if($query > 0)
        {
            return $query;    
        }
        else
        {
            return 0;
        }
        
    }
    
    
    function insert_pay_credit()
    {
        //-----------------  Ingreso en tabla payment_credit
        $data['date']               = date('Y-m-d');
        $data['time']               = date('H:i:s');
        $data['datetime']           = date('Y-m-d H:i:s');
        $data['user_id']            = $this->session->userdata('login_user_id');  
        $data['user_type']          = $this->session->userdata('login_type');    
        $data['amount']             = $this->input->post('amount');    
        $data['method']             = $this->input->post('method');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['tooth_treatment_id'] = $this->input->post('treatment_id');
        $data['previous_total']     = $this->input->post('previous_total');
        if($this->input->post('method') == 2)
        {
            $data['details']        = 'Titular de la tarjeta: '.$this->input->post('cardholder').' con el boucher: '.$this->input->post('vaucher');
        }
        elseif($this->input->post('method') == 3)
        {
            $data['details']        = 'Cheque no: '.$this->input->post('checkk').' nombre de la cuenta: '.$this->input->post('titular_checkk');
        }
        elseif($this->input->post('method') == 4)
        {
            $data['details']        = 'Número de depósito: '.$this->input->post('no_dep');
        }
        
        elseif($this->input->post('method') == 5)
        {
            $data['details']        = 'Transferencia número: '.$this->input->post('transf');
        }
        else{
            $data['details']        = 'Efectivo';
        }
        
        $this->db->insert('payment_credit', $data);
        $pay_id = $this->db->insert_id();

        //----------------Insertando en tabla financial el ingreso     
        
        $dats['clinic_id']          = $this->session->userdata('current_clinic');
        $dats['user_id']            = $this->session->userdata('login_user_id');
        $dats['user_type']          = $this->session->userdata('login_type');
        $dats['description']        = 'Se abonó el tratamiento con ID: '.$this->input->post('treatment_id').' del paciente: '.$this->accounts_model->get_name('patient',$this->input->post('patient_id'));
        $dats['amount']             = $this->input->post('amount');
        $dats['method']             = $this->input->post('method');
        $dats['patient_id']         = $this->input->post('patient_id');
        $dats['treatment_id']       = $this->input->post('treatment_id');
        if($this->input->post('method') == 2)
        {
            $dats['reference']          = $this->input->post('vaucher');//si es el pago con tarjeta
        }
        elseif($this->input->post('method') == 3)
        {
            $dats['reference']          = $this->input->post('checkk');//si es el pago con cheque
        }
        elseif($this->input->post('method') == 4)
        {
            $dats['reference']          = $this->input->post('no_dep');//si es el pago con depósito
        }
        elseif($this->input->post('method') == 5)
        {
            $dats['reference']          = $this->input->post('transf');//si es el pago con transferencia
        }
        $dats['date']               = date('d/m/Y');
        $dats['time']               = date('H:m');
        $dats['pay_id']               = $pay_id;
        $this->db->insert('financial',$dats);
        $this->log_model->add_payment_credit($pay_id, $this->input->post('amount'));

    }
    
    function delete_pay_credit($pay_id)
    {
        $cant = $this->db->get_where('payment_credit', array('payment_credit_id' =>$pay_id))->row()->amount;
        $this->db->where('payment_credit_id',$pay_id);
        $this->db->delete('payment_credit');    
        
        $this->db->where('pay_id',$pay_id);
        $this->db->delete('financial');   
        
        $this->log_model->delete_payment_credit($pay_id,$cant);
        
    }    
    
    function treatments_status($treatment_id)
    {
        $this->db->where('odonto_treatment_id', $treatment_id);
        $this->db->where('status', 0);
        $treat = $this->db->get('tooth_treatment')->num_rows();
        return $treat;
    }
    
    function treatmentss($treatment_id)
    {
        $this->db->where('odonto_treatment_id', $treatment_id);
        $detalles = $this->db->get('tooth_treatment')->num_rows();
        return $detalles;
    }
    
    function appointment_status_treatment($treatment_id)
    {
        $this->db->limit(1);
        $this->db->order_by('appointment_id', 'DESC');
        $this->db->where('treatment_id', $treatment_id);
        $status = $this->db->get('appointment')->row();
        if( $status->status > 0)
        {
            return $status->status.'-'.$status->appointment_id;    
        }
        else
        {
            return '0-'.$status->appointment_id;    
        }
        
    }
    
    function treatments_count($patient_id)
    {
        $status = $this->db->get_where('appointment', array('patient_id' => $patient_id, 'practice' => '23', 'status' => 0))->num_rows();
        return $status;
    }
    
    function date_appointment($patient_id)
    {
        $this->db->limit('1');
        $this->db->order_by('appointment_id', 'desc');
        $this->db->where('patient_id', $patient_id);
        $app_pt = $this->db->get('appointment');
        if($app_pt->num_rows() > 0)
        {
            return $app_pt->row()->date;
        }
        else
        {
            return '';
        }
    }
    
    function num_appointments($patient_id)
    {
        return $this->db->get_where('appointment',array('patient_id'=>$patient_id))->num_rows();
    }
    
    function num_prescriptions($patient_id, $treatment_id)
    {
        $appoints = $this->db->get_where('appointment', array('treatment_id' => $treatment_id))->result_array();
        
        $data = array();  
        if(count($appoints)> 1)
        {
            foreach($appoints as $sd)
            {
                $data[] = $this->db->get_where('prescription', array('appointment_id' => $sd['appointment_id'], 'patient_id' => $patient_id))->row()->prescription_id;
            }
        }
        return $data;
    }
    
    function sum_treats($treatment_id)
    {
        $this->db->group_by('tooth_id');
        $this->db->where('odonto_treatment_id', $treatment_id);
        $refresh_query = $this->db->get('tooth_treatment');
        $final = 0;
        
        if(count($refresh_query) > 0)
        {
            foreach($refresh_query->result_array() as $tr)
            {
                $total = 0;
                $this->db->where('tooth_id', $tr['tooth_id']);
                $this->db->where('odonto_treatment_id', $treatment_id);
                $treat = $this->db->get('tooth_treatment');
                
                foreach($treat->result_array() as $row){
                    $total += $this->db->get_where('process', array('process_id' => $row['process']))->row()->price; 
                }
                  $final += $total;
            }
        }
        return $final;
    }

    function contacts()
    {
        $sql = "SELECT admin_id as id, username, phone, type FROM admin where status = 1 
        UNION SELECT staff_id as id, username, phone, type FROM staff  where status = 1 LIMIT 10";
        $res = $this->db->query($sql)->result_array();
        return $res;
    }

    

    function get_staff($user_id)
    {
        $first_name = $this->db->get_where('staff', array('staff_id' => $user_id))->row()->first_name;
        $last_name  = $this->db->get_where('staff', array('staff_id' => $user_id))->row()->last_name;
        return $first_name.' '.$last_name;
    }

   

    function get_inventory_expired($ID)
    {
        $total = $this->db->order_by('product_id','ASD')->limit(1)->get_where('product_lote',array('product_id'=>$ID, 'status'=>1))->row()->expiration;;
        return $total;
    }

    function get_salas(){
        $salas = $this->db->order_by('surgery_room_id','ASC')->get('surgery_room')->result_array();
        foreach ($salas as $row) {
            echo '"'. $row['name']. '",';
        }
    }

    function get_salas_color(){
        $salas = $this->db->order_by('surgery_room_id','ASC')->get('surgery_room')->result_array();
        foreach ($salas as $row) {
            echo '"'. $row['rgb']. '",';
        }
    }

    function get_salas_datos(){
        $salas = $this->db->order_by('surgery_room_id','ASC')->get('surgery_room')->result_array();
        foreach ($salas as $col) {
            $citas = $this->db->order_by('surgery_room_id','ASC')->get_where('appointment', array('surgery_room_id'=> $col['surgery_room_id']))->num_rows();
            echo '"'. $citas. '",';
        }
    }


    function fill_week_sop($date)
    {
        $explode_date = explode('-', $date);
        $this->db->where('day',$explode_date[2]);
        $this->db->where('month',$explode_date[1]);
        $this->db->where('year',$explode_date[0]);
        
        $this->db->where('status !=', 4);
        $this->db->where('status !=', 5);
        $this->db->where('status !=', 6);
        $nums = $this->db->get('appointment')->num_rows();
        return $nums;
        
    }




    //Contabilidad
    function getHeadingsTypes()
    {
        return $this->db->order_by('code', 'ASC')->get_where('heading_type', array('status'=>1));
    }

    function getStatement($state_id)
    {
        return $this->db->get_where('statement', array('statement_id'=>$state_id))->row_array();
    }

    function getHeadsByType($type_id)
    {
        return $this->db->order_by('code', 'ASC')->get_where('heading', array('status'=>1, 'heading_type_id'=>$type_id));
    }

    function getGroupsByHead($head_id)
    {
        return $this->db->order_by('code', 'ASC')->get_where('group_account', array('status'=>1, 'heading_id'=>$head_id));
    }

    function getAccountByGroup($group_id)
    {
        return $this->db->order_by('code', 'ASC')->get_where('nomenclature', array('group_account_id'=>$group_id));
    }

    function headingTypeByCode($code)
    {
        return $this->db->get_where('heading_type', array('code'=>$code))->row_array();
    }

    function headingByCode($code)
    {
        return $this->db->get_where('heading', array('code'=>$code))->row_array();
    }

    function groupByCode($code)
    {
        return $this->db->get_where('group_account', array('code'=>$code))->row_array();
    }

    function nomenByCode($code)
    {
        return $this->db->get_where('nomenclature', array('code'=>$code))->row_array();
    }

    function headingTypeByCodeNoID($code, $id)
    {
        return $this->db->get_where('heading_type', array('code'=>$code, 'heading_type_id !='=>$id))->row_array();
    }

    function headingByCodeNoID($code, $id)
    {
        return $this->db->get_where('heading', array('code'=>$code, 'heading !='=>$id))->row_array();
    }

    function groupByCodeNoID($code, $id)
    {
        return $this->db->get_where('group_account', array('code'=>$code, 'group_account_id !='=>$id))->row_array();
    }

    function nomenByCodeNoID($code, $id)
    {
        return $this->db->get_where('nomenclature', array('code'=>$code, 'nomenclature_id !='=>$id))->row_array();
    }

    function getNomen($nomen_id)
    {
        return $this->db->get_where("nomenclature", array("nomenclature_id"=>$nomen_id, "status"=>1))->row_array();
    }

    function accountByCode($code)
    {
        $ex = explode(".", $code);
        $num = count($ex);
        if ($num == 1) {
            $data = $this->headingTypeByCode($code);
        } elseif($num == 2) {
            $data = $this->headingByCode($code);
        } elseif ($num == 3) {
            $data = $this->groupByCode($code);
        } elseif ($num == 4){
            $data = $this->nomenByCode($code);
        }

        return $data;
    }

    function nomenByID($nomen_id)
    {
        return $this->db->get_where('nomenclature', array('nomenclature_id'=>$nomen_id))->row_array();
    }

    function nomenByIDJson()
    {
        $nomen_id = $this->input->post('id');
        $nomen = $this->db->get_where('nomenclature', array('nomenclature_id'=>$nomen_id))->row_array();
        echo json_encode($nomen); 
    }

    function searchNomenNew(){
        $code = $this->input->post('code');
        $ex = explode(".", $code);
        $num = count($ex);
        $data = array();
        if ($num == 1) {
            $data = $this->headingTypeByCode($code);
        } elseif($num == 2) {
            $data = $this->headingByCode($code);
        } elseif ($num == 3) {
            $data = $this->groupByCode($code);
        } elseif ($num == 4){
            $data = $this->nomenByCode($code);
        }

        echo count($data);
    }

    function searchNomenEdit(){
        $id = $this->input->post('id');
        $code = $this->input->post('code');
        $ex = explode(".", $code);
        $num = count($ex);
        if ($num == 1) {
            $data = $this->headingTypeByCodeNoID($code, $id);
        } elseif($num == 2) {
            $data = $this->headingByCodeNoID($code, $id);
        } elseif ($num == 3) {
            $data = $this->groupByCodeNoID($code, $id);
        } elseif ($num == 4){
            $data = $this->nomenByCodeNoID($code, $id);
        }

        echo count($data);
    }

    function newAccount()
    {
        $last_id = 0;
        $statement_id = 3;
        $code = str_replace(' ', '', $this->input->post('code'));
        $name = $this->input->post('name');
        $ex = explode(".", $code);
        $num = count($ex);
        if ($ex[0] == 1 || $ex[0] == 2 || $ex[0] == 3) {
            $statement_id = 1;
        } elseif($ex[0] == 4 || $ex[0] == 5) {
            $statement_id = 2;
        }

        if ($num == 1) {
            $data['code'] = $code;
            $data['name'] = $name;
            $data['statement_id'] = $statement_id;
            $this->db->insert('heading_type', $data);
            $last_id = $this->db->insert_id();
        
            /* $mensaje = "Ha creado una categoría principal de nomenclatura con id: $last_id, con la información: ".json_encode($data).".";
            $this->binnacle($mensaje, "heading_type", $last_id);*/
        } elseif($num == 2) {
            $type = $this->headingTypeByCode($ex[0]);
            $data['code'] = $code;
            $data['name'] = $name;
            $data['heading_type_id'] = $type['heading_type_id'];
            $data['statement_id'] = $statement_id;
            $this->db->insert('heading', $data);
            $last_id = $this->db->insert_id();
            
            /* $mensaje = "Ha creado una subcategoría de nomenclatura con id: $last_id, con la información: ".json_encode($data).".";
            $this->binnacle($mensaje, "heading", $last_id);*/
        } elseif ($num == 3) {
            $type = $this->headingTypeByCode($ex[0]);
            $head = $this->headingByCode($ex[0].".".$ex[1]);
            $data['code']            = $code;
            $data['name']            = $name;
            $data['heading_type_id'] = $type['heading_type_id'];
            $data['heading_id']      = $head['heading_id'];
            $data['statement_id']    = $statement_id;
            $this->db->insert('group_account', $data);
            $last_id = $this->db->insert_id();
            
            /* $mensaje = "Ha creado un grupo de nomenclatura con id: $last_id, con la información: ".json_encode($data).".";
            $this->binnacle($mensaje, "group_account", $last_id); */
        } elseif ($num == 4){
            $type = $this->headingTypeByCode($ex[0]);
            $head = $this->headingByCode($ex[0].'.'.$ex[1]);
            $group = $this->groupByCode($ex[0].'.'.$ex[1].'.'.$ex[2]);
            // log_message("error", $ex[0].'.'.$ex[1].'.'.$ex[2]);
            $move_bank = $this->input->post('move_bank');
            $data['code']             = $code;
            $data['name']             = $name;
            $data['description']      = trim($this->input->post('description'));
            $data['heading_type_id']  = $type['heading_type_id'];
            $data['heading_id']       = $head['heading_id'];
            $data['group_account_id'] = $group['group_account_id'];
            $data['balance']          = $this->input->post('balance');
            $data['statement']        = $this->input->post('statement');
            $data['purchase']         = $this->input->post('purchase');
            $data['calculate_isr']    = $this->input->post('calculate_isr');
            $data['statement_id']     = $statement_id;
            $data['ledger']           = $this->input->post('ledger');
            if($move_bank > 0) $data['move_bank'] = $this->input->post('move_bank');
            $this->db->insert('nomenclature', $data);
            $last_id = $this->db->insert_id();
            
            /* $mensaje = "Ha creado un rubro de nomenclatura con id: $last_id, con la información: ".json_encode($data).".";
            $this->binnacle($mensaje, "nomenclature", $last_id); */
        }

        return $last_id;
    }

    function editNomen()
    {
        $nomen_id = $this->input->post('nomenclature_id');
        $nom = $this->getNomen($nomen_id);
        $code = str_replace(' ', '', $this->input->post('code'));
        if ($code != $nom['code']) {
            $ex = explode('.', $code);
            $num = count($ex);
            $type = $this->headingTypeByCode($ex[0]);
            $head = $this->headingByCode($ex[0].'.'.$ex[1]);
            $group = $this->groupByCode($ex[0].'.'.$ex[1].'.'.$ex[2]);
            $data['code']             = $code;
            $data['heading_type_id']  = $type['heading_type_id'];
            $data['heading_id']       = $head['heading_id'];
            $data['group_account_id'] = $group['group_account_id'];
        }
        $data['name']                 = $this->input->post('name');
        $data['description']          = trim($this->input->post('description'));
        $data['balance']              = $this->input->post('balance');
        $data['statement']            = $this->input->post('statement');
        $data['purchase']             = $this->input->post('purchase');
        $data['calculate_isr']        = $this->input->post('calculate_isr');
        $data['move_bank']            = $this->input->post('move_bank');
        $data['ledger']               = $this->input->post('ledger');
        $this->db->where('nomenclature_id', $nomen_id);
        $query = $this->db->update('nomenclature', $data);
        
        /*$mensaje = "Ha actualizado el rubro de nomenclatura con id: $nomen_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "nomenclature", $nomen_id);*/
        return $query;
    }

    function deactivateNomen($nomen_id)
    {
        $nomenclature_id = base64_decode($nomen_id);
        $data['status'] = 0;
        $this->db->where('nomenclature_id', $nomenclature_id);
        $query = $this->db->update('nomenclature', $data);

        /*$mensaje = "Ha desactivado el rubro de nomenclatura con id: $nomenclature_id.";
        $this->binnacle($mensaje, "nomenclature", $nomenclature_id);*/
        echo $query;
    }

    function activateNomen($nomen_id)
    {
        $nomenclature_id = base64_decode($nomen_id);
        $data['status'] = 1;
        $this->db->where('nomenclature_id', $nomenclature_id);
        $query = $this->db->update('nomenclature', $data);

        /*$mensaje = "Ha activado el rubro de nomenclatura con id: $nomenclature_id.";
        $this->binnacle($mensaje, "nomenclature", $nomenclature_id);*/
        echo $query;
    }

    function deleteNomen($nomen_id)
    {
        $nomenclature_id = base64_decode($nomen_id);
        $this->db->where('nomenclature_id', $nomenclature_id);
        $query = $this->db->delete('nomenclature');

        /*$mensaje = "Ha eliminado el rubro de nomenclatura con id: $nomenclature_id.";
        $this->binnacle($mensaje, "nomenclature", $nomenclature_id);*/
        echo $query;
    }

    function getMoveBanks()
    {
        return $this->db->order_by("type", "ASC")->get_where("move_bank", array("status"=>1));
    }

    function getDepartures($initial, $final, $nomenclature_id = '')
    {
        $query = '';
        if ($nomenclature_id == '' || $nomenclature_id == 'T') $query = "SELECT * FROM departure WHERE type = 1 AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') ORDER BY date DESC, departure_id DESC";
        else $query = "SELECT p.* FROM departure AS p INNER JOIN departure_detail AS d ON p.departure_id = d.departure_id WHERE p.type = 1 AND d.nomenclature_id = '$nomenclature_id' AND DATE(p.date) >= DATE('$initial') AND DATE(p.date) <= DATE('$final') GROUP BY d.departure_id ORDER BY p.date DESC, p.departure_id DESC";
        $data = $this->db->query($query);
        return $data;
    }

    function getDeparturesActive($initial, $final, $nomenclature_id = '')
    {
        $query = '';
        if ($nomenclature_id == '' || $nomenclature_id == 'T') $query = "SELECT * FROM departure WHERE type = 1 AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND status = 1 ORDER BY date DESC, departure_id DESC";
        else $query = "SELECT p.* FROM departure AS p INNER JOIN departure_detail AS d ON p.departure_id = d.departure_id WHERE p.type = 1 AND d.nomenclature_id = '$nomenclature_id' AND DATE(p.date) >= DATE('$initial') AND DATE(p.date) <= DATE('$final') AND p.status = 1 AND d.status = 1 GROUP BY d.departure_id ORDER BY p.date DESC, p.departure_id DESC";
        $data = $this->db->query($query);
        return $data;
    }

    function getNomenclature()
    {
        $data = $this->db->order_by("code", "ASC")->get_where("nomenclature", array("status" => 1));
        return $data;
    }

    function getDeptosActive() {
        return $this->db->order_by("department_id", "ASC")->get_where("department", array("status"=>1));
    }
    
    function getProvidersByID($provider_id) {
        return $this->db->get_where("provider", array("provider_id"=>$provider_id))->row_array();
    }
    
    function getProvidersActive()
    {
        return $this->db->get_where("provider", array("status"=>1));
    }

    function getInstitutions()
    {
        return $this->db->query("SELECT * FROM institution WHERE registered IS NULL");
    }

    function getInstitutionRegistered()
    {
        return $this->db->get_where('institution', array('registered'=>1, 'status'=>1));
    }

    function getInstitutionTest()
    {
        return $this->db->get_where('institution', array('mode'=>0, 'status'=>1));
    }

    function getInstitutionProduction()
    {
        return $this->db->get_where('institution', array('mode'=>1, 'status'=>1));
    }
    
    function getNomenISR()
    {
        $data = $this->db->query("SELECT * FROM nomenclature WHERE name LIKE '%isr%' AND status = 1");
        return $data;
    }

    function getNomenReten()
    {
        $data = $this->db->query("SELECT * FROM nomenclature WHERE name LIKE '%reten%' AND status = 1");
        return $data;
    }

    function getNomenExen()
    {
        $data = $this->db->query("SELECT * FROM nomenclature WHERE name LIKE '%exen%' AND status = 1");
        return $data;
    }

    function verifyPeriod()
    {
        $date = $this->input->post("date"); 
        $total = 0;
        $year = $this->db->query("SELECT COUNT(closing_id) AS total FROM closing WHERE type = 'year' AND period = YEAR('$date') AND status = 1")->row()->total;
        $month = $this->db->query("SELECT COUNT(closing_id) AS total FROM closing WHERE type = 'month' AND period = YEAR('$date') AND MONTH('$date') AND status = 1")->row()->total;
        $check = $this->getInfo("check_close");
        $total = $year + $month;
        echo json_encode(array("results"=>$total, "month"=>intval($month), "year"=>intval($year), "check"=>$check));
    }

    function verifyPeriodDeparture($date)
    {
        $total = 0;
        $year = $this->db->query("SELECT COUNT(closing_id) AS total FROM closing WHERE type = 'year' AND period = YEAR('$date') AND status = 1")->row()->total;
        $month = $this->db->query("SELECT COUNT(closing_id) AS total FROM closing WHERE type = 'month' AND period = YEAR('$date') AND MONTH('$date') AND status = 1")->row()->total;
        $total = $year + $month;
        return $total;
    }

    function getClosing($type)
    {
        return $this->db->get_where("closing", array("status"=>1, "type"=>$type));
    }

    function getReopening()
    {
        return $this->db->get_where("reopening", array("status"=>1));
    }

    function getAdjust($type)
    {
        return $this->db->get_where("adjust", array("status"=>1, "type"=>$type));
    }

    function getDepByACR($type, $id)
    {
        return $this->db->get_where("departure", array("acr"=>$type, "acr_id"=>$id, "status"=>1))->row_array();
    }

    function verifyPeriodClose()
    {
        $category = $this->input->post('category');
        $type = $this->input->post('type');
        $period = $this->input->post('period');
        $month = $this->input->post('month');
        $query = ''; $total = 0;
        if ($category != 'other') {
            if ($type == "month") $query = "SELECT COUNT(closing_id) AS total FROM closing WHERE category = '$category' AND type = '$type' AND period = '$period' AND month = '$month' AND status = 1";
            else $query = "SELECT COUNT(closing_id) AS total FROM closing WHERE category = '$category' AND type = '$type' AND period = '$period' AND status = 1";
            $total = $this->db->query($query)->row()->total;
        } 
        echo json_encode(array("exist"=>$total));
    }

    function verifyPeriodOpen()
    {
        $period = $this->input->post('period');
        $total = $this->db->query("SELECT COUNT(reopening_id) AS total FROM reopening WHERE period = '$period' AND status = 1")->row()->total;
        echo json_encode(array("exist"=>$total));
    }

    function verifyPeriodAdjust()
    {
        $category = $this->input->post('category');
        $type = $this->input->post('type');
        $period = $this->input->post('period');
        $month = $this->input->post('month');
        $query = ''; $total = 0;
        if ($category != 'other') {
            if ($type == "month") $query = "SELECT COUNT(adjust_id) AS total FROM adjust WHERE category = '$category' AND type = '$type' AND period = '$period' AND month = '$month' AND status = 1";
            else $query = "SELECT COUNT(adjust_id) AS total FROM adjust WHERE category = '$category' AND type = '$type' AND period = '$period' AND status = 1";
            $total = $this->db->query($query)->row()->total;
        }
        echo json_encode(array("exist"=>$total));
    }

    function getClosingById($id)
    {
        return $this->db->get_where("closing", array("closing_id"=>$id))->row_array();
    }

    function getReopeningById($id)
    {
        return $this->db->get_where("reopening", array("reopening_id"=>$id))->row_array();
    }

    function getAdjustById($id)
    {
        return $this->db->get_where("adjust", array("adjust_id"=>$id))->row_array();
    }

    function getBankConciliations()
    {
        return $this->db->get("bank_conciliation");
    }
    
    function getBankConciliation($id)
    {
        return $this->db->get_where("bank_conciliation", array("bank_conciliation_id"=>$id))->row_array();
    }
    
    function getBankConciliationType($id, $type)
    {
        return $this->db->get_where("bank_conciliation_detail", array("bank_conciliation_id"=>$id, "type"=>$type));
    }
    
    function getCashFlows()
    {
        return $this->db->get("cash_flow");
    }
    
    function getCashFlow($id)
    {
        return $this->db->get_where("cash_flow", array("cash_flow_id"=>$id))->row_array();
    }
    
    function getCashFlowType($id, $type)
    {
        return $this->db->get_where("cash_flow_detail", array("cash_flow_id"=>$id, "type"=>$type));
    }

    function getDataDeparture($id)
    {
        $dets = $this->db->query("SELECT nomenclature_id, (CASE WHEN debit IS NULL THEN 0 ELSE 1 END) AS debit, (CASE WHEN credit IS NULL THEN 0 ELSE 1 END) AS credit FROM departure_detail WHERE departure_id = '$id' AND status = 1")->result_array();
        return base64_encode(json_encode($dets));
    }
    
    function getGroupsAccount() {
        return $this->db->order_by("code", "ASC")->get_where("group_account", array("status"=>1));
    }
    
    function getNomenGeneral($type_id, $head_id, $group_id)
    {
        return $this->db->order_by("code", "ASC")->get_where("nomenclature", array("heading_type_id"=>$type_id, "heading_id"=>$head_id, "group_account_id"=>$group_id, "statement_id"=>1, "status" => 1));
    }

    function getValuesGeneral($initial, $final)
    {
        $cash = 0; $cash_petty = 0; $bancos = 0; $cuentas_cobrar = 0; $deprec = 0;
        $activo = 0; $act_corriente = 0; $act_no_corriente = 0;
        $pasivo = 0; $pas_corriente = 0; $pas_no_corriente = 0;
        $patrimonio = 0; $capital = 0; $utilidad = 0;
        $val = $this->getUtilityGeneral($initial, $final);
        $reserva = $val['legal']; $bruta = $val['gross']; $neta = $val['net'];
        $cashes = $this->getCashNomen();
        foreach ($cashes->result_array() as $ch) {
            $total = $this->getTotalYearNom($ch['nomenclature_id'], $initial, $final, 1);
            $activo += $total; $act_corriente += $total; $cash += $total;
        }
        // log_message("error", "Caja: $cash");
        $pettyCash = $this->getPettyCash();
        foreach ($pettyCash->result_array() as $ch) {
            $total = $this->getTotalYearNom($ch['nomenclature_id'], $initial, $final, 1);
            $activo += $total; $act_corriente += $total; $petty_cash += $total;
        }
        // log_message("error", "Chica: $petty_cash");
        for ($i=1; $i <= 6; $i++) { 
            $nom = $this->getNomenByCode("1.01.02.00$i");
            $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
            $activo += $total; $act_corriente += $total; $bancos += $total;
        }
        // log_message("error", "Bancos: $bancos");
        $nom = $this->getNomenByCode("1.01.03.001");
        $total = 0;
        /*if (strtotime($final) < strtotime($hoy)) $total = $this->getTotalInventory($final);
        else $total = $this->getTotalInventory();*/
        $activo += $total; $act_corriente += $total; $cuentas_cobrar += $total;
        $nom = $this->getNomenByCode("1.01.04.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
        $activo += $total; $act_corriente += $total; $cuentas_cobrar += $total;
        $nom = $this->getNomenByCode("1.01.04.002");
        $total = $total * 0.03; $activo -= $total; $act_corriente -= $total; $cuentas_cobrar -= $total;
        // log_message("error", "Ctas por Cobrar: $cuentas_cobrar");
        $nom = $this->getNomenByCode("1.01.05.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
        $activo += $total; $act_corriente += $total;
        // log_message("error", "Act Cor: $act_corriente");
        for ($i=1; $i <= 9; $i++) { 
            $nom = $this->getNomenByCode("1.02.01.00$i");
            $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
            $activo += $total; $act_no_corriente += $total; $depreciacion += $total;
            if(($i % 2) == 0) $depreciacion = 0;
        }
        /* log_message("error", "Act No Cor: $act_no_corriente");
        log_message("error", "Activo: $activo"); */
        for ($i=1; $i <= 5; $i++) { 
            $nom = $this->getNomenByCode("2.01.01.00$i");
            $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 2);
            $pasivo += $total; $pas_corriente += $total;
        }
        // log_message("error", "Pas Cor: $pas_corriente");
        $nom = $this->getNomenByCode("2.02.01.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 2);
        $pasivo += $total; $pas_no_corriente += $total;
        // log_message("error", "Pas No Cor: $pas_no_corriente");
        $nom = $this->getNomenByCode("3.01.01.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 3);
        $patrimonio += $total; $capital += $total;
        $nom = $this->getNomenByCode("3.01.01.002");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 3);
        $patrimonio -= $total; $capital -= $total;
        // log_message("error", "Capital: $capital");
        $patrimonio += $reserva;
        // log_message("error", "Reserva: $reserva");
        $total = $activo - $pasivo - $capital - $reserva - $neta;
        $ut_no_dist = $total;
        $patrimonio += $total;
        // log_message("error", "Ut no dist: $total");
        $patrimonio += $neta; $utilidad += $total + $neta;
        /* log_message("error", "Ut neta: $neta");
        log_message("error", "Util: $utilidad");
        log_message("error", "Patrim: $patrimonio"); */
        $patrimonio += $pasivo;
        // log_message("error", "Patrim: $patrimonio");
        return array("caja"=>$cash, "chica"=>$petty_cash, "bancos"=>$bancos, "cuentas_cobrar"=>$cuentas_cobrar, "act_corriente"=>$act_corriente, "act_no_corriente"=>$act_no_corriente, "activo"=>$activo, "pas_corriente"=>$pas_corriente, "pas_no_corriente", "capital"=>$capital, "reserva"=>$reserva, "ut_no_dist"=>$ut_no_dist, "neta"=>$neta, "utilidad"=>$utilidad, "patrimonio"=>$patrimonio);
    }

    function getNomenByGroup($group_id)
    {
        return $this->db->order_by("code", "ASC")->get_where("nomenclature", array("group_account_id"=>$group_id, "status"=>1));
    }

    function addFieldSelect()
    {
        $cont = $this->input->post('cont');
        $cant = $this->input->post('cant');
        $rubros = $this->getNomenclature();
        $field = '<tr id="rowField_'.$cont.'">
            <input type="hidden" name="departure_detail_id[]" value="" />
            <td id="selectNomen_'.$cont.'">
                <div class="input-group">
                    <div style="width:80%;">
                        <select class="form-control select2-nom select2-nom-add" id="nomen_id_'.$cont.'" name="nomen_id[]" onchange="verifyNomen(this.value, '.$cont.')" required><option value="">Seleccionar</option>';
        foreach ($rubros->result_array() as $rb) {
            $field .= '<option value="'.$rb['nomenclature_id'].'">'.$rb['code'].' '.$rb['name'].'</option>';
        }
        $field .= '</select>
                    </div>
                    <div class="input-group-addon input-group-append" id="divSwitch_'.$cont.'" style="display: none;">
                        <div class="input-group-text">
                            <div class="custom-control custom-switch" data-toggle="tooltip" data-placement="right" title="Ver facturas">
                                <input type="checkbox" class="check-purchase custom-control-input" id="switch_'.$cont.'" switch="info" checked onchange="checkPurchase(this, '.$cont.')" />
                                <label for="switch_'.$cont.'" class="custom-control-label"></label>
                            </div>
                        </div>
                    </div>
                    <span class="input-group-addon input-group-append" id="btnAddPur_'.$cont.'" style="display: none;">
                        <input type="button" class="btn btn-primary" value="+" onclick="addPurchase()" />
                    </span>
                    <input type="hidden" id="purchase_'.$cont.'" name="purchase[]" value="" />
                    <input type="hidden" id="from_id_'.$cont.'" name="from_id[]" value="" />
                </div>
                <small class="text-danger" id="msgNomen_'.$cont.'"></small>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </span>
                    <input type="number" class="form-control debe" id="debe_'.$cont.'" name="debe[]" value="" step="0.01" min="0" oninput="sumarTotales()" />
                </div>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </span>
                    <input type="number" class="form-control .haber" id="haber_'.$cont.'" name="haber[]" value="" step="0.01" min="0" oninput="sumarTotales()" />
                </div>
            </td>
            <td>
                <div style="display:flex;">
                    <div class="">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" id="btn_group_'.$cont.'">...</button>
                        <div class="dropdown-menu" aria-labelledby="btn_group_'.$cont.'">
                            <a class="dropdown-item" href="javascript:void(0);" onclick="checkIVASelect(12, \'C\', '.$cont.')">IVA regimen general - Crédito Fiscal</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="checkIVASelect(12, \'D\', '.$cont.')">IVA regimen general - Débito Fiscal</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="checkISRSelect('.$cont.', \'G\')">ISR Régimen General</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="checkRetenSelect(\'G\', '.$cont.')">Retención de IVA General</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="checkRetenSelect(\'P\', '.$cont.')">Retención de IVA Peq. Contribuyente</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="checkExeSelect('.$cont.')">Exenta del IVA</a>
                        </div>
                    </div>
                    &nbsp;
                    <button class="btn btn-danger" type="button" onclick="deleteParent('.$cont.')">x</button>
                </div>
            </td>
            <script>$(".select2-nom-add").select2({placeholder: "Escribe el código de algún rubro",});</script>
        </tr>';
        echo json_encode(array("field"=>$field));
    }

    function addIVASelect()
    {
        $nomen = $this->input->post('nomen');
        $reg = $this->input->post('reg');
        $idx = $this->input->post('index');
        $cont = $this->input->post('cont');
        $cant = $this->input->post('cant');
        $iva = $this->input->post('iva');
        $val = $this->input->post('res');
        $nom_id = $this->input->post('nom_id');
        if ($nomen == 'C') $nom = $this->nomenByID(25);
        elseif ($nomen == 'D') $nom = $this->nomenByID(58);
        $id = $nom['nomenclature_id'];
        // log_message("error", "ID: $id, regimen: $reg, tipo: $nomen, indice: $idx, contador: $cont, cantidad: $cant, iva: $iva, restante: $val");
        $field = '<tr class="text-center" id="rowIVA_'.$idx.'">
            <td id="selectNomen_'.$cont.'"><b id="nameIVA_'.$idx.'">'.$nom['code'].' '.$nom['name'].'</b>
                <input type="hidden" id="nomen_id_IVA_'.$idx.'" name="nomen_id[]" value="'.$nom['nomenclature_id'].'" />
                <input type="hidden" id="purchase_'.$cont.'" name="purchase[]" value="'.$nom['purchase'].'" />
                <input type="hidden" id="from_id_IVA_'.$idx.'" name="from_id[]" value="'.$nom_id.'" />
                <small class="text-danger" id="msgNomenIVA_'.$idx.'"></small>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </span>
                    <input type="number" class="form-control" id="debeIVA_'.$idx.'" name="debe[]" value="';
        if ($id == 25) $field .= number_format($iva,2,".","");
        $field .= '" step="0.01" min="0" oninput="sumarTotales()" />
                </div>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </span>
                    <input type="number" class="form-control" id="haberIVA_'.$idx.'" name="haber[]" value="';
        if ($id == 58) $field .= number_format($iva,2,".","");
        $field .= '" step="0.01" min="0" oninput="sumarTotales()" />
                </div>
            </td>
            <td>
                <div style="display:flex;">
                    <button class="btn btn-danger" type="button" onclick="deleteIVA('.$idx.')">x</button>
                </div>
            </td>
        </tr>';
        echo json_encode(array("rubro"=>$field, "reg"=>$reg, "iva"=>number_format($iva,2,".",""), "restante"=>number_format($val,2,".","")));
    }

    function addISRSelect()
    {
        $idx = $this->input->post('idx');
        $cont = $this->input->post('cont');
        $cant = $this->input->post('cant'); 
        $isr = $this->input->post('isr');
        $val = $this->input->post('res');
        $parte = $this->input->post('parte');
        $nom_id = $this->input->post('nom_id');
        $rubros = $this->getNomenISR();
        // log_message("error", "Indice: $idx, contador: ".$cont.", cantidad: $cant, isr: $isr, restante: $val");
        $field = '<tr class="text-center" id="rowISR_'.$idx.'">
            <td id="selectNomen_'.$cont.'">
                <div class="input-group">
                    <select class="form-control select2-isr select2-ISR-add" id="nomen_id_'.$cont.'" name="nomen_id[]" onchange="verifyNomen(this.value, '.$cont.')" required><option value="">Seleccionar un rubro de ISR</option>';
        foreach ($rubros->result_array() as $rb) {
            $field .= '<option value="'.$rb['nomenclature_id'].'">'.$rb['code'].' '.$rb['name'].'</option>';
        } 
        $field .= '</select>
                    <input type="hidden" id="purchase_'.$cont.'" name="purchase[]" value="" />
                    <input type="hidden" id="from_id_ISR_'.$idx.'" name="from_id[]" value="'.$nom_id.'" />
                </div>
                <small class="text-danger" id="msgNomenISR_'.$idx.'"></small>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </span>
                    <input type="number" class="form-control" id="debeISR_'.$idx.'" name="debe[]" value="';
        if ($parte == 0) $field .= number_format($isr,2,".","");
        $field .= '" step="0.01" min="0" oninput="sumarTotales()" />
                </div>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </span>
                    <input type="number" class="form-control" id="haberISR_'.$idx.'" name="haber[]" value="';
        if ($parte == 1) $field .= number_format($isr,2,".","");
        $field .= '" step="0.01" min="0" oninput="sumarTotales()" />
                </div>
            </td>
            <td>
                <div style="display:flex;">
                    <button class="btn btn-danger" type="button" onclick="deleteISR('.$idx.')">x</button>
                </div>
            </td>
            <script type="text/javascript">$(".select2-ISR-add").select2({placeholder: "Selecciona un rubro de ISR",});</script>
        </tr>';
        echo json_encode(array("rubro"=>$field, "isr"=>number_format($isr,2,".",""), "restante"=>number_format($val,2,".","")));
    }

    function addRetenSelect()
    {
        $idx = $this->input->post('idx');
        $cant = $this->input->post('cant');
        $cont = $this->input->post('cont');
        $reten = $this->input->post('reten');
        $val = $this->input->post('res');
        $parte = $this->input->post('parte');
        $nom_id = $this->input->post('nom_id');
        $rubros = $this->getNomenReten();
        // log_message("error", "Indice: $idx, contador: $cont, cantidad: $cant, reten: $reten, restante: $val");
        $field = '<tr class="text-center" id="rowReten_'.$idx.'">
            <td id="selectNomen_'.$cont.'">
                <div class="input-group">
                    <select class="form-control select2-reten select2-reten-add" id="nomen_id_'.$cont.'" name="nomen_id[]" onchange="verifyNomen(this.value, '.$cont.')" required><option value="">Seleccionar un rubro de retención</option>';
        foreach ($rubros->result_array() as $rb) {
            $field .= '<option value="'.$rb['nomenclature_id'].'">'.$rb['code'].' '.$rb['name'].'</option>';
        }
        $field .= '</select>
                    <input type="hidden" id="purchase_'.$cont.'" name="purchase[]" value="" />
                    <input type="hidden" id="from_id_Reten_'.$idx.'" name="from_id[]" value="'.$nom_id.'" />
                </div>
                <small class="text-danger" id="msgNomenReten_'.$idx.'"></small>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </span>
                    <input type="number" class="form-control" id="debeReten_'.$idx.'" name="debe[]" value="';
        if ($parte == 0) $field .= number_format($reten,2,".","");
        $field .= '" step="0.01" min="0" oninput="sumarTotales()" />
                </div>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </span>
                    <input type="number" class="form-control" id="haberReten_'.$idx.'" name="haber[]" value="';
        if ($parte == 1) $field .= number_format($reten,2,".","");
        $field .= '" step="0.01" min="0" oninput="sumarTotales()" />
                </div>
            </td>
            <td>
                <div style="display:flex;">
                    <button class="btn btn-danger" type="button" onclick="deleteReten('.$idx.')">x</button>
                </div>
            </td>
            <script type="text/javascript">
                $(".select2-reten-add").select2({placeholder: "Selecciona un rubro de retención",});
            </script>
        </tr>';
        echo json_encode(array("rubro"=>$field, "reten"=>number_format($reten,2,".",""), "restante"=>number_format($val,2,".","")));
    }

    function addExenSelect()
    {
        $idx = $this->input->post('idx');
        $cant = $this->input->post('cant');
        $cont = $this->input->post('cont');
        $exen = $this->input->post('exen');
        $val = $this->input->post('res');
        $parte = $this->input->post('parte');
        $nom_id = $this->input->post('nom_id');
        $rubros = $this->getNomenExen();
        // log_message("error", "Indice: $idx, contador: $cont, cantidad: $cant, exen: $exen, restante: $val");
        $field = '<tr class="text-center" id="rowExen_'.$idx.'">
            <td id="selectNomen_'.$cont.'">
                <div class="input-group">
                    <select class="form-control select2-exen select2-exen-add" id="nomen_id_'.$cont.'" name="nomen_id[]" onchange="verifyNomen(this.value, '.$cont.')" required><option value="">Seleccionar un rubro de exención</option>';
        foreach ($rubros->result_array() as $rb) {
            $field .= '<option value="'.$rb['nomenclature_id'].'">'.$rb['code'].' '.$rb['name'].'</option>';
        }
        $field .= '</select>
                    <input type="hidden" id="purchase_'.$cont.'" name="purchase[]" value="" />
                    <input type="hidden" id="from_id_Exen_'.$idx.'" name="from_id[]" value="'.$nom_id.'" />
                </div>
                <small class="text-danger" id="msgNomenExen_'.$idx.'"></small>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </span>
                    <input type="number" class="form-control" id="debeExen_'.$idx.'" name="debe[]" value="';
        if ($parte == 0) $field .= number_format($exen,2,".","");
        $field .= '" step="0.01" min="0" oninput="sumarTotales()" />
                </div>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </span>
                    <input type="number" class="form-control" id="haberExen_'.$idx.'" name="haber[]" value="';
        if ($parte == 1) $field .= number_format($exen,2,".","");
        $field .= '" step="0.01" min="0" oninput="sumarTotales()" />
                </div>
            </td>
            <td>
                <div style="display:flex;">
                    <button class="btn btn-danger" type="button" onclick="deleteExen('.$idx.')">x</button>
                </div>
            </td>
            <script type="text/javascript">
                $(".select2-exen-add").select2({placeholder: "Selecciona un rubro de exención",});
            </script>
        </tr>';
        echo json_encode(array("rubro"=>$field, "reten"=>number_format($reten,2,".",""), "restante"=>number_format($val,2,".","")));
    }
    
    function inputsPurchase()
    {
        $date = date("Y-m-d");
        $cont = $this->input->post('cont');
        $index = $this->input->post('index');
        $total = $this->input->post('total');
        $selImp = ''; $selCom = ''; $selSer = ''; $type = '';
        $name = $this->input->post('name');
        if ($name != '') {
            $name_low = strtolower($this->input->post('name'));
            if(strpos($name_low, "import") !== false) {
                $type = 'I';
                $selImp = 'selected';
            } elseif ((strpos($name_low, "equipo") !== false) || (strpos($name_low, "compra") !== false) || (strpos($name_low, "insumo") !== false) || (strpos($name_low, "gasto") !== false) || (strpos($name_low, "papel") !== false) || (strpos($name_low, "viático") !== false)) {
                $type = 'C';
                $selCom = 'selected';
            } else {
                $type = 'S';
                $selSer = 'selected';
            }
        } else {
            $type = 'C';
            $selCom = 'selected';
        }
        $provs = $this->getProvidersActive();
        $inst2 = $this->getInstitutions();
        $inst = $this->getInstitutionProduction();
        $inputs = '<tr id="dataPurchase_'.$cont.'">
            <td>
                <div class="form-group">
                    <input type="date" class="form-control" name="date_pur[]" id="date_'.$cont.'" value="'.$date.'" />
                </div>
            </td>
            <td>
                <input type="hidden" name="purchase_id[]" id="purchase_id_'.$cont.'" value="" />
                <input type="hidden" name="cont_purchase[]" id="cont_purchase_'.$cont.'" value="'.$cont.'" />
                <div class="form-group">
                    <input type="text" class="form-control" name="document_type[]" id="document_type_'.$cont.'" value="" oninput="verifyPurchase()" />
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control" name="serie[]" id="serie_'.$cont.'" value="" />
                </div>
            </td>
            <td>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="number[]" id="number_'.$cont.'" value="" oninput="verifyPurchase()" onblur="searchNumDoc('.$cont.')" />
                    </div>
                    <small class="text-danger" id="spnNumber_'.$cont.'"></small>
                    <input type="hidden" name="val_number[]" id="val_number_'.$cont.'" value="" />
                </div>
            </td>
            <td>
                <div class="form-group">
                    <select class="form-control select2-provider" name="provider_id[]" id="provider_id_'.$cont.'" onchange="dataProvider(this.value, '.$cont.')"><option value="">Selecciona un proveedor</option><option value="N">Nuevo</option>';
        foreach ($provs->result_array() as $pv) {
            $inputs .= '<option value="'.$pv['provider_id'].'">'.$pv['nit'].' '.$pv['name'].'</option>';
        }
        $inputs .= '</select>
                </div>
                <div class="form-group" id="dataProvider_'.$cont.'" style="display:none;">
                    <div class="input-group">
                        <input type="text" class="form-control" name="name[]" id="name_'.$cont.'" value="" placeholder="Nombre" oninput="verifyPurchase()" />
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" name="nit[]" id="nit_'.$cont.'" value="" placeholder="NIT" />
                    </div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control" name="institution_id[]" id="institution_id_'.$cont.'" ><option value="">Selecciona una establecimiento</option>';
        /* foreach ($inst->result_array() as $in) {
            $inputs .= '<option value="'.$in['institution_id'].'">'.$in['code'].' - '.$in['name'].'</option>';
        } */
        foreach ($inst2->result_array() as $in) {
            $inputs .= '<option value="'.$in['institution_id'].'">'.$in['code'].' - '.$in['name'].'</option>';
        }
        $inputs .= '</select>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <select class="form-control" name="type[]" id="type_'.$cont.'">
                        <option value="C" '.$selCom.'>Bien</option>
                        <option value="S" '.$selSer.'>Servicio</option>
                        <option value="I" '.$selImp.'>Importación</option>
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control cant-purchase" name="cant[]" id="cant_'.$cont.'" value="'.number_format($total,2,'.',',').'" placeholder="0" oninput="cantPartial('.$cont.')" step="0.01" min="1" max="" />
                    <input type="hidden" class="form-control" name="sin_iva[]" id="sin_iva_'.$cont.'" value="" />
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="checkbox" id="check_regime_'.$cont.'" switch="primary" value="1" onclick="cantPartial('.$cont.')" checked />
                    <label for="check_regime_'.$cont.'" data-on-label="Gen" data-off-label="Peq"></label>
                </div>
                <input type="hidden" id="regime_'.$cont.'" name="regime[]" value="G" />
            </td>
            <td>
                <div class="form-group">
                    <input type="checkbox" id="check_exempt_'.$cont.'" name="exempt[]" switch="info" value="1" onclick="cantPartial('.$cont.')" />
                    <label for="check_exempt_'.$cont.'" data-on-label="Si" data-off-label="No"></label>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control" name="iva_pur[]" id="iva_'.$cont.'" value="" placeholder="0" step="0.01" min="0" oninput="sumPartial()" />
                    <input type="hidden" name="hidden_iva[]" id="hidden_iva_'.$cont.'" value="0" />
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control" name="isr_pur[]" id="isr_'.$cont.'" value="" placeholder="0" step="0.01" min="0" oninput="sumPartial()" />
                </div>
            </td>
            <td>
                <input type="button" class="btn btn-danger" value="x" onclick="removePurchase('.$cont.')" />
            </td>
            <script type="text/javascript">
                $(document).ready(function () {
                    $(".select2-provider").select2({
                        placeholder: "Escribe el código o nombre de algún producto",
                        ajax: {
                            url: "'.base_url().'admin/getProviderAjax/1",
                            type: "POST",
                            dataType: "json",
                            delay: 250,
                            data: function (params) {
                                return {
                                    searchTerm: params.term,
                                };
                            },
                            processResults: function (response) {
                                return {
                                    results: response
                                };
                            }
                        }
                    });
                });
            </script>
        </tr>';
        echo json_encode(array("inputs"=>$inputs, "type"=>$type));
    }
    
    function searchNomenclatureSelect() {
        $search = $this->input->post('search');
        $nom_id = $this->input->post('nom_id');
        $select = '<option value="">Seleccione un rubro</option>';
        $query = "SELECT * FROM nomenclature WHERE status = 1 AND CONCAT_WS(' ', code, name) LIKE '%$search%' ORDER BY nomenclature_id ASC";
        $noms = $this->db->query($query);
        if ($noms->num_rows() > 0) {
            foreach ($noms->result_array() as $nm) {
                $select .= '<option value="'.$nm['nomenclature_id'].'"';
                if ($nom_id == $nm['nomenclature_id']) $select .= ' selected';
                $select .= '>'.$nm['code'].' - '.$nm['name'].'</option>';
            }
        } else {
            $select = '<option value="" selected>No se encontraron coincidencias</option>';
        }
        echo json_encode(array("results"=>$noms->num_rows(), "select"=>$select));
    }
    
    function getProviderAjax($new = '')
    {
        $search = $this->input->post('searchTerm');
        $query = '';
        if (!isset($search)) {
            $query = "SELECT * FROM provider WHERE status = 1 ORDER BY provider_id ASC LIMIT 5";
        } else {
            $query = "SELECT * FROM provider WHERE status = 1 AND CONCAT_WS(' ', code, name) LIKE '%$search%' ORDER BY provider_id ASC";
        }
        $data = $this->db->query($query)->result_array();
        $response = array();
        // log_message("error", "Nuevo: $new");
        if ($new) $response[] = array("id"=>'N', "text"=>"Nuevo");
        foreach ($data as $pv) {
            $response[] = array(
                "id" => $pv['provider_id'],
                "text" => $pv['code'].' - '.$pv['name']
            );
        }
        echo json_encode($response);
    }
    
    function getProviderJson()
    {
        $provider_id = $this->input->post('id');
        $prov = $this->db->get_where('provider', array('provider_id'=>$provider_id))->row_array();
        echo json_encode($prov);
    }
    
    function countExistPurchase()
    {
        $number = $this->input->post('number');
        $count = $this->db->query("SELECT COUNT(purchase_id) AS total FROM purchase WHERE status = 1 AND number = '$number'")->row()->total;
        echo json_encode(array("count"=>$count));
    }
    
    function countOtherExistPurchase()
    {
        $id = $this->input->post('id');
        $number = $this->input->post('number');
        $count = $this->db->query("SELECT COUNT(purchase_id) AS total FROM purchase WHERE status = 1 AND number = '$number' AND purchase_id != '$id'")->row()->total;
        echo json_encode(array("count"=>$count));
    }

    function correlativeCode($id, $prefix = null, $length = 12)
    {
        $code = '';
        if ($length < strlen($id)) $length++;
    
        if (is_string($prefix)) $code = sprintf("%s%s", $prefix, str_pad($id, $length, "0", STR_PAD_LEFT));
        else $code = str_pad($id, $length, "0", STR_PAD_LEFT);

        return $code;
    }

    function countAccountByNomen($nomen_id)
    {
        return $this->db->query("SELECT COUNT(bank_account_id) AS total FROM bank_account WHERE nomenclature_id = '$nomen_id' AND status = 1")->row()->total;
    }

    function getAccountByNomen($nomen_id)
    {
        return $this->db->query("SELECT * FROM bank_account WHERE nomenclature_id = '$nomen_id' AND status = 1")->row_array();
    }
    
    function randCode($index = '')
    {
        $codigo = strtoupper(substr(sha1(rand(100000000, 20000000000000)), 0, 6));
        return $index.$codigo;
    }

    function getNoPolicyNom($nom_id) {
        $year = date('Y');
        $no = $this->db->query("SELECT no_policy FROM policy WHERE nomenclature_id = '$nom_id' AND year = '$year' AND status = 1 ORDER BY no_policy DESC LIMIT 1")->row()->no_policy;
        $new = $no + 1;
        return $new;
    }

    function getDepartureByID($departure_id)
    {
        return $this->db->get_where("departure", array("departure_id"=>$departure_id))->row_array();
    }

    function getDetailsDeparture($departure_id)
    {
        return $this->db->order_by("number", "asc")->get_where("departure_detail", array("departure_id"=>$departure_id, "status"=>1));
    }

    function getPurchaseByDep($departure_id)
    {
        return $this->db->get_where("purchase", array("status"=>1, "departure_id"=>$departure_id));
    }
    
    function createDepByPurchase($pedido_id) {
        $fechaHora = date("Y-m-d H:i:s");
        
        $ped = $this->db->get_where('pedidos', array('pedidos_id'=>$pedido_id))->row_array();
        $amount = 0; $iva = 0; $isr = 0; $number = 1;
        $total = $ped['total'];
        $amount = $total / 1.12;
        $iva = $amount * 0.12;
        if ($amount > 30000) {
            $isr = $amount * 0.07;
        } elseif ($amount >= 2500) {
            $isr = $amount * 0.05;
        }
        
        $data1['date']          = $ped['date'];
        $data1['datetime']      = $fechaHora;
        $data1['amount']        = $amount;
        $data1['iva']           = $iva;
        $data1['isr']           = $isr;
        $data1['total']         = $total;
        $data1['regime']        = 'G';
        $data1['details']       = "Por compra de productos pedidos en fecha ".date("d/m/Y", strtotime($ped['date'])).", por un total de Q.".number_format($total,2,'.',',').".";
        $data1['admin_id']      = $this->session->userdata('login_user_id');
        $data1['purchase']      = 1;
        $this->db->insert('departure', $data1);
        $departure_id = $this->db->insert_id();
        
        $nom = $this->db->get_where("nomenclature", array("name"=>"Compras"))->row_array();
        $data2['number']          = $number++;
        $data2['departure_id']    = $departure_id;
        $data2['nomenclature_id'] = $nom['nomenclature_id'];
        $data2['debit']           = $amount;
        $data2['position']        = 'D';
        $this->db->insert('departure_detail', $data2);
        $departure_detail_id = $this->db->insert_id();
        $move = $nom['move'];
        $from_id = $nom['nomenclature_id'];
        
        if ($nom['heading_id'] == 1) {
            $data4 = array(); 
            $data4['departure_id']        = $departure_id;
            $data4['departure_detail_id'] = $departure_detail_id;
            $data4['nomenclature_id']     = $nom['nomenclature_id'];
            $data4['year']                = date('Y');
            $data4['no_policy']           = $this->getNoPolicyNom($nom['nomenclature_id']);
            $data4['type']                = 'Diario';
            $data4['concept']             = $details;
            $data4['approve_charge']      = "Gerente";
            $data4['maker_charge']        = "Auxiliar Contable";
            $this->db->insert('policy', $data4);
            $policy_id = $this->db->insert_id();
            
            /*$mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data6).".";
            $this->binnacle($mensaje, "policy", $policy_id);*/
        }
        
        $nom = $this->db->get_where("nomenclature", array("name"=>"Crédito fiscal IVA"))->row_array();
        $data5['number']          = $number++;
        $data5['departure_id']    = $departure_id;
        $data5['nomenclature_id'] = $nomenclature_id;
        $data5['from_id']         = $from_id;
        $data5['debit']           = $iva;
        $data5['position']        = 'D';
        $this->db->insert('departure_detail', $data5);
        $departure_detail_id = $this->db->insert_id();
        
        if ($nom['heading_id'] == 1) {
            $data6 = array(); 
            $data6['departure_id']        = $departure_id;
            $data6['departure_detail_id'] = $departure_detail_id;
            $data6['nomenclature_id']     = $nom['nomenclature_id'];
            $data6['year']                = date('Y');
            $data6['no_policy']           = $this->getNoPolicyNom($nom['nomenclature_id']);
            $data6['type']                = 'Diario';
            $data6['concept']             = $details;
            $data6['approve_charge']      = "Gerente";
            $data6['maker_charge']        = "Auxiliar Contable";
            $this->db->insert('policy', $data6);
            $policy_id = $this->db->insert_id();
            
            /*$mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data6).".";
            $this->binnacle($mensaje, "policy", $policy_id);*/
        }
        
        $nom = $this->db->get_where("nomenclature", array("nomenclature_id"=>$ped['nomenclature_id']))->row_array();
        $data7['number']          = $number++;
        $data7['departure_id']    = $departure_id;
        $data7['nomenclature_id'] = $nom['nomenclature_id'];
        $data7['credit']          = $total;
        $data7['position']        = 'C';
        $this->db->insert('departure_detail', $data7);
        $departure_detail_id = $this->db->insert_id();
        
        if ($nom['heading_id'] == 1) {
            $data8 = array(); 
            $data8['departure_id']        = $departure_id;
            $data8['departure_detail_id'] = $departure_detail_id;
            $data8['nomenclature_id']     = $nom['nomenclature_id'];
            $data8['year']                = date('Y');
            $data8['no_policy']           = $this->getNoPolicyNom($nom['nomenclature_id']);
            $data8['type']                = 'Diario';
            $data8['concept']             = $details;
            $data8['approve_charge']      = "Gerente";
            $data8['maker_charge']        = "Auxiliar Contable";
            $this->db->insert('policy', $data8);
            $policy_id = $this->db->insert_id();
            
            /*$mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data6).".";
            $this->binnacle($mensaje, "policy", $policy_id);*/
        }
        
        $account = $this->countAccountByNomen($nom['nomenclature_id']);
        if ($account > 0) {
            $bank = $this->getAccountByNomen($nom['nomenclature_id']);
            $transfer = $amount;
            $balance = $bank['balance'] - $transfer;
            
            $data9['type']                = 0;
            $data9['move']                = $move;
            $data9['code']                = $this->randCode("BT-");
            $data9['reference_table']     = "departure";
            $data9['reference_id']        = $departure_id;
            $data9['reference_detail_id'] = $departure_detail_id;
            $data9['bank_account_id']     = $bank['bank_account_id'];
            $data9['date']                = $ped['date'];
            $data9['datetime']            = $fechaHora;
            $data9['amount']              = $transfer;
            $data9['balance']             = $balance;
            $data9['description']         = $data1['details'];
            $this->db->insert('bank_transfer', $data9);
            $bank_transfer_id = $this->db->insert_id();

            /*$mensaje = "Ha creado una transferencia bancaria con id: $bank_transfer_id, con la información: ".json_encode($data4).".";
            $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id);*/

            $data10['balance'] = $balance;
            $this->db->where('bank_account_id', $bank['bank_account_id']);
            $query = $this->db->update('bank_account', $data10);

            /*$mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: ".$bank['bank_account_id'].", al saldo: $balance.";
            $this->binnacle($mensaje, "bank_account", $bank['bank_account_id']);*/
        }
        
        $data11['data'] = $this->getDataDeparture($departure_id);
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $data11);
        
        $prov = $this->db->get_where('provider', array('provider_id'=>$ped['provider_id']))->row_array();
        $type_purchase = '';
        if ($ped['order_type'] == '1') $type_purchase = 'B';
        elseif ($ped['order_type'] == '2') $type_purchase = 'S';
        
        $data12['departure_id']   = $departure_id;
        $data12['pedido_id']      = $pedido_id;
        $data12['date']           = $ped['date'];
        $data12['datetime']       = $fechaHora;
        $data12['institution_id'] = 1;
        $data12['provider_id']    = $ped['provider_id'];
        $data12['number']         = $ped['invoice_code'];
        $data12['serie']          = $ped['reference_code'];
        $data12['document_type']  = "FC";
        $data12['name']           = $prov['name'];
        $data12['nit']            = $prov['nit'];
        $data12['type']           = $type_purchase;
        $data12['amount']         = $amount;
        $data12['regime']         = 'G';
        $data12['isr']            = $isr;
        $data12['exempt']         = 0;
        $data12['iva']            = $iva;
        $data12['total']          = $total;
        $this->db->insert('purchase', $data12);
        $purchase_id = $this->db->insert_id();

        return $departure_id;
    }
    
    function createDepBySale($sale_id)  {
        $sale = $this->db->get_where('sale', array('sale_id'=>$sale_id))->row_array();
        $no_invoice = $sale['invoice']; $cliente = $sale['name']; $regime = $sale['regime']; $method = $sale['method'];
        $total = $sale['total']; $iva = 0; $isr = 0; $sin_iva = 0;
        if ($regime == 'G') {
            $sin_iva = $total / 1.12;
            $iva = $sin_iva * 0.12;
            
            /* if ($sin_iva > 30000) $isr = $sin_iva * 0.07;
            elseif ($sin_iva >= 2500) $isr = $sin_iva * 0.05;  */
        } else {
            $iva = $total * 0.05;
            $sin_iva = $total * $iva;
        }
        $amount = $sin_iva;
        
        $data1['date']      = $sale['date'];
        $data1['datetime']  = $sale['datetime'];
        $data1['amount']    = $amount;
        $data1['iva']       = $iva;
        $data1['isr']       = $isr;
        $data1['total']     = $total;
        $data1['regime']    = $regime;
        $data1['type_user'] = $this->session->userdata('login_type');
        $data1['admin_id']  = $this->session->userdata('login_user_id');
        $data1['details']   = "Fact. $invoice $cliente";
        $this->db->insert('departure', $data1);
        $departure_id = $this->db->insert_id();
        
        $data2['code'] = $this->correlativeCode($departure_id);
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $data2);

        /* $mensaje = "Ha creado la partida con id: $departure_id con la información: ".json_encode(array_merge($data1, $data2)).".";
        $this->binnacle($mensaje, "departure", $departure_id); */

        $data3['departure_id'] = $departure_id;
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->update('sale', $data3);

        /* $mensaje = "Ha asignado la partida con id: $departure_id, a la venta: $sale_id.";
        $this->binnacle($mensaje, "sale", $sale_id); */
        
        $num = 1;
        if ($method == '4') {
            $nom = $this->getNomenByCode("1.01.04.001");
            $nomen_id = $nom['nomenclature_id'];
            $data4['number']          = $num++;
            $data4['departure_id']    = $departure_id;
            $data4['nomenclature_id'] = $nomen_id;
            $data4['debit']           = $total;
            $data4['position']        = 'D';
            $this->db->insert('departure_detail', $data4);
            $departure_detail_id = $this->db->insert_id();
            
            if ($nom['heading_id'] == 1) {
                $data5 = array(); 
                $data5['departure_id']        = $departure_id;
                $data5['departure_detail_id'] = $departure_detail_id;
                $data5['nomenclature_id']     = $nomen_id;
                $data5['year']                = date('Y');
                $data5['no_policy']           = $this->getNoPolicyNom($nomen_id);
                $data5['type']                = 'Diario';
                $data5['concept']             = $details;
                $data5['approve_charge']      = "Gerente";
                $data5['maker_charge']        = "Auxiliar Contable";
                $this->db->insert('policy', $data5);
                $policy_id = $this->db->insert_id();
                
                /* $mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data5).".";
                $this->binnacle($mensaje, "policy", $policy_id); */
            }
        }

        $methods = $this->db->get_where('income', array('sale_id'=>$sale_id))->result_array();
        
        foreach ($methods as $mt) {
            $data4 = array(); $data5 = array(); $data6 = array(); $data7 = array(); $nomen_id = 0; $method = 0; $nom = array(); $total = 0;
            $method = $mt['method']; $total = $mt['amount'];
            if ($method == '1') $nomen_id = $mt['cash_id'];
            else $nomen_id = $mt['bank_account_id'];
            
            if ($nomen_id > 0) {
                $data4['number']          = $num++;
                $data4['departure_id']    = $departure_id;
                $data4['nomenclature_id'] = $nomen_id;
                $data4['debit']           = $total;
                $data4['position']        = 'D';
                $this->db->insert('departure_detail', $data4);
                $departure_detail_id = $this->db->insert_id();
                
                /* $mensaje = "Ha creado el detalle de partida con id: $departure_detail_id con la información: ".json_encode($data4).".";
                $this->binnacle($mensaje, "departure_detail", $departure_detail_id); */
                
                $nom = $this->getNomen($nomen_id);
                if ($nom['heading_id'] == 1) {
                    $data5 = array(); 
                    $data5['departure_id']        = $departure_id;
                    $data5['departure_detail_id'] = $departure_detail_id;
                    $data5['nomenclature_id']     = $nomen_id;
                    $data5['year']                = date('Y');
                    $data5['no_policy']           = $this->getNoPolicyNom($nomen_id);
                    $data5['type']                = 'Diario';
                    $data5['concept']             = $details;
                    $data5['approve_charge']      = "Gerente";
                    $data5['maker_charge']        = "Auxiliar Contable";
                    $this->db->insert('policy', $data5);
                    $policy_id = $this->db->insert_id();
                    
                    /* $mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data5).".";
                    $this->binnacle($mensaje, "policy", $policy_id); */
                }
                
                if ($method != '1') {
                    $banco = $this->getAccountByNomen($nomen_id);
                    $balance = 0;
                    $transfer = $total;
                    $balance = $banco['balance'] + $transfer;
                    $data6['code']                = $this->randCode("BT-");
                    $data6['type']                = 1;
                    $data6['move']                = 1;
                    $data6['reference_table']     = "departure";
                    $data6['reference_id']        = $departure_id;
                    $data6['reference_detail_id'] = $departure_detail_id;
                    $data6['bank_account_id']     = $banco['bank_account_id'];
                    $data6['date']                = $sale['date'];
                    $data6['datetime']            = $sale['datetime'];
                    $data6['amount']              = $transfer;
                    $data6['balance']             = $balance;
                    $this->db->insert('bank_transfer', $data6);
                    $bank_transfer_id = $this->db->insert_id();
        
                    /* $mensaje = "Ha creado la transferencia bancaria con id: $bank_transfer_id con la información: ".json_encode($data6).".";
                    $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id); */
            
                    $data7['balance'] = $balance;
                    $this->db->where('bank_account_id', $banco['bank_account_id']);
                    $query = $this->db->update('bank_account', $data7);
                    
                    /* $mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: ".$banco['bank_account_id'].", al saldo: $balance.";
                    $this->binnacle($mensaje, "bank_account", $banco['bank_account_id']); */
                }
            }
        }
        
        

        if ($sale['type'] == 'S') $nom = $this->getNomenByCode("4.02.01.001");
        elseif ($sale['type'] == 'M')  $nom = $this->getNomenByCode("4.02.01.001");
        else $nom = $this->getNomenByName("Ventas");
        $nomen_id = $nom['nomenclature_id'];
        $data8['number']          = $num++;
        $data8['departure_id']    = $departure_id;
        $data8['nomenclature_id'] = $nomen_id;
        $data8['credit']          = $amount;
        $data8['position']        = 'C';
        $this->db->insert('departure_detail', $data8);
        $departure_detail_id = $this->db->insert_id();

        /* $mensaje = "Ha creado el detalle de partida con id: $departure_detail_id con la información: ".json_encode($data8).".";
        $this->binnacle($mensaje, "departure_detail", $departure_detail_id); */
        
        $move_bank = $nom['move_bank'];
        
        $nom = $this->getNomenByName("Débito Fiscal IVA");
        $nomen_id = $nom['nomenclature_id'];
        $data9['number']          = $num++;
        $data9['departure_id']    = $departure_id;
        $data9['nomenclature_id'] = $nomen_id;
        $data9['credit']          = $iva;
        $data9['position']        = 'C';
        $data9['from_id']         = $data6['nomenclature_id'];
        $this->db->insert('departure_detail', $data9);
        $departure_detail_id = $this->db->insert_id();
        
        /* $mensaje = "Ha creado el detalle de partida con id: $departure_detail_id con la información: ".json_encode($data9).".";
        $this->binnacle($mensaje, "departure_detail", $departure_detail_id); */

        if ($nom['heading_id'] == 1) {
            $data10 = array(); 
            $data10['departure_id']        = $departure_id;
            $data10['departure_detail_id'] = $departure_detail_id;
            $data10['nomenclature_id']     = $nomen_id;
            $data10['year']                = date('Y');
            $data10['no_policy']           = $this->getNoPolicyNom($nomen_id);
            $data10['type']                = 'Diario';
            $data10['concept']             = $details;
            $data10['approve_charge']      = "Gerente";
            $data10['maker_charge']        = "Auxiliar Contable";
            $this->db->insert('policy', $data10);
            $policy_id = $this->db->insert_id();
            
            /* $mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data10).".";
            $this->binnacle($mensaje, "policy", $policy_id); */
        }

        $data11['data'] = $this->getDataDeparture($departure_id);
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $data11);

        /* $mensaje = "Ha creado la data de la partida con id: $departure_id, con la información: ".json_encode($data11).".";
        $this->binnacle($mensaje, "departure", $departure_id); */

        return $departure_id;
    }
    
    function newDeparture()
    {
        $fechaHora = date("Y-m-d H:i:s");
        $amount = 0;
        $date = $this->input->post('date');
        $total = $this->input->post('total');
        $iva = $this->input->post('iva');
        $isr = $this->input->post('isr');
        $amount = $total - $iva - $isr;
        $purchase = $this->input->post('purchase');
        $adjust = $this->input->post('adjust');
        $details = trim($this->input->post('details'));
        $regime = 'G';

        $data1['date']          = $date;
        $data1['datetime']      = $fechaHora;
        $data1['amount']        = $amount;
        $data1['iva']           = $iva;
        $data1['isr']           = $isr;
        $data1['total']         = $total;
        $data1['regime']        = $regime;
        $data1['adjust']        = $adjust;
        $data1['department_id'] = $this->input->post('department_id');
        $data1['details']       = $details;
        $data1['admin_id']      = $this->session->userdata('login_user_id');
        if (in_array(1, $purchase)) {
            $data1['purchase']      = 1;
        }
        $this->db->insert('departure', $data1);
        $departure_id = $this->db->insert_id();

        $data2['code'] = $this->correlativeCode($departure_id);
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $data2);

        /*$mensaje = "Ha creado una partida con id: $departure_id, con la información: ".json_encode(array_merge($data1, $data2)).".";
        $this->binnacle($mensaje, "departure", $departure_id);*/

        $move = [];

        for ($i=0; $i < count($this->input->post('nomen_id')); $i++) {
            $data3                    = array();
            $nomen_id                 = $this->input->post('nomen_id')[$i];
            $nom                      = $this->getNomen($nomen_id);
            $from_id                  = $this->input->post('from_id')[$i];
            if ($from_id == '') $from_id = null;
            $data3['number']          = $i + 1;
            $data3['departure_id']    = $departure_id;
            $data3['nomenclature_id'] = $nomen_id;
            $data3['from_id']         = $from_id;
            if ($this->input->post('debe')[$i] != '') {
                $data3['debit']       = $this->input->post('debe')[$i];
                $data3['credit']      = null;
                $data3['position']    = 'D';
            }
            if ($this->input->post('haber')[$i] != '') {
                $data3['debit']       = null;
                $data3['credit']      = $this->input->post('haber')[$i];
                $data3['position']    = 'C';
            }
            $this->db->insert('departure_detail', $data3);
            $departure_detail_id = $this->db->insert_id();
            
            /*$mensaje = "Ha creado el detalle de partida con id: $departure_detail_id, con la información: ".json_encode($data3).", de la partida con id: $departure_id.";
            $this->binnacle($mensaje, "departure_detail", $departure_detail_id);*/

            if($nom['move_bank'] != '') $move += ["move"=>$nom['move_bank']];

            $account = $this->countAccountByNomen($nomen_id);
            if ($account > 0) {
                $bank = $this->getAccountByNomen($nomen_id);
                $balance = 0; $transfer = 0;
                if ($this->input->post('debe')[$i] != '') {
                    $data4['type'] = 1;
                    $transfer = $this->input->post('debe')[$i];
                    $balance = $bank['balance'] + $transfer;
                }
                if ($this->input->post('haber')[$i] != '') {
                    $data4['type'] = 0;
                    $transfer = $this->input->post('haber')[$i];
                    $balance = $bank['balance'] - $transfer;
                }
                $move += ["type"=>$data4['type']];
                $data4['code']                = $this->randCode("BT-");
                $data4['reference_table']     = "departure";
                $data4['reference_id']        = $departure_id;
                $data4['reference_detail_id'] = $departure_detail_id;
                $data4['bank_account_id']     = $bank['bank_account_id'];
                $data4['date']                = date("Y-m-d");
                $data4['datetime']            = $fechaHora;
                $data4['amount']              = $transfer;
                $data4['balance']             = $balance;
                $data4['description']         = $details;
                $data4['adjust']              = $adjust;
                $this->db->insert('bank_transfer', $data4);
                $bank_transfer_id = $this->db->insert_id();

                /*$mensaje = "Ha creado una transferencia bancaria con id: $bank_transfer_id, con la información: ".json_encode($data4).".";
                $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id);*/

                $data5['balance'] = $balance;
                $this->db->where('bank_account_id', $bank['bank_account_id']);
                $query = $this->db->update('bank_account', $data5);

                /*$mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: ".$bank['bank_account_id'].", al saldo: $balance.";
                $this->binnacle($mensaje, "bank_account", $bank['bank_account_id']);*/

                $move += ["bank_id"=>$bank['bank_account_id']];
                $move += ["transfer_id"=>$bank_transfer_id];
            }

            if ($nom['heading_id'] == 1) {
                $data6 = array(); 
                $data6['departure_id']        = $departure_id;
                $data6['departure_detail_id'] = $departure_detail_id;
                $data6['nomenclature_id']     = $nomen_id;
                $data6['year']                = date('Y');
                $data6['no_policy']           = $this->getNoPolicyNom($nomen_id);
                $data6['type']                = 'Diario';
                $data6['concept']             = $details;
                $data6['approve_charge']      = "Gerente";
                $data6['maker_charge']        = "Auxiliar Contable";
                $this->db->insert('policy', $data6);
                $policy_id = $this->db->insert_id();
                
                /*$mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data6).".";
                $this->binnacle($mensaje, "policy", $policy_id);*/
            }
        }

        if (in_array(1, $purchase)) {
            for ($i=0; $i < count($this->input->post('purchase_id')); $i++) {
                $provider_id = $this->input->post('provider_id')[$i];
                $data7 = array();
                $data7['name']     = $this->input->post('name')[$i];
                $data7['nit']      = $this->input->post('nit')[$i];
                if ($provider_id == 'N' || (!is_numeric($provider_id) && strlen($provider_id) > 1)) {
                    $data7['code'] = $this->randCode("PV");
                    $this->db->insert('provider', $data7);
                    $provider_id = $this->db->insert_id();
                    // log_message('error', "Nuevo proveedor");

                    /* $mensaje = "Ha creado un proveedor con id: $provider_id, con la información: ".json_encode($data7).".";
                    $this->binnacle($mensaje, "provider", $provider_id);*/
                } else {
                    $data7['code'] = $this->db->get_where('provider', array("provider_id"=>$provider_id))->row()->code;
                    $this->db->where('provider_id', $provider_id);
                    $query = $this->db->update('provider', $data7);
                    // log_message('error', "Editar proveedor");

                    /*$mensaje = "Ha actualizado al proveedor con id: $provider_id, con la información: ".json_encode($data7).".";
                    $this->binnacle($mensaje, "provider", $provider_id);*/
                }
                
                $isr = $this->input->post('isr_pur')[$i];
                $type = $this->input->post('type')[$i];
                if ($type == 'I') $isr = 0;
                $data8['departure_id']   = $departure_id;
                $data8['date']           = $this->input->post('date_pur')[$i];
                $data8['datetime']       = $fechaHora;
                $data8['document_type']  = $this->input->post('document_type')[$i];
                $data8['serie']          = $this->input->post('serie')[$i];
                $data8['number']         = $this->input->post('number')[$i];
                $data8['provider_id']    = $provider_id;
                $data8['institution_id'] = $this->input->post('institution_id')[$i];
                $data8['name']           = $this->input->post('name')[$i];
                $data8['nit']            = $this->input->post('nit')[$i];
                $data8['type']           = $type;
                $data8['regime']         = $this->input->post('regime')[$i];
                $data8['amount']         = $this->input->post('sin_iva')[$i];
                $data8['isr']            = $isr;
                $data8['exempt']         = $this->input->post('exempt')[$i];
                $data8['iva']            = $this->input->post('hidden_iva')[$i];
                $data8['total']          = $this->input->post('cant')[$i];
                $this->db->insert('purchase', $data8);
                $purchase_id = $this->db->insert_id();

                /*$mensaje = "Ha creado un registro en el libro de compras con id: $purchase_id, con la información: ".json_encode($data8).".";
                $this->binnacle($mensaje, "purchase", $purchase_id);*/
            }
        }

        if (isset($move['bank_id']) && isset($move['move'])) {
            $data9['move'] = $move['move'];
            if($data9['move'] != '') {
                $this->db->where('bank_transfer_id', $move['transfer_id']);
                $this->db->update('bank_transfer', $data9);

                /*$mensaje = "Ha establecido el tipo de movimiento de la transferencia bancaria con id: ".$move['transfer_id'].", al tipo: ".$data9['move'].".";
                $this->binnacle($mensaje, "bank_transfer", $move['transfer_id']);*/
            }
        }
        
        $data10['data'] = $this->getDataDeparture($departure_id);
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $data10);

        /*$mensaje = "Ha creado la data de la partida con id: $departure_id, con la información: ".json_encode($data10).".";
        $this->binnacle($mensaje, "departure", $departure_id);*/

        return $departure_id;
    }

    function editDeparture()
    {
        $amount = 0; $move = [];
        $fechaHora = date("Y-m-d H:i:s");
        $regime = $this->input->post('regimen');
        $total = $this->input->post('total');
        $iva = $this->input->post('iva');
        $isr = $this->input->post('isr');
        $amount = $total - $iva - $isr;
        $purchase = $this->input->post('purchase');
        $adjust = $this->input->post('adjust');
        $departure_id = $this->input->post('departure_id');
        $details = trim($this->input->post('details'));
        $date = $this->input->post('date');

        $data1['date']          = $date;
        $data1['amount']        = $amount;
        $data1['iva']           = $iva;
        $data1['isr']           = $isr;
        $data1['total']         = $total;
        $data1['regime']        = $regime;
        $data1['adjust']        = $adjust;
        $data1['department_id'] = $this->input->post('department_id');
        $data1['details']       = $details;
        $data1['admin_id']      = $this->session->userdata('login_user_id');
        if (in_array(1, $purchase)) {
            $data1['purchase']      = 1;
        }
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $data1);

        /*$mensaje = "Ha actualizado la partida con id: $departure_id, con la información: ".json_encode($data1).".";
        $this->binnacle($mensaje, "departure", $departure_id);*/

        for ($i=0; $i < count($this->input->post('nomen_id')); $i++) {
            $detail_id = $this->input->post('departure_detail_id')[$i];
            $debe = $this->input->post('debe')[$i];
            $haber = $this->input->post('haber')[$i];
            $nom_id = $this->input->post('nomen_id')[$i];
            $from_id = $this->input->post('from_id')[$i];
            if ($from_id == '') $from_id = null;
            $nom = $this->getNomen($nom_id);
            if($nom['move_bank'] != '') $move += ["move"=>$nom['move_bank']];
            $data2 = array();
            $data2['number'] = $i + 1;
            $data2['nomenclature_id'] = $this->input->post('nomen_id')[$i];
            $data2['from_id']         = $from_id;
            if ($debe != '') {
                $data2['debit']       = $debe;
                $data2['credit']      = null;
                $data2['position']    = 'D';
            }
            if ($haber != '') {
                $data2['debit']       = null;
                $data2['credit']      = $haber;
                $data2['position']    = 'C';
            }
            if ($detail_id == '') {
                $data2['departure_id'] = $departure_id;
                $this->db->insert('departure_detail', $data2);
                $detail_id = $this->db->insert_id();
                if ($nom['heading_id'] == 1) {
                    $data3 = array(); 
                    $data3['departure_id']        = $departure_id;
                    $data3['departure_detail_id'] = $detail_id;
                    $data3['nomenclature_id']     = $nom_id;
                    $data3['year']                = date('Y');
                    $data3['no_policy']           = $this->getNoPolicyNom($nom_id);
                    $data3['type']                = 'Diario';
                    $data3['concept']             = $details;
                    $data3['approve_charge']      = "Gerente";
                    $data3['maker_charge']        = "Auxiliar Contable";
                    $this->db->insert('policy', $data3);
                    $policy_id = $this->db->insert_id();
                    
                    /*$mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data3).".";
                    $this->binnacle($mensaje, "policy", $policy_id);*/
                }

                /* $mensaje = "Ha creado el detalle de partida con id: $detail_id, con la información: ".json_encode($data2).", de la partida con id: $departure_id.";
                $this->binnacle($mensaje, "departure_detail", $detail_id); */

                $account = $this->countAccountByNomen($nom_id);
                if ($account > 0) {
                    $bank = $this->getAccountByNomen($nom_id);
                    $balance = 0; $transfer = 0;
                    if ($debe != '') {
                        $data4['type'] = 1;
                        $transfer = $debe;
                        $balance = $bank['balance'] + $transfer;
                    }
                    if ($haber != '') {
                        $data4['type'] = 0;
                        $transfer = $haber;
                        $balance = $bank['balance'] - $transfer;
                    }
                    $move += ["type"=>$data4['type']];
                    $data4['code']                = $this->randCode("BT-");
                    $data4['reference_table']     = "departure";
                    $data4['reference_id']        = $departure_id;
                    $data4['reference_detail_id'] = $detail_id;
                    $data4['bank_account_id']     = $bank['bank_account_id'];
                    $data4['date']                = date("Y-m-d");
                    $data4['datetime']            = $fechaHora;
                    $data4['amount']              = $transfer;
                    $data4['balance']             = $balance;
                    $data4['description']         = $details;
                    $data4['adjust']              = $adjust;
                    $this->db->insert('bank_transfer', $data4);
                    $bank_transfer_id = $this->db->insert_id();

                    /*$mensaje = "Ha creado una transferencia bancaria con id: $bank_transfer_id, con la información: ".json_encode($data4).".";
                    $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id);*/

                    $data5['balance'] = $balance;
                    $this->db->where('bank_account_id', $bank['bank_account_id']);
                    $query = $this->db->update('bank_account', $data5);

                    /*$mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: ".$bank['bank_account_id'].", al saldo: $balance.";
                    $this->binnacle($mensaje, "bank_account", $bank['bank_account_id']);*/

                    $move += ["bank_id"=>$bank['bank_account_id']];
                    $move += ["transfer_id"=>$bank_transfer_id];
                }
            } else {
                $account = $this->countAccountByNomen($nom_id);
                $trans = $this->countTransferByReference("departure", $departure_id, $detail_id);
                if ($account > 0) { 
                    $bank = $this->getAccountByNomen($nom_id);
                    $balance = 0; $transfer = 0;
                    if ($trans > 0) {
                        $tra = $this->getBankTransferByDetail("departure", $departure_id, $detail_id);
                        if ($bank['bank_account_id'] == $tra['bank_account_id']) {
                            $balance = 0; $transfer = 0;
                            if ($debe != '') {
                                $data6['type'] = 1;
                                $transfer = $debe;
                                $balance = $bank['balance'] - $tra['amount'] + $transfer;
                            }
                            if ($haber != '') {
                                $data6['type'] = 0;
                                $transfer = $haber;
                                $balance = $bank['balance'] + $tra['amount'] - $transfer;
                            }
                            $move += ["type"=>$data6['type']];
                            $bank = $this->getAccountByNomen($nom_id);
                            $data6['reference_detail_id'] = $detail_id;
                            $data6['date']                = $date;
                            $data6['bank_account_id']     = $bank['bank_account_id'];
                            $data6['amount']              = $transfer;
                            $data6['balance']             = $balance;
                            $data6['description']         = $details;
                            $data6['adjust']              = $adjust;
                            $this->db->where('bank_transfer_id', $tra['bank_transfer_id']);
                            $query = $this->db->update('bank_transfer', $data6);
                            $move += ["bank_id"=>$bank['bank_account_id']];
                            $move += ["transfer_id"=>$tra['bank_transfer_id']];
        
                            /*$mensaje = "Ha actualizado la transferencia bancaria con id: ".$tra['bank_transfer_id'].", con la información: ".json_encode($data6).".";
                            $this->binnacle($mensaje, "bank_transfer", $tra['bank_transfer_id']);*/
                        } else {
                            if ($debe != '') {
                                $data7['type'] = 1;
                                $transfer = $debe;
                                $balance = $bank['balance'] + $transfer;
                            }
                            if ($haber != '') {
                                $data7['type'] = 0;
                                $transfer = $haber;
                                $balance = $bank['balance'] - $transfer;
                            }
                            $move += ["type"=>$data7['type']];
                            $data7['code']                = $this->randCode("BT-");
                            $data7['reference_table']     = "departure";
                            $data7['reference_id']        = $departure_id;
                            $data7['reference_detail_id'] = $detail_id;
                            $data7['bank_account_id']     = $bank['bank_account_id'];
                            $data7['date']                = date("Y-m-d");
                            $data7['datetime']            = $fechaHora;
                            $data7['amount']              = $transfer;
                            $data7['balance']             = $balance;
                            $data7['description']         = $details;
                            $data7['adjust']              = $adjust;
                            $this->db->insert('bank_transfer', $data7);
                            $bank_transfer_id = $this->db->insert_id();
                            $move += ["bank_id"=>$bank['bank_account_id']];
                            $move += ["transfer_id"=>$bank_transfer_id];
        
                            /*$mensaje = "Ha creado una transferencia bancaria con id: $bank_transfer_id, con la información: ".json_encode($data7).".";
                            $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id);*/
        
                            $data8['balance'] = $balance;
                            $this->db->where('bank_account_id', $bank['bank_account_id']);
                            $query = $this->db->update('bank_account', $data8);
        
                            /*$mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: ".$bank['bank_account_id'].", al saldo: $balance.";
                            $this->binnacle($mensaje, "bank_account", $bank['bank_account_id']);*/
                            
                            $first = $this->getAccountBank($tra['bank_account_id']);
                            if($tra['type']) $data9['balance'] = $first['balance'] - $tra['amount'];
                            else $data9['balance'] = $first['balance'] + $tra['amount'];
                            $this->db->where('bank_account_id', $tra['bank_account_id']);
                            $query = $this->db->update('bank_account', $data9);

                            /*$mensaje = "Ha modificado el balance de la cuenta bancaria con id: ".$tra['bank_account_id'].", con nuevo balance de: ".$data9['balance'].".";
                            $this->binnacle($mensaje, "bank_account", $tra['bank_account_id']);*/
                        }
                    } else {
                        if ($debe != '') {
                            $data10['type'] = 1;
                            $transfer = $debe;
                            $balance = $bank['balance'] + $transfer;
                        }
                        if ($haber != '') {
                            $data10['type'] = 0;
                            $transfer = $haber;
                            $balance = $bank['balance'] - $transfer;
                        }
                        $move += ["type"=>$data10['type']];
                        $data10['code']                = $this->randCode("BT-");
                        $data10['reference_table']     = "departure";
                        $data10['reference_id']        = $departure_id;
                        $data10['reference_detail_id'] = $detail_id;
                        $data10['bank_account_id']     = $bank['bank_account_id'];
                        $data10['date']                = date("Y-m-d");
                        $data10['datetime']            = $fechaHora;
                        $data10['amount']              = $transfer;
                        $data10['balance']             = $balance;
                        $data10['description']         = $details;
                        $data10['adjust']              = $adjust;
                        $this->db->insert('bank_transfer', $data10);
                        $bank_transfer_id = $this->db->insert_id();
                        $move += ["bank_id"=>$bank['bank_account_id']];
                        $move += ["transfer_id"=>$bank_transfer_id];
    
                        /*$mensaje = "Ha creado una transferencia bancaria con id: $bank_transfer_id, con la información: ".json_encode($data10).".";
                        $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id);*/
    
                        $data11['balance'] = $balance;
                        $this->db->where('bank_account_id', $bank['bank_account_id']);
                        $query = $this->db->update('bank_account', $data11);
    
                        /*$mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: ".$bank['bank_account_id'].", al saldo: $balance.";
                        $this->binnacle($mensaje, "bank_account", $bank['bank_account_id']);*/
                        
                        $first = $this->getAccountBank($tra['bank_account_id']);
                        if($tra['type']) $data12['balance'] = $first['balance'] - $tra['amount'];
                        else $data12['balance'] = $first['balance'] + $tra['amount'];
                        $this->db->where('bank_account_id', $tra['bank_account_id']);
                        $query = $this->db->update('bank_account', $data12);

                        /*$mensaje = "Ha modificado el balance de la cuenta bancaria con id: ".$tra['bank_account_id'].", con nuevo balance de: ".$data12['balance'].".";
                        $this->binnacle($mensaje, "bank_account", $tra['bank_account_id']);*/
                    }
                } else {
                    $trans = $this->countTransferByReference("departure", $departure_id, $detail_id);
                    if ($trans > 0) {
                        $tra = $this->getBankTransferByDetail("departure", $departure_id, $detail_id);
                        $data13['status'] = 0;
                        $this->db->where('bank_transfer_id', $tra['bank_transfer_id']);
                        $query = $this->db->update('bank_transfer', $data13);
                        
                        /*$mensaje = "Ha anulado el movimiento con id: ".$tra['bank_transfer_id']." de la cuenta bancaria con id: ".$tra['bank_account_id']." por cambio de nomenclatura en la partida.";
                        $this->binnacle($mensaje, "bank_transfer", $tra['bank_transfer_id']);*/

                        $first = $this->getAccountBank($tra['bank_account_id']);
                        if($tra['type']) $data14['balance'] = $first['balance'] - $tra['amount'];
                        else $data14['balance'] = $first['balance'] + $tra['amount'];
                        $this->db->where('bank_account_id', $tra['bank_account_id']);
                        $query = $this->db->update('bank_account', $data14);

                        /*$mensaje = "Ha modificado el balance de la cuenta bancaria con id: ".$tra['bank_account_id'].", con nuevo balance de: ".$data14['balance'].".";
                        $this->binnacle($mensaje, "bank_account", $tra['bank_account_id']);*/
                    }
                }
                $this->db->where('departure_detail_id', $detail_id);
                $query = $this->db->update('departure_detail', $data2);

                /*$mensaje = "Ha actualizado el detalle de partida con id: $detail_id, con la información: ".json_encode($data2).", de la partida con id: $departure_id.";
                $this->binnacle($mensaje, "departure_detail", $detail_id);*/
                
                if ($nom['heading_id'] == 1) {
                    $pol = $this->getPolicyByDetail($detail_id);
                    if (count($pol) > 0) {
                        $data15 = array();
                        $data15['nomenclature_id'] = $nom_id;
                        $data15['concept']         = $details;
                        if ($nom_id != $pol['nomenclature_id']) $data15['no_policy'] = $this->getNoPolicyNom($nom_id);
                        $this->db->where('policy_id', $pol['policy_id']);
                        $query = $this->db->update('policy', $data15);
                        
                        /*$mensaje = "Ha actualizado la póliza con id: ".$pol['policy_id'].", con la información: ".json_encode($data15).".";
                        $this->binnacle($mensaje, "policy", $pol['policy_id']);*/
                    } else {
                        $data16 = array(); 
                        $data16['departure_id']        = $departure_id;
                        $data16['departure_detail_id'] = $detail_id;
                        $data16['nomenclature_id']     = $nom_id;
                        $data16['year']                = date('Y');
                        $data16['no_policy']           = $this->getNoPolicyNom($nom_id);
                        $data16['type']                = 'Diario';
                        $data16['concept']             = $details;
                        $data16['approve_charge']      = "Gerente";
                        $data16['maker_charge']        = "Auxiliar Contable";
                        $this->db->insert('policy', $data16);
                        $policy_id = $this->db->insert_id();
                        
                        /*$mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data16).".";
                        $this->binnacle($mensaje, "policy", $policy_id);*/
                    }
                }
            }
        }

        if (in_array(1, $purchase)) {
            for ($i=0; $i < count($this->input->post('purchase_id')); $i++) {
                $purchase_id = $this->input->post('purchase_id')[$i];
                $data17 = array();
                $provider_id = $this->input->post('provider_id')[$i];
                $data17['name'] = $this->input->post('name')[$i];
                $data17['nit']  = $this->input->post('nit')[$i];
                if ($provider_id == 'N' || (!is_numeric($provider_id) && strlen($provider_id) > 1)) {
                    $data17['code'] = $this->randCode("PV");
                    $this->db->insert('provider', $data17);
                    $provider_id = $this->db->insert_id();
                    /* $mensaje = "Ha creado un proveedor con id: $provider_id, con la información: ".json_encode($data17).".";
                    $this->binnacle($mensaje, "provider", $provider_id); */
                } else {
                    $data17['code'] = $this->db->get_where('provider', array("provider_id"=>$provider_id))->row()->code;
                    $this->db->where('provider_id', $provider_id);
                    $query = $this->db->update('provider', $data17);
                    /* $mensaje = "Ha actualizado al proveedor con id: $provider_id, con la información: ".json_encode($data17).".";
                    $this->binnacle($mensaje, "provider", $provider_id); */
                }
                
                $data18 = array();
                $isr = $this->input->post('isr_pur')[$i];
                $type = $this->input->post('type')[$i];
                if ($type == 'I') $isr = 0;
                $data18['date']           = $this->input->post('date_pur')[$i];
                $data18['number']         = $this->input->post('number')[$i];
                $data18['provider_id']    = $provider_id;
                $data18['institution_id'] = $this->input->post('institution_id')[$i];
                $data18['document_type']  = $this->input->post('document_type')[$i];
                $data18['serie']          = $this->input->post('serie')[$i];
                $data18['number']         = $this->input->post('number')[$i];
                $data18['name']           = $this->input->post('name')[$i];
                $data18['nit']            = $this->input->post('nit')[$i];
                $data18['type']           = $type;
                $data18['regime']         = $this->input->post('regime')[$i];
                $data18['amount']         = $this->input->post('sin_iva')[$i];
                $data18['isr']            = $isr;
                $data18['exempt']         = $this->input->post('exempt')[$i];
                $data18['iva']            = $this->input->post('hidden_iva')[$i];
                $data18['total']          = $this->input->post('cant')[$i];
                if ($purchase_id != '') {
                    $this->db->where('purchase_id', $purchase_id);
                    $query = $this->db->update('purchase', $data18);
                    
                    /*$mensaje = "Ha actualizado el registro en el libro de compras con id: $purchase_id, con la información: ".json_encode($data18).".";
                    $this->binnacle($mensaje, "purchase", $purchase_id);*/
                } else {
                    $data18['departure_id']  = $departure_id;
                    $data18['datetime']      = $fechaHora;
                    $this->db->insert('purchase', $data18);
                    $purchase_id = $this->db->insert_id();
                    
                    /*$mensaje = "Ha creado un registro en el libro de compras con id: $purchase_id, con la información: ".json_encode($data18).".";
                    $this->binnacle($mensaje, "purchase", $purchase_id);*/
                }
            }
        }
        
        if (isset($move['bank_id']) && isset($move['move'])) {
            $data19['move'] = $move['move'];
            if($data19['move'] != '') {
                $this->db->where('bank_transfer_id', $move['transfer_id']);
                $this->db->update('bank_transfer', $data19);

                /*$mensaje = "Ha establecido el tipo de movimiento de la transferencia bancaria con id: ".$move['transfer_id'].", al tipo: ".$data19['move'].".";
                $this->binnacle($mensaje, "bank_transfer", $move['transfer_id']);*/
            }
        }

        $data20['data'] = $this->getDataDeparture($departure_id);
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $data20);

        /*$mensaje = "Ha creado la data de la partida con id: $departure_id, con la información: ".json_encode($data20).".";
        $this->binnacle($mensaje, "departure", $departure_id);*/

    }

    function deactivateDeparture($departure_id = '')
    {
        $data['status'] = 0;
        if ($departure_id == '') $departure_id = base64_decode($this->input->post('id'));
        $results = array();

        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('purchase', $data);
        //log_message("error", "Compras: $query");
        array_push($results, $query);
        
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('policy', $data);
        array_push($results, $query);
        
        $tra = $this->getTransferByReference("departure", $departure_id);
        if (count($tra) > 0) {
            $bank = $this->getAccountBank($tra['bank_account_id']);
            /* log_message("error", "Balance: ".$bank['balance']);
            log_message("error", "Monto: ".$tra['amount']); */
            if($tra['type']) $dataA['balance'] = $bank['balance'] - $tra['amount'];
            else $dataA['balance'] = $bank['balance'] + $tra['amount'];
            // log_message("error", "Balance: ".$data['balance']);
            $this->db->where('bank_account_id', $tra['bank_account_id']);
            $query = $this->db->update('bank_account', $dataA);
            // log_message("error", "Cuenta bancaria: $query");
            array_push($results, $query);
    
            /* $mensaje = "Ha modificado el balance de la cuenta bancaria con id: ".$tra['bank_account_id'].", con nuevo balance de: ".$dataA['balance'].".";
            $this->binnacle($mensaje, "bank_account", $tra['bank_account_id']); */
        }

        // $pay = $this->getPayByDep($departure_id);
        // $sale = $this->getSale($pay['sale_id']);

        if (count($sale) > 0){
            $data1['residue'] = $sale['residue'] + $pay['amount'];
            $this->db->where('sale_id', $pay['sale_id']);
            $query = $this->db->update('sale', $data1);
            // log_message("error", "Venta: $query");
            array_push($results, $query);

            /* $mensaje = "Ha actualizado el monto pendiente de la venta con id: $sale_id, a un saldo de: ".$data1['residue'].", por eliminación de pago.";
            $this->binnacle($mensaje, "sale", $sale_id); */
        }
        
        if (count($pay) > 0) {
            $this->db->where('pay_id', $pay['pay_id']);
            $query = $this->db->update('pay', $data);
            // log_message("error", "Pago: $query");
            array_push($results, $query);
        }
        
        $this->db->where('bank_transfer_id', $tra['bank_transfer_id']);
        $query = $this->db->update('bank_transfer', $data);
        // log_message("error", "Transferencia: $query");
        array_push($results, $query);
        
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure_detail', $data);
        // log_message("error", "Detalle de partida: $query");
        array_push($results, $query);

        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $data);
        // log_message("error", "Partida: $query");
        array_push($results, $query);
        
        /* $mensaje = "Ha desactivado la partida con id: $departure_id, tambien los detalles de partida, documentos de libro de compras, datos de póliza, pago, y transferencias bancarias referentes a la misma partida.";
        $this->binnacle($mensaje, "departure", $departure_id); */
        
        echo json_encode($results);
    }

    function activateDeparture()
    {
        $departure_id = base64_decode($this->input->post('id'));
        $data['status'] = 1;
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $data);
        
        /*$mensaje = "Ha activado la partida con id: $departure_id.";
        $this->binnacle($mensaje, "departure", $departure_id);*/
        
        echo $query;
    }

    function deleteDeparture()
    {
        $departure_id = base64_decode($this->input->post('id'));
        $results = array();

        $this->db->where('departure_id', $departure_id);
        $query = $this->db->delete('purchase');
        //log_message("error", "Compras: $query");
        array_push($results, $query);
        
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->delete('policy');
        array_push($results, $query);
        
        $tra = $this->getTransferByReference("departure", $departure_id);
        if (count($tra) > 0) {
            $bank = $this->getAccountBank($tra['bank_account_id']);
            /* log_message("error", "Balance: ".$bank['balance']);
            log_message("error", "Monto: ".$tra['amount']); */
            if($tra['type']) $data['balance'] = $bank['balance'] - $tra['amount'];
            else $data['balance'] = $bank['balance'] + $tra['amount'];
            // log_message("error", "Balance: ".$data['balance']);
            $this->db->where('bank_account_id', $tra['bank_account_id']);
            $query = $this->db->update('bank_account', $data);
            // log_message("error", "Cuenta bancaria: $query");
            array_push($results, $query);
    
            /*$mensaje = "Ha modificado el balance de la cuenta bancaria con id: ".$tra['bank_account_id'].", con nuevo balance de: ".$data['balance'].".";
            $this->binnacle($mensaje, "bank_account", $tra['bank_account_id']);*/
        }

        $pay = $this->getPayByDep($departure_id);
        // $sale = $this->getSale($pay['sale_id']);

        if (count($sale) > 0){
            $data1['residue'] = $sale['residue'] + $pay['amount'];
            $this->db->where('sale_id', $pay['sale_id']);
            $query = $this->db->update('sale', $data1);
            // log_message("error", "Venta: $query");
            array_push($results, $query);

            /*$mensaje = "Ha actualizado el monto pendiente de la venta con id: $sale_id, a un saldo de: ".$data1['residue'].", por eliminación de pago.";
            $this->binnacle($mensaje, "sale", $sale_id);*/
        }

        $this->db->where('pay_id', $pay['pay_id']);
        $query = $this->db->delete('pay');
        // log_message("error", "Pago: $query");
        array_push($results, $query);
        
        $this->db->where('bank_transfer_id', $tra['bank_transfer_id']);
        $query = $this->db->delete('bank_transfer');
        // log_message("error", "Transferencia: $query");
        array_push($results, $query);
        
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->delete('departure_detail');
        // log_message("error", "Detalle de partida: $query");
        array_push($results, $query);

        $this->db->where('departure_id', $departure_id);
        $query = $this->db->delete('departure');
        // log_message("error", "Partida: $query");
        array_push($results, $query);
        
        /*$mensaje = "Ha eliminado la partida con id: $departure_id, tambien los detalles de partida, documentos de libro de compras, datos de póliza, pago, y transferencias bancarias referentes a la misma partida.";
        $this->binnacle($mensaje, "departure", $departure_id);*/
        
        echo json_encode($results);
    }

    function deactivateDepareDetail()
    {
        $id = $this->input->post('id');
        $data['status'] = 0;
        $this->db->where('departure_detail_id', $id);
        $query = $this->db->update('departure_detail', $data);

        /*$mensaje = "Ha desactivado el detalle de partida con id: $id.";
        $this->binnacle($mensaje, "purchase", $purchase_id);*/
        
        echo $query;
    }

    function deactivatePurchase()
    {
        $id = $this->input->post('id');
        $data['status'] = 0;
        $this->db->where('purchase_id', $id);
        $query = $this->db->update('purchase', $data);

        /*$mensaje = "Ha desactivado el documento de libro de compras con id: $id.";
        $this->binnacle($mensaje, "purchase", $id);*/
        
        echo $query;
    }

    function getJournal($initial, $final, $nom_id = '')
    {
        $query = '';
        if ($nom_id == '' || $nom_id == 'T') $query = "SELECT * FROM departure WHERE type != 2 AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND status = 1 ORDER BY date ASC, departure_id ASC";
        else $query = "SELECT p.* FROM departure AS p INNER JOIN departure_detail AS d ON p.departure_id = d.departure_id WHERE p.type != 2 AND d.nomenclature_id = '$nom_id' AND DATE(p.date) >= DATE('$initial') AND DATE(p.date) <= DATE('$final') AND p.status = 1 AND d.status = 1 GROUP BY d.departure_id ORDER BY p.date ASC, d.departure_id ASC";
        $data = $this->db->query($query);
        return $data;
    }
    
    function insertBankConciliation()
    {
        $fechaHora = date("Y-m-d H:i:s");
        $data['bank_account_id']       = $this->input->post('bank_account_id');
        $data['initial']               = $this->input->post('initial');
        $data['final']                 = $this->input->post('final');
        $data['datetime']              = $fechaHora;
        $data['admin_id']              = $this->session->userdata('login_user_id');
        $data['balance_ledge']         = $this->input->post('balance_ledge');
        $data['subtotal_note_credit']  = $this->input->post('subtotal_note_credit');
        $data['subtotal_note_debit']   = $this->input->post('subtotal_note_debit');
        $data['balance_1']             = $this->input->post('balance_1');
        $data['balance_account']       = $this->input->post('balance_account');
        $data['subtotal_bank_check']   = $this->input->post('subtotal_bank_check');
        $data['subtotal_bank_deposit'] = $this->input->post('subtotal_bank_deposit');
        $data['balance_2']             = $this->input->post('balance_2');
        $data['elaborate_name']        = $this->input->post('elaborate_name');
        $data['elaborate_charge']      = $this->input->post('elaborate_charge');
        $data['approve_name']          = $this->input->post('approve_name');
        $data['approve_charge']        = $this->input->post('approve_charge');
        $data['check_name']            = $this->input->post('check_name');
        $data['check_charge']          = $this->input->post('check_charge');
        $this->db->insert('bank_conciliation', $data);
        $bank_conciliation_id = $this->db->insert_id();

        /*$mensaje = "Ha creado una conciliación bancaria con id: $bank_conciliation_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "bank_conciliation", $bank_conciliation_id);*/

        $dataD = array();
        for ($i=0; $i < count($this->input->post('cont_credit')); $i++) { 
            $dataD['bank_conciliation_id'] = $bank_conciliation_id;
            $dataD['type']                 = "NC";
            $dataD['description']          = $this->input->post('note_credit')[$i];
            $dataD['amount']               = $this->input->post('amount_credit')[$i];
            $this->db->insert('bank_conciliation_detail', $dataD);
            $detail_id = $this->db->insert_id();

            /*$mensaje = "Ha creado detalle de nota de crédito de conciliación bancaria con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "bank_conciliation_detail", $detail_id);*/
        }

        $dataD = array();
        for ($i=0; $i < count($this->input->post('cont_debit')); $i++) { 
            $dataD['bank_conciliation_id'] = $bank_conciliation_id;
            $dataD['type']                 = "ND";
            $dataD['description']          = $this->input->post('note_debit')[$i];
            $dataD['amount']               = $this->input->post('amount_debit')[$i];
            $this->db->insert('bank_conciliation_detail', $dataD);
            $detail_id = $this->db->insert_id();
            
            /*$mensaje = "Ha creado detalle de nota de débito de conciliación bancaria con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "bank_conciliation_detail", $detail_id);*/
        }
        
        $dataD = array();
        for ($i=0; $i < count($this->input->post('cont_check')); $i++) { 
            $dataD['bank_conciliation_id'] = $bank_conciliation_id;
            $dataD['type']                 = "BC";
            $dataD['description']          = $this->input->post('note_check')[$i];
            $dataD['amount']               = $this->input->post('amount_check')[$i];
            $this->db->insert('bank_conciliation_detail', $dataD);
            $detail_id = $this->db->insert_id();
            
            /*$mensaje = "Ha creado detalle de cheques girados de conciliación bancaria con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "bank_conciliation_detail", $detail_id);*/
        }
        
        $dataD = array();
        for ($i=0; $i < count($this->input->post('cont_deposit')); $i++) { 
            $dataD['bank_conciliation_id'] = $bank_conciliation_id;
            $dataD['type']                 = "BD";
            $dataD['description']          = $this->input->post('note_deposit')[$i];
            $dataD['amount']               = $this->input->post('amount_deposit')[$i];
            $this->db->insert('bank_conciliation_detail', $dataD);
            $detail_id = $this->db->insert_id();
            
            /*$mensaje = "Ha creado detalle de depositos en tránsito de conciliación bancaria con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "bank_conciliation_detail", $detail_id);*/
        }

        return $bank_conciliation_id;
    }

    function deleteBankConciliation()
    {
        $id = base64_decode($this->input->post('id'));
        $this->db->where('bank_conciliation_id', $id);
        $query = $this->db->delete('bank_conciliation');

        $this->db->where('bank_conciliation_id', $id);
        $this->db->delete('bank_conciliation_detail');
        
        /*$mensaje = "Ha eliminado la conciliación bancaria con id: $id, con sus respectivos detalles.";
        $this->binnacle($mensaje, "bank_conciliation", $id);*/

        echo $query;
    }
    
    function insertCashFlow()
    {
        $fechaHora = date("Y-m-d H:i:s");
        $data['initial']            = $this->input->post('initial');
        $data['final']              = $this->input->post('final');
        $data['datetime']           = $fechaHora;
        $data['admin_id']           = $this->session->userdata('login_user_id');
        $data['utility']            = $this->input->post('utility');
        $data['no_moves']           = $this->input->post('no_moves');
        $data['subtotal_operation'] = $this->input->post('subtotal_operation');
        $data['subtotal_invest']    = $this->input->post('subtotal_invest');
        $data['subtotal_finance']   = $this->input->post('subtotal_finance');
        $data['total_activities']   = $this->input->post('total_activities');
        $data['check_equals']       = $this->input->post('check_equals');
        $data['increase']           = $this->input->post('increase');
        $data['equal_initial']      = $this->input->post('equal_initial');
        $data['equal_final']        = $this->input->post('equal_final');
        $data['description']        = $this->input->post('description');
        $data['legal_name']         = $this->input->post('legal_name');
        $data['legal_charge']       = $this->input->post('legal_charge');
        $data['account_name']       = $this->input->post('account_name');
        $data['account_charge']     = $this->input->post('account_charge');
        $this->db->insert('cash_flow', $data);
        $cash_flow_id = $this->db->insert_id();

        /*$mensaje = "Ha creado un flujo de efectivo con id: $cash_flow_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "cash_flow", $cash_flow_id);*/

        $dataD = array();
        for ($i=0; $i < count($this->input->post('cont_operation')); $i++) { 
            $dataD['cash_flow_id'] = $cash_flow_id;
            $dataD['type']         = "AO";
            $dataD['description']  = $this->input->post('note_operation')[$i];
            $dataD['amount']       = $this->input->post('amount_operation')[$i];
            $this->db->insert('cash_flow_detail', $dataD);
            $detail_id = $this->db->insert_id();

            /*$mensaje = "Ha creado detalle de actividad de operacion de flujo de efectivo con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "cash_flow_detail", $detail_id);*/
        }

        $dataD = array();
        for ($i=0; $i < count($this->input->post('cont_invest')); $i++) { 
            $dataD['cash_flow_id'] = $cash_flow_id;
            $dataD['type']         = "AI";
            $dataD['description']  = $this->input->post('note_invest')[$i];
            $dataD['amount']       = $this->input->post('amount_invest')[$i];
            $this->db->insert('cash_flow_detail', $dataD);
            $detail_id = $this->db->insert_id();
            
            /*$mensaje = "Ha creado detalle de actividad de inversión de flujo de efectivo con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "cash_flow_detail", $detail_id);*/
        }
        
        $dataD = array();
        for ($i=0; $i < count($this->input->post('cont_finance')); $i++) { 
            $dataD['cash_flow_id'] = $cash_flow_id;
            $dataD['type']         = "AF";
            $dataD['description']  = $this->input->post('note_finance')[$i];
            $dataD['amount']       = $this->input->post('amount_finance')[$i];
            $this->db->insert('cash_flow_detail', $dataD);
            $detail_id = $this->db->insert_id();
            
            /*$mensaje = "Ha creado detalle de actividades de financiamiento de flujo de efectivo con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "cash_flow_detail", $detail_id);*/
        }
        
        return $cash_flow_id;
    }

    function deleteCashFlow()
    {
        $id = base64_decode($this->input->post('id'));
        $this->db->where('cash_flow_id', $id);
        $query = $this->db->delete('cash_flow');

        $this->db->where('cash_flow_id', $id);
        $this->db->delete('cash_flow_detail');
        
        /*$mensaje = "Ha eliminado el flujo de efectivo con id: $id, con todos sus respectivos detalles.";
        $this->binnacle($mensaje, "cash_flow", $id);*/

        echo $query;
    }
    
    function getClientsBook()
    {
        $query = '';
        $visitor_id = $this->input->post('visitor_id');
        $client_id = $this->input->post('client_id');
        $com = $this->input->post('commission');
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        if ($client_id == 'T') $client_id = '';
        if ($com == '') {
            if ($visitor_id != '' && $client_id != '' && $initial != '' && $final != '') $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND DATE(s.date) >= DATE('$initial') AND DATE(s.date) <= DATE('$final') AND s.visitor_id = '$visitor_id' AND s.client_id = '$client_id' AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id != '' && $client_id == '' && $initial != '' && $final != '') $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND DATE(s.date) >= DATE('$initial') AND DATE(s.date) <= DATE('$final') AND s.visitor_id = '$visitor_id' AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id == '' && $client_id != '' && $initial != '' && $final != '') $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND DATE(s.date) >= DATE('$initial') AND DATE(s.date) <= DATE('$final') AND s.client_id = '$client_id' AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id == '' && $client_id == '' && $initial != '' && $final != '') $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND DATE(s.date) >= DATE('$initial') AND DATE(s.date) <= DATE('$final') AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id != '' && $client_id != '' && ($initial == '' || $final == '')) $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND s.visitor_id = '$visitor_id' AND s.client_id = '$client_id' AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id != '' && $client_id == '' && ($initial == '' || $final == '')) $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND s.visitor_id = '$visitor_id' AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id == '' && $client_id != '' && ($initial == '' || $final == '')) $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND s.client_id = '$client_id' AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            else $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
        } else {
            if ($visitor_id != '' && $client_id != '' && $initial != '' && $final != '') $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND DATE(s.date) >= DATE('$initial') AND DATE(s.date) <= DATE('$final') AND s.visitor_id = '$visitor_id' AND s.client_id = '$client_id' AND DATE(NOW()) $com DATE_ADD(s.date, INTERVAL 60 DAY) AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id != '' && $client_id == '' && $initial != '' && $final != '') $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND DATE(s.date) >= DATE('$initial') AND DATE(s.date) <= DATE('$final') AND s.visitor_id = '$visitor_id' AND DATE(NOW()) $com DATE_ADD(s.date, INTERVAL 60 DAY) AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id == '' && $client_id != '' && $initial != '' && $final != '') $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND DATE(s.date) >= DATE('$initial') AND DATE(s.date) <= DATE('$final') AND s.client_id = '$client_id' AND DATE(NOW()) $com DATE_ADD(s.date, INTERVAL 60 DAY) AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id == '' && $client_id == '' && $initial != '' && $final != '') $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND DATE(s.date) >= DATE('$initial') AND DATE(s.date) <= DATE('$final') AND DATE(NOW()) $com DATE_ADD(s.date, INTERVAL 60 DAY) AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id != '' && $client_id != '' && ($initial == '' || $final == '')) $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND s.visitor_id = '$visitor_id' AND s.client_id = '$client_id' AND DATE(NOW()) $com DATE_ADD(s.date, INTERVAL 60 DAY) AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id != '' && $client_id == '' && ($initial == '' || $final == '')) $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND s.visitor_id = '$visitor_id' AND DATE(NOW()) $com DATE_ADD(s.date, INTERVAL 60 DAY) AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            elseif ($visitor_id == '' && $client_id != '' && ($initial == '' || $final == '')) $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND s.client_id = '$client_id' AND DATE(NOW()) $com DATE_ADD(s.date, INTERVAL 60 DAY) AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
            else $query = "SELECT c.client_id, c.code, c.first_name, c.last_name, c.nit, c.address, c.phone, s.sale_id, s.visitor_id, s.invoice, s.total_due, s.type_invoice, SUM(s.total_due - s.residue) AS charges, s.residue, s.date, s.due_date, s.details FROM sale AS s INNER JOIN client AS c ON s.client_id = c.client_id WHERE s.type_invoice = 'C' AND DATE(NOW()) $com DATE_ADD(s.date, INTERVAL 60 DAY) AND s.status = 1 GROUP BY s.sale_id ORDER BY s.date DESC, s.sale_id DESC";
        }
        $data = $this->db->query($query);
        return $data;
    }
    
    function getLedger($initial, $final, $nom_id = '')
    {
        $query = '';
        if ($nom_id == '' || $nom_id == 'T') $query = "SELECT n.* FROM departure AS p INNER JOIN departure_detail AS d ON p.departure_id = d.departure_id INNER JOIN nomenclature AS n ON n.nomenclature_id = d.nomenclature_id WHERE p.type != 2 AND DATE(p.date) >= DATE('$initial') AND DATE(p.date) <= DATE('$final') AND p.status = 1 AND d.status = 1 GROUP BY d.nomenclature_id ORDER BY n.code ASC, n.nomenclature_id ASC";
        else $query = "SELECT n.* FROM departure AS p INNER JOIN departure_detail AS d ON p.departure_id = d.departure_id INNER JOIN nomenclature AS n ON n.nomenclature_id = d.nomenclature_id WHERE p.type != 2 AND n.nomenclature_id = '$nom_id' AND DATE(p.date) >= DATE('$initial') AND DATE(p.date) <= DATE('$final') AND p.status = 1 AND d.status = 1 GROUP BY d.nomenclature_id ORDER BY n.code ASC, n.nomenclature_id ASC";
        $data = $this->db->query($query);
        return $data;
    }

    function getDetailLedger($nomen_id, $initial, $final)
    {
        return $this->db->query("SELECT d.*, p.date, p.details FROM departure AS p INNER JOIN departure_detail AS d ON p.departure_id = d.departure_id WHERE d.nomenclature_id = '$nomen_id' AND p.type != 2 AND d.status = 1 AND DATE(p.date) >= DATE('$initial') AND DATE(p.date) <= ('$final') ORDER BY p.date ASC");
    }
    
    function getSumBalance($initial, $final)
    {
        $datos = $this->db->query("SELECT SUM(d.debit) AS debe, SUM(d.credit) AS haber, n.nomenclature_id, n.code, n.name FROM departure_detail AS d INNER JOIN nomenclature AS n ON d.nomenclature_id = n.nomenclature_id INNER JOIN departure AS p ON p.departure_id = d.departure_id WHERE p.type != 2 AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND p.status = 1 AND d.status = 1 AND n.status = 1 GROUP BY d.nomenclature_id");
        return $datos;
    }

    function getTotalYearNom($nom_id, $initial, $final, $group, $print = '')
    {
        $total = 0;
        $datos = $this->db->query("SELECT SUM(d.debit) AS totalDebe, SUM(d.credit) AS totalHaber FROM departure_detail AS d INNER JOIN departure AS p ON d.departure_id = p.departure_id WHERE p.type = 1 AND d.status = 1 AND p.status = 1 AND d.status = 1 AND d.nomenclature_id = '$nom_id' AND DATE(p.date) >= DATE('$initial') AND DATE(p.date) <= DATE('$final')")->row_array();
        if ($group == 1 || $group == 5 || $group == 6 || $group == 7 || $group == 8 || $group == 9) $total = $datos['totalDebe'] - $datos['totalHaber'];
        elseif ($group == 2 || $group == 3 || $group == 4) $total = $datos['totalHaber'] - $datos['totalDebe'];
        if ($print != '') log_message("error", "Nom ID: $nom_id, Inicial: $initial, Final: $final, Datos: ".json_encode($datos).", Group: $group, Total: $total"); 
        return $total;
    }
    
    function getTotalYearCloseSale($initial, $final) {
        $total = 0;
        /* $query = "SELECT SUM(d.debit) AS totalDebe, SUM(d.credit) AS totalHaber FROM departure_detail AS d INNER JOIN departure AS p ON d.departure_id = p.departure_id INNER JOIN nomenclature AS n ON d.nomenclature_id = n.nomenclature_id WHERE d.status = 1 AND p.status = 1 AND n.status = 1 AND DATE(p.date) >= DATE('$initial') AND DATE(p.date) <= DATE('$final') AND (n.code = '5.01.01.003' OR n.code = '5.01.01.002')";
        $inv = $this->getInitialInventory($initial);
        //log_message("error", "Query: $query");
        $datos = $this->db->query($query)->row_array();
        //log_message("error", "Datos: ".json_encode($datos));
        $total = $datos['totalDebe'] - $datos['totalHaber'] + $inv; */
        return $total;
    }
    
    function getLevelsDownBalance($code, $level) {
        $level++;
        $query = "SELECT * FROM nomenclature WHERE status = 1 AND code LIKE '$code%' AND level = $level AND balance = 1";
        return $this->db->query($query);
    }

    function getTotalLevelUpBalance($initial, $final, $code, $level, $group)
    {
        $total = 0;
        $datos = $this->db->query("SELECT SUM(d.debit) AS totalDebe, SUM(d.credit) AS totalHaber FROM departure_detail AS d INNER JOIN departure AS p ON d.departure_id = p.departure_id INNER JOIN nomenclature AS n ON d.nomenclature_id = n.nomenclature_id WHERE p.type = 1 AND d.status = 1 AND p.status = 1 AND d.status = 1 AND n.code LIKE '$code%' AND n.level = 5 AND n.balance = 1 AND n.status = 1 AND DATE(p.date) >= DATE('$initial') AND DATE(p.date) <= DATE('$final')")->row_array();
        if ($group == 1 || $group == 5 || $group == 6 || $group == 7 || $group == 8 || $group == 9) $total = $datos['totalDebe'] - $datos['totalHaber'];
        elseif ($group == 2 || $group == 3 || $group == 4) $total = $datos['totalHaber'] - $datos['totalDebe'];
        if ($print != '') log_message("error", "Inicial: $initial, Final: $final, Datos: ".json_encode($datos).", Group: $group, Total: $total"); 
        return $total;
    }
    
    function getLevelsDownState($code, $level) {
        $level++;
        $query = "SELECT * FROM nomenclature WHERE status = 1 AND code LIKE '$code%' AND level = $level AND statement = 1";
        return $this->db->query($query);
    }

    function getTotalLevelUpState($initial, $final, $code, $level, $group)
    {
        $total = 0;
        $datos = $this->db->query("SELECT SUM(d.debit) AS totalDebe, SUM(d.credit) AS totalHaber FROM departure_detail AS d INNER JOIN departure AS p ON d.departure_id = p.departure_id INNER JOIN nomenclature AS n ON d.nomenclature_id = n.nomenclature_id WHERE p.type = 1 AND d.status = 1 AND p.status = 1 AND d.status = 1 AND n.code LIKE '$code%' AND n.level = 5 AND n.statement = 1 AND n.status = 1 AND DATE(p.date) >= DATE('$initial') AND DATE(p.date) <= DATE('$final')")->row_array();
        if ($group == 1 || $group == 5 || $group == 6 || $group == 7 || $group == 8 || $group == 9) $total = $datos['totalDebe'] - $datos['totalHaber'];
        elseif ($group == 2 || $group == 3 || $group == 4) $total = $datos['totalHaber'] - $datos['totalDebe'];
        if ($print != '') log_message("error", "Inicial: $initial, Final: $final, Datos: ".json_encode($datos).", Group: $group, Total: $total"); 
        return $total;
    }
    
    function getGroupByCode($code)
    {
        return $this->db->get_where("group_account", array("code"=>$code, "status"=>1))->row_array();
    }

    function getNomenByCode($code)
    {
        return $this->db->get_where("nomenclature", array("code"=>$code, "status"=>1))->row_array();
    }

    function getNomenByCodeName($code, $name)
    {
        return $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND code = '$code' AND name LIKE '%$name%'")->row_array();
    }

    function getNomenByName($name)
    {
        return $this->db->get_where("nomenclature", array("name"=>$name, "status"=>1))->row_array();
    }

    function getHeadByCode($code)
    {
        return $this->db->get_where("heading", array("code"=>$code, "status"=>1))->row_array();
    }

    function getGroupEquityLike($like, $head_id)
    {
        return $this->db->query("SELECT g.*, t.code AS init_code FROM group_account AS g INNER JOIN heading AS h ON g.heading_id = h.heading_id INNER JOIN heading_type AS t ON h.heading_type_id = t.heading_type_id WHERE g.name LIKE '%$like%' AND g.heading_id = '$head_id' AND h.status = 1 AND t.status = 1");
    }

    function getNomenLikeStatement($like, $type_id, $head_id, $group_id)
    {
        return $this->db->query("SELECT * FROM nomenclature WHERE name LIKE '%$like%' AND heading_type_id = '$type_id' AND heading_id = '$head_id' AND group_account_id = '$group_id' AND status = 1 ORDER BY code ASC");
    }

    function getHeadsTypesGeneral()
    {
        return $this->db->order_by("heading_type_id", "ASC")->get_where("heading_type", array("statement_id"=>1, "status"=>1));
    }

    function getUtilityGeneral($initial, $final) {
        //log_message("error", "Inicio en Balance General");
        $income = 0; $expense = 0; $hoy = strtotime(date("Y-m-d")); $legal = 0;
        $merc = 0; $totalMerc = 0; $oper = 0; $admin = 0; $fina = 0; $prod = 0; $gast = 0;
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '4.01.01.001' OR code = '4.01.01.002' OR code = '4.02.01.001')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 4);
            $ventas += $total;
            $income += $total;
        }
        //log_message("error", "Ven Netas: $income");
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '5.01.01.001' OR code = '5.01.01.002' OR code = '5.01.01.003' OR code = '5.01.01.006')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 5);
            $merc += $total;
        }
        //log_message("error", "Merc: $merc");
        /*if (strtotime($final) < $hoy) $total = $this->getTotalInventory($final);
        else $total = $this->getTotalInventory();*/
        //log_message("error", "Inv Final: $total");
        if ($merc > $total) $totalMerc = $merc - $total;
        else $totalMerc = $total - $merc;
        //log_message("error", "totalMerc: $totalMerc");
        $total = $income - $totalMerc;
        //log_message("error", "Merc: $total");
        $expense += $totalMerc;
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '5.02.01.002' OR code = '5.02.01.003' OR code = '5.02.01.004' OR code = '5.02.01.005' OR code = '5.02.01.006' OR code = '5.02.01.007' OR code = '5.02.01.008' OR code = '5.02.01.009' OR code = '5.02.01.010' OR code = '5.02.01.011' OR code = '5.02.01.012' OR code = '5.02.01.013' OR code = '5.02.01.014' OR code = '5.02.01.015' OR code = '5.02.01.016' OR code = '5.02.01.017' OR code = '5.02.01.018' OR code = '5.02.01.019' OR code = '5.02.01.020' OR code = '5.02.01.021')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 5);
            $oper += $total;
            $expense += $total;
        }
        //log_message("error", "Oper: $oper");
        $margen = $income - $expense;
        //log_message("error", "Margen: $margen");
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '5.02.01.024' OR code = '5.02.01.025' OR code = '5.02.01.026' OR code = '5.02.01.027' OR code = '5.02.01.028')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 5);
            $admin += $total;
            $expense += $total;
        }
        //log_message("error", "Admin: $admin");
        $margen = $income - $expense;
        //log_message("error", "Margen: $margen");
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '5.03.01.001' OR code = '5.03.01.002' OR code = '5.03.01.003' OR code = '5.03.01.004' OR code = '5.03.01.005')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 5);
            $fina += $total;
            $expense += $total;
        }
        //log_message("error", "Fina: $fina");
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '5.04.01.001' OR code = '5.04.01.002')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 5);
            $prod += $total;
            $expense -= $total;
        }
        //log_message("error", "Prod: $prod");
        $gast = $fina - $prod;
        //log_message("error", "Gast: $gast");
        $rest = $income - $expense;
        $gros = $rest;
        //log_message("error", "Util: $rest");
        if($rest > 0) $legal = $rest * 0.05;
        //log_message("error", "Legal: $legal");
        $rest -= $legal;
        // log_message("error", "Util: $rest");
        $values = array("gross"=>$gros, "legal"=>$legal, "net"=>$rest);
        // log_message("error", "Values: ".json_encode($values));
        return $values;
    }

    function getCashNomen() {
        $data = $this->db->query("SELECT * FROM nomenclature WHERE name LIKE '%caja%' AND name NOT LIKE '%chica%' AND balance = 1 AND status = 1");
        return $data;
    }

    function getPettyCash() {
        $data = $this->db->query("SELECT * FROM nomenclature WHERE name LIKE '%caja chica%' AND balance = 1 AND status = 1");
        return $data;
    }

    function getNomenCash()
    {
        $data = $this->db->query("SELECT * FROM nomenclature WHERE name LIKE '%Caja%'  AND nomenclature_id NOT IN(157,65) AND status = 1");
        return $data;
    }

    function getCashPetty() {
        $data = $this->db->query("SELECT * FROM nomenclature WHERE name LIKE '%caja chica%' AND status = 1");
        return $data;
    }
    
    function getBankNomenGeneral() {
        $data = $this->db->query("SELECT * FROM nomenclature WHERE code LIKE '1.01.02%' AND balance = 1 AND status = 1 ORDER BY code ASC");
        return $data;
    }
    
    function getInventNomenGeneral() {
        $data = $this->db->query("SELECT * FROM nomenclature WHERE code LIKE '1.01.03%' AND code NOT LIKE '%001' AND balance = 1 AND status = 1 ORDER BY code ASC");
        return $data;
    }

    function getHeadTypeByCode($code)
    {
        return $this->db->get_where("heading_type", array("code"=>$code, "status"=>1))->row_array();
    }

    function getGroupByCodeName($code, $name)
    {
        return $this->db->query("SELECT * FROM group_account WHERE status = 1 AND code = '$code' AND name LIKE '%$name%'")->row_array();
    }

    function getSalesBook($initial, $final, $data)
    {
        $query = "";
        $ex = explode('-', $data);
        $institution_id = $ex[0];
        $camp = $ex[1];
        $text = $ex[2];
        if ($institution_id != '' && $camp != '') $query = "SELECT * FROM sale WHERE institution_id = '$institution_id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND $camp LIKE '%$text%' ORDER BY DATE(date) ASC, sale_id ASC";
        elseif ($institution_id != '' && $camp == '') $query = "SELECT * FROM sale WHERE institution_id = '$institution_id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') ORDER BY DATE(date) ASC, sale_id ASC";
        elseif ($institution_id == '' && $camp != '') $query = "SELECT * FROM sale WHERE DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND $camp LIKE '%$text%' ORDER BY DATE(date) ASC, sale_id ASC";
        else $query = "SELECT * FROM sale WHERE DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') ORDER BY DATE(date) ASC, sale_id ASC";
        return $this->db->query($query);
    }

    function getPurchasing($initial, $final, $data)
    {
        $query = "";
        $ex = explode('-', $data);
        $institution_id = $ex[0];
        $camp = $ex[1];
        $text = $ex[2];
        if ($institution_id != '' && $camp != '') $query = "SELECT * FROM purchase WHERE institution_id = '$institution_id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND $camp LIKE '%$text%' ORDER BY DATE(date) ASC, purchase_id ASC";
        elseif ($institution_id != '' && $camp == '') $query = "SELECT * FROM purchase WHERE institution_id = '$institution_id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') ORDER BY DATE(date) ASC, purchase_id ASC";
        elseif ($institution_id == '' && $camp != '') $query = "SELECT * FROM purchase WHERE DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND $camp LIKE '%$text%' ORDER BY DATE(date) ASC, purchase_id ASC";
        else $query = "SELECT * FROM purchase WHERE DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') ORDER BY DATE(date) ASC, purchase_id ASC";
        return $this->db->query($query);
        
        // $query = "SELECT c.*, p.name, p.nit FROM pedidos AS c INNER JOIN provider AS p ON c.provider_id = p.provider_id WHERE DATE(c.date) >= DATE('$initial') AND DATE(c.date) <= DATE('$final') AND p.status = 1";
        return $this->db->query($query);
        
    }

    function getInstitutionActive()
    {
        return $this->db->query("SELECT * FROM institution WHERE status = 1 AND registered IS NULL");
    }

    function getTransferAccount($account_id, $initial, $final, $no_policy = '')
    {
        if ($no_policy == '') $data =  $this->db->query("SELECT * FROM bank_transfer WHERE bank_account_id = '$account_id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND (adjust IS NULL OR adjust = '') AND reference_table IS NOT NULL AND reference_table != '' AND status = 1 ORDER BY date ASC, bank_transfer_id ASC");
        else $data = $this->db->query("SELECT t.* FROM bank_transfer AS t INNER JOIN policy = p ON t.reference_id = p.departure_id WHERE t.bank_account_id = '$account_id' AND p.no_policy = '$no_policy' AND DATE(t.date) >= DATE('$initial') AND DATE(t.date) <= DATE('$final') AND (t.adjust IS NULL OR t.adjust = '') AND t.reference_table = 'departure' AND t.status = 1 AND p.status = 1 ORDER BY date ASC, bank_transfer_id ASC");
        return $data;
    }

    function getTransferAdjustAccount($account_id, $initial, $final, $no_policy = '')
    {
        if ($no_policy == '') $data = $this->db->query("SELECT * FROM bank_transfer WHERE bank_account_id = '$account_id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND adjust = 1 AND status = 1 ORDER BY date ASC");
        else $data = $this->db->query("SELECT t.* FROM bank_transfer AS t INNER JOIN policy = p ON t.reference_id = p.departure_id WHERE t.bank_account_id = '$account_id' AND p.no_policy = '$no_policy' AND DATE(t.date) >= DATE('$initial') AND DATE(t.date) <= DATE('$final') AND t.adjust = 1 AND t.reference_table = 'departure' AND t.status = 1 AND p.status = 1");
        return $data;
    }

    function getInfoAccount($account_id)
    {
        return $this->db->query("SELECT a.bank_account_id, a.name AS name_account, a.code, b.name AS bank, n.name AS heading, n.code AS key_code, c.symbol, c.name AS currency, c.code AS iso FROM bank_account AS a INNER JOIN bank AS b ON a.bank_id = b.bank_id INNER JOIN currency AS c ON a.currency_id = c.currency_id INNER JOIN nomenclature AS n ON a.nomenclature_id = n.nomenclature_id WHERE a.bank_account_id = '$account_id'")->row_array();
    }

    function getInitialBalanceBank($account_id, $initial)
    {
        $plus = $this->db->query("SELECT SUM(amount) AS total FROM bank_transfer WHERE bank_account_id = '$account_id' AND DATE(date) < DATE('$initial') AND type = 1 AND status = 1")->row()->total;
        $min = $this->db->query("SELECT SUM(amount) AS total FROM bank_transfer WHERE bank_account_id = '$account_id' AND DATE(date) < DATE('$initial') AND type = 0 AND status = 1")->row()->total;
        $total = $plus - $min;
        return $total;
    }

    function getBankAccountsActive()
    {
        return $this->db->get_where("bank_account", array("status"=>1, "property"=>1));
    }

    function getAccountBank($id)
    {
        return $this->db->get_where("bank_account", array("bank_account_id"=>$id))->row_array();
    }
    
    function getPolicy($policy_id)
    {
        return $this->db->get_where("policy", array("policy_id"=>$policy_id))->row_array();
    }

    function getPolicyByDep($departure_id)
    {
        return $this->db->get_where("policy", array("departure_id"=>$departure_id));
    }

    function getPolicyByDetail($detail_id)
    {
        return $this->db->get_where("policy", array("departure_detail_id"=>$detail_id))->row_array();
    }

    function getPolicyDetails($policy_id)
    {
        return $this->db->get_where("policy_detail", array("policy_id"=>$policy_id, "status"=>1));
    }

    function getNoPolicyByBank($dep_id, $nom_id)
    {
        return $this->db->query("SELECT no_policy FROM policy WHERE departure_id = '$dep_id' AND nomenclature_id = '$nom_id' AND status = 1")->row()->no_policy;
    }
    
    function getFinalBalanceAccount($id, $initial, $final)
    {
        return $this->db->query("SELECT * FROM bank_transfer WHERE bank_account_id = '$id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND status = 1 ORDER BY date DESC LIMIT 1")->row()->balance;
    }

    function getBalanceFinalBank($account_id, $initial, $final)
    {
        $balance = $this->getInitialBalanceBank($account_id, $initial);
        $plus = $this->db->query("SELECT SUM(amount) AS total FROM bank_transfer WHERE bank_account_id = '$account_id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND type = 1 AND (adjust IS NULL OR adjust = '') AND reference_table IS NOT NULL AND reference_table != '' AND status = 1")->row()->total;
        $min = $this->db->query("SELECT SUM(amount) AS total FROM bank_transfer WHERE bank_account_id = '$account_id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND type = 0 AND (adjust IS NULL OR adjust = '') AND reference_table IS NOT NULL AND reference_table != '' AND status = 1")->row()->total;
        /* log_message("error", "Conciliacion bancaria");
        log_message("error", "Saldo inicial: $balance");
        log_message("error", "Ingresos: $plus");
        log_message("error", "Egresos: $min"); */
        $total = $balance + $plus - $min;
        // log_message("error", "Total: $total");
        return $total;
    }

    function getCreditNotes($id, $initial, $final)
    {
        return $this->db->query("SELECT * FROM bank_transfer WHERE bank_account_id = '$id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND category = 1 AND status = 1");
    }
    
    function getDebitNotes($id, $initial, $final)
    {
        return $this->db->query("SELECT * FROM bank_transfer WHERE bank_account_id = '$id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND category = 2 AND status = 1");
    }

    function getCheckDrawn($id, $initial, $final)
    {
        return $this->db->query("SELECT * FROM bank_transfer WHERE bank_account_id = '$id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND category = 3 AND status = 1");
    }

    function getDepositTransit($id, $initial, $final)
    {
        return $this->db->query("SELECT * FROM bank_transfer WHERE bank_account_id = '$id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND category = 4 AND status = 1");
    }
    
    function getIssueBySale($sale_id)
    {
        //return $this->db->get_where('issue', array('sale_id'=>$sale_id))->row_array();
        return 0;
    }

    function getIssueByInvoice($date)
    {
        return $this->db->query("SELECT * FROM emision WHERE TIMESTAMP(fecha_emision) = TIMESTAMP('$date') LIMIT 1")->row_array();
        // return $this->db->get_where('emision', array('numero_factura'=>$invoice))->row_array();
    }

    function newBank() {
        $data['name']        = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $this->db->insert('bank', $data);
        $bank_id = $this->db->insert_id();

        /* $mensaje = "Ha creado el banco con id: $id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "bank", $id); */

        return $bank_id;
    }
    
    function editBank() {
        $bank_id             = $this->input->post('bank_id');
        $data['name']        = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $this->db->where('bank_id', $bank_id);
        $query = $this->db->update('bank', $data);
        
        /* $mensaje = "Ha actualizado el banco con id: $id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "bank", $id); */

        return $query;
    }
    
    function deactivateBank() {
        $bank_id = base64_decode($this->input->post('id'));
        $data['status'] = 0;
        $this->db->where('bank_id', $bank_id);
        $query = $this->db->update('bank', $data);

        /* $mensaje = "Ha desactivado el banco con id: $bank_id.";
        $this->binnacle($mensaje, "bank", $bank_id); */

        echo $query;
    }
    
    function activateBank() {
        $bank_id = base64_decode($this->input->post('id'));
        $data['status'] = 1;
        $this->db->where('bank_id', $bank_id);
        $query = $this->db->update('bank', $data);
        
        /* $mensaje = "Ha activado el banco con id: $bank_id.";
        $this->binnacle($mensaje, "bank", $bank_id); */

        echo $query;
    }
    
    function deleteBank() {
        $bank_id = base64_decode($this->input->post('id'));
        $this->db->where('bank_id', $bank_id);
        $query = $this->db->delete('bank');
        
        /* $mensaje = "Ha eliminado el banco con id: $bank_id.";
        $this->binnacle($mensaje, "bank", $bank_id); */

        echo $query;
    }

    function newCurrency()
    {
        $data['name']   = $this->input->post('name');
        $data['symbol'] = $this->input->post('symbol');
        $data['code']   = $this->input->post('code');
        $data['origin'] = $this->input->post('origin');
        $this->db->insert('currency', $data);
        $currency_id = $this->db->insert_id();

        /* $mensaje = "Ha creado la moneda con id: $currency_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "currency", $currency_id); */

        return $currency_id;
    }

    function editCurrency()
    {
        $currency_id    = $this->input->post('currency_id');
        $data['name']   = $this->input->post('name');
        $data['symbol'] = $this->input->post('symbol');
        $data['code']   = $this->input->post('code');
        $data['origin'] = $this->input->post('origin');
        $this->db->where('currency_id', $currency_id);
        $query = $this->db->update('currency', $data);
        
        /* $mensaje = "Ha actualizado la moneda con id: $currency_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "currency", $currency_id); */

        return $query;
    }

    function deactivateCurrency()
    {
        $currency_id = base64_decode($this->input->post('id'));
        $data['status'] = 0;
        $this->db->where('currency_id', $currency_id);
        $query = $this->db->update('currency', $data);
        
        /* $mensaje = "Ha desactivado la moneda con id: $currency_id.";
        $this->binnacle($mensaje, "currency", $currency_id); */

        echo $query;
    }

    function activateCurrency()
    {
        $currency_id = base64_decode($this->input->post('id'));
        $data['status'] = 1;
        $this->db->where('currency_id', $currency_id);
        $query = $this->db->update('currency', $data);
        
        /* $mensaje = "Ha activado la moneda con id: $currency_id.";
        $this->binnacle($mensaje, "currency", $currency_id); */

        echo $query;
    }

    function deleteCurrency()
    {
        $currency_id = base64_decode($this->input->post('id'));
        $this->db->where('currency_id', $currency_id);
        $query = $this->db->delete('currency');
        
        /* $mensaje = "Ha eliminado la moneda con id: $currency_id.";
        $this->binnacle($mensaje, "currency", $currency_id); */

        echo $query;
    }
    
    function newBankCheck()
    {
        $initial = date("Y-m-01"); $final = date("Y-m-t"); $fechaHora = date("Y-m-d H:i:s");
        $balance_ledge = 0; $subtotal_note_credit = 0; $subtotal_note_debit = 0; $balance_1 = 0;
        $balance_account = 0; $subtotal_bank_check = 0; $subtotal_bank_deposit = 0; $balance_2 = 0;
        
        $bank_account_id = $this->input->post('bank_account_id');
        $no_check        = $this->input->post('no_check');
        $date            = $this->input->post('date');
        $amount          = $this->input->post('amount');
        $pay_to          = $this->input->post('pay_to');
        $reference       = $this->input->post('reference');
        $nomen_id        = $this->input->post('nomenclature_id');
        
        $data['bank_account_id'] = $bank_account_id;
        $data['no_check']        = $no_check;
        $data['place']           = $this->input->post('place');
        $data['date']            = $date;
        $data['amount']          = $amount;
        $data['pay_to']          = $this->input->post('pay_to');
        $data['amount_letter']   = $this->input->post('amount_letter');
        $data['reference']       = $reference;
        $data['nomenclature_id'] = $nomen_id;
        $this->db->insert('bank_check', $data);
        $bank_check_id = $this->db->insert_id();
        
        /* $mensaje = "Ha creado el cheque bancario con id: $bank_check_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "bank_check", $bank_check_id); */
        
        $credits = $this->getCreditNotes($bank_account_id, $initial, $final);
        $debits = $this->getDebitNotes($bank_account_id, $initial, $final);
        $checks = $this->getCheckDrawn($bank_account_id, $initial, $final);
        $deposits = $this->getDepositTransit($bank_account_id, $initial, $final);
        
        $balance_ledge = $this->getBalanceFinalBank($bank_account_id, $initial, $final);
        $balance_1 += $balance_ledge;
        foreach ($credits->result_array() as $cr) {
            $balance_1 += $cr['amount'];
            $subtotal_not_debit += $cr['amount'];
        }
        foreach ($debits->result_array() as $db) {
            $balance_1 -= $db['amount'];
            $subtotal_not_debit += $db['amount'];
        }
        
        $balance_account = $this->db->get_where('bank_account', array('bank_account_id'=>$bank_account_id))->row()->balance;
        $balance_2 += $balance_account;
        $balance_2 -= $amount;
        foreach ($checks->result_array() as $ch) {
            $balance_2 -= $ch['amount'];
            $subtotal_bank_check += $ch['amount'];
        }
        foreach ($deposits->result_array() as $dp) {
            $balance_2 += $dp['amount'];
            $subtotal_bank_deposit += $dp['amount'];
        }
        
        $dataC['bank_account_id']       = $bank_account_id;
        $dataC['initial']               = $initial;
        $dataC['final']                 = $final;
        $dataC['datetime']              = $fechaHora;
        $dataC['admin_id']              = $this->session->userdata('login_user_id');
        $dataC['balance_ledge']         = $balance_ledge;
        $dataC['subtotal_note_credit']  = $subtotal_note_credit;
        $dataC['subtotal_note_debit']   = $subtotal_note_debit;
        $dataC['balance_1']             = $balance_1;
        $dataC['balance_account']       = $balance_account;
        $dataC['subtotal_bank_check']   = $subtotal_bank_check;
        $dataC['subtotal_bank_deposit'] = $subtotal_bank_deposit;
        $dataC['balance_2']             = $balance_2;
        $this->db->insert('bank_conciliation', $dataC);
        $bank_conciliation_id = $this->db->insert_id();

        /* $mensaje = "Ha creado una conciliación bancaria con id: $bank_conciliation_id, con la información: ".json_encode($dataC).".";
        $this->binnacle($mensaje, "bank_conciliation", $bank_conciliation_id); */
        
        $dataD = array();
        foreach ($credits->result_array() as $cr) {
            $dataD['bank_conciliation_id'] = $bank_conciliation_id;
            $dataD['type']                 = "NC";
            $dataD['description']          = $cr['description'];
            $dataD['amount']               = $cr['amount'];
            $dataD['reference_bank']       = "bank_transfer";
            $dataD['reference_id']         = $cr['bank_transfer_id'];
            $this->db->insert('bank_conciliation_detail', $dataD);
            $detail_id = $this->db->insert_id();

            /* $mensaje = "Ha creado detalle de nota de crédito de conciliación bancaria con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "bank_conciliation_detail", $detail_id); */
        }
        
        $dataD = array();
        foreach ($debits->result_array() as $db) { 
            $dataD['bank_conciliation_id'] = $bank_conciliation_id;
            $dataD['type']                 = "ND";
            $dataD['description']          = $db['description'];
            $dataD['amount']               = $db['amount'];
            $dataD['reference_bank']       = "bank_transfer";
            $dataD['reference_id']         = $db['bank_transfer_id'];
            $this->db->insert('bank_conciliation_detail', $dataD);
            $detail_id = $this->db->insert_id();

            /* $mensaje = "Ha creado detalle de nota de débito de conciliación bancaria con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "bank_conciliation_detail", $detail_id); */
        }

        $dataD = array();
        $dataD['bank_conciliation_id'] = $bank_conciliation_id;
        $dataD['type']                 = "BC";
        $dataD['description']          = $reference;
        $dataD['amount']               = $amount;
        $dataD['reference_bank']       = "bank_check";
        $dataD['reference_id']         = $bank_check_id;
        $this->db->insert('bank_conciliation_detail', $dataD);
        $detail_id = $this->db->insert_id();

        /* $mensaje = "Ha creado detalle de cheques girados de conciliación bancaria con id: $detail_id, con la información: ".json_encode($dataD).".";
        $this->binnacle($mensaje, "bank_conciliation_detail", $detail_id); */
        foreach ($checks->result_array() as $ch) { 
            $dataD['bank_conciliation_id'] = $bank_conciliation_id;
            $dataD['type']                 = "BC";
            $dataD['description']          = $ch['description'];
            $dataD['amount']               = $ch['amount'];
            $dataD['reference_bank']       = "bank_transfer";
            $dataD['reference_id']         = $ch['bank_transfer_id'];
            $this->db->insert('bank_conciliation_detail', $dataD);
            $detail_id = $this->db->insert_id();

            /* $mensaje = "Ha creado detalle de cheques girados de conciliación bancaria con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "bank_conciliation_detail", $detail_id); */
        }

        $dataD = array();
        foreach ($deposits->result_array() as $dp) { 
            $dataD['bank_conciliation_id'] = $bank_conciliation_id;
            $dataD['type']                 = "BD";
            $dataD['description']          = $dp['description'];
            $dataD['amount']               = $dp['amount'];
            $dataD['reference_bank']       = "bank_transfer";
            $dataD['reference_id']         = $dp['bank_transfer_id'];
            $this->db->insert('bank_conciliation_detail', $dataD);
            $detail_id = $this->db->insert_id();

            /* $mensaje = "Ha creado detalle de depositos en tránsito de conciliación bancaria con id: $detail_id, con la información: ".json_encode($dataD).".";
            $this->binnacle($mensaje, "bank_conciliation_detail", $detail_id); */
        }
        $details = "Por emisión de cheque no.$no_check, por un total de: Q.".number_format($amount,2,'.',',')." a nombre de: $pay_to";
        $data6['date']     = $date;
        $data6['datetime'] = $fechaHora;
        $data6['amount']   = $amount;
        $data6['iva']      = 0;
        $data6['isr']      = 0;
        $data6['total']    = $amount;
        $data6['admin_id'] = $this->session->userdata('login_user_id');
        $data6['details']  = $details;
        $this->db->insert('departure', $data6);
        $departure_id = $this->db->insert_id();
        
        $data7['code'] = $this->correlativeCode($departure_id);
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $data7);

        /* $mensaje = "Ha creado la partida con id: $departure_id con la información: ".json_encode(array_merge($data6, $data7)).".";
        $this->binnacle($mensaje, "departure", $departure_id); */

        $num = 1; $move = array();
        
        $data9['number']          = $num++;
        $data9['departure_id']    = $departure_id;
        $data9['nomenclature_id'] = $nomen_id;
        $data9['debit']           = $amount;
        $data9['position']        = 'D';
        $this->db->insert('departure_detail', $data9);
        $departure_detail_id = $this->db->insert_id();
        $nom = $this->getNomen($nomen_id);
        $move['move'] = $nom['move_bank'];
        if ($nom['heading_id'] == 1) {
            $data10 = array(); 
            $data10['departure_id']        = $departure_id;
            $data10['departure_detail_id'] = $departure_detail_id;
            $data10['nomenclature_id']     = $nomen_id;
            $data10['year']                = date('Y');
            $data10['no_policy']           = $this->getNoPolicyNom($nomen_id);
            $data10['type']                = 'Diario';
            $data10['concept']             = $details;
            $data10['approve_charge']      = "Gerente";
            $data10['maker_charge']        = "Auxiliar Contable";
            $this->db->insert('policy', $data10);
            $policy_id = $this->db->insert_id();
            
            /* $mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data10).".";
            $this->binnacle($mensaje, "policy", $policy_id); */
        }
        
        /* $mensaje = "Ha creado el detalle de partida con id: $departure_detail_id con la información: ".json_encode($data9).".";
        $this->binnacle($mensaje, "departure_detail", $departure_detail_id); */
        
        $banco = $this->getBankAccount($bank_account_id);
        $nomen_id = $banco['nomenclature_id'];
        $nom = $this->getNomen($nomen_id);
        
        $data11['number']          = $num++;
        $data11['departure_id']    = $departure_id;
        $data11['nomenclature_id'] = $nomen_id;
        $data11['credit']          = $amount;
        $data11['position']        = 'C';
        $this->db->insert('departure_detail', $data11);
        $departure_detail_id = $this->db->insert_id();

        if ($nom['heading_id'] == 1) {
            $data12 = array(); 
            $data12['departure_id']        = $departure_id;
            $data12['departure_detail_id'] = $departure_detail_id;
            $data12['nomenclature_id']     = $nomen_id;
            $data12['year']                = date('Y');
            $data12['no_policy']           = $this->getNoPolicyNom($nomen_id);
            $data12['type']                = 'Diario';
            $data12['concept']             = $details;
            $data12['approve_charge']      = "Gerente";
            $data12['maker_charge']        = "Auxiliar Contable";
            $this->db->insert('policy', $data12);
            $policy_id = $this->db->insert_id();
            
            /* $mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data12).".";
            $this->binnacle($mensaje, "policy", $policy_id); */
        }
        
        /* $mensaje = "Ha creado el detalle de partida con id: $departure_detail_id con la información: ".json_encode($data11).".";
        $this->binnacle($mensaje, "departure_detail", $departure_detail_id); */
        
        $dataDep['data'] = $this->getDataDeparture($departure_id);
        $this->db->where('departure_id', $departure_id);
        $query = $this->db->update('departure', $dataDep);

        /* $mensaje = "Ha creado la data de la partida con id: $departure_id, con la información: ".json_encode($dataDep).".";
        $this->binnacle($mensaje, "departure", $departure_id); */
        
        $balance = 0;
        $transfer = $amount;
        $balance = $banco['balance'] - $transfer;
        $dataT['code']                = $this->randCode("BT-");
        $dataT['type']                = 0;
        $dataT['move']                = $move['move'];
        $dataT['no_check']            = $no_check;
        $dataT['reference_table']     = "departure";
        $dataT['reference_id']        = $departure_id;
        $dataT['reference_detail_id'] = $departure_detail_id;
        $dataT['bank_account_id']     = $bank_account_id;
        $dataT['date']                = $date;
        $dataT['datetime']            = $fechaHora;
        $dataT['amount']              = $transfer;
        $dataT['balance']             = $balance;
        $dataT['description']         = $details;
        $this->db->insert('bank_transfer', $dataT);
        $bank_transfer_id = $this->db->insert_id();

        /* $mensaje = "Ha creado la transferencia bancaria con id: $bank_transfer_id con la información: ".json_encode($dataT).".";
        $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id); */

        $dataB['balance'] = $balance;
        $this->db->where('bank_account_id', $banco['bank_account_id']);
        $query = $this->db->update('bank_account', $dataB);
        
        /* $mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: ".$banco['bank_account_id'].", al saldo: $balance.";
        $this->binnacle($mensaje, "bank_account", $banco['bank_account_id']); */
        
        $dataBC['departure_id'] = $departure_id;
        $this->db->where('bank_check_id', $bank_check_id);
        $this->db->update('bank_check', $dataBC);
        
        
        return $bank_check_id;
    }

    function editBankCheck()
    {
        $subtotal_bank_check = 0; $balance_2 = 0; $fechaHora = date("Y-m-d H:i:s"); $move = array();
        
        $bank_check_id = $this->input->post('bank_check_id');
        $no_check      = $this->input->post('no_check');
        $date          = $this->input->post('date');
        $amount        = $this->input->post('amount');
        $pay_to        = $this->input->post('pay_to');
        $reference     = $this->input->post('reference');
        $nomen_id      = $this->input->post('nomenclature_id');
        
        $data['no_check']        = $no_check;
        $data['place']           = $this->input->post('place');
        $data['date']            = $date;
        $data['amount']          = $amount;
        $data['pay_to']          = $pay_to;
        $data['amount_letter']   = $this->input->post('amount_letter');
        $data['reference']       = $reference;
        $data['nomenclature_id'] = $nomen_id;
        $this->db->where('bank_check_id', $bank_check_id);
        $query = $this->db->update('bank_check', $data);
        
        /* $mensaje = "Ha actualizado el cheque bancario con id: $bank_check_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "bank_check", $bank_check_id); */

        $detcon = $this->db->get_where('bank_conciliation_detail', array('reference_bank'=>'bank_check', 'reference_id'=>$bank_check_id, 'status'=>1));
        
        if ($detcon->num_rows() > 0) {
            $det = $detcon->row_array();
            $conban = $this->db->get_where('bank_conciliation', array('bank_conciliation_id'=>$det['bank_conciliation_id']))->row_array();
            $subtotal_bank_check = $conban['subtotal_bank_check'] + $det['amount'] - $amount;
            $balance_2 = $conban['balance_2'] + $det['amount'] - $amount;
            
            $dataCB['subtotal_bank_check'] = $subtotal_bank_check;
            $dataCB['balance_2']           = $balance_2;
            $this->db->where('bank_conciliation_id', $det['bank_conciliation_id']);
            $this->db->update('bank_conciliation', $dataCB);
            
            $dataDC['description'] = $reference;
            $dataDC['amount']      = $amount;
            $this->db->where('bank_conciliation_detail_id', $det['bank_conciliation_detail_id']);
            $query = $this->db->update('bank_conciliation_detail', $dataDC);
        }
        
        
        $check = $this->getBankCheck($bank_check_id);
        if ($check['departure_id'] != '') {
            $departure_id = $check['departure_id'];
            $details = "Por emisión de cheque no.$no_check, por un total de: Q.".number_format($amount,2,'.',',')." a nombre de: $pay_to";
            
            $data1['date']     = $date;
            $data1['amount']   = $amount;
            $data1['total']    = $amount;
            $data1['admin_id'] = $this->session->userdata('login_user_id');
            $data1['details']  = $details;
            $this->db->where('departure_id', $departure_id);
            $this->db->update('departure', $data1);
            
            /* $mensaje = "Ha actualizado la partida con id: $departure_id con la información: ".json_encode($data1).".";
            $this->binnacle($mensaje, "departure", $departure_id); */
            
            $detail_id = $this->db->get_where('departure_detail', array('number'=>1, 'departure_id'=>$departure_id, 'status'=>1))->row()->departure_detail_id;
            $data2['nomenclature_id'] = $nomen_id;
            $data2['debit']           = $amount;
            $this->db->where('departure_detail_id', $detail_id);
            $this->db->update('departure_detail', $data2);
            
            $nom = $this->getNomen($nomen_id);
            $move['move'] = $nom['move_bank'];
            if ($nom['heading_id'] == 1) {
                $pol = $this->getPolicyByDetail($detail_id);
                if (count($pol) > 0) {
                    $data3 = array();
                    $data3['nomenclature_id'] = $nomen_id;
                    if ($nomen_id != $pol['nomenclature_id']) $data3['no_policy'] = $this->getNoPolicyNom($nomen_id);
                    $this->db->where('policy_id', $pol['policy_id']);
                    $query = $this->db->update('policy', $data3);
                    
                    /* $mensaje = "Ha actualizado la póliza con id: ".$pol['policy_id'].", con la información: ".json_encode($data3).".";
                    $this->binnacle($mensaje, "policy", $pol['policy_id']); */
                } else {
                    $data4 = array(); 
                    $data4['departure_id']        = $departure_id;
                    $data4['departure_detail_id'] = $detail_id;
                    $data4['nomenclature_id']     = $nomen_id;
                    $data4['year']                = date('Y');
                    $data4['no_policy']           = $this->getNoPolicyNom($nomen_id);
                    $data4['type']                = 'Diario';
                    $data4['concept']             = $details;
                    $data4['approve_charge']      = "Gerente";
                    $data4['maker_charge']        = "Auxiliar Contable";
                    $this->db->insert('policy', $data4);
                    $policy_id = $this->db->insert_id();
                    
                    /* $mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data4).".";
                    $this->binnacle($mensaje, "policy", $policy_id); */
                }
            }
            /* $mensaje = "Ha actualizado el detalle de la partida con id: $detail_id con la información: ".json_encode($data2).".";
            $this->binnacle($mensaje, "departure_detail", $detail_id); */
        
            $banco = $this->getBankAccount($bank_account_id);
            $nomen_id = $banco['nomenclature_id'];
            $nom = $this->getNomen($nomen_id);
            
            $detail_id = $this->db->get_where('departure_detail', array('number'=>2, 'departure_id'=>$departure_id, 'status'=>1))->row()->departure_detail_id;
            $data5['nomenclature_id'] = $nomen_id;
            $data5['credit']          = $amount;
            $this->db->where('departure_detail_id', $detail_id);
            $this->db->update('departure_detail', $data5);
            
            $nom = $this->getNomen($nomen_id);
            if ($nom['heading_id'] == 1) {
                $pol = $this->getPolicyByDetail($detail_id);
                if (count($pol) > 0) {
                    $data6 = array();
                    $data6['nomenclature_id'] = $nomen_id;
                    if ($nomen_id != $pol['nomenclature_id']) $data6['no_policy'] = $this->getNoPolicyNom($nomen_id);
                    $this->db->where('policy_id', $pol['policy_id']);
                    $query = $this->db->update('policy', $data6);
                    
                    /* $mensaje = "Ha actualizado la póliza con id: ".$pol['policy_id'].", con la información: ".json_encode($data6).".";
                    $this->binnacle($mensaje, "policy", $pol['policy_id']); */
                } else {
                    $data7 = array(); 
                    $data7['departure_id']        = $departure_id;
                    $data7['departure_detail_id'] = $detail_id;
                    $data7['nomenclature_id']     = $nomen_id;
                    $data7['year']                = date('Y');
                    $data7['no_policy']           = $this->getNoPolicyNom($nomen_id);
                    $data7['type']                = 'Diario';
                    $data7['concept']             = $details;
                    $data7['approve_charge']      = "Gerente";
                    $data7['maker_charge']        = "Auxiliar Contable";
                    $this->db->insert('policy', $data7);
                    $policy_id = $this->db->insert_id();
                    
                    /* $mensaje = "Ha creado una nueva póliza con id: $policy_id, con la información: ".json_encode($data7).".";
                    $this->binnacle($mensaje, "policy", $policy_id); */
                }
            }
            /* $mensaje = "Ha actualizado el detalle de la partida con id: $detail_id con la información: ".json_encode($data5).".";
            $this->binnacle($mensaje, "departure_detail", $detail_id); */
            
            $dataDep['data'] = $this->getDataDeparture($departure_id);
            $this->db->where('departure_id', $departure_id);
            $query = $this->db->update('departure', $dataDep);
    
            /* $mensaje = "Ha actualizado la data de la partida con id: $departure_id, con la información: ".json_encode($dataDep).".";
            $this->binnacle($mensaje, "departure", $departure_id); */
        }
        
        $trans = $this->countTransferByReference("departure", $departure_id, $detail_id);
        $bank = $this->getAccountByNomen($nomen_id);
        $balance = 0; $transfer = 0;
        if ($trans > 0) {
            $tra = $this->getBankTransferByDetail("departure", $sale['departure_id'], $detail_id);
            if ($bank['bank_account_id'] == $tra['bank_account_id']) {
                $balance = 0; $transfer = 0;
                $data8['type'] = 0;
                $transfer = $amount;
                $balance = $bank['balance'] + $tra['amount'] - $transfer;
                $bank = $this->getAccountByNomen($nom_id);
                $data8['reference_detail_id'] = $detail_id;
                $data8['date']                = $date;
                $data8['bank_account_id']     = $bank['bank_account_id'];
                $data8['amount']              = $transfer;
                $data8['balance']             = $balance;
                $data8['description']         = $details;
                $this->db->where('bank_transfer_id', $tra['bank_transfer_id']);
                $query = $this->db->update('bank_transfer', $data8);

                /* $mensaje = "Ha actualizado la transferencia bancaria con id: ".$tra['bank_transfer_id'].", con la información: ".json_encode($data8).".";
                $this->binnacle($mensaje, "bank_transfer", $tra['bank_transfer_id']); */
            } else {
                $transfer = $amount;
                $balance = $bank['balance'] - $transfer;
                $data9['type']                = 0;
                $data9['move']                = $move['move'];
                $data9['code']                = $this->randCode("BT-");
                $data9['reference_table']     = "departure";
                $data9['reference_id']        = $departure_id;
                $data9['reference_detail_id'] = $detail_id;
                $data9['bank_account_id']     = $bank_account_id;
                $data9['date']                = $date;
                $data9['datetime']            = $fechaHora;
                $data9['amount']              = $transfer;
                $data9['balance']             = $balance;
                $data9['description']         = $details;
                $this->db->insert('bank_transfer', $data9);
                $bank_transfer_id = $this->db->insert_id();

                /* $mensaje = "Ha creado una transferencia bancaria con id: $bank_transfer_id, con la información: ".json_encode($data9).".";
                $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id); */

                $data10['balance'] = $balance;
                $this->db->where('bank_account_id', $bank['bank_account_id']);
                $query = $this->db->update('bank_account', $data10);

                /* $mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: ".$bank['bank_account_id'].", al saldo: $balance.";
                $this->binnacle($mensaje, "bank_account", $bank['bank_account_id']); */
                
                $first = $this->getAccountBank($tra['bank_account_id']);
                if($tra['type']) $data11['balance'] = $first['balance'] - $tra['amount'];
                else $data11['balance'] = $first['balance'] + $tra['amount'];
                $this->db->where('bank_account_id', $tra['bank_account_id']);
                $query = $this->db->update('bank_account', $data11);

                /* $mensaje = "Ha modificado el balance de la cuenta bancaria con id: ".$tra['bank_account_id'].", con nuevo balance de: ".$data11['balance'].".";
                $this->binnacle($mensaje, "bank_account", $tra['bank_account_id']); */
            }
        } else {
            $transfer = $amount;
            $balance = $bank['balance'] - $transfer;
            $data12['type']                = 1;
            $data12['move']                = $move['move'];
            $data12['code']                = $this->randCode("BT-");
            $data12['reference_table']     = "departure";
            $data12['reference_id']        = $departure_id;
            $data12['reference_detail_id'] = $detail_id;
            $data12['bank_account_id']     = $bank_account_id;
            $data12['date']                = $date;
            $data12['datetime']            = $fechaHora;
            $data12['amount']              = $transfer;
            $data12['balance']             = $balance;
            $data12['description']         = $details;
            $data12['adjust']              = $adjust;
            $this->db->insert('bank_transfer', $data12);
            $bank_transfer_id = $this->db->insert_id();

            /* $mensaje = "Ha creado una transferencia bancaria con id: $bank_transfer_id, con la información: ".json_encode($data23).".";
            $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id); */

            $data13['balance'] = $balance;
            $this->db->where('bank_account_id', $bank['bank_account_id']);
            $query = $this->db->update('bank_account', $data13);

            /* $mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: ".$bank['bank_account_id'].", al saldo: $balance.";
            $this->binnacle($mensaje, "bank_account", $bank['bank_account_id']); */
            
            $first = $this->getAccountBank($tra['bank_account_id']);
            if($tra['type']) $data14['balance'] = $first['balance'] - $tra['amount'];
            else $data14['balance'] = $first['balance'] + $tra['amount'];
            $this->db->where('bank_account_id', $tra['bank_account_id']);
            $query = $this->db->update('bank_account', $data14);

            /* $mensaje = "Ha modificado el balance de la cuenta bancaria con id: ".$tra['bank_account_id'].", con nuevo balance de: ".$data14['balance'].".";
            $this->binnacle($mensaje, "bank_account", $tra['bank_account_id']); */
        }
            
        return $query;
    }

    function deactivateBankCheck()
    {
        $bank_check_id = base64_decode($this->input->post('id'));
        $data['status'] = 0;
        $this->db->where('bank_check_id', $bank_check_id);
        $query = $this->db->update('bank_check', $data);
        
        /* $mensaje = "Ha desactivado el cheque bancario con id: $bank_check_id.";
        $this->binnacle($mensaje, "bank_check", $bank_check_id); */

        $check = $this->getBankCheck($bank_check_id);
        if ($check['departure_id'] != '') {
            $this->deactivateDeparture($check['departure_id']);
        }
        
        echo $query;
    }

    function activateBankCheck()
    {
        $bank_check_id = base64_decode($this->input->post('id'));
        $data['status'] = 1;
        $this->db->where('bank_check_id', $bank_check_id);
        $query = $this->db->update('bank_check', $data);
        
        /* $mensaje = "Ha activado el cheque bancario con id: $bank_check_id.";
        $this->binnacle($mensaje, "bank_check", $bank_check_id); */

        echo $query;
    }

    function deleteBankCheck()
    {
        $bank_check_id = base64_decode($this->input->post('id'));
        $this->db->where('bank_check_id', $bank_check_id);
        $query = $this->db->delete('bank_check');

        /* $mensaje = "Ha eliminado el cheque bancario con id: $bank_check_id.";
        $this->binnacle($mensaje, "bank_check", $bank_check_id); */

        echo $query;
    }
    
    function anulateBankCheck()
    {
        $results = array();
        $bank_check_id = base64_decode($this->input->post('id'));
        $data['status'] = 0;
        $this->db->where('bank_check_id', $bank_check_id);
        $query = $this->db->update('bank_check', $data);
        array_push($results, $query);
        
        /* $mensaje = "Ha anulado el cheque bancario con id: $bank_check_id.";
        $this->binnacle($mensaje, "bank_check", $bank_check_id); 
        
        $policy_detail_id = $this->db->query("SELECT * FROM policy_detail WHERE bank_check_id = '$bank_check_id' AND status = 1")->row()->policy_detail_id;
        if ($policy_detail_id != '') {
            $this->db->where('bank_check_id', $bank_check_id);
            $query = $this->db->update('policy_detail', $data);
            array_push($results, $query);
            
            $mensaje = "Ha anulado el detalle de poliza con id: $policy_detail_id.";
            $this->binnacle($mensaje, "policy_detail", $policy_detail_id);
        } */

        echo json_encode($results);
    }

    function newBankAccount()
    {
        $property = $this->input->post('property');
        if ($property == 1) $data['nomenclature_id'] = $this->input->post('nomenclature_id');
        elseif ($property == 2) $data['nomenclature_id'] = null;
        $data['code']            = $this->input->post('code');
        $data['name']            = $this->input->post('name');
        $data['bank_id']         = $this->input->post('bank_id');
        $data['account_type_id'] = $this->input->post('account_type_id');
        $data['currency_id']     = $this->input->post('currency_id');
        $data['property']        = $property;
        $this->db->insert('bank_account', $data);
        $bank_account_id = $this->db->insert_id();
        
        /* $mensaje = "Ha creado la cuenta bancaria con id: $bank_account_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "bank_account", $bank_account_id); */

        return $bank_account_id;
    }

    function editBankAccount()
    {
        $bank_account_id         = $this->input->post('bank_account_id');
        $property = $this->input->post('property_edit');
        if ($property == 1) $data['nomenclature_id'] = $this->input->post('nomenclature_id');
        elseif ($property == 2) $data['nomenclature_id'] = null;
        $data['code']            = $this->input->post('code');
        $data['name']            = $this->input->post('name');
        $data['bank_id']         = $this->input->post('bank_id');
        $data['account_type_id'] = $this->input->post('account_type_id');
        $data['currency_id']     = $this->input->post('currency_id');
        $data['balance']         = $this->input->post('balance');
        $data['property']        = $property;
        $this->db->where('bank_account_id', $bank_account_id);
        $query = $this->db->update('bank_account', $data);
        
        /* $mensaje = "Ha actualizado la cuenta bancaria con id: $bank_account_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "bank_account", $bank_account_id); */

        return $query;
    }

    function deactivateBankAccount()
    {
        $bank_account_id = base64_decode($this->input->post('id'));
        $data['status'] = 0;
        $this->db->where('bank_account_id', $bank_account_id);
        $query = $this->db->update('bank_account', $data);
        
        /* $mensaje = "Ha desactivado la cuenta bancaria con id: $bank_account_id.";
        $this->binnacle($mensaje, "bank_account", $bank_account_id); */

        echo $query;
    }

    function activateBankAccount()
    {
        $bank_account_id = base64_decode($this->input->post('id'));
        $data['status'] = 1;
        $this->db->where('bank_account_id', $bank_account_id);
        $query = $this->db->update('bank_account', $data);
        
        /* $mensaje = "Ha activado la cuenta bancaria con id: $bank_account_id.";
        $this->binnacle($mensaje, "bank_account", $bank_account_id); */

        echo $query;
    }

    function deleteBankAccount()
    {
        $bank_account_id = base64_decode($this->input->post('id'));
        $this->db->where('bank_account_id', $bank_account_id);
        $query = $this->db->delete('bank_account');
        
        /* $mensaje = "Ha eliminado la cuenta bancaria con id: $bank_account_id.";
        $this->binnacle($mensaje, "bank_account", $bank_account_id); */

        echo $query;
    }
    
    function newAccountType()
    {
        $data['name']        = $this->input->post('name');
        $data['description'] = trim($this->input->post('description'));
        $this->db->insert('account_type', $data);
        $account_type_id = $this->db->insert_id();
        
        /* $mensaje = "Ha creado el tipo de cuenta bancaria con id: $account_type_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "account_type", $account_type_id); */

        return $account_type_id;
    }

    function editAccountType()
    {
        $account_type_id     = $this->input->post('account_type_id');
        $data['name']        = $this->input->post('name');
        $data['description'] = trim($this->input->post('description'));
        $this->db->where('account_type_id', $account_type_id);
        $this->db->update('account_type', $data);
        $account_type_id = $this->db->insert_id();
        
        /* $mensaje = "Ha actualizado el tipo de cuenta bancaria con id: $account_type_id, con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "account_type", $account_type_id); */

        return $account_type_id;
    }

    function deactivateAccountType()
    {
        $account_type_id = base64_decode($this->input->post('id'));
        $data['status']  = 0;
        $this->db->where('account_type_id', $account_type_id);
        $query = $this->db->update('account_type', $data);
        
        /* $mensaje = "Ha desactivado el tipo de cuenta bancaria con id: $account_type_id.";
        $this->binnacle($mensaje, "account_type", $account_type_id); */

        echo $query;
    }

    function activateAccountType()
    {
        $account_type_id = base64_decode($this->input->post('id'));
        $data['status']  = 1;
        $this->db->where('account_type_id', $account_type_id);
        $query = $this->db->update('account_type', $data);
        
        /* $mensaje = "Ha activado el tipo de cuenta bancaria con id: $account_type_id.";
        $this->binnacle($mensaje, "account_type", $account_type_id); */

        echo $query;
    }

    function deleteAccountType()
    {
        $account_type_id = base64_decode($this->input->post('id'));
        $this->db->where('account_type_id', $account_type_id);
        $query = $this->db->delete('account_type');
        
        /* $mensaje = "Ha eliminado el tipo de cuenta bancaria con id: $account_type_id.";
        $this->binnacle($mensaje, "account_type", $account_type_id); */

        echo $query;
    }
    
    function newTransfer()
    {
        $fechaHora = date("Y-m-d H:i:s");
        $amount = $this->input->post('amount');
        $source_id = $this->input->post('source_account');
        $property = $this->input->post('property');
        $acc = $this->getBankAccount($source_id);
        $balance = $acc['balance'] - $amount;

        $destiny_id = $this->input->post('destiny_account');

        $data['code']             = $this->randCode("BT-");
        $data['bank_account_id']  = $source_id;
        $data['date']             = date("Y-m-d");
        $data['datetime']         = $fechaHora;
        $data['amount']           = $amount;
        $data['balance']          = $balance;
        $data['type']             = 0;
        $data['move']             = 21;
        $data['description']      = trim($this->input->post('description'));
        $data['other_account_id'] = $destiny_id;
        $this->db->insert('bank_transfer', $data);
        $bank_transfer_id = $this->db->insert_id();

        /* $mensaje = "Ha creado la transferencia bancaria con id: $bank_transfer_id con la información: ".json_encode($data).".";
        $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id); */

        $data2['balance'] = $balance;
        $this->db->where('bank_account_id', $source_id);
        $query = $this->db->update('bank_account', $data2); 
        
        /* $mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: $source_id, al saldo: $balance.";
        $this->binnacle($mensaje, "bank_account", $source_id); */

        if ($property == 1) {
            $acc = $this->getBankAccount($destiny_id);
            $balance = $acc['balance'] + $amount;
            $data['code']             = $this->randCode("BT-");
            $data['bank_account_id']  = $destiny_id;
            $data['balance']          = $balance;
            $data['type']             = 1;
            $data['move']             = 10;
            $data['other_account_id'] = $source_id;
            $data['description']      = trim($this->input->post('description'));
            $this->db->insert('bank_transfer', $data);
            $bank_transfer_id = $this->db->insert_id();
    
            /* $mensaje = "Ha creado la transferencia bancaria con id: $bank_transfer_id con la información: ".json_encode($data).".";
            $this->binnacle($mensaje, "bank_transfer", $bank_transfer_id); */
    
            $data2['balance'] = $balance;
            $this->db->where('bank_account_id', $destiny_id);
            $query = $this->db->update('bank_account', $data2);
            
            /* $mensaje = "Ha actualizado el saldo de la cuenta bancaria con id: $destiny_id, al saldo: $balance.";
            $this->binnacle($mensaje, "bank_account", $destiny_id); */
        }
    }
    
    function getUtilityStatement($initial, $final)
    {
        //log_message("error", "Inicio en Balance General");
        $income = 0; $expense = 0; $hoy = strtotime(date("Y-m-d")); $legal = 0;
        $merc = 0; $totalMerc = 0; $oper = 0; $admin = 0; $fina = 0; $prod = 0; $gast = 0;
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '4.01.01.001' OR code = '4.01.01.002' OR code = '4.02.01.001')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 4);
            $ventas += $total;
            $income += $total;
        }
        //log_message("error", "Ven Netas: $income");
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '5.01.01.001' OR code = '5.01.01.002' OR code = '5.01.01.003' OR code = '5.01.01.006')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 5);
            $merc += $total;
        }
        //log_message("error", "Merc: $merc");
        /*if (strtotime($final) < $hoy) $total = $this->getTotalInventory($final);
        else $total = $this->getTotalInventory();*/
        //log_message("error", "Inv Final: $total");
        if ($merc > $total) $totalMerc = $merc - $total;
        else $totalMerc = $total - $merc;
        //log_message("error", "totalMerc: $totalMerc");
        $total = $income - $totalMerc;
        //log_message("error", "Merc: $total");
        $expense += $totalMerc;
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '5.02.01.002' OR code = '5.02.01.003' OR code = '5.02.01.004' OR code = '5.02.01.005' OR code = '5.02.01.006' OR code = '5.02.01.007' OR code = '5.02.01.008' OR code = '5.02.01.009' OR code = '5.02.01.010' OR code = '5.02.01.011' OR code = '5.02.01.012' OR code = '5.02.01.013' OR code = '5.02.01.014' OR code = '5.02.01.015' OR code = '5.02.01.016' OR code = '5.02.01.017' OR code = '5.02.01.018' OR code = '5.02.01.019' OR code = '5.02.01.020' OR code = '5.02.01.021')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 5);
            $oper += $total;
            $expense += $total;
        }
        //log_message("error", "Oper: $oper");
        $margen = $income - $expense;
        //log_message("error", "Margen: $margen");
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '5.02.01.024' OR code = '5.02.01.025' OR code = '5.02.01.026' OR code = '5.02.01.027' OR code = '5.02.01.028')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 5);
            $admin += $total;
            $expense += $total;
        }
        //log_message("error", "Admin: $admin");
        $margen = $income - $expense;
        //log_message("error", "Margen: $margen");
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '5.03.01.001' OR code = '5.03.01.002' OR code = '5.03.01.003' OR code = '5.03.01.004' OR code = '5.03.01.005')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 5);
            $fina += $total;
            $expense += $total;
        }
        //log_message("error", "Fina: $fina");
        $nom = $this->db->query("SELECT * FROM nomenclature WHERE status = 1 AND (code = '5.04.01.001' OR code = '5.04.01.002')")->result_array();
        foreach ($nom as $n) {
            $total = $this->getTotalYearNom($n['nomenclature_id'], $initial, $final, 5);
            $prod += $total;
            $expense -= $total;
        }
        //log_message("error", "Prod: $prod");
        $gast = $fina - $prod;
        //log_message("error", "Gast: $gast");
        $rest = $income - $expense;
        $gros = $rest;
        //log_message("error", "Util: $rest");
        if($rest > 0) $legal = $rest * 0.05;
        //log_message("error", "Legal: $legal");
        $rest -= $legal;
        //log_message("error", "Util: $rest");
        return number_format($rest,2,".","");
    }

    function getUtilityValues($initial, $final)
    {
        $ingresos = $this->getIncomeStatement();
        $egresos = $this->getExpenseStatement();
        $totalIngresos = 0; $totalEgresos = 0; $gross = 0; $legal = 0; $net = 0;
        foreach ($ingresos->result_array() as $in) {
            $cuentas = $this->getNomenStatement($in['heading_type_id'], $in['heading_id'], $in['group_account_id']);
            foreach ($cuentas->result_array() as $ct){
                $total = $this->getTotalYearNom($ct['nomenclature_id'], $initial, $final, $in['init_code']);
                $totalIngresos += $total;
            }
        }
        foreach($egresos->result_array() as $eg) {
            $cuentas = $this->getNomenStatement($eg['heading_type_id'], $eg['heading_id'], $eg['group_account_id']);
            foreach ($cuentas->result_array() as $ct) {
                $name_low = strtolower($ct['name']);
                if(!(strpos($name_low, "utilidad") !== false)) { 
                    $total = $this->getTotalYearNom($ct['nomenclature_id'], $initial, $final, $eg['init_code']);
                    $totalEgresos += $total;
                }
            }
        }
        $gross = $totalIngresos - $totalEgresos;
        if ($gross > 0) {
            $legal = $gross * 0.05;
            $net = $gross - $legal;
        }
        return array("gross"=>$gross, "legal"=>$legal, "net"=>$net);
    }

    function getUtilityStatementJson()
    {
        setlocale(LC_TIME,"es_ES");
        $initial = $this->input->post('initial');
        $final = $this->input->post('final');
        $restante = $this->getUtilityStatement($initial, $final);
        $format = '';
        if ($restante < 0) $format .= '-'; $format .= "Q.".number_format(abs($restante),2,".",",");
        $in = strtoupper(strftime("%d de %B del %Y", strtotime($initial)));
        $fn = strtoupper(strftime("%d de %B del %Y", strtotime($final)));
        echo json_encode(array("format"=>$format, "amount"=>$restante, "initial"=>$in, "final"=>$fn));
    }

    function getAccountByBankName($name)
    {
        return $this->db->query("SELECT a.* FROM bank_account AS a INNER JOIN bank AS b ON a.bank_id = b.bank_id WHERE b.name = '$name' AND b.status = 1 AND a.status = 1");
    }
    
    function getAccountsBankNomen() {
        return $this->db->query("SELECT a.*, b.name AS bank FROM bank_account AS a INNER JOIN bank AS b ON a.bank_id = b.bank_id INNER JOIN nomenclature AS n ON a.nomenclature_id = n.nomenclature_id WHERE a.status = 1 AND n.status = 1");
    }

    function getTransferByData($table, $ref_id, $bank_id)
    {
        return $this->db->query("SELECT * FROM bank_transfer WHERE reference_table = '$table' AND reference_id = '$ref_id' AND bank_account_id = '$bank_id' AND status = 1 ORDER BY bank_transfer_id DESC LIMIT 1")->row_array();
    }
    
    function getTransferByReference($table, $id) {
        return $this->db->get_where("bank_transfer", array("reference_table"=>$table, "reference_id"=>$id, "status"=>1))->row_array();
    }
    
    function getTransferByDetail($table, $ref_id, $detail_id) {
        return $this->db->query("SELECT * FROM bank_transfer WHERE reference_table = '$table' AND reference_id = '$ref_id' AND reference_detail_id = '$detail_id' AND status = 1 ORDER BY bank_transfer_id DESC LIMIT 1")->row_array();
    }
   
    function getTotalInventoryStatement($date = '')
    {
        //log_message("error", "Fecha: $date");
        $total = 0;
        /* $multiple_cellar = $this->getInfo("multiple_cellar");
        $cellars_inventory = $this->getInfo("cellars_inventory");
        //log_message("error", "multiple_cellar: $multiple_cellar, cellars_inventory: $cellars_inventory");
        if ($multiple_cellar && isset($cellars_inventory)) {
            //log_message("error", "Bodegas");
            $ids = implode(',', json_decode($cellars_inventory));
            $query = "SELECT * FROM product WHERE type = 'B' AND inventory = 1 AND cellar_id IN ($ids) AND status = 1";
        } else {
            //log_message("error", "Todos");
            $query = "SELECT * FROM product WHERE type = 'B' AND inventory = 1 AND status = 1";
        }
        $prods = $this->db->query($query)->result_array();
        foreach ($prods as $pd) {
            $prod_id = $pd['product_id'];
            $stock = $this->getStockProduct($pd['product_id'], $date);
            $cost = $this->getLastPrice($pd['product_id'], $date);
            //log_message("error", "Prod: ".$pd['code'].", Stock: $stock, Costo $cost");
            $subtotal = abs($stock) * $cost;
            $total += $subtotal;
            //log_message("error", "Prod: ".$pd['code']." - ".$pd['name'].", Stock: $stock, Cost: $cost, Subtotal: $subtotal");
        } */
        //log_message("error", "Total: $total");
        return $total;
    }
 
    function getTotalInventory($date = '')
    {
        //log_message("error", "Fecha: $date");
        $total = 0;
        /* $multiple_cellar = $this->getInfo("multiple_cellar");
        $cellars_inventory = $this->getInfo("cellars_inventory");
        //log_message("error", "multiple_cellar: $multiple_cellar, cellars_inventory: $cellars_inventory");
        if ($multiple_cellar && isset($cellars_inventory)) {
            //log_message("error", "Bodegas");
            $ids = implode(',', json_decode($cellars_inventory));
            $query = "SELECT * FROM product WHERE type = 'B' AND inventory = 1 AND cellar_id IN ($ids) AND status = 1";
        } else {
            //log_message("error", "Todos");
            $query = "SELECT * FROM product WHERE type = 'B' AND inventory = 1 AND status = 1";
        }
        $prods = $this->db->query($query)->result_array();
        foreach ($prods as $pd) {
            $prod_id = $pd['product_id'];
            $stock = $this->getStockProduct($pd['product_id'], $date);
            $cost = $this->getLastPrice($pd['product_id'], $date);
            //log_message("error", "Prod: ".$pd['code'].", Stock: $stock, Costo $cost");
            $subtotal = abs($stock) * $cost;
            $total += $subtotal;
            //log_message("error", "Prod: ".$pd['code']." - ".$pd['name'].", Stock: $stock, Cost: $cost, Subtotal: $subtotal");
        } */
        //log_message("error", "Total: $total");
        return $total;
    }

    function getTotalYearCloseFinalInventory($initial, $final)
    {
        $inv = 0; $hoy = date("Y-m-d"); $total = 0;
        if (strtotime($final) < strtotime($hoy)) $inv = $this->getTotalInventory($final);
        else $inv = $this->getTotalInventory();
        $nom = $this->getNomenByCode("5.01.01.006");
        $dev = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4);
        $total = $inv + $dev;
        return $total;
    }

    function getInitialInventory($date)
    {
        $total = 0;
        /* $prods = $this->db->query("SELECT * FROM product WHERE type = 'B' AND inventory = 1 AND status = 1")->result_array();
        foreach ($prods as $pd) {
            $prod_id = $pd['product_id'];
            $stock = $this->getStockAntProduct($pd['product_id'], $date);
            $cost = $this->getLastPrice($pd['product_id'], $date);
            $subtotal = abs($stock) * $cost;
            $total += $subtotal;
            //log_message("error", "Prod: ".$pd['code']." - ".$pd['name'].", Stock: $stock, Cost: $cost, Subtotal: $subtotal");
        } */
        //log_message("error", "Total: $total");
        return $total;
    }

    function getTotalYearClosePL($initial, $final)
    {
        $total = 0;
        for ($i=2; $i <= 21; $i++) { 
            $idx = $this->correlativeCode($i, null, 2);
            $nom = $this->getNomenByCode("5.02.01.0$idx");
            $cant = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
            $total += $cant;
        }
        for ($i=11; $i <= 15; $i++) { 
            $nom = $this->getNomenByCode("5.03.01.0$i");
            $cant = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
            $total += $cant;
        }
        for ($i=24; $i <= 28; $i++) { 
            $nom = $this->getNomenByCode("5.02.01.0$i");
            $cant = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
            $total += $cant;
        }
        for ($i=1; $i <= 5; $i++) { 
            $nom = $this->getNomenByCode("5.03.01.00$i");
            $cant = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
            $total += $cant;
        }
        for ($i=1; $i <= 2; $i++) { 
            $nom = $this->getNomenByCode("5.04.01.00$i");
            $cant = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
            $total += $cant;
        }
        return $total;
    }

    function getTotalYearCloseCash($initial, $final)
    {
        $total = 0;
        $cashes = $this->getCashNomen();
        $petty = $this->getPettyCash();
        foreach ($cashes->result_array() as $ch) {
            $cant = $this->getTotalYearNom($ch['nomenclature_id'], $initial, $final, 1);
            $total += $cant;
        }
        foreach ($petty->result_array() as $ch) {
            $cant = $this->getTotalYearNom($ch['nomenclature_id'], $initial, $final, 1);
            $total += $cant;
        }
        return $total;
    }

    function getClientSearchAjax()
    {
        $id = $this->input->post('id');
        $cf = $this->input->post('cf');
        $search = $this->input->post('searchTerm');
        // log_message("error", "Id: $id, cf: $cf, search: $search");
        if (!isset($search) || $search == '') {
            if ($id == '' || $id == 'T') $query = "SELECT * FROM client WHERE status = 1 ORDER BY client_id ASC LIMIT 5";
            else $query = "SELECT * FROM client WHERE status = 1 AND client_id != '$id' ORDER BY client_id ASC LIMIT 5";
        } else {
            if ($id == '' || $id == 'T') $query = "SELECT * FROM client WHERE status = 1 AND CONCAT_WS(' ', nit, first_name, last_name) LIKE '%$search%' ORDER BY client_id ASC";
            else $query = "SELECT * FROM client WHERE client_id != '$id' AND status = 1 AND CONCAT_WS(' ', nit, first_name, last_name) LIKE '%$search%' ORDER BY client_id ASC";
        }
        $response = array();
        $response[] = array("id"=>"T", "text"=>"Todos", "selected"=>($id == '' || $id == 'T')?true:false);
        if ($cf != 'no') $response[] = array("id"=>"0", "text"=>"Consumidor Final", "selected"=>($id == 0)?true:false);
        if ($id != '' && $id != 'T' && $id != 0) {
            $clien = $this->getClient($id);
            $response[] = array(
                "id" => $id,
                "text" => $clien['nit'].' - '.$clien['first_name'].' '.$clien['last_name'],
                "selected" => true,
            );
        }
        $data = $this->db->query($query)->result_array();
        foreach ($data as $cl) {
            $response[] = array(
                "id" => $cl['client_id'],
                "text" => $cl['nit'].' - '.$cl['first_name'].' '.$cl['last_name'],
                "selected" => false,
            );
        }
        echo json_encode($response);
    }

    function getBanks() {
        return $this->db->get("bank");
    }
    
    function getBank($bank_id)
    {
        return $this->db->get_where("bank", array("bank_id"=>$bank_id))->row_array();
    } 

    function getBanksAccounts($property) {
        return $this->db->get_where("bank_account", array("property"=>$property));
    }
    
    function getCurrency($currency_id)
    {
        return $this->db->get_where("currency", array("currency_id"=>$currency_id))->row_array();
    }
    
    function getCurrencies() {
        return $this->db->get("currency");
    }
    
    function getCurrenciesActive()
    {
        return $this->db->get_where("currency", array("status"=>1));
    }

    function getBanksActive()
    {
        return $this->db->get_where("bank", array("status"=>1));
    }

    function getAccountType($type_id)
    {
        return $this->db->get_where("account_type", array("account_type_id"=>$type_id))->row_array();
    }

    function getAccountTypes()
    {
        return $this->db->get("account_type");
    }

    function getAccountTypesActive()
    {
        return $this->db->get_where("account_type", array("status"=>1));
    }

    function getBankAccount($account_id)
    {
        return $this->db->get_where("bank_account", array("bank_account_id"=>$account_id))->row_array();
    }

    function countAccountByNomenExist($nomen_id, $account_id)
    {
        echo $this->db->query("SELECT COUNT(bank_account_id) AS total FROM bank_account WHERE bank_account_id != '$account_id' AND nomenclature_id = '$nomen_id' AND status = 1")->row()->total;
    }

    function countTransferByReference($table, $id, $detail_id)
    {
        return $this->db->query("SELECT COUNT(bank_transfer_id) AS total FROM bank_transfer WHERE reference_table = '$table' AND reference_id = '$id' AND reference_detail_id = '$detail_id' AND status = 1")->row()->total;
    }

    function getBankTransfer($transfer_id) {
        return $this->db->get_where("bank_transfer", array("bank_transfer_id"=>$transfer_id))->row_array();
    }

    function getBankTransfers($initial, $final, $account_id = '')
    {
        if ($account_id != '') {
            $data = $this->db->query("SELECT * FROM bank_transfer WHERE bank_account_id = '$account_id' AND DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND status = 1 ORDER BY date DESC, bank_transfer_id DESC");
        } else {
            $data = $this->db->query("SELECT * FROM bank_transfer WHERE DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') AND status = 1 ORDER BY date DESC, bank_transfer_id DESC");
        }
        return $data;
    }

    function getBankTransferByDetail($table, $reference_id, $reference_detail_id) {
        return $this->db->get_where("bank_transfer", array("reference_table"=>$table, "reference_id"=>$reference_id, "reference_detail_id"=>$reference_detail_id))->row_array();
    }

    function getBanksNomen()
    {
        return $this->db->query("SELECT * FROM nomenclature WHERE name LIKE '%banco%' AND status = 1");
    }

    function getBankChecksFilters($initial, $final, $account_id = '')
    {
        $query = "SELECT * FROM bank_check WHERE DATE(date) >= DATE('$initial') AND DATE(date) <= DATE('$final') ";
        if ($account_id != '') $query .= "AND bank_account_id = '$account_id' ";
        $query .= "ORDER BY date DESC, bank_check_id DESC";
        return $this->db->query($query);
    }

    function getBankChecksActive()
    {
        return $this->db->get_where("bank_check", array("status"=>1));
    }

    function getBankCheck($bank_check_id)
    {
        return $this->db->get_where("bank_check", array("bank_check_id"=>$bank_check_id))->row_array();
    }

    function verifyNoCheck()
    {
        $id = $this->input->post('id');
        $no = $this->input->post('no');
        $exist = $this->db->query("SELECT COUNT(bank_check_id) AS total FROM bank_check WHERE bank_account_id = '$id' AND no_check = '$no' AND status = 1")->row()->total;
        echo json_encode(array("exist"=>$exist));
    }
    
    function verifyNoCheckEdit()
    {
        $id = $this->input->post('id');
        $account_id = $this->input->post('account_id');
        $no = $this->input->post('no');
        $exist = $this->db->query("SELECT COUNT(bank_check_id) AS total FROM bank_check WHERE bank_check_id != '$id' AND bank_account_id = '$account_id' AND no_check = '$no' AND status = 1")->row()->total;
        echo json_encode(array("exist"=>$exist));
    }

    function getOtherBankAccounts()
    {
        $id = $this->input->post('id');
        $property = $this->input->post('property');
        $accounts = $this->db->get_where("bank_account", array("bank_account_id !="=>$id, "status"=>1, "property"=>$property))->result_array();
        $select = '<option value="">Selecciona un cuenta diferente</option>';
        foreach ($accounts as $ac) {
            $select .= '<option value="'.$ac['bank_account_id'].'">'.$ac['code'].' '.$ac['name'].'</option>';
        }
        echo json_encode(array("select"=>$select));
    }

    function checkBalanceBankAccount()
    {
        $id = $this->input->post('id');
        $amount = $this->input->post('amount');
        $acc = $this->getBankAccount($id);
        $check = 0;
        if($acc['balance'] >= $amount) $check = 1;

        echo json_encode(array("check"=>$check, "balance"=>"Q.".number_format($acc['balance'],2,".",",")));
    }

    function getIncomeStatement()
    {
        return $this->db->query("SELECT g.*, t.code AS init_code FROM heading_type AS t INNER JOIN heading AS h ON t.heading_type_id = h.heading_type_id INNER JOIN group_account AS g ON g.heading_id = h.heading_id WHERE t.name LIKE '%ingreso%' AND t.status = 1 AND h.status = 1 AND g.status = 1");
    }

    function getExpenseStatement()
    {
        return $this->db->query("SELECT g.*, t.code AS init_code FROM heading_type AS t INNER JOIN heading AS h ON t.heading_type_id = h.heading_type_id INNER JOIN group_account AS g ON g.heading_id = h.heading_id WHERE t.name LIKE '%egreso%' AND g.name NOT LIKE '%ingreso%' AND t.status = 1 AND h.status = 1 AND g.status = 1");
    }

    function printConciliationPDF()
    {
        $id = $this->input->post('id');
        if($id == '') $this->insertBankConciliation();
        $hoy = date("Y-m-d-H-i-s");
        $data['bank_account_id']       = $this->input->post('bank_account_id');
        $data['initial']               = $this->input->post('initial');
        $data['final']                 = $this->input->post('final');
        $data['balance_ledge']         = $this->input->post('balance_ledge');
        $data['note_credit']           = $this->input->post('note_credit');
        $data['amount_credit']         = $this->input->post('amount_credit');
        $data['total_note_credit']     = $this->input->post('total_note_credit');
        $data['subtotal_note_credit']  = $this->input->post('subtotal_note_credit');
        $data['note_debit']            = $this->input->post('note_debit');
        $data['amount_debit']          = $this->input->post('amount_debit');
        $data['total_note_debit']      = $this->input->post('total_note_debit');
        $data['subtotal_note_debit']   = $this->input->post('subtotal_note_debit');
        $data['balance_1']             = $this->input->post('balance_1');
        $data['balance_account']       = $this->input->post('balance_account');
        $data['note_check']            = $this->input->post('note_check');
        $data['amount_check']          = $this->input->post('amount_check');
        $data['total_bank_check']      = $this->input->post('total_bank_check');
        $data['subtotal_bank_check']   = $this->input->post('subtotal_bank_check');
        $data['note_deposit']          = $this->input->post('note_deposit');
        $data['amount_deposit']        = $this->input->post('amount_deposit');
        $data['total_bank_deposit']    = $this->input->post('total_bank_deposit');
        $data['subtotal_bank_deposit'] = $this->input->post('subtotal_bank_deposit');
        $data['balance_2']             = $this->input->post('balance_2');
        $data['elaborate_name']        = $this->input->post('elaborate_name');
        $data['elaborate_charge']      = $this->input->post('elaborate_charge');
        $data['approve_name']          = $this->input->post('approve_name');
        $data['approve_charge']        = $this->input->post('approve_charge');
        $data['check_name']            = $this->input->post('check_name');
        $data['check_charge']          = $this->input->post('check_charge');
        $html = $this->load->view('backend/viewspdf/bank_conciliation.php',$data,TRUE); 
        $pdfFilePath = "conciliacion-bancaria-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Letter'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printCashFlowPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial']            = $this->input->post('initial');
        $data['final']              = $this->input->post('final');
        $data['utility']            = $this->input->post('utility');
        $data['no_moves']           = $this->input->post('no_moves');
        $data['note_operation']     = $this->input->post('note_operation');
        $data['amount_operation']   = $this->input->post('amount_operation');
        $data['subtotal_operation'] = $this->input->post('subtotal_operation');
        $data['note_invest']        = $this->input->post('note_invest');
        $data['amount_invest']      = $this->input->post('amount_invest');
        $data['subtotal_invest']    = $this->input->post('subtotal_invest');
        $data['note_finance']       = $this->input->post('note_finance');
        $data['amount_finance']     = $this->input->post('amount_finance');
        $data['subtotal_finance']   = $this->input->post('subtotal_finance');
        $data['total_activities']   = $this->input->post('total_activities');
        $data['check_equals']       = $this->input->post('check_equals');
        $data['increase']           = $this->input->post('increase');
        $data['equal_initial']      = $this->input->post('equal_initial');
        $data['equal_final']        = $this->input->post('equal_final');
        $data['description']        = $this->input->post('description');
        $data['legal_name']         = $this->input->post('legal_name');
        $data['legal_charge']       = $this->input->post('legal_charge');
        $data['account_name']       = $this->input->post('account_name');
        $data['account_charge']     = $this->input->post('account_charge');
        $html = $this->load->view('backend/viewspdf/cash_flow.php',$data,TRUE); 
        $pdfFilePath = "flujo-de-efectivo-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Letter'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printGeneralPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial']        = $this->input->post('initial');
        $data['final']          = $this->input->post('final');
        $data['description']    = trim($this->input->post('description'));
        $data['legal_name']     = $this->input->post('legal_name');
        $data['legal_charge']   = $this->input->post('legal_charge');
        $data['account_name']   = $this->input->post('account_name');
        $data['account_charge'] = $this->input->post('account_charge');
        $html = $this->load->view('backend/viewspdf/general.php',$data,TRUE); 
        $pdfFilePath = "balance-general-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Legal'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printStatementPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial']        = $this->input->post('initial');
        $data['final']          = $this->input->post('final');
        $data['description']    = trim($this->input->post('description'));
        $data['legal_name']     = $this->input->post('legal_name');
        $data['legal_charge']   = $this->input->post('legal_charge');
        $data['account_name']   = $this->input->post('account_name');
        $data['account_charge'] = $this->input->post('account_charge');
        $html = $this->load->view('backend/viewspdf/statement.php',$data,TRUE); 
        $pdfFilePath = "estado-de-resultados-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Legal'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printJournalPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial'] = $this->input->post('initial');
        $data['final']   = $this->input->post('final');
        $data['nom_id']  = $this->input->post('nom_id');
        $html = $this->load->view('backend/viewspdf/journal.php',$data,TRUE); 
        $pdfFilePath = "libro-diario-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Letter'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printJournalPDFC()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial'] = $this->input->post('initial');
        $data['final']   = $this->input->post('final');
        $data['nom_id']  = $this->input->post('nom_id');
        $html = $this->load->view('backend/viewspdf/journal_consolidate_group.php',$data,TRUE); 
        $pdfFilePath = "libro-diario-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Letter'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printLedgerPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial']         = $this->input->post('initial');
        $data['final']           = $this->input->post('final');
        $data['nomenclature_id'] = $this->input->post('nomenclature_id');
        $html = $this->load->view('backend/viewspdf/ledger.php',$data,TRUE); 
        $pdfFilePath = "libro-mayor-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Letter'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printLedgerPDFC()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial']         = $this->input->post('initial');
        $data['final']           = $this->input->post('final');
        $data['nomenclature_id'] = $this->input->post('nomenclature_id');
        $html = $this->load->view('backend/viewspdf/ledger_consolidate.php',$data,TRUE); 
        $pdfFilePath = "libro-mayor-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Letter'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printPurchasingPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial']        = $this->input->post('initial');
        $data['final']          = $this->input->post('final');
        $data['institution_id'] = $this->input->post('institution_id');
        $data['camp']           = $this->input->post('camp');
        $data['text']           = $this->input->post('text');
        $html = $this->load->view('backend/viewspdf/purchasing.php',$data,TRUE); 
        $pdfFilePath = "libro-de-compras-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Legal-L'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printSalesBookPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial']        = $this->input->post('initial');
        $data['final']          = $this->input->post('final');
        $data['institution_id'] = $this->input->post('institution_id');
        $data['camp']           = $this->input->post('camp');
        $data['text']           = $this->input->post('text');
        $html = $this->load->view('backend/viewspdf/sales_book.php',$data,TRUE); 
        $pdfFilePath = "libro-de-ventas-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Legal-L'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printBankBookPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['account_id']     = $this->input->post('account_id');
        $data['initial']        = $this->input->post('initial');
        $data['final']          = $this->input->post('final');
        $data['maker_name']     = $this->input->post('maker_name');
        $data['maker_charge']   = $this->input->post('maker_charge');
        $data['approve_name']   = $this->input->post('approve_name');
        $data['approve_charge'] = $this->input->post('approve_charge');
        $html = $this->load->view('backend/viewspdf/bank_book.php',$data,TRUE); 
        $pdfFilePath = "libro-de-bancos-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Letter'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printPolicyPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $md5 = md5($hoy);

        $policy_id        = $this->input->post('policy_id');
        $data0['type']    = $this->input->post('type');
        $data0['concept'] = $this->input->post('concept');
        $data0['bank']    = $this->input->post('bank');
        if ($data0['bank'] == 1){
            $departure_id = $this->input->post('departure_id');
            $reference_bank = $this->input->post('reference_bank');
            $reference_id = $this->input->post('reference_id');
            $data0['reference_bank'] = $reference_bank;
            $data0['reference_id']   = $reference_id;

            if ($reference_bank == 'bank_transfer') {
                $data1['reference_table'] = "departure";
                $data1['reference_id'] = $departure_id;
            } elseif($reference_bank == 'bank_check') {
                $data1['departure_id']   = $departure_id;
            }
            $this->db->where($reference_bank."_id", $reference_id);
            $this->db->update($reference_bank, $data1);
            
            $tabla = '';
            if ($reference_bank == 'bank_transfer') $tabla = 'la transferencia bancaria';
            elseif ($reference_bank == 'bank_check') $tabla = 'el cheque bancario';

            /* $mensaje = "Ha actualizado $tabla con id: $reference_id, con la información: ".json_encode($data1).".";
            $this->binnacle($mensaje, $reference_bank, $reference_id); */

            if($reference_bank == 'bank_check') {
                $account_id = $this->input->post('account_id');
                $trans = $this->db->query("SELECT COUNT(bank_transfer_id) AS total FROM bank_transfer WHERE reference_table = 'departure' AND reference_id = '$departure_id' AND bank_account_id = '$account_id' AND status = 1")->row()->total;
                if ($trans > 0) {
                    $trans_id = $this->db->query("SELECT bank_transfer_id FROM bank_transfer WHERE reference_table = 'departure' AND reference_id = '$departure_id' AND bank_account_id = '$account_id' AND status = 1")->row()->bank_transfer_id;
                    $data2['no_check'] = $this->input->post('reference');
                    $this->db->where('bank_transfer_id', $trans_id);
                    $this->db->update('bank_transfer', $data2);

                    /* $mensaje = "Ha actualizado la transferencia bancaria con id: $trans_id, con la información: ".json_encode($data2).".";
                    $this->binnacle($mensaje, "bank_transfer", $trans_id); */
                }
            }
        } else {
            $data0['reference_bank'] = null;
            $data0['reference_id']   = null;
        }
        $data0['approve_name']   = $this->input->post('approve_name');
        $data0['approve_charge'] = $this->input->post('approve_charge');
        $data0['maker_name']     = $this->input->post('maker_name');
        $data0['maker_charge']   = $this->input->post('maker_charge');
        $this->db->where('policy_id', $policy_id);
        $query = $this->db->update('policy', $data0);

        /* $mensaje = "Ha actualizado la póliza con id: $policy_id, con la información: ".json_encode($data0).".";
        $this->binnacle($mensaje, "policy", $policy_id); */

        $data['policy_id'] = $policy_id;

        $html = $this->load->view('backend/viewspdf/policy.php',$data,TRUE); 
        $pdfFilePath = "poliza-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Letter');
        //$mpdf = new mPDF('utf-8',[165,68], 0, '', 0, 0, 0, 0, 0, 0); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printBankCheckPDF($id)
    {
        $type = '';
        $hoy = date("Y-m-d-H-i-s");
        $bank_check_id = base64_decode($id);
        $data['bank_check_id'] = $bank_check_id;
        $check = $this->getBankCheck($bank_check_id);
        $bank = $this->getInfoAccount($check['bank_account_id']);
        $html = $this->load->view("backend/viewspdf/bank_check.php",$data,TRUE);
        $pdfFilePath = "cheque-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8',[165,68], 0, '', 0, 0, 0, 0, 0, 0); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printClientsBookPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial']    = $this->input->post('initial');
        $data['final']      = $this->input->post('final');
        $data['visitor_id'] = $this->input->post('visitor_id');
        $data['client_id']  = $this->input->post('client_id');
        $data['commission'] = $this->input->post('commission');
        $data['ventas']     = $this->getClientsBook();
        $html = $this->load->view('backend/viewspdf/clients_book.php',$data,TRUE); 
        $pdfFilePath = "libro-de-clientes-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Letter-L'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printBalancesPDF()
    {
        $hoy = date("Y-m-d-H-i-s");
        $data['initial'] = $this->input->post('initial');
        $data['final']   = $this->input->post('final');
        $html = $this->load->view('backend/viewspdf/balances.php',$data,TRUE); 
        $pdfFilePath = "balance-de-saldos-".$hoy.".pdf";
        $this->load->library('M_pdf');
        $mpdf = new mPDF('utf-8','Letter'); 
        $mpdf->packTableData = true;
        $mpdf->WriteHTML($html,2);
        $mpdf->Output($pdfFilePath, "I");
    }

    function printJournalExcel()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial = $this->input->post('initial');
        $final   = $this->input->post('final');
        $nom_id  = $this->input->post('nom_id');
        $totalDebe = 0; $totalHaber = 0;
        $date = "DEL ".strtoupper(strftime("%d DE %B AL ", strtotime($initial))).date('d ', strtotime($final));
        if (date('m', strtotime($initial)) != date('m', strtotime($final))) $date .= strftime("DE %B ", strtotime($final));
        $date .= strftime("DEL %Y", strtotime($final));
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LIBRO DIARIO');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->mergeCells('A5:D5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', $date);
        $objPHPExcel->getActiveSheet()->getStyle("A2:A5")->getAlignment()->setHorizontal($centerHz);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A7', '#');
        $objPHPExcel->getActiveSheet()->setCellValue('B7', '');
        $objPHPExcel->getActiveSheet()->setCellValue('C7', 'DEBE');
        $objPHPExcel->getActiveSheet()->setCellValue('D7', 'HABER');
        
        $a = 8; $b = 8; $c = 8; $d = 8;

        $query = $this->getJournal($initial, $final, $nom_id);
        foreach($query->result_array() as $row)
        {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $row['departure_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, date("d/m/Y", strtotime($row['date'])));
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
            $details = $this->getDetailsDeparture($row['departure_id']);
            foreach ($details->result_array() as $det) {
                $nom_id = $det['nomenclature_id']; 
                $nom = $this->nomenByID($nom_id);
                $debe = ''; $haber = '';
                if($det['debit'] != '') $debe = number_format($det['debit'],2,'.','');
                if($det['credit'] != '') $haber = number_format($det['credit'],2,'.','');
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['code'].' '.$nom['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $debe);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $haber);
                $totalDebe += $det['debit'];
                $totalHaber += $det['credit'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $row['details']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($row['total'],2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($row['total'],2,'.',''));
        }
        $objPHPExcel->getActiveSheet()->getStyle("A7:D".$d)->applyFromArray($border_style);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, 'TOTALES:');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($totalDebe,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($totalHaber,2,'.',''));
        $objPHPExcel->getActiveSheet()->getStyle("C8:D".($d-1))->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
        $objPHPExcel->getActiveSheet()->getStyle("A7:D".($d-1))->applyFromArray($border_style);
       
        foreach(range('A','D') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Libro_Diario');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="libro_diario_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printJournalExcelC()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial = $this->input->post('initial');
        $final   = $this->input->post('final');
        $nom_id  = $this->input->post('nom_id');
        $totalDebe = 0; $totalHaber = 0; $cont = 1; $corres = '';
        $time_initial = strtotime($initial); $format_initial = date("d/m/Y", $time_initial);
        $time_final = strtotime($final); $format_final = date("d/m/Y", $time_final);
        if (date('m', $time_initial) == date('m', $time_final)) $corres = strftime("%B", $time_initial);
        else $corres = strftime("%d de %B al ", $time_initial).strftime("%d de %B del %Y", $time_final);
        $date = "DEL ".strtoupper(strftime("%d DE %B AL ", $time_initial)).date('d ', $time_final);
        if (date('m', $time_initial) != date('m', $time_final)) $date .= strftime("DE %B ", $time_final);
        $date .= strftime("DEL %Y", $time_final);
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LIBRO DIARIO');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->mergeCells('A5:D5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', $date);
        $objPHPExcel->getActiveSheet()->getStyle("A2:A5")->getAlignment()->setHorizontal($centerHz);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A7', '#');
        $objPHPExcel->getActiveSheet()->setCellValue('B7', '');
        $objPHPExcel->getActiveSheet()->setCellValue('C7', 'DEBE');
        $objPHPExcel->getActiveSheet()->setCellValue('D7', 'HABER');
        
        $a = 8; $b = 8; $c = 8; $d = 8;

        $query = $this->getJournalConsolidate($initial, $final, $nom_id);
        foreach($query->result_array() as $row)
        {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $cont++);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $format_final);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
            $details = $this->getJournalDetailsConsolidate($row['ids']);
            foreach ($details->result_array() as $det) {
                $nom_id = $det['nomenclature_id']; 
                $nom = $this->nomenByID($nom_id);
                $debe = ''; $haber = '';
                if($det['debit'] != '') $debe = number_format($det['debit'],2,'.','');
                if($det['credit'] != '') $haber = number_format($det['credit'],2,'.','');
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['code'].' '.$nom['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $debe);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $haber);
                $totalDebe += $det['debit'];
                $totalHaber += $det['credit'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "Correspondiente a $corres");
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($totalDebe,2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($totalHaber,2,'.',''));
        }
        $objPHPExcel->getActiveSheet()->getStyle("C8:D".($d-1))->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
        $objPHPExcel->getActiveSheet()->getStyle("A7:D".($d-1))->applyFromArray($border_style);
       
        foreach(range('A','D') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Libro_Diario');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="libro_diario_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printJournalExcelGroup()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial = $this->input->post('initial');
        $final   = $this->input->post('final');
        $nom_id  = $this->input->post('nom_id');
        $totalDebe = 0; $totalHaber = 0; $cont = 1; $corres = ''; $dataDb = array(); $dataHb = array();
        $time_initial = strtotime($initial); $format_initial = date("d/m/Y", $time_initial);
        $time_final = strtotime($final); $format_final = date("d/m/Y", $time_final);
        if (date('m', $time_initial) == date('m', $time_final)) $corres = strftime("%B", $time_initial);
        else $corres = strftime("%d de %B al ", $time_initial).strftime("%d de %B del %Y", $time_final);
        $date = "DEL ".strtoupper(strftime("%d DE %B AL ", $time_initial)).date('d ', $time_final);
        if (date('m', $time_initial) != date('m', $time_final)) $date .= strftime("DE %B ", $time_final);
        $date .= strftime("DEL %Y", $time_final);
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LIBRO MAYOR');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->mergeCells('A5:D5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', $date);
        $objPHPExcel->getActiveSheet()->getStyle("A2:A5")->getAlignment()->setHorizontal($centerHz);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A7', '#');
        $objPHPExcel->getActiveSheet()->setCellValue('B7', '');
        $objPHPExcel->getActiveSheet()->setCellValue('C7', 'DEBE');
        $objPHPExcel->getActiveSheet()->setCellValue('D7', 'HABER');
        
        $a = 8; $b = 8; $c = 8; $d = 8;

        $query = $this->getJournalConsolidateDebit($initial, $final, $nom_id);
        foreach($query->result_array() as $row)
        {
            $data = explode(",", $row['data']);
            for($i=0; $i < count($data); $i++) {
                if(!in_array($data[$i], $dataDb)){
                    $totalDebe = 0; $totalHaber = 0; $totalDebe += $row['total']; array_push($dataDb, $data[$i]);
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $cont++);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $format_final);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $row['code'].' '.$row['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($row['total'],2,'.',''));
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                    $extra = $this->getJournalConsolidateExtra("debit", $row['ids'], $row['nomenclature_id']);
                    foreach ($extra->result_array() as $xt) {
                        $totalDebe += $xt['total'];
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $xt['code'].' '.$xt['name']);
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($xt['total'],2,'.',''));
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                    }
                    $tax = $this->getJournalConsolidateOther("debit", $row['ids'], $row['nomenclature_id']);
                    foreach($tax->result_array() as $tx){
                        $totalDebe += $tx['total'];
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $tx['code'].' '.$tx['name']);
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($tx['total'],2,'.',''));
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                        $extra = $this->getJournalConsolidateExtra("debit", $row['ids'], $tx['nomenclature_id']);
                        foreach($extra->result_array() as $xt){
                            $totalDebe += $xt['total'];
                            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $xt['code'].' '.$xt['name']);
                            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($xt['total'],2,'.',''));
                            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                        }
                    }
                    $pay = $this->getJournalConsolidatePay("credit", $row['ids']);
                    foreach($pay->result_array() as $py) {
                        $totalHaber += $py['total'];
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $py['code'].' '.$py['name']);
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($py['total'],2,'.',''));
                        $extra = $this->getJournalConsolidateExtra("credit", $row['ids'], $py['nomenclature_id']);
                        foreach($extra->result_array() as $xt) {
                            $totalHaber += $xt['total'];
                            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $xt['code'].' '.$xt['name']);
                            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($xt['total'],2,'.',''));
                        }
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "Correspondiente a $corres");
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($totalDebe,2,'.',''));
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($totalHaber,2,'.',''));
                }
            }
            $query = $this->getJournalConsolidateCredit($initial, $final, $nom_id);
            foreach($query->result_array() as $row)
            {
                $data = explode(",", $row['data']);
                for($i=0; $i < count($data); $i++) {
                    if(!in_array($data[$i], $dataDb)){
                        $totalDebe = 0; $totalHaber = 0; $totalDebe += $row['total']; array_push($dataDb, $data[$i]);
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $cont++);
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $format_final);
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                        $pay = $this->getJournalConsolidatePay("credit", $row['ids']);
                        foreach($pay->result_array() as $py) {
                            $totalDebe += $py['total'];
                            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $py['code'].' '.$py['name']);
                            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($py['total'],2,'.',''));
                            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                            $extra = $this->getJournalConsolidateExtra("credit", $row['ids'], $py['nomenclature_id']);
                            foreach($extra->result_array() as $xt) {
                                $totalDebe += $xt['total'];
                                $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                                $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $xt['code'].' '.$xt['name']);
                                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($xt['total'],2,'.',''));
                                $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                            }
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $row['code'].' '.$row['name']);
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($row['total'],2,'.',''));
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                        $extra = $this->getJournalConsolidateExtra("debit", $row['ids'], $row['nomenclature_id']);
                        foreach ($extra->result_array() as $xt) {
                            $totalHaber += $xt['total'];
                            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $xt['code'].' '.$xt['name']);
                            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($xt['total'],2,'.',''));
                        }
                        $tax = $this->getJournalConsolidateOther("debit", $row['ids'], $row['nomenclature_id']);
                        foreach($tax->result_array() as $tx){
                            $totalHaber += $tx['total'];
                            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $tx['code'].' '.$tx['name']);
                            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($tx['total'],2,'.',''));
                            $extra = $this->getJournalConsolidateExtra("debit", $row['ids'], $tx['nomenclature_id']);
                            foreach($extra->result_array() as $xt){
                                $totalHaber += $xt['total'];
                                $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                                $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $xt['code'].' '.$xt['name']);
                                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                                $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($xt['total'],2,'.',''));
                            }
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "Correspondiente a $corres");
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($totalDebe,2,'.',''));
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($totalHaber,2,'.',''));
                    }
                }
            }
        }
        $objPHPExcel->getActiveSheet()->getStyle("C8:D".($d-1))->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
        $objPHPExcel->getActiveSheet()->getStyle("A7:D".($d-1))->applyFromArray($border_style);
       
        foreach(range('A','D') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Libro_Diario');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="libro_diario_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printLedgerExcel()
    {
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial         = $this->input->post('initial');
        $final           = $this->input->post('final');
        $nomenclature_id = $this->input->post('nomenclature_id');
        $count = 1;
        $signo = '';
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LIBRO MAYOR');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->mergeCells('A5:D5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'DEL '.strtoupper(strftime("%d DEL %B", strtotime($initial)).' AL '.strftime("%d DE %B DEL %Y", strtotime($final))));
        $objPHPExcel->getActiveSheet()->getStyle("A2:A5")->getAlignment()->setHorizontal($centerHz);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A7', '#');
        $objPHPExcel->getActiveSheet()->setCellValue('B7', 'CUENTA');
        $objPHPExcel->getActiveSheet()->setCellValue('C7', 'DEBE');
        $objPHPExcel->getActiveSheet()->setCellValue('D7', 'HABER');
        
        $a = 8; $b = 8; $c = 8; $d = 8;

        $query = $this->getLedger($initial, $final, $nomenclature_id);
        foreach($query->result_array() as $row)
        {
            $totalDebe = 0;
            $totalHaber = 0;
            $restante = 0; $saldoDebe = ''; $saldoHaber = '';
            $exNom = explode('.', $row['code']);
            $tipo = $exNom[0];
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $count++);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $row['code'].' '.$row['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
            $details = $this->getDetailLedger($row['nomenclature_id'], $initial, $final);
            foreach ($details->result_array() as $det) {
                $debe = ''; $haber = '';
                if($det['debit'] != '') $debe = number_format($det['debit'],2,'.','');
                if($det['credit'] != '') $haber = number_format($det['credit'],2,'.','');
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $det['details']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $debe);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $haber);
                $totalDebe += $det['debit'];
                $totalHaber += $det['credit'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($totalDebe,2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($totalHaber,2,'.',''));
            if($tipo == 1 || $tipo == 5) {
                $restante = $totalDebe - $totalHaber;
                $saldoDebe = number_format(abs($restante),2,'.',''); 
            } if($tipo == 2 || $tipo == 3 || $tipo == 4) {
                $restante = $totalHaber - $totalDebe;
                $saldoHaber = number_format(abs($restante),2,'.',''); 
            }
            if($restante < 0) $signo = '-'; else $signo = '';
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, 'SALDO:');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $signo.$saldoDebe);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $signo.$saldoHaber);
        }
        $objPHPExcel->getActiveSheet()->getStyle("C8:D".($d-1))->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
        $objPHPExcel->getActiveSheet()->getStyle("A7:D".($d-1))->applyFromArray($border_style);
       
        foreach(range('A','D') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Libro_Mayor');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="libro_mayor_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printLedgerExcelC()
    {
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        setlocale(LC_TIME, "es_ES");
        $hoy = date("Y-m-d-H-i-s");
        $initial         = $this->input->post('initial');
        $final           = $this->input->post('final');
        $nomenclature_id = $this->input->post('nomenclature_id');
        $count = 1; $signo = ''; $texto = "Movimiento correspondiente ";
        if (date('m', strtotime($initial)) == date('m', strtotime($final))) $texto .= strftime("%B", strtotime($initial));
        else $texto .= strftime("%d de %B AL ", strtotime($initial)).strftime("%d de %B del %Y", strtotime($final));
        $date = "DEL ".strtoupper(strftime("%d DEL %B AL ", strtotime($initial))).date('d ', strtotime($final));
        if (date('m', strtotime($initial)) != date('m', strtotime($final))) $date .= strftime("DE %B ", strtotime($final));
        $date .= strftime("DEL %Y", strtotime($final));
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LIBRO MAYOR');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D4');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true); 
        $objPHPExcel->getActiveSheet()->mergeCells('A5:D5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->mergeCells('A6:D6');
        $objPHPExcel->getActiveSheet()->setCellValue('A6', $date);
        $objPHPExcel->getActiveSheet()->getStyle("A2:A6")->getAlignment()->setHorizontal($centerHz);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A8', '#');
        $objPHPExcel->getActiveSheet()->setCellValue('B8', 'CUENTA');
        $objPHPExcel->getActiveSheet()->setCellValue('C8', 'DEBE');
        $objPHPExcel->getActiveSheet()->setCellValue('D8', 'HABER');
        
        $a = 9; $b = 9; $c = 9; $d = 9;

        $query = $this->getLedgerConsolidate($initial, $final, $nomenclature_id);
        foreach($query->result_array() as $row)
        {
            $restante = 0; $saldoDebe = ''; $saldoHaber = '';
            $exNom = explode('.', $row['code']);
            $tipo = $exNom[0];
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $count++);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $row['code'].' '.$row['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $texto);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($row['debit'],2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($row['credit'],2,'.',''));
            if($tipo == 1 || $tipo == 5) {
                $restante = $row['debit'] - $row['credit'];
                $saldoDebe = number_format(abs($restante),2,'.',''); 
            } if($tipo == 2 || $tipo == 3 || $tipo == 4) {
                $restante = $row['credit'] - $row['debit'];
                $saldoHaber = number_format(abs($restante),2,'.',''); 
            }
            if($restante < 0) $signo = '-'; else $signo = '';
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, 'SALDO:');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $signo.$saldoDebe);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $signo.$saldoHaber);
        }
        $objPHPExcel->getActiveSheet()->getStyle("C9:D".($d-1))->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
        $objPHPExcel->getActiveSheet()->getStyle("A8:D".($d-1))->applyFromArray($border_style);
       
        foreach(range('A','D') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Libro_Mayor');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="libro_mayor_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printImportExcel($id)
    {
        $hoy = date("Y-m-d-H-i-s");
        $import_id = base64_decode($id);
        $imp = $this->getImport($import_id);
        $prov = $this->getProvider($imp['provider_id']);
        $cont = 1;
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => array('argb' => '000000'),)));
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NÚMERO:');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', $imp['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'FECHA:');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', date("d/m/Y", strtotime($imp['date'])));
        $objPHPExcel->getActiveSheet()->setCellValue('G2', '-');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'POLIZA:');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'TIPO CAMBIO:');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', $imp['exchange_rate']);
        $objPHPExcel->getActiveSheet()->setCellValue('G3', '-');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'TOTAL FOB.');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'TOTAL CIF');
        $objPHPExcel->getActiveSheet()->setCellValue('E4', '');
        $objPHPExcel->getActiveSheet()->setCellValue('G4', '-');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'TOTAL COSTOS:');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', number_format($imp['total_product_quetzal'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'FACTOR $.');
        $objPHPExcel->getActiveSheet()->setCellValue('E5', '');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'FACTOR Q.');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:D7');
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'DETALLE DE PROVEEDORES');
        $objPHPExcel->getActiveSheet()->setCellValue('A8', 'NÚMERO');
        $objPHPExcel->getActiveSheet()->setCellValue('B8', 'FECHA');
        $objPHPExcel->getActiveSheet()->setCellValue('C8', 'PROVEEDOR');
        $objPHPExcel->getActiveSheet()->setCellValue('D8', 'TOTAL FOB');
        $objPHPExcel->getActiveSheet()->setCellValue('A9', $prov['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('C9', $prov['name']);
        $objPHPExcel->getActiveSheet()->mergeCells('F7:H7');
        $objPHPExcel->getActiveSheet()->setCellValue('F7', 'DETALLE DE GASTOS');
        $objPHPExcel->getActiveSheet()->setCellValue('F8', 'GASTO');
        $objPHPExcel->getActiveSheet()->setCellValue('G8', 'DOLARES');
        $objPHPExcel->getActiveSheet()->setCellValue('H8', 'QUETZALES');
        $objPHPExcel->getActiveSheet()->setCellValue('F9', 'AGENTE ADUANERO');
        $objPHPExcel->getActiveSheet()->setCellValue('G9', number_format($imp['custom_agent_dollar'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('H9', number_format($imp['custom_agent_quetzal'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('F10', 'DAI');
        $objPHPExcel->getActiveSheet()->setCellValue('G10', number_format($imp['dai_dollar'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('H10', number_format($imp['dai_quetzal'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('F11', 'ESTADÍA');
        $objPHPExcel->getActiveSheet()->setCellValue('G11', number_format($imp['stay_dollar'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('H11', number_format($imp['stay_quetzal'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('F12', 'FLETE ÁEREO');
        $objPHPExcel->getActiveSheet()->setCellValue('G12', number_format($imp['freight_land_dollar'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('H12', number_format($imp['freight_land_quetzal'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('F13', 'FLETE TERRESTRE');
        $objPHPExcel->getActiveSheet()->setCellValue('G13', number_format($imp['freight_air_dollar'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('H13', number_format($imp['freight_air_quetzal'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('F14', 'OTROS GASTOS');
        $objPHPExcel->getActiveSheet()->setCellValue('G14', number_format($imp['other_expense_dollar'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('H14', number_format($imp['other_expense_quetzal'],2,".",","));

        $objPHPExcel->getActiveSheet()->setCellValue('A16', 'ITEM');
        $objPHPExcel->getActiveSheet()->setCellValue('B16', 'CÓDIGO');
        $objPHPExcel->getActiveSheet()->setCellValue('C16', 'DESCRIPCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('D16', 'CANTIDAD');
        $objPHPExcel->getActiveSheet()->setCellValue('E16', 'PRECIO FOB');
        $objPHPExcel->getActiveSheet()->setCellValue('F16', 'TOTAL FOB');
        $objPHPExcel->getActiveSheet()->setCellValue('G16', 'COSTO Q.');
        $objPHPExcel->getActiveSheet()->setCellValue('H16', 'TOTAL Q.');
        
        $a = 17; $b = 17; $c = 17; $d = 17; $e = 17; $f = 17; $g = 17; $h = 17;

        $query = $this->getDetailImport($import_id);
        foreach($query->result_array() as $row)
        {
            $prod = $this->getProduct($row['product_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $cont++);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $prod['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $prod['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $row['amount']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($row['dollar'],2,".",","));
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, number_format($row['subtotal_dollar'],2,".",","));
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, number_format($row['quetzal'],2,".",","));
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, number_format($row['subtotal_quetzal'],2,".",","));
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, number_format($imp['total_product_dollar'],2,".",","));
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, number_format($imp['total_product_quetzal'],2,".",","));
        $objPHPExcel->getActiveSheet()->getStyle("A7:D9")->applyFromArray($border_style);
        $objPHPExcel->getActiveSheet()->getStyle("F7:H14")->applyFromArray($border_style);
        $objPHPExcel->getActiveSheet()->getStyle("A16:H".$h)->applyFromArray($border_style);
       
        foreach(range('A','H') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Importación');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="importacion_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printGeneralExcel()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial = $this->input->post('initial');
        $final   = $this->input->post('final');
        $tipos = $this->getHeadsTypesGeneral();
        $val = $this->getUtilityGeneral($initial, $final);
        $cashes = $this->getCashNomen();
        $cash = 0;
        $pettyCash = $this->getPettyCash();
        $cash_petty = 0;
        $activo = 0; $act_corriente = 0; $act_no_corriente = 0;
        $pasivo = 0; $pas_corriente = 0; $pas_no_corriente = 0;
        $patrimonio = 0; $capital = 0; $utilidad = 0;
        $reserva = $val['legal']; $bruta = $val['gross']; $neta = $val['net'];
        $bancos = 0; $cuentas_cobrar = 0; $deprec = 0;
        $centerAll = array(
            'aligment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $centerVt = PHPExcel_Style_Alignment::VERTICAL_CENTER;
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_right = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_bottom = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_bottom_double = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('argb' => '000000'),)));
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'BALANCE GENERAL');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true); 
        $objPHPExcel->getActiveSheet()->mergeCells('A4:E4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setWrapText(true); 
        $objPHPExcel->getActiveSheet()->mergeCells('A5:E5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'DEL '.strtoupper(strftime("%d DEL %B", strtotime($initial)).' AL '.strftime("%d DE %B DEL %Y", strtotime($final))));
        $objPHPExcel->getActiveSheet()->getStyle("A2:A5")->getAlignment()->setHorizontal($centerHz);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Rubro');
        
        $a = 8; $b = 8; $c = 8; $d = 8; $e = 8;

        $type = $this->getHeadTypeByCode("1");
        $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $type['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $type['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $head = $this->getHeadByCode("1.01");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $head['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, strtoupper($head['name']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nCash = 1;
        foreach ($cashes->result_array() as $ch) {
            $total = $this->getTotalYearNom($ch['nomenclature_id'], $initial, $final, 1);
            $activo += $total; $act_corriente += $total; $cash += $total;
            $value1 = ''; 
            if($cashes->num_rows() > 1) $value1 .= number_format($total,2,'.','');
            $value2 = '';
            if($cashes->num_rows() == 1) $value2 .= number_format($total,2,'.','');
            if($cashes->num_rows() > 1 && $cashes->num_rows() == $nCash) $value2 .= number_format($cash,2,'.','');
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $ch['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $ch['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $value1);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $value2);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
            $nCash++;
        }
        $nPetCash = 1;
        foreach ($pettyCash->result_array() as $ch) {
            $total = $this->getTotalYearNom($ch['nomenclature_id'], $initial, $final, 1);
            $activo += $total; $act_corriente += $total; $petty_cash += $total;
            $value1 = ''; 
            if($pettyCash->num_rows() > 1) $value1 .= number_format($total,2,'.','');
            $value2 = '';
            if($pettyCash->num_rows() == 1) $value2 .= number_format($total,2,'.','');
            if($pettyCash->num_rows() > 1 && $pettyCash->num_rows() == $nPetCash) $value2 .= number_format($petty_cash,2,'.','');
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $ch['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $ch['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $value1);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $value2);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
            $nPetCash++;
        }
        for ($i=1; $i <= 6; $i++) {
            $nom = $this->getNomenByCode("1.01.02.00$i");
            $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
            $activo += $total; $act_corriente += $total; $bancos += $total;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        }
        $group = $this->getGroupByCode("1.01.02");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $group['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $group['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $group = $this->getGroupByCode("1.01.03");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $group['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, strtoupper($group['name']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("1.01.03.001");
        /*if (strtotime($final) < strtotime(date("Y-m-d"))) $total = $this->getTotalInventory($final);
        else $total = $this->getTotalInventory();*/
        $activo += $total; $act_corriente += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $group = $this->getGroupByCode("1.01.04");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $group['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, strtoupper($group['name']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("1.01.04.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
        $activo += $total; $act_corriente += $total; $cuentas_cobrar += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("1.01.04.002");
        $total = $total * 0.03; $activo -= $total; $act_corriente -= $total; $cuentas_cobrar -= $total;
        $objPHPExcel->getActiveSheet()->getStyle("C".$c)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($cuentas_cobrar,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("1.01.05.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
        $activo += $total; $act_corriente += $total;
        $objPHPExcel->getActiveSheet()->getStyle("D".$d)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($act_corriente,2,'.',''));
        $head = $this->getHeadByCode("1.02");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $head['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, strtoupper($head['name']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        for ($i=1; $i <= 9; $i++) {
            $nom = $this->getNomenByCode("1.02.01.00$i");
            $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
            $activo += $total; $act_no_corriente += $total; $depreciacion += $total;
            $value1 = ''; $value1 .= number_format($total,2,'.','');
            $value2 = ''; 
            if(($i % 2) == 0) { 
                $objPHPExcel->getActiveSheet()->getStyle("C".$c)->applyFromArray($border_bottom);
                $value2 .= number_format($depreciacion,2,'.','');
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $value1);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $value2);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
            if(($i % 2) == 0) $depreciacion = 0;
        }
        $objPHPExcel->getActiveSheet()->getStyle("C".$c.":D".$d)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $objPHPExcel->getActiveSheet()->getStyle("D".$d.":E".$e)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($act_no_corriente,2,'.',''));
        $objPHPExcel->getActiveSheet()->getStyle("D".$d.":E".$e)->applyFromArray($border_bottom_double);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "TOTAL DEL ACTIVO");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($activo,2,'.',''));
        $type = $this->getHeadTypeByCode("2");
        $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $type['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, strtoupper($type['name']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $head = $this->getHeadByCode("2.01");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $head['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, strtoupper($head['name']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        for ($i=1; $i <= 5; $i++) { 
            $nom = $this->getNomenByCode("2.01.01.00$i");
            $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 2);
            $pasivo += $total; $pas_corriente += $total;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($pas_corriente,2,'.',''));
        $head = $this->getHeadByCode("2.02");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $head['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, strtoupper($head['name']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("2.02.01.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 2);
        $pasivo += $total; $pas_no_corriente += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($pas_no_corriente,2,'.',''));
        $head = $this->getHeadByCode("3.01");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $head['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, strtoupper($head['name']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $group = $this->getGroupByCode("3.01.01");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $group['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, strtoupper($group['name']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("3.01.01.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 3);
        $patrimonio += $total; $capital += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("3.01.01.002");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
        $patrimonio -= $total; $capital -= $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($capital,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $group = $this->getGroupByCodeName("3.02.01", "reserva");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $group['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, strtoupper($group['name']));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCodeName("3.02.01.001", "reserva");
        $patrimonio += $reserva;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($reserva,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("3.02.01.003");
        $total = $activo - $pasivo - $capital - $reserva - $neta; $patrimonio += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->crud_model->getNomenByCode("3.02.01.002");
        $patrimonio += $neta; $utilidad += $total + $neta;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($neta,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($utilidad,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $objPHPExcel->getActiveSheet()->getStyle("D".$d.":E".$e)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($patrimonio,2,'.',''));
        $patrimonio += $pasivo;
        $objPHPExcel->getActiveSheet()->getStyle("D".$d.":E".$e)->applyFromArray($border_bottom_double);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "3.02.02.003");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "TOTAL DE PASIVO Y CAPITAL");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($patrimonio,2,'.',''));
        $objPHPExcel->getActiveSheet()->getStyle("C8:E".($e-1))->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);

        $a++; $b++; $c++; $d++; $e++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':E'.($e+2));
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, trim($this->input->post('description')));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setWrapText(true); 
        $a += 4; $b += 4; $c += 4; $d += 4; $e += 4;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':E'.$e);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $this->getInfo("address").' '.strftime("%d de %B del %Y"));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':E'.$e)->getAlignment()->setHorizontal($centerHz);
        $a += 3; $b += 3; $c += 3; $d += 3; $e += 3;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':B'.$b);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $this->input->post('legal_name'));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('C'.$c.':E'.$e);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $this->input->post('account_name'));
        $objPHPExcel->getActiveSheet()->getStyle('C'.$c)->getAlignment()->setHorizontal($centerHz);
        $a++; $b++; $c++; $d++; $e++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':B'.$b);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $this->input->post('legal_charge'));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('C'.$c.':E'.$e);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $this->input->post('account_charge'));
        $objPHPExcel->getActiveSheet()->getStyle('C'.$c)->getAlignment()->setHorizontal($centerHz);
        $a += 6; $b += 6; $c += 6; $d += 6; $e += 6;
        $objPHPExcel->getActiveSheet()->getStyle("E1:E".$e)->applyFromArray($border_right);
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":E".$e)->applyFromArray($border_bottom);
       
        foreach(range('A','E') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Balance_General');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="balance_general_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }
    
    function printStatementExcel()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial = $this->input->post('initial');
        $final   = $this->input->post('final');
        $totalIngresos = 0; $totalEgresos = 0;
        $ventas = 0; $mercaderias = 0; $compras = 0; $operacion = 0; $margen = 0; $admin = 0; $financieros = 0; $productos = 0; $gastos = 0; $restante = 0;
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_top = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_bottom = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_bottom_double = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('argb' => '000000'),)));
        $border_right = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_left = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'ESTADO DE RESULTADOS');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true); 
        $objPHPExcel->getActiveSheet()->mergeCells('A4:E4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setWrapText(true); 
        $objPHPExcel->getActiveSheet()->mergeCells('A5:E5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'DEL '.strtoupper(strftime("%d DEL %B", strtotime($initial)).' AL '.strftime("%d DE %B DEL %Y", strtotime($final))));
        $objPHPExcel->getActiveSheet()->getStyle("A2:A5")->getAlignment()->setHorizontal($centerHz);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Rubro');
        
        $a = 8; $b = 8; $c = 8; $d = 8; $e = 8;

        $group = $this->getGroupByCode("4.01.01");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $group['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $group['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("4.02.01.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4);
        $ventas += $total; $totalIngresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("4.01.01.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4);
        $ventas += $total; $totalIngresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("4.01.01.002");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4);
        $ventas += $total; $totalIngresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, 'Ventas netas');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($totalIngresos,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, 'menos');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $group = $this->getGroupByCode("5.01.01");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $group['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $group['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.01.01.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4);
        $mercaderias += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.01.01.002");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $compras += $total; $mercaderias += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.01.01.003");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $compras += $total; $mercaderias += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.01.01.006");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $compras += $total; $mercaderias += $total;
        $objPHPExcel->getActiveSheet()->getStyle("C".$c.":D".$d)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($compras,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.01.01.007");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($mercaderias,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.01.01.008"); $total = 0;
        /*if (strtotime($final) < strtotime($hoy)) $total = $this->getTotalInventory($final);
        else $total = $this->getTotalInventory();*/
        if ($mercaderias > $total) $totalMerc = $mercaderias - $total;
        else $totalMerc = $total - $mercaderias;
        $objPHPExcel->getActiveSheet()->getStyle("D".$d.":E".$e)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($totalMerc,2,'.',''));
        $nom = $this->getNomenByCode("5.01.01.009");
        $total = $totalIngresos - $totalMerc; $totalEgresos += $totalMerc;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($total,2,'.',''));
        $group = $this->getGroupByCode("5.02.01");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $group['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $group['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.001");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.002");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.003");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.004");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.005");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.006");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.007");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.008");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.009");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.010");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.011");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.012");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.013");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.014");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.015");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.016");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.017");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.018");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.019");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.020");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.021");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $operacion += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $objPHPExcel->getActiveSheet()->getStyle("D".$d.":E".$e)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($operacion,2,'.',''));
        $nom = $this->getNomenByCode("5.02.01.022");
        $margen = $totalIngresos - $totalEgresos;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($margen,2,'.',''));
        $nom = $this->getNomenByCode("5.02.01.023");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.024");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $admin += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.025");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $admin += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.026");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $admin += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.027");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $admin += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.02.01.028");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $admin += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $objPHPExcel->getActiveSheet()->getStyle("D".$d.":E".$e)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($admin,2,'.',''));
        $nom = $this->getNomenByCode("5.02.01.034");
        $margen = $totalIngresos - $totalEgresos;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($margen,2,'.',''));
        $group = $this->getGroupByCode("5.03.01");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $group['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $group['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.03.01.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $financieros += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.03.01.002");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $financieros += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.03.01.003");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $financieros += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.03.01.004");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $financieros += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.03.01.005");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $financieros += $total; $totalEgresos += $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($financieros,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $group = $this->getGroupByCode("5.04.01");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $group['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $group['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.04.01.001");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $productos += $total; $totalEgresos -= $total;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $nom = $this->getNomenByCode("5.04.01.002");
        $total = $this->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
        $productos += $total; $totalEgresos -= $total; $gastos = $financieros - $productos;
        $objPHPExcel->getActiveSheet()->getStyle("C".$c.":E".$e)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $nom['code']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $nom['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($total,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($productos,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($gastos,2,'.',''));

        $head = $this->getHeadByCode("3.02");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $head['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
        $restante = $totalIngresos - $totalEgresos;
        if ($restante >= 0) {
            $utilidad = $this->getGroupEquityLike("ganancia", $head['heading_id']);
            foreach($utilidad->result_array() as $ut){
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $ut['code']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $ut['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
                $cuentas = $this->getNomenLikeStatement("del periodo", $ut['heading_type_id'], $ut['heading_id'], $ut['group_account_id']);
                foreach($cuentas->result_array() as $ct) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $ct['code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $ct['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($restante,2,'.',''));
                }
            }
        } else {
            $perdida = $this->getGroupEquityLike("perdida", $head['heading_id']);
            foreach($perdida->result_array() as $pd) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $pd['code']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $pd['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
            }
        }
        if ($restante > 0) {
            $head = $this->getHeadByCode("3.01");
            $reserva = $this->getGroupEquityLike("reserva", $head['heading_id']);
            foreach($reserva->result_array() as $rs) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $rs['code']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $rs['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
                $cuentas = $this->getNomenGeneral($rs['heading_type_id'], $rs['heading_id'], $rs['group_account_id']);
                $legal = $restante * 0.05;
                foreach($cuentas->result_array() as $ct) {
                    $objPHPExcel->getActiveSheet()->getStyle("D".$d.":E".$e)->applyFromArray($border_bottom);
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $ct['code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $ct['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($legal,2,'.',''));
                }
            }
            $restante -= $legal;
        }
        $head = $this->getHeadByCode("3.02");
        if ($restante >= 0) $neta = $this->getGroupEquityLike("ganancia", $head['heading_id']);
        else $neta = $this->getGroupEquityLike("perdida", $head['heading_id']);
        foreach($neta->result_array() as $nt) {
            $cuentas = $this->getNomenLikeStatement("neta del ejercicio", $nt['heading_type_id'], $nt['heading_id'], $nt['group_account_id']);
            foreach($cuentas->result_array() as $ct) {
                $objPHPExcel->getActiveSheet()->getStyle("D".$d.":E".$e)->applyFromArray($border_bottom_double);
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $ct['code']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $ct['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($restante,2,'.',''));
            }
        }
        $objPHPExcel->getActiveSheet()->getStyle("C9:E".($e-1))->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);

        $a++; $b++; $c++; $d++; $e++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':E'.($e+2));
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, trim($this->input->post('description')));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setWrapText(true); 
        $a += 4; $b += 4; $c += 4; $d += 4; $e += 4;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':E'.$e);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $this->getInfo("address").' '.strftime("%d de %B del %Y"));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':E'.$e)->getAlignment()->setHorizontal($centerHz);
        $a += 3; $b += 3; $c += 3; $d += 3; $e += 3;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':B'.$b);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $this->input->post('legal_name'));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('C'.$c.':E'.$e);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $this->input->post('account_name'));
        $objPHPExcel->getActiveSheet()->getStyle('C'.$c)->getAlignment()->setHorizontal($centerHz);
        $a++; $b++; $c++; $d++; $e++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':B'.$b);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$b, $this->input->post('legal_charge'));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$b)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('C'.$c.':E'.$e);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $this->input->post('account_charge'));
        $objPHPExcel->getActiveSheet()->getStyle('C'.$c)->getAlignment()->setHorizontal($centerHz);
        $a += 4; $b += 4; $c += 4; $d += 4; $e += 4;
        $objPHPExcel->getActiveSheet()->getStyle("E1:E".$e)->applyFromArray($border_right);
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":E".$e)->applyFromArray($border_bottom);
       
        foreach(range('A','E') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Estado_Resultados');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="estado_de_resultados_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }
    
    function printPurchasingExcel()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial        = $this->input->post('initial');
        $final          = $this->input->post('final');
        $institution_id = $this->input->post('institution_id');
        $camp           = $this->input->post('camp');
        $text           = $this->input->post('text');
        $checks = json_decode($this->getInfo("checks_purchase"));
        $totalDebe = 0;
        $totalHaber = 0;
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:Q2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "LIBRO DE COMPRAS Y SERVICIOS ADQUIRIDOS");
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('A3:Q3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->getStyle("A3")->getAlignment()->setHorizontal($centerHz);
        
        $a = 5; $b = 5; $c = 5; $d = 5; $e = 5; $f = 5; $g = 5; $h = 5; $i = 5; $j = 5; $k = 5; $l = 5; $m = 5; $n = 5; $o = 5; $p = 5; $q = 5;
        if ($institution_id != '') {
            $ins = $this->crud_model->getInstitution($institution_id);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':C'.$c);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "CONTRIBUYENTE:");
            $objPHPExcel->getActiveSheet()->mergeCells('D'.$d.':G'.$g);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d, $ins['personal_name']);
            $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++; $n++; $o++; $p++; $q++;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':C'.$c);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "NOMBRE COMERCIAL:");
            $objPHPExcel->getActiveSheet()->mergeCells('D'.$d.':G'.$g);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d, $ins['name']);
            $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++; $n++; $o++; $p++; $q++;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':C'.$c);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "DIRECCIÓN COMERCIAL:");
            $objPHPExcel->getActiveSheet()->mergeCells('D'.$d.':G'.$g);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d, $ins['address']);
            $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++; $n++; $o++; $p++; $q++;
            $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++; $n++; $o++; $p++; $q++;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "PERIODO");
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$b.':E'.$e);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, "DEL ".strtoupper(strftime("%d DEL %B", strtotime($initial))." AL ".strftime("%d DEL %Y", strtotime($final))));
        $objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':K'.$k);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, "NIT: ".$this->getInfo("nit"));
        $a += 2; $b += 2; $c += 2; $d += 2; $e += 2; $f += 2; $g += 2; $h += 2; $i += 2; $j += 2; $k += 2; $l += 2; $m += 2; $n += 2; $o += 2; $p += 2; $q += 2;
        $cellI = $a;        
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "FECHA");
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$b.':D'.$d);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, "Documento");
        $objPHPExcel->getActiveSheet()->mergeCells('E'.$e.':F'.$f);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, "PROVEEDOR/PRESTADOR");
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g, "EST");
        $objPHPExcel->getActiveSheet()->mergeCells('H'.$h.':I'.$i);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$h, "PC");
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$j, "Regimén general");
        $objPHPExcel->getActiveSheet()->mergeCells('K'.$k.':M'.$m);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$k, "Precios base");
        $objPHPExcel->getActiveSheet()->getStyle('K'.$k)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, "ISR/COMPRAS-SERVICIOS");
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$o, '');
        $objPHPExcel->getActiveSheet()->setCellValue('P'.$p, "IVA CREDITO FISCAL");
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$q, "TOTALES");
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':Q'.$q)->getAlignment()->setWrapText(true); 
        $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++; $n++; $o++; $p++; $q++;
        $objPHPExcel->getActiveSheet()->getStyle("A".$cellI.":Q".$q)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "Tipo");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, "SERIE");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, "NUMERO");
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, "NIT O DPI, Otros");
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, "NOMBRE");
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, "Compra");
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, "Servicio");
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, "Total factura");
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, "COMPRAS");
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, "SERVICIOS");
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, "IMPORTACION");
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$n++, "ISR");
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$o++, "EXENTA DEL IVA");
        $objPHPExcel->getActiveSheet()->setCellValue('P'.$p++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$q++, '');
        
        $totalPeqCom = 0; $totalPeqSer = 0; $totalGen = 0; $totalCompras = 0; $totalServicios = 0; $totalImports = 0; $totalISR = 0; $totalExe = 0; $totalIVA = 0; $totalTotal = 0;
        $query = $this->getPurchasing($initial, $final, $institution_id.'-'.$camp.'-'.$text);
        foreach($query->result_array() as $row)
        {
            $ins = $this->getInstitution($row['institution_id']);
            $compraP = ''; $servicioP = ''; $compraG = ''; $compras = ''; $servicios = ''; $importaciones = ''; $isr = ''; $exempt = ''; $iva = ''; $totales = '';
            if($row['regime'] == 'P' && $row['type'] == 'C') $compraP = number_format($row['total'],2,'.','');
            if($row['regime'] == 'P' && $row['type'] == 'S') $servicioP = number_format($row['total'],2,'.','');
            if($row['regime'] == 'G') $compraG = number_format($row['total'],2,'.','');
            if(($row['regime'] == 'G' || $row['regime'] == '') && $row['type'] == 'C') $compras = number_format($row['amount'],2,'.','');
            if(($row['regime'] == 'G' || $row['regime'] == '') && $row['type'] == 'S') $servicios = number_format($row['amount'],2,'.','');
            if(($row['regime'] == 'G' || $row['regime'] == '') && $row['type'] == 'I') $importaciones = number_format($row['amount'],2,'.','');
            if($row['regime'] == 'G') $isr = number_format($row['isr'],2,'.','');
            if($row['regime'] == 'G' && $row['exempt'] == 1) $exempt = number_format($row['iva'],2,'.','');
            if($row['regime'] == 'G' && $row['exempt'] != 1) $iva = number_format($row['iva'],2,'.','');
            if($row['regime'] == 'G') $totales = number_format($row['total'],2,'.','');
            $objPHPExcel->getActiveSheet()->getStyle('G'.$g)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, date("d/m/Y", strtotime($row['date'])));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $row['document_type']);
            $objPHPExcel->getActiveSheet()->getStyle("C".$c)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $row['serie']);
            $objPHPExcel->getActiveSheet()->getStyle("D".$d)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $row['number']);
            $objPHPExcel->getActiveSheet()->getStyle("E".$e)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, $row['nit']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, $row['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, $ins['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, $compraP);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, $servicioP);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, $compraG);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, $compras);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, $servicios);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, $importaciones);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$n++, $isr);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$o++, $exempt);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$p++, $iva);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$q++, $totales);
            if($row['regime'] == 'P' && $row['type'] == 'C') $totalPeqCom += $row['total']; if($row['regime'] == 'P' && $row['type'] == 'S') $totalPeqSer += $row['total']; 
            if ($row['regime'] == 'G') $totalGen += $row['total']; 
            if(($row['regime'] == 'G' || $row['regime'] == '') && $row['type'] == 'C') $totalCompras += $row['amount'];
            if(($row['regime'] == 'G' || $row['regime'] == '') && $row['type'] == 'S') $totalServicios += $row['amount']; 
            if(($row['regime'] == 'G' || $row['regime'] == '') && $row['type'] == 'I') $totalImports += $row['amount'];
            if($row['regime'] == 'G') $totalISR += $row['isr']; 
            if($row['regime'] == 'G' && $row['exempt'] == 1) $totalExe += $row['iva']; 
            if($row['regime'] == 'G' && $row['exempt'] != 1) $totalIVA += $row['iva']; 
            if($row['regime'] == 'G') $totalTotal += $row['total'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, '');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$f, '');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g, "Totales:");
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$h, number_format($totalPeqCom,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, number_format($totalPeqSer,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$j, number_format($totalGen,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$k, number_format($totalCompras,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$l, number_format($totalServicios,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$m, number_format($totalImports,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, number_format($totalISR,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$o, number_format($totalExe,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('P'.$p, number_format($totalIVA,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$q, number_format($totalTotal,2,'.',''));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':Q'.$q)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("A".$cellI.":Q".$q)->applyFromArray($border_style);
        $objPHPExcel->getActiveSheet()->getStyle("H".($cellI+2).":Q".$q)->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
       
        $nCol = 2;
        foreach(range('A','Q') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setVisible(in_array($nCol, $checks));
            $nCol++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Libro_de_Compras');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="libro_de_compras_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printBankBookExcel()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $account_id = $this->input->post('account_id');
        $initial    = $this->input->post('initial');
        $final      = $this->input->post('final');
        $info = $this->getInfoAccount($account_id);
        $saldo = $this->getInitialBalanceBank($account_id, $initial);
        $checks = json_decode($this->getInfo("checks_bank"));
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_bottom = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $title_red = array('fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'F8CBAD')));
        $color_red = array('fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'FFE699')));
        $cell_blue = array('fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'DDEBF7')));
        $cell_green = array('fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'E2EFDA')));
        $cell_yellow = array('fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'FFFF00')));
        $cell_red = array('fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'FCE4D6')));
        $cell_initial = array('fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'FFC000')));
        $cell_no = array('fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'92D050')));
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "LIBRO DE BANCOS");
        $objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->mergeCells('A4:F4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->getStyle("A2:A4")->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('A6', "CUENTA");
        $objPHPExcel->getActiveSheet()->setCellValue('B6', $info['code']);
        $objPHPExcel->getActiveSheet()->getStyle("B6")->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('E6', "CUENTA");
        $objPHPExcel->getActiveSheet()->setCellValue('F6',$info['iso']." - ".$info['currency']);
        $objPHPExcel->getActiveSheet()->getStyle("F6")->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A7', "BANCO");
        $objPHPExcel->getActiveSheet()->setCellValue('B7', $info['bank']);
        $objPHPExcel->getActiveSheet()->getStyle("B7")->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->setCellValue('A8', "MES");
        $objPHPExcel->getActiveSheet()->setCellValue('B8', "DEL ".strtoupper(strftime("%d DEL %B", strtotime($initial))." AL ".strftime("%d DEL %Y", strtotime($final))));
        $objPHPExcel->getActiveSheet()->getStyle("B8")->applyFromArray($border_bottom);

        $objPHPExcel->getActiveSheet()->mergeCells('A10:F10');
        $objPHPExcel->getActiveSheet()->getStyle("A10")->applyFromArray($title_red);
        $objPHPExcel->getActiveSheet()->mergeCells('G10:Q10');
        $objPHPExcel->getActiveSheet()->setCellValue('G10', "INGRESOS");
        $objPHPExcel->getActiveSheet()->getStyle("G10")->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->getStyle("G10")->applyFromArray($cell_blue);
        $objPHPExcel->getActiveSheet()->mergeCells('R10:AD10');
        $objPHPExcel->getActiveSheet()->setCellValue('R10', "EGRESOS");
        $objPHPExcel->getActiveSheet()->getStyle("R10")->applyFromArray($cell_green);
        $objPHPExcel->getActiveSheet()->getStyle("R10")->getAlignment()->setHorizontal($centerHz);

        $objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(50);
        $objPHPExcel->getActiveSheet()->setCellValue('A11', "FECHA");
        $objPHPExcel->getActiveSheet()->setCellValue('B11', "DESCRIPCION");
        $objPHPExcel->getActiveSheet()->setCellValue('C11', "No. DE PÓLIZA");
        $objPHPExcel->getActiveSheet()->setCellValue('D11', "EGRESOS");
        $objPHPExcel->getActiveSheet()->setCellValue('E11', "INGRESOS");
        $objPHPExcel->getActiveSheet()->setCellValue('F11', "Acumulado");
        $objPHPExcel->getActiveSheet()->setCellValue('G11', "Ventas al contado");
        $objPHPExcel->getActiveSheet()->setCellValue('H11', "Cobros Ctas. Por Cobrar locales");
        $objPHPExcel->getActiveSheet()->setCellValue('I11', "Préstamos bancarios desembolso");
        $objPHPExcel->getActiveSheet()->setCellValue('J11', "Cobros Ctas. Por cobrar exterior");
        $objPHPExcel->getActiveSheet()->setCellValue('K11', "Cobros Ctas. Por cobrar relacionadas locales y del exterior (1)");
        $objPHPExcel->getActiveSheet()->setCellValue('L11', "Cobros Ctas. Por cobrar Socios (2)");
        $objPHPExcel->getActiveSheet()->setCellValue('M11', "Cobros Ctas. Por cobrar empleados");
        $objPHPExcel->getActiveSheet()->setCellValue('N11', "Anticipo Clientes");
        $objPHPExcel->getActiveSheet()->setCellValue('O11', "Intereses Ganados");
        $objPHPExcel->getActiveSheet()->setCellValue('P11', "Transferencia de Fondos entre cuentas (3)");
        $objPHPExcel->getActiveSheet()->setCellValue('Q11', "Otros Ingresos");
        $objPHPExcel->getActiveSheet()->setCellValue('R11', "Pago compras al Contado");
        $objPHPExcel->getActiveSheet()->setCellValue('S11', "Pago proveedores");
        $objPHPExcel->getActiveSheet()->setCellValue('T11', "Pago Gastos Operativos");
        $objPHPExcel->getActiveSheet()->setCellValue('U11', "Pagos Anticipados");
        $objPHPExcel->getActiveSheet()->setCellValue('V11', "Pago de Prestamos (4)");
        $objPHPExcel->getActiveSheet()->setCellValue('W11', "Pago Dividendos (5)");
        $objPHPExcel->getActiveSheet()->setCellValue('X11', "Cuentas por Pagar Socios (6)");
        $objPHPExcel->getActiveSheet()->setCellValue('Y11', "Cuentas por pagar relacionadas locales (7)");
        $objPHPExcel->getActiveSheet()->setCellValue('Z11', "Cuentas por pagar Relacionadas Exterior (8)");
        $objPHPExcel->getActiveSheet()->setCellValue('AA11', "Transferencia de Fondos entre Ctas. Bancarias (9)");
        $objPHPExcel->getActiveSheet()->setCellValue('AB11', "Gastos financieros");
        $objPHPExcel->getActiveSheet()->setCellValue('AC11', "Pagos a Declaraguate");
        $objPHPExcel->getActiveSheet()->setCellValue('AD11', "Otros egresos");
        $objPHPExcel->getActiveSheet()->getStyle("A11:AD11")->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->getStyle('G11:AD11')->getAlignment()->setWrapText(true); 
        $objPHPExcel->getActiveSheet()->getStyle("A11:F11")->applyFromArray($title_red);
        $objPHPExcel->getActiveSheet()->getStyle("G11:J11")->applyFromArray($cell_blue);
        $objPHPExcel->getActiveSheet()->getStyle("K11:L11")->applyFromArray($cell_yellow);
        $objPHPExcel->getActiveSheet()->getStyle("M11:Q11")->applyFromArray($cell_blue);
        $objPHPExcel->getActiveSheet()->getStyle("R11:U11")->applyFromArray($cell_green);
        $objPHPExcel->getActiveSheet()->getStyle("V11:AA11")->applyFromArray($cell_yellow);
        $objPHPExcel->getActiveSheet()->getStyle("AB11:AD11")->applyFromArray($cell_green);
        
        $totEg = 0; $totIn = 0; $totVen = 0; $totCob1 = 0; $totPre = 0; $totCob2 = 0; $totCob3 = 0; $totCob4 = 0; $totCob5 = 0; $totAnt = 0; $totInt = 0; $totTra1 = 0; $totOtro1 = 0; 
        $totCom = 0; $totPro = 0; $totOp = 0; $totPAn = 0; $totPPr = 0; $totDiv = 0; $totPag1 = 0; $totPag2 = 0; $totPag3 = 0; $totTra2 = 0; $totGas = 0; $totDec = 0; $totOtro2 = 0;
        $sumIn = 0; $sumEg = 0; $difIn = 0; $difEg = 0;

        $a = 12; $b = 12; $c = 12; $d = 12; $e = 12; $f = 12; $g = 12; $h = 12; $i = 12; $j = 12; $k = 12; $l = 12; $m = 12; $n = 12; $o = 12; $p = 12; $q = 12; $r = 12; $s = 12; $t = 12; $u = 12; $v = 12; $w = 12; $x = 12; $y = 12; $z = 12; 
        $aa = 12; $ab = 12; $ac = 12; $ad = 12;
        if ($account_id != '') {
            $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->applyFromArray($cell_initial);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':F'.$f)->applyFromArray($cell_red);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$g.':Q'.$q)->applyFromArray($cell_blue);
            $objPHPExcel->getActiveSheet()->getStyle('R'.$r.':AD'.$ad)->applyFromArray($cell_green);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, strtoupper(strftime("%B", strtotime($initial))));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "SALDO INICIAL");
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, number_format($saldo,2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$n++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$o++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$p++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$q++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$r++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$s++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$t++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$u++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$v++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$w++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$x++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$y++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$z++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$aa++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$ab++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$ac++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$ad++, '');
        }
        $query = $this->getTransferAccount($account_id, $initial, $final);
        foreach($query->result_array() as $row)
        {
            $acc = $this->getAccountBank($row['bank_account_id']);
            $no_policy = $this->getNoPolicyByBank($row['reference_id'], $acc['nomenclature_id']);
            $ingreso = ''; $egreso = ''; $ven = ''; $cob1 = ''; $pre = ''; $cob2 = ''; $cob3 = ''; $cob4 = ''; $cob5 = ''; $ant = ''; $int = ''; $tra1 = ''; $otro1 = '';
            $com = ''; $pro = ''; $op = ''; $pan = ''; $ppr = ''; $div = ''; $pag1 = ''; $pag2 = ''; $pag3 = ''; $tra2 = ''; $gas = ''; $dec = ''; $otro2 = '';
            if($row['type'] == 1) $saldo += $row['amount']; if($row['type'] == 0) $saldo -= $row['amount'];
            if($row['type'] == 0) $egreso = number_format($row['amount'],2,'.',''); else $egreso = '-';
            if($row['type'] == 1) $ingreso = number_format($row['amount'],2,'.',''); else $ingreso = '-';
            if($row['move'] == 1) $ven = number_format($row['amount'],2,'.','');
            if($row['move'] == 2) $cob1 = number_format($row['amount'],2,'.','');
            if($row['move'] == 3) $pre = number_format($row['amount'],2,'.','');
            if($row['move'] == 4) $cob2 = number_format($row['amount'],2,'.','');
            if($row['move'] == 5) $cob3 = number_format($row['amount'],2,'.','');
            if($row['move'] == 6) $cob4 = number_format($row['amount'],2,'.','');
            if($row['move'] == 7) $cob5 = number_format($row['amount'],2,'.','');
            if($row['move'] == 8) $ant = number_format($row['amount'],2,'.','');
            if($row['move'] == 9) $int = number_format($row['amount'],2,'.','');
            if($row['move'] == 10) $tra1 = number_format($row['amount'],2,'.','');
            if($row['move'] == 11) $otro1 = number_format($row['amount'],2,'.','');
            if($row['move'] == 12) $com = number_format($row['amount'],2,'.','');
            if($row['move'] == 13) $pro = number_format($row['amount'],2,'.','');
            if($row['move'] == 14) $op = number_format($row['amount'],2,'.','');
            if($row['move'] == 15) $pan = number_format($row['amount'],2,'.','');
            if($row['move'] == 16) $ppr = number_format($row['amount'],2,'.','');
            if($row['move'] == 17) $div = number_format($row['amount'],2,'.','');
            if($row['move'] == 18) $pag1 = number_format($row['amount'],2,'.','');
            if($row['move'] == 19) $pag2 = number_format($row['amount'],2,'.','');
            if($row['move'] == 20) $pag3 = number_format($row['amount'],2,'.','');
            if($row['move'] == 21) $tra2 = number_format($row['amount'],2,'.','');
            if($row['move'] == 22) $gas = number_format($row['amount'],2,'.','');
            if($row['move'] == 23) $dec = number_format($row['amount'],2,'.','');
            if($row['move'] == 24) $otro2 = number_format($row['amount'],2,'.','');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':C'.$c)->applyFromArray($cell_red);
            $color_eg = array(); $color_in = array();
            if($row['type'] != 0) $color_eg = $cell_red; elseif($row['category'] == '') $color_eg = $cell_red; elseif($row['category'] == 5) $color_eg = $cell_yellow; else $color_eg = $cell_no;
            if($row['type'] != 1) $color_in = $cell_red; elseif($row['category'] == '') $color_in = $cell_red; elseif($row['category'] == 5) $color_in = $cell_yellow; else $color_in = $cell_no;
            $description = '';
            if($row['no_check'] != '') $description .= "No. Cheque: ".$row['no_check'];
            if($row['description'] != '' && $row['no_check'] != '') $description .= ", "; 
            $description .= $row['description'];
            if($row['description'] != '' && $row['no_check'] == '') $description .= ", "; 
            if($row['no_check'] == '') $description .= $row['code'];
            $objPHPExcel->getActiveSheet()->getStyle('D'.$d)->applyFromArray($color_eg);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$e)->applyFromArray($color_in);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$f)->applyFromArray($cell_red);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$g.':Q'.$q)->applyFromArray($cell_blue);
            $objPHPExcel->getActiveSheet()->getStyle('R'.$r.':AD'.$ad)->applyFromArray($cell_green);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$c)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, date("d/m/Y", strtotime($row['date'])));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $description);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $no_policy);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $egreso);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, $ingreso);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, number_format($saldo,2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, $ven);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, $cob1);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, $pre);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, $cob2);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, $cob3);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, $cob4);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, $cob5);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$n++, $ant);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$o++, $int);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$p++, $tra1);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$q++, $otro1);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$r++, $com);
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$s++, $pro);
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$t++, $op);
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$u++, $pan);
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$v++, $ppr);
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$w++, $div);
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$x++, $pag1);
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$y++, $pag2);
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$z++, $pag3);
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$aa++, $tra2);
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$ab++, $gas);
            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$ac++, $dec);
            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$ad++, $otro2);
            if($row['type'] == 0) $totEg += $row['amount']; if($row['type'] == 1) $totIn += $row['amount']; 
            if($row['move'] == 1) $totVen += $row['amount']; if($row['move'] == 2) $totCob1 += $row['amount']; if($row['move'] == 3) $totPre += $row['amount']; if($row['move'] == 4) $totCob2 += $row['amount']; 
            if($row['move'] == 5) $totCob3 += $row['amount']; if($row['move'] == 6) $totCob4 += $row['amount']; if($row['move'] == 7) $totCob5 += $row['amount']; if($row['move'] == 8) $totAnt += $row['amount']; 
            if($row['move'] == 9) $totInt += $row['amount']; if($row['move'] == 10) $totTra1 += $row['amount']; if($row['move'] == 11) $totOtro1 += $row['amount']; if($row['move'] == 12) $totCom += $row['amount']; 
            if($row['move'] == 13) $totPro += $row['amount']; if($row['move'] == 14) $totPOp += $row['amount']; if($row['move'] == 15) $totPAn += $row['amount']; if($row['move'] == 16) $totPPr += $row['amount']; 
            if($row['move'] == 17) $totDiv += $row['amount']; if($row['move'] == 18) $totPag1 += $row['amount']; if($row['move'] == 19) $totPag2 += $row['amount']; if($row['move'] == 20) $totPag3 += $row['amount']; 
            if($row['move'] == 21) $totTra2 += $row['amount']; if($row['move'] == 22) $totGas += $row['amount']; if($row['move'] == 23) $totDec += $row['amount']; if($row['move'] == 24) $totOtro2 += $row['amount'];
        }
        if ($account_id != '') {
            $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->applyFromArray($cell_initial);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':F'.$f)->applyFromArray($cell_red);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$g.':Q'.$q)->applyFromArray($cell_blue);
            $objPHPExcel->getActiveSheet()->getStyle('R'.$r.':AD'.$ad)->applyFromArray($cell_green);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "Ajustes");
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, number_format($saldo,2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$n++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$o++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$p++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$q++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$r++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$s++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$t++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$u++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$v++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$w++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$x++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$y++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$z++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$aa++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$ab++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$ac++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$ad++, '');
        }
        $adjs = $this->getTransferAdjustAccount($account_id, $initial, $final);
        foreach($adjs->result_array() as $row)
        {
            $acc = $this->getAccountBank($row['bank_account_id']);
            $no_policy = $this->getNoPolicyByBank($row['reference_id'], $acc['nomenclature_id']);
            $ingreso = ''; $egreso = ''; $ven = ''; $cob1 = ''; $pre = ''; $cob2 = ''; $cob3 = ''; $cob4 = ''; $cob5 = ''; $ant = ''; $int = ''; $tra1 = ''; $otro1 = '';
            $com = ''; $pro = ''; $op = ''; $pan = ''; $ppr = ''; $div = ''; $pag1 = ''; $pag2 = ''; $pag3 = ''; $tra2 = ''; $gas = ''; $dec = ''; $otro2 = '';
            if($row['type'] == 1) $saldo += $row['amount']; if($row['type'] == 0) $saldo -= $row['amount'];
            if($row['type'] == 0) $egreso = number_format($row['amount'],2,'.',''); else $egreso = '-';
            if($row['type'] == 1) $ingreso = number_format($row['amount'],2,'.',''); else $ingreso = '-';
            if($row['move'] == 1) $ven = number_format($row['amount'],2,'.','');
            if($row['move'] == 2) $cob1 = number_format($row['amount'],2,'.','');
            if($row['move'] == 3) $pre = number_format($row['amount'],2,'.','');
            if($row['move'] == 4) $cob2 = number_format($row['amount'],2,'.','');
            if($row['move'] == 5) $cob3 = number_format($row['amount'],2,'.','');
            if($row['move'] == 6) $cob4 = number_format($row['amount'],2,'.','');
            if($row['move'] == 7) $cob5 = number_format($row['amount'],2,'.','');
            if($row['move'] == 8) $ant = number_format($row['amount'],2,'.','');
            if($row['move'] == 9) $int = number_format($row['amount'],2,'.','');
            if($row['move'] == 10) $tra1 = number_format($row['amount'],2,'.','');
            if($row['move'] == 11) $otro1 = number_format($row['amount'],2,'.','');
            if($row['move'] == 12) $com = number_format($row['amount'],2,'.','');
            if($row['move'] == 13) $pro = number_format($row['amount'],2,'.','');
            if($row['move'] == 14) $op = number_format($row['amount'],2,'.','');
            if($row['move'] == 15) $pan = number_format($row['amount'],2,'.','');
            if($row['move'] == 16) $ppr = number_format($row['amount'],2,'.','');
            if($row['move'] == 17) $div = number_format($row['amount'],2,'.','');
            if($row['move'] == 18) $pag1 = number_format($row['amount'],2,'.','');
            if($row['move'] == 19) $pag2 = number_format($row['amount'],2,'.','');
            if($row['move'] == 20) $pag3 = number_format($row['amount'],2,'.','');
            if($row['move'] == 21) $tra2 = number_format($row['amount'],2,'.','');
            if($row['move'] == 22) $gas = number_format($row['amount'],2,'.','');
            if($row['move'] == 23) $dec = number_format($row['amount'],2,'.','');
            if($row['move'] == 24) $otro2 = number_format($row['amount'],2,'.','');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':C'.$c)->applyFromArray($cell_red);
            $color_eg = array(); $color_in = array();
            if($row['type'] != 0) $color_eg = $cell_red; elseif($row['category'] == '') $color_eg = $cell_red; elseif($row['category'] == 5) $color_eg = $cell_yellow; else $color_eg = $cell_no;
            if($row['type'] != 1) $color_in = $cell_red; elseif($row['category'] == '') $color_in = $cell_red; elseif($row['category'] == 5) $color_in = $cell_yellow; else $color_in = $cell_no;
            $description = '';
            if($row['no_check'] != '') $description .= "No. Cheque: ".$row['no_check'];
            if($row['description'] != '' && $row['no_check'] != '') $description .= ", "; 
            $description .= $row['description'];
            if($row['description'] != '' && $row['no_check'] == '') $description .= ", "; 
            if($row['no_check'] == '') $description .= $row['code'];
            $objPHPExcel->getActiveSheet()->getStyle('D'.$d)->applyFromArray($color_eg);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$e)->applyFromArray($color_in);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$f)->applyFromArray($cell_red);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$g.':Q'.$q)->applyFromArray($cell_blue);
            $objPHPExcel->getActiveSheet()->getStyle('R'.$r.':AD'.$ad)->applyFromArray($cell_green);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$c)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, date("d/m/Y", strtotime($row['date'])));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $description);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $no_policy);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $egreso);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, $ingreso);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, number_format($saldo,2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, $ven);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, $cob1);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, $pre);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, $cob2);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, $cob3);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, $cob4);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, $cob5);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$n++, $ant);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$o++, $int);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$p++, $tra1);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$q++, $otro1);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$r++, $com);
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$s++, $pro);
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$t++, $op);
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$u++, $pan);
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$v++, $ppr);
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$w++, $div);
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$x++, $pag1);
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$y++, $pag2);
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$z++, $pag3);
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$aa++, $tra2);
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$ab++, $gas);
            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$ac++, $dec);
            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$ad++, $otro2);
            if($row['type'] == 0) $totEg += $row['amount']; if($row['type'] == 1) $totIn += $row['amount']; 
            if($row['move'] == 1) $totVen += $row['amount']; if($row['move'] == 2) $totCob1 += $row['amount']; if($row['move'] == 3) $totPre += $row['amount']; if($row['move'] == 4) $totCob2 += $row['amount']; 
            if($row['move'] == 5) $totCob3 += $row['amount']; if($row['move'] == 6) $totCob4 += $row['amount']; if($row['move'] == 7) $totCob5 += $row['amount']; if($row['move'] == 8) $totAnt += $row['amount']; 
            if($row['move'] == 9) $totInt += $row['amount']; if($row['move'] == 10) $totTra1 += $row['amount']; if($row['move'] == 11) $totOtro1 += $row['amount']; if($row['move'] == 12) $totCom += $row['amount']; 
            if($row['move'] == 13) $totPro += $row['amount']; if($row['move'] == 14) $totPOp += $row['amount']; if($row['move'] == 15) $totPAn += $row['amount']; if($row['move'] == 16) $totPPr += $row['amount']; 
            if($row['move'] == 17) $totDiv += $row['amount']; if($row['move'] == 18) $totPag1 += $row['amount']; if($row['move'] == 19) $totPag2 += $row['amount']; if($row['move'] == 20) $totPag3 += $row['amount']; 
            if($row['move'] == 21) $totTra2 += $row['amount']; if($row['move'] == 22) $totGas += $row['amount']; if($row['move'] == 23) $totDec += $row['amount']; if($row['move'] == 24) $totOtro2 += $row['amount'];
        }
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':F'.$f)->applyFromArray($cell_red);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$g.':AD'.$ad)->applyFromArray($cell_initial);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, date("d/m/Y", strtotime($final)));
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "SALDO FINAL PARA EL SIGUIENTE PERIODO");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format($totEg,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, number_format($totIn,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, number_format($saldo,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, number_format($totVen,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, number_format($totCob1,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, number_format($totPre,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, number_format($totCob2,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, number_format($totCob3,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, number_format($totCob4,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, number_format($totCob5,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$n++, number_format($totAnt,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$o++, number_format($totInt,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('P'.$p++, number_format($totTra1,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$q++, number_format($totOtro1,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('R'.$r++, number_format($totCom,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('S'.$s++, number_format($totPro,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('T'.$t++, number_format($totOp,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('U'.$u++, number_format($totPAn,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('V'.$v++, number_format($totPPr,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('W'.$w++, number_format($totDiv,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('X'.$x++, number_format($totPag1,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('Y'.$y++, number_format($totPag2,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('Z'.$z++, number_format($totPag3,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('AA'.$aa++, number_format($totTra2,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('AB'.$ab++, number_format($totGas,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('AC'.$ac++, number_format($totDec,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('AD'.$ad++, number_format($totOtro2,2,'.',''));
        $objPHPExcel->getActiveSheet()->getStyle("D12:AD".($ad-1))->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);

        $nT = $d;
        $sumIn = $totVen + $totCob1 + $totPre + $totCob2 + $totCob3 + $totCob4 + $totCob5 + $totAnt + $totInt + $totTra1 + $totOtro1;
        $sumEg = $totCom + $totPro + $totPOp + $totPAn + $totPPr + $totDiv + $totPag1 + $totPag2 + $totPag3 + $totTra2 + $totGas + $totDec + $totOtro2;

        $ingreso = ''; $egreso = '';
        if($totEg > 0) $egreso = number_format($totEg,2,'.',''); else $egreso = '-';
        if($totIn > 0) $ingreso = number_format($totIn,2,'.',''); else $ingreso = '-';
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':C'.$c);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, '');
        $objPHPExcel->getActiveSheet()->getStyle('G'.$g)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d, $egreso);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, $ingreso);
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$g.':Q'.$q);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g, '');
        $objPHPExcel->getActiveSheet()->getStyle('G'.$g)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('R'.$r.':AD'.$ad);
        $objPHPExcel->getActiveSheet()->setCellValue('R'.$r, '');
        $objPHPExcel->getActiveSheet()->getStyle('R'.$r)->getAlignment()->setHorizontal($centerHz);
        $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++; $n++; $o++; $p++; $q++; $r++; $s++; $t++; $u++; $v++; $w++; $x++; $y++; $z++; 
        $aa++; $ab++; $ac++; $ad++;
        
        $ingreso = ''; $egreso = '';
        if($sumEg > 0) $egreso = number_format($sumEg,2,'.',''); else $egreso = '-';
        if($sumIn > 0) $ingreso = number_format($sumIn,2,'.',''); else $ingreso = '-';
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':C'.$c);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, '');
        $objPHPExcel->getActiveSheet()->getStyle('G'.$g)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d, $egreso);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, $ingreso);
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$g.':Q'.$q);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g, '');
        $objPHPExcel->getActiveSheet()->getStyle('G'.$g)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('R'.$r.':AD'.$ad);
        $objPHPExcel->getActiveSheet()->setCellValue('R'.$r, '');
        $objPHPExcel->getActiveSheet()->getStyle('R'.$r)->getAlignment()->setHorizontal($centerHz);
        $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++; $n++; $o++; $p++; $q++; $r++; $s++; $t++; $u++; $v++; $w++; $x++; $y++; $z++; 
        $aa++; $ab++; $ac++; $ad++;
        
        $difEg = $totEg - $sumEg; $difIn = $totIn - $sumIn;
        $ingreso = ''; $egreso = '';
        $egreso .= number_format($difEg,2,'.','');
        $ingreso .= number_format($difIn,2,'.','');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':C'.$c);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, '');
        $objPHPExcel->getActiveSheet()->getStyle('G'.$g)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d, $egreso);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, $ingreso);
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$g.':Q'.$q);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g, '');
        $objPHPExcel->getActiveSheet()->getStyle('G'.$g)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('R'.$r.':AD'.$ad);
        $objPHPExcel->getActiveSheet()->setCellValue('R'.$r, '');
        $objPHPExcel->getActiveSheet()->getStyle('R'.$r)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$nT.':E'.$e)->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
        $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++; $n++; $o++; $p++; $q++; $r++; $s++; $t++; $u++; $v++; $w++; $x++; $y++; $z++; 
        $aa++; $ab++; $ac++; $ad++;
        
        $objPHPExcel->getActiveSheet()->getStyle("A10:AD".($ad-1))->applyFromArray($border_style);
       
        foreach(range('A','Z') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);

        $nCol = 1;
        foreach(range('G','Z') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setVisible(in_array($nCol, $checks));
            $nCol++;
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setVisible(in_array($nCol, $checks)); $nCol++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setVisible(in_array($nCol, $checks)); $nCol++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setVisible(in_array($nCol, $checks)); $nCol++;
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setVisible(in_array($nCol, $checks)); $nCol++;

        $objPHPExcel->getActiveSheet()->setTitle('Libro_de_Bancos');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="libro_de_bancos_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printSalesBookExcel()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial        = $this->input->post('initial');
        $final          = $this->input->post('final');
        $institution_id = $this->input->post('institution_id');
        $camp           = $this->input->post('camp');
        $text           = $this->input->post('text');
        $checks = json_decode($this->getInfo("checks_sales"));
        $totalDebe = 0;
        $totalHaber = 0;
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "LIBRO DE VENTAS Y SERVICIOS PRESTADOS");
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('A3:N3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->getStyle("A3")->getAlignment()->setHorizontal($centerHz);

        $a = 5; $b = 5; $c = 5; $d = 5; $e = 5; $f = 5; $g = 5; $h = 5; $i = 5; $j = 5; $k = 5; $l = 5; $m = 5; $n = 5;
        if ($institution_id != '') {
            $ins = $this->crud_model->getInstitution($institution_id);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':B'.$b);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "CONTRIBUYENTE:");
            $objPHPExcel->getActiveSheet()->mergeCells('C'.$c.':E'.$e);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $ins['personal_name']);
            $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':B'.$b);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "NOMBRE COMERCIAL:");
            $objPHPExcel->getActiveSheet()->mergeCells('C'.$c.':E'.$e);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $ins['name']);
            $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':B'.$b);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "DIRECCIÓN COMERCIAL:");
            $objPHPExcel->getActiveSheet()->mergeCells('C'.$c.':E'.$e);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, $ins['address']);
            $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++;
            $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "PERIODO");
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$b.':E'.$e);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, "DEL ".strtoupper(strftime("%d DEL %B", strtotime($initial))." AL ".strftime("%d DEL %Y", strtotime($final))));
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$g.':H'.$h);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g, "NIT: ".$this->getInfo("nit"));
        
        $a += 2; $b += 2; $c += 2; $d += 2; $e += 2; $f += 2; $g += 2; $h += 2; $i += 2; $j += 2; $k += 2; $l += 2; $m += 2; $n += 2;
        $cellI = $a;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "FECHA");
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$b.':D'.$d);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, "Documento");
        $objPHPExcel->getActiveSheet()->mergeCells('E'.$e.':F'.$f);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, "COMPRADOR");
        $objPHPExcel->getActiveSheet()->getStyle('E'.$e)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g, "EST");
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$h, "Total Factura venta/servicio");
        $objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':J'.$j);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, "PRECIO BASE");
        $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$k, "ISR S/VENTAS");
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$l, "EXENTA DEL IVA");
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$m, "IVA DEBITO FISCAL");
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, "TOTALES");
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':M'.$m)->getAlignment()->setWrapText(true); 
        $a++; $b++; $c++; $d++; $e++; $f++; $g++; $h++; $i++; $j++; $k++; $l++; $m++; $n++;
        $objPHPExcel->getActiveSheet()->getStyle("A".$cellI.":M".$m)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "Tipo");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, "No. Serie");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, "Del No. Al No.");
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, "NIT O DPI");
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, "NOMBRE");
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, "VENTA");
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, "SERVICIO");
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$n++, '');
        $nI = $g;
        $totalAmount = 0; $totalSale = 0; $totalService = 0; $totalISR = 0; $totalExe = 0; $totalIVA = 0; $totalTotal = 0;
        $query = $this->getSalesBook($initial, $final, $institution_id.'-'.$camp.'-'.$text);
        foreach($query->result_array() as $row)
        {
            $ins = $this->getInstitution($row['institution_id']);
            $issue = $this->getIssueBySale($row['sale_id']);
            $doc = ''; $inst_code = $ins['code']; $total = ''; $venta = ''; $servicio = ''; $isr = ''; $exe = ''; $iva = '';
            if($row['type_invoice'] == 'N') $doc = "FACT"; elseif($row['type_invoice'] == 'C') $doc = "FCAM"; elseif($row['type_note'] == 'C') $doc = "N.C"; elseif($row['type_note'] == 'D') $doc = "N.D"; elseif($row['type_note'] == 'A') $doc = 'N';
            if($isn['mode'] == 0) $inst_code .= " *";
            if($row['status'] == 1) {
                $total = number_format($row['total'],2,'.',''); 
                $iva = number_format($row['iva'],2,'.','');
            } else {
                $total = '-'; $iva = '-';
            }
            if($row['type'] == 'V' && $row['status'] == 1) $venta = number_format($row['amount'],2,'.',''); else $venta = '-';
            if($row['type'] == 'S' && $row['status'] == 1) $servicio = number_format($row['amount'],2,'.',''); else $servicio = '-';
            if($row['type'] == 'V' && $row['total'] > 2500 && $row['status'] == 1) $isr = number_format($row['isr'],2,'.',''); else $isr = '-';
            if($row['exempt'] == 1 && $row['status'] == 1) $exe = number_format($row['iva'],2,'.',''); else $exe = '-';
            $objPHPExcel->getActiveSheet()->getStyle('F'.$f)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, date("d/m/Y", strtotime($row['date'])));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $doc);
            $objPHPExcel->getActiveSheet()->getStyle("C".$c)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $issue['no_serie']);
            $objPHPExcel->getActiveSheet()->getStyle("D".$d)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $row['invoice']);
            $objPHPExcel->getActiveSheet()->getStyle("E".$e)->getAlignment()->setHorizontal($centerHz);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, $row['nit']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, $row['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, $inst_code);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, $total);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, $venta);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, $servicio);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, $isr);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, $exe);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, $iva);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$n++, $total);
            if ($row['status'] == 1) {
                $totalAmount += $row['total']; if($row['type'] == 'V') $totalSale += $row['amount']; if ($row['type'] == 'S') $totalService += $row['amount'];
                if($row['type'] == 'V' && $row['total'] > 2500) $totalISR += $row['isr']; if($row['exempt'] == 1) $totalExe += $row['iva']; $totalIVA += $row['iva']; $totalTotal += $row['total'];
            }
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, '');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$f, '');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g, "Totales:");
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$h, number_format($totalAmount,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, number_format($totalSale,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$j, number_format($totalService,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$k, number_format($totalISR,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$l, number_format($totalIExe,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$m, number_format($totalIVA,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, number_format($totalTotal,2,'.',''));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':N'.$n)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$cellI.":N".$n)->applyFromArray($border_style);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$nI.':N'.$n)->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
       
        $nCol = 2;
        foreach(range('A','N') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setVisible(in_array($nCol, $checks));
            $nCol++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Libro_de_Ventas');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="libro_de_ventas_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printClientsBookExcel()
    {
        
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial    = $this->input->post('initial');
        $final      = $this->input->post('final');
        $visitor_id = $this->input->post('visitor_id');
        $client_id  = $this->input->post('client_id');
        $commission = $this->input->post('commission');
        $checks = json_decode($this->getInfo("checks_clients"));
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "CUENTAS POR COBRAR");
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('A3:M3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->getStyle("A3")->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('A4:M4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->getStyle("A4")->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('A5:M5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', "Nit: ".$this->getInfo("nit"));
        $objPHPExcel->getActiveSheet()->getStyle("A5")->getAlignment()->setHorizontal($centerHz);

        $a = 7; $b = 7; $c = 7; $d = 7; $e = 7; $f = 7; $g = 7; $h = 7; $i = 7; $j = 7; $k = 7; $l = 7; $m = 7;
        if ($initial != '' && $final != '') {
            $text = "DEL ".strtoupper(strftime("%d DE %B AL ", strtotime($initial))).date('d ', strtotime($final));
            if (date('m', strtotime($initial)) != date('m', strtotime($final))) $text .= strftime("DE %B ", strtotime($final));
            $text .= strftime("DEL %Y", strtotime($final));
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':M'.$m);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $text);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
            $a += 2; $b += 2; $c += 2; $d += 2; $e += 2; $f += 2; $g += 2; $h += 2; $i += 2; $j += 2; $k += 2; $l += 2; $m += 2;
        }

        $cellI = $a;
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":M".$m)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "Cod. cliente");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, "Nombre del cliente");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, "Nit");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, "Dirección");
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, "Tel");
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, "Vendedor");
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, "No. de factura");
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, "Fecha de emisión");
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, "Fecha de vencimiento");
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, "Cargo total");
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, "Abonos");
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, "Saldo pendiente");
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, "Observaciones");
        
        $amount = 0; $total = 0;
        $query = $this->getClientsBook();
        foreach($query->result_array() as $row)
        {
            $visit = $this->getVisitor($row['visitor_id']);
            $issue = $this->getIssueBySale($row['sale_id']);
            $date_issue = ''; if($issue['date'] != '') $date_issue = date("d/m/Y", strtotime($issue['date_issue'])); else $date_issue = date("d/m/Y", strtotime($row['date']));
            $due_date = ''; if($row['due_date'] != '') $due_date = date("d/m/Y", strtotime($row['due_date']));
            $charges = ''; if($row['type_invoice'] == 'C') $charges = number_format($row['charges'],2,'.',''); else $charges = '-';
            $residue = ''; if($row['type_invoice'] == 'C') $residue = number_format($row['residue'],2,'.',''); else $residue = '-';
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $row['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $row['first_name'].' '.$row['last_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $row['nit']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $row['address']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, $row['phone']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, $visit['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, $row['invoice']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, $date_issue);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, $due_date);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$j++, number_format($row['total_due'],2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$k++, $charges);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$l++, $residue);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$m++, $row['details']);
            $totalTotal += $row['total']; 
            if($row['type_invoice'] == 'C') { 
                $totalCredit += $row['total'];
                $totalCharge += $row['charges']; 
                $totalResidue += $row['residue'];
            } elseif($row['type_invoice'] == 'N') { 
                $totalCashed += $row['total'];
            }
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "Totales");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$e, '');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$f, '');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$g, '');
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$h, '');
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, '');
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$j, number_format($totalTotal,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$k, number_format($totalCharge,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$l, number_format($totalResidue,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$m, '');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':M'.$m)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('J'.($cellI+1).":L".$l)->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
        $objPHPExcel->getActiveSheet()->getStyle("A".$cellI.":M".$m)->applyFromArray($border_style);
       
        $nCol = 2;
        foreach(range('A','M') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setVisible(in_array($nCol, $checks));
            $nCol++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Libro de Clientes');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="libro_de_clientes_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }
    
    
    function printBalancesExcel()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial = $this->input->post('initial');
        $final   = $this->input->post('final');
        $debe = 0; $haber = 0;
        $date = "DEL ".strtoupper(strftime("%d DE %B AL ", strtotime($initial))).date('d ', strtotime($final));
        if (date('m', strtotime($initial)) != date('m', strtotime($final))) $date .= strftime("DE %B ", strtotime($final));
        $date .= strftime("DEL %Y", strtotime($final));
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'BALANCE DE SALDOS');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->mergeCells('A5:D5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', $date);
        $objPHPExcel->getActiveSheet()->getStyle("A2:A5")->getAlignment()->setHorizontal($centerHz);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'CÓDIGO');
        $objPHPExcel->getActiveSheet()->setCellValue('B7', 'RUBRO');
        $objPHPExcel->getActiveSheet()->setCellValue('C7', 'DEBE');
        $objPHPExcel->getActiveSheet()->setCellValue('D7', 'HABER');
        
        $a = 8; $b = 8; $c = 8; $d = 8;

        $query = $this->getSumBalance($initial, $final);
        foreach($query->result_array() as $row)
        {
            $saldo = 0; $debe = ''; $haber = '';
            $info = explode('.', $row['code']);
            if($info[0] == 1 || $info[0] == 5) {
                $saldo = $row['debe'] - $row['haber'];
                if ($saldo < 0) if($saldo < 0) $debe .= '-'; $debe .= 'Q'.number_format(abs($saldo),2,'.',',');
            } elseif($info[0] == 2 || $info[0] == 3 || $info[0] == 4) {
                $saldo = $row['haber'] - $row['debe'];
                if ($saldo < 0) if($saldo < 0) $haber .= '-'; $haber .= 'Q'.number_format(abs($saldo),2,'.',',');
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $row['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $row['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $debe);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $haber);
        }
        $objPHPExcel->getActiveSheet()->getStyle("A7:D".$d)->applyFromArray($border_style);
        $objPHPExcel->getActiveSheet()->getStyle("C8:D".($d-1))->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
        $objPHPExcel->getActiveSheet()->getStyle("A7:D".($d-1))->applyFromArray($border_style);
       
        foreach(range('A','D') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Libro_Diario');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="libro_diario_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printConciliationExcel()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $bank_account_id       = $this->input->post('bank_account_id');
        $initial               = $this->input->post('initial');
        $final                 = $this->input->post('final');
        $balance_ledge         = $this->input->post('balance_ledge');
        $note_credit           = $this->input->post('note_credit');
        $amount_credit         = $this->input->post('amount_credit');
        $total_note_credit     = $this->input->post('total_note_credit');
        $subtotal_note_credit  = $this->input->post('subtotal_note_credit');
        $note_debit            = $this->input->post('note_debit');
        $amount_debit          = $this->input->post('amount_debit');
        $total_note_debit      = $this->input->post('total_note_debit');
        $subtotal_note_debit   = $this->input->post('subtotal_note_debit');
        $balance_1             = $this->input->post('balance_1');
        $balance_account       = $this->input->post('balance_account');
        $note_check            = $this->input->post('note_check');
        $amount_check          = $this->input->post('amount_check');
        $total_bank_check      = $this->input->post('total_bank_check');
        $subtotal_bank_check   = $this->input->post('subtotal_bank_check');
        $note_deposit          = $this->input->post('note_deposit');
        $amount_deposit        = $this->input->post('amount_deposit');
        $total_bank_deposit    = $this->input->post('total_bank_deposit');
        $subtotal_bank_deposit = $this->input->post('subtotal_bank_deposit');
        $balance_2             = $this->input->post('balance_2');
        $elaborate_name        = $this->input->post('elaborate_name');
        $elaborate_charge      = $this->input->post('elaborate_charge');
        $approve_name          = $this->input->post('approve_name');
        $approve_charge        = $this->input->post('approve_charge');
        $check_name            = $this->input->post('check_name');
        $check_charge          = $this->input->post('check_charge');
        
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_top = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_bottom = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $back_color = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'd8d8d8')));
        $border_bottom_double = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('argb' => '000000'),)));
        $acc = $this->getBankAccount($bank_account_id);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->mergeCells('A4:C4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', "Conciliación Bancaria");
        $objPHPExcel->getActiveSheet()->mergeCells('A5:C5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', "Banco ".$acc['name']." ".$acc['code']);
        $objPHPExcel->getActiveSheet()->mergeCells('A6:C6');
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'DEL '.strtoupper(strftime("%d DEL %B", strtotime($initial)).' AL '.strftime("%d DE %B DEL %Y", strtotime($final))));
        $objPHPExcel->getActiveSheet()->getStyle("A2:A6")->getAlignment()->setHorizontal($centerHz);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A8', '');
        $objPHPExcel->getActiveSheet()->setCellValue('B8', "Parcial");
        $objPHPExcel->getActiveSheet()->setCellValue('C8', "Total");
        $objPHPExcel->getActiveSheet()->getStyle("B8:C8")->applyFromArray($border_style);
        $objPHPExcel->getActiveSheet()->getStyle("B8:C8")->applyFromArray($back_color);
        $text = '';
        if($balance_ledge < 0) $text .= '-'; 
        $text .= number_format(abs($balance_ledge),2,'.','');
        $objPHPExcel->getActiveSheet()->setCellValue('A9', "SALDO FINAL SEGÚN LIBRO MAYOR DE BANCOS");
        $objPHPExcel->getActiveSheet()->setCellValue('B9', '');
        $objPHPExcel->getActiveSheet()->setCellValue('C9', $text);
        $objPHPExcel->getActiveSheet()->getStyle("A9:B9")->applyFromArray($border_top);
        $objPHPExcel->getActiveSheet()->getStyle("A9:B9")->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->getStyle("A9:C9")->applyFromArray($back_color);
        $objPHPExcel->getActiveSheet()->setCellValue('A10', "(+) Notas de crédito");
        $objPHPExcel->getActiveSheet()->setCellValue('B10', '');
        $objPHPExcel->getActiveSheet()->setCellValue('C10', '');
        
        $a = 11; $b = 11; $c = 11;

        for ($i=0; $i < count($note_credit); $i++) { 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $note_credit[$i]);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, number_format($amount_credit[$i],2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        }

        $text1 = '';
        if($total_note_credit < 0) $text1 .= '-'; 
        $text1 .= number_format(abs($total_note_credit),2,'.','');
        if (count($note_credit) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, 'Subtotal');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($subtotal_note_credit,2,'.',''));
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "(-) Notas de crédito");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $text1 = '';
        if($total_note_debit < 0) $text1 .= '-'; 
        $text1 .= number_format(abs($total_note_debit),2,'.','');
        $text2 = number_format($subtotal_note_debit,2,'.','');
        $text3 = '';
        for ($i=0; $i < count($note_debit); $i++) { 
            if ($i == (count($note_debit) - 1)) $text3 = $text2;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $note_debit[$i]);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, number_format($amount_debit[$i],2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $text3);
        }

        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":B".$b)->applyFromArray($border_top);
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":B".$b)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":C".$c)->applyFromArray($back_color);
        $objPHPExcel->getActiveSheet()->getStyle("C".$c)->applyFromArray($border_bottom_double);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "Saldo a conciliar");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($balance_1,2,'.',''));

        $a++; $b++; $c++;

        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":B".$b)->applyFromArray($border_top);
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":B".$b)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":C".$c)->applyFromArray($back_color);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "SALDO AL FINAL SEGÚN ESTADO DE CUENTA");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($balance_account,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "(-) Cheques girados y no cobrados");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');

        for ($i=0; $i < count($note_check); $i++) { 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $note_check[$i]);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, number_format($amount_check[$i],2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        }

        $text1 = '';
        if($total_bank_check < 0) $text1 .= '-'; 
        $text1 .= number_format(abs($total_bank_check),2,'.','');
        if (count($note_check) > 0){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, 'Subtotal');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format($subtotal_bank_check,2,'.',''));
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "(+) Depositos en tránsito");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');

        $text1 = '';
        if($total_bank_deposit < 0) $text1 .= '-'; 
        $text1 .= number_format(abs($total_bank_deposit),2,'.','');
        $text2 = number_format($subtotal_bank_deposit,2,'.','');
        $text3 = '';
        for ($i=0; $i < count($note_deposit); $i++) {
            if ($i == (count($note_debit) - 1)) $text3 = $text2;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $note_deposit[$i]);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, number_format($amount_deposit[$i],2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $text3);
        }
       
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":B".$b)->applyFromArray($border_top);
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":B".$b)->applyFromArray($border_bottom);
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":C".$c)->applyFromArray($back_color);
        $objPHPExcel->getActiveSheet()->getStyle("C".$c)->applyFromArray($border_bottom_double);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "Saldo a conciliar");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c, number_format($balance_2,2,'.',''));
        $objPHPExcel->getActiveSheet()->getStyle("B11:C".$c)->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);

        $a += 2; $b += 2; $c += 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "Elabora:______________________________");
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$b.':C'.$c);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, "Aprueba:______________________________");
        $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->getAlignment()->setHorizontal($centerHz);
        $a++; $b++; $c++;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $elaborate_name);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$b.':C'.$c);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, $approve_name);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->getAlignment()->setHorizontal($centerHz);
        $a++; $b++; $c++;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $elaborate_charge);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$b.':C'.$c);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, $approve_charge);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->getAlignment()->setHorizontal($centerHz);
        $a += 2; $b += 2; $c += 2;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':C'.$c);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "Revisa:______________________________");
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $a++; $b++; $c++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':C'.$c);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $check_name);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $a++; $b++; $c++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':C'.$c);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $check_charge);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);

        foreach(range('A','C') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Conciliacion_Bancaria');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="conciliacion_bancaria_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    function printCashFlowExcel()
    {
        setlocale(LC_TIME,"es_ES");
        define('FORMAT_CURRENCY_NIS_SIMPLE', '_("Q"* #,##0.00_)');
        $hoy = date("Y-m-d-H-i-s");
        $initial            = $this->input->post('initial');
        $final              = $this->input->post('final');
        $utility            = $this->input->post('utility');
        $no_moves           = $this->input->post('no_moves');
        $note_operation     = $this->input->post('note_operation');
        $amount_operation   = $this->input->post('amount_operation');
        $subtotal_operation = $this->input->post('subtotal_operation');
        $note_invest        = $this->input->post('note_invest');
        $amount_invest      = $this->input->post('amount_invest');
        $subtotal_invest    = $this->input->post('subtotal_invest');
        $note_finance       = $this->input->post('note_finance');
        $amount_finance     = $this->input->post('amount_finance');
        $subtotal_finance   = $this->input->post('subtotal_finance');
        $total_activities   = $this->input->post('total_activities');
        $check_equals       = $this->input->post('check_equals');
        $increase           = $this->input->post('increase');
        $equal_initial      = $this->input->post('equal_initial');
        $equal_final        = $this->input->post('equal_final');
        $description        = $this->input->post('description');
        $legal_name         = $this->input->post('legal_name');
        $legal_charge       = $this->input->post('legal_charge');
        $account_name       = $this->input->post('account_name');
        $account_charge     = $this->input->post('account_charge');
        
        $centerAll = array(
            'aligment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $centerHz = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $centerVt = PHPExcel_Style_Alignment::VERTICAL_CENTER;
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_right = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_bottom = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '000000'),)));
        $border_bottom_double = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('argb' => '000000'),)));
        $acc = $this->getBankAccount($bank_account_id);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "FLUJO DE EFECTIVO");
        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
        $objPHPExcel->getActiveSheet()->getStyle("A3")->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $this->getInfo("description"));
        $objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', $this->getInfo("system_name"));
        $objPHPExcel->getActiveSheet()->mergeCells('A5:D5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', "DEL ".strtoupper(strftime("%d DEL %B", strtotime($initial))." AL ".strftime("%d DE %B DEL %Y", strtotime($final))));
        $objPHPExcel->getActiveSheet()->getStyle("A2:A5")->getAlignment()->setHorizontal($centerHz);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A7', "Utilidad del Ejercicio");
        $objPHPExcel->getActiveSheet()->setCellValue('B7', '');
        $objPHPExcel->getActiveSheet()->setCellValue('C7', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D7', number_format($utility,2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('A8', "Cuentas que no originan movimiento de efectivo");
        $objPHPExcel->getActiveSheet()->setCellValue('B8', '');
        $objPHPExcel->getActiveSheet()->setCellValue('C8', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D8', number_format(abs($no_moves),2,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('A10', "CONCILIACIÓN ENTRE LA UTILIDAD NETA");
        $objPHPExcel->getActiveSheet()->setCellValue('A11', "Y FLUJO DE EFECTIVO PROVISTO POR");
        $objPHPExcel->getActiveSheet()->getStyle("A10:A11")->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->setCellValue('A14', "Actividades de Operación");
        
        $a = 15; $b = 15; $c = 15; $d = 15;

        for ($i=0; $i < count($note_operation); $i++) { 
            $text1 = ''; if(count($note_operation) > 1) $text1 = number_format(abs($amount_operation[$i]),2,'.','');
            $text2 = ''; if(count($note_operation) == 1) $text2 = number_format(abs($subtotal_operation),2,'.','');
            if($i == (count($note_operation) - 1) && count($note_operation) > 1)
                $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->applyFromArray($border_bottom);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $note_operation[$i]);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $text1);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $text2);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        }
        if (count($note_operation) == 1){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        }
        if (count($note_operation) > 1){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format(abs($subtotal_operation),2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "ACTIVIDADES DE INVERSIÓN");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        for ($i=0; $i < count($note_invest); $i++) { 
            $text1 = ''; if(count($note_invest) > 1) $text1 = number_format(abs($amount_invest[$i]),2,'.','');
            $text2 = ''; if(count($note_invest) == 1) $text2 = number_format(abs($subtotal_invest),2,'.','');
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $note_invest[$i]);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $text1);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $text2);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        }
        if (count($note_invest) == 1){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        }
        if (count($note_invest) > 1){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format(abs($subtotal_invest),2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "ACTIVIDADES DE FINANCIAMIENTO");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        for ($i=0; $i < count($note_finance); $i++) { 
            $text = ''; if($i == (count($note_finance) - 1)) $text = number_format(abs($total_activities),2,'.','');
            if($i == (count($note_finance) - 1)) 
                $objPHPExcel->getActiveSheet()->getStyle('C'.$c)->applyFromArray($border_bottom);
            if($i == (count($note_finance) - 1)) 
                $objPHPExcel->getActiveSheet()->getStyle('D'.$d)->applyFromArray($border_bottom);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $note_finance[$i]);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, number_format(abs($amount_finance[$i]),2,'.',''));
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $text);
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');
        if ($check_equals) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "AUMENTO NETO DE EFECTIVO");
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');

            $objPHPExcel->getActiveSheet()->getStyle('C'.$c.':D'.$d)->applyFromArray($border_bottom);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "Y EQUIVALENTES DE EFECTIVO");
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format(abs($increase),2,'.',''));
            
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "EFECTIVO Y EQUIVALENTES DE EFECTIVO");
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');

            $objPHPExcel->getActiveSheet()->getStyle('C'.$c.':D'.$d)->applyFromArray($border_bottom);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "DEL ".strtoupper(strftime("%d de %B del %Y", strtotime($initial))));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format(abs($equal_initial),2,'.',''));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "EFECTIVO Y EQUIVALENTES DE EFECTIVO");
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, '');

            $objPHPExcel->getActiveSheet()->getStyle('C'.$c.':D'.$d)->applyFromArray($border_bottom_double);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, "AL ".strtoupper(strftime("%d de %B del %Y", strtotime($final))));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, '');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, number_format(abs($equal_final),2,'.',''));
        }
        $objPHPExcel->getActiveSheet()->getStyle("B7:D".($d-1))->getNumberFormat()->setFormatCode(FORMAT_CURRENCY_NIS_SIMPLE);
        
        $a += 3; $b += 3; $c += 3; $d += 3;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':D'.($d+2));
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, trim($this->input->post('description')));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setWrapText(true); 
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":D".$d)->applyFromArray($centerAll);
        $a += 6; $b += 6; $c += 6; $d += 6;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':D'.$d);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $this->getInfo("address").' '.strftime("%d de %B del %Y"));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':D'.$d)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a.':D'.$d)->getAlignment()->setVertical($centerVt);

        $a += 4; $b += 4; $c += 4; $d += 4;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "______________________________________");
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$b.':D'.$d);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, "_____________________________________");
        $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->getAlignment()->setHorizontal($centerHz);
        $a++; $b++; $c++; $d++;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $legal_name);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$b.':D'.$d);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, $account_name);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->getAlignment()->setHorizontal($centerHz);
        $a++; $b++; $c++; $d++;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, $legal_charge);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$a)->getAlignment()->setHorizontal($centerHz);
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$b.':D'.$d);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$b, $account_charge);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->getAlignment()->setHorizontal($centerHz);
        $a += 5; $b += 5; $c += 5; $d += 5;
        $objPHPExcel->getActiveSheet()->getStyle("D1:D".$d)->applyFromArray($border_right);
        $objPHPExcel->getActiveSheet()->getStyle("A".$a.":D".$d)->applyFromArray($border_bottom);

        foreach(range('A','D') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Flujo_de_Efectivo');
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="flujo_de_efectivo_'.$hoy.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }

    //Fin de contabilidad

    function file_size($bytes)
    {
        $mb = 1048576; // 1024 * 1024
        $gb = 1073741824; // 1024 * 1024 * 1024

        if ($bytes < $mb) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes < $gb) {
            return number_format($bytes / $mb, 2) . ' MB';
        } else {
            return number_format($bytes / $gb, 2) . ' GB';
        }
    }

    function get_extension($extension)
    {
        if($extension == 'xlsx' || $extension == 'xlsm' || $extension == 'xltx' || $extension == 'xltm'){
            return 'fa fa-file-excel-o';
        }
        elseif($extension == 'docm' || $extension == 'docx' || $extension == 'dotx' || $extension == 'dotm'){
            return 'fa fa-file-word-o';
        }
        elseif($extension == 'txt'){
            return 'fa fa-file-image-o';
        }
        elseif($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPEG' || $extension == 'gif'){
            return 'fa fa-file-image-o';   
        }
        elseif($extension == 'pdf' ){
            return 'fa fa-file-pdf-o';
        }
        elseif($extension == 'pptx' || $extension == 'pptm' || $extension == 'potx' || $extension == 'potm' || $extension == 'ppam' || $extension == 'ppsx' || $extension == 'ppsm' || $extension == 'sldx' || $extension == 'sldm'){
            return 'fa-file-powerpoint-o';
        }else{
            return 'fa-file-code-o';
        }
    }


    function getPatientPoints($patient_id){
      
        $points = $this->db->query("SELECT SUM(points) as total FROM `patient_points` where patient_id = ".$patient_id." and type = 1")->row()->total;
        $npoints = $this->db->query("SELECT SUM(points) as total FROM `patient_points` where patient_id = ".$patient_id." and type = 0")->row()->total;
        return $points-$npoints;
        
    }

    //////////////////////////////////////////// FEL 
    function getInstitutionMode()
    {
        $fel = $this->getInfo("fel");
    
        if ($fel) 
        return $this->db->get_where('establecimiento', array( 'estado'=>'Activo','nit'=>'107921782'));
        else
        return $this->db->get_where('establecimiento', array( 'estado'=>'Activo','nit'=>'50206109'));
        
    }

    function getInstitution($id)
    {
        return $this->db->get_where('institution', array('institution_id'=>$id))->row_array();
    }

    function getDataInstitution()
    {
        $id = $this->input->post('id');
        $institution = $this->getInstitution($id);
        echo json_encode($institution);
    }

    function getClientsCF()
    {
        return $this->db->query("SELECT * FROM client WHERE nit LIKE 'CF' AND status = 1");
    }

    function setChecksBankBook() {
        $vals = $this->input->post('vals');
        $data['description'] = json_encode($vals);
        $this->db->where('type', 'checks_bank');
        $query = $this->db->update('settings', $data);
        $mensaje = "Ha cambiado el ocultamiento de las columnas del libro de bancos, con la información: ".json_encode($vals).".";
        $this->binnacle($mensaje, "settings", "checks_banks");
        echo json_encode(array("query"=>$query));
    }

    function setChecksPurchase() {
        $vals = $this->input->post('vals');
        $data['description'] = json_encode($vals);
        $this->db->where('type', 'checks_purchase');
        $query = $this->db->update('settings', $data);
        /* $mensaje = "Ha cambiado el ocultamiento de las columnas del libro de compras, con la información: ".json_encode($vals).".";
        $this->binnacle($mensaje, "settings", "checks_purchase"); */
        echo json_encode(array("query"=>$query));
    }

    function setChecksSales() {
        $vals = $this->input->post('vals');
        $data['description'] = json_encode($vals);
        $this->db->where('type', 'checks_sales');
        $query = $this->db->update('settings', $data);
        /* $mensaje = "Ha cambiado el ocultamiento de las columnas del libro de ventas, con la información: ".json_encode($vals).".";
        $this->binnacle($mensaje, "settings", "checks_sales"); */
        echo json_encode(array("query"=>$query));
    }

    function setChecksClients() {
        $vals = $this->input->post('vals');
        $data['description'] = json_encode($vals);
        $this->db->where('type', 'checks_clients');
        $query = $this->db->update('settings', $data);
        /* $mensaje = "Ha cambiado el ocultamiento de las columnas del libro de clientes, con la información: ".json_encode($vals).".";
        $this->binnacle($mensaje, "settings", "checks_clients"); */
        echo json_encode(array("query"=>$query));
    }

    function setChecksGeneral() {
        $vals = $this->input->post('vals');
        $data['description'] = json_encode($vals);
        $this->db->where('type', 'checks_general');
        $query = $this->db->update('settings', $data);
        /* $mensaje = "Ha cambiado el ocultamiento de las columnas del libro de ventas, con la información: ".json_encode($vals).".";
        $this->binnacle($mensaje, "settings", "checks_sales"); */
        echo json_encode(array("query"=>$query));
    }

    function setChecksStatement() {
        $vals = $this->input->post('vals');
        $data['description'] = json_encode($vals);
        $this->db->where('type', 'checks_statement');
        $query = $this->db->update('settings', $data);
        /* $mensaje = "Ha cambiado el ocultamiento de las columnas del libro de ventas, con la información: ".json_encode($vals).".";
        $this->binnacle($mensaje, "settings", "checks_sales"); */
        echo json_encode(array("query"=>$query));
    }


    
    function getClientJson() {
        $type = $this->input->post('type');
        if ($type == "NIT") return $this->getClientJsonByNIT();
        elseif ($type == "CUI") return $this->getClientJsonByCUI();
        else echo json_encode(array("results"=>0, "error"=>"No hay metodo de identifiación del cliente"));
    }

    function getClientJsonByNIT()
    {
        $nit = $this->input->post('nit');
        $client = array();
        $this->db->where('nit_1', $nit);
        $exist = $this->db->get("patient");

        $this->db->where('nit_2', $nit);
        $exist2 = $this->db->get("patient");

        $this->db->where('nit_3', $nit);
        $exist3 = $this->db->get("patient");

        if ($exist->num_rows() > 0) {
            $client = array_merge($exist->row_array(), array("results"=>1,"exist"=>$exist->num_rows(),'name_nit'=>$exist->row()->name_nit_1,'address_nit'=>$exist->row()->address_nit_1));

        }if ($exist2->num_rows() > 0) {
            $client = array_merge($exist->row_array(), array("results"=>1,"exist"=>$exist->num_rows(),'name_nit'=>$exist->row()->name_nit_2,'address_nit'=>$exist->row()->address_nit_2));

        } if ($exist3->num_rows() > 0) {
            $client = array_merge($exist->row_array(), array("results"=>1,"exist"=>$exist->num_rows(),'name_nit'=>$exist->row()->name_nit_3,'address_nit'=>$exist->row()->address_nit_3));
            
        }  else {
            $client = $this->nitSat($nit);
        }
        echo json_encode($client);
    }

    function getClientJsonByID()
    {
        $id = $this->input->post('id');
        $client = $this->getClient($id);
        echo json_encode($client);
    }

    function nitSat($nit)
    {
        $first_name = ''; $last_name = '';
        $results = array();
        $entity = $this->getInfo("entity");
        $requestor = $this->getInfo("requestor");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apis.mayansource.com/dte/consultarNIT',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'Nit='.$nit.'&NT='.$entity.'&req='.$requestor
        ));
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        log_message("error", "Respuesta buscar nit: $response");
        if ($err)
        {
            $results = array("results"=>0, "exist"=>0);
            log_message("error", "Busqueda de Nit: ".json_encode($err));
        } 
        else 
        {
            if($response == 'NIT no encontrado'){
                $results = array("results"=>0, "exist"=>0, "response"=>$response);
            }else{
                $str = explode(',,',$response);
                $cn = count($str);
                if($cn == 2){
                    $str = explode(',,',$response);
                    $first_name = str_replace(',', ' ', $str[1]);
                    $last_name = str_replace(',', ' ', $str[0]);
                } elseif ($cn <= 1){
                    $str = explode(',',$response);
                    $cn = count($str);
                    if ($cn == 2) {
                        $first_name = $str[0];
                        $last_name = $str[1];
                    } else {
                        $first_name = $str;
                        $last_name = '';
                    }
                }
                $results = array("first_name"=>$first_name, "last_name"=>$last_name, "results"=>1, "exist"=>0) ;            
            }
        }
        return $results;
    }

    function getClientJsonByCUI()
    {
        $cui = $this->input->post('cui');
        $client = array();
        $exist = $this->db->get_where("patient", array("dpi"=>$cui));
        if ($exist->num_rows() > 0) {
            $client = array_merge($exist->row_array(), array("results"=>1,"exist"=>$exist->num_rows()));
        } else {
            $client = $this->cuiSat($cui);
        }
        echo json_encode($client);
    }

 
    function pluralizar($cantidad, $singular, $plural = null) {
        if($cantidad != '')
        {
            if ($cantidad == 1) {
            return $singular;
            }
            $ultima_letra = strtolower(substr($singular, -1));
            if ($ultima_letra === 'n') {
            return $singular. 'es';
            }else{
                return $singular . 's';
            }
        }
        
      }

    function cuiSat($cui)
    {
        $first_name = ''; $last_name = '';
        $results = array();
        $entity = $this->getInfo("entity");
        $requestor = $this->getInfo("requestor");
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://app.corposistemasgt.com/webservicefrontTEST/factwsfront.asmx?WSDL',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://www.fact.com.mx/schema/ws">
    <SOAP-ENV:Header />
    <SOAP-ENV:Body>
        <ws:RequestTransaction>
            <ws:Requestor>'.$requestor.'</ws:Requestor>
            <ws:Transaction>SYSTEM_REQUEST</ws:Transaction>
            <ws:Country>GT</ws:Country>
            <ws:Entity>'.$entity.'</ws:Entity>
            <ws:User>'.$requestor.'</ws:User>
            <ws:UserName>ADMINISTRADOR</ws:UserName>
            <ws:Data1>CONSULTA_CUI</ws:Data1>
            <ws:Data2>'.$cui.'</ws:Data2>
            <ws:Data3></ws:Data3>
        </ws:RequestTransaction>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>',
CURLOPT_HTTPHEADER => array(
'Content-Type: text/xml'
),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
log_message("error", "Respuesta buscar cui: $response");
if ($err) {
$results = array("results"=>0, "exist"=>0);
log_message("error", "Busqueda de CUI: ".json_encode($err));
} else {
$data = $response;
$xml = simplexml_load_string($data);
$info = $xml->xpath("//soap:Body/*")[0];
$details = $info->children("http://www.fact.com.mx/schema/ws");
$getResult = $details->RequestTransactionResult->Response->Result;
log_message("error", "Result: $getResult");
if ($getResult == false){
$results = array("results"=>0, "exist"=>0, "response"=>$details);
} else {
$item = $details->RequestTransactionResult->ResponseData->ResponseData1;
log_message("error", "Info: $item");
$person = json_decode($item);
$name = $person->nombre;
$str = explode(',,',$name);
log_message("error", "Nombre sin comas: ".str_replace(',', ' ', $name));
$cn = count($str);
if($cn == 2) {
$str = explode(',,', $name);
$first_name = trim(str_replace(',', ' ', $str[1]));
$last_name = trim(str_replace(',', ' ', $str[0]));
} elseif($cn <= 1) { $str=explode(',', $name); $count=count($str); if ($count==2) { $first_name=trim($str[0]); $last_name=trim($str[1]); } else if ($count < 2) { $first_name=$str[0]; $last_name='' ; } else { $first_name=trim(str_replace(',', ' ' , $name)); $last_name='' ; } } $results=array("first_name"=>$first_name, "last_name"=>$last_name, "results"=>1, "exist"=>0, "dead"=>$person->fallecido) ;
    }
    }
    return $results;
    }


    function create_membership()
    {

        	$data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'), 
            );

            $this->db->insert('membership',$data);


    }
    
    
      function update_membership($id)
    {

        	$data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'), 
            );
            
            $this->db->where('membership_id',$id);
            $this->db->update('membership',$data);


    }
    
    
       function delete_membership($id)
    {

        	$data = array(
                'status' => 0,
            );
            $this->db->where('membership_id',$id);
            $this->db->update('membership',$data);
    }

    function create_membership_benefit()
    {

        	$data = array(
                'membership_id' => $this->input->post('membership_id'),
                'category_id' => $this->input->post('cat_id'), 
                'product_id' => $this->input->post('product_id'),
                 'porcent' => $this->input->post('porcent'),
                'amount' => $this->input->post('amount'),
                'unity' => $this->input->post('unity'), 
                'benefit_type' => $this->input->post('benefit_type'),
                'type_amount' => $this->input->post('type_amount'), 
                'status' => 1
            );

            $this->db->insert('membership_benefit',$data);


    }
    
    
     function edit_membership_benefit($id)
    {

        	$data = array(
                'category_id' => $this->input->post('cat_id'), 
                'product_id' => $this->input->post('product_id'),
                 'porcent' => $this->input->post('porcent'),
                'amount' => $this->input->post('amount'),
                'unity' => $this->input->post('unity'), 
                'benefit_type' => $this->input->post('benefit_type'),
                'type_amount' => $this->input->post('type_amount'), 
            );

            $this->db->where('membership_benefit_id',$id);
            $this->db->update('membership_benefit',$data);

    }
    
     function delete_membership_benefit($id)
    {

        	$data = array(
                'status' => 0, 
               
            );

            $this->db->where('membership_benefit_id',$id);
            $this->db->update('membership_benefit',$data);

    }

    function count_patient_membership($membership_id)
    {

        $patients = $this->db->get_where('patient',array('membership_id'=>$membership_id))->num_rows();
        return $patients;

    }
    
    
    function compressImage($source, $destination, $quality) {
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];

    switch($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromjpeg($source);
    }

    if (!$image) {
        return false; // Error al cargar la imagen
    }

    if (!imagejpeg($image, $destination, $quality)) {
        return false; // Error al guardar la imagen comprimida
    }

    imagedestroy($image);
    return $destination; // Éxito
}


    }