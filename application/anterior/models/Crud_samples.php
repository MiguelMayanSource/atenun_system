<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud_samples extends CI_Model 
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

    function codeGroup()
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = 'GROUP-'.substr(str_shuffle($chars),0,8);
        return $code;
    }

    function sampleCode($id){
        $result ='';
        
        if($id != 8 )
        {
            $name = 'ORD';
           
            
            $cont = $this->db->get_where('sample', array('year'=>date('Y'), 'category_id'=>$id, 'branch_id'=>$this->session->userdata('current_clinic') ))->num_rows()+1;

            if(strlen((string) $cont) == 4)
            {
                $result = $name.date('y').'-'.$cont;
            }elseif(strlen((string) $cont) == 3) {
                $result = $name.date('y').'-'.'0'.$cont;
            }else {
                $result = $name.date('y').'-'.'00'.$cont;
            }
        }else{
            $name = 'ORD';
           
            
            $cont = $this->db->get_where('sample', array('year'=>date('Y'), 'category_id'=>$id, 'branch_id'=>$this->session->userdata('current_clinic') ))->num_rows()+1;

            if(strlen((string) $cont) == 4)
            {
                $result = $name.'-'.date('y').'-'.$cont;
            }elseif(strlen((string) $cont) == 3) {
                $result =  $name.'-'.date('y').'-'.'0'.$cont;
            }else {
                $result =  $name.'-'.date('y').'-'.'00'.$cont;
            }
        }
        return $result;
        
    }

    function sampleCodeRayx($id){
        $result ='';
        
        if($id != 8 )
        {
            $name = 'ray';
           
            
            $cont = $this->db->get_where('rayx')->num_rows()+1;

            if(strlen((string) $cont) == 4)
            {
                $result = $name.date('y').'-'.$cont;
            }elseif(strlen((string) $cont) == 3) {
                $result = $name.date('y').'-'.'0'.$cont;
            }else {
                $result = $name.date('y').'-'.'00'.$cont;
            }
        }else{
            $name = 'ORD';
           
            
            $cont = $this->db->get_where('rayx')->num_rows()+1;

            if(strlen((string) $cont) == 4)
            {
                $result = $name.'-'.date('y').'-'.$cont;
            }elseif(strlen((string) $cont) == 3) {
                $result =  $name.'-'.date('y').'-'.'0'.$cont;
            }else {
                $result =  $name.'-'.date('y').'-'.'00'.$cont;
            }
        }
        return $result;
        
    }


function sampleCodeUpdate($id,$n){
        $result ='';
        
        $name = 'ORD';
        
        if(strlen((string) $n) == 4)
        {
            $result = $name.date('y').'-'.$n;
        }elseif(strlen((string) $cont) == 3) {
            $result = $name.date('y').'-'.'0'.$n;
        }else {
            $result = $name.date('y').'-'.'00'.$n;
        }
        
        return $result;
    }

    function workOrder(){
        $result ='';

        $user = $this->session->userdata('login_user_id');
        
        $samples = $this->db->get_where('sample', array('user_id'=>$user))->num_rows();
        $result = $user.date('y').$samples;

        return $result ;
    }
    
    
       //Funciones de muestras
    function create_rayx()
    {
        $sampleCode = $this->samplecoderayx(0);
        $md5 = md5(date('d-m-y H:i:s'));
        
     
        $patient_id = $this->input->post('patient_id'); 
        $dataS['patient_name']  = $this->accounts_model->get_full_name('patient',$patient_id);


        if($this->input->post('doctors_id') != 0)
        {
            $dataS['doctors_id']    = $this->input->post('doctors_id');
            $dataS['doctor_name']   = $this->accounts_model->get_full_name('admin',$this->input->post('doctor_name'));
        }else
        {
            $dataS['doctors_id']    = $this->input->post('doctors_id');
            $dataS['doctor_name']   = $this->input->post('doctor_name');
        }


        $dataS['code']          = $sampleCode;
        $dataS['date'] =         $this->input->post('fecha_recibido');
        $dataS['category_id']   = 0;
        $dataS['patient_id']    = $patient_id;
        $dataS['financial_id'] = 0;
        $dataS['doctor_name'] = trim($this->input->post('doctor_name'));
        $dataS['process_date']  = $this->input->post('fecha_procedimiento');
        $dataS['received_date'] = $this->input->post('fecha_recibido');
        $dataS['manarquia_date']   = $this->input->post('fecha_manarquia');
        $dataS['menopause_date']   = $this->input->post('fecha_menopausia');
        $dataS['menstrual_cycle']  = $this->input->post('ciclos_menstruales');
        $dataS['FUR']      = $this->input->post('FUR');
        $dataS['deeds']    = $this->input->post('gestas');
        $dataS['birth']    = $this->input->post('partos');
        $dataS['abortion'] = $this->input->post('abortos');
        $dataS['birth_date'] = $this->input->post('fecha_ultimo_parto');
        $dataS['DIU'] = $this->input->post('DIU');
        $dataS['tx_hormonal'] = $this->input->post('tx_hormonal');
        $dataS['positive_data'] = $this->input->post('datos_positivos');
        $dataS['payment_type'] = $this->input->post('payment_type');
        $dataS['previous'] = $this->input->post('previa');
        $dataS['diagnosis'] = $this->input->post('diagnostico');
        $dataS['delivered_by'] = $this->input->post('delivered_by');
        $dataS['address'] = $this->input->post('address') != ''?$this->input->post('address'):'Desce consulta';
        $dataS['address_r'] = $this->input->post('address_r');
        $dataS['credit'] = 0;
        $dataS['total'] = $this->input->post('total');
        $dataS['day']   = date('d');
        $dataS['month'] = date('m');
        $dataS['year']  = date('Y');
        $dataS['branch_id']  = $this->session->userdata('current_clinic');
        $dataS['user_id'] = $this->session->userdata('login_user_id');
        $dataS['user_type'] = $this->session->userdata('login_type');
        $dataS['clinic_id']     = $this->input->post('clinic_id');
        $dataS['work_order'] = $this->workOrder();
        $dataS['invoiced']    = $this->input->post('facturado');
        $dataS['status_priority']    = $this->input->post('status_priority')!=''?$this->input->post('status_priority'):1;
        $dataS['status']  = 0;
        $dataS['origin_id'] =         $this->input->post('origin_id');
        $dataS['origin_type'] =         $this->input->post('origin_type');

        if($_FILES['leaf']['size'] > 0){
            $dataS['leaf'] = $md5.str_replace(' ', '', $_FILES['leaf']['name']);
            move_uploaded_file($_FILES['leaf']['tmp_name'], 'uploads/files/' . $md5.str_replace(' ', '', $_FILES['leaf']['name']));
        }
        
        if($this->input->post('bill') !='')
        $dataS['bill_id'] = $this->input->post('bill');

        //guardamos la muestra
        $response = $this->db->insert('sample', $dataS);

        $sample_id = $this->db->insert_id();

        $pieces     = $this->input->post('laboratories');
        $exams      = $this->input->post('exmans');
        $estudios   = $this->input->post('estudio');
        $precios    = $this->input->post('price');
        $laminillas    = $this->input->post('laminillas');
        $details_price    = $this->input->post('details_price');
        $priority    = $this->input->post('priority');
        $cats    = $this->input->post('cat');
        $cont = 0;
        $priority_status = 1;
        $x = 'A';
        $num_of_pices =sizeof($pieces);
        foreach($pieces as $piece) {
            
            log_message('error','examen '.$exams[$cont]);
            log_message('error','piece '.json_encode($piece));
            $study .=  ' '.$this->db->get_where('product',array('product_id'=>$piece))->row()->name;

            $dataPiece['code']   = $sampleCode;

            $dataPiece['sample_id']   = $sample_id;
            $dataPiece['laboratory_id']   = $piece;
            $dataPiece['exams']       = $exams[$cont];
            $dataPiece['study']       = $estudios[$cont];
            $dataPiece['details']     = $details_price[$cont];
            $dataPiece['date']        = $this->input->post('fecha_recibido');
            $dataPiece['price'] =$precios[$cont] ;

            $this->db->insert('sample_piece',$dataPiece);

            $x++;
            $cont++;
        }
        
        $dataStudy['priority'] = $priority_status;
        $dataStudy['study'] = $study;
        $this->db->where('sample_id', $sample_id);
        $this->db->update('sample', $dataStudy);
        $type = $this->session->userdata('login_type');

        $mensaje = "Ha creado una nueva muestra con código : ".$sampleCode." paciente: ".$this->input->post('name');
        //$this->crud_model->insertar_bitacora($mensaje);
        //$this->crud_model->new_notificacion($mensaje, base64_encode($type.'/samples/'.base64_encode($this->input->post('category_id')).'/'), 'Muestras');
        return $sampleCode;
    }


    //Funciones de muestras
    function create_samples()
    {
        $sampleCode = $this->samplecode(0);
        $md5 = md5(date('d-m-y H:i:s'));
        
     
        $patient_id = $this->input->post('patient_id'); 
        $dataS['patient_name']  = $this->accounts_model->get_full_name('patient',$patient_id);


        if($this->input->post('doctors_id') != 0)
        {
            $dataS['doctors_id']    = $this->input->post('doctors_id');
            $dataS['doctor_name']   = $this->accounts_model->get_full_name('admin',$this->input->post('doctor_name'));
        }else
        {
            $dataS['doctors_id']    = $this->input->post('doctors_id');
            $dataS['doctor_name']   = $this->input->post('doctor_name');
        }


        $dataS['code']          = $sampleCode;
        $dataS['date'] =         $this->input->post('fecha_recibido');
        $dataS['category_id']   = 0;
        $dataS['patient_id']    = $patient_id;
        $dataS['financial_id'] = 0;
        $dataS['doctor_name'] = trim($this->input->post('doctor_name'));
        $dataS['process_date']  = $this->input->post('fecha_procedimiento');
        $dataS['received_date'] = $this->input->post('fecha_recibido');
        $dataS['manarquia_date']   = $this->input->post('fecha_manarquia');
        $dataS['menopause_date']   = $this->input->post('fecha_menopausia');
        $dataS['menstrual_cycle']  = $this->input->post('ciclos_menstruales');
        $dataS['FUR']      = $this->input->post('FUR');
        $dataS['deeds']    = $this->input->post('gestas');
        $dataS['birth']    = $this->input->post('partos');
        $dataS['abortion'] = $this->input->post('abortos');
        $dataS['birth_date'] = $this->input->post('fecha_ultimo_parto');
        $dataS['DIU'] = $this->input->post('DIU');
        $dataS['tx_hormonal'] = $this->input->post('tx_hormonal');
        $dataS['positive_data'] = $this->input->post('datos_positivos');
        $dataS['payment_type'] = $this->input->post('payment_type');
        $dataS['previous'] = $this->input->post('previa');
        $dataS['diagnosis'] = $this->input->post('diagnostico');
        $dataS['delivered_by'] = $this->input->post('delivered_by');
        $dataS['address'] = $this->input->post('address') != ''?$this->input->post('address'):'Desce consulta';
        $dataS['address_r'] = $this->input->post('address_r');
        $dataS['credit'] = 0;
        $dataS['total'] = $this->input->post('total');
        $dataS['day']   = date('d');
        $dataS['month'] = date('m');
        $dataS['year']  = date('Y');
        $dataS['branch_id']  = $this->session->userdata('current_clinic');
        $dataS['user_id'] = $this->session->userdata('login_user_id');
        $dataS['user_type'] = $this->session->userdata('login_type');
        $dataS['clinic_id']     = $this->input->post('clinic_id');
        $dataS['work_order'] = $this->workOrder();
        $dataS['invoiced']    = $this->input->post('facturado');
        $dataS['status_priority']    = $this->input->post('status_priority')!=''?$this->input->post('status_priority'):1;
        $dataS['status']  = 0;
        $dataS['origin_id'] =         $this->input->post('origin_id');
        $dataS['origin_type'] =         $this->input->post('origin_type');

        if($_FILES['leaf']['size'] > 0){
            $dataS['leaf'] = $md5.str_replace(' ', '', $_FILES['leaf']['name']);
            move_uploaded_file($_FILES['leaf']['tmp_name'], 'uploads/files/' . $md5.str_replace(' ', '', $_FILES['leaf']['name']));
        }
        
        if($this->input->post('bill') !='')
        $dataS['bill_id'] = $this->input->post('bill');

        //guardamos la muestra
        $response = $this->db->insert('sample', $dataS);

        $sample_id = $this->db->insert_id();

        $pieces     = $this->input->post('laboratories');
        $exams      = $this->input->post('exmans');
        $estudios   = $this->input->post('estudio');
        $precios    = $this->input->post('price');
        $laminillas    = $this->input->post('laminillas');
        $details_price    = $this->input->post('details_price');
        $priority    = $this->input->post('priority');
        $cats    = $this->input->post('cat');
        $cont = 0;
        $priority_status = 1;
        $x = 'A';
        $num_of_pices =sizeof($pieces);
        foreach($pieces as $piece) {
            
            log_message('error','examen '.$exams[$cont]);
            log_message('error','piece '.json_encode($piece));
            $study .=  ' '.$this->db->get_where('product',array('product_id'=>$piece))->row()->name;

            $dataPiece['code']   = $sampleCode;

            $dataPiece['sample_id']   = $sample_id;
            $dataPiece['laboratory_id']   = $piece;
            $dataPiece['exams']       = $exams[$cont];
            $dataPiece['study']       = $estudios[$cont];
            $dataPiece['details']     = $details_price[$cont];
            $dataPiece['date']        = $this->input->post('fecha_recibido');
            $dataPiece['price'] =$precios[$cont] ;

            $this->db->insert('sample_piece',$dataPiece);

            $x++;
            $cont++;
        }
        
        $dataStudy['priority'] = $priority_status;
        $dataStudy['study'] = $study;
        $this->db->where('sample_id', $sample_id);
        $this->db->update('sample', $dataStudy);
        $type = $this->session->userdata('login_type');

        $mensaje = "Ha creado una nueva muestra con código : ".$sampleCode." paciente: ".$this->input->post('name');
        //$this->crud_model->insertar_bitacora($mensaje);
        //$this->crud_model->new_notificacion($mensaje, base64_encode($type.'/samples/'.base64_encode($this->input->post('category_id')).'/'), 'Muestras');
        return $sampleCode;
    }

     //Funciones de muestras
    function update_samples($ID)
    {
        $sampleCode = $this->input->post('code');
        $sample_id = base64_decode($ID);
        $md5 = md5(date('d-m-y H:i:s'));

        $patient_id = $this->input->post('patient_id'); 
        $dataS['patient_id']  = $patient_id ;
        $dataS['patient_name']  = $this->accounts_model->get_full_name('patient',$patient_id);


        if($this->input->post('doctors_id') != 0)
        {
            $dataS['doctors_id']    = $this->input->post('doctors_id');
            $dataS['doctor_name']   = $this->accounts_model->get_full_name('admin',$this->input->post('doctor_name'));
        }else
        {
            $dataS['doctors_id']    = $this->input->post('doctors_id');
            $dataS['doctor_name']   = $this->input->post('doctor_name');
        }


        $dataS['code'] = $sampleCode;
        $dataS['date'] = $this->input->post('fecha_recibido');
        $dataS['category_id']   = $this->input->post('category_id');
        $dataS['process_date']  = $this->input->post('fecha_procedimiento');
        $dataS['received_date'] = $this->input->post('fecha_recibido');
        $dataS['manarquia_date']   = $this->input->post('fecha_manarquia');
        $dataS['menopause_date']   = $this->input->post('fecha_menopausia');
        $dataS['menstrual_cycle']  = $this->input->post('ciclos_menstruales');
        $dataS['FUR']      = $this->input->post('FUR');
        $dataS['deeds']    = $this->input->post('gestas');
        $dataS['birth']    = $this->input->post('partos');
        $dataS['abortion'] = $this->input->post('abortos');
        $dataS['birth_date'] = $this->input->post('fecha_ultimo_parto');
        $dataS['DIU'] = $this->input->post('DIU');
        $dataS['tx_hormonal'] = $this->input->post('tx_hormonal');
        $dataS['positive_data'] = $this->input->post('datos_positivos');
        $dataS['priority'] = $this->input->post('prioridad');
        $dataS['previous'] = $this->input->post('previa');
        $dataS['diagnosis'] = $this->input->post('diagnostico');
        $dataS['delivered_by'] = $this->input->post('delivered_by');
        $dataS['address'] = $this->input->post('address');
        $dataS['address_r'] = $this->input->post('address_r');
        $dataS['credit'] = $this->input->post('credito');
        $dataS['total'] = $this->input->post('total');
        $dataS['bill_id'] = $this->input->post('bill');
        $dataS['status_payment'] = $this->input->post('status_payment');
        $dataS['status_delivery'] = $this->input->post('status_delivery');
        $dataS['status_priority']    = $this->input->post('status_priority');
        $dataS['invoiced']    = $this->input->post('facturado');
        $dataS['clinic_id']     = $this->input->post('clinic_id');
        $dataS['payment_type'] = $this->input->post('payment_type');

        if($_FILES['leaf']['name'] != ''){
            $dataS['leaf'] = $md5.str_replace(' ', '', $_FILES['leaf']['name']);
            move_uploaded_file($_FILES['leaf']['tmp_name'], 'uploads/files/' . $md5.str_replace(' ', '', $_FILES['leaf']['name']));
        }

        $response = $this->db->where('sample_id', $sample_id)->update('sample', $dataS);

    

        $pieces     = $this->input->post('laboratories');
        $estudios   = $this->input->post('estudio');
        $precios    = $this->input->post('price');
        $laminillas    = $this->input->post('laminillas');
        $details_price    = $this->input->post('details_price');
        $priority    = $this->input->post('priority');
        $cats        = $this->input->post('cat');
        $sample_piece  = $this->input->post('piece');
        $total_price   = 0;
        $cont = 0;
        $x = 'A';
        $num_of_pices =sizeof($pieces);
        
       
   
        $this->db->where('sample_id', $sample_id);
        $this->db->delete('sample_piece');
        
            
        foreach($pieces as $pieces) {
        
            $study .=  ' '.$this->db->get_where('laboratory',array('laboratory_id'=>$pieces))->row()->name;

            $dataPiece['code']   = $sampleCode;

            $dataPiece['sample_id']   = $sample_id;
            $dataPiece['laboratory_id']   = $pieces;
            $dataPiece['exams'] = json_encode($this->input->post($cats[$cont].'_fields'));
            $dataPiece['study']       = $estudios[$cont];
            $dataPiece['details']     = $details_price[$cont];
            $dataPiece['date']        = $this->input->post('fecha_recibido');
            $dataPiece['price'] =$precios[$cont] ;

            $this->db->insert('sample_piece',$dataPiece);

            $total_price  += $precios[$cont];
            
            $x++;
            $cont++;
        }

        $dataStudy['priority'] = $priority_status;
        $dataStudy['study'] = $study;
         $dataStudy['total'] = $total_price;
        $this->db->where('sample_id', $sample_id);
        $this->db->update('sample', $dataStudy);
/*
        $dataF['amount'] = $this->input->post('total');
        $this->db->where('sample_code', $sampleCode);
        $this->db->update('financial', $dataF);
        
*/
        $type = $this->session->userdata('login_type');

        $mensaje = "Ha actualizado un muestra con código : ".$sampleCode." paciente: ".$this->input->post('name');
        //$this->crud_model->insertar_bitacora($mensaje);
       // $this->crud_model->new_notificacion($mensaje, base64_encode($type.'/samples/'.base64_encode($this->input->post('category_id')).'/'), 'Muestras');
        return $response;
    }


    function findObject($id,$array){
        
        foreach ( $array as $key ) {
            if ( $key->$id != "") {
                return  $key->$id;
            }
        }
    
        return '';
    }


    //Funciones de muestras
    function update_samples_staff($ID)
    {
        
        $sample_id = base64_decode($ID);
        $md5 = md5(date('d-m-y H:i:s'));
        
        $dataP['name']       = $this->input->post('name');
        $dataP['birthday']   = $this->input->post('birthday');
        $dataP['age']        = $this->input->post('age');
        $dataP['gender']     = $this->input->post('gender');
        $dataP['activities'] = $this->input->post('activities');
        $dataP['branch_id']  = $this->session->userdata('current_clinic');
        $dataP['doctor_id']  = $this->input->post('doctors_id');
        $dataP['phone']  = $this->input->post('phone');
    
        if($this->input->post('patient_id') != 0){

            $this->db->where('patient_id', $this->input->post('patient_id'));
            $this->db->update('patient', $dataP);
            $patient_id = $this->input->post('patient_id'); 
            
        }else{

            $this->db->insert('patient', $dataP);
            $patient_id = $this->db->insert_id();    

        }
        
        $dataS['date'] = $this->input->post('fecha_recibido');
        $dataS['category_id']   = $this->input->post('category_id');
        $dataS['patient_id']    = $patient_id;
        $dataS['patient_name']  = $this->input->post('name');
        $dataS['doctors_id']    = $this->input->post('doctors_id');
        $dataS['doctor_name'] = trim($this->input->post('doctor_name'));
        $dataS['process_date']  = $this->input->post('fecha_procedimiento');
        $dataS['received_date'] = $this->input->post('fecha_recibido');
        $dataS['manarquia_date']   = $this->input->post('fecha_manarquia');
        $dataS['menopause_date']   = $this->input->post('fecha_menopausia');
        $dataS['menstrual_cycle']  = $this->input->post('ciclos_menstruales');
        $dataS['FUR']      = $this->input->post('FUR');
        $dataS['deeds']    = $this->input->post('gestas');
        $dataS['birth']    = $this->input->post('partos');
        $dataS['abortion'] = $this->input->post('abortos');
        $dataS['birth_date'] = $this->input->post('fecha_ultimo_parto');
        $dataS['DIU'] = $this->input->post('DIU');
        $dataS['tx_hormonal'] = $this->input->post('tx_hormonal');
        $dataS['positive_data'] = $this->input->post('datos_positivos');
        $dataS['priority'] = $this->input->post('prioridad');
        $dataS['previous'] = $this->input->post('previa');
        $dataS['diagnosis'] = $this->input->post('diagnostico');
        $dataS['address'] = $this->input->post('address');
        $dataS['clinic_id']     = $this->input->post('clinic_id');
        $dataS['invoiced']    = $this->input->post('facturado');
        $dataS['payment_type'] = $this->input->post('payment_type');

        if($_FILES['leaf']['size'] > 0){
            $dataS['leaf'] = $md5.str_replace(' ', '', $_FILES['leaf']['name']);
            move_uploaded_file($_FILES['leaf']['tmp_name'], 'uploads/files/' . $md5.str_replace(' ', '', $_FILES['leaf']['name']));
        }

        $response = $this->db->where('sample_id', $sample_id)->update('sample', $dataS);


       $pieces     = $this->input->post('laboratories');
        $estudios   = $this->input->post('estudio');
        $precios    = $this->input->post('price');
        $laminillas    = $this->input->post('laminillas');
        $details_price    = $this->input->post('details_price');
        $priority    = $this->input->post('priority');
        $cats    = $this->input->post('cat');
        $sample_piece  = $this->input->post('piece');
        $total_price   = 0;
        $cont = 0;
        $x = 'A';
        $num_of_pices =sizeof($pieces);
        
        
        log_message('error','Result '.json_encode($pieces));
        $this->db->where_not_in('laboratory_id', $pieces);
        $this->db->where('sample_id', $sample_id);
        $this->db->delete('sample_piece');
            
            
        foreach($pieces as $piece) {
             
               $results = $this->db->get_where('sample_piece',array('sample_piece_id'=>$sample_piece[$cont]));
              
              if($results->num_rows() > 0)
              {
                    $results = $results->row()->results;
                
                
                    if($results != ""){
                        $results2 = array();
                         $results = json_decode($results);
                         foreach($this->input->post($cats[$cont].'_fields') as $field)
                         {
                           array_push($results2,array($field=>$this->findObject($field,$results)));                 
                         }
                         
                         $results2 = json_encode($results2);
                    }else
                    {
                        $results2= '';
                    }
                
              
                
                    $study .=  ' '.$this->db->get_where('laboratory',array('laboratory_id'=>$piece))->row()->name;
        
                    $dataPiece['exams']       = json_encode($this->input->post($cats[$cont].'_fields'));
                    $dataPiece['study']       = $estudios[$cont];
                    $dataPiece['details']     = $details_price[$cont];
                    $dataPiece['date']        = $this->input->post('fecha_recibido');
                    $dataPiece['price']       = $precios[$cont] ;
                    $dataPiece['results']     = $results2;
                    
                    $total_price   += $precios[$cont];
                    
                    $this->db->where('sample_piece_id', $sample_piece[$cont]);
                    $this->db->update('sample_piece',$dataPiece);
                    
              }else
              {
                    $sampleCode = $this->db->get_where('sample',array('sample_id'=>$sample_id))->row()->code;
                    $results2 = array();
                    
                    foreach($this->input->post($cats[$cont].'_fields') as $field)
                    {
                         array_push($results2,array($field=>''));    
                    }
                    $results2 = json_encode($results2);
                    
                    $study .=  ' '.$this->db->get_where('laboratory',array('laboratory_id'=>$piece))->row()->name;
        
                    $dataPiece['code']   = $sampleCode;
                    $dataPiece['sample_id']   = $sample_id;
                    $dataPiece['laboratory_id']   = $piece;
                    $dataPiece['exams'] = json_encode($this->input->post($cats[$cont].'_fields'));
                    $dataPiece['study']       = $estudios[$cont];
                    $dataPiece['details']     = $details_price[$cont];
                    $dataPiece['date']        = $this->input->post('fecha_recibido');
                    $dataPiece['price'] =$precios[$cont] ;
                    $dataPiece['results']     = $results2;
                    
                    $total_price   += $precios[$cont];
                    
                    $this->db->insert('sample_piece',$dataPiece); 
                  
              }
                $x++;
                $cont++;
            
        }

        $dataStudy['priority'] = $priority_status;
        $dataStudy['study'] = $study;
        $dataStudy['total'] = $total_price;
        $this->db->where('sample_id', $sample_id);
        $this->db->update('sample', $dataStudy);
        
        
        $type = $this->session->userdata('login_type');

        $mensaje = "Ha actualizado un muestra con código : ".$sampleCode;
       // $this->crud_model->insertar_bitacora($mensaje);
       // $this->crud_model->new_notificacion($mensaje, base64_encode($type.'/samples/'.base64_encode($this->input->post('category_id')).'/'), 'Muestras');
        return $response;
    }
    
    
    function delete_samples($ID)
    {
        $sample = $this->db->get_where('sample',array('sample_id' => $ID))->row();

        $this->db->where('sample_id >',$ID);
        $this->db->where('category_id',$sample->category_id);
        $this->db->where('branch_id',$sample->branch_id);
        $samples = $this->db->get('sample')->result_array();

        $this->db->where('sample_id <',$ID);
        $this->db->where('category_id',$sample->category_id);
        $this->db->where('branch_id',$sample->branch_id);
        $samples2 = $this->db->get('sample')->result_array();

        //$response = $this->db->where('sample_code', $sample->code)->delete('financial');

        $cont = count($samples2)+1;
        $categoria = $this->db->get_where('sample', array("sample_id"=>$ID))->row()->category_id;
        foreach ($samples as $sm)
        {

            $sampleCode = $this->sampleCodeUpdate($categoria, $cont++);
            
            $data['code'] =$sampleCode;
            $response = $this->db->where('sample_id', $sm['sample_id'])->update('sample', $data);
           
            $response = $this->db->where('sample_id', $sm['sample_id'])->update('sample_piece', $data);
            
            $dataf['sample_code'] =$sampleCode;
            $dataf['description'] = 'Pago de muestra con código '.$sampleCode;
            //$response = $this->db->where('sample_code', $sm['code'])->update('financial', $dataf);
        }
        
     
        $type = $this->session->userdata('login_type');

        $mensaje = "Ha eliminado la muestra una muestra: ".$this->db->get_where('sample', array('sample_id'=>$ID))->row()->code;
      //  $this->crud_model->insertar_bitacora($mensaje);
       // $this->crud_model->new_notificacion($mensaje, base64_encode($type.'/muestras/'.base64_encode($categoria)), 'Muestras');

        $response = $this->db->where('sample_id', $ID)->delete('sample');
        return $response;
    }
    
    function getSample($ID){
        $query = $this->db->get_where('sample', array('code'=>$ID));
        return $query;
    }

    function getSampleByID($ID){
        $query = $this->db->get_where('sample', array('sample_id'=>$ID))->row();
        return $query;
    }

    function getTracing($ID){
        
        $query = $this->db->get_where('tracing', array('sample_id'=>base64_decode($ID)));
        return $query;
    }

    function getSampleTracing($ID){
        $query = $this->db->get_where('sample', array('sample_id'=>base64_decode($ID)));
        return $query;
    }

    function update_sample_details($code)
    {
        
        $id = $this->input->post('sample_piece_id');
        $dacal_status = 0;
        for ($i=0; $i <sizeof($id) ; $i++) 
        { 
            $data['description'] = $this->input->post('description_'.$id[$i]);
            $data['description_micro'] = $this->input->post('description_micro_'.$id[$i]);
            $data['diagnostic'] = $this->input->post('diagnostic_'.$id[$i]);
            $basquet             = $this->input->post('basquet_'.$id[$i]);
            $basquet_description = $this->input->post('basquet_description_'.$id[$i]);
            $basquet_cut         = $this->input->post('basquet_cut_'.$id[$i]);

            $basquets = array();
            $details = array();
            if($basquet)
            {
            if(count($basquet) > 0)
            {
                for ($j=0; $j < sizeof($basquet); $j++) { 

                    $details = array('basquet'=>$basquet[$j],'basquet_description'=>$basquet_description[$j],'basquet_cut'=>$basquet_cut[$j]);
                    array_push($basquets,$details);
                }       
            }
        }

            $nbasquet             = $this->input->post('nbasquet_'.$id[$i]);
            $nbasquet_description = $this->input->post('nbasquet_description_'.$id[$i]);
            $nbasquet_cut         = $this->input->post('nbasquet_cut_'.$id[$i]);

            $nbasquets = array();
            $ndetails = array();
            if($nbasquet)
            {
                if(count($nbasquet) > 0)
                {
                    for ($j=0; $j < sizeof($nbasquet); $j++) { 

                        $ndetails = array('basquet'=>$nbasquet[$j],'basquet_description'=>$nbasquet_description[$j],'basquet_cut'=>$nbasquet_cut[$j]);
                        array_push($nbasquets,$ndetails);
                    }       
                }
            }

            $data['basquets'] = serialize($basquets);
            $data['new_basquets'] = serialize($nbasquets);
            //$data['date'] = $this->input->post('date');
            $data['process'] = $this->input->post('process');
            $data['inclusion'] = $this->input->post('inclusion');
            $data['microtomia'] = $this->input->post('microtomia');
            $data['desparafinacion'] = $this->input->post('desparafinacion');
            $data['tincion_montaje'] = $this->input->post('tincion_montaje');
           
            $data['doctor_id']   = $this->input->post('doctor_id');
            $data['total_cut']   = $this->input->post('total_cut');
            $data['cut_maden']   = $this->input->post('cut_maden');

            $data['ntotal_cut']   = $this->input->post('ntotal_cut');
            $data['ncut_maden']   = $this->input->post('ncut_maden');

            $data['decal']   = $this->input->post('decal');

            if($data['decal'] != 1)
            {
                $data['status']      = 2;
            }else {
                $data['status']      = 1;
            }
          
            $this->db->where('tracing_id', $id[$i])->update('tracing', $data);


            if($data['decal'] == 1)
            {
                $dacal_status++;
            }

        }


        if($dacal_status == 0)
        {
            $dataTr['tracing_status']      = 2;
        }else {
            $dataTr['tracing_status']      = 1;
        }

        $this->db->where('sample_id', $this->input->post('sample_id'))->update('sample', $dataTr);



        $category = $this->db->get_where('sample',array('sample_id'=>$this->input->post('sample_id')))->row()->category_id;
        
        if($category == 3)
        {
            if( $this->input->post('status') == 8)
            {
                $dataTr['status']      = 2;
                $dataTr['tracing_status']      = $this->input->post('status');
                $this->db->where('sample_id', $this->input->post('sample_id'))->update('sample', $dataTr);

            }
            
        }elseif($category == 1)
        {
           
                $dataTr['status']      = 2;
                $dataTr['tracing_status']      = 3;
                $this->db->where('sample_id', $this->input->post('sample_id'))->update('sample', $dataTr);
          
        }
    
    }


    function upload_report($sample)
    {
            //Subir imagenes de la des

            $file_name = 'file';
            
            
            
            if( $_FILES[$file_name]['name'] != "")
            {
                $md5 = md5(date('d-m-y H:i:s'));
                $dataFile['report'] = $md5.str_replace(' ', '', $_FILES[$file_name]['name']); 
                $this->db->where('sample_id',base64_decode($sample));
                $this->db->update('sample',$dataFile);
        
                $moved = move_uploaded_file($_FILES[$file_name]['tmp_name'], 'uploads/samples_files/' . $md5.str_replace(' ', '', $_FILES[$file_name]['name']));

                if( $moved ) {
                    log_message('error','subido');    
                  } else {
                    log_message('error',"Not uploaded because of error #".$_FILES[$file_name]["error"]);
                  }

                
            } 
            
    }


    function upload_file($id)
    {
            //Subir imagenes de la des
            $file_name = 'file';
            
            if( $_FILES[$file_name]['name'] != "")
            {
                $md5 = md5(date('d-m-y H:i:s'));
                $dataFile['file'] = $md5.str_replace(' ', '', $_FILES[$file_name]['name']); 
                $dataFile['sample_id'] =  $id;
                $dataFile['type'] =  1;
                $this->db->insert('sample_file',$dataFile);
        
                move_uploaded_file($_FILES[$file_name]['tmp_name'], 'uploads/samples_files/' . $md5.str_replace(' ', '', $_FILES[$file_name]['name']));
            } 
            
    }

    function upload_files($id)
    {
            //Subir imagenes de la des
            $file_name = 'file';
            
            
            if( $_FILES[$file_name]['name'] != "")
            {
                $md5 = md5(date('d-m-y H:i:s'));
                $dataFile['file'] = $md5.str_replace(' ', '', $_FILES[$file_name]['name']); 
                $dataFile['sample_id'] =  $id;
                $dataFile['type'] =  1;
                $this->db->insert('samples_file',$dataFile);
        
                move_uploaded_file($_FILES[$file_name]['tmp_name'], 'uploads/samples_files/' . $md5.str_replace(' ', '', $_FILES[$file_name]['name']));
            }
            
            echo $md5.str_replace(' ', '', $_FILES[$file_name]['name']);
            exit();
    }
    

    function aprobar($id)
    {
        
        $dataTr['diagnostic']  = $this->input->post('diagnostic');
        if($this->input->post('status'))
        $dataTr['status']      = 3;

        $this->db->where('sample_id', base64_decode($id))->update('sample', $dataTr);
            
    }

    function delete_image($id)
    {
        $file = $this->db->get_where('sample_file',array('sample_file_id'=>$id))->row()->file;

        unlink('uploads/samples_files/'.$file);
        
        $this->db->where('sample_file_id',$id);
        $this->db->delete('sample_file');
    }
    
    function pay_samples($CODE){

        $md5 = md5(date('d-m-y H:i:s'));

        $dataF['description'] = trim($this->input->post('descripcion'));
        $dataF['method']      = $this->input->post('metodo');
        $dataF['amount']      = $this->input->post('amount');
        $dataF['type']        = 1;
        $dataF['reference']   = $this->input->post('referencia');
        $dataF['date']        = $this->input->post('date');
        $date = explode('-',$this->input->post('date'));
        $dataF['year']        = $date[0];  
        $dataF['month']       = $date[1];
        $dataF['day']         = $date[2];
        $dataF['branch_id']   = $this->session->userdata('current_clinic');
        $dataF['invoiced']    = $this->input->post('facturado');
        $dataF['user_id']     = $this->session->userdata('login_user_id');
        $dataF['user_type']   = $this->session->userdata('login_type');
        $dataF['category_id'] =  $this->input->post('category_id');;
        $dataF['sample_code'] = $CODE;
       
        if($_FILES['invoice']['size'] > 0){
            $dataF['invoice'] = $md5.str_replace(' ', '', $_FILES['invoice']['name']);
            move_uploaded_file($_FILES['invoice']['tmp_name'], 'uploads/files/' . $md5.str_replace(' ', '', $_FILES['invoice']['name']));
        }

        if($_FILES['document']['size'] > 0){
            $dataF['document'] = $md5.str_replace(' ', '', $_FILES['document']['name']);
            move_uploaded_file($_FILES['document']['tmp_name'], 'uploads/files/' . $md5.str_replace(' ', '', $_FILES['document']['name']));
        }
        
        $response = $this->db->insert('financial', $dataF);
        $id_financiero =$this->db->insert_id();
        $type = $this->session->userdata('login_type');

        $mensaje = "Ha creado un nuevo pago : ".$id_financiero;
        $this->crud_model->insertar_bitacora($mensaje);
        $this->crud_model->new_notificacion($mensaje, base64_encode($type.'/financial/'), 'Financiero');
        
        $data['financial_id'] = $id_financiero;
        $data['status_payment'] = 1;

        $response = $this->db->where('code', $CODE)->update('sample', $data);
        
        $categoria = $this->input->post('category_id');
        
        $mensaje = "Ha realizado el pago de la muestra con código: ". $this->input->post('code');
       // $this->crud_model->insertar_bitacora($mensaje);
      // $this->crud_model->new_notificacion($mensaje, base64_encode($type.'/muestras/'.base64_encode($categoria)), 'Muestras');
        
        
        return $response;
    }


    function pay_exam($sample_piece){

        $md5 = md5(date('d-m-y H:i:s'));

        $mensaje = "Ha confirmado el pago del examen de la pieza : ".$sample_piece;
        $this->crud_model->insertar_bitacora($mensaje);
        
        $data['status'] = 1;
        $response = $this->db->where('code', $CODE)->update('sample', $data);
        
        $categoria = $this->input->post('category_id');
        
        $mensaje = "Ha realizado el pago de la muestra con código: ". $this->input->post('code');
       // $this->crud_model->insertar_bitacora($mensaje);
      // $this->crud_model->new_notificacion($mensaje, base64_encode($type.'/muestras/'.base64_encode($categoria)), 'Muestras');
        
        return $response;
    }

    function getSamples(){
            $code = $this->input->post('code');
            $samples = $this->db->get_where('sample', array('code'=>$code));
            $doctor = $this->accounts_model->short_name('admin', $samples->row()->doctors_id);
            $pieces = $this->db->get_where('sample_piece', array('sample_id'=>$samples->row()->sample_id));
            $delivered_by = $samples->row()->delivered_by;
            $branch_id = $samples->row()->branch_id;
            $credito = $samples->row()->credit ==  1 ?'Crédito':'Pagada';
            

               if($samples->row()->status_priority == 1 ) {
                    $prioridad = 'normal';
                }elseif($samples->row()->status_priority == 2) {
                    $prioridad = 'prioridad ';
                }elseif($samples->row()->status_priority == 3) {
                    $prioridad = 'Urgencia 4 días';
                }elseif($samples->row()->status_priority == 4 ) {
                    $prioridad = 'Urgencia';
                }
            
            if($samples->row()->user_type == 'staff')
            {
                $user_type= "staff";
            }else {
                $user_type= $samples->row()->user_type;
            }
            $user = $this->accounts_model->short_name($user_type, $samples->row()->user_id);
            $html = '<div class="ticket">
            <p class="centrado">
                <img src="'.base_url().'public/uploads/'.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo.'" alt="Logotipo">
            </p>
            <p class="centrado">'.$this->db->get_where('settings', array('type'=>'name'))->row()->description.'</p>
            <p class="centrado">Ticket de muestra</p>
            <p class="centrado"> Fecha de emisión: '.date('d/m/Y', strtotime($samples->row()->received_date) ).'</p>
            <p class="centrado">-Doctor-</p>
            <p class="centrado">Dr. '.$doctor.'</p>
            <p class="centrado">-Entregado por-</p>
            <p class="centrado">'.$delivered_by.'</p>
            <p class="centrado">-Prioridad-</p>
            <p class="centrado">'.$prioridad.'</p>
            <p class="centrado">'.$credito.'</p>
            <p class="centrado">-DATOS-</p>
            <div class="table-responsive">
            <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Paciente</th>
                    <th>Estudio</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($pieces->result_array() as $sp) {
                $total +=  $sp['price'];
                $html.='<tr>
                    <th scope="row" class="text" style="font-size:10px;width:20px;font-weight: lighter;">'.$sp['code'].'</th>
                    <td style="font-size:10px;white-space: normal;width:20px;font-weight: lighter;">'.$this->db->get_where('patient', array('patient_id'=>$samples->row()->patient_id))->row()->first_name.'</td>
                    <td style="font-size:10px;width:30px;font-weight: lighter;">'.$sp['study'].'</td>
                    <td style="font-size:10px;font-weight: lighter;">Q.'.number_format($sp['price'],2,'.',',').'</td>
                    </tr> ';
            }
            $html.='<tr>
                <th></th>
                <td></td>
                <td style="font-size:10px">Total</td>
                <td style="font-size:10px;font-weight: lighter;">Q.'.number_format($total,2,'.',',').'</td>
                </tr>
            </tbody>
            </table>
            </div>
            </div>';

            return $html;
    }

    function getGroupSamples(){
        $code = $this->input->post('code');
        $samples = $this->db->order_by('sample_id', 'DESC')->get_where('sample', array('code_group'=>$code));
        $doctor = $this->accounts_model->short_name('admin', $samples->row()->doctors_id);
        $user = $this->accounts_model->short_name('staff', $samples->row()->user_id);
        $delivered_by = $samples->row()->delivered_by;
        $credito = $samples->row()->credit ==  1 ?'Crédito':'Pagada';
        $branch_id = $samples->row()->branch_id;
        
        if($samples->row()->status_priority == 1 ) {
            $prioridad = 'normal';
        }elseif($samples->row()->status_priority == 2) {
            $prioridad = 'prioridad ';
        }elseif($samples->row()->status_priority == 3) {
            $prioridad = 'Urgencia 4 días';
        }elseif($samples->row()->status_priority == 4 ) {
            $prioridad = 'Urgencia';
        }
        
        $html = '<div class="ticket">
        <p class="centrado">
            <img src="'.base_url().'public/uploads/'.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo.'" alt="Logotipo">
        </p>
        <p class="centrado">'.$this->db->get_where('settings', array('type'=>'name'))->row()->description.'</p>
        <p class="centrado">'.$this->db->get_where('branch', array('branch_id'=>$branch_id))->row()->name.'</p>
        <p class="centrado">Ticket de muestra</p>
        <p class="centrado"> Fecha de emisión: '.date('d/m/Y', strtotime($samples->row()->received_date) ).'</p>
        <p class="centrado">-Doctor-</p>
        <p class="centrado">Dr. '.$doctor.'</p>
        <p class="centrado">-Entregado por-</p>
        <p class="centrado">'.$delivered_by.'</p>
        <p class="centrado">-Prioridad-</p>
        <p class="centrado">'.$prioridad.'</p>
        <p class="centrado">'.$credito.'</p>
        <p class="centrado">-DATOS-</p>
        <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Paciente</th>
                <th>Estudio</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($samples->result_array() as $sp) {
            $total +=  $sp['total'];
            $html.='<tr>
                <th scope="row" class="text">'.$sp['code'].'</th>
                <td style="width:80px;white-space:normal">'.$this->db->get_where('patient', array('patient_id'=>$sp['patient_id']))->row()->name.'</td>
                <td>'.$sp['study'].'</td>
                <td>Q.'.number_format($sp['total'],2,'.',',').'</td>
                </tr> ';
        }
        $html.='<tr>
            <th></th>
            <td></td>
            <td>Total</td>
            <td>Q.'.number_format($total,2,'.',',').'</td>
            </tr>
        </tbody>
        </table>
        </div><p class="centrado" >'.$user.' <br> '.$this->db->get_where('branch', array('branch_id'=>$this->session->userdata('current_clinic')))->row()->name.'<br>'.$samples->row()->time.'</p>
        </div>';


        return $html;
    }


    function getSamplesDelivery(){
        log_message('error','delivery_sample');
        log_message('error',$this->input->post('code'));

        $code = $this->input->post('code');
        $samples = $this->db->get_where('sample', array('code'=>$code));
        $doctor = $this->accounts_model->short_name('admin', $samples->row()->doctors_id);
        $pieces = $this->db->get_where('sample_piece', array('sample_id'=>$samples->row()->sample_id));
        $user = $this->accounts_model->short_name($samples->row()->user_type, $samples->row()->user_id);    

        if($samples->row()->delivery_user_type != "")
        {
            $delivery_type = $samples->row()->delivery_user_type == "staff"?'staff':'admin';
            $delivery =$this->accounts_model->short_name($delivery_type, $samples->row()->delivery_user_id) ;
        }

        $html = '<div class="ticket">
        <p class="centrado">
            <img src="'.base_url().'public/uploads/'.$this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo.'" alt="Logotipo">
        </p>
        <p class="centrado">'. $this->db->get_where('settings', array('type'=>'name'))->row()->description.'</p>
        <p class="centrado">'. $this->db->get_where('settings', array('type'=>'address'))->row()->description.'</p>
        <p class="centrado">Ticket de Entrega</p>
        <p class="centrado"> Fecha de emisión: '.date('d/m/Y', strtotime($samples->row()->received_date) ).'</p>
        <p class="centrado"> Fecha de entrega: '.date('d/m/Y', strtotime($samples->row()->delivery_date) ).'</p>
        <p class="centrado"> Entregado por: </p>
        <p class="centrado"> '.$delivery.' </p>
        <p class="centrado"> Dirección de entrega: '.$samples->row()->address.'</p>
        <p class="centrado">-Doctor-</p>
        <p class="centrado">Dr.'.$doctor.'</p>
        <p class="centrado">-DATOS-</p>
        <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Paciente</th>
                <th>Estudio</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($pieces->result_array() as $sp) {
            $total +=  $sp['price'];
            $html.='<tr>
                <th scope="row" class="text">'.$sp['code'].'</th>
                <td>'.$this->db->get_where('patient', array('patient_id'=>$samples->row()->patient_id))->row()->name.'</td>
                <td>'.$sp['study'].'</td>
                <td>Q.'.number_format($sp['price'],2,'.',',').'</td>
                </tr> ';
        }
        $html.='<tr>
            <th></th>
            <td></td>
            <td>Total</td>
            <td>Q.'.number_format($total,2,'.',',').'</td>
            </tr>
        </tbody>
        </table>
        </div>
        <p class="centrado">Sucursal: '.$this->db->get_where('branch', array('branch_id'=>$this->session->userdata('current_clinic')))->row()->name.'</p>
        </div>';

        return $html;
}

    function getSamplesTotal(){
        return $this->db->query('SELECT sum(total) as total FROM `sample` where month = '.date('m').' and year = '.date('Y'))->row()->total;
    }

    function getSamplesTotalUser($user_id){
        return $this->db->query('SELECT sum(total) as total FROM `sample` where month = '.date('m').' and year = '.date('Y'))->row()->total;
    }

    function getSamplesTotalGraph(){
        $branch_id = $this->session->userdata('current_clinic');
        return $this->db->query('SELECT * FROM `sample` where month = '.date('m').' and year = '.date('Y').' and branch_id = '.$branch_id)->num_rows();
    }

    function getMySamplesTotal(){

        $total = $this->db->query('SELECT sum(total) as total FROM `sample` where user_id = "'.$this->session->userdata('login_user_id').'" and user_type = "'.$this->session->userdata('login_type').'" and month = '.date('m').' and year = '.date('Y'))->row()->total;
        
        if($total == "")
        {
            $total = 0;
        }

        return $total;
        
    }

    function getUserSamples($user_id,$user_type,$category_id,$date){
   
        return  $this->db->query('SELECT * FROM `sample` where category_id = "'.$category_id.'" and user_id = "'.$user_id.'" and user_type = "'.$user_type.'"  and date = "'.$date.'"')->result_array();
    }

    function getUserPays($user_id,$user_type,$category_id,$date){

        return  $this->db->query('SELECT * FROM `financial` where category_id = "'.$category_id.'" and user_id = "'.$user_id.'" and user_type = "'.$user_type.'"  and date = "'.$date.'"')->result_array();
    }

    function getDoctorTotalSamples($doctors_id,$user_type,$category_id,$date_start,$date_end){
   
        return  $this->db->query('SELECT * FROM `sample` where category_id = "'.$category_id.'" and doctors_id = "'.$doctors_id.'"  and date >= "'.$date_start.'" and date <=  "'.$date_end.'"')->result_array();
    }

    function getUserTotalSamples($user_id,$user_type,$category_id,$date_start,$date_end){
   
        return  $this->db->query('SELECT * FROM `sample` where category_id = "'.$category_id.'" and user_id = "'.$user_id.'" and user_type = "'.$user_type.'"  and date >= "'.$date_start.'" and date <=  "'.$date_end.'"')->result_array();
    }

    function getUserTotalPays($user_id,$user_type,$category_id,$date_start,$date_end){

        return  $this->db->query('SELECT * FROM `financial` where category_id = "'.$category_id.'" and user_id = "'.$user_id.'" and user_type = "'.$user_type.'"  and date >= "'.$date_start.'" and date <= "'.$date_end.'"')->result_array();
    }

    function getadminTotalPays($user_id,$user_type,$category_id,$date_start,$date_end){

        return  $this->db->query('SELECT * FROM `financial` where category_id = "'.$category_id.'" and user_id = "'.$user_id.'" and user_type = "'.$user_type.'"  and date >= "'.$date_start.'" and date <= "'.$date_end.'"')->result_array();
    }
    

    function totalSamples($date){
        return $this->db->get_where('sample', array('date'=>$date, 'branch_id'=> $this->session->userdata('current_clinic')))->num_rows();
    }

    function totalSamplesDetail($date, $category_id){
        return $this->db->get_where('sample', array('date'=>$date , 'category_id'=>$category_id, 'branch_id'=> $this->session->userdata('current_clinic')))->num_rows();
    }

    function totalSamplesCredito($date){
        return $this->db->get_where('sample', array('date'=>$date,'credit'=>1, 'branch_id'=> $this->session->userdata('current_clinic')))->num_rows();
    }

    function totalSamplesContado($date){
        return $this->db->get_where('sample', array('date'=>$date,'credit'=>0, 'branch_id'=> $this->session->userdata('current_clinic')))->num_rows();
    }

    function pay_credit_group(){

        $sample = $this->input->post('sample');
        $num_of_sample =count($sample);

        if($_FILES['invoice']['size'] > 0){
            $dataF['invoice'] = $md5.str_replace(' ', '', $_FILES['invoice']['name']);
            move_uploaded_file($_FILES['invoice']['tmp_name'], 'uploads/files/' . $md5.str_replace(' ', '', $_FILES['invoice']['name']));
        }

        if($_FILES['document']['size'] > 0){
            $dataF['document'] = $md5.str_replace(' ', '', $_FILES['document']['name']);
            move_uploaded_file($_FILES['document']['tmp_name'], 'uploads/files/' . $md5.str_replace(' ', '', $_FILES['document']['name']));
        }

        for ($i=0; $i < $num_of_sample ; $i++) { 
            if($this->input->post('checkbox_'.$sample[$i])==1)
            {
                $data = $this->db->get_where('sample', array('sample_id'=>$sample[$i]))->row();
               
                $dataF['description'] = 'Pago de muestra con código '.$data->code;
                $dataF['method']      = $this->input->post('metodo');
                $dataF['amount']      = $data->total;
                $dataF['type']        = 1;
                $dataF['reference']   = $this->input->post('referencia');
                $dataF['date']        = $this->input->post('date');
                $date = explode('-',$this->input->post('date'));
                $dataF['year']        = $date[0];  
                $dataF['month']       = $date[1];
                $dataF['day']         = $date[2];
                $dataF['branch_id']   = $data->branch_id;
                $dataF['user_id']     = $this->session->userdata('login_user_id');
                $dataF['user_type']   = $this->session->userdata('login_type');
                $dataF['invoiced']    = $this->input->post('facturado');
                $dataF['sample_code'] = $data->code;
        
                $md5 = md5(date('d-m-y H:i:s'));
        
                $response = $this->db->insert('financial', $dataF);
                $id_financiero =$this->db->insert_id();
                $type = $this->session->userdata('login_type');
        
                $mensaje = "Ha creado un nuevo pago: ".$id_financiero;
              //  $this->crud_model->insertar_bitacora($mensaje);
                //$this->crud_model->new_notificacion($mensaje, base64_encode('financial'), 'Financiero');  
                
                $dataS['status_payment'] = 1;
                $dataS['financial_id'] = $id_financiero;
                $this->db->where('sample_id',$sample[$i])->update('sample', $dataS);
            }
        }
        
        return $response;
    }

    /* reporte de muestras  */

    function mes_report($date_start, $date_end){
        
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days")))
        {
            $result.= substr($i, -2).','; 
        }
        
        return $result;
    }

    function citor_report($date_start, $date_end, $category_id){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $total = $this->db->get_where('sample', array('branch_id'=>$branch_id, 'date'=>$i, 'category_id'=>$category_id , 'status !=' => 0))->num_rows();
            
            if($total == '')
                $result .= '0,';
            else
                $result .= $total.',';
        }
        return $result;
    }

    function pato_report($date_start, $date_end, $category_id){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $total = $this->db->get_where('sample', array('branch_id'=>$branch_id, 'date'=>$i, 'category_id'=>$category_id , 'status !=' => 0))->num_rows();
            
            if($total == '')
                $result .= '0,';
            else
                $result .= $total.',';
        }
        return $result;
    }

    function trans_report($date_start, $date_end, $category_id){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $total = $this->db->get_where('sample', array('branch_id'=>$branch_id, 'date'=>$i, 'category_id'=>$category_id , 'status !=' => 0))->num_rows();
            
            if($total == '')
                $result .= '0,';
            else
                $result .= $total.',';
        }
        return $result;
    }

    function inmu_report($date_start, $date_end, $category_id){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $total = $this->db->get_where('sample', array('branch_id'=>$branch_id, 'date'=>$i, 'category_id'=>$category_id , 'status !=' => 0))->num_rows();
            
            if($total == '')
                $result .= '0,';
            else
                $result .= $total.',';
        }
        return $result;
    }
    
    
    
    function getTotalCategory($date_start, $date_end){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $cito += $this->db->get_where('sample', array('category_id'=>1 , 'date'=>$i , 'branch_id'=>$branch_id , 'status !=' => 0))->num_rows();
            $pato += $this->db->get_where('sample', array('category_id'=>3 , 'date'=>$i , 'branch_id'=>$branch_id , 'status !=' => 0))->num_rows();
            $trans += $this->db->get_where('sample', array('category_id'=>4, 'date'=>$i , 'branch_id'=>$branch_id , 'status !=' => 0))->num_rows();
            $inmu += $this->db->get_where('sample', array('category_id'=>8 , 'date'=>$i , 'branch_id'=>$branch_id , 'status !=' => 0))->num_rows();
        }
        $total = $cito.','.$pato.','.$trans.','.$inmu;
    
        return $total;
    }
    
    
    function bill_report(){
        $branch_id = $this->session->userdata('current_clinic');
        $bills  = $this->db->get_where('bill', array('status'=>1 , 'branch_id'=>$branch_id))->result_array();
        foreach ($bills as $row) {
            $result .= "'".$row['name']."',";
        }
        return $result;
    }
    
    function bill_paid_report($date_start, $date_end){
        $branch_id = $this->session->userdata('current_clinic');
        $bills  = $this->db->get_where('bill', array('status'=>1, 'branch_id'=>$branch_id))->result_array();
        
        foreach ($bills as $row) {
            
            for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
                $total += $this->db->get_where('sample', array('branch_id'=>$branch_id, 'date'=>$i, 'bill_id'=>$row['bill_id'] , 'status_payment'=>1))->num_rows();
            }
        }
        
        return $total;
    }
    

    
    function totalFinancial($date_start, $date_end){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $total += $this->db->get_where('sample', array( 'date'=>$i , 'branch_id'=>$branch_id , 'status !=' => 0))->num_rows();
        }
        return $total;
    }
    
    function totalFinancialCredito($date_start, $date_end){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $total += $this->db->get_where('sample', array( 'date'=>$i , 'branch_id'=>$branch_id, 'credit'=>1 , 'status !=' => 0))->num_rows();
        }
        return $total;
    }
    
    function totalFinancialContado($date_start, $date_end){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $total += $this->db->get_where('sample', array( 'date'=>$i , 'branch_id'=>$branch_id, 'credit'=>0 , 'status !=' => 0))->num_rows();
        }
        return $total;
    }
    
    function balanceReport($date_start, $date_end){
        $branch_id = $this->session->userdata('current_clinic');
        
        $total = $this->db->query("SELECT sum(amount) as total  FROM `financial` WHERE `branch_id` = $branch_id AND `status`=1 AND  `date` BETWEEN '$date_start' AND '$date_end'")->row()->total;
        
        return $total;
    }
    
    
    function TotalIngresosReport($date_start, $date_end){
        $branch_id = $this->session->userdata('current_clinic');
        
        $total = $this->db->query("SELECT sum(amount) as total  FROM `financial` WHERE `branch_id` = $branch_id AND `type` =1  AND `status`=1   AND `date` BETWEEN '$date_start' AND '$date_end' AND 	category_financial_id != 0")->row()->total;
        
        return $total;
    }
    
    function TotalEgresosReport($date_start, $date_end){
        $branch_id = $this->session->userdata('current_clinic');
        
        $total = $this->db->query("SELECT sum(amount) as total  FROM `financial` WHERE `branch_id` = $branch_id AND `type` = 0 AND `status`=1  AND `date` BETWEEN '$date_start' AND '$date_end'")->row()->total;
        
        return $total;
    }
    
    function totalSamplesCredit($bill_id){
        
        $data = $this->db->get_where('sample', array('bill_id'=>$bill_id , 'status !=' => 0));
    
        if($data->num_rows() > 0){
            foreach ($data->result_array() as $row) {
            
                if($row['date'] < date('Y-m-d') && $row['status_payment']==0){
                    $result = 3;
                }else{
                    $result = 2;
                }
            }
        }else{
            $result = 1;
        }
    
        
        return $result;
    }
    /* fin del reporte de muestras  */

    function delivery($code){

        if($this->session->userdata('login_type') != 'staff')
        {
            $user_type = "staff";
        }else
        {
            $user_type = $this->session->userdata('login_type');
        }

        $patient_id = $this->db->where('code',$code)->get('sample')->row()->patient_id;
        $date = $this->db->where('code',$code)->get('sample')->row()->date;
        $patient = $this->db->where('patient_id',$patient_id)->get('patient')->row_array();
      
        $this->load->library('M_pdf');

        if($this->input->post('send_email'))
        {
           
            

            if($patient['email'] != '')
            { 
                log_message('error', 'enivado correo:'.$patient['email']);

                // Get output html
    
                $sample= $this->db->get_where('sample',array('code'=>$code))->row();
                $laboratory = 'laboratorios-'.$sample->patient_name.'-'.$sample->study.'.pdf';

                log_message('error', 'enivado sample_id:'. $sample->sample_id);
                
                $page_data['sample_id'] = base64_encode($sample->sample_id);
                $html = $this->load->view('backend/pdf/laboratory_result.php', $page_data, true);
                $mpdf = new mPDF('utf-8', 'letter');
                $mpdf->WriteHTML($html, 0);
                $mpdf->Output($laboratory, "F");

                $body = 'Acontinuación puedes consultar los resultados de tus laboratorios solicitados el dia '.$date;
                $this->email_model->send_email($patient['email'], 'Resultados de laboratorio',$body,$laboratory);

                unlink($laboratory);
            }

          
        }


        
        if($this->input->post('send_whatsapp'))
        {
            log_message('error', 'enivado whatsapp:'.$patient);
            if($patient['phone'] != '')
            { 
                log_message('error', 'enivado whatsapp:'.$patient['area_code'].$patient['phone']);

                // Get output html
                $sample= $this->db->get_where('sample',array('code'=>$code))->row();
                $laboratory = 'laboratorios-'.$sample->patient_name.'-'.$sample->study.'.pdf';

                log_message('error', 'enivado sample_id:'. $sample->sample_id);
                
                $page_data['sample_id'] = base64_encode($sample->sample_id);
                $html = $this->load->view('backend/pdf/laboratory_result.php', $page_data, true);

                $mpdf = new mPDF('utf-8', 'letter');
                $mpdf->WriteHTML($html, 0);
                $mpdf->Output($laboratory, "F");

                $body = 'Acontinuación puedes consultar los resultados de tus laboratorios solicitados el dia '.$date;


                $message = $this->input->post('message');
                $dataW = array(
                    'phone' => $patient['area_code'].$patient['phone'],
                    'message' => $body,
                    'file' => $laboratory,
                    'response' => json_encode(''),
                    'status' => 0,
                    'user_type' => 'patient',
                    'user_id' => $patient['patient_id']
                    );
                
                $this->db->insert('whatsapp_messages',$dataW);
                $id= $this->db->insert_id();    

                $this->whatsapp->curl_whatsapp_file($patient['area_code'].$patient['phone'],$body,$laboratory,$id);

             
            }
        }

        $data['delivery_user_type'] = $user_type;
        $data['delivery_user_id']   = $this->session->userdata('login_user_id');
        $data['delivery_date']      = $this->input->post('delivery_date');
        $data['status_delivery']    = 1;

        $response = $this->db->where('code',$code)->update('sample', $data);
        $type = $this->session->userdata('login_type');

        $mensaje = "Ha entregado la muestra : ".$code;
       // $this->crud_model->insertar_bitacora($mensaje);
       // $this->crud_model->new_notificacion($mensaje, base64_encode($type.'/samples/MQ=='), 'Entrega');  

        return $response;
    }


    function next(){

        $sample    = $this->input->post('sample');
        $checkbox     = $this->input->post('checkbox');
        
        foreach ($sample as $TR){

            if($this->input->post('checkbox_'.$TR)==1){

                $tracing_status = $this->db->get_where('sample', array('sample_id'=>$TR))->row()->tracing_status + 1;

                $dataS['tracing_status'] = $tracing_status;
                $result = $this->db->where('sample_id',$TR)->update('sample',$dataS);

                $dataTR['status'] = $tracing_status;
                $this->db->where('sample_id',$TR)->update('tracing',$dataTR);
                
                $type = $this->session->userdata('login_type');
                $mensaje = "Ha cambiado el estado del proceso con ID: ".$TR;
               // $this->crud_model->insertar_bitacora($mensaje);
                //$this->crud_model->new_notificacion($mensaje, base64_encode($type.'/process/'.$type.'/'.$status), 'Entrega'); 
            }
            
        }

        return $result;
    }

    /* Reporte de doctor  */
    function citor_report_doctor($doctor_id,  $category_id){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=1; $i<=12; $i++ ) {
            $total = $this->db->get_where('sample', array('branch_id'=>$branch_id, 'month'=>$i, 'year'=>date('Y'), 'doctors_id'=>$doctor_id, 'category_id'=>$category_id , 'status !=' => 0))->num_rows();
            
            if($total == '')
                $result .= '0,';
            else
                $result .= $total.',';
        }
        return $result;
    }

    function pato_report_doctor($doctor_id, $category_id){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=1; $i<=12; $i++ ) {
            $total = $this->db->get_where('sample', array('branch_id'=>$branch_id, 'month'=>$i, 'year'=>date('Y'), 'doctors_id'=>$doctor_id, 'category_id'=>$category_id , 'status !=' => 0))->num_rows();
            
            if($total == '')
                $result .= '0,';
            else
                $result .= $total.',';
        }
        return $result;
    }

    function trans_report_doctor($doctor_id, $category_id){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=1; $i<=12; $i++ ) {
            $total = $this->db->get_where('sample', array('branch_id'=>$branch_id, 'month'=>$i, 'year'=>date('Y'), 'doctors_id'=>$doctor_id, 'category_id'=>$category_id , 'status !=' => 0))->num_rows();
            
            if($total == '')
                $result .= '0,';
            else
                $result .= $total.',';
        }
        return $result;
    }

    function inmu_report_doctor($doctor_id, $category_id){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=1; $i<=12; $i++ )  {
            $total = $this->db->get_where('sample', array('branch_id'=>$branch_id, 'month'=>$i, 'year'=>date('Y'), 'doctors_id'=>$doctor_id, 'category_id'=>$category_id , 'status !=' => 0))->num_rows();
            
            if($total == '')
                $result .= '0,';
            else
                $result .= $total.',';
        }
        return $result;
    }

    function getTotalCategoryDoctor($date_start, $date_end, $ID){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $cito += $this->db->get_where('sample', array('category_id'=>1 , 'date'=>$i , 'branch_id'=>$branch_id, 'doctors_id'=>$ID, 'status !=' => 0))->num_rows();
            $pato += $this->db->get_where('sample', array('category_id'=>3 , 'date'=>$i , 'branch_id'=>$branch_id, 'doctors_id'=>$ID, 'status !=' => 0))->num_rows();
            $trans += $this->db->get_where('sample', array('category_id'=>4, 'date'=>$i , 'branch_id'=>$branch_id, 'doctors_id'=>$ID, 'status !=' => 0))->num_rows();
            $inmu += $this->db->get_where('sample', array('category_id'=>8 , 'date'=>$i , 'branch_id'=>$branch_id, 'doctors_id'=>$ID, 'status !=' => 0))->num_rows();
        }
        $total = $cito.','.$pato.','.$trans.','.$inmu;
    
        return $total;
    }

    function totalFinancialDoctor($date_start, $date_end, $ID){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $total += $this->db->get_where('sample', array( 'date'=>$i , 'branch_id'=>$branch_id, 'doctors_id'=>$ID , 'status !=' => 0))->num_rows();
        }
        return $total;
    }

    function totalFinancialCreditoDoctor($date_start, $date_end, $ID){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $total += $this->db->get_where('sample', array( 'date'=>$i , 'branch_id'=>$branch_id, 'credit'=>1 , 'doctors_id'=>$ID , 'status !=' => 0))->num_rows();
        }
        return $total;
    }

    function totalFinancialContadoDoctor($date_start, $date_end, $ID){
        $branch_id = $this->session->userdata('current_clinic');
        for($i=$date_start;$i<=$date_end;$i = date("Y-m-d", strtotime($i ."+ 1 days"))) {
            $total += $this->db->get_where('sample', array( 'date'=>$i , 'branch_id'=>$branch_id, 'credit'=>0 ,'doctors_id'=>$ID , 'status !=' => 0))->num_rows();
        }
        return $total;
    }

    function method($code)
    {
        
        $method  = $this->db->get_where('financial',array('sample_code'=>$code))->row()->method;

        if($method == 1)
         return 'Efectivo';
        else if ($method == 2)
        return 'Tarjeta';
        else if ($method == 3)
        return 'Cheque';
        else if ($method == 4)
        return 'Depósito';
        else if ($method == 5)
        return 'Transferencia';
        # code...
    }

    function payment_method($method)
    {
        if($method == 1)
         return 'Efectivo';
        else if ($method == 2)
        return 'Tarjeta';
        else if ($method == 3)
        return 'Cheque';
        else if ($method == 4)
        return 'Depósito';
        else if ($method == 5)
        return 'Transferencia';
        # code...
    }

    /* en report de doctor  */
    
    /* End Samples */
}