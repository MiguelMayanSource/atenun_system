<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud_rayx extends CI_Model 
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

    function ServiceCode($id){
        $result ='';
        
        if($id == 1 )
        {
            $name = 'RAY';
           
            
            $cont = $this->db->get_where('patient_service',array('type'=>$id))->num_rows()+1;

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
           
            
            $cont = $this->db->get_where('patient_service',array('type'=>$id))->num_rows()+1;

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
    
    
         //Funciones de muestras
    function create_service()
    {
        $sampleCode = $this->ServiceCode( $this->input->post('type'));
        $md5 = md5(date('d-m-y H:i:s'));
        
     
        $patient_id = $this->input->post('patient_id'); 
        $dataS['patient_name']  = $this->accounts_model->get_full_name('patient',$patient_id);


        if($this->input->post('doctors_id') != 0)
        {
            $dataS['doctor_id']    = $this->input->post('doctors_id');
            $dataS['doctor_name']   = $this->accounts_model->get_full_name('admin',$this->input->post('doctor_name'));
        }else
        {
            $dataS['doctor_id']    = $this->input->post('doctors_id');
            $dataS['doctor_name']   = $this->input->post('doctor_name');
        }


        $dataS['code']          = $sampleCode;
        $dataS['date'] =         $this->input->post('fecha_recibido');
        $dataS['patient_id']    = $patient_id;
        $dataS['status']  = 0;
        $dataS['origin'] =         $this->input->post('origin');
        $dataS['origin_id'] =         $this->input->post('origin_id');
        $dataS['total'] =         $this->input->post('total');
        $dataS['type'] =         $this->input->post('type');


        //guardamos la muestra
        $response = $this->db->insert('patient_service', $dataS);


        $mensaje = "Ha creado una nueva orde de rayos x con código : ".$sampleCode." paciente: ".$dataS['patient_name'];
        //$this->crud_model->insertar_bitacora($mensaje);
        //$this->crud_model->new_notificacion($mensaje, base64_encode($type.'/samples/'.base64_encode($this->input->post('category_id')).'/'), 'Muestras');
        return $sampleCode;
    }


   /* End Samples */
}