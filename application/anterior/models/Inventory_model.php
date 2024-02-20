<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventory_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
    

    function create_product()
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['image']['name']);
        if($_FILES['image']['name'] != ''){
            
            $archivo    = $this->db->get_where('product', array('product_id' => $product_id))->row()->img;
            unlink('public/uploads/inventory/'.$archivo);
            move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
        }


        if($this->input->post('product_type') == '1')
        {
            $data = array(
                'category_id' => $this->input->post('category_id'),
                'subcategory_id' => $this->input->post('subcategory_id'),
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'provider' => $this->input->post('provider_id'),
                'amount_alert' => $this->input->post('alert'),
                'image' => $this->input->post('image'),
                'stock' => $this->input->post('amount2'),
                'principal_unity' => $this->input->post('unity2'),
                'cost' => $this->input->post('cost'),
                'u_amount' => $this->input->post('u_amount'),
                'unity' => $this->input->post('unity'),
                'p_amount' => $this->input->post('p_amount'),
                'presentation' => $this->input->post('presentation'),
                'pa_amount' => $this->input->post('pa_amount'),
                'packaging' => $this->input->post('packaging'),
                'price_1' => $this->input->post('price_1'),
                'price_2' => $this->input->post('price_2'),
                'price_3' => $this->input->post('price_3'),
                'points' => $this->input->post('points'),
                'inventory_id' => $this->input->post('inventory_id'),
                'image' =>  $name,
                'type' => 1,
                'status' => 1
             );
    
             $this->db->insert('product',$data);
             $product_id = $this->db->insert_id();
             
             
            $prices = $this->input->post('price');
            $insurances = $this->input->post('insurance_id');
             
            foreach($insurances as $i=>$insurance_id)
            {
                $exist = $this->db->get_where('product_price',array('product_id'=>$product_id,'insurance_id'=>$insurance_id))->num_rows();
                if($exist > 0)
                {
                    $datapp['price'] = $prices[$i];
                    
                    $this->db->where('product_id',$product_id);
                    $this->db->where('insurance_id',$insurance_id);
                    
                    $this->db->update('product_price',$datapp);
                    
                    log_message('error', 'No. '.$cont++.' Product_id: '.$product_id.' Price : '.$prices[$i].' Insurance id = '.$insurance_id.'<br>');
                }else
                {
                  
                    $datapp['price'] =  $prices[$i];
                    $datapp['product_id'] = $product_id;
                    $datapp['insurance_id'] = $insurance_id;
                      
                    $this->db->insert('product_price',$datapp);
                      
                     log_message('error', 'No. '.$cont++.' Product_id: '.$product_id.' Price : '.$prices[$i].' Insurance id = '.$insurance_id.'<br>');
                  
                }
             
                
            }
        
        
             $amount = $this->input->post('amount2');
             $unity = $this->input->post('unity2');
             $cost = $this->input->post('cost');
        }else
        {
            $product_id = $this->input->post('product_id');
            $amount = $this->input->post('amount1');
            $unity = $this->input->post('unity1');
            $cost = $this->input->post('cost1');
        }
       

         $data = array(
            'product_id' =>  $product_id,
            'inventory_id' => $this->input->post('inventory_id'),
         );

         $this->db->insert('inventory_product',$data);

            $data = array(
                'product_id' => $product_id,
                'date' => $this->crud_model->formatDate(),
                'expiration' => $this->input->post('date_'.$p['product_id']),
                'cost' => $this->input->post('cost'),
                'total' => $amount*$this->input->post('cost'),
                'initial' => $amount,
                'amount' => $amount,
                'unity' => $unity,
                'clinic_id' => trim($this->session->userdata('current_clinic')),
                'status' => 1
            );
    
            $this->db->insert('product_lote',$data);
            $lote_id = $this->db->insert_id();
            
            $data = array(
                'product_id' => $product_id,
                'lote' =>  $lote_id,
                'date' =>  date('Y-m-d'),
                'clinic_id' => trim($this->session->userdata('current_clinic')),
                'initial' => $amount,
                'amount' => $amount,
                'unity' => $unity,
                'ref' => 'Primer ingreso',
                'cost' => $this->input->post('cost'),
                'price' => '',
                'obs' => $this->input->post('notes'),
                'status_mov' => 1
            );
            
            $this->db->insert('product_move',$data);

    }

    function update_product($product_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['image']['name']);
        if($_FILES['image']['name'] != ''){
            
            $archivo    = $this->db->get_where('product', array('product_id' => $product_id))->row()->img;
            unlink('public/uploads/inventory/'.$archivo);
            move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
        }

        $data = array(
            'category_id' => $this->input->post('category_id'),
            'subcategory_id' => $this->input->post('subcategory_id'),
            'name' => $this->input->post('name'),
            'code' => $this->input->post('code'),
            'provider' => $this->input->post('provider_id'),
            'amount_alert' => $this->input->post('alert'),
            'image' => $this->input->post('image'),
            'points' => $this->input->post('points'),
            'cost' => $this->input->post('cost'),
            'u_amount' => $this->input->post('u_amount'),
            'unity' => $this->input->post('unity'),
            'p_amount' => $this->input->post('p_amount'),
            'presentation' => $this->input->post('presentation'),
            'pa_amount' => $this->input->post('pa_amount'),
            'packaging' => $this->input->post('packaging'),
            'price_1' => $this->input->post('price_1'),
            'price_2' => $this->input->post('price_2'),
            'price_3' => $this->input->post('price_3'),
            'image' =>  $name,
         );
         
         $this->db->where('product_id',$product_id);
         $this->db->update('product',$data);

        $prices = $this->input->post('price');
        $insurances = $this->input->post('insurance_id');
         
        $this->db->where('product_id',$product_id);
        $this->db->where_not_in('insurance_id',$insurances);
        $this->db->delete('product_price');
        
        foreach($insurances as $i=>$insurance_id)
        {
            $exist = $this->db->get_where('product_price',array('product_id'=>$product_id,'insurance_id'=>$insurance_id))->num_rows();
            if($exist > 0)
            {
                $datapp['price'] = $prices[$i];
                
                $this->db->where('product_id',$product_id);
                $this->db->where('insurance_id',$insurance_id);
                
                $this->db->update('product_price',$datapp);
                
                log_message('error', 'No. '.$cont++.' Product_id: '.$product_id.' Price : '.$prices[$i].' Insurance id = '.$insurance_id.'<br>');
            }else
            {
              
                $datapp['price'] =  $prices[$i];
                $datapp['product_id'] = $product_id;
                $datapp['insurance_id'] = $insurance_id;
                  
                $this->db->insert('product_price',$datapp);
                  
                 log_message('error', 'No. '.$cont++.' Product_id: '.$product_id.' Price : '.$prices[$i].' Insurance id = '.$insurance_id.'<br>');
              
            }
         
            
        }
        
        
         return $this->db->get_where('product', array('product_id' => $product_id))->row()->inventory_id;
    }

    function product_import()
    {
    
        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['files']['name']);
        $type = 1;
        if($_FILES['files']['name'] != ''){
            $data['file']              = $name;
            move_uploaded_file($_FILES['files']['tmp_name'], 'public/uploads/import/' . $name);
        }


             $path = 'public/uploads/import/' . $name;
             $object = PHPExcel_IOFactory::load($path);
             foreach($object->getWorksheetIterator() as $worksheet)
             {
                 $highestRow = $worksheet->getHighestRow();
                 $highestColumn = $worksheet->getHighestColumn();
                 log_message('error', '$highestRow '.$highestRow);
                 for($row=12; $row <= $highestRow; $row++)
                 {
                  
                    log_message('error','category_id '.$worksheet->getCellByColumnAndRow(0, $row)->getValue());
                    log_message('error','subcategory_id '.$worksheet->getCellByColumnAndRow(1, $row)->getValue());
                    log_message('error','name '.$worksheet->getCellByColumnAndRow(2, $row)->getValue());
                    log_message('error','code '.$worksheet->getCellByColumnAndRow(3, $row)->getValue());
                    $product = $this->db->get_where('product', array('code' =>  $worksheet->getCellByColumnAndRow(2, $row)->getValue()))->num_rows();
                    $category_id = $this->db->query('SELECT * FROM category WHERE name LIKE "%'.$worksheet->getCellByColumnAndRow(0, $row)->getValue().'%"')->row()->id;
                    $subcategory_id = $this->db->query('SELECT * FROM subcategory WHERE name LIKE "%'.$worksheet->getCellByColumnAndRow(1, $row)->getValue().'%"')->row()->id;
                    $provider_id = $this->db->where('first_name',$worksheet->getCellByColumnAndRow(4, $row)->getValue())->get('staff')->first_row()->staff_id ;
                    
                    if($worksheet->getCellByColumnAndRow(2, $row)->getValue() )
                    {
                        if($product == 0 )
                        {
    
                            if($provider_id == '')
                            $provider_id =0;
    
                            if($category_id  == '')
                            $category_id =0;
                            
                            
                            if($category_id == 15)
                                $type = 3;
                         
    
                           
                            $principal_unity = $this->db->where('name',$worksheet->getCellByColumnAndRow(7, $row)->getValue())->get('unity')->row()->code;
                            
                            if($principal_unity == '')
                            {
                                $dataUnity = array(
                                            'code'=>$worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                                            'name'=>$worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                                            );
                                            
                                $this->db->insert('unity',$dataUnity);
                                $principal_unity = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                                
                            }
                            
                            
                            $cell = $worksheet->getCellByColumnAndRow(6, $row);

                            if ($cell->getValue() !== null ) {
                                // La celda contiene una fórmula
                                $value = $cell->getCalculatedValue();
                            } else {
                                // La celda no contiene una fórmula, obtener el valor directo
                                $value = $cell->getValue();
                            }


                            $data = array(
                                'category_id' =>  $category_id,
                                'subcategory_id' =>  $subcategory_id,
                                'inventory_id' => $this->input->post('inventory_id'),
                                'name' =>   $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                                'code' =>   $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                                'provider' => $provider_id,
                                'stock' => $value,
                                'principal_unity' =>  $principal_unity,
                                'amount_alert' => $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
                                'points'  =>    $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
                                'cost' => $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
                                'price_1' =>    $worksheet->getCellByColumnAndRow(11, $row)->getValue(),
                                'price_2' =>    $worksheet->getCellByColumnAndRow(12, $row)->getValue(),
                                'price_3' =>    $worksheet->getCellByColumnAndRow(13, $row)->getValue(),
                                'pa_amount' =>  $worksheet->getCellByColumnAndRow(14, $row)->getValue(),
                                'packaging' =>  $this->db->like('name',$worksheet->getCellByColumnAndRow(15, $row)->getValue(),'both')->get('unity')->row()->code,
                                'p_amount' =>   $worksheet->getCellByColumnAndRow(16, $row)->getValue(),
                                'presentation' => $this->db->like('name',$worksheet->getCellByColumnAndRow(17, $row)->getValue(),'both')->get('unity')->row()->code,
                                'u_amount' =>   $worksheet->getCellByColumnAndRow(18, $row)->getValue(),
                                'unity'         =>  $this->db->like('name',$worksheet->getCellByColumnAndRow(19, $row)->getValue(),'both')->get('unity')->row()->code,
                                'type' => $type,
                                'status' => 1
                            );
                    
                            $this->db->insert('product',$data);
                            $product_id = $this->db->insert_id();
                           
                        }else
                        {
                            $product_id = $this->db->get_where('product', array('code' =>  $worksheet->getCellByColumnAndRow(4, $row)->getValue()))->first_row()->product_id;
                        }
                       
                        $pr_inventory = $this->db->get_where('inventory_product', array('product_id' => $product_id,'inventory_id'=>$this->input->post('inventory_id')))->num_rows();
                        
                        if($product_id != 0 && $pr_inventory == 0)
                        {
                       
                            $data = array(
                                'product_id' =>  $product_id,
                                'inventory_id' => $this->input->post('inventory_id'),
                            );
                    
                            $this->db->insert('inventory_product',$data);
    
                            
                            $amount = $value;
                            $cost = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                            
                        
                                    $data = array(
                                        'product_id' => $product_id,
                                        'date' => $this->crud_model->formatDate(),
                                        'expiration' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
                                        'cost' => $cost,
                                        'total' => $amount*$cost,
                                        'initial' => $amount,
                                        'amount' => $amount,
                                        'unity' => $principal_unity,
                                        'clinic_id' => trim($this->session->userdata('current_clinic')),
                                        'status' => 1
                                    );
                            
                                    $this->db->insert('product_lote',$data);
                                    $lote_id = $this->db->insert_id();
                                    
                                    $data = array(
                                        'product_id' => $product_id,
                                        'lote' =>  $lote_id,
                                        'date' =>  date('Y-m-d'),
                                        'clinic_id' => trim($this->session->userdata('current_clinic')),
                                        'amount' => $amount,
                                        'unity' => $principal_unity,
                                        'ref' => 'Primer ingreso',
                                        'cost' => $cost,
                                        'price' => '',
                                        'obs' => 'Importado',
                                        'status_mov' => 1
                                    );
                                    
                                    $this->db->insert('product_move',$data);
                           
                                }
                    }

                 }
             }
             unlink('public/uploads/import/' . $name);
            
    }


    function delete_products($id)
    {
      $data['status'] = 0;
      $this->db->where('inventory_product_id', $id);
      $this->db->update('inventory_product', $data);

      return $this->db->get_where('inventory_product', array('inventory_product_id' => $id))->row()->inventory_id;
    }

   function get_product_price($product_id,$type_price)
    {
         return $this->db->get_where('product_price' , array('product_id' => $product_id,'insurance_id'=>$type_price))->row()->price;
    }
    
    
    function create_service()
    {


        if($this->input->post('product_type') == '1')
        {


            $md5 = md5(date('d-m-Y H:i:s'));
            $name = $md5.str_replace(' ', '', $_FILES['image']['name']);
            if($_FILES['image']['name'] != ''){
                
                $archivo    = $this->db->get_where('product', array('product_id' => $product_id))->row()->img;
                unlink('public/uploads/inventory/'.$archivo);
                move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
            }

            $data = array(
                'category_id' => $this->input->post('category_id'),
                'subcategory_id' => $this->input->post('subcategory_id'),
                'provider' => $this->input->post('provider_id'),
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'image'=> $this->input->post('image'),
                'cost' => $this->input->post('cost'),
                'price_1' => $this->input->post('price_1'),
                'price_2' => $this->input->post('price_2'),
                'price_3' => $this->input->post('price_3'),
                'clinic_id'     => trim($this->session->userdata('current_clinic')),
                'inventory_id'  => $this->input->post('inventory_id'),
                'points' => $this->input->post('points'),
                'image' =>  $name,
                'type' => 2,
                'status' => 1
             );
             $this->db->insert('product',$data);
             $product_id = $this->db->insert_id();
             
            $prices = $this->input->post('price');
            $insurances = $this->input->post('insurance_id');
             
            foreach($insurances as $i=>$insurance_id)
            {
                $exist = $this->db->get_where('product_price',array('product_id'=>$product_id,'insurance_id'=>$insurance_id))->num_rows();
                if($exist > 0)
                {
                    $datapp['price'] = $prices[$i];
                    
                    $this->db->where('product_id',$product_id);
                    $this->db->where('insurance_id',$insurance_id);
                    
                    $this->db->update('product_price',$datapp);
                    
                    log_message('error', 'No. '.$cont++.' Product_id: '.$product_id.' Price : '.$prices[$i].' Insurance id = '.$insurance_id.'<br>');
                }else
                {
                  
                    $datapp['price'] =  $prices[$i];
                    $datapp['product_id'] = $product_id;
                    $datapp['insurance_id'] = $insurance_id;
                      
                    $this->db->insert('product_price',$datapp);
                      
                     log_message('error', 'No. '.$cont++.' Product_id: '.$product_id.' Price : '.$prices[$i].' Insurance id = '.$insurance_id.'<br>');
                  
                }
             
                
            }
            
            
        }else
        {
            $product_id = $this->input->post('product_id');
        }
       

         $data = array(
            'product_id' =>  $product_id,
            'inventory_id' => $this->input->post('inventory_id'),
         ); 

         $this->db->insert('inventory_product',$data);

    }



    function update_service($product_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['image']['name']);
        if($_FILES['image']['name'] != ''){
            
            $archivo    = $this->db->get_where('product', array('product_id' => $product_id))->row()->img;
            unlink('public/uploads/inventory/'.$archivo);
            move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
        }
        $data = array(
            'category_id' => $this->input->post('category_id'),
            'subcategory_id' => $this->input->post('subcategory_id'),
            'provider' => $this->input->post('provider_id'),
            'name' => $this->input->post('name'),
            'code' => $this->input->post('code'),
            'image'=> $this->input->post('image'),
            'points' => $this->input->post('points'),
            'cost' => $this->input->post('cost'),
            'price_1' => $this->input->post('price_1'),
            'price_2' => $this->input->post('price_2'),
            'price_3' => $this->input->post('price_3'),
            'image' =>  $name,
         );

         $this->db->where('product_id',$product_id);
         $this->db->update('product',$data);
         
         
        $prices = $this->input->post('price');
        $insurances = $this->input->post('insurance_id');
         
        $this->db->where('product_id',$product_id);
        $this->db->where_not_in('insurance_id',$insurances);
        $this->db->delete('product_price');
        
        foreach($insurances as $i=>$insurance_id)
        {
            $exist = $this->db->get_where('product_price',array('product_id'=>$product_id,'insurance_id'=>$insurance_id))->num_rows();
            if($exist > 0)
            {
                $datapp['price'] = $prices[$i];
                
                $this->db->where('product_id',$product_id);
                $this->db->where('insurance_id',$insurance_id);
                
                $this->db->update('product_price',$datapp);
                
                log_message('error', 'No. '.$cont++.' Product_id: '.$product_id.' Price : '.$prices[$i].' Insurance id = '.$insurance_id.'<br>');
            }else
            {
              
                $datapp['price'] =  $prices[$i];
                $datapp['product_id'] = $product_id;
                $datapp['insurance_id'] = $insurance_id;
                  
                $this->db->insert('product_price',$datapp);
                  
                 log_message('error', 'No. '.$cont++.' Product_id: '.$product_id.' Price : '.$prices[$i].' Insurance id = '.$insurance_id.'<br>');
              
            }
         
            
        }
       
         
      
      

    }



    function service_imp($service_id)
    {
       
            $md5 = md5(date('d-m-Y H:i:s'));
            $name = $md5.str_replace(' ', '', $_FILES['files']['name']);
            $type = 2;
            
            if($_FILES['files']['name'] != ''){
                $data['file']              = $name;
                move_uploaded_file($_FILES['files']['tmp_name'], 'public/uploads/import/' . $name);
            }
    
    
                 $path = 'public/uploads/import/' . $name;
                 $object = PHPExcel_IOFactory::load($path);
                 foreach($object->getWorksheetIterator() as $worksheet)
                 {
                     $highestRow = $worksheet->getHighestRow();
                     $highestColumn = $worksheet->getHighestColumn();
                    
                     for($row=8; $row <= $highestRow; $row++)
                     {
                      
                        $product = $this->db->get_where('product', array('code' =>  $worksheet->getCellByColumnAndRow(2, $row)->getValue()))->num_rows();
                        $category_id = $this->db->query('SELECT * FROM category WHERE name = "'.$worksheet->getCellByColumnAndRow(0, $row)->getValue().'"')->row()->id;
                        $subcategory_id = $this->db->query('SELECT * FROM subcategory WHERE name LIKE "%'.$worksheet->getCellByColumnAndRow(1, $row)->getValue().'%"')->row()->id;
                        $provider_id = $this->db->where('first_name',$worksheet->getCellByColumnAndRow(4, $row)->getValue())->get('staff')->first_row()->staff_id ;
                        log_message('error', '$ $product '. $product);
                        if($product == 0 )
                        {
    
                            if($provider_id == '')
                            $provider_id =0;
                            
                             if($category_id == 15)
                            $type = 3;
    
                            log_message('error','category_id '.$worksheet->getCellByColumnAndRow(0, $row)->getValue().'-'.$category_id);
                            log_message('error','subcategory_id '.$worksheet->getCellByColumnAndRow(1, $row)->getValue().'-'.$subcategory_id);
    
                           
                            $principal_unity = $this->db->like('name',$worksheet->getCellByColumnAndRow(7, $row)->getValue(),'both')->get('unity')->row()->code;
    
                            
                            $data = array(
                                'category_id' =>  $category_id,
                                'subcategory_id' =>  $subcategory_id,
                                'inventory_id' => $this->input->post('inventory_id'),
                                'name' =>   $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                                'code' =>   $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                                'provider' => $provider_id,
                                'points'  =>    $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
                                'cost' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                                'price_1' =>    $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                                'price_2' =>    $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
                                'price_3' =>    $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
                                'type' => $type,
                                'status' => 1
                            );
                    
                            $this->db->insert('product',$data);
                            $product_id = $this->db->insert_id();
                           
                        }else
                        {
                            $product_id = $this->db->get_where('product', array('code' =>  $worksheet->getCellByColumnAndRow(2, $row)->getValue()))->first_row()->product_id;
                        }
                       
                        $pr_inventory = $this->db->get_where('inventory_product', array('product_id' => $product_id,'inventory_id'=>$this->input->post('inventory_id')))->num_rows();
                        
                        if($product_id != 0 && $pr_inventory == 0)
                        {
                       
                            $data = array(
                                'product_id' =>  $product_id,
                                'inventory_id' => $this->input->post('inventory_id'),
                            );
                    
                            $this->db->insert('inventory_product',$data);
                           
                        }
    
                     }
                 }
                 unlink('public/uploads/import/' . $name);
                
    
    
    }

    function prices_imp()
    {
       
            $md5 = md5(date('d-m-Y H:i:s'));
            $name = $md5.str_replace(' ', '', $_FILES['files']['name']);
    
            if($_FILES['files']['name'] != ''){
                $data['file']              = $name;
                move_uploaded_file($_FILES['files']['tmp_name'], 'public/uploads/import/' . $name);
            }
    
    
                 $path = 'public/uploads/import/' . $name;
                 $object = PHPExcel_IOFactory::load($path);
                 foreach($object->getWorksheetIterator() as $worksheet)
                 {
                     $highestRow = $worksheet->getHighestRow();
                     $highestColumn = $worksheet->getHighestColumn();
                    
                     for($row=7; $row <= $highestRow; $row++)
                     {
                        $code = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $insurance = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $price = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        
                        if($insurance != '' && $code != '' &&  $price != '')
                        {
                                $insurance_id = 0;
                             
                                if( $insurance == 'Atenun' ||  $insurance == 'ATENUN'  ||  $insurance == '')
                                $insurance_id = 0;
                                else
                                $insurance_id = $this->db->get_where('insurance',array('name'=>$insurance))->row()->insurance_id ;
                                
                                if($insurance_id == '')
                                $insurance_id = 0;
                                
                                if($code != '')
                                $product_id = $this->db->order_by('product_id','DESC')->get_where('product',array('code'=>$code,'status'=>1))->row()->product_id;
                               
                                
                                
                               
                                if($product_id != '' )
                                {
                                    
                                    
                                    $exist = $this->db->get_where('product_price',array('product_id'=>$product_id,'insurance_id'=>$insurance_id))->num_rows();
                                    log_message('error',  ' Aseguradora '. $insurance_id.' product '.$product_id.' price '.$price.' exist '.$exist);
                                    if($exist > 0)
                                    {
                                        $dataPr = array(
                                            'price'=>$price
                                            );
                                        $this->db->where('product_id',$product_id);
                                        $this->db->where('insurance_id',$insurance_id);
                                        $this->db->update('product_price',$dataPr);
                                    }
                                    else
                                    {
                                        $data = array(
                                            'product_id' =>  $product_id,
                                            'insurance_id' =>  $insurance_id,
                                            'price' => $price,
                                        );
                            
                                        $this->db->insert('product_price',$data);
        
                                    }
            
                                }
                            
                        }
    
                     }
                 }
                 unlink('public/uploads/import/' . $name);
                
    
    
    }
    
    function service_implementos($service_id)
    {
        $this->db->where('service_id', $service_id);
        $this->db->delete('service_imp');
        

           for ($i=0; $i < count($this->input->post('product_id')); $i++) { 
            # code...

          
               
                $data = array(
                    'service_id' =>  $service_id,
                    'product_id' =>  $this->input->post('product_id')[$i],
                    'amount'=>  $this->input->post('amount')[$i],
                    'unity' =>  $this->input->post('unity')[$i],
                    'cost' =>  $this->input->post('cost')[$i],
                );

                $this->db->insert('service_imp',$data);
            }
    
    }


    function create_laboratory()
    {

        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['image']['name']);
        if($_FILES['image']['name'] != ''){
            
            $archivo    = $this->db->get_where('product', array('product_id' => $product_id))->row()->img;
            unlink('public/uploads/inventory/'.$archivo);
            move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
        }

        if($this->input->post('product_type') == '1')
        {
            $data = array(
                'category_id' => $this->input->post('category_id'),
                'subcategory_id' => $this->input->post('subcategory_id'),
                'provider' => $this->input->post('provider_id'),
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'image'=> $this->input->post('image'),
                'cost' => $this->input->post('cost'),
                'price_1' => $this->input->post('price_1'),
                'price_2' => $this->input->post('price_2'),
                'price_3' => $this->input->post('price_3'),
                'clinic_id'     => trim($this->session->userdata('current_clinic')),
                'inventory_id'  => $this->input->post('inventory_id'),
                'points' => $this->input->post('points'),
                'image' =>  $name,
                'type' => 3,
                'status' => 1
             );
             $this->db->insert('product',$data);
             $product_id = $this->db->insert_id();
        }else
        {
            $product_id = $this->input->post('product_id');
        }
       

         $data = array(
            'product_id' =>  $product_id,
            'inventory_id' => $this->input->post('inventory_id'),
         ); 

         $this->db->insert('inventory_product',$data);

    }


    
    function update_laboratory($product_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $name = $md5.str_replace(' ', '', $_FILES['image']['name']);
        if($_FILES['image']['name'] != ''){
            
            $archivo    = $this->db->get_where('product', array('product_id' => $product_id))->row()->img;
            unlink('public/uploads/inventory/'.$archivo);
            move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/inventory/' . $name);
        }

        $data = array(
            'category_id' => $this->input->post('category_id'),
            'subcategory_id' => $this->input->post('subcategory_id'),
            'provider' => $this->input->post('provider_id'),
            'name' => $this->input->post('name'),
            'code' => $this->input->post('code'),
            'image'=> $this->input->post('image'),
            'points' => $this->input->post('points'),
            'cost' => $this->input->post('cost'),
            'price_1' => $this->input->post('price_1'),
            'price_2' => $this->input->post('price_2'),
            'price_3' => $this->input->post('price_3'),
            'image' =>  $name,
         );

         $this->db->where('product_id',$product_id);
         $this->db->update('product',$data);
         $product_id = $this->db->insert_id();

    }



    function get_stock($ID)
    {
        $moves = $this->db->query(" SELECT * FROM `product_move` WHERE product_id = '$ID' and clinic_id = '".$this->session->userdata('current_clinic')."' AND status = '1' ")->result_array();
        $presentations = $this->db->query(" SELECT * FROM `product` WHERE product_id = ".$ID)->row_array();
        if(count($moves)>0)
        {
            $total = 0;
            foreach ($moves as $move) {
            # code..
            if($move['unity'] == $presentations['principal_unity'])
            {
                $total += $move['amount'];
            }else
            {
                if($move['unity'] == $presentations['unity'])
                    {
                        $total += ($move['amount']/$presentations['u_amount']);
                    }
    
                    if($move['unity'] == $presentations['presentation'])
                    {
                        $total += ($move['amount']/$presentations['p_amount']);
                    }
    
    
                    if($move['unity'] == $presentations['packaging'])
                    {
                        $total += ($move['amount']/$presentations['pa_amount']);
                    }
                }
            }
            
            
            return $total;
        }else
        {
            return '';
        }

    }

    function getProductImage($productId){
        $image = $this->db->get_where('product', array('product_id' => $productId))->row()->image;
        if($image != ''){
            return base_url().'public/uploads/inventory/'.$image;
        }else{
            return base_url().'public/uploads/img.png';
        }
    }
        


    function create_inventory()
    {
      $data['name']        = $this->input->post('name');
      $data['type']        = $this->input->post('type');
      $data['icon']        = $this->input->post('icono');
      $data['clinic_id']   = trim($this->session->userdata('current_clinic'));
      $this->db->insert('inventory', $data);
    }

    function update_inventory($id)
    {
      $data['name']        = $this->input->post('name');
      $data['type']        = $this->input->post('type');
      $data['icon']        = $this->input->post('icono');
      $this->db->where('inventory_id', $id);
      $this->db->update('inventory', $data);
    }

    function delete_inventory($id)
    {
      $data['status'] = 0;
      $this->db->where('inventory_id', $id);
      $this->db->update('inventory', $data);
    }

    function get_products()
    {
        $this->db->order_by('name', 'ASC');
        $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
        $products = $this->db->get('product')->result_array();
        $string = "";
        foreach($products as $row)
        {
            $string .= "'".$row['name']."'".",";
        }
        return $string;
    }

    
    function create_solicitud()
    {
       
        $products       =   $this->input->post('product_id');
        $unity          =   $this->input->post('unity');
        $amount         =   $this->input->post('amount');
        $subtotal       =   $this->input->post('sbtotal');
        $total          =   $this->input->post('total');
        $total_val      = 0;
        $sales_order_entries =   array();
        for($i = 0; $i < sizeof($products); $i++) 
        {
            if($products[$i] != "")
            {
                
                $new_order_entry    =   array(
                    'product_id' => $products[$i],
                    'amount' => $amount[$i],
                    'unity' => $unity[$i],
                    'subtotal' => $subtotal[$i],
                    'total' => $total[$i],
                );
                $total_val += $total[$i];

                array_push($sales_order_entries , $new_order_entry);
            }
        }

        $data['code']           =  $this->input->post('code');
        $data['provider_id']    =  $this->input->post('provider_id');
        $data['date']           =  $this->input->post('date');
        $data['user_id']        =  $this->session->userdata('login_user_id');
        $data['user_type']      =  $this->session->userdata('login_type');
        $data['products']       =  serialize($sales_order_entries);
        $data['order_type']     =  $this->input->post('order_type');
        $data['total']          =  $total_val;
        $data['status']         =  0;

        $this->db->insert('pedidos', $data);
        
    }


    function update_solicitud($pedidos_id)
    {
       
        $products       =   $this->input->post('product_id');
        $unity          =   $this->input->post('unity');
        $amount         =   $this->input->post('amount');
        $subtotal       =   $this->input->post('subtotal');
        $total          =   $this->input->post('total');
        $total_val      = 0;
        $sales_order_entries =   array();
        for($i = 0; $i < sizeof($products); $i++) 
        {
            if($products[$i] != "")
            {
                
                $new_order_entry    =   array(
                    'product_id' => $products[$i],
                    'amount' => $amount[$i],
                    'unity' => $unity[$i],
                    'subtotal' => $subtotal[$i],
                    'total' => $total[$i],
                );
                $total_val += $total[$i];

                array_push($sales_order_entries , $new_order_entry);
            }
        }

        $data['code']           =  $this->input->post('code');
        $data['provider_id']    =  $this->input->post('provider_id');
        $data['date']           =  $this->input->post('date');
        $data['user_id']        =  $this->session->userdata('login_user_id');
        $data['user_type']      =  $this->session->userdata('login_type');
        $data['total']          =  $total_val;
        $data['products']  =  serialize($sales_order_entries);

        $this->db->where('pedidos_id', $pedidos_id);
        $this->db->update('pedidos', $data);
        
    }

    function delete_solicitud($pedidos_id)
    {
        

        $data['status']    =  0;
        $this->db->where('pedidos_id', $pedidos_id);
        $this->db->update('pedidos', $data);
        
    }

    
    function confirm_solicitud($pedidos_id)
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
       
        $data['method']            = $this->input->post('method');

        if($this->input->post('method') == 1)
        {
            $data['nomenclature_id']   = $this->input->post('cash_id');
        }

        if($this->input->post('method') == 3)
        {
            $data['nomenclature_id']   = $this->input->post('bank_account_id');
        }

        $data['transaction']       = $this->input->post('type_transfer');
        $data['reference_code']    = $this->input->post('reference_code');
        $data['reference_file']    = $this->input->post('reference_file');
        $data['invoice_code']      = $this->input->post('invoice_code');
        $data['invoice_file']           = $this->input->post('invoice_file');
        $data['days']           = $this->input->post('days');
        $data['status']            = 1;
        $this->db->where('pedidos_id', $pedidos_id);
        $prod = $this->db->update('pedidos',$data);


        $this->db->where('pedidos_id', $pedidos_id);
        
        $prod = $this->db->get('pedidos')->row()->products;
       
        foreach (unserialize($prod) as $p) {

            # code...
            log_message('error',$p['product_id'].' '.$p['amount'].' '.$p['unity'].' '.$p['subtotal'].' '.$p['total']);
            $data = array(
                'product_id' => $p['product_id'],
                'date' => $this->crud_model->formatDate(),
                'expiration' => $this->input->post('date_'.$p['product_id']),
                'cost' => $p['subtotal'],
                'total' => $p['total'],
                'amount' => $p['amount'],
                'unity' => $p['unity'],
                'clinic_id' => trim($this->session->userdata('current_clinic')),
                'status' => 1
            );
    
            $this->db->insert('product_lote',$data);
            $lote_id = $this->db->insert_id();
            
            $data = array(
                'product_id' => $p['product_id'],
                'lote' =>  $lote_id,
                'date' =>  date('Y-m-d'),
                'clinic_id' => trim($this->session->userdata('current_clinic')),
                'amount' => $p['amount'],
                'unity' => $p['unity'],
                'ref' => $pedidos_id,
                'cost' => $p['subtotal'],
                'price' => '',
                'obs' => $this->input->post('notes'),
                'status_mov' => 1
            );
            
            $this->db->insert('product_move',$data);
        }
        
        $this->crud_model->createDepByPurchase($pedidos_id);
    }

    function count_cost()
    {
        $sql = "SELECT * FROM product WHERE clinic_id = ? and status = 1";
        $res = $this->db->query($sql, array($this->session->userdata('current_clinic')));   
        return $res;
    }

    function count_alert()
    {
        $sql = "SELECT * FROM product WHERE clinic_id = ? and status = 1";
        $res = $this->db->query($sql, array($this->session->userdata('current_clinic')));   
        $prd = array();
        foreach($res->result_array() as $row)
        {
            $stock = $this->crud_model->get_inventory($row['product_id']);
            if($row['amount_alert'] >= $stock && $stock > 0)
            {
                array_push($prd,$row);
            }
        }

        return $prd ;
    }

    function get_total_cajac($param1 = '', $param2 = '')
    {
        $total = $this->db->query(" SELECT sum(total) as total FROM `sale` WHERE box_id = '$param1' AND nomenclature_id = 2 ")->row()->total;

        return $total != '' ? number_format($total,2,'.',','): number_format(0,2,'.',',');
    }

    function get_total_cajav($param1 = '', $param2 = '')
    {
        $total = $this->db->query(" SELECT sum(total) as total FROM `sale` WHERE box_id = '$param1' AND nomenclature_id = 1 ")->row()->total;
        return $total != '' ? number_format($total,2,'.',','): number_format(0,2,'.',',');
    }

    function get_total_banco($param1 = '', $param2 = '')
    {
        $total = $this->db->query(" SELECT sum(total) as total FROM `sale` WHERE box_id = '$param1' AND bank_account_id = 1 ")->row()->total;
        return $total != '' ? number_format($total,2,'.',','): number_format(0,2,'.',',');
    }
    
    function product_expiration()
    { 
                
        $hoy = date('Y-m-d');                
        $res = $this->db->query("SELECT pl.date,pl.expiration,p.status FROM product_lote pl INNER JOIN product p on pl.product_id = p.product_id and str_to_date(pl.expiration , '%Y-%m-%d') < str_to_date('$hoy', '%Y-%m-%d') WHERE p.status = '1'");
            
        return $res;
    }

    function product_per_expiration()
    { 
                
        $hoy = date('Y-m-d');  
        $new_date = date("Y-m-d",strtotime($fecha_actual."+ 2 week"));               
        $res = $this->db->query("SELECT * FROM product_lote WHERE status = '1' AND  str_to_date(expiration , '%Y-%m-%d') > str_to_date('$hoy', '%Y-%m-%d') AND cantidad > 0 ");
        $prd = array();
        foreach ($res->result_array() as $row)
        {
            $st = $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->status;
            if($st == 1)
            {
                $expiration = strtotime($row['expiration']);  
                
                if($expiration <=  strtotime($new_date))
                {
                    array_push($prd,$row);
                }
            }
        }
        return $prd;
    }

    function product_outstock()
    {
        $sql = "SELECT * FROM product WHERE clinic_id = ? and status = 1";
        $res = $this->db->query($sql, array($this->session->userdata('current_clinic')));   
        $prd = array();
        foreach($res->result_array() as $row)
        {
            $stock = $this->crud_model->get_inventory($row['product_id']);
            if( $stock == 0)
            {
                array_push($prd,$row);
            }
        }

        return $prd ;
    }
 
    
       
    function leading_product()
    {
       /*$reg = '.*variant_id;s:[0-9]+:2.*';
        $this->db->where('products count(REGEXP ', "'".'.*"variant_id";s:[0-9]+:"'.$var.'".*)'."'", false); 
        $sql = $this->db->get('cart');
        
        return $sql->num_rows();*/
       $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
       $this->db->limit(6);
       $this->db->order_by('cart_id','desc');
       $sql = $this->db->get('cart')->result_array();
       $ar = array();
   
       foreach($sql as $row)
       { 
            foreach (unserialize ($row['products']) as $row2)
            {
               array_push($ar,['qty'=>$row2['variant_id']*$row2['ordered_quantity'],'product_id'=>$row2['variant_id']]);
            }
       }
       rsort($ar);
       return $ar;
    }

    
    function service_export()
     {

        $md5 = md5(date('d-m-Y H:i:s'));
        $path = 'public/uploads/import/services.xlsx';

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($path);

        $number_of_entries   =   sizeof($columns);

        $styleArray = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );
          
        setlocale(LC_ALL,"es_ES");
       
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);

        if($this->input->post('category_id') != 'T')
        {
            $this->db->where('category_id',$this->input->post('category_id'));
        }

        if($this->input->post('subcategory_id') != 'T')
        {
            $this->db->where('subcategory_id',$this->input->post('subcategory_id'));
        }
        $this->db->where('type',2);
        $this->db->where('status',1);
        $products = $this->db->get('product')->result_array();
        log_message('error',$this->db->last_query());
        $row = 8;
        foreach ($products as $product) {
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row,  $this->db->get_where('category',array('id'=>$product['category_id']))->row()->name);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row,  $this->db->get_where('subcategory',array('id'=>$product['subcategory_id']))->row()->name);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $product['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $product['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $product['provider']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $product['amount_alert']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $product['cost']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $product['price_1']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $product['price_2']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $product['price_3']);
            $row++;
        }
        
       // Configurar el encabezado HTTP para descargar el archivo Excel
       $nombrePersonalizado = "Servicios.xlsx";
      
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       header('Content-Disposition: attachment;filename="' . $nombrePersonalizado . '"');
       header('Content-Disposition: attachment;filename="servicios.xlsx"');
       header('Cache-Control: max-age=0');

       // Guardar el archivo Excel en el flujo de salida
       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
       $objWriter->save('php://output');

       exit();
        
     }

     function product_export()
     {

        $md5 = md5(date('d-m-Y H:i:s'));
        $path = 'public/uploads/import/products.xlsx';

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($path);

        $number_of_entries   =   sizeof($columns);

        $styleArray = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );
          
        setlocale(LC_ALL,"es_ES");
       
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);

        if($this->input->post('category_id') != 'T')
        {
            $this->db->where('category_id',$this->input->post('category_id'));
        }

        if($this->input->post('subcategory_id') != 'T')
        {
            $this->db->where('subcategory_id',$this->input->post('subcategory_id'));
        }
        $this->db->where('type',1);
        $this->db->where('status',1);
        $products = $this->db->get('product')->result_array();
        log_message('error',$this->db->last_query());
        $row = 12;
        foreach ($products as $product) {

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $this->db->get_where('category',array('id'=>$product['category_id']))->row()->name);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row,  $this->db->get_where('subcategory',array('id'=>$product['subcategory_id']))->row()->name);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $product['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $product['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $product['provider']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row,'');
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $product['stock']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $product['principal_unity']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $product['amount_alert']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $product['points']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $product['cost']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $product['price_1']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $product['price_2']);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $product['price_3']);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $product['kit']);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $product['packaging']);
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $product['pa_amount']);
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $product['presentation']);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $product['unity']);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $product['u_amount']);

            $row++;
        }
        
       // Configurar el encabezado HTTP para descargar el archivo Excel
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       header('Content-Disposition: attachment;filename="productos.xlsx"');
       header('Cache-Control: max-age=0');

       // Guardar el archivo Excel en el flujo de salida
       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
       $objWriter->save('php://output');

       exit();
        
     }
     
         function prices_export()
     {

        $md5 = md5(date('d-m-Y H:i:s'));
        $path = 'public/uploads/import/prices.xlsx';

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($path);

        $number_of_entries   =   sizeof($columns);

        $styleArray = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );
          
        setlocale(LC_ALL,"es_ES");
       
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);

        if($this->input->post('category_id') != 'T')
        {
            $this->db->where('category_id',$this->input->post('category_id'));
        }

        if($this->input->post('subcategory_id') != 'T')
        {
            $this->db->where('subcategory_id',$this->input->post('subcategory_id'));
        }
        $this->db->where('type',2);
        $this->db->where('status',1);
        $products = $this->db->get('product')->result_array();
        log_message('error',$this->db->last_query());
        $row = 7;
        
        foreach ($products as $product) {
            
            $prices = $this->db->get_where('product_price',array('product_id'=>$product['product_id']))->result_array();
            
            foreach($prices as $price)
            {
             
                $insurance = $this->db->get_where('insurance',array('insurance_id'=>$price['insurance_id']))->row()->name;
                
                if($insurance == '')
                {
                    $insurance = 'Normal';
                }
                
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $product['code']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $insurance );
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $price['price']);
               
                $row++;
                
            }
            
        }
       // Configurar el encabezado HTTP para descargar el archivo Excel
       $nombrePersonalizado = "Servicios.xlsx";
      
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       header('Content-Disposition: attachment;filename="' . $nombrePersonalizado . '"');
       header('Content-Disposition: attachment;filename="precios.xlsx"');
       header('Cache-Control: max-age=0');

       // Guardar el archivo Excel en el flujo de salida
       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
       $objWriter->save('php://output');

       exit();
        
     }

     function service_masive_delete()
     {

        if($this->input->post('category_id') != 'T')
        {
            $this->db->where('category_id',$this->input->post('category_id'));
        }

        if($this->input->post('subcategory_id') != 'T')
        {
            $this->db->where('subcategory_id',$this->input->post('subcategory_id'));
        }
        
        
        if($this->input->post('category_id') == '15')
            $this->db->where('type',3);
        else  if($this->input->post('category_id') == '11')
            $this->db->where('type',2);
          else  
            $this->db->where('type',2);    
            
        $this->db->where('status',1);
        $products = $this->db->update('product',array('status'=>0));

        $products = $this->db->get_where('product',array('status'=>0))->result_array();
        foreach($products as $product)
        {
            $data = array(
                'status' => 0
                );
                
            $this->db->where('product_id',$product['product_id']);
            $this->db->update('inventory_product',$data);
            log_message('error','Products '.$product['product_id']);
        }
        
     }

     function product_masive_delete()
     {

        if($this->input->post('category_id') != 'T')
        {
            $this->db->where('category_id',$this->input->post('category_id'));
        }

        if($this->input->post('subcategory_id') != 'T')
        {
            $this->db->where('subcategory_id',$this->input->post('subcategory_id'));
        }
        
        
        if($this->input->post('category_id') == '15')
            $this->db->where('type',3);
        else
            $this->db->where('type',1);
            

        $products = $this->db->get_where('product',array('status'=>1))->result_array();
        foreach($products as $product)
        {
            $data = array(
                'status' => 0
                );
                
            $this->db->where('product_id',$product['product_id']);
            $this->db->update('inventory_product',$data);
            
            $this->db->where('product_id',$product['product_id']);
            $this->db->update('product',$data);
        }
        
     }



     function excel_export_inventory($param1)
     {
        if($param1 == 'all')
        {
            $query = $this->crud_model->count_cost()->result_array();
            $type = 'TODOS LOS PRODUCTOS';
        }
        if($param1 == 'alert')
        {
            $query = $this->crud_model->count_alert();
            $type = 'PRODUCTOS EN ALERTA';
        }
        if($param1 == 'per_expirate')
        {
            $query = $this->crud_model->product_per_expiration();
            $type = 'PRODUCTOS POR EXPIRAR';
        }
        if($param1 == 'expirate')
        {
            $query = $this->crud_model->product_expiration()->result_array();
            $type = 'PRODUCTOS EXPIRADOS';
        }
        if($param1 == 'out')
        {
            $query = $this->crud_model->product_outstock();
            $type = 'PRODUCTOS AGOTADOS';
        }
        
        $md5 = md5(date('d-m-Y H:i:s'));
        $path = 'public/uploads/plantilla_inventory_cmhm.xlsx';

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($path);

        $columns      =   $this->input->post('columns');
       

        $number_of_entries   =   sizeof($columns);

        $styleArray = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );
          
        setlocale(LC_ALL,"es_ES");
       
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);

        $objPHPExcel->getActiveSheet()->setCellValue('G5',$this->accounts_model->short_name($this->session->userdata('login_type') =='doctor' ? 'admin' :$this->session->userdata('login_type') ,$this->session->userdata('login_user_id')));
        $objPHPExcel->getActiveSheet()->setCellValue('F6',strftime("%A %d de %B de %Y"));
        $objPHPExcel->getActiveSheet()->setCellValue('C8','REPORTE DE INVENTARIOS DE '.$type);
               
     
         
        $row = 10;
        $set_color = true;
        $cont = 1;
        foreach($query as $rows)
        {  
            $row++;
            $c = 66;
            if($set_color)
            {
                $color = "FFFFFF";
                $set_color = false;
            }else {
                $color = "BCBCBC";
                $set_color = true;
            }
           
            
            foreach($rows as $key => $col)
            {
                if($key == "product_id")
                {
                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$col);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                    
                }else if($key == "name") {

                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$col);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }else if($key == "code") {

                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$col);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }else if($key == "price") {
                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,'Q. '.number_format($col,2,'.',','));
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }else if($key == "expiration") {

                    $expiration = explode("-",$this->crud_model->get_inventory_expired($rows['product_id']));

                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$expiration[2].'/'.$expiration[1].'/'.$expiration[0]);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }

                
               
            }

            foreach($rows as $key => $col)
            {
                if($key == "stock") {

                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$this->crud_model->get_inventory($rows['product_id']));
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }
               
            }
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        $objWriter->save('public/uploads/'.$md5.'.xlsx');
        $file_name = "Reporte Inventarios.xlsx";
        $this->load->helper('download');
        $info = file_get_contents("public/uploads/" .$md5.'.xlsx');
        $name = $file_name;
       

        unlink("public/uploads/" .$md5.".xlsx");

        force_download($name, $info);
        
     }

     function pdf_export()
     {
        $this->load->library('M_pdf'); 
        $mpdf = new mPDF('c', 'A4'); 
        $page_data['pedidos_id']           = 1;
        $html = $this->load->view('backend/doctor/print_solicitud', $page_data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();

    
        
     }

     function excel_export_kardex($param1)
     {
        
        $md5 = md5(date('d-m-Y H:i:s'));
        $path = 'public/uploads/plantilla_kardex_cmhm.xlsx';

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($path);

        $columns      =   $this->input->post('columns');

        $number_of_entries   =   sizeof($columns);

        $styleArray = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );
          
        setlocale(LC_ALL,"es_ES");
       
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A2',strftime("%A %d de %B de %Y"));
        $objPHPExcel->getActiveSheet()->setCellValue('B3', $this->db->get_where('product',array('product_id'=> base64_decode($param1)))->row()->name);
        $objPHPExcel->getActiveSheet()->setCellValue('F3',$this->inventory_model->get_stock(base64_decode($param1)));
         
        $row = 5;
        $set_color = true;
        $cont = 1;
        $n = 1;
        $query = $this->db->order_by('product_move_id', 'DESC')->get_where('product_move',array('product_id'=> base64_decode($param1)))->result_array();
        foreach($query as $rows)
        {  
            $row++;
            $c = 65;
            if($set_color)
            {
                $color = "FFFFFF";
                $set_color = false;
            }else {
                $color = "BCBCBC";
                $set_color = true;
            }
           
            
            foreach($rows as $key => $col)
            {
                if($key == "product_move_id")
                {
                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,'CRT-'.$cont++);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                    
                }
            }

            foreach($rows as $key => $col)
            {
                if($key == "date")
                {
                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$col);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                    
                }
            }

            foreach($rows as $key => $col)
            {
                if($key == "expiration")
                {
                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$col);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                    
                }
            }
            foreach($rows as $key => $col)
            {
                if($key == "paciente_id") {

                     if($row['status_mov'] == 1)
                     {
                        $status = $this->accounts_model->get_name('patient', $col);
                       
                     }else
                     {
                      
                        $status = "----";
                     }
                       

                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$status);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }
            }
            foreach($rows as $key => $col)
            {
                if($key == "paciente_id") {

                     if($row['status_mov'] == 1)
                     {
                        
                        $status = 'Salida';
                     }else
                     {
                        
                        $status = "----";
                     }
                       

                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$status);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }
            }
         
           
            foreach($rows as $key => $col)
            {
                if($key == "proveedor") {
                    
                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$col);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }
            }
            foreach($rows as $key => $col)
            {
                if($key == "factura") {
                    
                    if($row['status_mov'] == 1)
                     {
                        $status = '---';
                       
                     }else
                     {
                        $status =  $col;
                     }
                     
                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$col);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }
            }
            foreach($rows as $key => $col)
            {
                if($key == "status_mov") {
                    
                    if($row['status_mov'] == 1)
                     {
                        $status = 'Entrada';
                       
                     }else
                     {
                        $status = 'Salida';
                     }
                     
                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row, $status);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }
            }
            
           
            foreach($rows as $key => $col)
            {
                if($key == "cantidad") {

                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$this->crud_model->get_inventory($rows['producto_id']));
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }
            }
            foreach($rows as $key => $col)
            {
                if($key == "obs") {

                    $letra =chr($c++);
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($letra.$row,$col);
                    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => $color
                        )
                    ));
    
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($letra.$row)->getAlignment()->setWrapText(true);
                }
            }
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        $objWriter->save('public/uploads/'.$md5.'.xlsx');
        $file_name = "Reporte Inventarios.xlsx";
        $this->load->helper('download');
        $info = file_get_contents("public/uploads/" .$md5.'.xlsx');
        $name = $file_name;
       

        unlink("public/uploads/" .$md5.".xlsx");

        force_download($name, $info);
        
     }


    function add_product_extra()
    {
        
        
        $products = $this->input->post('product_id');
        $amounts = $this->input->post('amount');
        $unity = $this->input->post('unity');        
        $cats           =   $this->input->post('cat_id');
        $products       =   $this->input->post('product_id');
        $unity          =   $this->input->post('unity');
        $amount         =   $this->input->post('amount');
        
       
        for($i = 0; $i < sizeof($products); $i++) 
        {
                
            if($products[$i] != "")
            {
                
                log_message('error',$products[$i]); 
                $product_lotes = $this->db->order_by('product_lote_id', 'ASC')->get_where('product_lote' , array('product_id' => $products[$i],'amount >'=>0))->result_array();
                $amountd = $amount[$i];

                foreach($product_lotes as $lote)
                {
                    log_message('error',$products[$i].' '.$lote['product_lote_id'].' '.$lote['amount']); 
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
                            'origin_id' => $this->input->post('origin_id'),
                            'origin_type' => $this->input->post('origin_type'),
                            'patient_id' => $this->input->post('patient_id'),
                            'doctor_id' => $this->input->post('doctor_id'),
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
                            'origin_id' => $this->input->post('origin_id'),
                            'origin_type' => $this->input->post('origin_type'),
                            'patient_id' => $this->input->post('patient_id'),
                            'doctor_id' => $this->input->post('doctor_id'), 
                            'status_mov' => 2
                        );
                        
                        $this->db->insert('product_move',$data);
                        
                        $this->db->where('product_lote_id',$lote['product_lote_id']);
                        $this->db->update('product_lote',array('amount'=>0));

                    }
                }
            }
        }
    }
    
    
    function delete_product_extra($id)
    {
        
             $data = array(
                'status_mov' => 0
            );
            
            $this->db->where('product_move_id',$id);
            $this->db->update('product_move',$data);
    }
    
    
    function create_cot()
    {
        
            $cats           =   $this->input->post('cat_id');
            $products       =   $this->input->post('product_id');
            $unity          =   $this->input->post('unity');
            $amount         =   $this->input->post('amount');
            $subtotal       =   $this->input->post('subtotal');
            $discounts       =   $this->input->post('discount');
            $total1          =   $this->input->post('total');
            $total      = 0;
            $sales_order_entries =   array();
            for($i = 0; $i < sizeof($products); $i++) 
            {
                if($products[$i] != "")
                {
                    
                    $new_order_entry    =   array(
                        'cat_id' => $cats[$i],
                        'product_id' => $products[$i],
                        'amount' => $amount[$i],
                        'unity' => $unity[$i],
                        'subtotal' => $subtotal[$i],
                        'discount' => $discounts[$i],
                        'total' => $total1[$i],
                    );
                    $total += $total1[$i];

                    array_push($sales_order_entries , $new_order_entry);

                }
            }

            $fecha_actual = date("d-m-Y");
            $expiration_date = date("d-m-Y",strtotime($fecha_actual."+ 7 days")); 
            $data = array(
                'date' => $fecha_actual,
                'expiration_date' => $expiration_date,
                'client_id' => $this->input->post('client_id'),
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
                'iva' =>0,
                'amount' => 0,
                'regime' => $this->input->post('regime'),
                'institution_id' => $this->input->post('institution_id'),
                'type_invoice' => $this->input->post('type_invoice'),
                'type' => $this->input->post('type'),
                'method' => $this->input->post('method'),
                'nomenclature_id' => $nomenclature_id,
                'type_transfer' => $this->input->post('type_transfer'),
                'days' => $this->input->post('days'),
                'details' => $this->input->post('notes'),
                'user_id' => $this->session->userdata('login_user_id'),
                'user_type' => $this->session->userdata('login_type'),
                'original_id' => $this->input->post('original_id'),
                'commission' => $this->input->post('commission'),
                'products' => serialize($sales_order_entries),
                'status' => 0,
                'box_id' =>  0
            );

            $this->db->insert('sale', $data);
            return $sale_id = $this->db->insert_id();
            
    }
    
    function get_product_press($product_id)
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

        return $options;
        
    }
    
        
    function clean_inventorys()
    {
        
        $products = $this->db->get_where('product',array('status'=>0,'category_id'=>20))->result_array();
        
        foreach($products as $pd)
        {
            $this->db->where('product_id',$pd['product_id']);
            $this->db->delete('product');
            
            
            $this->db->where('product_id',$pd['product_id']);
            $this->db->delete('inventory_product');
            
        }
        
        
    }
    
}