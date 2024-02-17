<?php
    if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    ini_set('max_execution_time', 0);
    ini_set('memory_limit','2048M');

class Install extends CI_Controller
{
    function index()
    {
        $this->load->view('install/index');
    }

  function setup()
  {
        $hostname = $this->input->post('hostname');
        $username = $this->input->post('dbusername');
        $password = $this->input->post('dbpassword');
        $dbname   = $this->input->post('database');
        $db_connection = $this->database_connection($hostname, $username, $password, $dbname);
        if ($db_connection == 'success') 
        {
            $this->load->database();
            $templine = '';
            $lines = file('./uploads/install.sql');
            foreach ($lines as $line) 
            {
                if (substr($line, 0, 2) == '--' || $line == '')
                continue;
                $templine .= $line;
                if (substr(trim($line), -1, 1) == ';') 
                {
                    $this->db->query($templine);
                    $templine = '';
                }
            }
            $htaccess= "<IfModule mod_rewrite.c> 
                RewriteEngine On
                RewriteBase /
                RewriteCond %{REQUEST_URI} ^system.*
                RewriteRule ^(.*)$ /index.php?/$1 [L]
                RewriteCond %{REQUEST_URI} ^application.*
                RewriteRule ^(.*)$ /index.php?/$1 [L]
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteCond %{REQUEST_FILENAME} !-d
                RewriteRule ^(.*)$ index.php?/$1 [L]
            </IfModule> ";
            file_put_contents(".htaccess", $htaccess);
            unlink(APPPATH.'controllers/Install.php');
            redirect(base_url() , 'refresh');
        }else {
            session_start();
            $_SESSION['error'] = '1';
            redirect(base_url(),'refresh');
        }
    }

    function database_connection($hostname, $username, $password, $dbname) 
    {
        $link = mysqli_connect($hostname, $username, $password, $dbname);
        if (!$link) 
        {
            mysqli_close($link);
            return 'failed';
        }
        $db_selected = mysqli_select_db($link, $dbname);
        if (!$db_selected) {
        mysqli_close($link);
            return "db_not_exist";
        }
        mysqli_close($link);
        return 'success';
    }

    
}