<?php 
    if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Drive extends CI_Controller 
{
   var $acces_key;
   var $host_url;
    function __construct() 
    {
        parent::__construct();
        $this->acces_key ='medicaby.a0AfH6SMCWNFfAedG7UUoOEr19o';
        $this->host_url ='https://medicaby.com/rest/';
        $this->load->library('session');
        $this->load->library('user_agent');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
       
    }

    public function index() 
    {
        
        redirect(base_url(), 'refresh');
    }


    function getFolder()
    {

        $have_folder = $this->db->get_where('settings',array('type'=>'folderId'))->row()->description;
        if($have_folder != "")
        {
            return $have_folder;
        }else
        {
            return  base64_encode( base_url());

        }
    }


    function checkFolder()
    {
       
        $have_folder = $this->db->get_where('settings',array('type'=>'folder'))->row()->description;

        if ($have_folder != '') 
        {
           echo $this->host_url;

        }else
        {
            
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->host_url.'createFolder',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS =>'folderName='.$this->getFolder().'&access_key='.$this->acces_key,
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
           
            if ($response != '') {
                $data['description'] = $this->getFolder();
                $this->db->where('type', 'folder');
                $this->db->update('settings', $data);

                $data2['description'] =$response;
                $this->db->where('type', 'folderId');
                $this->db->update('settings', $data2);
            }



                $this->session->set_flashdata('flash_message' , "¡Listo! Ya puedes guardar los archivos de tus pacientes");
                $refer =  $this->agent->referrer();
                redirect($refer, 'refresh');
        }
    }


  

    function createPatientFolder($patient_id)
    {
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->host_url.'createPatientFolder',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS =>'folderName='.$this->getFolder().'&patientId='.$patient_id.'&access_key='.$this->acces_key,
            ));
            
            $response = curl_exec($curl);
            log_message('error', $patient_id);
            curl_close($curl); 
           
            if($response != '')
            {

                $data['folder'] = 1;
                $data['folderId'] = $response;
                $this->db->where('patient_id',$patient_id);
                $this->db->update('patient',$data);

            }
            
    }

    function createSinglePatientFolder($parentId)
    {

            $folderName=$this->input->post('name');
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->host_url.'createSinglePatientFolder',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS =>'parentId='.$parentId.'&folderName='.$folderName.'&access_key='.$this->acces_key,
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl); 

            $this->cache->delete('getDoctor_'.$parentId.'_'.$this->session->userdata('login_type').'_'.$this->session->userdata('login_user_id'));
            
    }
    
    function createFile()
    {

        $result = 0;
        $file_tmp  = $_FILES["file"]["tmp_name"];
        $file_type = $_FILES["file"]["type"];
        $file_name = basename($_FILES["file"]["name"]);
        if(@move_uploaded_file($file_tmp, 'public/uploads/patient_files/' .$file_name)){
            $result = 1;
        }
      
        $patient_id = $this->input->post('patient_id');
        $folderId = $this->input->post('folderId');

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host_url.'createFile',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS =>'patientId='.$patient_id.'&url='.$this->getFolder().'&folderName='.$folderId.'&fileName='.$file_name.'&fileType='.$file_type.'&access_key='.$this->acces_key,
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        if($response != '')
        {

            unlink('./public/uploads/patient_files/'.$data['files'][0]['name']);

            $insert_data['patient_id']      = $_GET['patient_id']; 
            $insert_data['name']            = $response;
            $insert_data['date']            = $this->crud_model->formatDate();
            $this->db->insert('patient_file', $insert_data);
        

        }


            $this->log_model->file_uploaded($_GET['patient_id']);
            
    
            sleep(1);
            echo '<script language="javascript" type="text/javascript">window.top.window.stopUpload('. $result.');</script>  ';
           
            $this->cache->delete('getDoctor_'.$folderId.'_'.$this->session->userdata('login_type').'_'.$this->session->userdata('login_user_id'));
        
    }


    function deleteFile($fileId, $parent_id, $patient_id)
    {

        if ($parent_id != 0) {
        
            $parentId = $parent_id;
        }else
        {
            $parentId = $this->db->get_where('patient', array('patient_id'=>$patient_id))->row()->folderId;
        }


           
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->host_url.'deleteFile',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS =>'fileId='.$fileId.'&access_key='.$this->acces_key,
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);

            if($response == 'success')
            {
                $this->db->where('name',$fileId);
                $this->db->delete('patient_file');
            }
     
            $this->cache->delete('getDoctor_'.$parentId.'_'.$this->session->userdata('login_type').'_'.$this->session->userdata('login_user_id'));
    }


  

    function getPatientFile($patient_id)
    {
        $var = array();
      

        if ($this->input->post('folderId')!= 0) {
        
            $folderId = $this->input->post('folderId');
        }else
        {
            $folderId = $this->db->get_where('patient', array('patient_id'=>$patient_id))->row()->folderId;
        }

        $getFromCache = $this->cache->get('getDoctor_'.$folderId.'_'.$this->session->userdata('login_type').'_'.$this->session->userdata('login_user_id'));


        if($getFromCache)
        {

            $var = $getFromCache;
            
        }else
        {

           
            $curl = curl_init();
                
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->host_url.'getFoldersByPatient',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS =>'parentId='.$folderId.'&access_key='.$this->acces_key,
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);

            $var =$response;

            $this->cache->save('getDoctor_'.$folderId.'_'.$this->session->userdata('login_type').'_'.$this->session->userdata('login_user_id'), $var,2629750);


        }


      
        $html_table = '<div class="col-sm-6" id="folder">
                            <div class="form-group m-b-15">
                                <a style="background:#fead55; text-decoration:none; color:#fff" class="labelx" for="apply" href="javascript:void(0)" onclick="showAjaxModal('."'".base_url().'modal/popup/modal_file/'.$folderId.'/'.$patient_id.''."'"."".')" >Subir archivo</a>
                            </div>
                        </div>
    
        <div class="col-sm-6" id="folder">
                            <div class="form-group m-b-15">
                                <a style="background:rgb(160, 26, 122); text-decoration:none; color:#fff" class="labelx" for="apply" href="javascript:void(0)" onclick="showAjaxModal('."'".base_url().'modal/popup/modal_folder/'.$folderId.''."'"."".')" >Crear carpeta</a>
                            </div>
                        </div>';

        if ($var == 'nf') 
        {
            $html_table = '
            <div class="col-sm-6" id="folder">
                            <div class="form-group m-b-15">
                                <a style="background:#fead55; text-decoration:none; color:#fff" class="labelx" for="apply" href="javascript:void(0)" onclick="showAjaxModal('."'".base_url().'modal/popup/modal_file/'.$folderId.'/'.$patient_id.''."'"."".')" >Subir archivo</a>
                            </div>
                        </div>
                        
                        <div class="col-sm-6" id="folder">
            <div class="form-group m-b-15">
                <a class="labelx" for="apply" href="javascript:void(0)" onclick="showAjaxModal('."'".base_url().'modal/popup/modal_folder/'.$folderId.''."'"."".')" >Crear carpeta</a>
            </div>
        </div>';
            $html_table .='<div class="col-sm-12"><br><br><br>
            <p class="text-center">Aun no hay archivos</p>
            <center><img src="'.base_url().'public/uploads/no_files.svg" style="max-width:150px;"></center>
        </div>';



        }else
        {
            $data = json_decode($var, true);
            foreach ($data as $row) {
                $html_table .= '
                
                   <div class="col-sm-6">
                    <div class="file-ticket">
                    '.$this->crud_model->isFolder($row['mimeType'], $row['id'], $row['name']).'
                       <a href="javascript:void(0);" style="text-decoration:none;color:#556180" '.$this->crud_model->checkClick($row['mimeType'], $row['id'], $row['name'], 0).'>
                           <div class="st-body">
                               <div class="avatar">
                                <img src="'.$this->crud_model->getMimeType($row['mimeType'], $row['thumbnailLink'], $row['iconLink']).'" style="max-width:30px;">
                               </div>
                               <div class="ticket-content">
                                   <div class="ticket-description">
                                       <div class="os-progress-bar primary">
                                           <div class="bar-labels">
                                               <div class="bar-label-left">
                                                   <span class="bigger">'.$row['name'].'</span>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </a>
                   </div>
                   </div>
             
              ';
            }
        }
        echo $html_table;


    }


    function getPatientOnlyFile($patient_id)
    {
        $var = array();
      

        if ($this->input->post('folderId')!= 0) {
        
            $folderId = $this->input->post('folderId');
        }else
        {
            $folderId = $this->db->get_where('patient', array('patient_id'=>$patient_id))->row()->folderId;
        }

        $getFromCache = $this->cache->get('getDoctor_'.$folderId.'_'.$this->session->userdata('login_type').'_'.$this->session->userdata('login_user_id'));


        if($getFromCache)
        {

            $var = $getFromCache;
            
        }else
        {

           
            $curl = curl_init();
                
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->host_url.'getFoldersByPatient',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS =>'parentId='.$folderId.'&access_key='.$this->acces_key,
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);

            $var =$response;

            $this->cache->save('getDoctor_'.$folderId.'_'.$this->session->userdata('login_type').'_'.$this->session->userdata('login_user_id'), $var,2629750);


        }


      
        $html_table = '';

        if ($var == 'nf') 
        {
            
            $html_table .='<div class="col-sm-12"><br><br><br>
            <p class="text-center">Aun no hay archivos</p>
            <center><img src="'.base_url().'public/uploads/no_files.svg" style="max-width:150px;"></center>
        </div>';



        }else
        {
            $data = json_decode($var, true);
            foreach ($data as $row) {
                $html_table .= '
                
                   <div class="col-sm-6">
                    <div class="file-ticket">
                    '.$this->crud_model->isFolder($row['mimeType'], $row['id'], $row['name']).'
                       <a href="javascript:void(0);" style="text-decoration:none;color:#556180" '.$this->crud_model->checkClick($row['mimeType'], $row['id'], $row['name'], 0).'>
                           <div class="st-body">
                               <div class="avatar">
                                <img src="'.$this->crud_model->getMimeType($row['mimeType'], $row['thumbnailLink'], $row['iconLink']).'" style="max-width:30px;">
                               </div>
                               <div class="ticket-content">
                                   <div class="ticket-description">
                                       <div class="os-progress-bar primary">
                                           <div class="bar-labels">
                                               <div class="bar-label-left">
                                                   <span class="bigger">'.$row['name'].'</span>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </a>
                   </div>
                   </div>
             
              ';
            }
        }
        echo $html_table;


    }


    function download($mime,$id,$name){
        $response = $this->requestPermissions($id);
        
        if($response == 'success')
        {
            header("Location: ". $this->get_embed_url($mime,$id));

        }else
        {

            echo  'error';
        }
       
    }


    function get_embed_url($mime, $id)
    {

   
        $curl = curl_init();
            
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host_url.'getUrl',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS =>'mimeType='.$mime.'&fileId='.$id.'&access_key='.$this->acces_key,
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

      return $response;


    }
    
    function downloadFile($id, $mimeType)
    {
        $response = $this->requestPermissions($id);
        
        if ($response == 'success')
         {
            
            if ($mimeType != 0) 
            {
             
                header("Location: ". $this->getDownloadLink($id, $mimeType)); 
            } else 
            {
                
                header("Location: ". $this->getDownloadLink($id, 0)); 
            }
        }else
        {
            echo 'error';
        }
    }

    function requestPermissions($id)
    {

        
        $curl = curl_init();
            
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host_url.'authorizePermissions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS =>'fileId='.$id.'&access_key='.$this->acces_key,
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        return $response;

    }


    public function getDownloadLink($id,$mime)
    {
       
        $curl = curl_init();
            
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host_url.'provideDownload',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS =>'fileId='.$id.'&mimeType='.$mime.'&access_key='.$this->acces_key,
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        return $response;
    }

    function refreshFiles(){
        $role = $this->session->userdata('login_type').'_'.$this->session->userdata('login_user_id');
        $mask = '_'.$role;
        $cache_path = APPPATH.'cache/';
        $cache_path .= $mask;

        echo 'okey';
    }



}