<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Print_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
    
    //Cargar la vista para imprimir la receta.
    function imprimir($view, $data = '')
    {
        $this->load->view('backend/print/'.$view, $data);
    }
       
    
}