<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tables_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
    
    
    function getTables($table = '', $param1 = '', $param2 = '', $param3 = '')
    {
        $fetch_data = $this->MakeTable($table, $param1, $param2, $param3);  
        
        $data = $this->getArrays($table,$fetch_data,$param1, $param2, $param3);    

        $output = array(  
            "draw"                      =>      intval($_POST["draw"]),  
            "recordsTotal"              =>      $this->GetAllData($table,$param1, $param2, $param3),  
            "recordsFiltered"           =>      $this->GetFilteredData($table,$param1, $param2, $param3),  
            "data"                      =>      $data  
        );  
        
        echo json_encode($output); 
    }
    
    function MakeTable($table,$param1, $param2, $param3)
	{  
        $this->MakeQuery($table,$param1, $param2, $param3);  
        if($_POST["length"] != -1)  
        {  
            $this->db->limit($_POST['length'], $_POST['start']);  
        }  
        $query = $this->db->get();  
        return $query->result();  
    }
    
    function MakeQuery($table,$param1, $param2, $param3)  
    {  
        $this->db->select("*");  
        
        if($table == 'my_appointments')
        {
            $this->db->order_by('order_date', 'ASC');
            $this->db->from("appointment");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('doctor_id',$this->session->userdata('login_user_id'));
            $this->db->where('status !=', 4);
            $this->db->where('status !=', 5);
        }
        
        elseif($table == 'doctor_appointments')
        {
            $this->db->order_by('order_date', 'ASC');
            $this->db->from("appointment");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('doctor_id',$param1);
            $this->db->where('status !=', 4);
            $this->db->where('status !=', 5);
        }
        
        elseif($table == 'patients')
        {
            if($param1 == 0){
                $this->db->order_by('first_name', 'ASC');
                $this->db->from("patient");
                $this->db->where('status !=', 0);
            }else
            {

                $this->db->from('insurance_patients ip');
                $this->db->join('patient p', 'ip.patient_id = p.patient_id');
                $this->db->where('ip.insurance_id', $param1);
                $this->db->where('p.status', 1);

            }
            
        }
        
        
         elseif($table == 'clients')
        {
             $this->db->order_by('patient_id', 'desc');
            $this->db->from("patient");
            $this->db->where('status',1); 
            $this->db->where('client_status',1); 
            
        }

        elseif($table == 'patient_history')
        {

            $this->db->order_by('appointment_id', 'desc');
            $this->db->from("appointment");
            $this->db->where('patient_id', $param1); 
    
        }


        elseif($table == 'stabilitation')
        {
            $this->db->select('a.*,d.*');
            $this->db->from('stabilitation_ref a');
            $this->db->join('patient d', 'a.patient_id = d.patient_id');
            $this->db->where('a.clinic_id',$this->session->userdata('current_clinic'));
            $this->db->order_by('a.stabilitation_ref_id', 'desc');
            
        }
        
        elseif($table == 'financial_stabilitation')
        {
            $this->db->select('a.*,d.*');
            $this->db->from('stabilitation_ref a');
            $this->db->join('patient d', 'a.patient_id = d.patient_id');
            $this->db->where('a.clinic_id',$this->session->userdata('current_clinic'));
            $this->db->order_by('a.stabilitation_ref_id', 'desc');
            
        }
        
        elseif($table == 'financial')
        {
            $this->db->order_by('financial_id', 'DESC');
            $this->db->from("financial");
            $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
        }

        elseif($table == 'financial_reports')
        {
            $this->db->order_by('financial_id', 'DESC');
            $this->db->from("financial");
            $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
            $this->db->where("str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date('".base64_decode($param1)."', '%d/%m/%Y') AND str_to_date('".base64_decode($param2)."', '%d/%m/%Y')");
        
        }
        
        elseif($table == 'activities')
        {
            $this->db->order_by('bitacora_id', 'DESC');
            $this->db->from("bitacora");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('user_id', $param1);
            $this->db->where('user_type', $param2);
        }
        
        elseif($table == 'patient_appointments')
        {
            $this->db->order_by('appointment_id','desc');
            $this->db->from("appointment");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('patient_id', $param1);
            $this->db->where('status !=', 5);
        }
        
        elseif($table == 'inventory')
        {
            $this->db->from("inventory_product");
            $this->db->where('inventory_product.inventory_id',$param1);
            $this->db->where('inventory_product.status',1);
        }

        elseif($table == 'inventory_products')
        {
            $this->db->from("product");
            $this->db->where('type',1);
            $this->db->where('status',1);
        }


        elseif($table == 'services')
        {
            $this->db->order_by('name', 'ASC');
            $this->db->from("service");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        }

        elseif($table == 'categories')
        {
            $this->db->order_by('id', 'ASC');
            $this->db->where('status',1);
            $this->db->from("category");
        }
        elseif($table == 'subcategories')
        {
            $this->db->order_by('id', 'ASC');
            $this->db->where('status',1);
            $this->db->from("subcategory");
        }
        elseif($table == 'pedidos')
        {
            $this->db->order_by('pedidos_id', 'ASC');
            $this->db->from("pedidos");
        }
        elseif($table == 'combos')
        {
            $this->db->order_by('combos_id', 'ASC');
            $this->db->from("combo");
            $this->db->where('status !=', 0);
        }
        elseif($table == 'sales')
        {
           $date_start = explode('/',$_POST["date_start"]);
           $date1 = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];


            $date_end = explode('/',$_POST["date_end"]);
            $date2 = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];
            $this->db->order_by('sale_id', 'DESC');
            $this->db->from("sale");
            $this->db->where('DATE(datetime) >=',  $date1);
            $this->db->where('DATE(datetime) <=', $date2);
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('status !=',0);
        }
        
           elseif($table == 'cotizaciones')
        {
            $date_start = explode('/',$_POST["date_start"]);
           $date1 = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];


           $date_end = explode('/',$_POST["date_end"]);
           $date2 = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];
            $this->db->order_by('sale_id', 'DESC');
            $this->db->from("sale");
            $this->db->where('DATE(datetime) >=',  $date1);
            $this->db->where('DATE(datetime) <=', $date2);
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('status',0);
        }
        elseif($table == 'sales_insurance')
        {
            $date_start = explode('/',$_POST["date_start"]);
           $date1 = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];


           $date_end = explode('/',$_POST["date_end"]);
           $date2 = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];
            $this->db->order_by('sale_id', 'DESC');
            $this->db->where('insurance_id',$param1);
            $this->db->where('DATE(datetime) >=',  $date1);
            $this->db->where('DATE(datetime) <=', $date2);
            $this->db->from("sale");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        }


        elseif($table == 'history')
        {
            $this->db->order_by('history_id', 'DESC');
            $this->db->from("history");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        }

        elseif($table == 'equipment')
        {
            $this->db->order_by('equipment_id', 'DESC');
            $this->db->from("equipment");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        }

        elseif($table == 'supplies')
        {
            $this->db->order_by('supplies_id', 'DESC');
            $this->db->from("supplies");
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        }
        elseif($table == 'samples')
        {
            $this->db->from("sample");
            
            $this->db->where('branch_id',$this->session->userdata('current_clinic'));
            $this->db->order_by("sample_id",'desc');
            
        }elseif($table == 'patient_service')
        {
            $this->db->from("patient_service");
            $this->db->where('type',$param1); 
            $this->db->order_by("patient_service_id",'desc');
        }
        
        //*****************
        if($_POST["search"]["value"] != "")  
        {
            if($table == 'my_appointments' || $table == 'doctor_appointments')
            {
                $this->db->like("date", $_POST["search"]["value"]);  
            }
            elseif($table == 'patients')
            {
                $this->db->where("first_name like '%". $_POST["search"]["value"]."%' and status = 1");
                $this->db->or_where("second_name like '%". $_POST["search"]["value"]."%' and status = 1");
                $this->db->or_where("concat(first_name,' ',second_name) like '%". $_POST["search"]["value"]."%' and status = 1");
                $this->db->or_where("concat(first_name,' ',second_name,' ',third_name) like '%". $_POST["search"]["value"]."%' and status = 1");
                $this->db->or_where("concat(first_name,' ',second_name,' ',third_name,' ',last_name) like '%". $_POST["search"]["value"]."%' and status = 1");
                $this->db->or_where("concat(first_name,' ',second_name,' ',third_name,' ',last_name,' ',second_last_name) like '%". $_POST["search"]["value"]."%' and status = 1");
            }

            elseif($table == 'financial')
            {
                $this->db->like("description", $_POST["search"]["value"]);  
                $this->db->or_like("type", $_POST["search"]["value"],'both');
                $this->db->or_like("date", $_POST["search"]["value"],'both'); 
                $this->db->or_like("patient_name", $_POST["search"]["value"],'both'); 
            }
            

            elseif($table == 'financial_reports')
            {
                $this->db->like("description", $_POST["search"]["value"]);  
                $this->db->or_like("type", $_POST["search"]["value"],'both');
                $this->db->or_like("date", $_POST["search"]["value"],'both'); 
                $this->db->or_like("patient_name", $_POST["search"]["value"],'both'); 
            }
            
            elseif($table == 'stabilitation')
            {
                $this->db->like("d.first_name", $_POST["search"]["value"]);  
                $this->db->or_like("d.second_name", $_POST["search"]["value"],'both');
                $this->db->or_like("d.third_name", $_POST["search"]["value"],'both'); 
                $this->db->or_like("d.last_name", $_POST["search"]["value"],'both'); 
            }
            elseif($table == 'financial_stabilitation')
            {
                $this->db->like("d.first_name", $_POST["search"]["value"]);  
                $this->db->or_like("d.second_name", $_POST["search"]["value"],'both');
                $this->db->or_like("d.third_name", $_POST["search"]["value"],'both'); 
                $this->db->or_like("d.last_name", $_POST["search"]["value"],'both'); 
            }
            
            elseif($table == 'activities')
            {
                $this->db->like("message", $_POST["search"]["value"]);  
            }
            
            elseif($table == 'patient_appointments')
            {
                $this->db->like("date", $_POST["search"]["value"]);  
            }
            
            elseif($table == 'inventory')
            {
                 $this->db->join('product p', 'p.product_id = inventory_product.product_id');
               $this->db->where(' p.code like "%'.$_POST["search"]["value"].'%" or  p.name like "%'.$_POST["search"]["value"].'%" and  p.status = 1 and inventory_product.inventory_id ='.$param1);
               $this->db->group_by('p.product_id');
            }

            elseif($table == 'inventory_products')
            {
                $this->db->like("name", $_POST["search"]["value"],'both');  
            }

            elseif($table == 'services')
            {
            
                $this->db->like("name", $_POST["search"]["value"],'both');
                //$this->db->or_like("compuesto", $_POST["search"]["value"],'both'); 
            }
            elseif($table == 'categories')
            {
                $this->db->like("name", $_POST["search"]["value"]);  
            }
            elseif($table == 'subcategories')
            {
                $this->db->like("name", $_POST["search"]["value"]);  
            }
            elseif($table == 'pedidos')
            {
                $this->db->like("date", $_POST["search"]["value"]);  
            }
            elseif($table == 'combos')
            {
                $this->db->like("date", $_POST["search"]["value"]);  
            }
            
            elseif($table == 'sales')
            {
              
                $this->db->like("total", $_POST["search"]["value"]);  
                $this->db->or_like("DATE(datetime)", $_POST["search"]["value"],'both');
                $this->db->or_like("method", $_POST["search"]["value"]);    
            }
            elseif($table == 'cotizaciones')
            {
              
                $this->db->like("total", $_POST["search"]["value"]);  
                $this->db->or_like("date", $_POST["search"]["value"],'both');
                $this->db->or_like("method", $_POST["search"]["value"]);    
            }
            elseif($table == 'sales_insurance')
            {
              
                $this->db->like("total", $_POST["search"]["value"]);  
                $this->db->or_like("DATE(datetime)", $_POST["search"]["value"],'both');
                $this->db->or_like("method", $_POST["search"]["value"]);    
            }

            elseif($table == 'history')
            {
                $this->db->like("date", $_POST["search"]["value"]);  
            }

            elseif($table == 'equipment')
            {
                $this->db->like("name", $_POST["search"]["value"],'both');  
                $this->db->or_like("location", $_POST["search"]["value"],'both');
            }

            elseif($table == 'supplies')
            {
                $this->db->like("name", $_POST["search"]["value"],'both');  
                $this->db->or_like("location", $_POST["search"]["value"],'both');
            }

            if($table == 'samples')
            {
                $this->db->like("date", $_POST["search"]["value"],'both'); 
                $this->db->or_like("code", $_POST["search"]["value"],'before');  
                $this->db->or_like("patient_name", $_POST["search"]["value"],'both');
            }
            
            if($table == 'patient_service')
            {
                $this->db->like("date", $_POST["search"]["value"],'both'); 
                $this->db->or_like("code", $_POST["search"]["value"],'before');  
                $this->db->or_like("patient_name", $_POST["search"]["value"],'both');
            }
            
            
        }  
        if(isset($_POST["order"]))  
        {  
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
        }  
        else  
        {  
            if($table == 'my_appointments' || $table == 'doctor_appointments')
            {
                $this->db->order_by('order_date', 'ASC');  
            }
            elseif($table == 'patients' )
            {
                $this->db->order_by('first_name', 'ASC');  
            }
            
            elseif($table == 'activities' )
            {
                $this->db->order_by('date', 'DESC');  
            }
            elseif($table == 'patient_appointments')
            {
                $this->db->order_by('appointment_id','desc');
            }
            elseif($table == 'sales')
            {
                $this->db->order_by('sale_id', 'DESC');
            }
             elseif($table == 'cotizaciones')
            {
                $this->db->order_by('sale_id', 'DESC');
            }
            elseif($table == 'sales_insurance')
            {
                $this->db->order_by('sale_id', 'DESC');
            }
            if($table == 'samples')
            {
                $this->db->order_by('sample_id', 'ASC');  
            }
            if($table == 'patient_service')
            {
                $this->db->order_by('patient_service_id', 'ASC');  
            }
        }  
    }
    
    function GetAllData($table,$param1, $param2, $param3)  
    {  

        if($table == 'patient_service')
        {
            $this->db->select("*");  
            $this->db->from("patient_service"); 
            $this->db->where("type",$param1); 
            return $this->db->count_all_results(); 
        }
        
         if($table == 'samples')
        {
            $this->db->select("*");  
            $this->db->from("sample"); 
            $this->db->where('branch_id',$this->session->userdata('branch_id'));
            return $this->db->count_all_results(); 
        }


        if($table == 'my_appointments')
        {
            $this->db->select("*");  
            $this->db->from("appointment"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('doctor_id',$this->session->userdata('login_user_id'));
            $this->db->where('status !=', 4);
            $this->db->where('status !=', 5);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'doctor_appointments')
        {
            $this->db->select("*");  
            $this->db->from("appointment"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('doctor_id',$param1);
            $this->db->where('status !=', 4);
            $this->db->where('status !=', 5);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'patients')
        {
            $this->db->select("*");  
            $this->db->from("patient"); 
            $this->db->where('status !=', 0);
            $this->db->where('category',$param1);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'clients')
        {   
            $this->db->order_by('patient_id', 'desc');
            $this->db->from("patient");
            $this->db->where('client_status', 1); 
             $this->db->where('status',1); 
            return $this->db->count_all_results(); 
        }
        elseif($table == 'patient_history')
        {   
            $this->db->order_by('stabilitation_ref_id', 'desc');
            $this->db->from("stabilitation_ref");
            $this->db->where('patient_id', $param1); 
            return $this->db->count_all_results(); 
        }
        elseif($table == 'stabilitation')
        {   $this->db->order_by('stabilitation_ref_id', 'desc');
            $this->db->select("*");  
            $this->db->from("stabilitation_ref"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }
        elseif($table == 'financial_stabilitation')
        {   $this->db->order_by('stabilitation_ref_id', 'desc');
            $this->db->select("*");  
            $this->db->from("stabilitation_ref"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }
        elseif($table == 'financial')
        {
            $this->db->select("*");  
            $this->db->from("financial"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }
        elseif($table == 'financial_reports')
        {
            $this->db->order_by('financial_id', 'DESC');
            $this->db->from("financial");
            $this->db->where('clinic_id', $this->session->userdata('current_clinic'));
            $this->db->where("str_to_date(date, '%d/%m/%Y') BETWEEN str_to_date('".base64_decode($param1)."', '%d/%m/%Y') AND str_to_date('".base64_decode($param2)."', '%d/%m/%Y')");
            return $this->db->count_all_results(); 
        }
        elseif($table == 'activities')
        {
            $this->db->select("*");  
            $this->db->from("bitacora"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('user_id',$param1);
            $this->db->where('user_type',$param2);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'patient_appointments')
        {
            $this->db->select("*");  
            $this->db->from("appointment"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('patient_id',$param1);
            $this->db->where('status !=', 5);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'inventory')
        {
            $this->db->select("*");  
            $this->db->from("inventory_product"); 
            $this->db->where('inventory_product.inventory_id',$param1);
            $this->db->where('inventory_product.status',1);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'inventory_products')
        {
            $this->db->select("*");  
            $this->db->from("product"); 
            $this->db->where('status',1);
            $this->db->where('type',1);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'categories')
        {
            $this->db->select("*");  
            $this->db->from("category"); 
            $this->db->where('status',1);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'subcategories')
        {
            $this->db->select("*");  
            $this->db->from("subcategory"); 
            $this->db->where('status',1);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'pedidos')
        {
            $this->db->select("*");  
            $this->db->from("pedidos"); 
            $this->db->where('status !=', 0);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'combos')
        {
            $this->db->select("*");  
            $this->db->from("combo"); 
            $this->db->where('status !=', 0);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'sales')
        {
            $date_start = explode('/',$_POST["date_start"]);
            $date1 = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];


            $date_end = explode('/',$_POST["date_end"]);
            $date2 = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];
            $this->db->order_by('sale_id', 'DESC');
            $this->db->from("sale");
            $this->db->where('DATE(datetime) >=',  $date1);
            $this->db->where('DATE(datetime) <=', $date2);
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            $this->db->where('status !=',0);
            return $this->db->count_all_results(); 
        }
        elseif($table == 'cotizaciones')
        {
            $this->db->select("*");  
            $this->db->from("sale"); 
            $this->db->where('status','0');
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }
        elseif($table == 'sales_insurance')
        {
            $this->db->select("*");  
            $this->db->from("sale"); 
            $this->db->where('insurance_id',$param1);
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }

        elseif($table == 'history')
        {
            $this->db->select("*");  
            $this->db->from("history"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }

        elseif($table == 'equipment')
        {
            $this->db->select("*");  
            $this->db->from("equipment"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }

        elseif($table == 'supplies')
        {
            $this->db->select("*");  
            $this->db->from("supplies"); 
            $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
            return $this->db->count_all_results(); 
        }
        //*******************
    }
    
    function GetFilteredData($table,$param1, $param2, $param3)
    {  
        $this->MakeQuery($table,$param1, $param2, $param3);  
        $query = $this->db->get();  
        return $query->num_rows();  
    }
    
    
    function getArrays($table, $fetch_data,$param1, $param2, $param3)
    {
        if($table == 'my_appointments' || $table == 'doctor_appointments')
        {
           return $this->get_appointments($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'patients' )
        {
            return $this->get_patients($table, $fetch_data,$param1, $param2, $param3);
        }

        elseif($table == 'stabilitation' )
        {
            return $this->get_stabilitation($table, $fetch_data,$param1, $param2, $param3);
        }
        elseif($table == 'financial_stabilitation' )
        {
            return $this->get_financial_stabilitation($table, $fetch_data,$param1, $param2, $param3);
        }
        elseif($table == 'patient_history' )
        {
            return $this->get_patient_history($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'clients' )
        {
            return $this->get_clients($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'financial')
        {
            return $this->get_financial($table, $fetch_data,$param1, $param2, $param3);
        }
        elseif($table == 'financial_reports')
        {
            return $this->get_financial_reports($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'activities')
        {
            return $this->get_bitacora($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'patient_appointments')
        {
            return $this->get_patient_apointments($table, $fetch_data,$param1, $param2, $param3);
        }
        
        elseif($table == 'inventory')
        {
            return $this->get_products($table, $fetch_data,$param1, $param2, $param3);
        }

        elseif($table == 'inventory_products')
        {
            return $this->get_products_list($table, $fetch_data,$param1, $param2, $param3);
        }

        elseif($table == 'categories')
        {
            return $this->get_categories($table, $fetch_data,$param1, $param2, $param3);
        }
        elseif($table == 'subcategories')
        {
            return $this->get_subcategories($table, $fetch_data,$param1, $param2, $param3);
        }
        elseif($table == 'pedidos')
        {
            return $this->get_pedidos($table, $fetch_data,$param1, $param2, $param3);
        }
        elseif($table == 'combos')
        {
            return $this->get_combos($table, $fetch_data,$param1, $param2, $param3);
        }
        elseif($table == 'sales')
        {
            return $this->get_sales($table, $fetch_data,$param1, $param2, $param3);
        }
        elseif($table == 'cotizaciones')
        {
            return $this->get_cotizaciones($table, $fetch_data,$param1, $param2, $param3);
        }
        elseif($table == 'sales_insurance')
        {
            return $this->get_sales_insurance($table, $fetch_data,$param1, $param2, $param3);
        }

        elseif($table == 'history')
        {
            return $this->get_history($table, $fetch_data,$param1, $param2, $param3);
        }

        elseif($table == 'equipment')
        {
            return $this->get_equipment($table, $fetch_data,$param1, $param2, $param3);
        }

        elseif($table == 'supplies')
        {
            return $this->get_supplies($table, $fetch_data,$param1, $param2, $param3);
        }

        if($table == 'samples')
        {
           return $this->get_samples($table, $fetch_data,$param1, $param2, $param3);
        }  
        
        if($table == 'patient_service')
        {
           return $this->get_patient_service($table, $fetch_data,$param1, $param2, $param3);
        }  
        
        
        //*******************
    }
    
    
    
    function get_patients($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            $app_pt         = $this->crud_model->date_appointment($row->patient_id);
            $new            = $this->crud_model->num_appointments($row->patient_id);
            $sub_array      = array();  
            
            $sub_array[]    = '<span class="smaller lighter">'.sprintf('%04d', $row->patient_id).'</span>';
            
            $sub_array[]    = '<div class="user-with-avatar">
            <a href="'.base_url().$this->session->userdata('login_type').'/patient_profile/'.base64_encode($row->patient_id).'">
                                <img alt="" src="'.$this->accounts_model->get_photo('patient', $row->patient_id).'">
                                <span>'.$this->accounts_model->get_full_name('patient', $row->patient_id).'</span>
                                </a>
                                </div>';
            if($row->gender =='M')
            {
                $sub_array[]    = '<div class="patient-gender-male">Masculino</div>';    
            }
            else
            {
                $sub_array[]    = '<div class="patient-gender-female">Femenino</div>';
            }
            
            $satatus = '<div class="patient-contact">';
               
            $satatus .= '<a href="tel:+502'.$row->phone.'" class="no-decoration" data-toggle="tooltip" data-placement="top" title="Llamar"><i class="icon-container picons-thin-icon-thin-0289_mobile_phone_call_ringing_nfc"></i></a>';
            $satatus .= '<a href="mailto:'.$row->email.'" class="no-decoration" data-toggle="tooltip" data-placement="top" title="Correo" target="_blank"><i class="icon-container picons-social-icon-gmail"></i></a>';   
              
            
            $satatus .= '</div>';
            
            $sub_array[]    = $satatus;
        
            $sub_array[]    = '<span class="smaller lighter">'.$this->crud_model->formatear2($app_pt).'<span>';      


            if($new < 2)
            {
                $sub_array[] = '<div class="status-pill new" data-title="Nuevo" data-toggle="tooltip" data-original-title="" title="Nuevo"></div>';
            }
            else
            {
                $sub_array[] = '<div class="status-pill frec" data-title="Frecuente" data-toggle="tooltip" data-original-title="" title="Frecuente"></div>';
            }
            
            $sub_array[] = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/patient_profile/'.base64_encode($row->patient_id).'">Perfil</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_patient(\''.$row->patient_id.'\')">Eliminar</a>
                                </div>
                            </div>';
            $data[] = $sub_array;  
        }
        return $data;
    }
    
    
    function get_clients($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            $app_pt         = $this->crud_model->date_appointment($row->patient_id);
            $new            = $this->crud_model->num_appointments($row->patient_id);
            $sub_array      = array();  
            
            $sub_array[]    = '<div class="user-with-avatar">
            <a href="javascript:void(0)">
                                <img alt="" src="'.$this->accounts_model->get_photo('patient', $row->patient_id).'">
                                <span>'.$this->accounts_model->get_name('patient', $row->patient_id).'</span>
                                </a>
                                </div>';
            if($row->gender =='M')
            {
                $sub_array[]    = '<div class="patient-gender-male">Masculino</div>';    
            }
            else
            {
                $sub_array[]    = '<div class="patient-gender-female">Femenino</div>';
            }
            
            $satatus = '<div class="patient-contact">';
               
            $satatus .= '<a href="tel:+502'.$row->phone.'" class="no-decoration" data-toggle="tooltip" data-placement="top" title="Llamar"><i class="icon-container picons-thin-icon-thin-0289_mobile_phone_call_ringing_nfc"></i></a>';
            $satatus .= '<a href="mailto:'.$row->email.'" class="no-decoration" data-toggle="tooltip" data-placement="top" title="Correo" target="_blank"><i class="icon-container picons-social-icon-gmail"></i></a>';   
              
            
            $satatus .= '</div>';
            
            $sub_array[]    = $satatus;
        
            $sub_array[] = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_patient(\''.$row->patient_id.'\')">Eliminar</a>
                                </div>
                            </div>';
            $data[] = $sub_array;  
        }
        return $data;
    }

    function get_stabilitation($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            //$app_pt         = $this->crud_model->date_appointment($row->patient_id);
            //$new            = $this->crud_model->num_appointments($row->patient_id);
            $sub_array      = array();  
            
            $sub_array[]    = '<span class="smaller lighter">'.sprintf('%04d', $row->patient_id).'</span>';
            
            $sub_array[]    = '<div class="user-with-avatar"><a href="'.base_url().$this->session->userdata('login_type').'/stabilitation_details/'.base64_encode($row->stabilitation_ref_id).'">
                                <img alt="" src="'.$this->accounts_model->get_photo('patient', $row->patient_id).'">
                                <span>'.$this->accounts_model->get_name('patient', $row->patient_id).'</span></a>
                                </div>';

            $sub_array[]    = '<span class="smaller lighter">'.$row->date.' '.$row->time.'</span>';

            if($row->status == 0)
            {
                $sub_array[] = '<div class="status-pill new" data-title="Nuevo" data-toggle="tooltip" data-original-title="" title="Nuevo"></div>';
            }
            else
            {
                $sub_array[] = '<div class="status-pill frec " data-title="Frecuente" data-toggle="tooltip" data-original-title="" title="Frecuente"></div>';
            }
            $sub_array[] = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                                </div>
                               
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_patient(\''.$row->stabilitation_ref_id.'\')">Eliminar</a>
                                </div>
                            </div>';
            $data[] = $sub_array;  
        }
        return $data;
    }
    
    function get_financial_stabilitation($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            //$app_pt         = $this->crud_model->date_appointment($row->patient_id);
            //$new            = $this->crud_model->num_appointments($row->patient_id);
            $sub_array      = array();  
            
            $sub_array[]    = '<span class="smaller lighter">'.sprintf('%04d', $row->patient_id).'</span>';
            
            $sub_array[]    = '<div class="user-with-avatar"><a href="'.base_url().$this->session->userdata('login_type').'/stabilitation_financial/'.base64_encode($row->stabilitation_ref_id).'">
                                <img alt="" src="'.$this->accounts_model->get_photo('patient', $row->patient_id).'">
                                <span>'.$this->accounts_model->get_name('patient', $row->patient_id).'</span></a>
                                </div>';

            $sub_array[]    = '<span class="smaller lighter">'.$row->date.' '.$row->time.'</span>';

            if($row->status == 0)
            {
                $sub_array[] = '<div class="status-pill new" data-title="Nuevo" data-toggle="tooltip" data-original-title="" title="Nuevo"></div>';
            }
            else
            {
                $sub_array[] = '<div class="status-pill frec " data-title="Frecuente" data-toggle="tooltip" data-original-title="" title="Frecuente"></div>';
            }
            $sub_array[] = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_patient(\''.$row->stabilitation_ref_id.'\')">Eliminar</a>
                                </div>
                            </div>';
            $data[] = $sub_array;  
        }
        return $data;
    }

    function get_patient_history($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            //$app_pt         = $this->crud_model->date_appointment($row->patient_id);
            //$new            = $this->crud_model->num_appointments($row->patient_id);
            $sub_array      = array();  
            $sub_array[]    = '<a href="'.base_url().$this->session->userdata('login_type').'/appointment_details/'.base64_encode($row->appointment_id).'"><span class="smaller lighter">'.base64_encode($row->appointment_id).'</span></a>';
            $sub_array[]    = '<span class="smaller lighter">'.$row->date.' '.$row->time.'</span>';
            $sub_array[]    = '<span class="smaller lighter">'.$row->total.'</span>';
            $sub_array[] = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_patient(\''.$row->stabilitation_ref_id.'\')">Eliminar</a>
                                </div>
                            </div>';
            $data[] = $sub_array;  
        }
        return $data;
    }
    
    function get_appointments($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = '<a href="'.base_url().$this->session->userdata('login_type').'/appointment_details/'.base64_encode($row->appointment_id).'"><img src="'.$this->accounts_model->get_photo("patient",$row->patient_id).'" width="35px" style="padding-right:6px">'.$this->accounts_model->short_name("patient", $row->patient_id).'</a>';  
                            
                $sub_array[] = $this->accounts_model->gender($row->doctor_id).' '.$this->accounts_model->short_name('admin',$row->doctor_id);
                
                $status = "";
                if($row->time < '12:00')
                {
                    $status = '<span class="shadow-none badge badge-primary">'.$this->crud_model->formatear($row->date).' - '.$row->time.' AM </span>';
                }
                else
                {
                    $status = '<span class="shadow-none badge badge-primary">'.$this->crud_model->formatear($row->date).' - '.$row->time.' PM </span>';
                }
                
                $sub_array[] = $status;
                
                $satatus = "";
                if($row->status == 0)
                {
                    $satatus = '<span class="badge badge-celeste" style="color: #fff;background-color: #5bb3f5;">Pendiente</span>';
                }
                elseif($row->status == 1)
                {
                    $satatus = '<span class="badge badge-verde" style="color: #fff;background-color: #528410;">Confirmada</span>';
                }
                elseif($row->status == 2)
                {
                    $satatus = '<span class="badge badge-rosa" style="color: #fff;background-color: #e0345e;">Cancelada</span>';
                }
                elseif($row->status == 3)
                {
                    $satatus = '<span class="badge badge-marron" style="color: #fff;background-color: #a66767;">Reprogramada</span>';
                }
                
                elseif($row->status == 10)
                {
                    $satatus = '<span class="badge badge-amarillo" style="color: #fff;background-color: #e6b517;">Pendiente de cobro</span>';
                }
                
                $sub_array[] = $satatus;
                $data[] = $sub_array;  
            }
            return $data;
    }
    
    function get_financial($table, $fetch_data,$param1, $param2, $param3)
    {
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            
            $sub_array = array();  
            $sub_array[] = '<a href="'.base_url().'doctor/stabilitation_details/'.base64_encode($row->appointment_id).'" target="_blank" class="" ><div class="text-right">'.sprintf('%04d', $row->financial_id).'</div></a>';
            $sub_array[] = '<span class="smaller lighter">'.$row->date.'</span>';
            $sub_array[] = '<div class="user-with-avatar">
                <i class="finance-icon picons-thin-icon-thin-0383_graph_columns_growth_statistics"></i> <span class="smaller lighter">'.$row->description.'</span>

            </div>';
            $sub_array[] = '<div class="user-with-avatar"><a href="'.base_url().'doctor/patient_profile/'.base64_encode($row->patient_id).'" target="_blank">
                    <span class="smaller lighter">'.$row->patient_name.'</span>

            </div>';
                if($row->type == 1)
                {
                $sub_array[] = '<div class="patient-gender-male">Ingreso</div>';
                }
                else
                {
                $sub_array[] = '<div class="patient-gender-female">Egreso</div>';
                }
                if($row->de == 0)
                {
                $sub_array[] = '<div class="patient-gender-male" style="width:auto !important;padding: 5px;">Encamamientos</div>';
                }else if($row->de == 1)
                {
                $sub_array[] = '<div class="patient-gender-male">Venta</div>';
                }
                else if($row->de == 2)
                {
                $sub_array[] = '<div class="patient-gender-male">Ingreso externo</div>';
                }
                else if($row->de == 3)
                {
                $sub_array[] = '<div class="patient-gender-female">Egreso externo</div>';
                }


            if($param1 != 'report')
            {   
                    $satatus = "";
                    if($row->invoice_file != '')
                    {
                        $satatus = '<a href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_visualizacion/'.$row->financial_id.'/entregas\')"><i class="picons-thin-icon-thin-0096_file_attachment" ></i></a>';
                    }


                    $satatus .= '<a href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_income/'.$row->financial_id.'\');"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
                    <a href="javascript:void(0);" onclick="delete_income(\''.$row->financial_id.'\')"><i class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i></a>';

                    $sub_array[] = $satatus;
                    }

                    if($row->type == 1)
                    {
                    $sub_array[] = '  <div class="text-right" style="white-space: nowrap;"><span class="income"> + '.$currency.'. '.number_format($row->amount,2,'.',',').'</span></div>';
                    }
                    else
                    {
                    $sub_array[] = '<div class="text-right" style="white-space: nowrap;"><span class="expense"> - '.$currency.'. '.number_format($row->amount,2,'.',',').'</span></div>';
                    }
                    $data[] = $sub_array;
                    }

                    return $data;
        }


        function get_financial_reports($table, $fetch_data,$param1, $param2, $param3)
        {
            $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
            $data = array();  
            foreach($fetch_data as $row)  
            {  
                
                $sub_array = array();  
                $sub_array[] = '<a href="'.base_url().'doctor/stabilitation_details/'.base64_encode($row->appointment_id).'" target="_blank" class="" ><div class="text-right">'.sprintf('%04d', $row->financial_id).'</div></a>';
                $sub_array[] = '<span class="smaller lighter">'.$row->date.'</span>';
                $sub_array[] = '<div class="user-with-avatar">
                    <i class="finance-icon picons-thin-icon-thin-0383_graph_columns_growth_statistics"></i> <span class="smaller lighter">'.$row->description.'</span>
    
                </div>';
                $sub_array[] = '<div class="user-with-avatar"><a href="'.base_url().'doctor/patient_profile/'.base64_encode($row->patient_id).'" target="_blank">
                        <span class="smaller lighter">'.$row->patient_name.'</span>
    
                </div>';
                    if($row->type == 1)
                    {
                    $sub_array[] = '<div class="patient-gender-male">Ingreso</div>';
                    }
                    else
                    {
                    $sub_array[] = '<div class="patient-gender-female">Egreso</div>';
                    }
                    
                    if($row->de == 0)
                    {
                    $sub_array[] = '<div class="patient-gender-male" style="width:auto !important;padding: 5px;">Encamamientos</div>';
                    }else if($row->de == 1)
                    {
                    $sub_array[] = '<div class="patient-gender-male">Venta</div>';
                    }
                    else if($row->de == 2)
                    {
                    $sub_array[] = '<div class="patient-gender-male">Ingreso externo</div>';
                    }
                    else if($row->de == 3)
                    {
                    $sub_array[] = '<div class="patient-gender-female">Egreso externo</div>';
                    }
    
    
                        if($row->type == 1)
                        {
                            $sub_array[] = '  <div class="text-right" style="white-space: nowrap;"><span class="income"> + Q. '.number_format($row->amount,2,'.',',').'</span></div>';
                        }
                        else
                        {
                            $sub_array[] = '<div class="text-right" style="white-space: nowrap;"><span class="expense"> - Q. '.number_format($row->amount,2,'.',',').'</span></div>';
                        }
                        
                        $data[] = $sub_array;
                        }
    
                        return $data;
            }

    function get_bitacora($table, $fetch_data,$param1, $param2, $param3)
    {
                    $data = array();
                    foreach($fetch_data as $row)
                    {
                    $sub_array = array();
                    $sub_array[] = '<div style="font-family:\'Poppins\';font-size:14px;font-weight:bold;color:#4b4a55" class="">'.$row->message.'</div>';
                    $sub_array[] = '<div class="text-right"><span class="smaller lighter">'.$row->date.'</span></div>';
                    $data[] = $sub_array;
                    }


            return $data;
    }


    

function get_patient_apointments($table, $fetch_data,$param1, $param2, $param3)
{
        $data = array();
        $n = 1;
        foreach($fetch_data as $row)
        {
        $sub_array = array();
        $sub_array[] = $n++;
        
        
        if($row->observations !=  ''){
        $sub_array[] = '<a href="'.base_url().$this->session->userdata('login_type').'/appointment_details/'.base64_encode($row->appointment_id).'">
            <img src="'.$this->accounts_model->get_photo('patient', $row->patient_id).'" width="35px" style="padding-right:6px">
            '.$this->accounts_model->short_name('patient', $row->patient_id).'</a>';
        }else
        {
        $sub_array[] = ' <img src="'.$this->accounts_model->get_photo('patient', $row->patient_id).'" width="35px" style="padding-right:6px">
            '.$this->accounts_model->short_name('patient', $row->patient_id);
            
        }

        $sub_array[] = $this->accounts_model->gender($row->doctor_id).' '.$this->accounts_model->short_name('admin',$row->doctor_id);
        $satatus = '<div class="precio-ingreso" style="white-space: nowrap">'.$this->crud_model->formatear($row->date).' - '.$row->time.' ';
        if($row->time < '12:00' ) { $satatus .=' AM </div>' ; } else { $satatus .=' PM </div>' ; } $sub_array[]=$satatus; if($row->status == '0')
        {
        $sub_array[] = '<span class="badge badge-celeste" style="color: #fff;background-color: #5bb3f5;">Pendiente</span>';
        }
        elseif($row->status == '1')
        {
        $sub_array[] = '<span class="badge badge-verde" style="color: #fff;background-color: #528410 ;">Confirmada</span>';
        }
        elseif($row->status == '2')
        {
            $sub_array[] = '<span class="badge badge-rosa" style="color: #fff;background-color: #e0345e;">Cancelada</span>';
        }
        elseif($row->status == '3')
        {
            $sub_array[] = '<span class="badge badge-marron" style="color: #fff;background-color: #a66767;">Reprogramada</span>';
        }
        elseif($row->status == '10' && $this->session->userdata('login_type') == 'admin')
        {
            $sub_array[] = '<span class="badge badge-amarillo" style="color: #fff;background-color: #e6b517;">Pendiente de cobro</span>';
            
        }else
        {
            $sub_array[] = '<span class="badge badge-azul" style="color: #fff;background-color: #0044e9;">Finalizada</span>';
        }

        $data[] = $sub_array;
        }

        return $data;
        }

        function get_products($table, $fetch_data,$param1, $param2, $param3)
        {
            $data = array();
            $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
            $cnt=0;

            foreach($fetch_data as $row)
            {
                $row2 = $this->db->get_where('product',array('product_id'=>$row->product_id));
                    if($row2->num_rows() > 0)
                    {
                    $row2 = $row2->row();
                
                    $sub_array = array();
                    $cnt++;

                    if($row2->type == 1) 
                    $type = '<span class="income">Producto</span>';
                    elseif($row2->type == 2)
                    $type ='<span class="expense">Servicio</span>';
                    elseif($row2->type == 3)
                    $type ='<span class="expense">Laboratorio</span>';

                    $sub_array[] = $type;
                    $sub_array[] = '<span class="smaller lighter">'.$row2->code.'</span>';
                    
                    
                    $sub_array[] = '<span class="smaller lighter">'.$this->db->get_where('category',array('id'=>$row2->category_id))->row()->name.'</span>';
                    $sub_array[] = '<div style="display: flex;"><img style="max-width:45px" alt="" src="'.$this->inventory_model->getProductImage($row2->product_id).'"><span class="smaller lighter">'.$row2->name.'</span></div>';
                    
                    if($row2->principal_unity)
                    $presentacion = $this->db->get_where('unity',array('code'=>$row2->principal_unity))->row()->name;
                    else
                    $presentacion = '';
                    
                    if($row2->provider)
                    $provider = $this->accounts_model->get_name_provider('staff', $row2->provider);
                    else
                    $provider = '';
                    
                    
                    $sub_array[] = '<span class="smaller lighter">'.$presentacion.'</span>';
                    $sub_array[] = '<span class="smaller lighter">'.$provider.'</span>';
                    $sub_array[] = '<span class="smaller lighter">'.$currency.'. '.number_format($row2->cost, 2, '.', ',').'</span>';
                    $sub_array[] = '<a href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_prices/'.$row2->product_id.'\');" ><span class="smaller lighter">'.$currency.'. '.number_format($this->db->get_where('product_price',array('product_id'=>$row2->product_id,'insurance_id'=>0))->row()->price, 2, '.', ',').'</span></a>';
                    $stock = '';
                    $cantidad = $this->inventory_model->get_stock($row2->product_id);
                    if($row2->principal_unity != '')
                    $unity = $this->db->get_where('unity',array('code'=>$row2->principal_unity))->row()->name;
                    
                if($row2->type == 1)
                {
                    if($cantidad > $row2->amount_alert)
                    {
                        $stock .= '<span class="status-pill green" data-toggle="tooltip" data-placement="top" title="Producto disponible"></span>';
                    }
                    if($cantidad <= $row2->amount_alert && $cantidad > 0 )
                    {
                        $stock .= '<span class="status-pill yellow" data-toggle="tooltip" data-placement="top" title="Producto en alerta"></span>';
                    }

                    if($cantidad <= 0) { $stock .='<span class="status-pill red" data-toggle="tooltip" data-placement="top" title="Producto agotado"></span>' ; } $stock .='<span class="smaller lighter">' .$cantidad.' '.$unity.'</span>';
                }   
                    $sub_array[] = $stock;
                    $actions = '<div class="dropdown">
                        <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';

                        if($row2->type == 1)
                        {

                            $actions .= '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_edit_product/'.$row2->product_id.'\');">Editar</a>';
                            $actions .= '<a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/kardex/'.$row2->product_id.'">Kardex</a>';
                            
                        }
                        elseif($row2->type == 2)
                        {

                            $actions .= '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_edit_service/'.$row2->product_id.'\');">Editar</a>';
                            $actions .= '<a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/kardex/'.$row2->product_id.'">Movimientos</a>';
                            $actions .= '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_service_imp/'.$row2->product_id.'\');">Implementos</a>';
                        }
                        elseif($row2->type == 3)
                        {

                            $actions .= '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_edit_service/'.$row2->product_id.'\');">Editar</a>';
                            $actions .= '<a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/kardex/'.$row2->product_id.'">Ordenes</a>';
                            $actions .= '<a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/laboratory_template/'.$row2->product_id.'" >Exámenes</a>';
                            $actions .= '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_service_imp/'.$row2->product_id.'\');">Implementos</a>';
                        }

                                $actions .= '<a class="dropdown-item" href="javascript:void(0);" onclick="delete_inventory(\''.$row->inventory_product_id.'\')">Eliminar</a>
                                </div>
                            </div>';
                            $sub_array[] = $actions;
                            $data[] = $sub_array;
                            }
                        }
                    return $data;
        }


        function get_products_list($table, $fetch_data,$param1, $param2, $param3)
        {
            $data = array();
            $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
            $cnt=0;

            foreach($fetch_data as $row)
            {
                $sub_array = array();
                    $sub_array[] = '<span class="smaller lighter">'.$row->code.'</span>';
                    $sub_array[] = '<div style="display: flex;"><img style="max-width:45px" alt="" src="'.$this->inventory_model->getProductImage($row->product_id).'"><span class="smaller lighter">'.$row->name.'</span></div>';
                    
                    $presentacion = $this->db->get_where('unity',array('code'=>$row->principal_unity))->row()->name;
                
                    $sub_array[] = '<span class="smaller lighter">'.$presentacion.'</span>';
                   
                    $stock = '';
                    $cantidad = $this->inventory_model->get_stock($row->product_id);
                    if($row->principal_unity != '')
                    $unity = $this->db->get_where('unity',array('code'=>$row->principal_unity))->row()->name;
                    
                    if($row->type == 1)
                    {
                        if($cantidad > $row->amount_alert)
                        {
                            $stock .= '<span class="status-pill green" data-toggle="tooltip" data-placement="top" title="Producto disponible"></span>';
                        }
                        if($cantidad <= $row->amount_alert && $cantidad > 0 )
                        {
                            $stock .= '<span class="status-pill yellow" data-toggle="tooltip" data-placement="top" title="Producto en alerta"></span>';
                        }

                        if($cantidad <= 0) { $stock .='<span class="status-pill red" data-toggle="tooltip" data-placement="top" title="Producto agotado"></span>' ; } $stock .='<span class="smaller lighter">' .$cantidad.' '.$unity.'</span>';
                    }   

                    $sub_array[] = $stock;
                    $data[] = $sub_array;
                }
                    return $data;
        }


function get_categories($table, $fetch_data,$param1, $param2, $param3)
{
    $data = array();
    $n = 1;
    foreach($fetch_data as $row)
    {
        $consulta = $this->db->get_where('product', array('category_id' => $row->id))->num_rows();
    $sub_array = array();
    $sub_array[] = $n++;
    $sub_array[] = '<span class="smaller lighter">'.$row->name.'</span>';
    $sub_array[] = '<span class="smaller lighter">'.$row->description.'</span>';
    $sub_array[] = '<span class="badge badge-primary">'.$consulta.'</span>';

    $acciones = '<div class="dropdown">
        <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          ';
            
     if(  $row->id != 15 && $row->id != 5 && $row->id != 4)
    {
        $acciones .= '  <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_category/'.$row->id.'\');">Editar</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_category(\''.$row->id.'\')">Eliminar</a>';
        
    }
    
    
    $acciones .='</div>
    </div>';
    
    $sub_array[] = $acciones;
    $data[] = $sub_array;
    }

    return $data;
}

function get_subcategories($table, $fetch_data,$param1, $param2, $param3)
{
    $data = array();
    $n = 1;
    foreach($fetch_data as $row)
    {
    $consulta = $this->db->get_where('product', array('subcategory_id' => $row->id))->num_rows();
    $sub_array = array();
    $sub_array[] = $n++;
    $sub_array[] = '<span class="smaller lighter">'.$this->db->get_where('category', array('id' => $row->category_id))->row()->name.'</span>';
    $sub_array[] = '<span class="smaller lighter">'.$row->name.'</span>';
    $sub_array[] = '<span class="smaller lighter">'.$row->description.'</span>';
    $sub_array[] = '<span class="badge badge-primary">'.$consulta.'</span>';

    $acciones = '<div class="dropdown">
        <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_subcategory/'.$row->id.'\');">Editar</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_subcategory(\''.$row->id.'\')">Eliminar</a>';
            
         
       
       $acciones .=' </div>
    </div>';
    
    $sub_array[] = $acciones;
    $data[] = $sub_array;
    }

    return $data;
}


function get_pedidos($table, $fetch_data,$param1, $param2, $param3)
{
    $data = array();
    $n = 1;
    foreach($fetch_data as $row)
    {
        
    $sub_array = array();
    $sub_array[] = $row->code;
    $sub_array[] = '<a href="'.base_url().'"><span class="smaller lighter">'.$row->date.'</a></span>';
    $sub_array[] = '<span class="smaller lighter">'.$this->db->get_where('provider',array('provider_id'=>$row->provider_id))->row()->name.'</span>';
    $sub_array[] = '<span class="smaller lighter">Q'.number_format($row->total,2,'.',',').'</span>';
    if($row->status == 1)
    {
        $sub_array[] = '<div class="status-pill frec" ></div><span>Confirmada</span>';
    }else if($row->status == 2)
    {
        $sub_array[] = '<div class="status-pill danger" ></div><span>Cancelada</span>';
    }
    else if($row->status == 0)
    {
        $sub_array[] = '<div class="status-pill new" ></div><span>Pendiente</span>';
    }
    $options = '<div class="dropdown">
        <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item"  target="_blank" href="'.base_url().$this->session->userdata('login_type').'/print_solicitud/'.$row->pedidos_id.'">Imprimir</a>';
    if($row->status == 0){

        
               $options .=  '<a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/edit_purchase/'.base64_encode($row->pedidos_id).'" >Editar</a>
                    <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/confirm_purchase/'.base64_encode($row->pedidos_id).'" >Confirmar orden</a>';

    }
            $options .= '<a class="dropdown-item" href="javascript:void(0);" onclick="deletePedido(\''.$row->pedidos_id.'\')">Eliminar</a>
        </div>
    </div>';
    $sub_array[] = $options;
    $data[] = $sub_array;
    }

    return $data;
}

function get_combos($table, $fetch_data,$param1, $param2, $param3)
{
    $data = array();
    $n = 1;
    foreach($fetch_data as $row)
    {
        
    $sub_array = array();
    $sub_array[] = '<a href="'.base_url().'"><span class="smaller lighter">'.$row->code.'</a></span>';
    $sub_array[] = '<a href="'.base_url().'"><span class="smaller lighter">'.$row->name.'</a></span>';
    $sub_array[] = '<a href="'.base_url().'"><span class="smaller lighter">'.$row->costo.'</a></span>';
    $sub_array[] = '<a href="'.base_url().'"><span class="smaller lighter">'.$row->price_1.'</a></span>';
    $sub_array[] = '<a href="'.base_url().'"><span class="smaller lighter">'.$row->price_2.'</a></span>';
    $sub_array[] = '<a href="'.base_url().'"><span class="smaller lighter">'.$row->price_3.'</a></span>';
   
    $options = '<div class="dropdown">
        <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item"  target="_blank" href="'.base_url().$this->session->userdata('login_type').'/print_solicitud/'.$row->pedidos_id.'">Imprimir</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_update_solicitud/'.$row->pedidos_id.'\');">Editar</a>';
            if($row->status = 1)
            {
                $options .= '<a class="dropdown-item" href="javascript:void(0);" onclick="setPedidos(\''.$row->pedidos_id.'\')">Listo</a>';
            }
            $options .= '<a class="dropdown-item" href="javascript:void(0);" onclick="deletePedido(\''.$row->pedidos_id.'\')">Eliminar</a>
        </div>
    </div>';
    $sub_array[] = $options;
    $data[] = $sub_array;
    }

    return $data;
}

function get_laboratory($table, $fetch_data,$param1, $param2, $param3)
{
$data = array();
$n = 1;
foreach($fetch_data as $row)
{

$sub_array = array();
$sub_array[] = $n++;
$sub_array[] = '<span class="smaller lighter">'.$row->name.'</span>';
$sub_array[] = '<span class="smaller lighter">'.$row->price_day.'</span>';
$sub_array[] = '<span class="smaller lighter">'.$row->price_night.'</span>';
$sub_array[] = '<div class="dropdown">
    <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
    </div>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_laboratory/'.$row->laboratory_id.'\');">Editar</a>
        <a class="dropdown-item" href="javascript:void(0);" onclick="delete(\''.$row->laboratory_id.'\')">Eliminar</a>
    </div>
</div>';
$data[] = $sub_array;
}

return $data;
}


function get_rayos_x($table, $fetch_data,$param1, $param2, $param3)
{
$data = array();
$n = 1;
foreach($fetch_data as $row)
{

$sub_array = array();
$sub_array[] = $n++;
$sub_array[] = '<span class="smaller lighter">'.$row->name.'</span>';
$sub_array[] = '<span class="smaller lighter">'.$row->price_day.'</span>';
$sub_array[] = '<span class="smaller lighter">'.$row->price_night.'</span>';
$sub_array[] = '<div class="dropdown">
    <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
    </div>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_laboratory/'.$row->laboratory_id.'\');">Editar</a>
        <a class="dropdown-item" href="javascript:void(0);" onclick="delete(\''.$row->laboratory_id.'\')">Eliminar</a>
    </div>
</div>';
$data[] = $sub_array;
}

return $data;
}

function get_product_estb($table, $fetch_data,$param1, $param2, $param3)
{
$data = array();
$n = 1;
foreach($fetch_data as $row)
{

$sub_array = array();
$sub_array[] = $n++;
$sub_array[] = '<span class="smaller lighter">'.$row->name.'</span>';
$sub_array[] = '<span class="smaller lighter">'.$row->price_day.'</span>';
$sub_array[] = '<span class="smaller lighter">'.$row->price_night.'</span>';
$sub_array[] = '<div class="dropdown">
    <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
    </div>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/modal_laboratory/'.$row->laboratory_id.'\');">Editar</a>
        <a class="dropdown-item" href="javascript:void(0);" onclick="delete(\''.$row->laboratory_id.'\')">Eliminar</a>
    </div>
</div>';
$data[] = $sub_array;
}

return $data;
}


function get_sales($table, $fetch_data,$param1, $param2, $param3)
{
    $data = array();
    $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
    $n = 1;
    foreach($fetch_data as $row)
    {
        $sub_array = array();
        $sub_array[] = '<span class="smaller lighter">'.'CRT-'.$n++.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->date.'</span>';
        $sub_array[] = '<div class="user-with-avatar">
        <span class="smaller lighter">'.$row->name.'</span>
        </div>';
        $sub_array[] = '<div class="user-with-avatar">
        <img alt="" src="'.$this->accounts_model->get_photo($row->user_type,$row->user_id).'"><span class="smaller lighter">'.$this->accounts_model->short_name($row->user_type,$row->user_id).'</span>
        </div>';

        $status = '';
            if($row->method == 1){
            $status .= '<span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;"> Efectivo </span>';
            }
            elseif($row->method == 3)
            {
                $status .= '<span style="color:#5bb3f5;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">';
                if($row->type_transfer == 'T'){
                    $status .= 'Transferencia';
                    }
                    elseif($row->type_transfer == 'T')
                    {
                    $status.= 'Depósito';
                    }
                    elseif($row->type_transfer == 'C')
                    {
                    $status.= 'Cheque';
                    }
                    elseif($row->type_transfer == 'Tr')
                    {
                    $status.= 'Tarjeta';
                    }

                    $status.= '</span>';
            }elseif($row->method == 4){
                $status .= '<span style="color:#c21a1a;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Crédito</span>';
                }
                elseif($row->method == 5)
                {
                    $status.= '<span style="color:#5bb3f5;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Mixto</span>';
                } 
            elseif($row->method == 0 | $row->method == "")
            {
                $status.= 'n/d';
            }

            $sub_array[] = $status;


            $sub_array[] = '<span class="smaller lighter">'.$currency.'. '.number_format($row->total,'2','.',',').'</span>';
            
          
            if($row->status == 0 || $row->status == 3){
                $status = '<span style="color:#5bb3f5;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Pendiente</span>';
            }
            elseif($row->status == 1)
            {
                $status = '<span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Completado</span>';
            }elseif($row->status == 2){
                $status = '<span style="color:#c21a1a;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Anulada</span>';
                }

           
            $sub_array[] = $status;
            $actions = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#00a0ff;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                if($row->status == 3)
                $actions .=' <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/notasdca/'.base64_encode($row->sale_id).'">Nueva nota</a>';
               
               
               $actions .='         <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/sale_details/'.base64_encode($row->sale_id).'">Detalles</a>';
                 if($row->invoice == '')
                                      $actions .='    <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/sales/emit_invoice/'.base64_encode($row->sale_id).'">Emitir factura</a>';


                                       $actions .='  
                                </div>
                            </div>';

                $sub_array[] = $actions;
            $data[] = $sub_array;
        }

    return $data;
}

function get_cotizaciones($table, $fetch_data,$param1, $param2, $param3)
{
    $data = array();
    $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
    $n = 1;
    foreach($fetch_data as $row)
    {
        $sub_array = array();
        $sub_array[] = '<span class="smaller lighter">'.'CRT-'.$n++.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->date.'</span>';
        $sub_array[] = '<div class="user-with-avatar">
        <span class="smaller lighter">'.$row->name.'</span>
        </div>';
        $sub_array[] = '<div class="user-with-avatar">
        <img alt="" src="'.$this->accounts_model->get_photo($row->user_type,$row->user_id).'"><span class="smaller lighter">'.$this->accounts_model->short_name($row->user_type,$row->user_id).'</span>
        </div>';

        $status = '';
            if($row->method == 1){
            $status .= '<span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;"> Efectivo </span>';
            }
            elseif($row->method == 3)
            {
                $status .= '<span style="color:#5bb3f5;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">';
                if($row->type_transfer == 'T'){
                    $status .= 'Transferencia';
                    }
                    elseif($row->type_transfer == 'T')
                    {
                    $status.= 'Depósito';
                    }
                    elseif($row->type_transfer == 'C')
                    {
                    $status.= 'Cheque';
                    }
                    elseif($row->type_transfer == 'Tr')
                    {
                    $status.= 'Tarjeta';
                    }

                    $status.= '</span>';
            }elseif($row->method == 4){
                $status .= '<span style="color:#c21a1a;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Crédito</span>';
                }
                elseif($row->method == 5)
                {
                    $status.= '<span style="color:#5bb3f5;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Mixto</span>';
                } 
            elseif($row->method == 0 | $row->method == "")
            {
                $status.= 'n/d';
            }

            $sub_array[] = $status;


            $sub_array[] = '<span class="smaller lighter">'.$currency.'. '.number_format($row->total,'2','.',',').'</span>';
            
          
            if($row->status == 0 || $row->status == 3){
                $status = '<span style="color:#5bb3f5;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Pendiente</span>';
            }
            elseif($row->status == 1)
            {
                $status = '<span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Completado</span>';
            }elseif($row->status == 2){
                $status = '<span style="color:#c21a1a;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Anulada</span>';
                }

           
            $sub_array[] = $status;
            $actions = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#00a0ff;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                if($row->status == 3)
                $actions .=' <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/notasdca/'.base64_encode($row->sale_id).'">Nueva nota</a>';
               $actions .='     <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/sale_details/'.base64_encode($row->sale_id).'">Detalles</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_sale(\''.base64_encode($row->sale_id).'\')">Anular</a>
                                </div>
                            </div>';

                $sub_array[] = $actions;
            $data[] = $sub_array;
        }

    return $data;
}

function get_sales_insurance($table, $fetch_data,$param1, $param2, $param3)
{
    $data = array();
    $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
    $n = 1;
    foreach($fetch_data as $row)
    {
        $sub_array = array();
        $sub_array[] = '<span class="smaller lighter">'.'CRT-'.$n++.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->date.'</span>';
        $sub_array[] = '<div class="user-with-avatar">
                            <span class="smaller lighter">'.$row->name.'</span>
                        </div>';
        $sub_array[] = '<span class="smaller lighter">'.$row->titular.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->dpi_titular.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->move_economy.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->record.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$currency.'. '.number_format($row->total_insurance,'2','.',',').'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->service.'</span>'; 
          
        if($row->invoice_insurance == ''){
            $status = '<span style="color:#5bb3f5;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Pendiente</span>';
        }
        elseif($row->invoice_insurance != '' && $row->invoice_insurance != 0)
        {
            $status = '<span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Completado</span>';
        }elseif($row->invoice_insurance == -1)
        {
            $status = '<span style="color:#c21a1a;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">Anulada</span>';
        }

           
            $sub_array[] = $status;
            $actions = '<div class="dropdown">
                                <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="batch-icon-ellipsis" style="color:#00a0ff;font-size: 20px;"></i>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                if($row->status == 3)
                $actions .=' <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/notasdca/'.base64_encode($row->sale_id).'">Nueva nota</a>';
               $actions .='     <a class="dropdown-item" href="'.base_url().$this->session->userdata('login_type').'/sale_details/'.base64_encode($row->sale_id).'">Detalles</a>
                                </div>
                            </div>';

                $sub_array[] = $actions;
            $data[] = $sub_array;
        }

    return $data;
}

function get_history($table, $fetch_data,$param1, $param2, $param3)
{
        $data = array();
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $n = 1;
        foreach($fetch_data as $row)
        {
        $producto = $this->db->get_where('product',array('product_id'=>$row->producto_id))->row() ;
        $sub_array = array();
        $sub_array[] = '<span class="smaller lighter">'.'CRT-'.$n++.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->date.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->expiration.'</span>';
        $sub_array[] = '<span class="smaller lighter"> Paciente </span>';
        $sub_array[] = '<span class="smaller lighter"> expediente </span>';
        $sub_array[] = '<span class="smaller lighter">'.$producto->provider.'</span>';
        $sub_array[] = '<span class="smaller lighter"> No. factura </span>';

        if($row->status_mov == 1){
        $status = '<span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">';
            $status .= 'Entrada';
            }
            elseif($row->status_mov == 2)
            {
            $status = '<span style="color:red;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">';
                $status .= 'Salida';
                }
                $status.= '</span>';
            $sub_array[] = $status;

            $sub_array[] = '<span class="smaller lighter">'.$producto->stock.'</span>';
            $sub_array[] = '<span class="smaller lighter">'.$row->obs.'</span>';

            $data[] = $sub_array;
        }

        return $data;
}

    function get_equipment($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $n = 1;
            foreach($fetch_data as $row)
            {
                $producto = $this->db->get_where('product',array('product_id'=>$row->producto_id))->row() ;
                $sub_array = array();
                $sub_array[] = '<span class="smaller lighter">'.'CRT-'.$n++.'</span>';
                $sub_array[] = '<span class="smaller lighter">'.$row->name.' </span>';
                $sub_array[] = '<span class="smaller lighter">'.$row->marca.'</span>';
                $sub_array[] = '<span class="smaller lighter">'.$row->modelo.' modelo </span>';
                $sub_array[] = '<span class="smaller lighter">'.$row->location.' </span>';
                $sub_array[] = '<span class="smaller lighter">'.$row->description.'</span>';
                $sub_array[] = '<div class="dropdown">
                    <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
                    </div>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/equipment_edit/'.$row->equipment_id.'\');">Editar</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_equipment(\''.$row->equipment_id.'\')">Eliminar</a>
                    </div>
                </div>';

                $data[] = $sub_array;
            }

        return $data;
    }

    function get_supplies($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();
        $currency = $this->db->get_where('supplies', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
        $n = 1;
        foreach($fetch_data as $row)
        {
        $producto = $this->db->get_where('product',array('product_id'=>$row->producto_id))->row() ;
        $sub_array = array();
        $sub_array[] = '<span class="smaller lighter">'.'CRT-'.$n++.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->name.' </span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->location.' </span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->description.'</span>';
        $sub_array[] = '<span class="smaller lighter">'.$row->cantidad.'</span>';
        $sub_array[] = '<div class="dropdown">
            <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
            </div>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg(\''.base_url().'modal/popup/supplies_edit/'.$row->supplies_id.'\');">Editar</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="delete_supplies(\''.$row->supplies_id.'\')">Eliminar</a>
            </div>
        </div>';

        $data[] = $sub_array;
        }

        return $data;
    }

    function get_samples($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        foreach($fetch_data as $sp)  
        {  
            $sub_array = array();  
           
            $user_type = $sp->user_type;

            if($user_type == 'staff')
            {
                $user_type = 'user';
            }else {
                $user_type = 'admin';
            }
            $statuss = $sp->tracing_status;

            if($sp->status_delivery == 0)
            {
                if($sp->status==0)
                {
                    $buttonColor = 'success';
                }elseif($sp->status==1)
                {
                    $buttonColor =  'warning';
                }
                
             }else{
                $buttonColor = 'info';
             }

             if($sp->status_delivery == 0)
             {
                if($sp->status==0)
                {
                   $text = 'En proceso';
                   
                }elseif($sp->status==1)
                {
                    $text = 'Finalizada';
                }
            }else
            {
                $text ='Entregada';


            }
                if($sp->status_priority == 1 ) {
                    $prioridad = 'normal';
                    $btnPrioridad='success ';
                }elseif($sp->status_priority == 2) {
                    $prioridad = 'prioridad ';
                    $btnPrioridad='warning ';
                }elseif($sp->status_priority == 3) {
                    $prioridad = 'Urgencia 4 días';
                    $btnPrioridad='danger ripple ';
                }elseif($sp->status_priority == 4 ) {
                    $prioridad = 'Urgencia';
                    $btnPrioridad='danger ripple';
                }

            $td2 ='  <a style="white-space: nowrap;" onclick="showAjaxModal(\''.base_url().'modal/popup/modal_sample_details/'.$sp->sample_id.'\')" class="btn btn-'.$buttonColor.'">'.$text.'</a>';
            $td3 = '<span style="white-space: nowrap;">'.$sp->date.'<b>/</b>'.$sp->time.'</span>';
            $td4 = '<a style="white-space: nowrap;font-weight: bolder;" href="javascript:void(0);" onclick="showAjaxModal(\''.base_url().'modal/popup/modal_sample_details/'.$sp->sample_id.'\')" >'.$sp->code.'</a>';
            $td5 = '<div class="user-with-avatar">
            <a href="'.base_url().$this->session->userdata('login_type').'/patient_profile/'.base64_encode($sp->patient_id).'">
                                <img alt="" src="'.$this->accounts_model->get_photo('patient', $sp->patient_id).'">
                                <span>'.$this->accounts_model->get_name('patient', $sp->patient_id).'</span>
                                </a>
                                </div>';
            $td6 = '<span style="white-space: nowrap;">'.$sp->study.'</span>';

            if($sp->doctors_id != 0)
            {
                $td7 = '<b style="white-space: nowrap;">'.$this->accounts_model->get_name('admin', $sp->doctors_id).'</b>';
            }else
            {
                $td7 = '<b style="white-space: nowrap;">'.$sp->doctor_name.'</b>';
            }
            $td8 ='<span>Q.'.number_format($sp->total,2,'.',',').'</span>';


            $acciones = '<center>
            <div class="dropdown custom-dropdown">
                <a onclick="showAjaxModal(\''.base_url().'modal/popup/modal_sample_details/'.$sp->sample_id.'\')" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg></a>
            </div>  
            </center>';
                    
            $sub_array[] = $td2;  
            $sub_array[] = $td3;
            $sub_array[] = $td4;  
            $sub_array[] = $td5;  
            $sub_array[] = $td6;
            $sub_array[] = $td7;  
            $sub_array[] = $td8;  
            $sub_array[] = $acciones;    
            
            $data[] = $sub_array;  
        }  
        return $data;
    }
    
    
     function get_patient_service($table, $fetch_data,$param1, $param2, $param3)
    {
        $data = array();  
        foreach($fetch_data as $sp)  
        {  
            
                $sub_array = array();  
          
                $td1 = $sp->code;
                $td2 = ' <img src="'.$this->accounts_model->get_photo( 'admin', $sp->doctor_id).'" width="35px" style="padding-right:6px">
                '.$this->accounts_model->gender($sp->doctor_id).' '.$this->accounts_model->short_name( 'admin', $sp->doctor_id);
                
                $td3 = $this->db->get_where('product',array('product_id'=>$sp->product_id))->row()->name;
                $td4 = $sp->date;
                
                
                if($sp->status == 0):
                    $td5 = '<span class="text-info"><b>Pendiente</b></span>';
                endif; 
                
                if($sp->status == 1):
                    $td5 = '<span class="text-warning"><b>Pagada</b></span>';
                endif; 
                
                if($sp->status == 2):
                    $td5 = '<span class="text-success"><b>Informe subido</b></span>';
                endif; 
                
                if($sp->status == 4):
                   $td5 = '<span class="text-danger"><b>Anulada</b></span>';
                endif; 
                
                if($sp->status == 1 || $sp->status == 2):
                    $td6 = '<a onclick="showAjaxModal(\''.base_url().'modal/popup/modal_patient_service_details/'.$sp->patient_service_id.'\')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg></a>';
                 endif;
               
          
            $sub_array[] = $td1;          
            $sub_array[] = $td2;  
            $sub_array[] = $td3;
            $sub_array[] = $td4;  
            $sub_array[] = $td5;  
            $sub_array[] = $td6;
           
            
            $data[] = $sub_array;  
        }  
        return $data;
    }

    }