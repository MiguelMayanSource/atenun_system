<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud_services extends CI_Model 
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
        $dataS['product_id']    =  $this->input->post('exmans');
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


    function get_services_appointment($appointment_id,$type)
        {
            log_message('error','appointment_services '.$appointment_id);
             $labs = $this->db->get_where('patient_service',array('origin'=>'appointment','origin_id'=>$appointment_id,'type'=>$type))->result_array(); $cont =1;
                 $html = '';      
             if(count($labs) > 0 ){
         $html .= '<hr>
            <h4>Rayos X</h4>
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
                        
                    
              $html .='<tr>
                        <td>
                             '. $cont++.'
                        </td>
                        <td>
                            <img src=" '. $this->accounts_model->get_photo('admin', $sm['doctor_id']).'" width="35px" style="padding-right:6px">
                             '. $this->accounts_model->gender($sm['doctor_id']).'
                             '. $this->accounts_model->short_name('admin', $sm['doctor_id']).'
                        </td>
                        <td>
                             '. $sm['code'].'
                        </td>
                        <td>
                             '. $this->db->get_where('product',array('product_id'=>$sm['product_id']))->row()->name.'
                        </td>
                        <td> 
                            Q.'. $sm['total'].'
                        </td>
                        <td>';
                            if($sm['status'] == 0)
                            {
                                $html .='<span class="text-info"><b>Pendiente</b></span>';
                            }else if($sm['status'] == 1)
                            {
                                $html .='<span class="text-success"><b>Confirmada</b></span>';
                            }
                            if($sm['status'] == 2)
                            {
                                $html .='<span class="text-danger"><b>Denegada</b></span>';
                            }

                        $html .='</td>
                        <td>';
                            
                             if($sm['status'] == 0){
                        $html .=' <i onclick="rayStatus(\''.$sm['patient_service_id'].'\')" class="text-info picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash" style="font-size:22px;cursor:pointer" data-toggle="tooltip" data-placement="top" title="Pagar"></i>';
                              }elseif($sm['status'] == 1){
                         $html .='<input type="hidden" class="total_rays" value="'.$sm['total'].'">';
                           
                               }
                               
                       $html .='</td>
                    </tr>
                    
                    ';
                     endforeach; 
                     $html .='</table>
                        </div>';
                    }

                    echo $html;
                    exit();

        }
        

   /* End Samples */
}