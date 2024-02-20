<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdf_model extends CI_Model 
{
    function __construct() 
    {
      parent::__construct();
    }
    
    public function pdf($name,$view, $data)
    {
            $html = $this->load->view('backend/pdf/'.$view,$data,TRUE); 
            $this->load->library('M_pdf');
            $mpdf = new mPDF('c', 'letter'); 
            $mpdf->SetTitle($name);
            $mpdf->packTableData = true;
            $mpdf->SetCompression(0);
            $mpdf->WriteHTML($html,0);
            $mpdf->Output($pdfFilePath, "I");  
            
    }

    
}